<template>
  <div class="container">

    <div class="filter-bar">
      <div class="filter-categories">
        <button v-for="cat in categories" :key="cat.value" @click="filterByCategory(cat.value)"
          :class="['cat-btn', { active: activeCategory === cat.value }]">
          {{ cat.label }}
        </button>
      </div>

      <button class="advanced-btn" @click="toggleFilterPanel">
        <i class="zmdi zmdi-filter-list"></i>
        Filtres
        <i :class="['zmdi', showFilterPanel ? 'zmdi-chevron-up' : 'zmdi-chevron-down']"></i>
      </button>
    </div>

    <transition name="slide-down">
      <div v-if="showFilterPanel" class="filter-panel">
        <div class="filter-section">
          <p class="filter-section-title">📊 Trier par</p>
          <div class="filter-options">
            <button v-for="sort in sortOptions" :key="sort.value" @click="sortProducts(sort.value)"
              :class="['filter-option-btn', { active: sortOption === sort.value }]">
              {{ sort.label }}
            </button>
          </div>
        </div>

        <div class="filter-divider"></div>

        <div class="filter-section">
          <p class="filter-section-title">💰 Prix</p>
          <div class="filter-options">
            <button v-for="price in priceRanges" :key="price.value" @click="filterByPrice(price.value)"
              :class="['filter-option-btn', { active: activePrice === price.value }]">
              {{ price.label }}
            </button>
          </div>
        </div>
      </div>
    </transition>

    <div v-if="filteredProducts.length === 0" class="no-products-alert">
      🔍 Aucun produit ne correspond à ces critères de recherche.
    </div>

    <div class="row style-grid">
      <div v-for="product in paginatedProducts" :key="product.id"
        class="col-sm-6 col-md-4 col-lg-3 p-b-35 product-item-container">
        <div class="product-card">
          <div class="product-img-wrapper">
            <img :src="product.image_name" :alt="product.name" class="product-img">
            <div class="product-img-overlay">
              <button @click.prevent="openModal(product)" class="product-view-btn">
                👁️ Voir le produit
              </button>
            </div>
          </div>

          <div class="product-info">
            <h3 class="product-name">{{ product.name }}</h3>
            <div class="product-price-row">
              <span v-if="product.sale_price > 0" class="product-old-price">
                {{ parseFloat(product.price).toFixed(2) }} €
              </span>
              <span class="product-price">
                {{ product.sale_price > 0 ? parseFloat(product.sale_price).toFixed(2) :
                  parseFloat(product.price).toFixed(2) }} €
              </span>
              <span v-if="product.sale_price > 0" class="product-badge">Promo</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="!disablePagination && totalPages > 1" class="vue-pagination-container">
      <nav class="custom-blade-pagination">
        <ul style="display:flex; gap:6px; list-style:none; padding:0; margin:0; flex-wrap: nowrap;">
          <li>
            <button @click="changePage(currentPage - 1)" class="page-btn-link" :disabled="currentPage === 1"
              :class="{ 'disabled-btn': currentPage === 1 }">
              ‹
            </button>
          </li>

          <li v-for="page in totalPages" :key="page">
            <button @click="changePage(page)" class="page-btn-link" :class="{ 'active-page': page === currentPage }">
              {{ page }}
            </button>
          </li>

          <li>
            <button @click="changePage(currentPage + 1)" class="page-btn-link" :disabled="currentPage === totalPages"
              :class="{ 'disabled-btn': currentPage === totalPages }">
              ›
            </button>
          </li>
        </ul>
      </nav>
    </div>

    <div v-if="showModal" class="product-modal" @click.self="closeModal">
      <div class="product-modal-content">
        <button class="modal-close-btn" @click="closeModal">&times;</button>
        <div class="modal-body">
          <div class="modal-img-side">
            <img :src="selectedProduct.image_name" :alt="selectedProduct.name" class="modal-img">
          </div>
          <div class="modal-info-side">
            <span class="modal-tag">{{ selectedProduct.type }}</span>
            <h2 class="modal-title">{{ selectedProduct.name }}</h2>
            <div class="modal-price-row">
              <span v-if="selectedProduct.sale_price > 0" class="modal-old-price">{{
                parseFloat(selectedProduct.price).toFixed(2) }} €</span>
              <span class="modal-price">{{ selectedProduct.sale_price > 0 ?
                parseFloat(selectedProduct.sale_price).toFixed(2) : parseFloat(selectedProduct.price).toFixed(2) }}
                €</span>
            </div>
            <p class="modal-description">{{ selectedProduct.description }}</p>
            <div class="modal-cart-section">
              <template v-if="!isAuthenticated">
                <div class="alert alert-danger" style="border-radius:8px; font-size:14px;">🔒 Connectez-vous pour
                  ajouter au panier</div>
              </template>
              <template v-else>
                <div class="quantity-control">
                  <button @click="decreaseQuantity" class="qty-btn">−</button>
                  <input type="number" v-model="quantity" min="1" class="qty-input">
                  <button @click="increaseQuantity" class="qty-btn">+</button>
                </div>
                <div v-if="alertMessage" :class="['alert', alertType]" style="border-radius:8px; font-size:14px;">
                  {{ alertMessage }}
                </div>
                <button class="add-to-cart-btn" @click="addToCart(selectedProduct.id, selectedProduct.price)">🛒 Ajouter
                  au panier</button>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
  props: {
    products: { type: Array, required: true },
    isAuthenticated: { type: Boolean, default: false },
    disablePagination: { type: Boolean, default: false },
    initialSearch: { type: String, default: '' }
  },

  data() {
    return {
      showModal: false,
      selectedProduct: {},
      alertMessage: '',
      alertType: '',
      quantity: 1,
      showFilterPanel: false,
      sortOption: 'default',
      activeCategory: '*',
      activePrice: '*',
      currentPage: 1,
      itemsPerPage: 8, // Modifie ici pour afficher plus ou moins de produits par page
      categories: [
        { label: 'Tous', value: '*' },
        { label: 'Hommes', value: 'hommes' },
        { label: 'Femmes', value: 'femmes' },
        { label: 'Chaussures', value: 'chaussures' },
        { label: 'Sacs', value: 'sacs' },
        { label: 'Montres', value: 'montres' },
      ],
      sortOptions: [
        { label: 'Par défaut', value: 'default' },
        { label: 'Prix croissant ↑', value: 'price-asc' },
        { label: 'Prix décroissant ↓', value: 'price-desc' },
      ],
      priceRanges: [
        { label: 'Tous les prix', value: '*' },
        { label: '0 € - 50 €', value: '0-50' },
        { label: '50 € - 100 €', value: '50-100' },
        { label: '100 € - 200 €', value: '100-200' },
        { label: '200 € - 500 €', value: '200-500' },
        { label: '+ 500 €', value: '500-plus' },
      ],
      searchQuery: this.initialSearch || '', // Initialisé avec la recherche globale
    };
  },

  computed: {
    // 1. Filtrage et Tri global et immédiat
    filteredProducts() {
      let result = [...this.products];

      // 1. Filtrage textuel (Barre de recherche globale ex: ?search=montre)
      // On cherche une correspondance dans le nom ou le type/catégorie du produit
      if (this.searchQuery) {
        const query = this.searchQuery.trim().toLowerCase();
        result = result.filter(p => {
          const nameMatch = p.name ? p.name.toLowerCase().includes(query) : false;
          const typeMatch = p.type ? p.type.toLowerCase().includes(query) : false;
          return nameMatch || typeMatch;
        });
      }

      // 2. Filtrage par bouton de catégorie active
      if (this.activeCategory !== '*') {
        result = result.filter(p => p.type && p.type.toLowerCase() === this.activeCategory.toLowerCase());
      }

      // 3. Filtrage par tranches de prix (en gérant les prix de base et les prix en promotion)
      if (this.activePrice !== '*') {
        result = result.filter(p => {
          const currentPrice = parseFloat(p.sale_price) > 0 ? parseFloat(p.sale_price) : parseFloat(p.price);

          if (this.activePrice === '0-50') return currentPrice >= 0 && currentPrice < 50;
          if (this.activePrice === '50-100') return currentPrice >= 50 && currentPrice < 100;
          if (this.activePrice === '100-200') return currentPrice >= 100 && currentPrice < 200;
          if (this.activePrice === '200-500') return currentPrice >= 200 && currentPrice < 500;
          if (this.activePrice === '500-plus') return currentPrice >= 500;
          return true;
        });
      }

      // 4. Tri par prix croissant ou décroissant
      if (this.sortOption === 'price-asc') {
        result.sort((a, b) => {
          const priceA = parseFloat(a.sale_price) > 0 ? parseFloat(a.sale_price) : parseFloat(a.price);
          const priceB = parseFloat(b.sale_price) > 0 ? parseFloat(b.sale_price) : parseFloat(b.price);
          return priceA - priceB;
        });
      } else if (this.sortOption === 'price-desc') {
        result.sort((a, b) => {
          const priceA = parseFloat(a.sale_price) > 0 ? parseFloat(a.sale_price) : parseFloat(a.price);
          const priceB = parseFloat(b.sale_price) > 0 ? parseFloat(b.sale_price) : parseFloat(b.price);
          return priceB - priceA;
        });
      }

      return result;
    },

    // 2. Calcule le nombre total de pages en fonction des filtres actifs
    totalPages() {
      return Math.ceil(this.filteredProducts.length / this.itemsPerPage);
    },

    // 3. Extrait uniquement les produits à afficher sur la page courante
    paginatedProducts() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredProducts.slice(start, end);
    }
  },

  methods: {
    filterByCategory(filter) {
      this.activeCategory = filter;
      this.currentPage = 1; // Reset automatique en page 1
    },
    filterByPrice(filter) {
      this.activePrice = filter;
      this.currentPage = 1; // Reset automatique en page 1
    },
    sortProducts(option) {
      this.sortOption = option;
      this.currentPage = 1;
    },
    changePage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
        // Optionnel : remonte l'écran en haut de la grille produits de façon fluide
        window.scrollTo({ top: 400, behavior: 'smooth' });
      }
    },
    toggleFilterPanel() { this.showFilterPanel = !this.showFilterPanel; },
    openModal(product) { this.selectedProduct = product; this.showModal = true; this.quantity = 1; },
    closeModal() { this.showModal = false; },
    increaseQuantity() { this.quantity++; },
    decreaseQuantity() { if (this.quantity > 1) this.quantity--; },
    ...mapActions({ addToCartAction: 'addToCart' }),
    addToCart(productId, productPrice) {
      this.addToCartAction({
        product_id: productId,
        quantity: this.quantity || 1,
        price: productPrice * (this.quantity || 1)
      }).then(response => {
        if (response.status === 200) {
          this.alertMessage = response.data.message;
          this.alertType = 'alert-success';
          this.$store.dispatch('fetchCartCount');
        } else {
          this.alertMessage = 'Une erreur est survenue.';
          this.alertType = 'alert-danger';
        }
      }).catch(() => {
        this.alertMessage = 'Une erreur est survenue.';
        this.alertType = 'alert-danger';
      });
    },
  },

  created() {
    if (this.initialSearch) {
      const searchLower = this.initialSearch.trim().toLowerCase();

      // Liste de tes catégories disponibles (sans l'étoile)
      const validCategories = ['hommes', 'femmes', 'chaussures', 'sacs', 'montres'];

      // Si le mot recherché correspond exactement ou contient une catégorie
      const foundCategory = validCategories.find(cat => searchLower.includes(cat) || cat.includes(searchLower));

      if (foundCategory) {
        this.activeCategory = foundCategory;
      } else {
        // Optionnel : Si la recherche ne correspond pas à un nom de catégorie (ex: "Rolex"), 
        // tu peux stocker ce mot dans une variable "searchQuery" dans data() pour filtrer par texte.
        this.activeCategory = '*';
      }
    }
  }
};
</script>

<style scoped>
/* Code CSS existant inchangé ... */
.filter-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
  margin-bottom: 20px;
}

.filter-categories {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.cat-btn {
  padding: 8px 20px;
  border-radius: 25px;
  border: 2px solid #ddd;
  background: white;
  color: #555;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}

.cat-btn:hover,
.cat-btn.active {
  background: #1a1a2e;
  border-color: #1a1a2e;
  color: white;
}

.advanced-btn {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 8px 18px;
  border-radius: 25px;
  border: 2px solid #ddd;
  background: white;
  color: #555;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
}

.advanced-btn:hover {
  border-color: #1a1a2e;
  color: #1a1a2e;
}

.filter-panel {
  background: #f8f9fa;
  border-radius: 12px;
  padding: 20px 24px;
  margin-bottom: 24px;
  display: flex;
  gap: 30px;
  flex-wrap: wrap;
}

.filter-option-btn {
  padding: 6px 14px;
  border-radius: 20px;
  border: 2px solid #ddd;
  background: white;
  color: #555;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
}

.filter-option-btn:hover,
.filter-option-btn.active {
  background: #6c63ff;
  border-color: #6c63ff;
  color: white;
}

.filter-divider {
  width: 1px;
  background: #ddd;
  align-self: stretch;
}

.no-products-alert {
  background: white;
  padding: 40px;
  text-align: center;
  border-radius: 12px;
  color: #777;
  font-size: 15px;
  font-weight: 600;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
  margin-bottom: 30px;
}

.style-grid {
  display: flex;
  flex-wrap: wrap;
  margin-bottom: 30px;
}

.product-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
  transition: transform 0.3s, box-shadow 0.3s;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.product-img-wrapper {
  position: relative;
  overflow: hidden;
  height: 280px;
}

.product-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.product-img-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.3s;
}

.product-card:hover .product-img-overlay {
  opacity: 1;
}

.product-view-btn {
  background: white;
  color: #333;
  border: none;
  padding: 10px 20px;
  border-radius: 25px;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
}

.product-info {
  padding: 14px 16px;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.product-name {
  font-size: 14px;
  font-weight: 600;
  color: #333;
  margin-bottom: 8px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.product-price-row {
  display: flex;
  align-items: center;
  gap: 8px;
}

.product-price {
  font-size: 16px;
  font-weight: 700;
  color: #1a1a2e;
}

.product-old-price {
  font-size: 13px;
  color: #aaa;
  text-decoration: line-through;
}

.product-badge {
  background: #e74c3c;
  color: white;
  font-size: 10px;
  font-weight: 700;
  padding: 2px 8px;
  border-radius: 10px;
}

/* CSS DE LA PAGINATION INTÉGRÉE (PROPRE ET SANS BORDURE) */
.vue-pagination-container {
  display: flex;
  justify-content: center;
  padding: 20px 0 40px;
}

.custom-blade-pagination .page-btn-link {
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  min-width: 38px;
  height: 38px;
  padding: 0 12px;
  border-radius: 8px;
  background-color: #f3f4f6;
  color: #4b5563;
  border: none !important;
  text-decoration: none !important;
  font-weight: 700;
  font-size: 14px;
  transition: all 0.15s ease-in-out;
  box-sizing: border-box;
  cursor: pointer;
}

.custom-blade-pagination .page-btn-link.active-page {
  background-color: #1a1a2e !important;
  color: white !important;
  cursor: default;
}

.custom-blade-pagination .page-btn-link:not(.active-page):not(.disabled-btn):hover {
  background-color: #6c63ff !important;
  color: white !important;
}

.custom-blade-pagination .page-btn-link.disabled-btn {
  background-color: #f9fafb !important;
  color: #d1d5db !important;
  opacity: 0.5;
  cursor: not-allowed;
}

/* ===== MODALE PRODUIT ===== */
.product-modal {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.6);
  z-index: 2000;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
}

.product-modal-content {
  background: white;
  border-radius: 16px;
  width: 100%;
  max-width: 850px;
  max-height: 90vh;
  overflow-y: auto;
  position: relative;
}

.modal-close-btn {
  position: absolute;
  top: 15px;
  right: 15px;
  background: #f5f5f5;
  border: none;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  font-size: 20px;
  cursor: pointer;
  z-index: 10;
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-body {
  display: flex;
  flex-wrap: wrap;
}

.modal-img-side {
  flex: 1;
  min-width: 280px;
  max-height: 500px;
  overflow: hidden;
  border-radius: 16px 0 0 16px;
}

.modal-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.modal-info-side {
  flex: 1;
  min-width: 280px;
  padding: 30px;
}

.modal-tag {
  display: inline-block;
  background: #f0f0f0;
  color: #666;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  padding: 4px 12px;
  border-radius: 20px;
  margin-bottom: 12px;
}

.modal-title {
  font-size: 24px;
  font-weight: 800;
  color: #333;
  margin-bottom: 12px;
}

.modal-price-row {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 16px;
}

.modal-price {
  font-size: 24px;
  font-weight: 700;
  color: #333;
}

.modal-old-price {
  font-size: 16px;
  color: #aaa;
  text-decoration: line-through;
}

.modal-description {
  font-size: 14px;
  color: #666;
  line-height: 1.7;
  margin-bottom: 20px;
}

.modal-cart-section {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.quantity-control {
  display: flex;
  align-items: center;
  border: 2px solid #eee;
  border-radius: 10px;
  overflow: hidden;
  width: fit-content;
}

.qty-btn {
  background: #f5f5f5;
  border: none;
  width: 38px;
  height: 38px;
  font-size: 18px;
  cursor: pointer;
}

.qty-input {
  width: 50px;
  text-align: center;
  border: none;
  outline: none;
  font-size: 15px;
  font-weight: 600;
}

.add-to-cart-btn {
  background: #1a1a2e;
  color: white;
  border: none;
  padding: 14px 24px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: 700;
  cursor: pointer;
  width: 100%;
}

.add-to-cart-btn:hover {
  background: #333;
}

/* Transition */
.slide-down-enter-active,
.slide-down-leave-active {
  transition: all 0.3s ease;
}

.slide-down-enter-from,
.slide-down-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>