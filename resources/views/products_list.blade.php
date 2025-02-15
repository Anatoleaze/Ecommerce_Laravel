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
		/>
        
    </div>
</div>


<!-- Pagination-->
<div class="pagination m-t-50 m-b-75 text-center">
    {{ $products->links() }}
</div>
    
@endsection

