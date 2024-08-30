@extends('layouts.app')

@section('content')

<!-- Slider -->
<section class="section-slide">
	<slider-component link={{ route('products_list', [], false) }}?search=femmes />
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
					link={{ route('products_list', [], false) }}?search=femmes
				/>
			</div>

			<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
				<category-cart-component
					image="images/banner-02.jpg" 
					title="Hommes" 
					subtitle="Collection" 
					link={{ route('products_list', [], false) }}?search=hommes
				/>
			</div>
			
			<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
				<category-cart-component
					image="images/banner-03.jpg"
					title="Accessories"
					subtitle="Collection"
					link = {{ route('products_list', [], false) }}?search=montres
				/>
			</div>
				
		</div>
	</div>
</div>


<!-- Product -->
<div class="bg0 p-t-23 p-b-140" style="height: 1200px;">
	<div class="p-b-10">
		<h3 class="ltext-103 cl5 m-b-25 text-center" >
			Les plus populaires
		</h3>
	</div>	
	
	<!-- Filter -->
	<filter-component
		:products="{{ json_encode($products) }}"
	/>
			
</div>

<!-- Pagination-->
<div class="pagination m-t-50 m-b-75 text-center">
    {{ $products->links() }}
</div>
@endsection