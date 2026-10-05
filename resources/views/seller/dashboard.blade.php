<x-layouts.app title="Tableau de bord vendeur | DoYo.shop">
    <main class="seller-dashboard">
        <header class="seller-dashboard-header">
            <div><p class="eyebrow">Espace vendeur</p><h1>Bonjour, {{ auth()->user()->name }}</h1><p>Votre catalogue sera visible ici dès que vous publierez vos premiers produits.</p></div>
            <form method="POST" action="{{ route('seller.logout') }}">@csrf<button type="submit" class="button button-light">Se déconnecter</button></form>
        </header>
        @if (session('status'))<p class="seller-status">{{ session('status') }}</p>@endif
        <section class="seller-publish-grid">
            <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data" class="seller-product-form">
                @csrf
                <p class="eyebrow">Nouveau produit</p>
                <h2>Publier dans la boutique</h2>
                <label for="product-name">Nom du produit</label>
                <input id="product-name" name="name" type="text" value="{{ old('name') }}" required>
                @error('name')<small class="auth-error">{{ $message }}</small>@enderror
                <label for="product-description">Description</label>
                <textarea id="product-description" name="description" rows="4">{{ old('description') }}</textarea>
                @error('description')<small class="auth-error">{{ $message }}</small>@enderror
                <div class="seller-form-row"><div><label for="product-price">Prix</label><input id="product-price" name="price" type="number" min="0" step="0.01" value="{{ old('price') }}" required></div><div><label for="product-stock">Stock</label><input id="product-stock" name="stock" type="number" min="0" value="{{ old('stock', 1) }}" required></div></div>
                @error('price')<small class="auth-error">{{ $message }}</small>@enderror
                @error('stock')<small class="auth-error">{{ $message }}</small>@enderror
                <label for="product-image">Image du produit</label>
                <input id="product-image" name="image" type="file" accept="image/jpeg,image/png,image/webp" required>
                @error('image')<small class="auth-error">{{ $message }}</small>@enderror
                <button type="submit" class="button button-dark auth-submit">Publier le produit <span>→</span></button>
            </form>
            <section class="seller-products"><p class="eyebrow">Catalogue publié</p><h2>{{ $products->count() }} produit(s)</h2>@forelse ($products as $product)<article class="seller-product-row"><img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}"><div><strong>{{ $product->name }}</strong><span>${{ number_format((float) $product->price, 2) }} · Stock : {{ $product->stock }}</span></div><form method="POST" action="{{ route('seller.products.destroy', $product) }}">@csrf @method('DELETE')<button type="submit" class="cart-remove">Retirer</button></form></article>@empty<p class="cart-empty">Aucun produit publié pour le moment.</p>@endforelse</section>
        </section>
    </main>
</x-layouts.app>