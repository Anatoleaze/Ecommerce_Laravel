<template>
  <div class="container">

    <!-- Barre de filtres -->
    <div class="filter-bar">
      
      <!-- Catégories -->
      <div class="filter-categories">
        <button
          v-for="cat in categories" :key="cat.value"
          @click="filterByCategory(cat.value)"
          :class="['cat-btn', { active: activeCategory === cat.value }]">
          {{ cat.label }}
        </button>
      </div>

      <!-- Filtres avancés -->
      <button class="advanced-btn" @click="toggleFilterPanel">
        <i class="zmdi zmdi-filter-list"></i>
        Filtres
        <i :class="['zmdi', showFilterPanel ? 'zmdi-chevron-up' : 'zmdi-chevron-down']"></i>
      </button>
    </div>

    <!-- Panel filtres avancés -->
    <transition name="slide-down">
      <div v-if="showFilterPanel" class="filter-panel">
        
        <!-- Trier par -->
        <div class="filter-section">
          <p class="filter-section-title">📊 Trier par</p>
          <div class="filter-options">
            <button
              v-for="sort in sortOptions" :key="sort.value"
              @click="sortProducts(sort.value)"
              :class="['filter-option-btn', { active: sortOption === sort.value }]">
              {{ sort.label }}
            </button>
          </div>
        </div>

        <div class="filter-divider"></div>

        <!-- Prix -->
        <div class="filter-section">
          <p class="filter-section-title">💰 Prix</p>
          <div class="filter-options">
            <button
              v-for="price in priceRanges" :key="price.value"
              @click="filterByPrice(price.value)"
              :class="['filter-option-btn', { active: activePrice === price.value }]">
              {{ price.label }}
            </button>
          </div>
        </div>

      </div>
    </transition>

    <!-- Grille produits -->
    <div ref="productGrid" class="row isotope-grid">
      <div
        v-for="product in sortedProducts" :key="product.id"
        :class="`col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item ${product.type} ${getPriceClass(product.price)}`">
        <div class="product-card">
          
          <!-- Image -->
          <div class="product-img-wrapper">
            <img :src="product.image_name" :alt="product.name" class="product-img">
            <div class="product-img-overlay">
              <button @click.prevent="openModal(product)" class="product-view-btn">
                👁️ Voir le produit
              </button>
            </div>
          </div>

          <!-- Infos -->
          <div class="product-info">
            <h3 class="product-name">{{ product.name }}</h3>
            <div class="product-price-row">
              <span v-if="product.sale_price > 0" class="product-old-price">
                {{ parseFloat(product.price).toFixed(2) }} €
              </span>
              <span class="product-price">
                {{ product.sale_price > 0 ? parseFloat(product.sale_price).toFixed(2) : parseFloat(product.price).toFixed(2) }} €
              </span>
              <span v-if="product.sale_price > 0" class="product-badge">Promo</span>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Modale produit -->
    <div v-if="showModal" class="product-modal" @click.self="closeModal">
      <div class="product-modal-content">
        <button class="modal-close-btn" @click="closeModal">&times;</button>
        <div class="modal-body">

          <!-- Image -->
          <div class="modal-img-side">
            <img :src="selectedProduct.image_name" :alt="selectedProduct.name" class="modal-img">
          </div>

          <!-- Infos -->
          <div class="modal-info-side">
            <span class="modal-tag">{{ selectedProduct.type }}</span>
            <h2 class="modal-title">{{ selectedProduct.name }}</h2>
            <div class="modal-price-row">
              <span v-if="selectedProduct.sale_price > 0" class="modal-old-price">
                {{ parseFloat(selectedProduct.price).toFixed(2) }} €
              </span>
              <span class="modal-price">
                {{ selectedProduct.sale_price > 0 ? parseFloat(selectedProduct.sale_price).toFixed(2) : parseFloat(selectedProduct.price).toFixed(2) }} €
              </span>
            </div>
            <p class="modal-description">{{ selectedProduct.description }}</p>

            <!-- Partage -->
            <div class="modal-share">
              <span style="font-size:13px; color:#aaa;">Partager :</span>
              <button @click.prevent="shareOnFacebook(selectedProduct)" class="share-btn facebook">
                <i class="fa fa-facebook"></i>
              </button>
              <button @click.prevent="shareOnTwitter(selectedProduct)" class="share-btn twitter">
                <i class="fa fa-twitter"></i>
              </button>
            </div>

            <!-- Ajouter au panier -->
            <template v-if="!isAuthenticated">
              <div class="alert alert-danger" style="border-radius:8px; font-size:14px;">
                🔒 Connectez-vous pour ajouter au panier
              </div>
            </template>
            <template v-else>
              <div class="modal-cart-section">
                <div class="quantity-control">
                  <button @click="decreaseQuantity" class="qty-btn">−</button>
                  <input type="number" v-model="quantity" min="1" class="qty-input">
                  <button @click="increaseQuantity" class="qty-btn">+</button>
                </div>
                <div v-if="alertMessage" :class="['alert', alertType]" style="border-radius:8px; font-size:14px; margin:10px 0;">
                  {{ alertMessage }}
                </div>
                <button class="add-to-cart-btn" @click="addToCart(selectedProduct.id, selectedProduct.price)">
                  🛒 Ajouter au panier
                </button>
              </div>
            </template>
          </div>

        </div>
      </div>
    </div>

  </div>
</template>

<script>
import { mapActions } from 'vuex';
import Isotope from 'isotope-layout';

export default {
  props: {
    products: {
      type: [Array, Object],
      required: true
    },
    isAuthenticated: {
      type: [Boolean, Object],
      default: false
    },
    paginated: {
      type: Boolean,
      default: false
    }
  },

  data() {
    return {
      showModal: false,
      selectedProduct: {},
      alertMessage: '',
      alertType: '',
      quantity: 1,
      isotope: null,
      showFilterPanel: false,
      sortOption: 'default',
      activeCategory: '*',
      activePrice: '*',
      currentFilter: '*',
      categories: [
        { label: 'Tous', value: '*' },
        { label: 'Hommes', value: '.hommes' },
        { label: 'Femmes', value: '.femmes' },
        { label: 'Chaussures', value: '.chaussures' },
        { label: 'Sacs', value: '.sacs' },
        { label: 'Montres', value: '.montres' },
      ],
      sortOptions: [
        { label: 'Par défaut', value: 'default' },
        { label: 'Prix croissant ↑', value: 'price-asc' },
        { label: 'Prix décroissant ↓', value: 'price-desc' },
      ],
      priceRanges: [
        { label: 'Tous les prix', value: '*' },
        { label: '0 € - 50 €', value: '.price-0-50' },
        { label: '50 € - 100 €', value: '.price-50-100' },
        { label: '100 € - 200 €', value: '.price-100-200' },
        { label: '200 € - 500 €', value: '.price-200-500' },
        { label: '+ 500 €', value: '.price-500-plus' },
      ],
    };
  },

  computed: {
    sortedProducts() {
      let data = this.paginated ? this.products.data : this.products;
      let sorted = [...data];
      switch (this.sortOption) {
        case 'price-asc':
          sorted.sort((a, b) => a.price - b.price);
          break;
        case 'price-desc':
          sorted.sort((a, b) => b.price - a.price);
          break;
        default:
          break;
      }
      return sorted;
    }
  },

  methods: {
    // Filtre par catégorie — toujours Isotope, jamais de redirection
    filterByCategory(filter) {
    this.activeCategory = filter;
    this.activePrice = '*'; // reset prix
    
    // Gestion propre de la pagination Laravel
    const paginationEl = document.getElementById('laravel-pagination');
    if (paginationEl) {
      paginationEl.style.display = filter === '*' ? 'flex' : 'none';
    }

    this.$nextTick(() => {
      if (this.isotope) {
        this.isotope.arrange({ filter: filter === '*' ? '*' : filter });
      }
    });
  },

    // Filtre par prix — toujours Isotope
    filterByPrice(filter) {
    this.activePrice = filter;
    this.activeCategory = '*'; // reset catégorie
    
    // Gestion propre de la pagination Laravel
    const paginationEl = document.getElementById('laravel-pagination');
    if (paginationEl) {
      paginationEl.style.display = filter === '*' ? 'flex' : 'none';
    }

    this.$nextTick(() => {
      if (this.isotope) {
        this.isotope.arrange({ filter: filter === '*' ? '*' : filter });
      }
    });
  },

    getPriceClass(price) {
      if (price >= 0 && price < 50) return 'price-0-50';
      if (price >= 50 && price < 100) return 'price-50-100';
      if (price >= 100 && price < 200) return 'price-100-200';
      if (price >= 200 && price < 500) return 'price-200-500';
      if (price >= 500) return 'price-500-plus';
      return '';
    },

    sortProducts(option) {
      this.sortOption = option;
      this.$nextTick(() => {
        if (this.isotope) {
          this.isotope.reloadItems();
          this.isotope.arrange();
        }
      });
    },

    toggleFilterPanel() {
      this.showFilterPanel = !this.showFilterPanel;
    },

    openModal(product) {
      this.selectedProduct = product;
      this.showModal = true;
      this.alertMessage = '';
      this.alertType = '';
      this.quantity = 1;
    },

    closeModal() {
      this.showModal = false;
    },

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

    shareOnFacebook(product) {
      const url = encodeURIComponent(window.location.href);
      window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
    },

    shareOnTwitter(product) {
      const url = encodeURIComponent(window.location.href);
      const text = encodeURIComponent(`Découvrez ce produit : ${product.name}`);
      window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
    },
  },

  async mounted() {
    this.$nextTick(() => {
      this.isotope = new Isotope(this.$refs.productGrid, {
        itemSelector: '.isotope-item',
        layoutMode: 'fitRows',
      });
    });
  },
};
</script>

<style scoped>
/* ===== BARRE DE FILTRES ===== */
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

.cat-btn:hover, .cat-btn.active {
  background: #333;
  border-color: #333;
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
  transition: all 0.2s;
}

.advanced-btn:hover {
  border-color: #333;
  color: #333;
}

/* ===== PANEL FILTRES ===== */
.filter-panel {
  background: #f8f9fa;
  border-radius: 12px;
  padding: 20px 24px;
  margin-bottom: 24px;
  display: flex;
  gap: 30px;
  flex-wrap: wrap;
  align-items: flex-start;
}

.filter-section-title {
  font-weight: 700;
  color: #333;
  font-size: 14px;
  margin-bottom: 12px;
}

.filter-options {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
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
  transition: all 0.2s;
}

.filter-option-btn:hover, .filter-option-btn.active {
  background: #6c63ff;
  border-color: #6c63ff;
  color: white;
}

.filter-divider {
  width: 1px;
  background: #ddd;
  align-self: stretch;
}

/* Transition panel */
.slide-down-enter-active, .slide-down-leave-active {
  transition: all 0.3s ease;
}
.slide-down-enter-from, .slide-down-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

/* ===== CARTE PRODUIT ===== */
.product-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 12px rgba(0,0,0,0.07);
  transition: transform 0.3s, box-shadow 0.3s;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.12);
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
  transition: transform 0.4s;
}

.product-card:hover .product-img {
  transform: scale(1.05);
}

.product-img-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.4);
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
  transition: all 0.2s;
}

.product-view-btn:hover {
  background: #333;
  color: white;
}

.product-info {
  padding: 14px 16px;
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
  color: #333;
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
  text-transform: uppercase;
}

/* ===== MODALE PRODUIT ===== */
.product-modal {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.6);
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

.modal-share {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 20px;
}

.share-btn {
  width: 34px;
  height: 34px;
  border-radius: 50%;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 14px;
}

.share-btn.facebook { background: #1877F2; }
.share-btn.twitter { background: #1DA1F2; }

.modal-cart-section {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.quantity-control {
  display: flex;
  align-items: center;
  gap: 0;
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
  transition: background 0.2s;
}

.qty-btn:hover { background: #eee; }

.qty-input {
  width: 50px;
  text-align: center;
  border: none;
  outline: none;
  font-size: 15px;
  font-weight: 600;
}

.add-to-cart-btn {
  background: #333;
  color: white;
  border: none;
  padding: 14px 24px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: 700;
  cursor: pointer;
  transition: background 0.2s;
  width: 100%;
}

.add-to-cart-btn:hover { background: #555; }

/* ===== ISOTOPE ===== */
.isotope-grid {
  position: relative;
  height: inherit !important;
}

.isotope-item {
  left: inherit !important;
  top: inherit !important;
  position: inherit !important;
}

.row.isotope-grid {
  margin-bottom: 50px;
}
</style>