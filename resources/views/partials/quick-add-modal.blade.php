<div id="quick-add-modal" class="quick-add-modal" aria-hidden="true" style="display:none;"
     role="dialog" aria-modal="true" aria-labelledby="qa-name">
    <div class="quick-add-modal__backdrop" id="quick-add-backdrop"></div>

    <div class="quick-add-modal__dialog">

        <button type="button" class="quick-add-modal__close" id="qa-close" aria-label="Chiudi modale">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>

        <div class="quick-add-modal__product">
            <div class="quick-add-modal__image" id="qa-image" aria-hidden="true"></div>
            <div class="quick-add-modal__product-info">
                <h2 class="quick-add-modal__name" id="qa-name"></h2>
                <p class="quick-add-modal__unit-price" id="qa-unit-price"></p>
            </div>
        </div>

        <form class="quick-add-modal__form" id="quick-add-form" novalidate>

            <div class="quick-add-modal__field">
                <label class="quick-add-modal__label" for="qa-select" id="qa-select-label">Quantità</label>
                <select class="quick-add-modal__select" id="qa-select" name="quantity"></select>
            </div>

            <p class="quick-add-modal__total">
                Totale: <strong id="qa-total"></strong>
            </p>

            <div class="quick-add-modal__actions">
                <button type="button" class="quick-add-modal__btn quick-add-modal__btn--cancel" id="qa-cancel">
                    Annulla
                </button>
                <button type="submit" class="quick-add-modal__btn quick-add-modal__btn--submit" id="qa-submit">
                    Aggiungi al carrello
                </button>
            </div>

        </form>

    </div>
</div>
