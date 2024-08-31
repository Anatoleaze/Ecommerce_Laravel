@extends('layouts.app')

@section('content')

<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('../images/bg-01.jpg');">
    <h2 class="ltext-105 cl0 txt-center">
        Modification du produit "{{$product->name}}"
    </h2>
</section>

<!-- Shoping Cart -->
<div class="bg0 p-t-75 p-b-85">
    <div class="container">
        <div class="row">    
            <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    @if(session('success'))
                        <div class="alert alert-success"  style="margin: auto auto 25px;width: 66%;text-align: center;">
                            {{ session('success') }}
                        </div>
                    @endif
                
                    @if(session('error'))
                        <div class="alert alert-danger"  style="margin: auto auto 25px;width: 66%;text-align: center;">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <create-product-component
                        :link="'{{ route('update', $product->id) }}'"
                        :product="{{ json_encode($product) }}" 
                        csrf-token="{{ csrf_token() }}"
                    />

                </div>
            </div>
        </div>
    </div>
</div>
	
@endsection