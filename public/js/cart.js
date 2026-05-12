(function () {
    'use strict';

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    // ── Helpers ───────────────────────────────────────────────────────────────

    function fmtPrice(n) {
        return parseFloat(n).toFixed(2).replace('.', ',') + ' €';
    }

    // ── Toast ─────────────────────────────────────────────────────────────────

    function showToast(message, isError) {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = 'toast' + (isError ? ' toast--error' : '');
        toast.innerHTML =
            '<span class="toast__icon" aria-hidden="true">' +
            '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">' +
            (isError
                ? '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>'
                : '<polyline points="20 6 9 17 4 12"/>') +
            '</svg></span>' +
            '<span>' + message + '</span>';

        container.appendChild(toast);

        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                toast.classList.add('toast--visible');
            });
        });

        setTimeout(function () {
            toast.classList.remove('toast--visible');
            setTimeout(function () { toast.remove(); }, 350);
        }, 3000);
    }

    // ── Cart counter ──────────────────────────────────────────────────────────

    function updateCartCounter(count) {
        // Floating cart button (visible on /shop*)
        const cartBtn = document.querySelector('.cart-button');
        if (cartBtn) {
            let badge = cartBtn.querySelector('.cart-button__badge');
            if (count > 0) {
                if (!badge) {
                    badge = document.createElement('span');
                    badge.className = 'cart-button__badge';
                    cartBtn.appendChild(badge);
                }
                badge.textContent = count;
                badge.setAttribute('aria-label', count + ' articoli nel carrello');
            } else if (badge) {
                badge.remove();
            }
        }

        // Social bar shop badge (visible when NOT on /shop*)
        const shopItem = document.querySelector('.socials__item--shop a');
        if (shopItem && !window.location.pathname.startsWith('/shop')) {
            let sbadge = shopItem.querySelector('.socials__badge');
            if (count > 0) {
                if (!sbadge) {
                    sbadge = document.createElement('span');
                    sbadge.className = 'socials__badge';
                    shopItem.appendChild(sbadge);
                }
                sbadge.textContent = count;
                sbadge.setAttribute('aria-label', count + ' articoli nel carrello');
            } else if (sbadge) {
                sbadge.remove();
            }
        }
    }

    // ── Card in-cart update ───────────────────────────────────────────────────

    function markCardInCart(productId) {
        document.querySelectorAll('.product-card[data-product-id="' + productId + '"]').forEach(function (card) {
            card.classList.add('product-card--in-cart');
            const wrapper = card.querySelector('.product-card__image-wrapper');
            if (wrapper && !wrapper.querySelector('.product-card__in-cart-badge')) {
                const badge = document.createElement('span');
                badge.className = 'product-card__in-cart-badge';
                badge.setAttribute('aria-label', 'Già nel carrello');
                badge.innerHTML =
                    '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' +
                    '<polyline points="20 6 9 17 4 12"/></svg>';
                wrapper.appendChild(badge);
            }
        });
    }

    // ── Modal ─────────────────────────────────────────────────────────────────

    const modal     = document.getElementById('quick-add-modal');
    const backdrop  = document.getElementById('quick-add-backdrop');
    const form      = document.getElementById('quick-add-form');
    const qaImage   = document.getElementById('qa-image');
    const qaName    = document.getElementById('qa-name');
    const qaUPrice  = document.getElementById('qa-unit-price');
    const qaSelect  = document.getElementById('qa-select');
    const qaTotal   = document.getElementById('qa-total');
    const qaSubmit  = document.getElementById('qa-submit');
    const qaClose   = document.getElementById('qa-close');
    const qaCancel  = document.getElementById('qa-cancel');
    const qaLabel   = document.getElementById('qa-select-label');

    var currentProduct = null;

    function openModal(data) {
        currentProduct = data;

        if (qaImage) {
            qaImage.style.backgroundImage = data.image ? "url('" + data.image + "')" : 'none';
        }
        if (qaName)   qaName.textContent = data.name;
        if (qaUPrice) {
            qaUPrice.textContent = data.pricingType === 'piece'
                ? fmtPrice(data.pricePiece || 0) + ' cad.'
                : fmtPrice(data.pricePerKg || 0) + ' /kg';
        }

        // Populate select
        if (qaSelect) {
            qaSelect.innerHTML = '';
            if (data.pricingType === 'piece') {
                if (qaLabel) qaLabel.textContent = 'Quantità';
                for (var i = 1; i <= 10; i++) {
                    var opt = new Option(String(i), String(i));
                    qaSelect.appendChild(opt);
                }
            } else {
                if (qaLabel) qaLabel.textContent = 'Grammatura';
                var variants = [];
                try { variants = JSON.parse(data.variants || '[]'); } catch (_) {}
                variants.forEach(function (v) {
                    var opt = new Option(v.grams + 'g — ' + fmtPrice(v.price), String(v.grams));
                    opt.dataset.price = v.price;
                    qaSelect.appendChild(opt);
                });
            }
        }

        updateTotal();

        if (!modal) return;
        modal.removeAttribute('aria-hidden');
        modal.style.display = '';
        document.body.classList.add('modal-open');
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                modal.classList.add('quick-add-modal--visible');
            });
        });

        // Focus submit after transition
        if (qaSubmit) setTimeout(function () { qaSubmit.focus(); }, 320);
    }

    function closeModal() {
        if (!modal) return;
        modal.classList.remove('quick-add-modal--visible');
        document.body.classList.remove('modal-open');
        setTimeout(function () {
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
            currentProduct = null;
        }, 320);
    }

    function updateTotal() {
        if (!currentProduct || !qaSelect || !qaTotal) return;
        var total = 0;
        if (currentProduct.pricingType === 'piece') {
            var qty = parseInt(qaSelect.value, 10) || 1;
            total = parseFloat(currentProduct.pricePiece || 0) * qty;
        } else {
            var sel = qaSelect.options[qaSelect.selectedIndex];
            total = sel ? parseFloat(sel.dataset.price || 0) : 0;
        }
        qaTotal.textContent = fmtPrice(total);
    }

    // ── Event listeners ───────────────────────────────────────────────────────

    // Open via event delegation (button is inside <a>, stopPropagation prevents navigation)
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-action="open-quick-add"]');
        if (btn) {
            e.preventDefault();
            e.stopPropagation();
            openModal({
                id:          btn.dataset.productId,
                name:        btn.dataset.productName,
                slug:        btn.dataset.productSlug,
                image:       btn.dataset.productImage,
                pricingType: btn.dataset.pricingType,
                pricePiece:  btn.dataset.pricePiece,
                pricePerKg:  btn.dataset.pricePerKg,
                variants:    btn.dataset.variants || '[]',
            });
        }
    });

    if (qaClose)  qaClose.addEventListener('click', closeModal);
    if (qaCancel) qaCancel.addEventListener('click', closeModal);
    if (backdrop) backdrop.addEventListener('click', closeModal);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal && !modal.hasAttribute('aria-hidden')) {
            closeModal();
        }
    });

    if (qaSelect) qaSelect.addEventListener('change', updateTotal);

    // Form submit
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!currentProduct) return;

            var payload = {
                product_id:    parseInt(currentProduct.id, 10),
                quantity:      currentProduct.pricingType === 'piece'
                                   ? parseInt(qaSelect.value, 10)
                                   : 1,
                variant_grams: currentProduct.pricingType === 'weight'
                                   ? parseInt(qaSelect.value, 10)
                                   : null,
            };

            qaSubmit.disabled = true;
            qaSubmit.textContent = 'Aggiunta…';

            fetch('/cart/add', {
                method:  'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept':       'application/json',
                },
                body: JSON.stringify(payload),
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data.success) {
                    var pid = currentProduct.id;
                    closeModal();
                    showToast('Aggiunto al carrello');
                    updateCartCounter(data.cart_count);
                    markCardInCart(pid);
                } else {
                    showToast(data.error || "Errore durante l'aggiunta", true);
                }
            })
            .catch(function () {
                showToast('Errore di rete. Riprova.', true);
            })
            .finally(function () {
                if (qaSubmit) {
                    qaSubmit.disabled = false;
                    qaSubmit.textContent = 'Aggiungi al carrello';
                }
            });
        });
    }

})();
