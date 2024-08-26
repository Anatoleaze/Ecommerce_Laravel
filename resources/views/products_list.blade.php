@extends('layouts.app')

@section('content')

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
        />
        
    </div>
</div>


<!-- Pagination-->
<div class="pagination m-t-50 m-b-75 text-center">
    {{ $products->links() }}
</div>
    
@endsection

