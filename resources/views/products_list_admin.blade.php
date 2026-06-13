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
                                    <td class="column-2">
                                        <div>
                                            <img src="{{ asset($product->image_name)}}"  style="width: 80%; border-radius: 20px; cursor:pointer;"  alt="IMG-{{$product->name}}" onclick="openImageModal('{{ asset($product->image_name) }}')">
                                        </div>
                                    </td>
                                    <td class="column-2">{{$product->name}}</td>
                                    <td class="column-3">{{$product->price}} €</td>
                                    <td class="column-4">{{$product->type}}</td>
                                    <td class="column-5"> 
                                        <form action="{{ route('edit', $product->id) }}" method="GET">
                                            @csrf
                                            <button type="submit" style="width: inherit;" class="btn btn-info">  
                                                <i class="zmdi zmdi-hc-2x zmdi-edit"></i>
                                            </button>
                                        </form>

                                    </td>
                                    <td class="column-5"> 
                                        <form action="{{ route('delete_product', $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="width: inherit;" class="btn btn-danger">  
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
</div>
    
<!-- Modale Image -->
<div id="image-modal" onclick="closeImageModal()" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:2000; justify-content:center; align-items:center; cursor:pointer;">
    <div style="position:relative; max-width:90%; max-height:90vh;" onclick="event.stopPropagation()">
        <span onclick="closeImageModal()" style="position:absolute; top:-15px; right:-15px; width:32px; height:32px; background:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:20px; cursor:pointer; line-height:1; text-align:center;">&times;</span>
        <img id="image-modal-img" src="" alt="IMG" style="max-width:100%; max-height:85vh; border-radius:4px; object-fit:contain;">
    </div>
</div>	 
	
<script>
function openImageModal(src) {
    document.getElementById('image-modal-img').src = src;
    document.getElementById('image-modal').style.display = 'flex';
}
function closeImageModal() {
    document.getElementById('image-modal').style.display = 'none';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeImageModal();
});
</script>
@endsection