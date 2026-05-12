@props(['product'])

@php
    $isInCart = in_array($product->id, $cartProductIds ?? []);
@endphp

<article class="product-card {{ $isInCart ? 'product-card--in-cart' : '' }}" role="listitem">
    <a href="{{ route('shop.product', ['slug' => $product->slug]) }}">
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
        </div>
        <div class="product-card__body">
            <h3 class="product-card__name">{{ $product->name }}</h3>
            <p class="product-card__price">{{ $product->displayPrice() }}</p>
        </div>
    </a>
</article>
