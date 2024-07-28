@extends('layouts.app')

@section('content')

<!-- Slider -->
<section class="section-slide">
	<slider-component :link="'{{ route('products_list') }}'"/>
</section>

<!-- Banner -->
<div class="sec-banner bg0 p-t-80 p-b-50">
	<div class="container">
		<div class="row">
			
			<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
				<category-cart-component
					image="images/banner-01.jpg" 
					title="Femmes" 
					subtitle="Collection" 
					link={{ route('products_list') }}
				/>
			</div>

			<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
				<category-cart-component
					image="images/banner-02.jpg" 
					title="Hommes" 
					subtitle="Collection" 
					link={{ route('products_list') }}
				/>
			</div>
			
			<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
				<category-cart-component
					image="images/banner-03.jpg"
					title="Accessories"
					subtitle="Collection"
					link = {{ route('products_list') }}
				/>
			</div>
				
		</div>
	</div>
</div>


<!-- Product -->
<section class="bg0 p-t-23 p-b-140">	
	<div class="container">
		<div class="p-b-10">
			<h3 class="ltext-103 cl5" style="margin-bottom:25px;">
				Les plus populaires
			</h3>
		</div>

		<!-- Filter -->
		<div class="row">
			<filter-component/>
		</div>

		<div class="row isotope-grid">

			@foreach ( $products as $product )
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ $product->type }}">
					<product-cart-component
						:image="'{{$product->image_name}}'"
						:name="'{{$product->name}}'"
						:price="'{{$product->price}}'"
					/>
				</div>
			@endforeach
							
		</div>

		<!-- Load more -->
		<div class="flex-c-m flex-w w-full p-t-45">
			<a href="#" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
				Voir les produits suivants
			</a>
		</div>
	</div>
</section>


<!--<product-component/>-->

@endsection