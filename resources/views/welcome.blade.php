<x-layouts.app title="DoYo.shop | Trouvez votre style">
    <div class="storefront">
        <x-store.header />

        <main>
            <x-store.hero />
            <x-store.brand-strip :brands="$brands" />
            <x-store.product-section id="nouveautes" title="Nouveautés" :products="$newProducts" />
            <x-store.product-section id="meilleures-ventes" title="Meilleures ventes" :products="$bestSellers" />
            <x-store.style-browser :styles="$styles" />
            <x-store.testimonials :testimonials="$testimonials" />
            <x-store.newsletter />
        </main>

        <x-store.footer />
    </div>

    <div class="cart-overlay" data-cart-overlay></div>
    <div class="product-modal-overlay" data-product-modal-overlay></div>
    <aside class="product-modal" aria-label="Détails du produit" aria-hidden="true" data-product-modal>
        <button type="button" class="product-modal-close" aria-label="Fermer les détails" data-product-modal-close>×</button>
        <div class="product-modal-gallery"><div class="product-modal-thumbnails"><button type="button" class="is-active" data-modal-thumbnail><img src="" alt=""></button><button type="button" data-modal-thumbnail><img src="" alt=""></button><button type="button" data-modal-thumbnail><img src="" alt=""></button></div><div class="product-modal-main-image"><img src="" alt="" data-modal-image></div></div>
        <div class="product-modal-content"><p class="eyebrow">Produit</p><h2 data-modal-name></h2><div class="product-modal-rating"><span>★★★★★</span><strong>4.5/5</strong></div><strong class="product-modal-price" data-modal-price></strong><p class="product-modal-seller" data-modal-seller></p><p class="product-modal-description" data-modal-description></p><div class="product-modal-choice"><span>Choisir la couleur</span><div><button type="button" class="color-dot is-selected" aria-label="Couleur principale"></button><button type="button" class="color-dot color-dot-blue" aria-label="Couleur bleue"></button><button type="button" class="color-dot color-dot-dark" aria-label="Couleur sombre"></button></div></div><div class="product-modal-choice"><span>Choisir la taille</span><div class="size-options"><button type="button">S</button><button type="button">M</button><button type="button" class="is-selected">L</button><button type="button">XL</button></div></div><div class="product-modal-buy"><div class="modal-quantity"><button type="button" data-modal-minus>−</button><span data-modal-quantity>1</span><button type="button" data-modal-plus>+</button></div><button type="button" class="button button-dark button-add" data-modal-add>Ajouter au panier</button></div></div>
    </aside>
    <aside class="cart-drawer" aria-label="Votre panier" aria-hidden="true" data-cart-drawer data-whatsapp-number="{{ env('WHATSAPP_NUMBER', '33600000000') }}">
        <div class="cart-drawer-header">
            <div><p class="eyebrow">Votre sélection</p><h2>Panier <span data-cart-title-count>(0)</span></h2></div>
            <button type="button" class="cart-close" aria-label="Fermer le panier" data-cart-close>×</button>
        </div>
        <div class="cart-items" data-cart-items>
            <p class="cart-empty">Votre panier est encore vide.</p>
        </div>
        <div class="cart-summary">
            <div><span>Sous-total</span><strong data-cart-total>$0</strong></div>
            <p>Livraison et détails de commande confirmés sur WhatsApp.</p>
            <button type="button" class="button button-dark cart-checkout" data-checkout disabled>Commander sur WhatsApp <span>→</span></button>
        </div>
    </aside>
</x-layouts.app>