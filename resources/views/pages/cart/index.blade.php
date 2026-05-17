
@extends('layouts.app')

@section('title', 'Carrello — La Bottega del Gusto')

@section('content')
<section class="cart-page">
    <div class="container">
        <h1 class="cart-page__title">Il tuo carrello</h1>

        <div id="cart-content" data-empty="{{ $isEmpty ? 'true' : 'false' }}">

            {{-- Stato vuoto --}}
            <div class="cart-page__empty-state" {{ $isEmpty ? '' : 'hidden' }}>
                <p>Il tuo carrello è vuoto.</p>
                <a href="{{ route('shop.index') }}" class="cart-page__shop-link">
                    Torna allo shop →
                </a>
            </div>

            {{-- Stato con prodotti --}}
            <div class="cart-page__items-state" {{ $isEmpty ? 'hidden' : '' }}>
                <ul class="cart-items" id="cart-items-list">
                    @foreach($items as $item)
                        <li class="cart-item"
                            data-product-id="{{ $item['product_id'] }}"
                            data-variant-grams="{{ $item['variant_grams'] ?? '' }}"
                            data-pricing-type="{{ $item['pricing_type'] }}"
                            data-unit-price="{{ $item['unit_price'] }}">

                            @if($item['image_path'])
                                <img src="{{ asset('storage/' . $item['image_path']) }}"
                                     alt="{{ $item['product_name'] }}"
                                     class="cart-item__image"
                                     loading="lazy">
                            @else
                                <div class="cart-item__image cart-item__image--placeholder" aria-hidden="true"></div>
                            @endif

                            <div class="cart-item__info">
                                <h3 class="cart-item__name">
                                    <a href="{{ route('shop.product', $item['product_slug']) }}">
                                        {{ $item['product_name'] }}
                                    </a>
                                </h3>

                                @if($item['variant_grams'])
                                    <p class="cart-item__variant">{{ $item['variant_grams'] }}g</p>
                                @endif

                                <p class="cart-item__unit-price">{{ number_format($item['unit_price'], 2, ',', '.') }} € cad.</p>
                            </div>

                            <div class="cart-item__quantity-controls">
                                <button type="button"
                                        class="cart-item__qty-btn"
                                        data-action="decrease-quantity"
                                        aria-label="Diminuisci quantità">−</button>
                                <span class="cart-item__qty-value" data-quantity>{{ $item['quantity'] }}</span>
                                <button type="button"
                                        class="cart-item__qty-btn"
                                        data-action="increase-quantity"
                                        aria-label="Aumenta quantità">+</button>
                            </div>

                            <p class="cart-item__line-total" data-line-total>
                                {{ number_format($item['line_total'], 2, ',', '.') }} €
                            </p>

                            <button type="button"
                                    class="cart-item__remove"
                                    data-action="remove-item"
                                    aria-label="Rimuovi {{ $item['product_name'] }} dal carrello">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <line x1="18" y1="6" x2="6" y2="18"/>
                                    <line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                            </button>
                        </li>
                    @endforeach
                </ul>

                <div class="cart-page__summary">
                    <button type="button"
                            class="cart-page__clear-btn"
                            data-action="clear-cart">
                        Svuota carrello
                    </button>

                    <div class="cart-page__totals">
                        <div class="cart-page__subtotal-row">
                            <span>Subtotale</span>
                            <strong id="cart-subtotal">{{ number_format($subtotal, 2, ',', '.') }} €</strong>
                        </div>

                        <p class="cart-page__delivery-note">
                            Costi di consegna calcolati al prossimo passaggio.
                        </p>

                        @if(\App\Helpers\SettingHelper::shopEnabled())
                            <a href="{{ route('checkout.index') }}" class="cart-page__checkout-btn" id="cart-checkout-btn">
                                Procedi all'ordine
                            </a>
                        @else
                            <div class="cart-page__disabled-notice">
                                Lo shop online non è ancora attivo. Contattaci su WhatsApp per ordini.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
