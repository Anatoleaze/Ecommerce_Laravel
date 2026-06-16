<template>
<div style="padding:10px 0;">
  <div style="width:100%;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
      <div>
        <h2 style="font-size:24px; font-weight:800; color:#1a1a2e; margin:0;">
          Mes commandes
        </h2>
        <p style="color:#777; font-size:13px; margin-top:6px; margin-bottom: 0;">
          Historique et suivi de vos commandes
        </p>
      </div>

      <div>
        <select 
          v-model="selectedPeriod"
          style="padding: 10px 16px; border-radius: 10px; border: 2px solid #eee; background: white; font-size: 14px; font-weight: 600; color: #1a1a2e; outline: none; cursor: pointer; transition: border-color 0.2s;"
          onfocus="this.style.borderColor='#1a1a2e'"
          onblur="this.style.borderColor='#eee'"
        >
          <option value="all">Toutes les commandes</option>
          <option value="3months">3 derniers mois</option>
          <option value="2026">Année 2026</option>
          <option value="2025">Année 2025</option>
          <option value="2024">Année 2024</option>
          <option value="2023">Année 2023</option>
          <option value="2022">Année 2022</option>
          <option value="2021">Année 2021</option>
          <option value="2020">Année 2020</option>
        </select>
      </div>
    </div>

    <div style="background:white; border-radius:16px; box-shadow:0 4px 15px rgba(0,0,0,0.06); overflow:hidden;">

      <div :style="`
        display:grid;
        grid-template-columns: ${gridColumns};
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
        <div v-if="user.role !== 'admin'">Montant</div>
        <div>Status</div>
        <div>Détail</div>
      </div>

      <div v-if="filteredOrders.length === 0"
           style="padding:40px; text-align:center; color:#aaa; font-size:14px;">
        📦 Aucune commande pour cette période
      </div>

      <div v-for="order in filteredOrders"
           :key="order.id"
           :style="`
             display:grid;
             grid-template-columns: ${gridColumns};
             padding:16px 24px;
             align-items:center;
             border-bottom:1px solid #f3f4f6;
             transition:background 0.2s;
           `"
           onmouseover="this.style.background='#fafafa'"
           onmouseout="this.style.background='white'">

        <div style="font-size:13px; color:#333; font-weight:600;">
          {{ formatDate(order.created_at) }}
        </div>

        <div style="font-size:12px; color:#1a1a2e; font-family:monospace; font-weight:700; word-break:break-all;">
          {{ order.numero_commande }}
        </div>

        <div v-if="user.role !== 'admin'"
             style="font-size:14px; font-weight:800; color:#1a1a2e;">
          {{ order.total }} €
        </div>

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

  data() {
    return {
      selectedPeriod: 'all' // Filtre sélectionné par défaut
    };
  },

  computed: {
    // Calcule dynamiquement la disposition de la grille selon le rôle
    gridColumns() {
      return this.user.role !== 'admin' 
        ? '1fr 2fr 1fr 1.5fr 1fr' 
        : '1fr 2fr 1.5fr 1fr';
    },

    // Filtre les commandes en fonction de la période choisie
    filteredOrders() {
      if (this.selectedPeriod === 'all') {
        return this.orders;
      }

      const now = new Date();

      return this.orders.filter(order => {
        const orderDate = new Date(order.created_at);

        if (this.selectedPeriod === '3months') {
          const threeMonthsAgo = new Date();
          threeMonthsAgo.setMonth(now.getMonth() - 3);
          return orderDate >= threeMonthsAgo && orderDate <= now;
        }

        // Sinon, c'est un filtrage par année (2020 à 2026)
        const targetYear = parseInt(this.selectedPeriod, 10);
        return orderDate.getFullYear() === targetYear;
      });
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