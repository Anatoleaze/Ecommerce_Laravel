@extends('layouts.app')

@section('content')

<!-- Product -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92 m-b-75" style="background-image: url('images/bg-01.jpg');">
    <h2 class="ltext-105 cl0 txt-center">
        Mon profils
    </h2>
</section>

<div class="bg0 m-t-23 p-b-140">
    <div class="container">
           
        <div class="flex-w flex-sb-m p-b-52">
            <profil-component
            name="{{ Auth::user()->name }} "
            first_name="{{ Auth::user()->first_name }} "
            mail="{{ Auth::user()->email }} "
            link="{{ route('updateProfils') }}"
            /> 
                         
        </div>

    </div>
</div>
    
@endsection

