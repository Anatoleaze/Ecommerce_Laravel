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

<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
    <h2 class="ltext-105 cl0 txt-center">
        La listes des produits
    </h2>
</section>

<!-- Shoping Cart -->
<div class="bg0 p-t-75 p-b-85">
    <div class="container">
        <a href="{{route('create_product')}}" class="flex-c-m stext-101 cl0 size-103 bg1 bor1 p-lr-15" style="width: 25%;margin: auto; color:white;margin-bottom:50px;cursor: pointer;">Création d'un produit</a>
        <div class="row">    
            <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart">
                            <tr class="table_head">
                                <th class="column-1">Produits</th>
                                <th class="column-2"></th>
                                <th class="column-3">Prix</th>
                                <th class="column-4">Catégorie</th>
                                <th class="column-5">Modification</th>
                                <th class="column-5">Suppression</th>
                            </tr>

                            @foreach ($products as $product)
                                <tr class="table_row">
                                    <td class="column-1">
                                        <div class="how-itemcart1">
                                            <img src="{{ asset($product->image_name)}}" alt="IMG">
                                        </div>
                                    </td>
                                    <td class="column-2">{{$product->name}}</td>
                                    <td class="column-3">{{$product->price}} €</td>
                                    <td class="column-4">{{$product->type}}</td>
                                    <td class="column-5"> 
                                        <form action="{{ route('edit', $product->id) }}" method="GET">
                                            @csrf
                                            <button type="submit" class="btn btn-info">  
                                                <i class="zmdi zmdi-hc-2x zmdi-edit"></i>
                                            </button>
                                        </form>

                                    </td>
                                    <td class="column-5"> 
                                        <form action="{{ route('delete_product', $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">  
                                                <i class="zmdi zmdi-hc-2x zmdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                           
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pagination-->
    <div class="pagination m-t-50 m-b-75 text-center">
        {{ $products->links() }}
    </div>
</div>
    
	
	
@endsection