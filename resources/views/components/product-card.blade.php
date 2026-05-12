@props(['product'])

@php
    $isInCart = in_array($product->id, $cartProductIds ?? []);
    $variantsJson = $product->pricing_type === 'weight'
        ? $product->variants->map(fn($v) => ['grams' => $v->grams, 'price' => $product->priceForGrams($v->grams)])->toJson()
        : '[]';
@endphp

<article class="product-card {{ $isInCart ? 'product-card--in-cart' : '' }}" role="listitem"
         data-product-id="{{ $product->id }}">
    <a href="{{ route('shop.product', ['slug' => $product->slug]) }}" class="product-card__link">
        <div class="product-card__image-wrapper">
            <div class="product-card__image"
                @if($product->image_path)
                style="background-image: url('{{ asset('storage/' . $product->image_path) }}');"
                @endif>
            </div>

            @if($isInCart)
                <span class="product-card__in-cart-badge" aria-label="Già nel carrello">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </span>
            @endif

            <button type="button"
                    class="product-card__quick-add"
                    data-action="open-quick-add"
                    data-product-id="{{ $product->id }}"
                    data-product-name="{{ $product->name }}"
                    data-product-slug="{{ $product->slug }}"
                    data-product-image="{{ $product->image_path ? asset('storage/' . $product->image_path) : '' }}"
                    data-pricing-type="{{ $product->pricing_type }}"
                    data-price-piece="{{ $product->price_piece }}"
                    data-price-per-kg="{{ $product->price_per_kg }}"
                    data-variants="{{ $variantsJson }}"
                    aria-label="Aggiungi {{ $product->name }} al carrello">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
            </button>
        </div>

        <div class="product-card__body">
            <h3 class="product-card__name">{{ $product->name }}</h3>
            <p class="product-card__price">{{ $product->displayPrice() }}</p>
        </div>
    </a>
</article>
