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

<section style="min-height: 90vh; background: linear-gradient(135deg, rgb(26, 26, 46) 0%, rgb(51, 51, 51) 100%); display: flex; align-items: center; justify-content: center; padding: 40px 20px;">

    <div style="width: 100%; max-width: 520px;">

        <!-- Header -->
        <div style="text-align: center; margin-bottom: 32px;">

            <div style="
                width: 70px;
                height: 70px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 16px;
                font-size: 30px;
                backdrop-filter: blur(4px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            ">
                📩
            </div>

            <h1 style="color: white; font-size: 26px; font-weight: 800; margin: 0 0 8px;">
                Vérification email
            </h1>

            <p style="color: rgba(255, 255, 255, 0.6); font-size: 14px; margin: 0;">
                Confirmez votre adresse email pour continuer
            </p>

        </div>

        <!-- Card -->
        <div style="background: white; border-radius: 20px; padding: 36px; box-shadow: rgba(0, 0, 0, 0.3) 0px 20px 60px;">

            @if (session('resent'))
                <div style="
                    background: rgba(0, 200, 100, 0.1);
                    border: 1px solid rgba(0, 200, 100, 0.3);
                    color: #2e7d32;
                    padding: 12px;
                    border-radius: 10px;
                    font-size: 13px;
                    margin-bottom: 20px;
                ">
                    Un nouveau lien de vérification a été envoyé à votre adresse email.
                </div>
            @endif

            <p style="color: #444; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                Avant de continuer, veuillez vérifier votre boîte mail et cliquer sur le lien de vérification que nous vous avons envoyé.
            </p>

            <p style="color: #666; font-size: 13px; margin-bottom: 25px;">
                Si vous n’avez pas reçu l’email, vous pouvez en demander un nouveau ci-dessous.
            </p>

            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf

                <button type="submit"
                        style="
                            width: 100%;
                            padding: 14px;
                            background: linear-gradient(135deg, rgb(26, 26, 46), rgb(51, 51, 51));
                            color: white;
                            border: none;
                            border-radius: 10px;
                            font-size: 15px;
                            font-weight: 700;
                            cursor: pointer;
                            transition: 0.3s;
                        "
                        onmouseover="this.style.transform='translateY(-1px)'"
                        onmouseout="this.style.transform='translateY(0)'">

                    🔁 Renvoyer le lien de vérification
                </button>

            </form>

        </div>

        <!-- Footer link -->
        <div style="text-align: center; margin-top: 18px;">
            <a href="{{ route('login') }}"
               style="color: rgba(255,255,255,0.6); font-size: 13px; text-decoration: none;">
                ← Retour à la connexion
            </a>
        </div>

    </div>

</section>

@endsection