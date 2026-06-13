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

<!-- Product -->
<div class="bg0 m-t-23 p-b-50">
    <div class="container">

        <h2 class="text-center ltext-103 cl5" style="margin: 100px;">
            @if($search)
                Résultats de recherche pour : "{{ $search }}"
            @else
                Notre catalogue
            @endif
        </h2>
           
         <filter-component
            :products="{{ json_encode($products) }}"
            :is-authenticated="{{ json_encode(Auth::check()) }}"
            :paginated="true"
        />
        
    </div>
</div>


<!-- Pagination -->
<div class="m-t-50 m-b-75" style="display: flex; justify-content: center;">
    @if ($products->lastPage() > 1)
    <nav>
        <ul style="list-style:none; display:flex; gap:6px; padding:0; margin:0; align-items:center;">
            
            {{-- Bouton précédent --}}
            <li>
                <a href="{{ $products->currentPage() > 1 ? $products->url($products->currentPage() - 1) : '#' }}"
                   style="display:flex; align-items:center; justify-content:center; width:36px; height:36px; border:1px solid #ccc; border-radius:4px; color:#555; text-decoration:none; font-size:14px; {{ $products->currentPage() == 1 ? 'opacity:0.4; pointer-events:none;' : '' }}">
                    &lt;
                </a>
            </li>

            {{-- Pages glissantes 4 par 4 --}}
            @php
                $current = $products->currentPage();
                $last = $products->lastPage();
                $start = max(1, $current - 1);
                $end = min($last, $start + 3);
                if ($end - $start < 3) {
                    $start = max(1, $end - 3);
                }
            @endphp

            @for ($i = $start; $i <= $end; $i++)
            <li>
                <a href="{{ $products->url($i) }}"
                   style="display:flex; align-items:center; justify-content:center; width:36px; height:36px; border:1px solid {{ $i == $current ? '#6c63ff' : '#ccc' }}; border-radius:4px; background:{{ $i == $current ? '#6c63ff' : '#fff' }}; color:{{ $i == $current ? '#fff' : '#555' }}; text-decoration:none; font-size:14px;">
                    {{ $i }}
                </a>
            </li>
            @endfor

            {{-- Bouton suivant --}}
            <li>
                <a href="{{ $products->currentPage() < $products->lastPage() ? $products->nextPageUrl() : '#' }}"
                   style="display:flex; align-items:center; justify-content:center; width:36px; height:36px; border:1px solid #ccc; border-radius:4px; color:#555; text-decoration:none; font-size:14px; {{ $products->currentPage() == $products->lastPage() ? 'opacity:0.4; pointer-events:none;' : '' }}">
                    &gt;
                </a>
            </li>

        </ul>
    </nav>
    @endif
</div>
    
@endsection

