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
<section style="position:relative; background-image:url('{{ asset('images/bg-01.jpg') }}'); background-size:cover; background-position:center; padding:70px 20px; text-align:center;">
    <div style="position:absolute; inset:0; background:rgba(0,0,0,0.55);"></div>
    <div style="position:relative; z-index:1;">
        <span style="display:inline-block; background:rgba(255,255,255,0.15); color:white; padding:6px 18px; border-radius:25px; font-size:13px; font-weight:600; letter-spacing:2px; text-transform:uppercase; margin-bottom:16px; backdrop-filter:blur(4px); border:1px solid rgba(255,255,255,0.3);">
            Administration
        </span>
        <h1 style="color:white; font-size:36px; font-weight:800; margin:0;">🗂️ Gestion des produits</h1>
    </div>
</section>

<!-- Contenu -->
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
                        <td style="padding:16px 20px;">
                            <p style="font-weight:600; color:#333; margin:0; font-size:14px;">{{ $product->name }}</p>
                        </td>
                        <td style="padding:16px 20px;">
                            <span style="font-weight:700; color:#1a1a2e; font-size:15px;">{{ $product->price }} €</span>
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

        <div style="margin-top:30px; display:flex; justify-content:center;">
            {{ $products->links() }}
        </div>

    </div>
</section>

@endsection

@section('scripts')
<!-- Modale Image -->
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

<script>
function openImageModal(src) {
    document.getElementById('image-modal-img').src = src;
    document.getElementById('image-modal').style.display = 'flex';
}
function closeImageModal() {
    document.getElementById('image-modal').style.display = 'none';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeImageModal();
});
</script>
@endsection