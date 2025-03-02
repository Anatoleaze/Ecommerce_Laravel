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
	<footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-4 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Categories
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="{{ route('products_list', [], false) }}?search=femmes" class="stext-107 cl7 hov-cl1 trans-04">
									
								Femmes
							</a>
						</li>

						<li class="p-b-10">
							<a href="{{ route('products_list', [], false) }}?search=hommes" class="stext-107 cl7 hov-cl1 trans-04">
								Hommes
							</a>
						</li>

						<li class="p-b-10">
							<a href="{{ route('products_list', [], false) }}?search=chaussures" class="stext-107 cl7 hov-cl1 trans-04">
								Chaussures
							</a>
						</li>
                        
                        <li class="p-b-10">
							<a href="{{ route('products_list', [], false) }}?search=sacs" class="stext-107 cl7 hov-cl1 trans-04">
								Sacs
							</a>
						</li>

						<li class="p-b-10">
							<a href="{{ route('products_list', [], false) }}?search=montes" class="stext-107 cl7 hov-cl1 trans-04">
								Montres
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-4 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Mon compte
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="{{ route('profils') }}" class="stext-107 cl7 hov-cl1 trans-04">
								Mon profils
							</a>
						</li>

						<li class="p-b-10">
							<a href="{{route('order')}}" class="stext-107 cl7 hov-cl1 trans-04">
								Mes Commandes 
							</a>
						</li>
						@guest
						@else 
							@if(Auth::user()->isAdmin())
								<a class="stext-107 cl7 hov-cl1 trans-04" href="{{ route('products_list_admin') }}">
									Liste des produits
								</a>
							@endif
						@endguest
						

					</ul>
				</div>

				<div class="col-sm-6 col-lg-4 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Newsletter
					</h4>
					
					@if (session('message'))
						@if (session('message') == 'Vous avez été ajouté à la newsletter !')
							<div class="alert alert-success">{{ session('message') }}</div>
						@else
							<div class="alert alert-danger">{{ session('message') }}</div>
						@endif
								
					@endif
					
					<form method='GET' action={{route('addNewsLetter')}}>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email" placeholder="email@example.com">
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								S'abonner
							</button>
						</div>
					</form>
				</div>
			</div>

			<div class="p-t-40">
				<div class="flex-c-m flex-w p-b-18">
					<a href="#" class="m-all-1">
						<img src="{{ asset('images/icons/icon-pay-01.png')}}" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="{{ asset('images/icons/icon-pay-02.png')}}" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="{{ asset('images/icons/icon-pay-03.png')}}" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="{{ asset('images/icons/icon-pay-04.png')}}" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="{{ asset('images/icons/icon-pay-05.png')}}" alt="ICON-PAY">
					</a>
				</div>

				<p class="stext-107 cl6 txt-center">
			Copyright &copy;<script>document.write(new Date().getFullYear());</script> Tous droits réservés | Réalisé par 
		
			@isset($link)
				<a href="{{$link}}" target="_blank">{{ config('app.name', 'Laravel') }}</a>
			@else
				<a href="#" target="_blank">{{ config('app.name', 'Laravel') }}</a>	
			@endif
			
			</p>
			</div>
		</div>
	</footer>


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>




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
