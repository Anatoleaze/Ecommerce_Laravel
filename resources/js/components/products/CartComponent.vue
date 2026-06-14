<template>

    <form class="bg0 p-t-75 p-b-85">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">

                        <!-- Titre -->
                        <h4 class="mtext-109 cl2 p-b-20">🛍️ Mon Panier</h4>

                        <!-- Carte produit -->
                        <div v-for="row in cart" :key="row.product_id"
                            style="background:#fff; border:1px solid #eee; border-radius:12px; padding:15px; margin-bottom:15px; display:flex; align-items:center; gap:15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">

                            <!-- Image -->
                            <div style="flex-shrink:0; width:90px; height:90px; border-radius:8px; overflow:hidden;">
                                <img :src="row.product.image_name.startsWith('http') ? row.product.image_name : '/' + row.product.image_name"
                                    alt="IMG" style="width:100%; height:100%; object-fit:cover;" />
                            </div>

                            <!-- Infos produit -->
                            <div style="flex:1; min-width:0;">
                                <p
                                    style="font-weight:bold; color:#333; margin-bottom:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ row.product.name }}
                                </p>
                                <p style="color:#888; font-size:13px; margin-bottom:8px;">
                                    Prix unitaire : {{ parseFloat(row.product.price).toFixed(2) }} €
                                </p>

                                <!-- Quantité -->
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m"
                                        style="width:28px; height:28px; border-radius:50%; cursor:pointer;"
                                        @click="decreaseQuantity(row)">
                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                    </div>
                                    <input class="mtext-104 cl3 txt-center" type="number" v-model="row.qty"
                                        style="width:45px; height:28px; border:1px solid #ddd; border-radius:6px; text-align:center;">
                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m"
                                        style="width:28px; height:28px; border-radius:50%; cursor:pointer;"
                                        @click="increaseQuantity(row)">
                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Total ligne + Supprimer -->
                            <div
                                style="display:flex; flex-direction:column; align-items:flex-end; gap:10px; flex-shrink:0;">
                                <span style="font-weight:bold; font-size:16px; color:#333;">
                                    {{ (row.qty * parseFloat(row.product.price)).toFixed(2) }} €
                                </span>
                                <button @click="removeProduct(row.product_id)"
                                    style="background:none; border:1px solid #e74c3c; color:#e74c3c; border-radius:6px; padding:4px 10px; cursor:pointer; font-size:12px; transition:all 0.2s;"
                                    onmouseover="this.style.background='#e74c3c'; this.style.color='white'"
                                    onmouseout="this.style.background='none'; this.style.color='#e74c3c'">
                                    🗑️ Retirer
                                </button>
                            </div>
                        </div>

                        <!-- Message panier vide -->
                        <div v-if="cart.length === 0"
                            style="text-align:center; padding:40px; background:#f8f9fa; border-radius:12px; color:#aaa;">
                            <p style="font-size:40px; margin-bottom:10px;">🛒</p>
                            <p style="font-size:16px;">Votre panier est vide</p>
                        </div>

                        <!-- Coupon -->
                        <div style="background:#f8f9fa; border-radius:12px; padding:20px; margin-top:20px;">
                            <p style="font-weight:bold; color:#333; margin-bottom:12px;">🎟️ Coupon de réduction</p>
                            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                                <input v-model="couponCode" type="text" name="coupon"
                                    placeholder="Entrez votre code promo"
                                    style="flex:1; min-width:180px; padding:10px 15px; border:1px solid #ddd; border-radius:8px; font-size:14px;">
                                <div @click="applyCoupon" class="flex-c-m hov-btn3 trans-04 pointer"
                                    style="background:#333; color:white; padding:10px 20px; border-radius:8px; font-size:14px; cursor:pointer; white-space:nowrap;">
                                    ✅ Appliquer
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">

                        <!-- Titre -->
                        <h4 class="mtext-109 cl2 p-b-30">🛒 Récapitulatif</h4>

                        <!-- Alertes coupon -->
                        <div v-if="couponSuccess" class="alert alert-success"
                            style="border-radius:8px; text-align:center;">
                            ✅ {{ couponSuccess }}
                        </div>
                        <div v-if="couponError" class="alert alert-danger"
                            style="border-radius:8px; text-align:center;">
                            ❌ {{ couponError }}
                        </div>

                        <!-- Carte récapitulatif -->
                        <div style="background:#f8f9fa; border-radius:12px; padding:20px; margin-bottom:20px;">

                            <!-- Prix initial -->
                            <div
                                style="display:flex; justify-content:space-between; margin-bottom:12px; align-items:center;">
                                <span style="color:#555; font-size:14px;">🏷️ Prix du panier</span>
                                <span v-if="discount > 0"
                                    style="text-decoration:line-through; color:#e74c3c; font-weight:bold;">
                                    {{ totalCartPrice }} €
                                </span>
                                <span v-else style="font-weight:bold; color:#333;">
                                    {{ totalCartPrice }} €
                                </span>
                            </div>

                            <!-- Réduction -->
                            <div v-if="discount > 0"
                                style="display:flex; justify-content:space-between; margin-bottom:12px; align-items:center; background:#eafaf1; padding:8px 12px; border-radius:8px;">
                                <span style="color:#27ae60; font-size:14px;">🎉 Réduction ({{ pourcentage }}%)</span>
                                <span style="color:#27ae60; font-weight:bold;">- {{ discount.toFixed(2) }} €</span>
                            </div>

                            <!-- Sous-total après réduction -->
                            <div v-if="discount > 0"
                                style="display:flex; justify-content:space-between; margin-bottom:12px; align-items:center;">
                                <span style="color:#555; font-size:14px;">💰 Sous-total</span>
                                <span style="font-weight:bold; color:#27ae60;">{{ (totalCartPrice - discount).toFixed(2)
                                }} €</span>
                            </div>

                            <hr style="border:1px dashed #ddd; margin:12px 0;">

                            <!-- Livraison -->
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <span style="color:#555; font-size:14px;">🚚 Livraison</span>
                                <span v-if="deliveryFees > 0" style="font-weight:bold; color:#333;">{{ deliveryFees }}
                                    €</span>
                                <span v-else style="color:#aaa; font-style:italic; font-size:13px;">À calculer</span>
                            </div>
                        </div>

                        <!-- Adresse & Pays -->
                        <div
                            style="background:#fff; border:1px solid #eee; border-radius:12px; padding:20px; margin-bottom:20px;">
                            <p style="font-weight:bold; margin-bottom:12px; color:#333;">📦 Adresse de livraison</p>

                            <p v-if="selectedCountryErrors" class="alert alert-danger" style="font-size:13px;">{{
                                selectedCountryErrors }}</p>
                            <select v-model="selectedCountry" class="stext-104 cl2 plh4 size-116 bor13 p-lr-20 m-b-12"
                                name="time" required>
                                <option selected>Sélectionnez votre pays</option>
                                <option v-for="pays in paysList" :key="pays" :value="pays">{{ pays }}</option>
                            </select>

                            <input v-model="address.rue" class="stext-104 cl2 plh4 bor13 size-116 p-lr-20 m-b-12"
                                type="text" placeholder="🏠 Rue" :disabled="isAddressDisabled" required>
                            <p v-if="addressErrors.rue" class="alert alert-danger" style="font-size:13px;">{{
                                addressErrors.rue }}</p>

                            <input v-model="address.code_postal"
                                class="stext-104 cl2 plh4 bor13 size-116 p-lr-20 m-b-12" type="number"
                                placeholder="📮 Code Postal" :disabled="isAddressDisabled" required>
                            <p v-if="addressErrors.code_postal" class="alert alert-danger" style="font-size:13px;">{{
                                addressErrors.code_postal }}</p>

                            <input v-model="address.ville" class="stext-104 cl2 plh4 bor13 size-116 p-lr-20 m-b-12"
                                type="text" placeholder="🏙️ Ville" :disabled="isAddressDisabled" required>
                            <p v-if="addressErrors.ville" class="alert alert-danger" style="font-size:13px;">{{
                                addressErrors.ville }}</p>

                            <div @click="validateAddress"
                                class="flex-c-m stext-101 cl2 size-116 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-t-10">
                                🔄 Mettre à jour le total
                            </div>
                        </div>

                        <!-- Total TTC -->
                        <div
                            style="background: linear-gradient(135deg, #333, #555); border-radius:12px; padding:20px; margin-bottom:20px;">
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <span style="color:white; font-size:15px; font-weight:bold;">💳 Total TTC</span>
                                <span v-if="newTotal > 0" style="color:#f1c40f; font-size:22px; font-weight:bold;">
                                    {{ newTotal }} €
                                </span>
                                <span v-else style="color:#aaa; font-size:14px;">En attente de l'adresse</span>
                            </div>
                            <p v-if="newTotal > 0" style="color:#aaa; font-size:12px; margin-top:8px; margin-bottom:0;">
                                Livraison incluse · Paiement sécurisé
                            </p>
                        </div>

                        <!-- Bouton paiement -->
                        <button v-if="deliveryFees > 0" @click.prevent="openPaymentModal"
                            class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer"
                            style="width:100%; font-size:16px;">
                            🔒 Procéder au paiement
                        </button>

                        <PaymentModal :isOpen="isPaymentModalOpen" :total="newTotal" :userName="user.name"
                            :userEmail="user.email" :userAdressLine="address.rue" :userCodePostal="address.code_postal"
                            :userVille="address.ville" :userPays="selectedCountry"
                            @update:isOpen="isPaymentModalOpen = false" />
                    </div>
                </div>
            </div>
        </div>
    </form>


</template>

<script>

import { mapActions, mapGetters } from 'vuex';
import PaymentModal from "../orders/PaymentModal.vue";
import axios from 'axios';

export default {

    name: 'CartComponent',

    props: {
        user: {
            type: Object,
            required: true
        },
    },

    components: {
        PaymentModal,
    },

    data() {
        return {
            couponCode: '',
            discount: 0,
            newTotal: 0,
            pourcentage: 0,
            couponError: '',
            couponSuccess: '',
            paysList: [],
            selectedCountry: "Sélectionnez votre pays",
            selectedCountryErrors: '',
            isAddressDisabled: false,
            deliveryFees: 0,
            address: {
                rue: '',
                code_postal: '',
                ville: ''
            },
            addressErrors: {},
            isPaymentModalOpen: false,
        };
    },

    computed: {
        ...mapGetters(["cart", "totalCartPrice"]),

    },

    methods: {

        ...mapActions(['updateCartItem', 'removeFromCart', 'fetchCart']),

        increaseQuantity(row) {
            row.qty++;

            this.updateCartItem({
                product_id: row.product_id,
                quantity: row.qty,
                price: parseFloat(row.product.price),
            });
        },

        decreaseQuantity(row) {
            if (row.qty > 1) {
                row.qty--;

                this.updateCartItem({
                    product_id: row.product_id,
                    quantity: row.qty,
                    price: parseFloat(row.product.price),
                });
            } else {
                this.removeProduct(row.product_id);
            }
        },


        removeProduct(product_id) {
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
                this.pourcentage = response.data.pourcentage;
                this.updateTotal();


                this.$nextTick(() => {
                    this.newTotal = parseFloat((parseFloat(this.totalCartPrice) + parseFloat(this.deliveryFees) - this.discount).toFixed(2));
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
            if (!this.selectedCountry || this.selectedCountry === 'Sélectionnez votre pays') {
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
            await this.fetchDeliveryFees();
            this.newTotal = parseFloat((parseFloat(this.totalCartPrice) + parseFloat(this.deliveryFees) - this.discount).toFixed(2));
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
            this.selectedCountryErrors = '';

            if (this.selectedCountry === "Sélectionnez votre pays") {
                this.selectedCountryErrors = "Le pays doit être renseigné.";
            }

            if (!this.address.rue || this.address.rue.length < 3) {
                this.addressErrors.rue = "Le champ rue doit contenir au moins 3 caractères.";
            }

            if (!this.address.ville || this.address.ville.length < 3) {
                this.addressErrors.ville = "Le champ ville doit contenir au moins 3 caractères.";
            }

            if (!this.address.code_postal || !/^\d{4,5}$/.test(this.address.code_postal)) {
                this.addressErrors.code_postal = "Le code postal doit contenir 4 ou 5 chiffres.";
            }

            if (Object.keys(this.addressErrors).length === 0 && this.selectedCountryErrors == "") {
                await this.onUpdateTotalClick();
            }
        },

        openPaymentModal(event) {
            if (event) {
                event.preventDefault(); // Stop default behavior
                event.stopPropagation(); // Stop propagation
            }
            this.isPaymentModalOpen = true;
        },
        closePaymentModal(event) {
            if (event) event.preventDefault();

            this.isPaymentModalOpen = false;

            // Reaload fess delivry
            this.fetchDeliveryFees();
        }

    },



    mounted() {
        this.fetchCart();
        this.fetchPays();  // fetch pays when the component is mounted

    },

};


</script>

<style>
.column-2 {
    text-align: center;
}

.msg-promo {
    padding-left: 15px;
}

.new-total {
    color: green;
    font-weight: bold;
}

.oldprice {
    text-decoration: line-through;
    color: red;
}
</style>