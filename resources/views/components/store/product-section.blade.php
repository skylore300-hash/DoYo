<section class="catalog-section content-width" id="{{ $id }}" data-product-section>
    <div class="section-heading"><h2>{{ $title }}</h2><span class="section-rule"></span></div>
    <div class="product-grid">@foreach ($products as $product)<x-store.product-card :product="$product" />@endforeach</div>
    <button type="button" class="button button-outline" data-show-more>Voir tout <span>→</span></button>
</section>
