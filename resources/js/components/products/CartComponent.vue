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
                                Total :
                            </span>
                        </div>

                           <div v-if="discount > 0" class="size-229">
                                <p class="msg-promo">Réduction appliquée : -{{ discount.toFixed(2) }} €</p>
                                <p class="msg-promo">Nouveau total : <strong class="new-total">{{ newTotal.toFixed(2) }} €</strong></p>
                            </div>
                        
                            <div v-else class="size-209">
                               
                                <span class="mtext-110 cl2">
                                    {{ totalCartPrice }} €
                                </span>
                            </div>
                        

                    </div>
                    
                    <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                        <div class="size-208 w-full-ssm">
                            <span class="stext-110 cl2">
                                Livraison :
                            </span>
                        </div>

                        <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                            
                            <div class="p-t-15">
                                <span class="stext-112 cl8">
                                    Calculer les frais de port
                                </span>

                                <div class="rs1-select2 rs2-select2 m-b-12 m-t-9">
                                    <select class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" name="time">
                                        <option>Sélectionnez votre pays</option>
                                        <option value="USA">USA</option>
                                        <option value="UK">UK</option>
                                        <option value="FR">FR</option>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
 
                                <div class="flex-w">
                                    <div class="flex-c-m stext-101 cl2 size-115 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer">
                                      Mettre à jour le total
                                    </div>
                                </div>
                                    
                            </div>
                        </div>
                    </div>

                    <div class="flex-w flex-t p-t-27 p-b-33">
                        <div class="size-208">
                            <span class="mtext-101 cl2">
                                Total :
                            </span>
                        </div>

                        <div class="size-209 p-t-1">
                            <span class="mtext-110 cl2">
                                79.65 €
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
    };
  },

  computed: {
  ...mapGetters(["cart", "totalCartPrice"])
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
        console.log("In applyCoupon");
        this.couponError = '';
        this.couponSuccess = '';

        try {
        const response = await axios.post('/check-promo', {
            code: this.couponCode,
            total: this.totalCartPrice
        });
        console.log(response);
        this.discount = response.data.discount;
        this.newTotal = response.data.newTotal;
        this.couponSuccess = response.data.success;

        } catch (error) {
            console.log(error);
            this.couponError = error.response.data.error;

        }
    }

  },

  

  mounted() {

    this.fetchCart();
    console.log("discount : "+this.discount);
    
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