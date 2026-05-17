@if(!\App\Helpers\SettingHelper::shopEnabled())
    <div class="shop-banner" role="banner">
        <div class="container">
            <div class="shop-banner__content">
                <span class="shop-banner__icon" aria-hidden="true">🛍</span>
                <p>
                    <strong>Shop online in arrivo</strong> — Intanto, ordina su WhatsApp
                    <a href="https://wa.me/393928491518?text={{ urlencode('Ciao! Vorrei ordinare alcuni prodotti.') }}"
                       target="_blank" rel="noopener" class="shop-banner__link">
                        +39 392 8491518
                    </a>
                </p>
            </div>
        </div>
    </div>
@endif
