<template>
  <div style="padding: 40px 0; background: #f8f9fa; min-height: 100vh;">
    <div class="container">

      <!-- Titre -->
      <div style="margin-bottom: 32px;">
        <span style="display:inline-block; background:#f0f0ff; color:#6c63ff; padding:5px 14px; border-radius:20px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:12px;">
          Commande #{{ order[0].num }}
        </span>
        <h2 style="font-size:28px; font-weight:800; color:#1a1a2e; margin:0;">
          Détails de la commande
        </h2>
      </div>

      <div class="row" style="gap: 30px 0;">

        <!-- Liste des produits -->
        <div class="col-lg-7">
          <div style="background:white; border-radius:16px; padding:24px; box-shadow:0 4px 15px rgba(0,0,0,0.06);">
            <h5 style="font-size:16px; font-weight:700; color:#333; margin-bottom:20px;">🛍️ Produits commandés</h5>

            <div v-for="row in order" :key="row.id"
              style="display:flex; align-items:center; gap:16px; padding:16px 0; border-bottom:1px solid #f0f0f0;">

              <!-- Image -->
              <div style="flex-shrink:0; width:80px; height:80px; border-radius:10px; overflow:hidden; background:#f8f9fa;">
                <img :src="row.product_image" :alt="row.product_name"
                  style="width:100%; height:100%; object-fit:cover;">
              </div>

              <!-- Infos -->
              <div style="flex:1;">
                <p style="font-weight:600; color:#333; margin:0 0 4px; font-size:15px;">{{ row.product_name }}</p>
                <p style="color:#aaa; font-size:13px; margin:0;">Quantité : {{ row.quantity }}</p>
              </div>

            </div>
          </div>
        </div>

        <!-- Récapitulatif -->
        <div class="col-lg-5">
          <div style="background:white; border-radius:16px; padding:24px; box-shadow:0 4px 15px rgba(0,0,0,0.06);">
            <h5 style="font-size:16px; font-weight:700; color:#333; margin-bottom:20px;">📋 Récapitulatif</h5>

            <!-- Statut -->
            <div style="margin-bottom:16px; padding:14px; background:#f8f9fa; border-radius:10px; display:flex; justify-content:space-between; align-items:center;">
              <span style="font-size:13px; color:#888; font-weight:600;">Statut</span>
              <span :style="`
                padding: 5px 14px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 700;
                background: ${getStatusColor(orderLocal.statut).bg};
                color: ${getStatusColor(orderLocal.statut).text};
              `">
                {{ orderLocal.statut }}
              </span>
            </div>

            <!-- Numéro de suivi -->
            <div style="margin-bottom:16px; padding:14px; background:#f8f9fa; border-radius:10px; display:flex; justify-content:space-between; align-items:center;">
              <span style="font-size:13px; color:#888; font-weight:600;">N° de suivi</span>
              <span style="font-size:13px; font-weight:700; color:#333; font-family:monospace;">{{ order[0].num }}</span>
            </div>

            <!-- Livraison -->
            <div style="margin-bottom:16px; padding:14px; background:#f8f9fa; border-radius:10px; display:flex; justify-content:space-between; align-items:center;">
              <span style="font-size:13px; color:#888; font-weight:600;">🚚 Livraison</span>
              <span style="font-size:13px; font-weight:600; color:#333;">{{ order[0].livraison }}</span>
            </div>

            <!-- Total -->
            <div style="background:linear-gradient(135deg, #1a1a2e, #333); border-radius:10px; padding:16px; display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
              <span style="color:white; font-size:14px; font-weight:600;">Total TTC</span>
              <span style="color:#f1c40f; font-size:20px; font-weight:800;">{{ order[0].total }} €</span>
            </div>

            <!-- Bouton changer statut (admin) -->
            <template v-if="user.role === 'admin' && orderLocal.statut === 'en attente'">
              <div style="border-top:1px solid #f0f0f0; padding-top:16px;">
                <p style="font-size:13px; font-weight:600; color:#555; margin-bottom:10px;">⚙️ Action admin</p>
                <button @click="changeStatus(order[0].order_id)"
                  style="width:100%; padding:12px; background:#6c63ff; color:white; border:none; border-radius:10px; font-size:14px; font-weight:700; cursor:pointer; transition:background 0.2s;"
                  onmouseover="this.style.background='#5a52d5'"
                  onmouseout="this.style.background='#6c63ff'">
                  🚚 Marquer "En cours de livraison"
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
import axios from 'axios';

export default {
  name: 'OrderDetailsComponent',

  props: {
    order: { type: Array, required: true },
    user: { type: Object, required: true },
  },

  data() {
    return {
      orderLocal: { ...this.order[0] },
    };
  },

  methods: {
    getStatusColor(statut) {
      const map = {
        'en attente':          { bg: '#fff8e1', text: '#f39c12' },
        'encours de livraison': { bg: '#e8f4fd', text: '#2980b9' },
        'En cours de livraison': { bg: '#e8f4fd', text: '#2980b9' },
        'livré':               { bg: '#eafaf1', text: '#27ae60' },
        'annulé':              { bg: '#fef0f0', text: '#e74c3c' },
      };
      return map[statut] || { bg: '#f0f0f0', text: '#555' };
    },

    async changeStatus(order_id) {
      try {
        const response = await axios.patch(`/commande/${order_id}/status`, {
          statut: 'encours de livraison',
        });
        if (response.data.success) {
          this.orderLocal.statut = 'En cours de livraison';
        } else {
          console.error('Erreur :', response.data.message);
        }
      } catch (error) {
        console.error('Erreur :', error);
      }
    },
  },

  mounted() {
    console.log('OrderDetailsComponent mounted', this.order);
  },
};
</script>