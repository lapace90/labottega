<div id="cookie-banner" class="cookie-banner" style="display: none;" role="dialog" aria-live="polite" aria-label="Informativa cookie">
    <div class="cookie-banner__content">
        <p class="cookie-banner__text">
            Questo sito utilizza cookie tecnici necessari al funzionamento.
            La sezione contatti contiene una mappa di Google Maps che, se caricata,
            imposta cookie di terze parti.
            <a href="{{ route('cookie-policy') }}" class="cookie-banner__link">Cookie policy</a>
        </p>
        <div class="cookie-banner__buttons">
            <button id="cookie-accept" type="button" class="cookie-banner__button cookie-banner__button--accept">
                Accetta tutti
            </button>
            <button id="cookie-decline" type="button" class="cookie-banner__button">
                Solo necessari
            </button>
        </div>
    </div>
</div>
<script>
    (function () {
        const banner = document.getElementById('cookie-banner');
        const acceptBtn = document.getElementById('cookie-accept');
        const declineBtn = document.getElementById('cookie-decline');

        function showBanner() {
            banner.style.display = 'block';
            requestAnimationFrame(() => banner.classList.add('cookie-banner--visible'));
        }

        function hideBanner() {
            banner.classList.remove('cookie-banner--visible');
            setTimeout(() => { banner.style.display = 'none'; }, 400);
        }

        function setConsent(status) {
            localStorage.setItem('cookieConsent', status);
            window.dispatchEvent(new CustomEvent('cookie-consent-updated', { detail: { status } }));
        }

        if (!localStorage.getItem('cookieConsent')) {
            showBanner();
        }

        acceptBtn.addEventListener('click', () => { setConsent('accepted'); hideBanner(); });
        declineBtn.addEventListener('click', () => { setConsent('declined'); hideBanner(); });

        // API pubblica per riaprire il banner (es. link in footer)
        window.openCookieBanner = showBanner;
    })();
</script>
