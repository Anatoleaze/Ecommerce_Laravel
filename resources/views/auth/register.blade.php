@extends('layouts.app')

@section('content')

<!-- Header Vue inchangé -->
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

<section style="
    min-height:90vh;
    background:linear-gradient(135deg,#1a1a2e 0%,#333 100%);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:40px 20px;
">

    <div style="width:100%; max-width:520px;">

        <!-- Header -->
        <div style="text-align:center; margin-bottom:32px;">

            <div style="
                width:70px;
                height:70px;
                background:rgba(255,255,255,.1);
                border-radius:20px;
                display:flex;
                align-items:center;
                justify-content:center;
                margin:0 auto 16px;
                font-size:30px;
                backdrop-filter:blur(4px);
                border:1px solid rgba(255,255,255,.2);
            ">
                🧾
            </div>

            <h1 style="
                color:white;
                font-size:26px;
                font-weight:800;
                margin:0 0 8px;
            ">
                Créer un compte
            </h1>

            <p style="
                color:rgba(255,255,255,.6);
                font-size:14px;
                margin:0;
            ">
                Rejoignez-nous en quelques secondes
            </p>

        </div>

        <!-- Card -->
        <div style="
            background:white;
            border-radius:20px;
            padding:36px;
            box-shadow:0 20px 60px rgba(0,0,0,.3);
        ">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nom -->
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:700;color:#444;margin-bottom:8px;">
                        👤 Nom <span style="color:#e74c3c;">*</span>
                    </label>

                    <input id="name"
                           type="text"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           autocomplete="name"
                           autofocus
                           placeholder="Votre nom"
                           style="
                               width:100%;
                               padding:12px 16px;
                               border:2px solid #eee;
                               border-radius:10px;
                               font-size:14px;
                               outline:none;
                           ">

                    @error('name')
                        <div style="color:#e74c3c;font-size:12px;margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Prénom -->
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:700;color:#444;margin-bottom:8px;">
                        👤 Prénom <span style="color:#e74c3c;">*</span>
                    </label>

                    <input id="first_name"
                           type="text"
                           name="first_name"
                           value="{{ old('first_name') }}"
                           required
                           placeholder="Votre prénom"
                           style="
                               width:100%;
                               padding:12px 16px;
                               border:2px solid #eee;
                               border-radius:10px;
                               font-size:14px;
                           ">

                    @error('first_name')
                        <div style="color:#e74c3c;font-size:12px;margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email -->
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:700;color:#444;margin-bottom:8px;">
                        ✉️ Email <span style="color:#e74c3c;">*</span>
                    </label>

                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           placeholder="votre@email.com"
                           style="
                               width:100%;
                               padding:12px 16px;
                               border:2px solid #eee;
                               border-radius:10px;
                               font-size:14px;
                           ">

                    @error('email')
                        <div style="color:#e74c3c;font-size:12px;margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div style="margin-bottom:16px;">

                    <label style="display:block;font-size:13px;font-weight:700;color:#444;margin-bottom:8px;">
                        🔒 Mot de passe <span style="color:#e74c3c;">*</span>
                    </label>

                    <div style="position:relative;">

                        <input id="password"
                               type="password"
                               name="password"
                               required
                               autocomplete="new-password"
                               placeholder="Mot de passe"
                               oninput="checkPasswordStrength()"
                               style="
                                    width:100%;
                                    padding:12px 55px 12px 16px;
                                    border:2px solid #eee;
                                    border-radius:10px;
                                    font-size:14px;
                               ">

                        <button type="button"
                                onclick="togglePassword()"
                                style="
                                    position:absolute;
                                    right:15px;
                                    top:50%;
                                    transform:translateY(-50%);
                                    border:none;
                                    background:none;
                                    cursor:pointer;
                                ">
                            👁
                        </button>

                    </div>

                    <!-- Barre -->
                    <div style="margin-top:10px;">

                        <div style="
                            background:#eee;
                            height:8px;
                            border-radius:20px;
                            overflow:hidden;
                        ">
                            <div id="password-strength-bar"
                                 style="
                                    width:0%;
                                    height:100%;
                                    background:#e74c3c;
                                    transition:.3s;
                                 ">
                            </div>
                        </div>

                        <div id="password-strength-text"
                             style="
                                margin-top:6px;
                                font-size:12px;
                                color:#999;
                                font-weight:600;
                             ">
                            Force du mot de passe
                        </div>

                    </div>

                    @error('password')
                        <div style="color:#e74c3c;font-size:12px;margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <!-- Confirmation -->
                <div style="margin-bottom:24px;">

                    <label style="display:block;font-size:13px;font-weight:700;color:#444;margin-bottom:8px;">
                        🔒 Confirmation <span style="color:#e74c3c;">*</span>
                    </label>

                    <div style="position:relative;">

                        <input id="password-confirm"
                               type="password"
                               name="password_confirmation"
                               required
                               placeholder="Confirmez le mot de passe"
                               style="
                                    width:100%;
                                    padding:12px 55px 12px 16px;
                                    border:2px solid #eee;
                                    border-radius:10px;
                                    font-size:14px;
                               ">

                        <button type="button"
                                onclick="toggleConfirmPassword()"
                                style="
                                    position:absolute;
                                    right:15px;
                                    top:50%;
                                    transform:translateY(-50%);
                                    border:none;
                                    background:none;
                                    cursor:pointer;
                                ">
                            👁
                        </button>

                    </div>

                </div>

                <!-- Bouton -->
                <button type="submit"
                        style="
                            width:100%;
                            padding:14px;
                            background:linear-gradient(135deg,#1a1a2e,#333);
                            color:white;
                            border:none;
                            border-radius:12px;
                            font-size:15px;
                            font-weight:700;
                            cursor:pointer;
                        ">
                    🚀 Créer mon compte
                </button>

            </form>

        </div>

        <!-- Lien connexion -->
        <div style="text-align:center;margin-top:18px;">
            <a href="{{ route('login') }}"
               style="
                    color:rgba(255,255,255,.6);
                    font-size:13px;
                    text-decoration:none;
               ">
                ← Déjà un compte ? Se connecter
            </a>
        </div>

    </div>

</section>

<script>

function togglePassword() {
    let password = document.getElementById('password');

    password.type =
        password.type === 'password'
        ? 'text'
        : 'password';
}

function toggleConfirmPassword() {
    let confirmPassword = document.getElementById('password-confirm');

    confirmPassword.type =
        confirmPassword.type === 'password'
        ? 'text'
        : 'password';
}

function checkPasswordStrength() {

    const password = document.getElementById('password').value;

    let score = 0;

    if (password.length >= 8) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[a-z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;

    const bar = document.getElementById('password-strength-bar');
    const text = document.getElementById('password-strength-text');

    if (score <= 2) {

        bar.style.width = '33%';
        bar.style.background = '#e74c3c';

        text.innerHTML = '🔴 Faible';
        text.style.color = '#e74c3c';

    }
    else if (score <= 3) {

        bar.style.width = '66%';
        bar.style.background = '#f39c12';

        text.innerHTML = '🟠 Moyen';
        text.style.color = '#f39c12';

    }
    else {

        bar.style.width = '100%';
        bar.style.background = '#27ae60';

        text.innerHTML = '🟢 Fort';
        text.style.color = '#27ae60';

    }
}

</script>

@endsection