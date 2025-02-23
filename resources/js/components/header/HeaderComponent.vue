<template>
   <header class="header-v2">
		<!-- Header desktop -->
		<div class="container-menu-desktop trans-03">
			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop p-l-45">
					
					<!-- Logo desktop -->		
					<a :href=homeLink class="logo">
						<img :src=logo alt="IMG-LOGO">
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li class="active-menu">
								<a :href="homeLink">Accueil</a>
							</li>

							<li>
								<a :href="catalogLink">Catalogue</a>
							</li>

							<li>
								<a :href="contactLink">A propos</a>
							</li>
						</ul>
					</div>	

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m h-full">
						<div class="flex-c-m h-full p-r-24">
							<div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-modal-search" @click="showSearchModal">
								<i class="zmdi zmdi-search"></i>
							</div>
						</div>
							
						<div class="flex-c-m h-full p-l-18 p-r-25 bor5">
                            <a :href="cartLink">
                                <div v-if="cartItemCount > 0" class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" :data-notify="cartItemCount">
                                    <i class="zmdi zmdi-shopping-cart"></i>
                                </div>	
                                <div v-else class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11">
                                    <i class="zmdi zmdi-shopping-cart"></i>
                                </div>
                            </a>
						</div>

						<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
							<div class="container">
								
								<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
									<span class="navbar-toggler-icon"></span>
								</button>
				
								<div class="collapse navbar-collapse" id="navbarSupportedContent">
			
									<!-- Right Side Of Navbar -->
									<ul class="navbar-nav ml-auto">
										<!-- Authentication Links -->
										<template v-if="!isAuthenticated">
                                            <li>
                                               <a class="nav-link" :href="login">Connexion</a>
                                            </li>

                                            <li v-if="register">
                                                <a class="nav-link" :href="register">Inscription</a>
                                            </li>
                                        </template>
										<template v-else>
                                            <li class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                {{ user.name }} <span class="caret"></span>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" :href="profile">Mon profil</a>
                                                <a v-if="user.role != 'admin'" class="dropdown-item" :href="orders">Mes commandes</a>


                                                <a v-if="user.role = 'admin'" class="dropdown-item" :href="adminProducts">
                                                Liste des produits
                                                </a>
                                                <a v-if="user.role = 'admin'" class="dropdown-item" :href="adminOrderShow">
                                                Liste des commandes
                                                </a>

                                                <a class="dropdown-item" href="#" @click.prevent="logoutUser">
                                                Déconnexion
                                                </a>

                                            </div>
                                            </li>
                                        </template>
									</ul>
								</div>
							</div>
						</nav>
					
					</div>
				</nav>
			</div>	
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->		
			<div class="logo-mobile">
				<a :href=homeLink><img :src=logo alt="IMG-LOGO"></a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m h-full m-r-15">
				<div class="flex-c-m h-full p-r-10">
					<div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-modal-search" @click="showSearchModal">
						<i class="zmdi zmdi-search"></i>
					</div>
				</div>

				<div class="flex-c-m h-full p-l-18 p-r-25 bor5">
                    <a :href="cartLink">
                        <div v-if="cartItemCount > 0" class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" :data-notify="cartItemCount">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>	
                        
                        <div v-else class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>
                    </a>

				</div>

			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="main-menu-m">

				<li>
					<a :href=homeLink>Accueil</a>
				</li>

				<li>
					<a :href=catalogLink>Catalogue</a>
				</li>

				<li>
					<a :href=contactLink >A propos</a>
				</li>

                <template v-if="!isAuthenticated">
                    <li class="nav-item" style="border-right: 1px solid black;">
                        <a class="nav-link" :href="login">Connexion</a>
                    </li>
                    <li v-if="register" class="nav-item">
                        <a class="nav-link" :href="register">Inscription</a>
                    </li>
                </template>
                <template v-else>
                    <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        {{ user.name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" :href="profile">Mon profil</a>
                        <a class="dropdown-item" :href="orders">Mes commandes</a>

                        <a v-if="user.role = 'admin'" class="dropdown-item" :href="adminProducts">
                        Liste des produits
                        </a>

                        <a v-if="user.role = 'admin'" class="dropdown-item" :href="adminOrderShow">
                        Liste des commandes
                        </a>

                        <a class="dropdown-item" href="#" @click.prevent="logoutUser">
                        Déconnexion
                        </a>

                    </div>
                    </li>
                </template>
			</ul>
        </div>

		<!-- Modal Search -->
		<div v-if="isSearchModalVisible" class="modal-search-header flex-c-m trans-04">
            <div class="container-search-header">
                <button class="flex-c-m btn-hide-modal-search trans-04 btn-close" @click="hideSearchModal">
                    <img :src="logoClose" alt="CLOSE">
                </button>

                <form class="wrap-search-header flex-w p-l-15" method="GET" :action="catalogLink">
                    <input class="plh3" type="text" name="search" placeholder="Recherche..." v-model="searchQuery">
                    <button class="flex-c-m trans-04">
                        <i class="zmdi zmdi-search"></i>
                    </button>
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
            searchQuery: ""
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
            type: Boolean,
            required: true
        },

        user: {
            type: Object,
            required: true
        },

        login: {
            type: String,
            required: true
        },

        register: {
            type: String,
            required: true
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
            required: true
        },

    }, 

    computed: {
        cartItemCount() {
            return this.$store.getters.cartItemCount;
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
    
        hideSearchModal() {
            this.isSearchModalVisible = false;
        },

        ...mapActions(['fetchCartCount', 'fetchCart']), // Load cart in starting state
            

    },

    mounted() {
        if(this.isAuthenticated){
            this.fetchCartCount();
            this.fetchCart();
        }
        
         
    }

  };
  </script>
  
  <style scoped>
  .modal-search-header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8); 
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 1;
    transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
    z-index: 9999; 
}



.container-search-header {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
}

.modal-search-header[style*="display: none"] {
    display: flex !important;
}

.btn-close{
    background-color: white;
    border-radius: 7px;
    padding: 9px;
}

.wrap-search-header{
    height: 80px;
}

.wrap-search-header button{
    font-size: 40px;
    margin: auto;
}

.plh3{
    font-size: 25px;
}

.icon-header-noti::after {
    font-size: 14px;  
    height: 24px;     
    line-height: 24px; 
    top: -8px;        
    right: -8px;      
    border-radius: 15px;
    background: red;
}

.zmdi-shopping-cart, .zmdi-search{
    font-size:30px;
}


  </style>
  