<template>

<div style="min-height: 100vh; background:#f6f7fb; padding:60px 0;">

  <div class="container" style="max-width:1100px;">

    <!-- HEADER -->
    <div style="margin-bottom:30px;">
      <h2 style="font-size:28px; font-weight:800; color:#1a1a2e; margin:0;">
        Mes commandes
      </h2>
      <p style="color:#777; font-size:13px; margin-top:6px;">
        Historique et suivi de vos commandes
      </p>
    </div>

    <!-- TABLE CARD -->
    <div style="
      background:white;
      border-radius:18px;
      box-shadow:0 15px 40px rgba(0,0,0,0.06);
      overflow:hidden;
    ">

      <!-- HEADER ROW -->
      <div style="
        display:grid;
        grid-template-columns: 1.2fr 1.4fr 1fr 1fr 1fr;
        padding:16px 20px;
        background:#1a1a2e;
        color:white;
        font-size:12px;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:1px;
      ">
        <div>Date</div>
        <div>Tracking</div>
        <div v-if="user.role != 'admin'">Montant</div>
        <div>Status</div>
        <div>Détail</div>
      </div>

      <!-- ROWS -->
      <div v-for="order in orders"
           :key="order.id"
           style="
             display:grid;
             grid-template-columns: 1.2fr 1.4fr 1fr 1fr 1fr;
             padding:16px 20px;
             align-items:center;
             border-bottom:1px solid #f3f4f6;
             transition:0.2s;
           "
           onmouseover="this.style.background='#fafafa'"
           onmouseout="this.style.background='white'">

        <!-- DATE -->
        <div style="font-size:13px; color:#333; font-weight:600;">
          {{ formatDate(order.created_at) }}
        </div>

        <!-- TRACKING -->
        <div style="font-size:13px; color:#1a1a2e; font-family:monospace; font-weight:700;">
          {{ order.numero_commande }}
        </div>

        <!-- AMOUNT -->
        <div v-if="user.role != 'admin'"
             style="font-size:13px; font-weight:700; color:#333;">
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
             style="
               display:inline-block;
               padding:8px 14px;
               background:linear-gradient(135deg,#1a1a2e,#333);
               color:white;
               border-radius:10px;
               font-size:12px;
               font-weight:800;
               text-decoration:none;
               transition:0.2s;
             "
             onmouseover="this.style.transform='translateY(-1px)'"
             onmouseout="this.style.transform='translateY(0)'">
            Voir
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