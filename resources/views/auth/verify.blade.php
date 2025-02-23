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


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin: 250px; border-radius: 8px;width: 69%;margin-left: 15%;">
                <div class="card-header text-center">Vérifiez votre adresse e-mail</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Un nouveau lien de vérification a été envoyé à votre adresse électronique.
                        </div>
                    @endif

                    Avant de poursuivre, veuillez vérifier votre courrier électronique pour obtenir un lien de vérification.
                    Si vous n'avez pas reçu l'email,

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04" style="margin-left: 50%;">cliquez ici pour en demander un autre</button>.
                    </form>




                </div>

            </div>
        </div>
    </div>
</div>
@endsection
