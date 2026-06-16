@extends('layouts.app')

@section('content')

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

        <div style="text-align:center; margin-bottom:32px;">
            <div style="width:70px; height:70px; background:rgba(255,255,255,0.1); border-radius:20px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:32px; backdrop-filter:blur(4px); border:1px solid rgba(255,255,255,0.2);">
                🔒
            </div>
            <h1 style="color:white; font-size:28px; font-weight:800; margin:0 0 8px;">Nouveau mot de passe</h1>
            <p style="color:rgba(255,255,255,0.6); font-size:14px; margin:0;">Choisissez un mot de passe sécurisé</p>
        </div>

        <div style="background:white; border-radius:20px; padding:36px; box-shadow:0 20px 60px rgba(0,0,0,0.3);">

            @if ($errors->any())
            <div style="background:#fef0f0; border:1px solid #f5c6c6; border-radius:10px; padding:12px 16px; margin-bottom:20px; font-size:14px; color:#e74c3c;">
                ❌ {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div style="margin-bottom:15px;">
                    <label style="display:block; font-size:13px; font-weight:700; color:#444; margin-bottom:8px;">
                        🔒 Nouveau mot de passe
                    </label>
                    <div style="position: relative;">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Minimum 8 caractères"
                            style="width:100%; padding:12px 45px 12px 16px; border:2px solid {{ $errors->has('password') ? '#e74c3c' : '#eee' }}; border-radius:10px; font-size:14px; color:#333; outline:none; box-sizing:border-box;"
                            onfocus="this.style.borderColor='#6c63ff'"
                            onblur="this.style.borderColor='#eee'">
                        
                        <button type="button" id="togglePassword" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 16px; padding: 0;">
                            👁️
                        </button>
                    </div>

                    <div style="margin-top: 10px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <span id="strength-text" style="font-size: 11px; font-weight: bold; color: #aaa; text-transform: uppercase;">Sécurité : -</span>
                        </div>
                        <div style="width: 100%; height: 6px; background-color: #eee; border-radius: 3px; overflow: hidden;">
                            <div id="strength-bar" style="width: 0%; height: 100%; transition: all 0.3s ease; background-color: #e74c3c;"></div>
                        </div>
                    </div>

                    @error('password')
                    <p style="color:#e74c3c; font-size:12px; margin:6px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom:28px;">
                    <label style="display:block; font-size:13px; font-weight:700; color:#444; margin-bottom:8px;">
                        🔒 Confirmer le mot de passe
                    </label>
                    <div style="position: relative;">
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Répétez le mot de passe"
                            style="width:100%; padding:12px 45px 12px 16px; border:2px solid #eee; border-radius:10px; font-size:14px; color:#333; outline:none; box-sizing:border-box;"
                            onfocus="this.style.borderColor='#6c63ff'"
                            onblur="this.style.borderColor='#eee'">

                        <button type="button" id="togglePasswordConfirm" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 16px; padding: 0;">
                            👁️
                        </button>
                    </div>
                </div>

                <button type="submit"
                    style="width:100%; padding:14px; background:linear-gradient(135deg, #1a1a2e, #333); color:white; border:none; border-radius:10px; font-size:16px; font-weight:700; cursor:pointer; transition:all 0.3s;"
                    onmouseover="this.style.background='linear-gradient(135deg, #333, #555)'"
                    onmouseout="this.style.background='linear-gradient(135deg, #1a1a2e, #333)'">
                    💾 Enregistrer le nouveau mot de passe
                </button>

            </form>
        </div>

        <div style="text-align:center; margin-top:20px;">
            <a href="{{ route('login') }}" style="color:rgba(255,255,255,0.5); font-size:13px; text-decoration:none;">
                ← Retour à la connexion
            </a>
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    
    const togglePassword = document.getElementById('togglePassword');
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');

    // 1. Logique Afficher / Masquer le mot de passe
    function handleToggle(button, input) {
        button.addEventListener('click', function() {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    }
    handleToggle(togglePassword, passwordInput);
    handleToggle(togglePasswordConfirm, confirmInput);

    // 2. Calculateur de force du mot de passe
    passwordInput.addEventListener('input', function() {
        const val = passwordInput.value;
        let score = 0;

        if (val.length === 0) {
            strengthBar.style.width = '0%';
            strengthText.textContent = 'Sécurité : -';
            strengthText.style.color = '#aaa';
            return;
        }

        // Critères de sécurité
        if (val.length >= 8) score++; // Longueur minimale
        if (/[A-Z]/.test(val)) score++; // Majuscule
        if (/[0-9]/.test(val)) score++; // Chiffre
        if (/[^A-Za-z0-9]/.test(val)) score++; // Caractère spécial

        // Rendu visuel basé sur le score
        if (score <= 1) {
            strengthBar.style.width = '33%';
            strengthBar.style.backgroundColor = '#e74c3c'; // Rouge
            strengthText.textContent = 'Sécurité : Faible 🔴';
            strengthText.style.color = '#e74c3c';
        } else if (score === 2 || score === 3) {
            strengthBar.style.width = '66%';
            strengthBar.style.backgroundColor = '#f39c12'; // Orange
            strengthText.textContent = 'Sécurité : Moyen 🟡';
            strengthText.style.color = '#f39c12';
        } else if (score >= 4) {
            strengthBar.style.width = '100%';
            strengthBar.style.backgroundColor = '#2ecc71'; // Vert
            strengthText.textContent = 'Sécurité : Fort 🟢';
            strengthText.style.color = '#2ecc71';
        }
    });
});
</script>

@endsection