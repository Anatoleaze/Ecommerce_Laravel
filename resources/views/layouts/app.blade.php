<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('css/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/fonts/iconic/css/material-design-iconic-font.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/fonts/linearicons-v1.0.0/icon-font.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/animate/animate.css') }}">
	<link rel="stylesheet" href="{{ asset('css/css-hamburgers/hamburgers.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/animsition/animsition.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/perfect-scrollbar/perfect-scrollbar.css') }}">
	<link rel="stylesheet" href="{{ asset('css/util.css') }}">
	<link rel="stylesheet" href="{{ asset('css/main.css') }}">
	
	<!-- Stripe Integration-->
	<script src="https://js.stripe.com/v3/"></script>


</head> 

<body class="animsition">

	<div id="app">
		@yield('content')
	</div>
	

	<!-- Footer -->
<footer style="background: #1a1a2e; padding: 60px 0 0 0; margin-top: 60px;">
    <div class="container">
        <div class="row" style="padding-bottom: 40px;">

            <!-- Catégories -->
            <div class="col-sm-6 col-lg-3" style="margin-bottom: 40px;">
                <h5 style="color: white; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 24px;">
                    🏷️ Catégories
                </h5>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    @foreach([
                        ['label' => '👗 Femmes', 'search' => 'femmes'],
                        ['label' => '👔 Hommes', 'search' => 'hommes'],
                        ['label' => '👟 Chaussures', 'search' => 'chaussures'],
                        ['label' => '👜 Sacs', 'search' => 'sacs'],
                        ['label' => '⌚ Montres', 'search' => 'montres'],
                    ] as $cat)
                    <li style="margin-bottom: 12px;">
                        <a href="{{ route('products_list', [], false) }}?search={{ $cat['search'] }}"
                           style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px; transition: color 0.2s;"
                           onmouseover="this.style.color='white'"
                           onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                            {{ $cat['label'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Mon compte -->
            <div class="col-sm-6 col-lg-3" style="margin-bottom: 40px;">
                <h5 style="color: white; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 24px;">
                    👤 Mon Compte
                </h5>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 12px;">
                        <a href="{{ route('profils') }}"
                           style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px;"
                           onmouseover="this.style.color='white'"
                           onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                            📋 Mon profil
                        </a>
                    </li>
                    <li style="margin-bottom: 12px;">
                        <a href="{{ route('order') }}"
                           style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px;"
                           onmouseover="this.style.color='white'"
                           onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                            📦 Mes commandes
                        </a>
                    </li>
                    @auth
                        @if(Auth::user()->isAdmin())
                        <li style="margin-bottom: 12px;">
                            <a href="{{ route('products_list_admin') }}"
                               style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px;"
                               onmouseover="this.style.color='white'"
                               onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                                🗂️ Liste des produits
                            </a>
                        </li>
                        @endif
                    @endauth
                </ul>
            </div>

            <!-- Infos -->
            <div class="col-sm-6 col-lg-3" style="margin-bottom: 40px;">
                <h5 style="color: white; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 24px;">
                    ℹ️ Informations
                </h5>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 12px;">
                        <a href="{{ route('home') }}"
                           style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px;"
                           onmouseover="this.style.color='white'"
                           onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                            🏠 Accueil
                        </a>
                    </li>
                    <li style="margin-bottom: 12px;">
                        <a href="{{ route('contact') }}"
                           style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px;"
                           onmouseover="this.style.color='white'"
                           onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                            📞 Contact
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-sm-6 col-lg-3" style="margin-bottom: 40px;">
                <h5 style="color: white; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 24px;">
                    ✉️ Newsletter
                </h5>

                @if(session('message'))
                    <div class="alert {{ session('message') == 'Vous avez été ajouté à la newsletter !' ? 'alert-success' : 'alert-danger' }}"
                         style="border-radius: 8px; font-size: 13px; margin-bottom: 16px;">
                        {{ session('message') }}
                    </div>
                @endif

                <p style="color: rgba(255,255,255,0.5); font-size: 13px; margin-bottom: 16px; line-height: 1.6;">
                    Recevez nos dernières offres et nouveautés directement dans votre boîte mail.
                </p>

                <form method="GET" action="{{ route('addNewsLetter') }}">
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <input type="email" name="email" placeholder="votre@email.com"
                               style="padding: 12px 16px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.15); background: rgba(255,255,255,0.08); color: white; font-size: 14px; outline: none; width: 100%;">
                        <button type="submit"
                                style="padding: 12px; border-radius: 8px; background: white; color: #1a1a2e; border: none; font-size: 14px; font-weight: 700; cursor: pointer; transition: background 0.2s;"
                                onmouseover="this.style.background='#eee'"
                                onmouseout="this.style.background='white'">
                            S'abonner →
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Séparateur -->
        <div style="border-top: 1px solid rgba(255,255,255,0.1); padding: 30px 0;">

            <!-- Icônes paiement -->
            <div style="display: flex; justify-content: center; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 24px;">
                <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-right: 8px;">
                    Paiement sécurisé
                </span>
                @foreach(['icon-pay-01.png', 'icon-pay-02.png', 'icon-pay-03.png', 'icon-pay-04.png', 'icon-pay-05.png'] as $icon)
                <a href="#">
                    <img src="{{ asset('images/icons/' . $icon) }}" alt="Paiement"
                         style="height: 28px; opacity: 0.7; transition: opacity 0.2s;"
                         onmouseover="this.style.opacity='1'"
                         onmouseout="this.style.opacity='0.7'">
                </a>
                @endforeach
            </div>

            <!-- Copyright -->
            <p style="text-align: center; color: rgba(255,255,255,0.35); font-size: 13px; margin: 0;">
                © <span id="footer-year"></span> Tous droits réservés —
                @isset($link)
                    <a href="{{ $link }}" target="_blank" style="color: rgba(255,255,255,0.5); text-decoration: none;">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                @else
                    <a href="#" style="color: rgba(255,255,255,0.5); text-decoration: none;">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                @endisset
            </p>
        </div>
    </div>
</footer>

<!-- Bouton retour en haut -->
<div id="myBtn" style="position: fixed; bottom: 30px; right: 30px; width: 44px; height: 44px; background: #333; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.2); opacity: 0; transition: all 0.3s; z-index: 999;"
     onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
     onmouseover="this.style.background='#555'"
     onmouseout="this.style.background='#333'">
    <i class="zmdi zmdi-chevron-up" style="color: white; font-size: 20px;"></i>
</div>

<script>
    document.getElementById('footer-year').textContent = new Date().getFullYear();

    // Affiche le bouton retour en haut
    window.addEventListener('scroll', function() {
        const btn = document.getElementById('myBtn');
        btn.style.opacity = window.scrollY > 300 ? '1' : '0';
        btn.style.pointerEvents = window.scrollY > 300 ? 'auto' : 'none';
    });
</script>




  	<script src="{{ asset('js/jquery/jquery-3.2.1.min.js')}}"></script>
    
    <script src="{{ asset('js/animsition/animsition.min.js')}}"></script>

    <script src="{{ asset('js/bootstrap/popper.js')}}"></script>
    
    <script src="{{ asset('js/bootstrap/bootstrap.min.js')}}"></script>
    
    <script src="{{ asset('js/select2/select2.min.js')}}"></script>
    
    <script>
        $(".js-select2").each(function(){
            $(this).select2({
                minimumResultsForSearch: 20,
                dropdownParent: $(this).next('.dropDownSelect2')
            });
        })
    </script>
    
    <script src="{{ asset('js/daterangepicker/moment.min.js')}}"></script>

    <script src="{{ asset('js/daterangepicker/daterangepicker.js')}}"></script>

    <script src="{{ asset('js/slick/slick.min.js')}}"></script>

    <script src="{{ asset('js/slick-custom.js')}}"></script>

    <script src="{{ asset('js/parallax100/parallax100.js')}}"></script>

    <script>
        $('.parallax100').parallax100();
    </script>

    <script src="{{ asset('js/MagnificPopup/jquery.magnific-popup.min.js')}}"></script>
    
    <script>
        $('.gallery-lb').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a', // the selector for gallery item
                type: 'image',
                gallery: {
                    enabled:true
                },
                mainClass: 'mfp-fade'
            });
        });
    </script>


    <script src="{{ asset('js/sweetalert/sweetalert.min.js')}}"></script>
    
    <script>
        $('.js-addwish-b2').on('click', function(e){
            e.preventDefault();
        });

        $('.js-addwish-b2').each(function(){
            var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
            $(this).on('click', function(){
                swal(nameProduct, "is added to wishlist !", "success");

                $(this).addClass('js-addedwish-b2');
                $(this).off('click');
            });
        });

        $('.js-addwish-detail').each(function(){
            var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

            $(this).on('click', function(){
                swal(nameProduct, "is added to wishlist !", "success");

                $(this).addClass('js-addedwish-detail');
                $(this).off('click');
            });
        });
    
        $('.js-addcart-detail').each(function(){
            var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
            $(this).on('click', function(){
                swal(nameProduct, "is added to cart !", "success");
            });
        });
    </script>

    <script src="{{ asset('js/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    
    <script>
        $('.js-pscroll').each(function(){
            $(this).css('position','relative');
            $(this).css('overflow','hidden');
            var ps = new PerfectScrollbar(this, {
                wheelSpeed: 1,
                scrollingThreshold: 1000,
                wheelPropagation: false,
            });

            $(window).on('resize', function(){
                ps.update();
            })
        });
    </script>

	<script src="{{ asset('js/main.js')}}"></script>

	<!-- JS Script Vue -->
	@vite([ 'resources/js/app.js'])


</body>
</html>
