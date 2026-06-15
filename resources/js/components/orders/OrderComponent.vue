<template>
<div style="padding:10px 0;">
  <div style="width:100%;">

    <!-- HEADER -->
    <div style="margin-bottom:24px;">
      <h2 style="font-size:24px; font-weight:800; color:#1a1a2e; margin:0;">
        Mes commandes
      </h2>
      <p style="color:#777; font-size:13px; margin-top:6px;">
        Historique et suivi de vos commandes
      </p>
    </div>

    <!-- TABLE CARD -->
    <div style="background:white; border-radius:16px; box-shadow:0 4px 15px rgba(0,0,0,0.06); overflow:hidden;">

      <!-- HEADER ROW -->
      <div :style="`
        display:grid;
        grid-template-columns: ${user.role != 'admin' ? '1fr 2fr 1fr 1.5fr 1fr' : '1fr 2fr 1.5fr 1fr'};
        padding:16px 24px;
        background:#1a1a2e;
        color:white;
        font-size:12px;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:1px;
      `">
        <div>Date</div>
        <div>Tracking</div>
        <div v-if="user.role != 'admin'">Montant</div>
        <div>Status</div>
        <div>Détail</div>
      </div>

      <!-- Message si aucune commande -->
      <div v-if="orders.length === 0"
           style="padding:40px; text-align:center; color:#aaa; font-size:14px;">
        📦 Aucune commande pour le moment
      </div>

      <!-- ROWS -->
      <div v-for="order in orders"
           :key="order.id"
           :style="`
             display:grid;
             grid-template-columns: ${user.role != 'admin' ? '1fr 2fr 1fr 1.5fr 1fr' : '1fr 2fr 1.5fr 1fr'};
             padding:16px 24px;
             align-items:center;
             border-bottom:1px solid #f3f4f6;
             transition:background 0.2s;
           `"
           onmouseover="this.style.background='#fafafa'"
           onmouseout="this.style.background='white'">

        <!-- DATE -->
        <div style="font-size:13px; color:#333; font-weight:600;">
          {{ formatDate(order.created_at) }}
        </div>

        <!-- TRACKING -->
        <div style="font-size:12px; color:#1a1a2e; font-family:monospace; font-weight:700; word-break:break-all;">
          {{ order.numero_commande }}
        </div>

        <!-- AMOUNT -->
        <div v-if="user.role != 'admin'"
             style="font-size:14px; font-weight:800; color:#1a1a2e;">
          {{ order.total }} €
        </div>

        <!-- STATUS -->
        <div>
          <span :style="`
            display:inline-block;
            padding:5px 12px;
            border-radius:999px;
            font-size:11px;
            font-weight:800;
            background:${getStatusColor(order.statut).bg};
            color:${getStatusColor(order.statut).text};
          `">
            {{ order.statut }}
          </span>
        </div>

        <!-- ACTION -->
        <div>
          <a :href="`/commandes/details/${order.id}`"
             style="display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:#1a1a2e; color:white; border-radius:8px; font-size:12px; font-weight:700; text-decoration:none; transition:all 0.2s;"
             onmouseover="this.style.background='#333'"
             onmouseout="this.style.background='#1a1a2e'">
            👁️ Voir
          </a>
        </div>

      </div>

    </div>

  </div>
</div>
</template>

<script>
export default {
  name: 'OrderComponent',

  props: {
    orders: {
      type: Array,
      required: true
    },
    user: {
      type: Object,
      required: true
    }
  },

  methods: {
    formatDate(date) {
      return new Intl.DateTimeFormat("fr-FR", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
      }).format(new Date(date));
    },

    getStatusColor(statut) {
      const map = {
        'en attente': { bg: '#fff8e1', text: '#f39c12' },
        'encours de livraison': { bg: '#e8f4fd', text: '#2980b9' },
        'En cours de livraison': { bg: '#e8f4fd', text: '#2980b9' },
        'livré': { bg: '#eafaf1', text: '#27ae60' },
        'annulé': { bg: '#fef0f0', text: '#e74c3c' },
      };
      return map[statut] || { bg: '#f0f0f0', text: '#555' };
    }
  },

  mounted() {
    console.log('OrderComponent is mounted');
  }
}
</script>