@extends('layouts.app')

@section('title', 'Lo shop — La Bottega del Gusto')
@section('description', 'Acquista online i prodotti artigianali de La Bottega del Gusto: salumi, formaggi, pane, vini e specialità toscane.')
@section('og_title', 'Lo shop — La Bottega del Gusto')
@section('og_description', 'Scopri e ordina i nostri prodotti artigianali direttamente online.')

@section('content')
<div class="shop">

    <section class="shop__hero">
        <div class="container">
            <h1 class="shop__hero-title">Lo shop</h1>
            <p class="shop__hero-tagline">Scopri i nostri prodotti, ordina online.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">

            @forelse($categories as $category)
                @if($category->featured_products->isNotEmpty())
                <div class="shop-category-section">
                    <div class="shop-category-section__header">
                        <h2 class="shop-category-section__title">{{ $category->name }}</h2>
                        <a href="{{ route('shop.category', ['slug' => $category->slug]) }}" class="shop-category-section__link">
                            Vedi tutti i prodotti della categoria &rarr;
                        </a>
                    </div>

                    <div class="product-grid" role="list">
                        @foreach($category->featured_products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                </div>
                @endif
            @empty
                <p style="text-align:center; color:#777;">Nessuna categoria attiva al momento.</p>
            @endforelse

        </div>
    </section>

</div>
@endsection
