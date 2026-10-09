<x-layouts.app title="Tableau de bord vendeur | DoYo.shop">
    <main class="seller-dashboard">
        <aside class="seller-sidebar" aria-label="Navigation vendeur">
            <a href="{{ route('seller.dashboard') }}" class="seller-brand" aria-label="Accueil vendeur">✥</a>
            <nav class="seller-nav">
                <a href="{{ route('seller.dashboard') }}" class="is-active" aria-label="Tableau de bord">▣</a>
                <a href="#catalogue" aria-label="Catalogue">▤</a>
                <a href="#ajouter-produit" aria-label="Ajouter un produit">＋</a>
                <a href="#performances" aria-label="Performances">⌁</a>
            </nav>
            <div class="seller-sidebar-bottom">
                <a href="{{ route('seller.settings') }}" aria-label="Paramètres">⚙</a>
                <form method="POST" action="{{ route('seller.logout') }}">
                    @csrf
                    <button type="submit" aria-label="Se déconnecter">↪</button>
                </form>
            </div>
        </aside>

        <div class="seller-workspace">
            <header class="seller-topbar">
                <div>
                    <p class="seller-kicker">Espace vendeur / Vue générale</p>
                    <h1>Bonjour, {{ auth()->user()->name }}</h1>
                </div>
                <div class="seller-topbar-actions">
                    <button type="button" class="seller-icon-button" aria-label="Notifications">♧</button>
                    <button type="button" class="seller-icon-button" aria-label="Rechercher">⌕</button>
                    @if (auth()->user()->avatar_path)
                        <img class="seller-avatar seller-avatar-image" src="{{ asset('storage/'.auth()->user()->avatar_path) }}" alt="Photo de {{ auth()->user()->name }}">
                    @else
                        <span class="seller-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    @endif
                </div>
            </header>

            @if (session('status'))
                <p class="seller-status">{{ session('status') }}</p>
            @endif

            <section class="seller-analytics-grid" id="performances">
                <article class="seller-hero-card">
                    <div class="seller-hero-copy">
                        <p class="seller-kicker">Résumé de la boutique</p>
                        <h2>Développez<br>votre collection.</h2>
                        <p>Ajoutez vos nouveautés et suivez les performances de votre catalogue depuis un seul espace.</p>
                        <a href="#ajouter-produit" class="seller-primary-button">Ajouter un produit <span>↗</span></a>
                    </div>
                    <img src="{{ auth()->user()->avatar_path ? asset('storage/'.auth()->user()->avatar_path) : asset('images/Boutique DoYo élégante et lumineuse.png') }}" alt="" aria-hidden="true">
                    <div class="seller-hero-metrics">
                        <div><strong>{{ $stats['totalProducts'] }}</strong><span>Produits</span></div>
                        <div><strong>{{ $stats['stockUnits'] }}</strong><span>Unités</span></div>
                        <div><strong>{{ number_format($stats['inventoryValue'], 0, ',', ' ') }} €</strong><span>Valeur stock</span></div>
                        <div><strong>{{ $stats['lowStockProducts'] }}</strong><span>Stock bas</span></div>
                    </div>
                </article>

                <article class="seller-chart-card">
                    <div class="seller-card-heading"><div><p class="seller-kicker">Activité du catalogue</p><h2>Produits publiés</h2></div><span class="seller-live-dot">● Live</span></div>
                    <div class="seller-chart">
                        <div class="seller-chart-labels"><span>{{ $stats['publishedProducts'] }}</span><span>{{ max(1, ceil($stats['totalProducts'] / 2)) }}</span><span>0</span></div>
                        <svg viewBox="0 0 400 150" role="img" aria-label="Graphique de progression du catalogue">
                            <path d="M5 118 C45 85, 55 105, 88 74 S135 35, 170 70 S220 126, 250 74 S300 45, 330 66 S363 35, 395 50" class="seller-chart-line seller-chart-line-muted"/>
                            <path d="M5 128 C50 112, 74 119, 105 96 S145 72, 174 110 S214 130, 245 92 S292 100, 320 57 S365 48, 395 22" class="seller-chart-line"/>
                        </svg>
                        <div class="seller-chart-months"><span>Jan</span><span>Mar</span><span>Mai</span><span>Juil</span><span>Sep</span></div>
                    </div>
                </article>

                <article class="seller-highlight-card">
                    <div class="seller-card-heading"><div><p class="seller-kicker">Votre catalogue</p><h2>Dernière sélection</h2></div><span class="seller-more">•••</span></div>
                    @if ($products->first())
                        <div class="seller-feature-product">
                            <img src="{{ asset('storage/'.$products->first()->image_path) }}" alt="{{ $products->first()->name }}">
                            <div><strong>{{ $products->first()->name }}</strong><span>{{ number_format((float) $products->first()->price, 2, ',', ' ') }} €</span><small>{{ $products->first()->stock }} en stock</small></div>
                        </div>
                    @else
                        <div class="seller-feature-empty">Ajoutez votre premier produit pour le voir apparaître ici.</div>
                    @endif
                </article>
            </section>

            <section class="seller-catalogue-card" id="catalogue">
                <div class="seller-card-heading">
                    <div><p class="seller-kicker">Gestion des produits</p><h2>Votre catalogue</h2></div>
                    <a href="#ajouter-produit" class="seller-outline-button">Ajouter <span>＋</span></a>
                </div>
                @forelse ($products as $product)
                    <article class="seller-product-row">
                        <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}">
                        <div><strong>{{ $product->name }}</strong><span>{{ number_format((float) $product->price, 2, ',', ' ') }} € @if($product->discount_percent > 0) · -{{ $product->discount_percent }}%@endif</span></div>
                        <span class="seller-product-badge {{ $product->stock <= 3 ? 'is-low' : '' }}">{{ $product->stock <= 3 ? 'Stock bas' : 'Disponible' }}</span>
                        <small>{{ $product->stock }} unités</small>
                        <form method="POST" action="{{ route('seller.products.destroy', $product) }}">@csrf @method('DELETE')<button type="submit" class="seller-remove">Retirer</button></form>
                    </article>
                @empty
                    <p class="seller-feature-empty">Aucun produit publié pour le moment.</p>
                @endforelse
            </section>

            <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data" class="seller-add-card" id="ajouter-produit">
                @csrf
                <div><p class="seller-kicker">Nouvelle référence</p><h2>Publier un produit</h2></div>
                <div class="seller-add-fields">
                    <label>Nom<input name="name" type="text" value="{{ old('name') }}" required></label>
                    <label>Prix<input name="price" type="number" min="0" step="0.01" value="{{ old('price') }}" required></label>
                    <label>Stock<input name="stock" type="number" min="0" value="{{ old('stock', 1) }}" required></label>
                    <label>Réduction (%)<input name="discount_percent" type="number" min="0" max="90" value="{{ old('discount_percent', 0) }}" required></label>
                    <label>Image<input name="image" type="file" accept="image/jpeg,image/png,image/webp" required></label>
                    <label class="seller-description-field">Description<textarea name="description" rows="2">{{ old('description') }}</textarea></label>
                </div>
                <button type="submit" class="seller-primary-button">Publier le produit <span>↗</span></button>
            </form>

            <section class="seller-orders-card" id="commandes">
                <div class="seller-card-heading"><div><p class="seller-kicker">Notifications WhatsApp</p><h2>Demandes de commande</h2></div><span class="seller-live-dot">● {{ $orders->where('status', 'pending')->count() }} en attente</span></div>
                @forelse ($orders as $order)
                    <article class="seller-order-row">
                        <div><strong>Commande #{{ $order->id }}</strong><span>{{ $order->items->sum('quantity') }} article(s) · {{ number_format((float) $order->total, 2, ',', ' ') }} €</span></div>
                        <span class="seller-order-status is-{{ $order->status }}">{{ $order->status === 'pending' ? 'À confirmer' : ($order->status === 'confirmed' ? 'Achat confirmé' : 'Pas d’achat') }}</span>
                        @if ($order->status === 'pending')
                            <div class="seller-order-actions">
                                <form method="POST" action="{{ route('seller.orders.confirm', $order) }}">@csrf @method('PATCH')<button type="submit" class="seller-confirm-button">Achat réalisé</button></form>
                                <form method="POST" action="{{ route('seller.orders.reject', $order) }}">@csrf @method('PATCH')<button type="submit" class="seller-reject-button">Pas d’achat</button></form>
                            </div>
                        @endif
                    </article>
                @empty
                    <p class="seller-feature-empty">Aucune demande de commande pour le moment.</p>
                @endforelse
            </section>
        </div>
    </main>
</x-layouts.app>
