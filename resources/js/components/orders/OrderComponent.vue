<template>
  <div style="padding:10px 0; width: 100%;">
    <div style="width:100%;">

      <div
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; flex-wrap: wrap; gap: 16px; width: 100%;">
        <div>
          <h2 style="font-size:24px; font-weight:800; color:#1a1a2e; margin:0;">
            {{ user.role === 'admin' ? 'Gestion des commandes (Admin)' : 'Mes commandes' }}
          </h2>
          <p style="color:#777; font-size:13px; margin-top:6px; margin-bottom: 0;">
            {{ user.role === 'admin' ? 'Suivi logistique, filtrage et mises à jour' : 'Historique et suivi de vos commandes' }}
          </p>
        </div>

        <div v-if="user.role !== 'admin'">
          <select v-model="selectedPeriod"
            style="padding: 10px 16px; border-radius: 10px; border: 2px solid #eee; background: white; font-size: 14px; font-weight: 600; color: #1a1a2e; outline: none; cursor: pointer;">
            <option value="all">Toutes les commandes</option>
            <option value="3months">3 derniers mois</option>
            <option value="2026">Année 2026</option>
            <option value="2025">Année 2025</option>
          </select>
        </div>
      </div>

      <div v-if="user.role === 'admin'" style="display: flex; flex-direction: column; gap: 40px; width: 100%;">

        <div class="admin-section" style="width: 100%;">
          <div
            style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:8px;">
            <h3 style="font-size:16px; font-weight:800; color:#e67e22; margin:0;">{{ getTableHeaderText('payé', '💳 Commandes Payées(À préparer)') }}</h3>
            <input type="text" v-model="tablesState['payé'].search" placeholder="🔍 Rechercher un numéro..."
              style="padding:6px 12px; border-radius:8px; border:1px solid #ccc; font-size:13px; outline:none; width:220px;">
          </div>
          <div v-html="renderAdminTable('payé', 'expédié', '📦 Marquer Expédiée')"></div>
        </div>

        <div class="admin-section" style="width: 100%;">
          <div
            style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:8px;">
            <h3 style="font-size:16px; font-weight:800; color:#2980b9; margin:0;">{{ getTableHeaderText('expédié', '📦 Commandes Expédiées(En transit)') }}</h3>
            <input type="text" v-model="tablesState['expédié'].search" placeholder="🔍 Rechercher un numéro..."
              style="padding:6px 12px; border-radius:8px; border:1px solid #ccc; font-size:13px; outline:none; width:220px;">
          </div>
          <div v-html="renderAdminTable('expédié', 'en cours de livraison', '🚚 Mettre En cours de livraison')"></div>
        </div>

        <div class="admin-section" style="width: 100%;">
          <div
            style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:8px;">
            <h3 style="font-size:16px; font-weight:800; color:#8e44ad; margin:0;">{{ getTableHeaderText('en cours de livraison', '🚚 Commandes en Cours de Livraison') }}</h3>
            <input type="text" v-model="tablesState['en cours de livraison'].search"
              placeholder="🔍 Rechercher un numéro..."
              style="padding:6px 12px; border-radius:8px; border:1px solid #ccc; font-size:13px; outline:none; width:220px;">
          </div>
          <div v-html="renderAdminTable('en cours de livraison', 'livrée', '✅ Marquer Livrée')"></div>
        </div>

        <div class="admin-section" style="width: 100%;">
          <div
            style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:8px;">
            <h3 style="font-size:16px; font-weight:800; color:#27ae60; margin:0;">{{ getTableHeaderText('livrée', '✅ Commandes Livrées') }}</h3>
            <input type="text" v-model="tablesState['livrée'].search" placeholder="🔍 Rechercher un numéro..."
              style="padding:6px 12px; border-radius:8px; border:1px solid #ccc; font-size:13px; outline:none; width:220px;">
          </div>
          <div v-html="renderAdminTable('livrée')"></div>
        </div>

        <div class="admin-section" style="width: 100%;">
          <div
            style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:8px;">
            <h3 style="font-size:16px; font-weight:800; color:#7f8c8d; margin:0;">{{ getTableHeaderText('remboursé', '💰 Commandes Remboursées') }}</h3>
            <input type="text" v-model="tablesState['remboursé'].search" placeholder="🔍 Rechercher un numéro..."
              style="padding:6px 12px; border-radius:8px; border:1px solid #ccc; font-size:13px; outline:none; width:220px;">
          </div>
          <div v-html="renderAdminTable('remboursé')"></div>
        </div>

      </div>

      <div v-else
        style="background:white; border-radius:16px; box-shadow:0 4px 15px rgba(0,0,0,0.06); overflow:hidden; width: 100%;">
        <div
          :style="`display:grid; grid-template-columns: ${gridColumns}; padding:16px 24px; background:#1a1a2e; color:white; font-size:12px; font-weight:800; text-transform:uppercase;`">
          <div>Date</div>
          <div>Tracking</div>
          <div>Montant</div>
          <div>Status</div>
          <div>Détail</div>
        </div>

        <div v-if="filteredOrders.length === 0" style="padding:40px; text-align:center; color:#aaa; font-size:14px;">
          📦 Aucune commande pour cette période
        </div>

        <div v-for="order in filteredOrders" :key="order.id"
          :style="`display:grid; grid-template-columns: ${gridColumns}; padding:16px 24px; align-items:center; border-bottom:1px solid #f3f4f6;`">
          <div style="font-size:13px; color:#333; font-weight:600;">{{ formatDate(order.created_at) }}</div>
          <div style="font-size:12px; color:#1a1a2e; font-family:monospace; font-weight:700;">{{ order.numero_commande
            }}</div>
          <div style="font-size:14px; font-weight:800; color:#1a1a2e;">{{ order.total }} €</div>
          <div>
            <span :style="getSpanStyle(order.statut)">
              {{ order.statut }}
            </span>
          </div>
          <div>
            <a :href="`/commandes/details/${order.id}`"
              style="display:inline-flex; align-items:center; padding:8px 16px; background:#1a1a2e; color:white; border-radius:8px; font-size:12px; font-weight:700; text-decoration:none;">👁️
              Voir</a>
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
      selectedPeriod: 'all',
      localOrders: [...this.orders],
      perPage: 5, // Nombre d'éléments affichés par page

      // Centralisation de l'état de recherche et pagination pour chaque tableau admin
      tablesState: {
        'payé': { search: '', page: 1 },
        'expédié': { search: '', page: 1 },
        'en cours de livraison': { search: '', page: 1 },
        'livrée': { search: '', page: 1 },
        'remboursé': { search: '', page: 1 }
      }
    };
  },

  watch: {
    orders(newOrders) {
      this.localOrders = [...newOrders];
    }
  },

  computed: {
    gridColumns() {
      return '1fr 2fr 1fr 1.5fr 1fr';
    },

    filteredOrders() {
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
    formatDate(date) {
      return new Intl.DateTimeFormat("fr-FR", { day: "2-digit", month: "2-digit", year: "numeric" }).format(new Date(date));
    },

    getSpanStyle(statut) {
      const colors = this.getStatusColor(statut);
      return {
        display: 'inline-block', padding: '5px 12px', borderRadius: '999px', fontSize: '11px', fontWeight: '800', background: colors.bg, color: colors.text
      };
    },

    getStatusColor(statut) {
      const map = {
        'payé': { bg: '#e8f8f5', text: '#1e8449' },
        'expédié': { bg: '#e8f4fd', text: '#2980b9' },
        'en cours de livraison': { bg: '#f4ecf7', text: '#8e44ad' },
        'livrée': { bg: '#d4efdf', text: '#196f3d' },
        'remboursé': { bg: '#f2f4f4', text: '#7f8c8d' },
      };
      return map[statut] || { bg: '#f0f0f0', text: '#555' };
    },

    // Permet d'afficher à côté du titre le décompte (ex: "3/14") filtré vs total
    getTableHeaderText(status, baseTitle) {
      const allForStatus = this.localOrders.filter(order => order.statut === status);
      const search = this.tablesState[status].search.trim().toLowerCase();

      if (!search) return `${baseTitle} (${allForStatus.length})`;

      const filteredCount = allForStatus.filter(o => o.numero_commande.toLowerCase().includes(search)).length;
      return `${baseTitle} (${filteredCount}/${allForStatus.length})`;
    },

    // Changer de page depuis le bouton injecté en v-html
    changePage(status, newPage) {
      if (this.tablesState[status]) {
        this.tablesState[status].page = newPage;
      }
    },

    async updateStatus(orderId, nextStatus) { // On garde nextStatus ici juste pour la mise à jour réactive locale si ça fonctionne
      try {
        const response = await fetch(`/api/orders/${orderId}/status`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
          }
          // Plus de "body: JSON.stringify(...)" ici !
        });

        const result = await response.json();

        if (result.success) {
          // Le serveur renvoie le nouveau statut exact calculé par Laravel
          const index = this.localOrders.findIndex(o => o.id === orderId);
          if (index !== -1) {
            this.localOrders[index].statut = result.status;
          }
        } else {
          alert(result.message || "Erreur lors du changement de statut");
        }
      } catch (error) {
        console.error("Erreur API :", error);
        alert("Impossible de contacter le serveur.");
      }
    },

    // Générateur dynamique de tableau avec Recherche et Pagination intégrées
    renderAdminTable(status, nextStatus = null, buttonText = '') {
      // 1. Filtrer par statut de base
      let baseList = this.localOrders.filter(order => order.statut === status);

      // 2. Appliquer la recherche (si saisie)
      const query = this.tablesState[status].search.trim().toLowerCase();
      if (query) {
        baseList = baseList.filter(order =>
          order.numero_commande.toLowerCase().includes(query)
        );
      }

      if (baseList.length === 0) {
        return `<div style="padding:20px; background:white; border-radius:12px; text-align:center; color:#999; font-size:13px; border: 1px dashed #ccc; width: 100%; box-sizing: border-box;">Aucune commande trouvée</div>`;
      }

      // 3. Appliquer la pagination logique
      const totalItems = baseList.length;
      const totalPages = Math.ceil(totalItems / this.perPage);

      // Sécurité : Si la page courante dépasse à la suite d'un filtre ou d'une action, on la réajuste
      if (this.tablesState[status].page > totalPages) {
        this.tablesState[status].page = 1;
      }

      const currentPage = this.tablesState[status].page;
      const startIndex = (currentPage - 1) * this.perPage;
      const paginatedList = baseList.slice(startIndex, startIndex + this.perPage);

      // 4. Générer les lignes HTML
      let rows = paginatedList.map(order => {
        let actionColumn = '';
        if (nextStatus) {
          actionColumn = `<div>
            <button onclick="window.vueOrderComponent.updateStatus(${order.id}, '${nextStatus}')" 
                    style="padding:6px 12px; background:#1a1a2e; color:white; border:none; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer;">
              ${buttonText}
            </button>
          </div>`;
        } else {
          actionColumn = `<div style="color:#aaa; font-size:12px; font-weight:600;">Aucune action requise</div>`;
        }

        return `
          <div style="display:grid; grid-template-columns: 1fr 1.5fr 1fr 1.5fr 1fr; padding:14px 20px; align-items:center; background:white; border-bottom:1px solid #f3f4f6;">
            <div style="font-size:13px; font-weight:600; color:#333;">${this.formatDate(order.created_at)}</div>
            <div style="font-size:12px; font-family:monospace; font-weight:700; color:#1a1a2e;">${order.numero_commande}</div>
            <div style="font-size:14px; font-weight:800; color:#1a1a2e;">${order.total} €</div>
            ${actionColumn}
            <div>
              <a href="/commandes/details/${order.id}" style="display:inline-block; padding:6px 12px; border:1px solid #1a1a2e; color:#1a1a2e; border-radius:6px; font-size:11px; font-weight:700; text-decoration:none;">👁️ Détails</a>
            </div>
          </div>
        `;
      }).join('');

      // 5. Générer la barre de pagination HTML (uniquement si plusieurs pages)
      let paginationHTML = '';
      if (totalPages > 1) {
        let buttons = '';
        for (let i = 1; i <= totalPages; i++) {
          const isActive = i === currentPage;
          buttons += `
            <button onclick="window.vueOrderComponent.changePage('${status}', ${i})"
                    style="padding: 4px 10px; margin: 0 3px; border-radius: 6px; border: 1px solid #1a1a2e; font-size:11px; font-weight:700; cursor:pointer;
                    background: ${isActive ? '#1a1a2e' : 'white'}; color: ${isActive ? 'white' : '#1a1a2e'};">
              ${i}
            </button>
          `;
        }
        paginationHTML = `
          <div style="display:flex; justify-content:center; align-items:center; padding:12px; background:#fafafa; border-top:1px solid #eee;">
            <span style="font-size:12px; color:#666; margin-right:10px;">Page ${currentPage} sur ${totalPages}</span>
            <div style="display:flex;">${buttons}</div>
          </div>
        `;
      }

      // 6. Assembler le tout
      return `
        <div style="background:white; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.03); overflow:hidden; border: 1px solid #eee; width: 100%;">
          <div style="display:grid; grid-template-columns: 1fr 1.5fr 1fr 1.5fr 1fr; padding:14px 20px; background:#f8f9fa; color:#555; font-size:11px; font-weight:800; text-transform:uppercase; border-bottom:1px solid #eee;">
            <div>Date</div><div>Numéro</div><div>Montant</div><div>Action logistique</div><div>Lien</div>
          </div>
          ${rows}
          ${paginationHTML}
        </div>
      `;
    }
  },

  created() {
    window.vueOrderComponent = this;
  }
}
</script>