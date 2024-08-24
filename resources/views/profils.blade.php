@extends('layouts.app')

@section('content')

<!-- Product -->
<div class="bg0 m-t-23 p-b-140">
    <div class="container">

        <h2 class="text-center ltext-103 cl5" style="margin: 100px;">
            Mon profils
        </h2>
           
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

