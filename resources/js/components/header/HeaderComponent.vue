<template>
  <header class="header-v2">

    <!-- Header Desktop -->
    <div class="header-desktop">
      <div class="header-inner">

        <!-- Logo -->
        <a :href="homeLink" class="header-logo">
          <img :src="logo" alt="Logo">
        </a>

        <!-- Navigation -->
        <nav class="header-nav">
          <a :href="homeLink" class="nav-link-item">Accueil</a>
          <a :href="catalogLink" class="nav-link-item">Catalogue</a>
          <a :href="contactLink" class="nav-link-item">À propos</a>
        </nav>

        <!-- Actions -->
        <div class="header-actions">

          <!-- Recherche -->
          <button class="action-btn" @click="showSearchModal" title="Rechercher">
            <i class="zmdi zmdi-search"></i>
          </button>

          <!-- Panier -->
          <a :href="cartLink" class="action-btn cart-btn">
            <i class="zmdi zmdi-shopping-cart"></i>
            <span v-if="cartItemCount > 0" class="cart-badge">{{ cartItemCount }}</span>
          </a>

          <!-- Utilisateur non connecté -->
          <template v-if="!isAuthenticated">
            <a :href="login" class="btn-auth btn-login">Connexion</a>
            <a v-if="register" :href="register" class="btn-auth btn-register">Inscription</a>
          </template>

          <!-- Utilisateur connecté -->
          <template v-else>
            <div class="user-dropdown">
              <button class="user-btn" @click.prevent="toggleUserDropdown">
                <div class="user-avatar">{{ headerUser.name ? headerUser.name[0].toUpperCase() : '?' }}</div>
                <span class="user-name">{{ headerUser.name }}</span>
                <i :class="['zmdi', isUserDropdownOpen ? 'zmdi-chevron-up' : 'zmdi-chevron-down']"></i>
              </button>

              <div v-if="isUserDropdownOpen" class="dropdown-menu-custom">
                <a class="dropdown-item-custom" :href="profile">
                  <i class="zmdi zmdi-account"></i> Mon profil
                </a>
                <a v-if="headerUser.role != 'admin'" class="dropdown-item-custom" :href="orders">
                  <i class="zmdi zmdi-receipt"></i> Mes commandes
                </a>
                <template v-if="headerUser.role == 'admin'">
                  <div class="dropdown-divider-custom"></div>
                  <span class="dropdown-label">Administration</span>
                  <a class="dropdown-item-custom" :href="adminProducts">
                    <i class="zmdi zmdi-collection-item"></i> Liste des produits
                  </a>
                  <a class="dropdown-item-custom" :href="adminOrderShow">
                    <i class="zmdi zmdi-assignment"></i> Liste des commandes
                  </a>
                </template>
                <div class="dropdown-divider-custom"></div>
                <a class="dropdown-item-custom logout-item" href="#" @click.prevent="logoutUser">
                  <i class="zmdi zmdi-power"></i> Déconnexion
                </a>
              </div>
            </div>
          </template>

        </div>
      </div>
    </div>

    <!-- Header Mobile -->
    <div class="header-mobile">
      <a :href="homeLink" class="header-logo">
        <img :src="logo" alt="Logo">
      </a>

      <div class="mobile-actions">
        <button class="action-btn" @click="showSearchModal">
          <i class="zmdi zmdi-search"></i>
        </button>
        <a :href="cartLink" class="action-btn cart-btn">
          <i class="zmdi zmdi-shopping-cart"></i>
          <span v-if="cartItemCount > 0" class="cart-badge">{{ cartItemCount }}</span>
        </a>
        <button class="action-btn hamburger-btn" @click="toggleMobileMenu">
          <i :class="['zmdi', isMobileMenuOpen ? 'zmdi-close' : 'zmdi-menu']"></i>
        </button>
      </div>
    </div>

    <!-- Menu Mobile -->
    <div v-if="isMobileMenuOpen" class="mobile-menu">
      <a :href="homeLink" class="mobile-menu-item">🏠 Accueil</a>
      <a :href="catalogLink" class="mobile-menu-item">🛍️ Catalogue</a>
      <a :href="contactLink" class="mobile-menu-item">📞 À propos</a>

      <div class="mobile-menu-divider"></div>

      <template v-if="!isAuthenticated">
        <a :href="login" class="mobile-menu-item">🔑 Connexion</a>
        <a v-if="register" :href="register" class="mobile-menu-item">📝 Inscription</a>
      </template>
      <template v-else>
        <a :href="profile" class="mobile-menu-item">👤 Mon profil</a>
        <a v-if="headerUser.role != 'admin'" :href="orders" class="mobile-menu-item">📦 Mes commandes</a>
        <template v-if="headerUser.role == 'admin'">
          <a :href="adminProducts" class="mobile-menu-item">🗂️ Liste des produits</a>
          <a :href="adminOrderShow" class="mobile-menu-item">📋 Liste des commandes</a>
        </template>
        <a href="#" class="mobile-menu-item logout-mobile" @click.prevent="logoutUser">🚪 Déconnexion</a>
      </template>
    </div>

    <!-- Modal Recherche -->
    <div v-if="isSearchModalVisible" class="search-modal" @click.self="hideSearchModal">
      <div class="search-modal-content">
        <button class="search-close-btn" @click="hideSearchModal">
          <i class="zmdi zmdi-close"></i>
        </button>
        <form class="search-form" method="GET" :action="catalogLink">
          <i class="zmdi zmdi-search search-icon"></i>
          <input type="text" name="search" placeholder="Rechercher un produit..." v-model="searchQuery" autofocus>
          <button type="submit" class="search-submit-btn">Rechercher</button>
        </form>
      </div>
    </div>

  </header>
</template>
  
  <script>
  import { mapGetters, mapActions } from 'vuex';
  import axios from 'axios';

  export default {
    name: 'HeaderComponent',

    data() {
        return {
            isSearchModalVisible: false,
            searchQuery: "",
            isUserDropdownOpen: false,
        isMobileMenuOpen: false,
        };
    },

    props:{ 
        homeLink: {
            type: String,
            required: true,
        },
        
        logo: {
            type: String,
            required: true
        },

        catalogLink:{
            type: String,
            required: true
        },

        cartLink:{
            type: String,
            required: true
        },

        contactLink:{
            type: String,
            required: true
        },

        adminOrderShow:{
            type: String,
            required: true
        },

        isAuthenticated: {
            type: [Boolean, Object],
            default: false
        },

        user: {
            type: Object,
            required: false,
            default: () => ({})
        },

        login: {
            type: String,
            required: true
        },

        register: {
            type: String,
            required: false,
            default: ''
        },
        
        profile: {
            type: String,
            required: true
        },
        
        orders: {
            type: String,
            required: true
        },
        
        adminProducts: {
            type: String,
            required: true
        },
        
        logout: {
            type: String,
            required: true
        },

        logoClose: {
            type: String,
            required: true
        },

        csrfToken: {
            type: String,
            required: false,
            default: ''
        },

    }, 

    computed: {
        cartItemCount() {
            return this.$store.getters.cartItemCount;
        },
        headerUser() {
            return this.$store.state.user || this.user || {};
        }
    },

    methods: {
        ...mapActions(['toggleCart']),
        
        logoutUser() {
            axios.post(this.logout, {}, {
                headers: { 'X-CSRF-TOKEN': this.csrfToken }
            })
            .then(() => {
                window.location.href = this.homeLink; // Redirection après logout
            })
            .catch(error => console.error('Erreur lors du logout:', error));
        },

        showSearchModal() {
            this.isSearchModalVisible = true;  
        },

        toggleUserDropdown() {
            this.isUserDropdownOpen = !this.isUserDropdownOpen;
        },
    
        hideSearchModal() {
            this.isSearchModalVisible = false;
            this.isUserDropdownOpen = false;
        },
  
        toggleMobileMenu() {
    this.isMobileMenuOpen = !this.isMobileMenuOpen;
},

        ...mapActions(['fetchCartCount', 'fetchCart']), // Load cart in starting state
            

    },

    mounted() {
        if(this.isAuthenticated){
            this.fetchCartCount();
            this.fetchCart();
        }

        if (this.isAuthenticated && this.user && Object.keys(this.user).length) {
            this.$store.commit('SET_USER', this.user);
        }
    }

  };
  </script>
  
 <style scoped>
/* ===== HEADER DESKTOP ===== */
.header-desktop {
  display: flex;
  align-items: center;
  padding: 0 40px;
  height: 70px;
  background: white;
  box-shadow: 0 2px 10px rgba(0,0,0,0.08);
  position: sticky;
  top: 0;
  z-index: 1000;
}

.header-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  max-width: 1400px;
  margin: 0 auto;
}

.header-logo img {
  height: 40px;
  object-fit: contain;
}

.header-nav {
  display: flex;
  gap: 30px;
}

.nav-link-item {
  color: #333;
  text-decoration: none;
  font-size: 14px;
  font-weight: 600;
  letter-spacing: 0.5px;
  padding: 5px 0;
  border-bottom: 2px solid transparent;
  transition: all 0.2s;
}

.nav-link-item:hover {
  color: #6c63ff;
  border-bottom-color: #6c63ff;
}

.header-actions {
  display: flex;
  align-items: center;
  gap: 12px;
}

.action-btn {
  background: none;
  border: none;
  cursor: pointer;
  padding: 8px;
  border-radius: 50%;
  color: #333;
  font-size: 20px;
  transition: all 0.2s;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
}

.action-btn:hover {
  background: #f5f5f5;
  color: #6c63ff;
}

.cart-badge {
  position: absolute;
  top: -4px;
  right: -4px;
  background: #e74c3c;
  color: white;
  border-radius: 50%;
  width: 18px;
  height: 18px;
  font-size: 11px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
}

.btn-auth {
  padding: 8px 16px;
  border-radius: 25px;
  font-size: 13px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.2s;
}

.btn-login {
  border: 2px solid #333;
  color: #333;
  background: white;
}

.btn-login:hover {
  background: #333;
  color: white;
}

.btn-register {
  background: #333;
  color: white;
  border: 2px solid #333;
}

.btn-register:hover {
  background: #555;
}

/* ===== DROPDOWN USER ===== */
.user-dropdown {
  position: relative;
}

.user-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  background: none;
  border: 2px solid #eee;
  border-radius: 25px;
  padding: 6px 14px;
  cursor: pointer;
  transition: all 0.2s;
  color: #333;
}

.user-btn:hover {
  border-color: #333;
}

.user-avatar {
  width: 28px;
  height: 28px;
  background: #333;
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 13px;
  font-weight: bold;
}

.user-name {
  font-size: 13px;
  font-weight: 600;
}

.dropdown-menu-custom {
  position: absolute;
  right: 0;
  top: calc(100% + 8px);
  background: white;
  border-radius: 12px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.12);
  padding: 8px;
  min-width: 200px;
  z-index: 9999;
}

.dropdown-item-custom {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 14px;
  border-radius: 8px;
  color: #333;
  text-decoration: none;
  font-size: 14px;
  transition: background 0.15s;
}

.dropdown-item-custom:hover {
  background: #f5f5f5;
  color: #6c63ff;
}

.dropdown-divider-custom {
  height: 1px;
  background: #eee;
  margin: 6px 0;
}

.dropdown-label {
  font-size: 11px;
  color: #aaa;
  padding: 4px 14px;
  text-transform: uppercase;
  letter-spacing: 1px;
  display: block;
}

.logout-item {
  color: #e74c3c !important;
}

.logout-item:hover {
  background: #fef0f0 !important;
}

/* ===== HEADER MOBILE ===== */
.header-mobile {
  display: none;
  align-items: center;
  justify-content: space-between;
  padding: 0 20px;
  height: 60px;
  background: white;
  box-shadow: 0 2px 10px rgba(0,0,0,0.08);
  position: sticky;
  top: 0;
  z-index: 1000;
}

.mobile-actions {
  display: flex;
  align-items: center;
  gap: 4px;
}

.mobile-menu {
  position: fixed;
  top: 60px;
  left: 0;
  right: 0;
  bottom: 0;
  background: white;
  z-index: 999;
  padding: 20px;
  overflow-y: auto;
}

.mobile-menu-item {
  display: block;
  padding: 14px 16px;
  color: #333;
  text-decoration: none;
  font-size: 16px;
  font-weight: 500;
  border-radius: 8px;
  transition: background 0.15s;
}

.mobile-menu-item:hover {
  background: #f5f5f5;
}

.mobile-menu-divider {
  height: 1px;
  background: #eee;
  margin: 10px 0;
}

.logout-mobile {
  color: #e74c3c;
}

/* ===== MODAL RECHERCHE ===== */
.search-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.7);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
}

.search-modal-content {
  background: white;
  border-radius: 16px;
  padding: 30px;
  width: 90%;
  max-width: 550px;
  position: relative;
}

.search-close-btn {
  position: absolute;
  top: 15px;
  right: 15px;
  background: #f5f5f5;
  border: none;
  border-radius: 50%;
  width: 32px;
  height: 32px;
  cursor: pointer;
  font-size: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.search-form {
  display: flex;
  align-items: center;
  gap: 10px;
  border: 2px solid #eee;
  border-radius: 12px;
  padding: 10px 15px;
  margin-top: 10px;
}

.search-icon {
  font-size: 20px;
  color: #aaa;
}

.search-form input {
  flex: 1;
  border: none;
  outline: none;
  font-size: 16px;
  color: #333;
}

.search-submit-btn {
  background: #333;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 8px 16px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 600;
  transition: background 0.2s;
}

.search-submit-btn:hover {
  background: #555;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
  .header-desktop {
    display: none;
  }
  .header-mobile {
    display: flex;
  }
}
</style>