@extends('layouts.app')

@section('title', $product->name . ' — La Bottega del Gusto')
@section('description', $product->description ?? 'Acquista ' . $product->name . ' de La Bottega del Gusto.')
@section('og_title', $product->name . ' — La Bottega del Gusto')
@section('og_description', $product->description ?? 'Acquista ' . $product->name . ' de La Bottega del Gusto.')
@if($product->image_path)
@section('og_image', asset('storage/' . $product->image_path))
@endif

@section('content')
<div class="shop">

    <section class="section product-detail-section">
        <div class="container">

            <div class="product-detail">

                {{-- Immagine --}}
                <div class="product-detail__image-wrap">
                    <div class="product-detail__image"
                        @if($product->image_path)
                        style="background-image: url('{{ asset('storage/' . $product->image_path) }}');"
                        @endif>
                    </div>
                </div>

                {{-- Info --}}
                <div class="product-detail__info">

                    <nav class="breadcrumb" aria-label="Breadcrumb">
                        <a href="{{ route('shop.index') }}">Shop</a>
                        <span aria-hidden="true">/</span>
                        @if($product->category)
                        <a href="{{ route('shop.category', ['slug' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                        <span aria-hidden="true">/</span>
                        @endif
                        <span aria-current="page">{{ $product->name }}</span>
                    </nav>

                    <h1 class="product-detail__name">{{ $product->name }}</h1>

                    <p class="product-detail__price">{{ $product->displayPrice() }}</p>

                    @if($product->description)
                    <p class="product-detail__description">{{ $product->description }}</p>
                    @endif

                    <div class="product-detail__buy">

                        @if($product->pricing_type === 'weight' && $product->variants->isNotEmpty())

                            <label class="product-detail__label" for="variant-select">Grammatura</label>
                            <select id="variant-select" class="product-detail__quantity-select">
                                @foreach($product->variants as $variant)
                                <option value="{{ $variant->grams }}">
                                    {{ $variant->grams }}g — {{ number_format($product->priceForGrams($variant->grams), 2, ',', '.') }} €
                                </option>
                                @endforeach
                            </select>

                            <p class="product-detail__weight-note">I pesi sono indicativi: il peso effettivo può variare leggermente.</p>

                        @else

                            <label class="product-detail__label" for="qty-select">Quantità</label>
                            <select id="qty-select" class="product-detail__quantity-select">
                                @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>

                        @endif

                        <button
                            type="button"
                            class="product-detail__add-to-cart-btn"
                            onclick="alert('Carrello in arrivo! Presto potrai aggiungere prodotti al carrello e completare l\'ordine.')">
                            Aggiungi al carrello
                        </button>

                    </div>

                </div>

            </div>

        </div>
    </section>

    @if($related->isNotEmpty())
    <section class="section shop-related">
        <div class="container">
            <h2 class="shop-related__title">Potrebbe interessarti anche</h2>
            <div class="product-grid" role="list">
                @foreach($related as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

</div>
@endsection
