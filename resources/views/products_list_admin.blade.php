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

<section style="position:relative; background-image:url('{{ asset('images/bg-01.jpg') }}'); background-size:cover; background-position:center; padding:70px 20px; text-align:center;">
    <div style="position:absolute; inset:0; background:rgba(0,0,0,0.55);"></div>
    <div style="position:relative; z-index:1;">
        <span style="display:inline-block; background:rgba(255,255,255,0.15); color:white; padding:6px 18px; border-radius:25px; font-size:13px; font-weight:600; letter-spacing:2px; text-transform:uppercase; margin-bottom:16px; backdrop-filter:blur(4px); border:1px solid rgba(255,255,255,0.3);">
            Administration
        </span>
        <h1 style="color:white; font-size:36px; font-weight:800; margin:0;">🗂️ Gestion des produits</h1>
    </div>
</section>

<section style="padding:50px 0; background:#f8f9fa; min-height:60vh;">
    <div class="container">

        @if(session('success'))
        <div style="background:#eafaf1; border:1px solid #a9dfbf; border-radius:10px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:10px; font-size:14px; color:#27ae60; font-weight:600;">
            ✅ {{ session('success') }}
        </div>
        @endif

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
            <h4 style="font-size:20px; font-weight:800; color:#1a1a2e; margin:0;">
                Tous les produits
                <span style="background:#f0f0ff; color:#6c63ff; font-size:13px; padding:3px 10px; border-radius:20px; margin-left:8px; font-weight:700;">
                    {{ $products->total() }}
                </span>
            </h4>
            <a href="{{ route('create_product') }}"
               style="display:inline-flex; align-items:center; gap:8px; padding:12px 24px; background:#1a1a2e; color:white; border-radius:10px; font-size:14px; font-weight:700; text-decoration:none;"
               onmouseover="this.style.background='#333'"
               onmouseout="this.style.background='#1a1a2e'">
                ➕ Créer un produit
            </a>
        </div>

        <div style="background: white; padding: 16px; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.04); margin-bottom: 20px;">
            <form method="GET" action="{{ route('products_list_admin') }}" style="display: flex; gap: 10px; width: 100%;">
                <div style="position: relative; flex-grow: 1;">
                    <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); font-size: 16px;">🔍</span>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Rechercher un produit (contient le mot...)" 
                        style="width: 100%; padding: 12px 16px 12px 45px; border: 2px solid #eee; border-radius: 10px; font-size: 14px; color: #333; outline: none; box-sizing: border-box;"
                        onfocus="this.style.borderColor='#1a1a2e'"
                        onblur="this.style.borderColor='#eee'"
                    >
                </div>
                <button type="submit" style="padding: 12px 24px; background: #1a1a2e; color: white; border: none; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#333'" onmouseout="this.style.background='#1a1a2e'">
                    Filtrer
                </button>
                @if(request('search'))
                    <a href="{{ route('products_list_admin') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: #f3f4f6; color: #555; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                        Annuler
                    </a>
                @endif
            </form>
        </div>

        @if($products->isEmpty())
            <div style="background: white; border-radius: 16px; padding: 60px 20px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.06);">
                <div style="font-size: 50px; margin-bottom: 16px;">🔍❌</div>
                <h3 style="font-size: 20px; font-weight: 700; color: #1a1a2e; margin: 0 0 8px 0;">Aucun produit trouvé</h3>
                <p style="color: #777; font-size: 14px; margin: 0 0 20px 0;">La recherche pour "{{ request('search') }}" n'a donné aucun résultat.</p>
                <a href="{{ route('products_list_admin') }}" style="display: inline-flex; padding: 10px 20px; background: #1a1a2e; color: white; border-radius: 8px; font-size: 13px; font-weight: 700; text-decoration: none;">
                    Voir tous les produits
                </a>
            </div>
        @else
            <div style="background:white; border-radius:16px; box-shadow:0 4px 15px rgba(0,0,0,0.06); overflow:hidden;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f8f9fa; border-bottom:2px solid #f0f0f0;">
                            <th style="padding:16px 20px; text-align:left; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#aaa;">Image</th>
                            <th style="padding:16px 20px; text-align:left; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#aaa;">Nom</th>
                            <th style="padding:16px 20px; text-align:left; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#aaa;">Prix</th>
                            <th style="padding:16px 20px; text-align:left; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#aaa;">Catégorie</th>
                            <th style="padding:16px 20px; text-align:center; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#aaa;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr style="border-bottom:1px solid #f0f0f0;"
                            onmouseover="this.style.background='#fafafa'"
                            onmouseout="this.style.background='white'">
                            <td style="padding:16px 20px;">
                                <div style="width:70px; height:70px; border-radius:10px; overflow:hidden; cursor:pointer;"
                                     onclick="openImageModal('{{ asset($product->image_name) }}')">
                                    <img src="{{ asset($product->image_name) }}"
                                         alt="{{ $product->name }}"
                                         style="width:100%; height:100%; object-fit:cover; transition:transform 0.3s;"
                                         onmouseover="this.style.transform='scale(1.1)'"
                                         onmouseout="this.style.transform='scale(1)'">
                                </div>
                            </td>
                            <td style="padding:16px 20px; cursor:pointer;" onclick="openDetailModal({{ json_encode($product) }}, '{{ asset($product->image_name) }}')">
                                <p style="font-weight:600; color:#1a1a2e; margin:0; font-size:14px; text-decoration: underline; text-underline-offset: 4px;">
                                    {{ $product->name }} 📋
                                </p>
                            </td>
                            <td style="padding:16px 20px;">
                                @if(isset($product->sale_price) && $product->sale_price < $product->price)
                                    <span style="font-weight:700; color:#e74c3c; font-size:15px;">{{ $product->sale_price }} €</span>
                                    <span style="text-decoration: line-through; color: #aaa; font-size: 12px; margin-left: 5px;">{{ $product->price }} €</span>
                                @else
                                    <span style="font-weight:700; color:#1a1a2e; font-size:15px;">{{ $product->price }} €</span>
                                @endif
                            </td>
                            <td style="padding:16px 20px;">
                                <span style="background:#f0f0ff; color:#6c63ff; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700; text-transform:capitalize;">
                                    {{ $product->type }}
                                </span>
                            </td>
                            <td style="padding:16px 20px; text-align:center;">
                                <div style="display:flex; gap:8px; justify-content:center;">
                                    <form action="{{ route('edit', $product->id) }}" method="GET">
                                        @csrf
                                        <button type="submit"
                                            style="width:36px; height:36px; background:#e8f4fd; color:#2980b9; border:none; border-radius:8px; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center;"
                                            onmouseover="this.style.background='#2980b9'; this.style.color='white'"
                                            onmouseout="this.style.background='#e8f4fd'; this.style.color='#2980b9'">
                                            <i class="zmdi zmdi-edit"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('delete_product', $product->id) }}" method="POST"
                                          onsubmit="return confirm('Supprimer ce produit ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            style="width:36px; height:36px; background:#fef0f0; color:#e74c3c; border:none; border-radius:8px; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center;"
                                            onmouseover="this.style.background='#e74c3c'; this.style.color='white'"
                                            onmouseout="this.style.background='#fef0f0'; this.style.color='#e74c3c'">
                                            <i class="zmdi zmdi-delete"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="modern-pagination" style="margin-top:30px; display:flex; justify-content:center; width:100%;">
                {{ $products->appends(request()->query())->onEachSide(1)->links() }}
            </div>
        @endif

    </div>
</section>

@endsection

@section('scripts')
<div id="image-modal" onclick="closeImageModal()"
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:2000; justify-content:center; align-items:center; cursor:pointer;">
    <div style="position:relative; max-width:90%; max-height:90vh;" onclick="event.stopPropagation()">
        <span onclick="closeImageModal()"
              style="position:absolute; top:-15px; right:-15px; width:32px; height:32px; background:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:18px; cursor:pointer;">
            ×
        </span>
        <img id="image-modal-img" src="" alt="IMG"
             style="max-width:100%; max-height:85vh; border-radius:8px; object-fit:contain;">
    </div>
</div>

<div id="detail-modal" onclick="closeDetailModal()"
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:2000; justify-content:center; align-items:center; padding:20px;">
    <div style="position:relative; background:white; width:100%; max-width:550px; border-radius:20px; overflow:hidden; box-shadow:0 20px 50px rgba(0,0,0,0.3); display:flex; flex-direction:column; animation: fadeIn 0.3s;" onclick="event.stopPropagation()">
        
        <span onclick="closeDetailModal()"
              style="position:absolute; top:15px; right:15px; width:36px; height:36px; background:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:20px; cursor:pointer; color:#333; font-weight:bold; z-index:10; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            ×
        </span>

        <div style="width:100%; height:280px; background:#f4f5f7; display:flex; align-items:center; justify-content:center; padding:20px; box-sizing:border-box;">
            <img id="detail-img" src="" alt="" style="max-width:100%; max-height:100%; object-fit:contain; border-radius:8px;">
        </div>

        <div style="padding:30px;">
            <div style="margin-bottom:12px;">
                <span id="detail-type" style="background:#f0f0ff; color:#6c63ff; padding:4px 14px; border-radius:20px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px;"></span>
            </div>
            
            <h2 id="detail-name" style="font-size:24px; font-weight:800; color:#1a1a2e; margin:0 0 16px 0;"></h2>
            
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px; padding-bottom:20px; border-bottom:1px solid #eee;">
                <span id="detail-price-new" style="font-size:24px; font-weight:800; color:#1a1a2e;"></span>
                <span id="detail-price-old" style="font-size:16px; text-decoration:line-through; color:#aaa; display:none;"></span>
                <span id="detail-badge-sale" style="background:#fef0f0; color:#e74c3c; font-size:11px; font-weight:800; padding:3px 8px; border-radius:6px; display:none;">SOLDÉ</span>
            </div>

            <p style="font-size:12px; font-weight:700; text-transform:uppercase; color:#aaa; margin:0 0 6px 0; letter-spacing:0.5px;">Description</p>
            <p id="detail-desc" style="font-size:14px; color:#555; line-height:1.6; margin:0; max-height:140px; overflow-y:auto; white-space: pre-wrap;"></p>
        </div>
    </div>
</div>

<script>
function openImageModal(src) {
    document.getElementById('image-modal-img').src = src;
    document.getElementById('image-modal').style.display = 'flex';
}
function closeImageModal() {
    document.getElementById('image-modal').style.display = 'none';
}

function openDetailModal(product, imageUrl) {
    document.getElementById('detail-img').src = imageUrl;
    document.getElementById('detail-name').textContent = product.name;
    document.getElementById('detail-type').textContent = product.type || 'Général';
    document.getElementById('detail-desc').textContent = product.description || 'Aucune description disponible pour ce produit.';

    const priceOld = document.getElementById('detail-price-old');
    const priceNew = document.getElementById('detail-price-new');
    const badgeSale = document.getElementById('detail-badge-sale');

    if (product.sale_price && parseFloat(product.sale_price) < parseFloat(product.price)) {
        priceNew.textContent = product.sale_price + ' €';
        priceNew.style.color = '#e74c3c';
        priceOld.textContent = product.price + ' €';
        priceOld.style.display = 'inline';
        badgeSale.style.display = 'inline';
    } else {
        priceNew.textContent = product.price + ' €';
        priceNew.style.color = '#1a1a2e';
        priceOld.style.display = 'none';
        badgeSale.style.display = 'none';
    }

    document.getElementById('detail-modal').style.display = 'flex';
}

function closeDetailModal() {
    document.getElementById('detail-modal').style.display = 'none';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
        closeDetailModal();
    }
});
</script>

<style>
/* 1. ALIGNEMENT EN LIGNE */
.modern-pagination nav {
    display: flex !important;
    justify-content: center;
    align-items: center;
    flex-wrap: nowrap !important;
}

/* 2. BASE DES CASES : PLUS DE BORDURES, FOND ULTRA LÉGER */
.modern-pagination a, 
.modern-pagination span.relative {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    min-width: 38px !important;
    height: 38px !important;
    padding: 0 12px !important;
    margin: 0 3px !important;
    background-color: #f3f4f6 !important; /* Fond gris très doux au lieu du blanc */
    color: #4b5563 !important; /* Texte gris foncé plus doux que le noir pur */
    border: none !important; /* ON SUPPRIME TOUTES LES BORDURES CHOC */
    border-radius: 8px !important;
    font-size: 14px !important;
    font-weight: 700 !important;
    text-decoration: none !important;
    box-sizing: border-box !important;
    transition: all 0.15s ease-in-out !important;
    cursor: pointer !important;
}

/* 3. CENTRAGE PARFAIT DES FLÈCHES */
.modern-pagination nav svg,
.modern-pagination a svg,
.modern-pagination span svg {
    width: 14px !important;
    height: 14px !important;
    margin: 0 !important;
    padding: 0 !important;
    display: block !important;
}

/* 4. PAGE ACTUELLE : METTRE EN VALEUR SANS SURCHARGE */
.modern-pagination span.relative[aria-current="page"] {
    background-color: #1a1a2e !important; /* Bleu nuit comme ton header pour la cohérence */
    color: white !important;
    cursor: default !important;
}

/* 5. AU SURVOL : EFFET FLUIDE */
.modern-pagination a:hover {
    background-color: #6c63ff !important; /* Devient violet au survol */
    color: white !important;
}

.modern-pagination a:hover svg {
    fill: white !important;
    stroke: white !important;
}

/* 6. BOUTONS DÉSACTIVÉS (ex: page précédente quand on est sur la page 1) */
.modern-pagination span.relative:not([aria-current="page"]) {
    background-color: #f9fafb !important;
    color: #d1d5db !important;
    cursor: not-allowed !important;
}
.modern-pagination span.relative:not([aria-current="page"]) svg {
    fill: #d1d5db !important;
    stroke: #d1d5db !important;
}

/* 7. NETTOYAGE DES TEXTES PARASITES DE LARAVEL */
.modern-pagination nav > div:first-child {
    display: none !important;
}
.modern-pagination nav > div:last-child {
    display: flex !important;
    flex-direction: row !important;
}

/* Animation de la modale */
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
</style>
@endsection