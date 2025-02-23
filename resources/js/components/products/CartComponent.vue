<template>

<form class="bg0 p-t-75 p-b-85">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart">
                            <tr class="table_head">
                                <th class="column-1">Produits</th>
                                <th class="column-2"></th>
                                <th class="column-3">Prix</th>
                                <th class="column-4">Quantité</th>
                                <th class="column-5">Total</th>
                            </tr>

                            <tr v-for="row in cart" :key="row.product_id" class="table_row">
                                                            
                                <td class="column-1">
                                    <div class="how-itemcart1" @click="removeProduct(row.product_id)">
                                        <img :src="'/' + row.product.image_name" alt="IMG" />
                                    </div>
                                </td>
                                <td class="column-2"> {{ row.product.name }} </td>
                                <td class="column-3"> {{ parseFloat(row.product.price).toFixed(2) }} €</td>
                                <td class="column-4">
                                    <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" @click="decreaseQuantity(row)">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </div>

                                        <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product1" v-model='row.qty'>

                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" @click="increaseQuantity(row)">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="column-5"> {{ row.price  }} €</td>
                            </tr>

                        </table>
                    </div>

                    <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                        <div class="flex-w flex-m m-r-20 m-tb-5">
                            <input v-model="couponCode" class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text" name="coupon" placeholder="Coupon de réduction">
                                
                            <div @click="applyCoupon" class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                            Appliquer le coupon
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                    <h4 class="mtext-109 cl2 p-b-30">
                        Récapitulatif
                    </h4>
                    
                    <div v-if="couponSuccess" class="alert alert-success flex-c-m stext-101 cl2 size-115 bor13 p-lr-15 trans-04">
                        {{ couponSuccess }}
                    </div>
                    
                    <div v-if="couponError" class="alert alert-danger flex-c-m stext-101 cl2 size-115 bor13 p-lr-15 trans-04">
                        {{ couponError }}
                    </div>
                    
                    <div class="flex-w flex-t bor12 p-b-13">
                        <div class="size-208">
                            <span class="stext-110 cl2">
                                Total du Panier :
                            </span>
                        </div>

                           <div v-if="discount > 0" class="size-229">
                                <p class="msg-promo">Réduction appliquée : -{{ discount.toFixed(2) }} €</p>
                                <p class="msg-promo">Nouveau total : <strong class="new-total">{{ (totalCartPrice-discount).toFixed(2) }} €</strong></p>
                            </div>
                        
                            <div v-else class="size-209">
                               
                                <span class="mtext-110 cl2">
                                    {{ totalCartPrice }} €
                                </span>
                            </div>
                        

                    </div>
                    
                    <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                        <div class="w-full-ssm p-r-15">

                            <span class="stext-110 cl2">
                                Livraison : 
                                
                                <span v-if="deliveryFees>0" class="mtext-110 cl2">
                                    {{ deliveryFees }} €
                                </span>

                            </span>
                            
                             
                        </div>
                    </div>

                    <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                        <div class="rs1-select2 rs2-select2 m-b-12 m-t-9">
                            <select v-model="selectedCountry" class="stext-104 cl2 plh4 size-116 bor13 p-lr-20" name="time" required>
                                <option selected>Sélectionnez votre pays</option>
                                <option v-for="pays in paysList" :key="pays" :value="pays">{{ pays }}</option>
                            </select>
                            <div class="dropDownSelect2"></div>
                        </div>

                        <div class="rs1-select2 rs2-select2 m-b-12 m-t-9">
                            <input v-model="address.rue" class="stext-104 cl2 plh4 bor13 size-116 p-lr-20" type="text" placeholder="Rue" :disabled="isAddressDisabled" required>
                            <p v-if="addressErrors.rue" class="alert alert-danger m-t-15">{{ addressErrors.rue }}</p>
                        </div>

                        <div class="rs1-select2 rs2-select2 m-b-12 m-t-9">
                            <input v-model="address.code_postal" class="stext-104 cl2 plh4 bor13 size-116 p-lr-20" type="number" name="code_postal" placeholder="Code Postal" :disabled="isAddressDisabled" required>
                            <p v-if="addressErrors.code_postal" class="alert alert-danger m-t-15">{{ addressErrors.code_postal }}</p>
                        </div>

                        <div class="rs1-select2 rs2-select2 m-b-12 m-t-9">
                            <input v-model="address.ville" class="stext-104 cl2 plh4 bor13 size-116 p-lr-20 " type="text" name="ville" placeholder="Ville" :disabled="isAddressDisabled" required>
                            <p v-if="addressErrors.ville" class="alert alert-danger m-t-15">{{ addressErrors.ville }}</p>
                        </div>

                        <div @click="validateAddress" class="flex-c-m stext-101 cl2 size-116 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer">
                                Mettre à jour le total
                        </div>

                    
                    </div>

                    <div class="flex-w flex-t p-t-27 p-b-33">
                        <div class="size-208">
                            <span class="mtext-101 cl2">
                                Total :
                            </span>
                        </div>
                        
                        <div v-if="newTotal >0" class="size-209 p-t-1">
                            <span class="mtext-110 cl2">
                                {{ newTotal}} €
                            </span>
                        </div>
                    </div>

                    <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                        Procéder au paiement
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
    

</template>

<script>

import { mapActions,mapGetters } from 'vuex';
import axios from 'axios';

export default {

  data() {
    return {
        couponCode: '',
        discount: 0,
        newTotal: 0,  
        couponError: '',
        couponSuccess: '',
        paysList: [],
        selectedCountry: "Sélectionnez votre pays",
        isAddressDisabled: false,
        deliveryFees: 0,
        address: {
            rue: '',
            code_postal: '',
            ville: ''
        },
        addressErrors: {},
    };
  },

  computed: {
    ...mapGetters(["cart", "totalCartPrice"]),

  },
  
  methods: {
    
    ...mapActions(['updateCartItem', 'removeFromCart', 'fetchCart']),
    
    increaseQuantity(row) {
            row.qty++;
            row.price = (row.qty * row.product.price).toFixed(2);
    
            this.updateCartItem({
                product_id: row.product_id,
                quantity: row.qty,
                price: row.price,
            });
    },

    decreaseQuantity(row) {
        if (row.qty > 1) {
            row.qty--;
            row.price = (row.qty * row.product.price).toFixed(2);

            this.updateCartItem({
                product_id: row.product_id,
                quantity: row.qty,
                price: row.price,
            });
        } else {
            this.removeProduct(row.product_id);
        }
    },
    
    
    removeProduct(product_id){
        this.removeFromCart(product_id);
        this.fetchCart(); 
    },

    async applyCoupon() {
        this.couponError = '';
        this.couponSuccess = '';

        try {
        const response = await axios.post('/check-promo', {
            code: this.couponCode,
            total: this.totalCartPrice
        });

        this.discount = response.data.discount;
        this.couponSuccess = response.data.success;
        this.updateTotal();

        this.$nextTick(() => {
            this.newTotal = (parseFloat(this.totalCartPrice) + parseFloat(this.deliveryFees) - this.discount).toFixed(2);
        });
        } catch (error) {
            this.couponError = error.response.data.error;
        }
    },

    async fetchPays() {
      try {
        const response = await axios.get("/pays");
        this.paysList = response.data;
      } catch (error) {
        console.error("Erreur lors de la récupération des pays :", error);
      }
    },

    async fetchDeliveryFees() {
        if (!this.selectedCountry) {
            this.deliveryFees = 0;
            return;
        }

        try {
            const response = await axios.get(`/frais-livraison/${this.selectedCountry}`);
            this.deliveryFees = response.data.frais;
        } catch (error) {
            console.error("Erreur lors de la récupération des frais de livraison :", error);
            this.deliveryFees = 0;
        }
    },

    async updateTotal() {
        await this.fetchDeliveryFees(); // Get delevry cost
    
        this.newTotal = ( parseFloat(this.totalCartPrice) + parseFloat(this.deliveryFees) - this.discount ).toFixed(2);
        
    },

     // Click on button "Mettre à jour le total"
     async onUpdateTotalClick() {
        await this.updateTotal();
        this.disableAddressInputs();
    },


    disableAddressInputs() {

        // Block modification of “street”, “postal code”, and “city” fields
        const addressFields = document.querySelectorAll('input[name="rue"], input[name="code_postal"], input[name="ville"]');
        addressFields.forEach(field => {
            field.disabled = true;
        });
    },

    async validateAddress() {
        this.addressErrors = {}; 

        if (!this.address.rue || this.address.rue.length < 3) {
            this.addressErrors.rue = "Le champ rue doit contenir au moins 3 caractères.";
        }
        
        if (!this.address.ville || this.address.ville.length < 3) {
            this.addressErrors.ville = "Le champ ville doit contenir au moins 3 caractères.";
        }
        
        if (!this.address.code_postal || !/^\d{4,5}$/.test(this.address.code_postal)) {
            this.addressErrors.code_postal = "Le code postal doit contenir 4 ou 5 chiffres.";
        }
        
        if (Object.keys(this.addressErrors).length === 0) {
            await this.onUpdateTotalClick();
        }
    }



  },

  

  mounted() {

    this.fetchCart();
    this.fetchPays();  // fetch pays when the component is mounted
    
  },

};


</script>

<style>

.column-2{
    text-align: center;
}

.msg-promo{
    padding-left: 15px;
}

.new-total{
    color:green;
}

</style>