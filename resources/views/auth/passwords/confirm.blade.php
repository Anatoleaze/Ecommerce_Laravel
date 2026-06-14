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

    <div style="width: 100%; max-width: 460px;">

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
                🔒
            </div>

            <h1 style="color: white; font-size: 26px; font-weight: 800; margin: 0 0 8px;">
                Confirmation de sécurité
            </h1>

            <p style="color: rgba(255, 255, 255, 0.6); font-size: 14px; margin: 0;">
                Veuillez confirmer votre mot de passe pour continuer
            </p>

        </div>

        <!-- Card -->
        <div style="background: white; border-radius: 20px; padding: 36px; box-shadow: rgba(0, 0, 0, 0.3) 0px 20px 60px;">

            <p style="color: #555; font-size: 14px; margin-bottom: 20px; line-height: 1.6;">
                Pour des raisons de sécurité, veuillez confirmer votre mot de passe avant de continuer.
            </p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div style="margin-bottom: 22px;">
                    <label style="display:block; font-size:13px; font-weight:700; color:#444; margin-bottom:8px;">
                        🔒 Mot de passe
                    </label>

                    <input id="password"
                           type="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           placeholder="Votre mot de passe"
                           style="
                                width: 100%;
                                padding: 12px 16px;
                                border: 2px solid #eee;
                                border-radius: 10px;
                                font-size: 14px;
                                outline: none;
                                transition: 0.2s;
                           "
                           onfocus="this.style.borderColor='#6c63ff'"
                           onblur="this.style.borderColor='#eee'">

                    @error('password')
                        <div style="color:#e74c3c; font-size:12px; margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Button -->
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
                            margin-bottom: 12px;
                        "
                        onmouseover="this.style.transform='translateY(-1px)'"
                        onmouseout="this.style.transform='translateY(0)'">

                    ✔ Confirmer
                </button>

            </form>

            @if (Route::has('password.request'))
                <div style="text-align:center;">
                    <a href="{{ route('password.request') }}"
                       style="font-size: 13px; color: rgba(26,26,46,0.7); text-decoration: none; font-weight: 600;">
                        Mot de passe oublié ?
                    </a>
                </div>
            @endif

        </div>

    </div>

</section>

@endsection