@extends('layouts.app')

@section('content')

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
                🔐
            </div>

            <h1 style="color: white; font-size: 26px; font-weight: 800; margin: 0 0 8px;">
                Mot de passe oublié
            </h1>

            <p style="color: rgba(255, 255, 255, 0.6); font-size: 14px; margin: 0;">
                Entrez votre email pour recevoir un lien de réinitialisation
            </p>

        </div>

        <!-- Card -->
        <div style="background: white; border-radius: 20px; padding: 36px; box-shadow: rgba(0, 0, 0, 0.3) 0px 20px 60px;">

            @if (session('status'))
                <div style="
                    background: rgba(0, 200, 100, 0.1);
                    border: 1px solid rgba(0, 200, 100, 0.3);
                    color: #2e7d32;
                    padding: 12px;
                    border-radius: 10px;
                    font-size: 13px;
                    margin-bottom: 20px;
                ">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #444; margin-bottom: 8px;">
                        ✉️ Adresse email
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus
                        placeholder="votre@email.com"
                        style="
                            width: 100%;
                            padding: 12px 16px;
                            border: 2px solid #eee;
                            border-radius: 10px;
                            font-size: 14px;
                            color: #333;
                            outline: none;
                            transition: 0.2s;
                            box-sizing: border-box;
                        "
                        onfocus="this.style.borderColor='#6c63ff'"
                        onblur="this.style.borderColor='#eee'"
                    >

                    @error('email')
                        <div style="color: #e74c3c; font-size: 12px; margin-top: 6px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Bouton -->
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

                    📩 Envoyer le lien de réinitialisation
                </button>

            </form>

        </div>

        <!-- Retour login -->
        <div style="text-align: center; margin-top: 18px;">
            <a href="{{ route('login') }}"
               style="color: rgba(255,255,255,0.6); font-size: 13px; text-decoration: none;">
                ← Retour à la connexion
            </a>
        </div>

    </div>

</section>

@endsection