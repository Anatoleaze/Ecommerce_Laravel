<template>
  <div style="padding:10px 0; width:100%;">

    <div
      style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px; flex-wrap:wrap; gap:16px;">
      <div>
        <h2 style="font-size:24px; font-weight:800; color:#1a1a2e; margin:0;">
          {{ user.role === 'admin' ? '🗂️ Gestion des commandes' : '📦 Mes commandes' }}
        </h2>
        <p style="color:#777; font-size:13px; margin-top:6px; margin-bottom:0;">
          {{ user.role === 'admin' ? 'Suivi logistique et mises à jour' : 'Historique et suivi de vos commandes' }}
        </p>
      </div>
      <div v-if="user.role !== 'admin'">
        <select v-model="selectedPeriod"
          style="padding:10px 16px; border-radius:10px; border:2px solid #eee; background:white; font-size:14px; font-weight:600; color:#1a1a2e; outline:none; cursor:pointer;">
          <option value="all">Toutes les commandes</option>
          <option value="3months">3 derniers mois</option>
          <option value="2026">Année 2026</option>
          <option value="2025">Année 2025</option>
        </select>
      </div>
    </div>

    <div style="display:flex; flex-direction:column; gap:40px;">

      <order-table title="💳 Commandes Payées" title-color="#e67e22" :orders="getOrdersByStatus('paye')"
        next-status="expedie" button-text="📦 Marquer Expédiée" :per-page="perPage" @update-status="updateStatus" />

      <order-table title="📦 Commandes Expédiées" title-color="#2980b9" :orders="getOrdersByStatus('expedie')"
        next-status="livraison" button-text="🚚 Mettre en Livraison" :per-page="perPage"
        @update-status="updateStatus" />

      <order-table title="🚚 En cours de livraison" title-color="#8e44ad" :orders="getOrdersByStatus('livraison')"
        next-status="livre" button-text="✅ Marquer Livrée" :per-page="perPage"
        @update-status="updateStatus" />

      <order-table title="✅ Commandes Livrées" title-color="#27ae60" :orders="getOrdersByStatus('livre')"
        :per-page="perPage" @update-status="updateStatus" />

      <order-table v-if="user.role === 'admin'" title="💰 Commandes Remboursées" title-color="#7f8c8d"
        :orders="getOrdersByStatus('rembourse')" :per-page="perPage" @update-status="updateStatus" />

    </div>

  </div>
</template>

<script>
const OrderTable = {
  name: 'OrderTable',
  props: {
    title: String,
    titleColor: { type: String, default: '#333' },
    orders: { type: Array, default: () => [] },
    nextStatus: { type: String, default: null },
    buttonText: { type: String, default: '' },
    perPage: { type: Number, default: 5 },
  },
  emits: ['update-status'],
  data() {
    return {
      search: '',
      currentPage: 1,
    };
  },
  computed: {
    filteredOrders() {
      const q = this.search.trim().toLowerCase();
      if (!q) return this.orders;
      return this.orders.filter(o => o.numero_commande.toLowerCase().includes(q));
    },
    totalPages() {
      return Math.max(1, Math.ceil(this.filteredOrders.length / this.perPage));
    },
    paginatedOrders() {
      const start = (this.currentPage - 1) * this.perPage;
      return this.filteredOrders.slice(start, start + this.perPage);
    },
    headerText() {
      const q = this.search.trim();
      if (!q) return `${this.title} (${this.orders.length})`;
      return `${this.title} (${this.filteredOrders.length}/${this.orders.length})`;
    }
  },
  watch: {
    search() {
      this.currentPage = 1;
    },
    orders() {
      this.currentPage = 1;
    }
  },
  methods: {
    changePage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
      }
    },
    
    formatDate(date) {
      return new Intl.DateTimeFormat("fr-FR", { day: "2-digit", month: "2-digit", year: "numeric" }).format(new Date(date));
    },
    getStatusLabel(statut) {
      // Permet d'afficher un joli texte avec accents aux utilisateurs, même si la BDD stocke sans accent
      const labels = {
        'paye': 'Payée',
        'expedie': 'Expédiée',
        'livraison': 'En cours de livraison',
        'livre': 'Livrée',
        'rembourse': 'Remboursée'
      };
      return labels[statut] || statut;
    },
    getStatusColor(statut) {
      const map = {
        'paye': { bg: '#e8f8f5', text: '#1e8449' },
        'expedie': { bg: '#e8f4fd', text: '#2980b9' },
        'livraison': { bg: '#f4ecf7', text: '#8e44ad' },
        'livre': { bg: '#d4efdf', text: '#196f3d' },
        'rembourse': { bg: '#f2f4f4', text: '#7f8c8d' },
      };
      return map[statut] || { bg: '#f0f0f0', text: '#555' };
    },
  },
  template: `
    <div style="width:100%;">

      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:8px;">
        <h3 :style="\`font-size:16px; font-weight:800; color:\${titleColor}; margin:0;\`">
          {{ headerText }}
        </h3>
        <input
          type="text"
          v-model="search"
          placeholder="🔍 Rechercher un numéro..."
          style="padding:8px 14px; border-radius:8px; border:2px solid #eee; font-size:13px; outline:none; width:240px; transition:border-color 0.2s;"
          onfocus="this.style.borderColor='#6c63ff'"
          onblur="this.style.borderColor='#eee'">
      </div>

      <div style="background:white; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.05); overflow:hidden; border:1px solid #eee;">

        <div style="display:grid; grid-template-columns:1fr 1.8fr 1fr 1.8fr 1fr; padding:14px 20px; background:#1a1a2e; color:white; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:1px;">
          <div>Date</div>
          <div>Numéro</div>
          <div>Montant</div>
          <div>{{ nextStatus ? 'Action' : 'Statut' }}</div>
          <div>Détail</div>
        </div>

        <div v-if="paginatedOrders.length === 0"
          style="padding:30px; text-align:center; color:#aaa; font-size:14px; font-style:italic;">
          📭 Aucune commande trouvée
        </div>

        <div v-for="order in paginatedOrders" :key="order.id"
          style="display:grid; grid-template-columns:1fr 1.8fr 1fr 1.8fr 1fr; padding:14px 20px; align-items:center; border-bottom:1px solid #f3f4f6; transition:background 0.15s;"
          onmouseover="this.style.background='#fafafa'"
          onmouseout="this.style.background='white'">

          <div style="font-size:13px; font-weight:600; color:#333;">
            {{ formatDate(order.created_at) }}
          </div>

          <div style="font-size:12px; font-family:monospace; font-weight:700; color:#1a1a2e; word-break:break-all;">
            {{ order.numero_commande }}
          </div>

          <div style="font-size:14px; font-weight:800; color:#1a1a2e;">
            {{ order.total }} €
          </div>

          <div>
            <button 
              v-if="nextStatus" 
              @click="$emit('update-status', order.id, nextStatus)"
              style="padding:6px 12px; background:#1a1a2e; color:white; border:none; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer;"
            >
              {{ buttonText }}
            </button>
            <span v-else
              :style="\`display:inline-block; padding:5px 12px; border-radius:999px; font-size:11px; font-weight:800; background:\${getStatusColor(order.statut).bg}; color:\${getStatusColor(order.statut).text};\`">
              {{ getStatusLabel(order.statut) }}
            </span>
          </div>

          <div>
            <a :href="\`/commandes/details/\${order.id}\`"
              style="display:inline-flex; align-items:center; gap:4px; padding:7px 14px; border:2px solid #1a1a2e; color:#1a1a2e; border-radius:8px; font-size:11px; font-weight:700; text-decoration:none; transition:all 0.2s;"
              onmouseover="this.style.background='#1a1a2e'; this.style.color='white'"
              onmouseout="this.style.background='transparent'; this.style.color='#1a1a2e'">
              👁️ Voir
            </a>
          </div>

        </div>

        <div v-if="totalPages > 1"
          style="display:flex; justify-content:center; align-items:center; gap:8px; padding:14px; background:#fafafa; border-top:1px solid #eee; flex-wrap:wrap;">
          <span style="font-size:12px; color:#888; margin-right:4px;">
            Page {{ currentPage }} / {{ totalPages }}
          </span>
          <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1"
            style="width:32px; height:32px; border-radius:8px; border:1px solid #ddd; background:white; cursor:pointer; font-size:14px; display:flex; align-items:center; justify-content:center;"
            :style="currentPage === 1 ? 'opacity:0.4; cursor:not-allowed;' : ''">
            ‹
          </button>
          <button v-for="page in totalPages" :key="page" @click="changePage(page)"
            :style="\`width:32px; height:32px; border-radius:8px; border:none; cursor:pointer; font-size:13px; font-weight:700; display:flex; align-items:center; justify-content:center; background:\${page === currentPage ? '#1a1a2e' : '#f3f4f6'}; color:\${page === currentPage ? 'white' : '#555'};\`">
            {{ page }}
          </button>
          <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages"
            style="width:32px; height:32px; border-radius:8px; border:1px solid #ddd; background:white; cursor:pointer; font-size:14px; display:flex; align-items:center; justify-content:center;"
            :style="currentPage === totalPages ? 'opacity:0.4; cursor:not-allowed;' : ''">
            ›
          </button>
        </div>

      </div>
    </div>
  `
};

export default {
  name: 'OrderComponent',
  components: { OrderTable },

  props: {
    orders: { type: Array, required: true },
    user: { type: Object, required: true }
  },

  data() {
    return {
      selectedPeriod: 'all',
      localOrders: [...this.orders],
      perPage: 5,
    };
  },

  watch: {
    orders(newOrders) {
      this.localOrders = [...newOrders];
    }
  },

  computed: {
    filteredByPeriod() {
      if (this.selectedPeriod === 'all') return this.localOrders;
      const now = new Date();
      return this.localOrders.filter(order => {
        const orderDate = new Date(order.created_at);
        if (this.selectedPeriod === '3months') {
          const threeMonthsAgo = new Date();
          threeMonthsAgo.setMonth(now.getMonth() - 3);
          return orderDate >= threeMonthsAgo;
        }
        return orderDate.getFullYear() === parseInt(this.selectedPeriod, 10);
      });
    }
  },

  methods: {
    getOrdersByStatus(status) {
      return this.filteredByPeriod.filter(o => o.statut === status);
    },

    async updateStatus(orderId, nextStatus) {
      try {
        const response = await fetch(`/commande/update_status/${orderId}`, {
          method: 'PATCH',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
          },
          body: JSON.stringify({ status: nextStatus })
        });

        const result = await response.json();

        if (response.ok && result.success) {
          const index = this.localOrders.findIndex(o => o.id === orderId);
          if (index !== -1) {
            this.localOrders[index].statut = nextStatus;
          }
        } else {
          alert(result.message || "Erreur lors du changement de statut");
        }
      } catch (error) {
        console.error("Erreur API :", error);
        alert("Impossible de contacter le serveur.");
      }
    },
  }
};
</script>