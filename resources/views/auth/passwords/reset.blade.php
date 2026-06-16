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

        <!-- Titre -->
        <div style="text-align:center; margin-bottom:32px;">
            <div style="width:70px; height:70px; background:rgba(255,255,255,0.1); border-radius:20px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:32px; backdrop-filter:blur(4px); border:1px solid rgba(255,255,255,0.2);">
                🔒
            </div>
            <h1 style="color:white; font-size:28px; font-weight:800; margin:0 0 8px;">Nouveau mot de passe</h1>
            <p style="color:rgba(255,255,255,0.6); font-size:14px; margin:0;">Choisissez un mot de passe sécurisé</p>
        </div>

        <!-- Carte formulaire -->
        <div style="background:white; border-radius:20px; padding:36px; box-shadow:0 20px 60px rgba(0,0,0,0.3);">

            @if ($errors->any())
            <div style="background:#fef0f0; border:1px solid #f5c6c6; border-radius:10px; padding:12px 16px; margin-bottom:20px; font-size:14px; color:#e74c3c;">
                ❌ {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email -->
             
                <!-- Nouveau mot de passe -->
                <div style="margin-bottom:20px;">
                    <label style="display:block; font-size:13px; font-weight:700; color:#444; margin-bottom:8px;">
                        🔒 Nouveau mot de passe
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Minimum 8 caractères"
                        style="width:100%; padding:12px 16px; border:2px solid {{ $errors->has('password') ? '#e74c3c' : '#eee' }}; border-radius:10px; font-size:14px; color:#333; outline:none; box-sizing:border-box;"
                        onfocus="this.style.borderColor='#6c63ff'"
                        onblur="this.style.borderColor='#eee'">
                    @error('password')
                    <p style="color:#e74c3c; font-size:12px; margin:6px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmer mot de passe -->
                <div style="margin-bottom:28px;">
                    <label style="display:block; font-size:13px; font-weight:700; color:#444; margin-bottom:8px;">
                        🔒 Confirmer le mot de passe
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Répétez le mot de passe"
                        style="width:100%; padding:12px 16px; border:2px solid #eee; border-radius:10px; font-size:14px; color:#333; outline:none; box-sizing:border-box;"
                        onfocus="this.style.borderColor='#6c63ff'"
                        onblur="this.style.borderColor='#eee'">
                </div>

                <!-- Bouton -->
                <button type="submit"
                    style="width:100%; padding:14px; background:linear-gradient(135deg, #1a1a2e, #333); color:white; border:none; border-radius:10px; font-size:16px; font-weight:700; cursor:pointer; transition:all 0.3s;"
                    onmouseover="this.style.background='linear-gradient(135deg, #333, #555)'"
                    onmouseout="this.style.background='linear-gradient(135deg, #1a1a2e, #333)'">
                    💾 Enregistrer le nouveau mot de passe
                </button>

            </form>
        </div>

        <!-- Retour connexion -->
        <div style="text-align:center; margin-top:20px;">
            <a href="{{ route('login') }}" style="color:rgba(255,255,255,0.5); font-size:13px; text-decoration:none;">
                ← Retour à la connexion
            </a>
        </div>

    </div>
</section>

@endsection