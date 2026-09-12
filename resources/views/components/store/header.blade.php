<div class="promo-bar">Inscrivez-vous et profitez de 20 % sur votre première commande. <button type="button" aria-label="Fermer la promotion" data-dismiss-promo>×</button></div>
<header class="site-header" data-header>
    <div class="header-inner">
        <a href="{{ url('/') }}" class="wordmark" aria-label="DoYo.shop, accueil" style="color: #ec6b02;">DoYo.shop</a>
        <nav class="desktop-nav" aria-label="Navigation principale">
            <a href="#nouveautes">Boutique</a>
            <a href="#meilleures-ventes">Promotions</a>
            <a href="#nouveautes">Nouveautés</a>
            <a href="#marques">Marques</a>
        </nav>
        <form class="search-form" data-search-form role="search">
            <label class="sr-only" for="product-search">Rechercher un produit</label>
            <svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="11" cy="11" r="6.5"></circle><path d="m16 16 4 4"></path></svg>
            <input id="product-search" type="search" placeholder="Rechercher un produit..." data-product-search>
        </form>
        <div class="header-actions">
            <button type="button" class="icon-button" aria-label="Voir le panier" data-cart-button>
                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M4 5h2l1.5 10h10L20 8H7"></path><circle cx="9" cy="19" r="1"></circle><circle cx="17" cy="19" r="1"></circle></svg>
                <span class="cart-count" data-cart-count>0</span>
            </button>
            <button type="button" class="icon-button account-button" aria-label="Mon compte"><svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="12" cy="8" r="3"></circle><path d="M5.5 20c.8-3.2 3-5 6.5-5s5.7 1.8 6.5 5"></path></svg></button>
            <button type="button" class="menu-toggle" aria-label="Ouvrir le menu" aria-expanded="false" data-menu-toggle><span></span><span></span></button>
        </div>
    </div>
    <nav class="mobile-nav" aria-label="Navigation mobile" data-mobile-nav>
        <a href="#nouveautes">Boutique</a><a href="#meilleures-ventes">Promotions</a><a href="#nouveautes">Nouveautés</a><a href="#marques">Marques</a>
    </nav>
</header>
