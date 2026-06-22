@extends('layouts.app')

@section('content')

<!-- HEADER -->
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

<!-- HERO -->
<section style="
    background: linear-gradient(135deg, rgba(26,26,46,0.92), rgba(51,51,51,0.92)),
                url('/images/bg-01.jpg');
    background-size: cover;
    background-position: center;
    padding:70px 20px;
    text-align:center;
">

    <div style="max-width:700px; margin:0 auto;">

        <div style="
            width:65px;
            height:65px;
            margin:0 auto 18px;
            border-radius:18px;
            background:rgba(255,255,255,0.1);
            border:1px solid rgba(255,255,255,0.2);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:28px;
            backdrop-filter: blur(5px);
        ">
            🛍️
        </div>

        <h2 style="
            color:white;
            font-size:30px;
            font-weight:800;
            margin:0 0 8px;
        ">
            Création d’un produit
        </h2>

        <p style="color:rgba(255,255,255,0.6); font-size:14px; margin:0;">
            Ajoutez un nouveau produit à votre catalogue
        </p>

    </div>

</section>

<!-- CONTENT -->
<section style="background:#f6f7fb; padding:50px 20px; min-height:60vh;">

    <div style="max-width:900px; margin:0 auto;">

        <!-- CARD -->
        <div style="
            background:white;
            border-radius:18px;
            padding:30px;
            box-shadow:0 15px 40px rgba(0,0,0,0.06);
        ">

            <!-- ALERTS -->
            @if(session('success'))
                <div style="
                    background:#eafaf1;
                    color:#27ae60;
                    padding:12px;
                    border-radius:10px;
                    text-align:center;
                    font-weight:600;
                    font-size:13px;
                    margin-bottom:20px;
                ">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="
                    background:#fef0f0;
                    color:#e74c3c;
                    padding:12px;
                    border-radius:10px;
                    text-align:center;
                    font-weight:600;
                    font-size:13px;
                    margin-bottom:20px;
                ">
                    {{ session('error') }}
                </div>
            @endif

            <!-- COMPONENT -->
            <create-product-component
                link="{{ route('store_product') }}"
                csrf-token="{{ csrf_token() }}"
            />

        </div>

    </div>

</section>

@endsection