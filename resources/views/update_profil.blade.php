@extends('layouts.app')

@section('content')

<div style="margin:55px;">
    <h3 class="text-center">Modifier mon profils</h3>

    <profil-update-component 
        :user-data="{{ json_encode($user) }}"
    />
    
</div>

@endsection
