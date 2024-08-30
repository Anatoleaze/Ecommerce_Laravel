@extends('layouts.app')

@section('content')

<!-- Title page -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
    <h2 class="ltext-105 cl0 txt-center">
        Contact
    </h2>
</section>	


<!-- Content page -->
<section class="bg0 p-t-75 p-b-120">
    <div class="container">
        <div class="row p-b-148">
            <div class="col-md-7 col-lg-8">
                <div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
                    <h3 class="mtext-111 cl2 p-b-16">
                        Notre histoire
                    </h3>

                    <p class="stext-113 cl6 p-b-26">
                        Tout a commencé lorsque l'idée de créer une boutique de vêtements en ligne germa dans l'esprit d'un jeune entrepreneur passionné par la mode. Observant que de nombreuses personnes recherchaient des vêtements uniques et tendance, il réalisa qu'il y avait un marché non exploité pour des créations originales. Frustré par l'uniformité des offres dans les magasins physiques, il décida de se lancer dans l'aventure du commerce électronique. 
                    </p>
                    
                    <p class="stext-113 cl6 p-b-26">
                        Après plusieurs mois de recherche sur les tendances de la mode, l'analyse de la concurrence et la définition de son public cible, il conçut une vision claire pour sa boutique. Il souhaitait non seulement offrir des vêtements stylés, mais aussi créer un espace où chaque client se sentirait valorisé et écouté. C’est ainsi qu’il lança "{{ config('app.name', 'Laravel') }} ", une boutique en ligne dédiée à la mode originale et accessible, visant à transformer l'expérience d'achat en ligne en quelque chose de spécial et mémorable. </p>
                    </p>
                   
                </div>
            </div>

            <div class="col-11 col-md-5 col-lg-4 m-lr-auto">
                <div class="how-bor1 ">
                    <div class="hov-img0">
                        <img src="images/about-01.jpg" alt="IMG">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="order-md-2 col-md-7 col-lg-8 p-b-30">
                <div class="p-t-7 p-l-85 p-l-15-lg p-l-0-md">
                    <h3 class="mtext-111 cl2 p-b-16">
                        Notre Mission
                    </h3>

                    <p class="stext-113 cl6 p-b-26">
                        {{ config('app.name', 'Laravel') }} a pour mission de devenir une référence en matière de satisfaction client en fournissant une expérience d'achat exceptionnelle avec une large gamme de produits, des prix compétitifs et une livraison rapide et fiable. Nous investissons continuellement dans l'innovation et la technologie, intégrant les dernières avancées pour optimiser notre plateforme et proposer des fonctionnalités avant-gardistes. En parallèle, nous nous engageons à promouvoir la durabilité et la responsabilité sociale en adoptant des pratiques écologiques, minimisant notre empreinte carbone, et en soutenant activement les communautés locales à travers des programmes de dons et de volontariat.
                    </p>

                    <div class="bor16 p-l-29 p-b-9 m-t-22">
                        <p class="stext-114 cl6 p-r-40 p-b-11">
                            La créativité consiste simplement à relier les choses entre elles. Lorsque vous demandez à des personnes créatives comment elles ont fait quelque chose, elles se sentent un peu coupables parce qu'elles ne l'ont pas vraiment fait, elles ont juste vu quelque chose. Au bout d'un certain temps, cela leur a semblé évident. 
                        </p>

                        <span class="stext-111 cl8">
                            - Steve Job
                        </span>
                    </div>
                </div>
            </div>

            <div class="order-md-1 col-11 col-md-5 col-lg-4 m-lr-auto p-b-30">
                <div class="how-bor2">
                    <div class="hov-img0">
                        <img src="images/about-02.jpg" alt="IMG">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>	
	
    <section class="bg0 p-t-104 p-b-116">
		<div class="container">
			<div class="flex-w flex-tr">
				<div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
					<contact-form-component/>
				</div>

				<div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
					<div class="flex-w w-full p-b-42">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-map-marker"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Adresse
							</span>

							<p class="stext-115 cl6 size-213 p-t-18">
                                67 Boulevard du Généra Leclerc, 92110 Clichy
						</div>
					</div>

					<div class="flex-w w-full p-b-42">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-phone-handset"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Service Client
							</span>

							<p class="stext-115 cl1 size-213 p-t-18">
								08 05 10 14 20
							</p>
						</div>
					</div>

					<div class="flex-w w-full">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-envelope"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Adresse Mail
							</span>

							<p class="stext-115 cl1 size-213 p-t-18">
								contact@example.com
							</p>
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