<template>
    <form class="bg0 p-t-75 p-b-85">
        <div class="container">
            <div class="row">
                <!-- Colonne panier -->
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
                                <p style="font-weight:bold; color:#333; margin-bottom:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ row.product.name }}
                                </p>
                                <p style="color:#888; font-size:13px; margin-bottom:8px;">
                                    Prix unitaire :
                                    <span v-if="parseFloat(row.product.sale_price) === 0" class="product-price">
                                        {{ parseFloat(row.product.price).toFixed(2) }}€
                                    </span>
                                    <span v-else>
                                        <span class="product-old-price">{{ parseFloat(row.product.price).toFixed(2) }} € </span>
                                        <span class="product-price">{{ parseFloat(row.product.sale_price).toFixed(2) }} €</span>
                                        <span class="product-badge">Promo</span>
                                    </span>
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
                            <div style="display:flex; flex-direction:column; align-items:flex-end; gap:10px; flex-shrink:0;">
                                <span style="font-weight:bold; font-size:16px; color:#333;">
                                    <span v-if="parseFloat(row.product.sale_price) === 0">{{ (row.qty * parseFloat(row.product.price)).toFixed(2) }} €</span>
                                    <span v-else>{{ (row.qty * parseFloat(row.product.sale_price)).toFixed(2) }} €</span>
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

                <!-- Colonne récapitulatif -->
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
                            <div style="display:flex; justify-content:space-between; margin-bottom:12px; align-items:center;">
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
                                <span style="font-weight:bold; color:#27ae60;">{{ (totalCartPrice - discount).toFixed(2) }} €</span>
                            </div>

                            <hr style="border:1px dashed #ddd; margin:12px 0;">

                            <!-- Livraison -->
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <span style="color:#555; font-size:14px;">🚚 Livraison</span>
                                <span v-if="deliveryFees > 0" style="font-weight:bold; color:#333;">{{ deliveryFees }} €</span>
                                <span v-else style="color:#aaa; font-style:italic; font-size:13px;">Sélectionnez une adresse</span>
                            </div>
                        </div>

                        <!-- Adresse de livraison -->
                        <div style="background:#fff; border:1px solid #eee; border-radius:12px; padding:20px; margin-bottom:20px;">
                            <p style="font-weight:bold; margin-bottom:12px; color:#333;">📦 Adresse de livraison</p>

                            <!-- Liste des adresses -->
                            <div v-if="user.addresses && user.addresses.length > 0">
                                <div v-for="addr in user.addresses" :key="addr.id"
                                    @click="selectAddress(addr)"
                                    :style="`
                                        padding:14px;
                                        border-radius:10px;
                                        border:2px solid ${selectedAddressId === addr.id ? '#6c63ff' : '#eee'};
                                        background:${selectedAddressId === addr.id ? '#f0f0ff' : 'white'};
                                        cursor:pointer;
                                        margin-bottom:10px;
                                        transition:all 0.2s;
                                    `">
                                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                                        <div>
                                            <p style="font-weight:700; color:#333; margin:0 0 4px; font-size:14px;">
                                                {{ user.first_name }} {{ user.name }} {{ addr.last_name || '' }}
                                                <span v-if="addr.is_default"
                                                    style="background:#6c63ff; color:white; font-size:10px; padding:2px 8px; border-radius:10px; margin-left:6px; font-weight:700;">
                                                    Par défaut
                                                </span>
                                            </p>
                                            <p style="color:#666; font-size:13px; margin:0; line-height:1.6;">
                                                {{ addr.street }}
                                                <span v-if="addr.additional_address">, {{ addr.additional_address }}</span><br>
                                                {{ addr.postal_code }} {{ addr.city }}, {{ addr.country }}
                                            </p>
                                            <p v-if="addr.phone" style="color:#888; font-size:12px; margin:4px 0 0;">
                                                📞 {{ addr.phone }}
                                            </p>
                                        </div>
                                        <div v-if="selectedAddressId === addr.id"
                                            style="color:#6c63ff; font-size:22px; font-weight:bold;">✓</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Aucune adresse -->
                            <div v-else
                                style="background:#fff8e1; border-radius:8px; padding:14px; font-size:13px; color:#f39c12; text-align:center;">
                                📭 Aucune adresse enregistrée.<br>
                                <a href="/profils" style="color:#6c63ff; font-weight:600; text-decoration:none;">
                                    → Ajouter une adresse dans mon profil
                                </a>
                            </div>
                        </div>

                        <!-- Total TTC -->
                        <div style="background: linear-gradient(135deg, #333, #555); border-radius:12px; padding:20px; margin-bottom:20px;">
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <span style="color:white; font-size:15px; font-weight:bold;">💳 Total TTC</span>
                                <span v-if="newTotal > 0" style="color:#f1c40f; font-size:22px; font-weight:bold;">
                                    {{ newTotal }} €
                                </span>
                                <span v-else style="color:#aaa; font-size:14px;">Sélectionnez une adresse</span>
                            </div>
                            <p v-if="newTotal > 0" style="color:#aaa; font-size:12px; margin-top:8px; margin-bottom:0;">
                                Livraison incluse · Paiement sécurisé
                            </p>
                        </div>

                        <!-- Bouton paiement -->
                        <button v-if="selectedAddressId && deliveryFees > 0" @click.prevent="openPaymentModal"
                            class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer"
                            style="width:100%; font-size:16px;">
                            🔒 Procéder au paiement
                        </button>
                        <p v-else-if="!selectedAddressId" style="text-align:center; color:#aaa; font-size:13px; margin-top:10px;">
                            Sélectionnez une adresse pour continuer
                        </p>

                        <PaymentModal
                            :isOpen="isPaymentModalOpen"
                            :total="newTotal"
                            :userName="user.name"
                            :userEmail="user.email"
                            :userAdressLine="selectedAddress ? selectedAddress.street : ''"
                            :userCodePostal="selectedAddress ? String(selectedAddress.postal_code) : ''"
                            :userVille="selectedAddress ? selectedAddress.city : ''"
                            :userPays="selectedAddress ? selectedAddress.country : ''"
                            @update:isOpen="isPaymentModalOpen = false"
                        />
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
            deliveryFees: 0,
            selectedAddressId: null,
            selectedAddress: null,
            isPaymentModalOpen: false,
        };
    },
    computed: {
        ...mapGetters(["cart", "totalCartPrice"]),
    },
    watch: {
        // Recalcule le total quand les frais ou la réduction changent
        deliveryFees() {
            this.computeTotal();
        },
        discount() {
            this.computeTotal();
        },
        totalCartPrice() {
            this.computeTotal();
        },
        // Si l'utilisateur change, réinitialise les adresses
        user: {
            immediate: true,
            handler(newUser) {
                if (newUser && newUser.addresses) {
                    // Sélectionne l'adresse par défaut si elle existe
                    const defaultAddr = newUser.addresses.find(a => a.is_default === 1);
                    if (defaultAddr) {
                        this.selectAddress(defaultAddr);
                    }
                }
            }
        }
    },
    methods: {
        ...mapActions(['updateCartItem', 'removeFromCart', 'fetchCart']),

        increaseQuantity(row) {
            row.qty++;
            const price = parseFloat(row.product.sale_price) > 0 ? parseFloat(row.product.sale_price) : parseFloat(row.product.price);
            this.updateCartItem({ product_id: row.product_id, quantity: row.qty, price });
        },

        decreaseQuantity(row) {
            if (row.qty > 1) {
                row.qty--;
                const price = parseFloat(row.product.sale_price) > 0 ? parseFloat(row.product.sale_price) : parseFloat(row.product.price);
                this.updateCartItem({ product_id: row.product_id, quantity: row.qty, price });
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
            } catch (error) {
                this.couponError = error.response?.data?.error || 'Erreur lors de l\'application du coupon.';
            }
        },

        async selectAddress(addr) {
            this.selectedAddressId = addr.id;
            this.selectedAddress = addr;
            await this.fetchDeliveryFees(addr.country);
        },

        async fetchDeliveryFees(country) {
            if (!country) {
                this.deliveryFees = 0;
                return;
            }
            try {
                const response = await axios.get(`/frais-livraison/${country}`);
                this.deliveryFees = response.data.frais || 0;
            } catch (error) {
                console.error('Erreur frais de livraison:', error);
                this.deliveryFees = 0;
            }
        },

        computeTotal() {
            this.newTotal = parseFloat(
                (parseFloat(this.totalCartPrice) + parseFloat(this.deliveryFees) - this.discount).toFixed(2)
            );
        },

        openPaymentModal(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            this.isPaymentModalOpen = true;
        },
    },
    mounted() {
        this.fetchCart();
        // Sélectionne l'adresse par défaut si elle existe
        if (this.user.addresses && this.user.addresses.length > 0) {
            const defaultAddr = this.user.addresses.find(a => a.is_default === 1);
            if (defaultAddr) {
                this.selectAddress(defaultAddr);
            }
        }
    },
};
</script>

<style>
.product-badge {
    background: #e74c3c;
    color: white;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 10px;
    text-transform: uppercase;
    margin-left: 8px;
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
</style>