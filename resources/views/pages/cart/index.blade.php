
@extends('layouts.app')

@section('title', 'Carrello — La Bottega del Gusto')

@section('content')
<section class="cart-page">
    <div class="container">
        <h1 class="cart-page__title">Il tuo carrello</h1>

        @if($isEmpty)
            <p class="cart-page__empty">
                Il tuo carrello è vuoto. <a href="{{ route('shop.index') }}">Torna allo shop</a>.
            </p>
        @else
            <ul class="cart-page__items">
                @foreach($items as $item)
                    <li class="cart-item">
                        @if($item['image_path'])
                            <img src="{{ asset('storage/' . $item['image_path']) }}" alt="{{ $item['product_name'] }}" class="cart-item__image">
                        @else
                            <div class="cart-item__image cart-item__image--placeholder"></div>
                        @endif

                        <div class="cart-item__info">
                            <h3 class="cart-item__name">{{ $item['product_name'] }}</h3>
                            <p class="cart-item__quantity">{{ $item['display_quantity'] }}</p>
                        </div>

                        <p class="cart-item__price">{{ number_format($item['line_total'], 2, ',', '.') }} €</p>
                    </li>
                @endforeach
            </ul>

            <div class="cart-page__summary">
                <div class="cart-page__subtotal">
                    <span>Subtotale</span>
                    <strong>{{ number_format($subtotal, 2, ',', '.') }} €</strong>
                </div>

                <div class="cart-page__notice">
                    <p>📝 La pagina di checkout sarà disponibile prossimamente.</p>
                    <p>Per ordinare ora, contatta direttamente la bottega:</p>
                    <a href="https://wa.me/393928491518?text=Ciao!%20Vorrei%20ordinare%20questi%20prodotti:%20{{ urlencode($items->map(fn($i) => $i['display_quantity'] . ' ' . $i['product_name'])->implode(', ')) }}"
                       target="_blank"
                       rel="noopener"
                       class="cart-page__whatsapp">
                        💬 Manda l'ordine su WhatsApp
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
