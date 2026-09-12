<article class="product-card" data-product data-product-name="{{ strtolower($product['name']) }}">
    <button class="product-image" type="button" aria-label="Voir {{ $product['name'] }}"><img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy"><span class="quick-view">Voir</span></button>
    <div class="product-info"><h3>{{ $product['name'] }}</h3><div class="rating" aria-label="Note {{ $product['rating'] }} sur 5"><span>★★★★★</span><small>{{ $product['rating'] }}</small></div><div class="price-row"><strong>{{ $product['price'] }}</strong>@if(isset($product['oldPrice']))<del>{{ $product['oldPrice'] }}</del><em>{{ $product['discount'] }}</em>@endif</div></div>
</article>
