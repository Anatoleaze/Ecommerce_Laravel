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

<!-- HERO -->
<section style="
    min-height: 30vh;
    background: linear-gradient(135deg, rgba(26,26,46,0.95), rgba(51,51,51,0.95)),
                url('/images/bg-01.jpg');
    background-size: cover;
    background-position: center;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:60px 20px;
">

    <div style="text-align:center; max-width:800px;">

        <div style="
            width:60px;
            height:60px;
            margin:0 auto 16px;
            border-radius:16px;
            background:rgba(255,255,255,0.1);
            border:1px solid rgba(255,255,255,0.2);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:26px;
            backdrop-filter: blur(4px);
        ">
            📦
        </div>

        <h1 style="
            color:white;
            font-size:30px;
            font-weight:800;
            margin:0 0 8px;
            letter-spacing:1px;
        ">
            {{ $title }}
        </h1>

        <p style="color:rgba(255,255,255,0.6); font-size:14px; margin:0;">
            Suivi et gestion de vos commandes
        </p>

    </div>

</section>

<!-- CONTENT -->
<section style="background:#f6f7fb; padding:40px 20px; min-height:60vh;">

    <div style="max-width:1200px; margin:0 auto;">

        <div style="
            background:white;
            border-radius:18px;
            padding:20px;
            box-shadow:0 15px 40px rgba(0,0,0,0.06);
        ">

            <order-component
                :orders="{{ json_encode($data) }}"
                :user="{{ json_encode(Auth::user()) }}"
            />

        </div>

    </div>

</section>

@endsection