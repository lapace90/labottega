@props(['product'])

<article class="product-card" role="listitem">
    <a href="{{ route('shop.product', ['slug' => $product->slug]) }}">
        <div class="product-card__image"
            @if($product->image_path)
            style="background-image: url('{{ asset('storage/' . $product->image_path) }}');"
            @endif>
        </div>
        <div class="product-card__body">
            <h3 class="product-card__name">{{ $product->name }}</h3>
            <p class="product-card__price">{{ $product->displayPrice() }}</p>
        </div>
    </a>
</article>
