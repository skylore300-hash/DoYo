<x-layouts.app title="Sierra.shop | Trouvez votre style">
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
</x-layouts.app>