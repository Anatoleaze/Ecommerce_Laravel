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
    padding: 70px 20px;
    text-align: center;
">

    <div style="max-width: 800px; margin: auto;">

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

        <h1 style="
            color:white;
            font-size:30px;
            font-weight:800;
            margin:0 0 10px;
        ">
            @if($search)
                Résultats pour "{{ $search }}"
            @else
                Catalogue produits
            @endif
        </h1>

        <p style="color:rgba(255,255,255,0.6); font-size:14px; margin:0;">
            Explorez notre sélection de produits
        </p>

    </div>
</section>

<!-- CONTENT -->
<section style="background:#f6f7fb; padding:50px 20px; min-height:60vh;">

    <div style="max-width:1200px; margin:auto;">

        <!-- FILTER COMPONENT -->
<div style="
    background:white;
    border-radius:18px;
    padding:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.05);
">
    <!-- On ajoute un écouteur d'événement inline qui va masquer/afficher la pagination -->
    <filter-component
        :products="{{ json_encode($products) }}"
        :is-authenticated="{{ json_encode(Auth::check()) }}"
        :paginated="true"
    />
</div>

    </div>

</section>

<!-- PAGINATION -->
@if ($products->lastPage() > 1)

<div id="laravel-pagination" style="
    display:flex;
    justify-content:center;
    padding:30px 0 60px;
    background:#f6f7fb;
">
    <nav>
        <ul style="display:flex; gap:8px; list-style:none; padding:0; margin:0;">

            {{-- PREV --}}
            <li>
                <a href="{{ $products->currentPage() > 1 ? $products->previousPageUrl() : '#' }}"
                   style="
                        width:38px;
                        height:38px;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        border-radius:10px;
                        background:white;
                        border:1px solid #ddd;
                        text-decoration:none;
                        color:#333;
                        opacity:{{ $products->currentPage() == 1 ? '0.4' : '1' }};
                        pointer-events:{{ $products->currentPage() == 1 ? 'none' : 'auto' }};
                   ">
                    ‹
                </a>
            </li>

            @for ($i = 1; $i <= $products->lastPage(); $i++)
            <li>
                <a href="{{ $products->url($i) }}"
                   style="
                        width:38px;
                        height:38px;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        border-radius:10px;
                        text-decoration:none;
                        font-weight:700;
                        font-size:13px;
                        background:{{ $i == $products->currentPage() ? '#1a1a2e' : 'white' }};
                        color:{{ $i == $products->currentPage() ? 'white' : '#333' }};
                        border:1px solid #ddd;
                        transition:0.2s;
                   ">
                    {{ $i }}
                </a>
            </li>
            @endfor

            {{-- NEXT --}}
            <li>
                <a href="{{ $products->currentPage() < $products->lastPage() ? $products->nextPageUrl() : '#' }}"
                   style="
                        width:38px;
                        height:38px;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        border-radius:10px;
                        background:white;
                        border:1px solid #ddd;
                        text-decoration:none;
                        color:#333;
                        opacity:{{ $products->currentPage() == $products->lastPage() ? '0.4' : '1' }};
                        pointer-events:{{ $products->currentPage() == $products->lastPage() ? 'none' : 'auto' }};
                   ">
                    ›
                </a>
            </li>

        </ul>
    </nav>
</div>
@endif

@endsection