@extends('layouts.app')

@section('content')

<!-- Header -->
<div>
	<header-component
		:home-link="'{{ route('home') }}'"
		:logo="'{{ asset('images/icons/logo-01.png') }}'"
		:catalog-link="'{{ route('products_list') }}'"
		:cart-link="'{{ route('cart_show') }}'"
		:contact-link="'{{ route('contact') }}'"
		:admin-order-show="'{{ route('adminOrderShow') }}'"
		:is-authenticated="{{ json_encode(Auth::check()) }}"
		:user="{{ json_encode(Auth::user()) }}"
		:login="'{{ route('login') }}'"
		:register="'{{ route('register') }}'"
		:profile="'{{ route('profils') }}'"
		:orders="'{{ route('order') }}'"
		:admin-products="'{{ route('products_list_admin') }}'"
		:logout="'{{ route('logout') }}'"
		:logo-close="'{{ asset('images/icons/icon-close2.png') }}'"
		:csrfToken="'{{ csrf_token() }}'"
		
	/>
</div>

<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
    <h2 class="ltext-105 cl0 txt-center">
        Création d'un produit
    </h2>
</section>

<!-- Shoping Cart -->
<div class="bg0 p-t-75 p-b-85">
    <div class="container">
        <div class="row">    
            <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    @if(session('success'))
                        <div class="alert alert-success"  style="margin: auto auto 25px;width: 66%;text-align: center;">
                            {{ session('success') }}
                        </div>
                    @endif
                
                    @if(session('error'))
                        <div class="alert alert-danger"  style="margin: auto auto 25px;width: 66%;text-align: center;">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <create-product-component
                        link={{ route('store_product') }}
                        csrf-token="{{ csrf_token() }}"
                    />

                </div>
            </div>
        </div>
    </div>
</div>
	
@endsection