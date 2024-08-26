@extends('layouts.app')

@section('content')

<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
    <h2 class="ltext-105 cl0 txt-center">
        La listes des produits
    </h2>
</section>

<!-- Shoping Cart -->
<form class="bg0 p-t-75 p-b-85">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
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
                                            <img src="{{$product->image_name}}" alt="IMG">
                                        </div>
                                    </td>
                                    <td class="column-2">{{$product->name}}</td>
                                    <td class="column-3"> {{$product->price}} €</td>
                                    <td class="column-4"> {{$product->type}}</td>
                                    <td class="column-5"> <a href=""><i class="zmdi zmdi-hc-2x zmdi-edit"></i></a></td>
                                    <td class="column-5"> <a href=""><i class="zmdi zmdi-hc-2x zmdi-delete"></i></a></td>
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
</form>
    
	
	
@endsection