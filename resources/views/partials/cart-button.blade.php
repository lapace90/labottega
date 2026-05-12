@if(str_starts_with(request()->path(), 'shop') && !request()->is('cart') && !request()->is('checkout'))
    <a href="{{ url('/cart') }}" class="cart-button" aria-label="Vai al carrello">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="9" cy="21" r="1"/>
            <circle cx="20" cy="21" r="1"/>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
        </svg>
        <span>Carrello</span>
        <span class="cart-button__badge" data-cart-count
              {{ $cartCount === 0 ? 'hidden' : '' }}
              aria-label="{{ $cartCount }} articoli nel carrello">{{ $cartCount }}</span>
    </a>
@endif
