<template>
  <div class="container">

    <div class="flex-w flex-sb-m p-b-52">
      <div class="flex-w flex-l-m filter-tope-group m-tb-10">

        <!-- Filtres pour les produits -->
        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" @click="filterProducts('*')">Tous</button>
        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" @click="filterProducts('.hommes')">Hommes</button>
        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" @click="filterProducts('.femmes')">Femmes</button>
        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" @click="filterProducts('.chaussures')">Chaussures</button>
        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" @click="filterProducts('.sacs')">Sacs</button>
        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" @click="filterProducts('.montres')">Montres</button>


        <div class="flex-w flex-c-m m-tb-10">
          <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
            <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
            <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
            Filter
          </div>

        </div>


        <!-- Filter -->
        <div class="dis-none panel-filter w-full p-t-10">
          <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
            <div class="filter-col1 p-r-15 p-b-27">
              <div class="mtext-102 cl2 p-b-15">
                Sort By
              </div>

              <ul>
                <li class="p-b-6">
                  <a href="#" class="filter-link stext-106 trans-04">
                    Default
                  </a>
                </li>

                <li class="p-b-6">
                  <a href="#" class="filter-link stext-106 trans-04">
                    Popularity
                  </a>
                </li>

                <li class="p-b-6">
                  <a href="#" class="filter-link stext-106 trans-04">
                    Average rating
                  </a>
                </li>

                <li class="p-b-6">
                  <a href="#" class="filter-link stext-106 trans-04 filter-link-active">
                    Newness
                  </a>
                </li>

                <li class="p-b-6">
                  <a href="#" class="filter-link stext-106 trans-04">
                    Price: Low to High
                  </a>
                </li>

                <li class="p-b-6">
                  <a href="#" class="filter-link stext-106 trans-04">
                    Price: High to Low
                  </a>
                </li>
              </ul>
            </div>

            <div class="filter-col2 p-r-15 p-b-27">
              <div class="mtext-102 cl2 p-b-15">
                Price
              </div>

              <ul>
                <li class="p-b-6">
                  <a href="#" class="filter-link stext-106 trans-04 filter-link-active">
                    All
                  </a>
                </li>

                <li class="p-b-6">
                  <a href="#" class="filter-link stext-106 trans-04">
                    $0.00 - $50.00
                  </a>
                </li>

                <li class="p-b-6">
                  <a href="#" class="filter-link stext-106 trans-04">
                    $50.00 - $100.00
                  </a>
                </li>

                <li class="p-b-6">
                  <a href="#" class="filter-link stext-106 trans-04">
                    $100.00 - $150.00
                  </a>
                </li>

                <li class="p-b-6">
                  <a href="#" class="filter-link stext-106 trans-04">
                    $150.00 - $200.00
                  </a>
                </li>

                <li class="p-b-6">
                  <a href="#" class="filter-link stext-106 trans-04">
                    $200.00+
                  </a>
                </li>
              </ul>
            </div>

            <div class="filter-col3 p-r-15 p-b-27">
              <div class="mtext-102 cl2 p-b-15">
                Color
              </div>

              <ul>
                <li class="p-b-6">
                  <span class="fs-15 lh-12 m-r-6" style="color: #222;">
                    <i class="zmdi zmdi-circle"></i>
                  </span>

                  <a href="#" class="filter-link stext-106 trans-04">
                    Black
                  </a>
                </li>

                <li class="p-b-6">
                  <span class="fs-15 lh-12 m-r-6" style="color: #4272d7;">
                    <i class="zmdi zmdi-circle"></i>
                  </span>

                  <a href="#" class="filter-link stext-106 trans-04 filter-link-active">
                    Blue
                  </a>
                </li>

                <li class="p-b-6">
                  <span class="fs-15 lh-12 m-r-6" style="color: #b3b3b3;">
                    <i class="zmdi zmdi-circle"></i>
                  </span>

                  <a href="#" class="filter-link stext-106 trans-04">
                    Grey
                  </a>
                </li>

                <li class="p-b-6">
                  <span class="fs-15 lh-12 m-r-6" style="color: #00ad5f;">
                    <i class="zmdi zmdi-circle"></i>
                  </span>

                  <a href="#" class="filter-link stext-106 trans-04">
                    Green
                  </a>
                </li>

                <li class="p-b-6">
                  <span class="fs-15 lh-12 m-r-6" style="color: #fa4251;">
                    <i class="zmdi zmdi-circle"></i>
                  </span>

                  <a href="#" class="filter-link stext-106 trans-04">
                    Red
                  </a>
                </li>

                <li class="p-b-6">
                  <span class="fs-15 lh-12 m-r-6" style="color: #aaa;">
                    <i class="zmdi zmdi-circle-o"></i>
                  </span>

                  <a href="#" class="filter-link stext-106 trans-04">
                    White
                  </a>
                </li>
              </ul>
            </div>

            <div class="filter-col4 p-b-27">
              <div class="mtext-102 cl2 p-b-15">
                Tags
              </div>

              <div class="flex-w p-t-4 m-r--5">
                <a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                  Fashion
                </a>

                <a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                  Lifestyle
                </a>

                <a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                  Denim
                </a>

                <a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                  Streetstyle
                </a>

                <a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                  Crafts
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Grille de produits -->
    <div ref="productGrid" class="row isotope-grid">

      <div  v-for="product in products.data" :key="product.id"
        :class="`col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item ${product.type}`">

        <!-- Block2 -->
        <div class="block2">
          <div class="block2-pic hov-img0">
            <img :src="product.image_name" alt="IMG-PRODUCT">

            <a href="#" @click="openModal(product)"
              class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
              Voir
            </a>
          </div>

          <div class="block2-txt flex-w flex-t p-t-14">
            <div class="block2-txt-child1 flex-col-l ">
              <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                {{ product.name }}
              </a>

              <span class="stext-105 cl3">
                {{ product.price }} €
              </span>
            </div>
          </div>

        </div>
      </div>
    </div> 

    <!-- Modale pour afficher les détails du produit -->
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
                        <img :src="selectedProduct.image_name" alt="IMG-PRODUCT">

                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                          :href="selectedProduct.image_name">
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
                <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                  {{ selectedProduct.name }}
                </h4>

                <span class="mtext-106 cl2">
                  {{ selectedProduct.price }} €
                </span>

                <p class="stext-102 cl3 p-t-23">
                  {{ selectedProduct.description }}
                </p>

                <div class="flex-w flex-r-m p-b-10">
                  <div class="size-204 flex-w flex-m respon6-next">
                    <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                      <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                        <i class="fs-16 zmdi zmdi-minus"></i>
                      </div>

                      <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1">

                      <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                        <i class="fs-16 zmdi zmdi-plus"></i>
                      </div>
                    </div>

                    <button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail"
                      @click="addToCart(selectedProduct)">
                      Ajouter au panier
                    </button>

                  </div>
                </div>
              </div>

              <div class="flex-w flex-m p-l-100 p-t-40 respon7">

                <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                  data-tooltip="Facebook">
                  <i class="fa fa-facebook"></i>
                </a>

                <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                  data-tooltip="Twitter">
                  <i class="fa fa-twitter"></i>
                </a>

                <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                  data-tooltip="Google Plus">
                  <i class="fa fa-google-plus"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</template>

<script setup>
import { ref, onMounted, onUpdated } from 'vue'
import Isotope from 'isotope-layout'

// Recevoir les produits en tant que prop
const props = defineProps({
  products: {
    type: Array,
    required: true,
  }
})

const isotopeInstance = ref(null)
const productGrid = ref(null)
const showModal = ref(false)
const selectedProduct = ref({})

// Fonction pour filtrer les produits
const filterProducts = (filter) => {
  isotopeInstance.value.arrange({ filter })
}

// Fonction pour ouvrir la modale avec les détails du produit
const openModal = (product) => {
  selectedProduct.value = product;
  console.log(product);

  showModal.value = true;
  console.log(showModal);
}

// Fonction pour fermer la modale
const closeModal = () => {
  showModal.value = false
}

// Fonction pour ajouter un produit au panier (exemple de logique)
const addToCart = (product) => {
  alert(`${product.name} a été ajouté au panier!`)
  closeModal()
}

// Initialisation d'Isotope lorsque le composant est monté
onMounted(() => {
  setTimeout(() => {
    isotopeInstance.value = new Isotope(productGrid.value, {
      itemSelector: '.isotope-item',
      layoutMode: 'fitRows',
    });
  }, 0);
});

// Réinitialisation d'Isotope lorsque les produits sont mis à jour
onUpdated(() => {
  isotopeInstance.value.reloadItems()
  isotopeInstance.value.arrange()
})
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

.close {
  position: absolute;
  top: 10px;
  right: 20px;
  cursor: pointer;
  font-size: 20px;
}

.isotope-grid{
  position: relative; 
  height: inherit !important;
}
</style>