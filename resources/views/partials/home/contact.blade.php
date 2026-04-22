<section class="section contact" id="contatti" aria-labelledby="contact-title">
    <div class="container">
        <h2 class="contact__title" id="contact-title">Dove siamo</h2>

        <div class="contact__top">
            <div class="contact__info">
                <p><strong>Piazza Michele Da Montopoli, 3</strong><br>56020 Montopoli in Val d'Arno (PI)</p>
                <p>
                    Cellulare:
                    <a href="tel:+393928491518">+39 392 8491518</a>
                </p>
                <p>
                    Email:
                    <a href="mailto:labottegadelgustosas@gmail.com">labottegadelgustosas@gmail.com</a>
                </p>
                <p class="contact__tgtg">
                    🌱 <a href="https://share.toogoodtogo.com/item/574013/" target="_blank" rel="noopener">Aderente a Too Good To Go</a>
                </p>
            </div>

            @include('partials.home.hours')

            <div class="contact__photo"
                 role="img" aria-label="Torre di Montopoli in Val d'Arno con panchina a forma di cuore">
                <img src="{{ asset('images/montopoli.jpeg') }}"
                     alt="La torre medievale di Montopoli in Val d'Arno"
                     loading="lazy"
                     width="400" height="600">
            </div>
        </div>

        <div class="contact__map" id="contact-map">
            <div class="map-placeholder">
                <p class="map-placeholder__address">
                    <strong>Piazza Michele Da Montopoli, 3</strong><br>
                    Montopoli in Val d'Arno (PI)
                </p>
                <button type="button" class="map-placeholder__btn" data-load-map>
                    Carica la mappa
                </button>
                <p class="map-placeholder__note">
                    Caricando la mappa verrai connesso a Google Maps, che può impostare cookie di terze parti.
                </p>
            </div>
        </div>

        @push('scripts')
        <script>
            (function () {
                const container = document.getElementById('contact-map');
                if (!container) return;

                function loadMap() {
                    if (container.dataset.loaded === '1') return;
                    const iframe = document.createElement('iframe');
                    iframe.src = "https://maps.google.com/maps?q=La+Bottega+del+Gusto+Montopoli&ll=43.6703471,10.7608832&z=16&output=embed";
                    iframe.loading = 'lazy';
                    iframe.referrerPolicy = 'no-referrer-when-downgrade';
                    iframe.title = "Mappa La Bottega del Gusto — Piazza Michele Da Montopoli, 3, Montopoli in Val d'Arno";
                    iframe.allowFullscreen = true;
                    container.innerHTML = '';
                    container.appendChild(iframe);
                    container.dataset.loaded = '1';
                }

                if (localStorage.getItem('cookieConsent') === 'accepted') {
                    loadMap();
                }

                container.querySelector('[data-load-map]')?.addEventListener('click', loadMap);

                window.addEventListener('cookie-consent-updated', function (e) {
                    if (e.detail && e.detail.status === 'accepted') loadMap();
                });
            })();
        </script>
        @endpush
    </div>
</section>
