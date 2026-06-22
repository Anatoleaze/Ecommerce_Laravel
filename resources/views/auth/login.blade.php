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

<section style="min-height:90vh; background:linear-gradient(135deg, #1a1a2e 0%, #333 100%); display:flex; align-items:center; justify-content:center; padding:40px 20px;">
    <div style="width:100%; max-width:460px;">

        <!-- Logo / Titre -->
        <div style="text-align:center; margin-bottom:32px;">
            <div style="width:70px; height:70px; background:rgba(255,255,255,0.1); border-radius:20px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:32px; backdrop-filter:blur(4px); border:1px solid rgba(255,255,255,0.2);">
                🔑
            </div>
            <h1 style="color:white; font-size:28px; font-weight:800; margin:0 0 8px;">Bon retour !</h1>
            <p style="color:rgba(255,255,255,0.6); font-size:14px; margin:0;">Connectez-vous à votre compte</p>
        </div>

        <!-- Carte formulaire -->
        <div style="background:white; border-radius:20px; padding:36px; box-shadow:0 20px 60px rgba(0,0,0,0.3);">

            <!-- Erreurs globales -->
            @if ($errors->any())
            <div style="background:#fef0f0; border:1px solid #f5c6c6; border-radius:10px; padding:12px 16px; margin-bottom:20px; font-size:14px; color:#e74c3c;">
                ❌ {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div style="margin-bottom:20px;">
                    <label style="display:block; font-size:13px; font-weight:700; color:#444; margin-bottom:8px;">
                        ✉️ Adresse email
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', request()->cookie('remembered_email')) }}"
                        required
                        autocomplete="email"
                        autofocus
                        placeholder="votre@email.com"
                        style="width:100%; padding:12px 16px; border:2px solid {{ $errors->has('email') ? '#e74c3c' : '#eee' }}; border-radius:10px; font-size:14px; color:#333; outline:none; transition:border-color 0.2s; box-sizing:border-box;"
                        onfocus="this.style.borderColor='#6c63ff'"
                        onblur="this.style.borderColor='{{ $errors->has('email') ? '#e74c3c' : '#eee' }}'">
                    @error('email')
                    <p style="color:#e74c3c; font-size:12px; margin:6px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div style="margin-bottom:20px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                        <label style="font-size:13px; font-weight:700; color:#444;">
                            🔒 Mot de passe
                        </label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:12px; color:#6c63ff; text-decoration:none; font-weight:600;">
                            Mot de passe oublié ?
                        </a>
                        @endif
                    </div>
                    <input
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Votre mot de passe"
                        style="width:100%; padding:12px 16px; border:2px solid {{ $errors->has('password') ? '#e74c3c' : '#eee' }}; border-radius:10px; font-size:14px; color:#333; outline:none; transition:border-color 0.2s; box-sizing:border-box;"
                        onfocus="this.style.borderColor='#6c63ff'"
                        onblur="this.style.borderColor='{{ $errors->has('password') ? '#e74c3c' : '#eee' }}'">
                    @error('password')
                    <p style="color:#e74c3c; font-size:12px; margin:6px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Se souvenir de moi -->
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:24px;">
                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        {{ old('remember') ? 'checked' : '' }}
                        style="width:16px; height:16px; accent-color:#6c63ff; cursor:pointer;">
                    <label for="remember" style="font-size:13px; color:#666; cursor:pointer; margin:0;">
                        Se souvenir de moi
                    </label>
                </div>

                <!-- Bouton connexion -->
                <button type="submit"
                    style="width:100%; padding:14px; background:linear-gradient(135deg, #1a1a2e, #333); color:white; border:none; border-radius:10px; font-size:16px; font-weight:700; cursor:pointer; transition:all 0.3s; margin-bottom:16px;"
                    onmouseover="this.style.background='linear-gradient(135deg, #333, #555)'"
                    onmouseout="this.style.background='linear-gradient(135deg, #1a1a2e, #333)'">
                    🔑 Se connecter
                </button>

                <!-- Lien inscription -->
                <p style="text-align:center; font-size:14px; color:#aaa; margin:0;">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" style="color:#6c63ff; font-weight:700; text-decoration:none;">
                        S'inscrire
                    </a>
                </p>

            </form>
        </div>

        <!-- Retour accueil -->
        <div style="text-align:center; margin-top:20px;">
            <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.5); font-size:13px; text-decoration:none;">
                ← Retour à l'accueil
            </a>
        </div>

    </div>
</section>

@endsection