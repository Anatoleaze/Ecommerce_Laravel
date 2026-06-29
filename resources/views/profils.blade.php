@extends('layouts.app')

@php
$user = Auth::user()->load('address');
@endphp

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

<!-- Contenu profil -->
<section style="background:#f8f9fa; min-height:100vh;">
    <profil-component
    name="{{ $user->name }}"
    first_name="{{ $user->first_name }}"
    mail="{{ $user->email }}"
    :user-data='@json($user)'
    bg-image="{{ asset('images/bg-01.jpg') }}"
></profil-component>

</section>

@endsection