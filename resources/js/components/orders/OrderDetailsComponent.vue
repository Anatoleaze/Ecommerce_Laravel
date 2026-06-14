<template>
  <div style="min-height: 100vh; background: #f6f7fb; padding: 50px 0;">

    <div class="container" style="max-width: 1100px;">

      <!-- HEADER -->
      <div style="margin-bottom: 30px;">
        <span style="
          display:inline-block;
          background: rgba(26,26,46,0.08);
          color:#1a1a2e;
          padding:6px 14px;
          border-radius:20px;
          font-size:12px;
          font-weight:800;
          letter-spacing:1px;
          text-transform:uppercase;
          margin-bottom:10px;
        ">
          Commande #{{ order[0].num }}
        </span>

        <h2 style="font-size:28px; font-weight:800; color:#1a1a2e; margin:0;">
          Détails de la commande
        </h2>

        <p style="color:#777; font-size:13px; margin-top:6px;">
          Suivi et gestion de votre commande
        </p>
      </div>

      <div class="row" style="gap: 30px 0;">

        <!-- PRODUITS -->
        <div class="col-lg-7">

          <div style="
            background:white;
            border-radius:18px;
            padding:24px;
            box-shadow:0 15px 40px rgba(0,0,0,0.06);
          ">

            <h5 style="font-size:15px; font-weight:800; color:#1a1a2e; margin-bottom:18px;">
              🛍️ Produits
            </h5>

            <div v-for="row in order" :key="row.id"
              style="
                display:flex;
                gap:16px;
                padding:14px 0;
                border-bottom:1px solid #f3f4f6;
                align-items:center;
              ">

              <!-- IMAGE -->
              <div style="
                width:70px;
                height:70px;
                border-radius:12px;
                overflow:hidden;
                background:#f3f4f6;
                flex-shrink:0;
              ">
                <img :src="row.product_image"
                     :alt="row.product_name"
                     style="width:100%; height:100%; object-fit:cover;">
              </div>

              <!-- INFOS -->
              <div style="flex:1;">
                <p style="margin:0; font-weight:700; color:#1a1a2e; font-size:14px;">
                  {{ row.product_name }}
                </p>

                <p style="margin:4px 0 0; font-size:12px; color:#777;">
                  Quantité : <b>{{ row.quantity }}</b>
                </p>
              </div>

            </div>

          </div>
        </div>

        <!-- RECAP -->
        <div class="col-lg-5">

          <div style="
            background:white;
            border-radius:18px;
            padding:24px;
            box-shadow:0 15px 40px rgba(0,0,0,0.06);
          ">

            <h5 style="font-size:15px; font-weight:800; color:#1a1a2e; margin-bottom:18px;">
              📋 Récapitulatif
            </h5>

            <!-- STATUS -->
            <div style="margin-bottom:14px;">
              <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:12px; color:#777; font-weight:700;">Statut</span>

                <span :style="`
                  padding:6px 14px;
                  border-radius:999px;
                  font-size:12px;
                  font-weight:800;
                  background:${getStatusColor(orderLocal.statut).bg};
                  color:${getStatusColor(orderLocal.statut).text};
                `">
                  {{ orderLocal.statut }}
                </span>
              </div>
            </div>

            <!-- TRACKING -->
            <div style="margin-bottom:14px;">
              <div style="display:flex; justify-content:space-between;">
                <span style="font-size:12px; color:#777; font-weight:700;">Tracking</span>
                <span style="font-size:12px; font-weight:800; color:#1a1a2e; font-family:monospace;">
                  {{ order[0].num }}
                </span>
              </div>
            </div>

            <!-- LIVRAISON -->
            <div style="margin-bottom:14px;">
              <div style="display:flex; justify-content:space-between;">
                <span style="font-size:12px; color:#777; font-weight:700;">Livraison</span>
                <span style="font-size:13px; font-weight:700; color:#1a1a2e;">
                  {{ order[0].livraison }}
                </span>
              </div>
            </div>

            <!-- TOTAL -->
            <div style="
              margin-top:18px;
              padding:16px;
              border-radius:14px;
              background: linear-gradient(135deg, #1a1a2e, #333);
              display:flex;
              justify-content:space-between;
              align-items:center;
            ">
              <span style="color:white; font-weight:700; font-size:13px;">
                Total TTC
              </span>

              <span style="color:#f1c40f; font-size:18px; font-weight:900;">
                {{ order[0].total }} €
              </span>
            </div>

            <!-- ADMIN ACTION -->
            <template v-if="user.role === 'admin' && orderLocal.statut === 'en attente'">

              <div style="margin-top:20px; border-top:1px solid #f3f4f6; padding-top:16px;">

                <p style="font-size:12px; font-weight:800; color:#555; margin-bottom:10px;">
                  ⚙️ Action admin
                </p>

                <button @click="changeStatus(order[0].order_id)"
                  style="
                    width:100%;
                    padding:12px;
                    background: linear-gradient(135deg, #1a1a2e, #333);
                    color:white;
                    border:none;
                    border-radius:12px;
                    font-size:13px;
                    font-weight:800;
                    cursor:pointer;
                    transition:0.2s;
                  "
                  onmouseover="this.style.transform='translateY(-1px)'"
                  onmouseout="this.style.transform='translateY(0)'">

                  🚚 Marquer en cours de livraison
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
        'en attente': { bg: '#fff8e1', text: '#f39c12' },
        'encours de livraison': { bg: '#e8f4fd', text: '#2980b9' },
        'En cours de livraison': { bg: '#e8f4fd', text: '#2980b9' },
        'livré': { bg: '#eafaf1', text: '#27ae60' },
        'annulé': { bg: '#fef0f0', text: '#e74c3c' },
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
        }

      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>