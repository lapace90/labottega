@extends('layouts.app')

@section('title', $category->name . ' — La Bottega del Gusto')
@section('description', 'Acquista ' . $category->name . ' artigianali de La Bottega del Gusto.')
@section('og_title', $category->name . ' — La Bottega del Gusto')
@section('og_description', 'Scopri la selezione di ' . $category->name . ' disponibili nel nostro shop.')

@section('content')
<div class="shop shop-category-page">

    <section class="section">
        <div class="container shop-category-page__layout">

            {{-- Sidebar categorie --}}
            <aside class="shop-sidebar">
                <h2 class="shop-sidebar__title">Categorie</h2>
                <ul class="shop-sidebar__list">
                    @foreach($otherCategories as $other)
                    <li class="shop-sidebar__item">
                        <a href="{{ route('shop.category', ['slug' => $other->slug]) }}"
                           class="shop-sidebar__link">{{ $other->name }}</a>
                    </li>
                    @endforeach
                </ul>
            </aside>

            {{-- Contenuto principale --}}
            <div class="shop-category-page__main">

                <nav class="breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('shop.index') }}">Shop</a>
                    <span aria-hidden="true">/</span>
                    <span>{{ $category->name }}</span>
                </nav>

                <h1 class="shop-category-page__title">{{ $category->name }}</h1>

                @if($products->isEmpty())
                    <p style="color:#777; margin-top:32px;">Nessun prodotto disponibile in questa categoria al momento.</p>
                @else
                    <div class="product-grid" role="list">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <div class="shop-pagination">
                        {{ $products->links() }}
                    </div>
                @endif

            </div>
        </div>
    </section>

</div>
@endsection
