<template>
  <div class="container">
    <div class="flex-w flex-sb-m p-b-52">
      <div class="flex-w flex-l-m filter-tope-group m-tb-10">
        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" @click="filterProducts('*')">Tous</button>
        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" @click="filterProducts('.hommes')">Hommes</button>
        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" @click="filterProducts('.femmes')">Femmes</button>
        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" @click="filterProducts('.chaussures')">Chaussures</button>
        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" @click="filterProducts('.sacs')">Sacs</button>
        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" @click="filterProducts('.montres')">Montres</button>

        <div class="flex-w flex-c-m m-tb-10">
          <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter" @click="toggleFilterPanel">
            <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
            <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
            Filtre
          </div>
        </div>

        <div :class="['panel-filter', 'w-full', 'p-t-10', { 'show-filter': showFilterPanel }]">
          <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
            <div class="filter-col1 p-r-15 p-b-27">
              <div class="mtext-102 cl2 p-b-15">Trier Par</div>
              <ul>
                <li class="p-b-6"><a href="#" class="filter-link stext-106 trans-04" @click.prevent="sortProducts('default')">Tous les produits</a></li>
                <li class="p-b-6"><a href="#" class="filter-link stext-106 trans-04" @click.prevent="sortProducts('popularity')">Popularité</a></li>
                <li class="p-b-6"><a href="#" class="filter-link stext-106 trans-04" @click.prevent="sortProducts('new')">Nouveauté</a></li>
                <li class="p-b-6"><a href="#" class="filter-link stext-106 trans-04" @click.prevent="sortProducts('price-asc')">Prix : Croissant</a></li>
                <li class="p-b-6"><a href="#" class="filter-link stext-106 trans-04" @click.prevent="sortProducts('price-desc')">Prix : Décroissant</a></li>
              </ul>
            </div>
            <div class="filter-col2 p-r-15 p-b-27">
              <div class="mtext-102 cl2 p-b-15">Prix</div>
              <ul>
                <li class="p-b-6"><a href="#" class="filter-link stext-106 trans-04 filter-link-active" @click.prevent="filterProducts('*')">Tous</a></li>
                <li class="p-b-6"><a href="#" class="filter-link stext-106 trans-04" @click.prevent="filterProducts('.price-0-50')">$0.00 - $50.00</a></li>
                <li class="p-b-6"><a href="#" class="filter-link stext-106 trans-04" @click.prevent="filterProducts('.price-50-100')">$50.00 - $100.00</a></li>
                <li class="p-b-6"><a href="#" class="filter-link stext-106 trans-04" @click.prevent="filterProducts('.price-100-150')">$100.00 - $150.00</a></li>
                <li class="p-b-6"><a href="#" class="filter-link stext-106 trans-04" @click.prevent="filterProducts('.price-150-200')">$150.00 - $200.00</a></li>
                <li class="p-b-6"><a href="#" class="filter-link stext-106 trans-04" @click.prevent="filterProducts('.price-200-plus')">$200.00+</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div ref="productGrid" class="row isotope-grid">
      <div v-for="product in sortedProducts" :key="product.id" :class="`col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item ${product.type} ${getPriceClass(product.price)}`">
        <div class="block2">
          <div class="block2-pic hov-img0">
            <img class="img-product" :src="product.image_name" alt="IMG-PRODUCT">
            <a href="#" @click="openModal(product)" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">Voir</a>
          </div>
          <div class="block2-txt flex-w flex-t p-t-14">
            <div class="block2-txt-child1 flex-col-l ">
              <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">{{ product.name }}</a>
              <span class="stext-105 cl3">{{ product.price }} €</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="showModal" class="modal wrap-modal1 js-modal1 p-t-60 p-b-20 show-modal1">
      <div class="container">
        <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
          <span class="close" @click="closeModal">&times;</span>
          <div class="row">
            <div class="col-md-6 col-lg-7 p-b-30">
              <div class="p-l-25 p-r-30 p-lr-0-lg">
                <div class="wrap-slick3 flex-sb flex-w">
                  <div class="wrap-slick3-dots"></div>
                  <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>
                  <div class="slick3 gallery-lb">
                    <div class="item-slick3">
                      <div class="wrap-pic-w pos-relative">
                        <img class="img-product-modal" :src="selectedProduct.image_name" alt="IMG-PRODUCT">
                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" :href="selectedProduct.image_name">
                          <i class="fa fa-expand"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-5 p-b-30">
              <div class="p-r-50 p-t-5 p-lr-0-lg">
                <h4 class="mtext-105 cl2 js-name-detail p-b-14">{{ selectedProduct.name }}</h4>
                <span class="mtext-106 cl2">{{ selectedProduct.price }} €</span>
                <p class="stext-102 cl3 p-t-23">{{ selectedProduct.description }}</p>
                <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                  <a href="#" @click="shareOnFacebook" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100 share-button-facebook" data-tooltip="Facebook">
                    <i class="fa fa-facebook"></i>
                  </a>
                  <a href="#" @click="shareOnTwitter(selectedProduct)" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100 share-button-twitter" data-tooltip="Twitter">
                    <i class="fa fa-twitter"></i>
                  </a>
                  <a href="#" @click="shareOnGmail(selectedProduct)" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100 share-button-google" data-tooltip="Google Plus">
                    <i class="fa fa-google-plus"></i>
                  </a>
                </div>
                <div class="flex-w flex-r-m p-b-10">
                  <template v-if="!isAuthenticated">
                    <div class="alert alert-danger alert-danger-no-cart" role="alert">Vous devez être connecté pour ajouter un article à votre panier !</div>
                  </template>
                  <template v-else>
                    <div class="size-204 flex-w flex-m respon6-next">
                      <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" @click="decreaseQuantity">
                          <i class="fs-16 zmdi zmdi-minus"></i>
                        </div>
                        <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" v-model="quantity" min="1">
                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" @click="increaseQuantity">
                          <i class="fs-16 zmdi zmdi-plus"></i>
                        </div>
                      </div>
                      <div v-if="alertMessage!=''" :class="['alert', alertType]" role="alert">{{ alertMessage }}</div>
                      <button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail btn-cart" @click="() => addToCart(selectedProduct.id,selectedProduct.price)">Ajouter au panier</button>
                    </div>
                  </template>
                </div>
              </div>
            </div>
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
      type: Array,
      required: true
    },
    isAuthenticated: {
      type: Object,
      required: true
    },
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
      sortOption: 'default', // Ajout de cette propriété
    };
  },
  computed: {
    sortedProducts() {
      console.log("In sorted product computed"); // Ajout d'un log pour le débogage
      let sorted = [...this.products.data];
      console.log(sorted); // Ajout d'un log pour le débogage
      switch (this.sortOption) {
        case 'popularity':
          console.log("Popularity");
          sorted.sort((a, b) => b.popularity - a.popularity);
          console.log(sorted);
          break;
        case 'new':
          console.log("New");
          sorted.sort((a, b) => new Date(b.date) - new Date(a.date));
          console.log(sorted);
          break;
        case 'price-asc':
          console.log("Price-asc");
          sorted.sort((a, b) => a.price - b.price);
          console.log(sorted);
          break;
        case 'price-desc':
          console.log("Price-desc");
          sorted.sort((a, b) => b.price - a.price);
          console.log(sorted);
          break;
        default:
          break;
      }
      return sorted;
    }
  },
  methods: {
    filterProducts(filter) {
      this.isotope.arrange({ filter: filter });
    },
    getPriceClass(price) {
      if (price >= 0 && price < 50) return 'price-0-50';
      if (price >= 50 && price < 100) return 'price-50-100';
      if (price >= 100 && price < 150) return 'price-100-150';
      if (price >= 150 && price < 200) return 'price-150-200';
      if (price >= 200) return 'price-200-plus';
      return '';
    },
    sortProducts(option) {
      console.log("Sorting products by:", option); // Ajout d'un log pour le débogage
      this.sortOption = option;
    },
    openModal(product) {
      this.selectedProduct = product;
      this.showModal = true;
      this.alertMessage = "";
      this.alertType = "";
      this.quantity = 1;
    },
    closeModal() {
      this.showModal = false;
    },
    increaseQuantity() {
      this.quantity++;
    },
    decreaseQuantity() {
      if (this.quantity > 1) {
        this.quantity--;
      }
    },
    toggleFilterPanel() {
      this.showFilterPanel = !this.showFilterPanel;
    },
    ...mapActions({
      addToCartAction: 'addToCart'
    }),
    addToCart(productId, productPrice) {
      this.addToCartAction({
        product_id: productId,
        quantity: this.quantity || 1,
        price: productPrice * (this.quantity || 1)
      })
      .then(response => {
        if (response.status === 200) {
          this.alertMessage = response.data.message;
          this.alertType = 'alert-success';
          this.$store.dispatch('fetchCartCount');
        } else {
          this.alertMessage = 'Une erreur est survenue.';
          this.alertType = 'alert-danger';
        }
      })
      .catch(error => {
        console.error("Erreur lors de l'ajout au panier:", error);
        this.alertMessage = 'Une erreur est survenue.';
        this.alertType = 'alert-danger';
      });
    },
    shareOnGmail(product) {
      const subject = encodeURIComponent(`Découvrez ${product.name}`);
      const body = encodeURIComponent(`Je voulais partager cet article avec vous : ${window.location.href}`);
      const mailtoLink = `https://mail.google.com/mail/?view=cm&fs=1&to=&su=${subject}&body=${body}`;
      window.open(mailtoLink, '_blank');
    },
    shareOnFacebook() {
      const url = encodeURIComponent(window.location.href);
      const facebookShareLink = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
      window.open(facebookShareLink, '_blank');
    },
    shareOnTwitter(product) {
      const url = encodeURIComponent(window.location.href);
      const text = encodeURIComponent(`Découvrez ce produit : ${product.name} !`);
      const twitterShareLink = `https://twitter.com/intent/tweet?url=${url}&text=${text}`;
      window.open(twitterShareLink, '_blank', 'width=600,height=400');
    }
  },
  async mounted() {
    this.$nextTick(() => {
      this.isotope = new Isotope(this.$refs.productGrid, {
        itemSelector: ".isotope-item",
        layoutMode: "fitRows",
      });
    });
  },
};
</script>

<style scoped>
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.alert {
  margin-left: -15%;
}

.close {
  position: absolute;
  top: 10px;
  right: 20px;
  cursor: pointer;
  font-size: 20px;
}

.isotope-grid {
  position: relative;
  height: inherit !important;
}

.isotope-item {
  left: inherit !important;
  top: inherit !important;
  position: inherit !important;
}

.alert-danger-no-cart {
  margin: auto;
  text-align: center;
  margin-top: 15px;
}

.alert {
  margin-left: -30px;
}

.btn-cart {
  margin-left: -15px;
}

.share-button-facebook {
  background-color: #1877F2;
  color: white;
  border: none;
  padding: 10px 15px;
  border-radius: 5px;
  cursor: pointer;
  margin-left: 12px;
}

.share-button-google {
  background-color: #D93025;
  color: white;
  border: none;
  padding: 10px 15px;
  border-radius: 5px;
  cursor: pointer;
}

.share-button-twitter {
  display: flex;
  align-items: center;
  background-color: #1DA1F2;
  color: white;
  border: none;
  padding: 10px 15px;
  font-size: 14px;
  font-weight: bold;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.3s ease-in-out;
  text-decoration: none;
}

.img-product {
  height: 350px;
}

.item-slick3 img {
  margin-right: 45px;
}

.modal .container {
  width: 60%;
}

.panel-filter {
  display: none;
}

.show-filter {
  display: block;
}

/* Ajout de marges pour éviter la superposition avec le footer */
.row.isotope-grid {
  margin-bottom: 50px; /* Ajustez cette valeur selon vos besoins */
}

/* Ajout de styles pour le footer */
footer {
  margin-top: 20px; /* Ajustez cette valeur selon vos besoins */
  padding-top: 20px;
  background-color: #f8f9fa;
  border-top: 1px solid #e9ecef;
}
</style>
