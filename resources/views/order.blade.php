@extends('layouts.app')

@section('content')

<!-- Header -->
<div>
	<header-component
		:home-link="'{{ route('home') }}'"
		:logo="'{{ asset('images/icons/logo-01.png') }}'"
		:catalog-link="'{{ route('products_list') }}'"
		:cart-link="'{{ route('cart') }}'"
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
        Mes commandes
    </h2>
</section>

<div class="bg0 p-t-75 p-b-85">
    <div class="container">
        <div class="row">    
            <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart">
                            <tr class="table_head">
                                <th class="column-1">Date</th>
                                <th class="column-1">Numéro</th>
                                <th class="column-1">Montant</th>
                                <th class="column-1">Voir en détail</th>
                            </tr>

                            
                            <tr class="table_row">
                                <td class="column-1">10/11/2023</td>
                                <td class="column-1">0780523594</td>
                                <td class="column-1">150 €</td>
                                <td class="column-1">
                                    <a href="#" class="btn btn-info"> Voir </a>
                                </td>
                            </tr>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
	
	
@endsection