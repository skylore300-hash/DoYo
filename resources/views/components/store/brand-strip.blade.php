<section class="brand-strip" id="marques" aria-label="Marques partenaires">
    <div class="brand-marquee">
        <div class="brand-track">
            <div class="brand-list">
                @foreach ($brands as $brand)
                    <span>{{ $brand }}</span>
                @endforeach
            </div>
            <div class="brand-list" aria-hidden="true">
                @foreach ($brands as $brand)
                    <span>{{ $brand }}</span>
                @endforeach
            </div>
        </div>
    </div>
</section>
