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

<!-- Product -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92 m-b-75" style="background-image: url('images/bg-01.jpg');">
    <h2 class="ltext-105 cl0 txt-center">
        Mon profils
    </h2>
</section>

<div class="bg0 m-t-23 p-b-140">
    <div class="container">
           
        <div class="flex-w flex-sb-m p-b-52">
            <profil-component
            name="{{ Auth::user()->name }} "
            first_name="{{ Auth::user()->first_name }} "
            mail="{{ Auth::user()->email }} "
            link="{{ route('updateProfils') }}"
            /> 
                         
        </div>

    </div>
</div>
    
@endsection

