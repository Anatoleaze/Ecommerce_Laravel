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

<!-- Hero -->
<section style="position:relative; background-image:url('{{ asset('images/bg-01.jpg') }}'); background-size:cover; background-position:center; padding:80px 20px; text-align:center;">
    <div style="position:absolute; inset:0; background:rgba(0,0,0,0.55);"></div>
    <div style="position:relative; z-index:1;">
        <div style="width:80px; height:80px; background:rgba(255,255,255,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:36px; backdrop-filter:blur(4px); border:2px solid rgba(255,255,255,0.3);">
            👤
        </div>
        <h1 style="color:white; font-size:36px; font-weight:800; margin:0 0 8px;">
            {{ Auth::user()->first_name }} {{ Auth::user()->name }}
        </h1>
        <p style="color:rgba(255,255,255,0.7); font-size:14px; margin:0;">
            {{ Auth::user()->email }}
        </p>
    </div>
</section>

<!-- Contenu profil -->
<section style="padding:60px 0; background:#f8f9fa; min-height:60vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div style="background:white; border-radius:16px; padding:32px; box-shadow:0 4px 15px rgba(0,0,0,0.06);">
                    <profil-component
                        name="{{ Auth::user()->name }}"
                        first_name="{{ Auth::user()->first_name }}"
                        mail="{{ Auth::user()->email }}"
                        :user-data='@json(["name" => Auth::user()->name, "first_name" => Auth::user()->first_name, "email" => Auth::user()->email])'
                    ></profil-component>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection