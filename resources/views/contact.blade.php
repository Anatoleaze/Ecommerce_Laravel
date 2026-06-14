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

<!-- Hero -->
<section style="position:relative; background-image:url('{{ asset('images/bg-01.jpg') }}'); background-size:cover; background-position:center; padding:100px 20px; text-align:center;">
    <div style="position:absolute; inset:0; background:rgba(0,0,0,0.55);"></div>
    <div style="position:relative; z-index:1;">
        <span style="display:inline-block; background:rgba(255,255,255,0.15); color:white; padding:6px 18px; border-radius:25px; font-size:13px; font-weight:600; letter-spacing:2px; text-transform:uppercase; margin-bottom:16px; backdrop-filter:blur(4px); border:1px solid rgba(255,255,255,0.3);">
            À propos & Contact
        </span>
        <h1 style="color:white; font-size:48px; font-weight:800; margin:0;">Notre histoire</h1>
    </div>
</section>

<!-- Notre histoire -->
<section style="padding:80px 0; background:white;">
    <div class="container">
        <div class="row" style="align-items:center; gap:30px 0;">
            <div class="col-md-7">
                <span style="display:inline-block; background:#f0f0ff; color:#6c63ff; padding:5px 14px; border-radius:20px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:16px;">
                    Notre histoire
                </span>
                <h2 style="font-size:36px; font-weight:800; color:#1a1a2e; margin-bottom:24px; line-height:1.2;">
                    Comment tout a commencé
                </h2>
                <p style="font-size:15px; color:#666; line-height:1.9; margin-bottom:18px;">
                    Tout a commencé lorsque l'idée de créer une boutique de vêtements en ligne germa dans l'esprit d'un jeune entrepreneur passionné par la mode. Observant que de nombreuses personnes recherchaient des vêtements uniques et tendance, il réalisa qu'il y avait un marché non exploité pour des créations originales. Frustré par l'uniformité des offres dans les magasins physiques, il décida de se lancer dans l'aventure du commerce électronique.
                </p>
                <p style="font-size:15px; color:#666; line-height:1.9;">
                    Après plusieurs mois de recherche, il lança <strong style="color:#1a1a2e;">{{ config('app.name', 'Laravel') }}</strong>, une boutique en ligne dédiée à la mode originale et accessible, visant à transformer l'expérience d'achat en ligne en quelque chose de spécial et mémorable.
                </p>
                <div style="display:flex; gap:30px; margin-top:36px; flex-wrap:wrap;">
                    <div style="text-align:center;">
                        <div style="font-size:32px; font-weight:800; color:#6c63ff;">500+</div>
                        <div style="font-size:13px; color:#aaa; font-weight:600;">Produits</div>
                    </div>
                    <div style="text-align:center;">
                        <div style="font-size:32px; font-weight:800; color:#6c63ff;">10k+</div>
                        <div style="font-size:13px; color:#aaa; font-weight:600;">Clients</div>
                    </div>
                    <div style="text-align:center;">
                        <div style="font-size:32px; font-weight:800; color:#6c63ff;">98%</div>
                        <div style="font-size:13px; color:#aaa; font-weight:600;">Satisfaction</div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div style="border-radius:20px; overflow:hidden; box-shadow:0 20px 50px rgba(0,0,0,0.12);">
                    <img src="{{ asset('images/about-01.jpg') }}" alt="Notre histoire" style="width:100%; height:400px; object-fit:cover; display:block;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Notre Mission -->
<section style="padding:80px 0; background:#f8f9fa;">
    <div class="container">
        <div class="row" style="align-items:center; gap:30px 0;">
            <div class="col-md-5 order-md-1">
                <div style="border-radius:20px; overflow:hidden; box-shadow:0 20px 50px rgba(0,0,0,0.12);">
                    <img src="{{ asset('images/about-02.jpg') }}" alt="Notre mission" style="width:100%; height:400px; object-fit:cover; display:block;">
                </div>
            </div>
            <div class="col-md-7 order-md-2">
                <span style="display:inline-block; background:#f0f0ff; color:#6c63ff; padding:5px 14px; border-radius:20px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:16px;">
                    Notre mission
                </span>
                <h2 style="font-size:36px; font-weight:800; color:#1a1a2e; margin-bottom:24px; line-height:1.2;">
                    Ce qui nous anime
                </h2>
                <p style="font-size:15px; color:#666; line-height:1.9; margin-bottom:28px;">
                    {{ config('app.name', 'Laravel') }} a pour mission de devenir une référence en matière de satisfaction client en fournissant une expérience d'achat exceptionnelle avec une large gamme de produits, des prix compétitifs et une livraison rapide et fiable. Nous investissons continuellement dans l'innovation et la technologie, intégrant les dernières avancées pour optimiser notre plateforme.
                </p>
                <div style="background:white; border-left:4px solid #6c63ff; border-radius:0 12px 12px 0; padding:20px 24px; box-shadow:0 4px 15px rgba(0,0,0,0.06); margin-bottom:24px;">
                    <p style="font-size:15px; color:#555; line-height:1.8; font-style:italic; margin-bottom:12px;">
                        "La créativité consiste simplement à relier les choses entre elles. Lorsque vous demandez à des personnes créatives comment elles ont fait quelque chose, elles se sentent un peu coupables parce qu'elles ne l'ont pas vraiment fait, elles ont juste vu quelque chose."
                    </p>
                    <span style="font-size:13px; font-weight:700; color:#6c63ff;">— Steve Jobs</span>
                </div>
                <div style="display:flex; gap:16px; flex-wrap:wrap;">
                    @foreach(['🌱 Éco-responsable', '🚀 Innovation', '❤️ Communauté'] as $val)
                    <div style="background:white; padding:10px 18px; border-radius:25px; font-size:13px; font-weight:600; color:#333; box-shadow:0 2px 10px rgba(0,0,0,0.07);">
                        {{ $val }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Contact -->
<section style="padding:80px 0; background:white;">
    <div class="container">

        <div style="text-align:center; margin-bottom:50px;">
            <span style="display:inline-block; background:#f0f0ff; color:#6c63ff; padding:5px 14px; border-radius:20px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:16px;">
                Contact
            </span>
            <h2 style="font-size:36px; font-weight:800; color:#1a1a2e; margin:0;">
                Parlons-nous 👋
            </h2>
        </div>

        <div class="row" style="gap:30px 0;">

            <!-- Formulaire -->
            <div class="col-md-7">
                <div style="background:#f8f9fa; border-radius:20px; padding:36px; box-shadow:0 4px 20px rgba(0,0,0,0.05);">
                    <contact-form-component/>
                </div>
            </div>

            <!-- Infos contact -->
            <div class="col-md-5">
                <div style="display:flex; flex-direction:column; gap:16px;">

                    <div style="background:white; border-radius:16px; padding:20px; box-shadow:0 4px 15px rgba(0,0,0,0.06); display:flex; align-items:flex-start; gap:16px;">
                        <div style="width:48px; height:48px; background:#f0f0ff; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:22px; flex-shrink:0;">
                            📍
                        </div>
                        <div>
                            <p style="font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#aaa; margin:0 0 6px;">Adresse</p>
                            <p style="font-size:14px; font-weight:600; color:#333; margin:0;">67 Boulevard du Général Leclerc, 92110 Clichy</p>
                        </div>
                    </div>

                    <div style="background:white; border-radius:16px; padding:20px; box-shadow:0 4px 15px rgba(0,0,0,0.06); display:flex; align-items:flex-start; gap:16px;">
                        <div style="width:48px; height:48px; background:#f0fff4; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:22px; flex-shrink:0;">
                            📞
                        </div>
                        <div>
                            <p style="font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#aaa; margin:0 0 6px;">Service Client</p>
                            <p style="font-size:14px; font-weight:600; color:#333; margin:0;">08 05 10 14 20</p>
                        </div>
                    </div>

                    <div style="background:white; border-radius:16px; padding:20px; box-shadow:0 4px 15px rgba(0,0,0,0.06); display:flex; align-items:flex-start; gap:16px;">
                        <div style="width:48px; height:48px; background:#fff8f0; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:22px; flex-shrink:0;">
                            ✉️
                        </div>
                        <div>
                            <p style="font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#aaa; margin:0 0 6px;">Adresse Mail</p>
                            <p style="font-size:14px; font-weight:600; color:#333; margin:0;">contact@example.com</p>
                        </div>
                    </div>

                    <!-- Horaires -->
                    <div style="background:#1a1a2e; border-radius:16px; padding:24px;">
                        <p style="color:white; font-weight:700; margin-bottom:16px; font-size:15px;">🕐 Horaires d'ouverture</p>
                        @foreach([
                            ['Lundi - Vendredi', '9h00 - 18h00'],
                            ['Samedi', '10h00 - 16h00'],
                            ['Dimanche', 'Fermé'],
                        ] as $h)
                        <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                            <span style="color:rgba(255,255,255,0.6); font-size:13px;">{{ $h[0] }}</span>
                            <span style="color:white; font-size:13px; font-weight:600;">{{ $h[1] }}</span>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<script>
    window.Laravel = {
        userEmail: "{{ auth()->check() ? auth()->user()->email : '' }}"
    };
</script>

@endsection