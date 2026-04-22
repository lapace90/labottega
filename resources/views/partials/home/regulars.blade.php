<section class="section regulars" id="appuntamenti" aria-labelledby="regulars-title">
    <div class="container">
        <header class="regulars__header">
            <h2 class="regulars__title" id="regulars-title">I nostri appuntamenti</h2>
            <p class="regulars__subtitle">Momenti di gusto che trovi sempre da noi</p>
        </header>

        <div class="regulars__grid">
            {{-- Card 1: Apericena del giovedì --}}
            <article class="regular-card">
                <div class="regular-card__image"
                     style="--card-image: url('{{ asset('images/apericena.jpg') }}');"
                     role="img"
                     aria-label="Apericena toscana con taglieri e vini"></div>
                <div class="regular-card__body">
                    <span class="regular-card__badge">Ogni giovedì · dalle 19:00</span>
                    <h3 class="regular-card__title">Apericena toscana</h3>
                    <p class="regular-card__text">
                        Taglieri di salumi e formaggi del territorio, vini locali,
                        schiacciata calda e l'atmosfera della bottega.
                        Prenota il tuo tavolo con un messaggio.
                    </p>
                    <div class="regular-card__actions">
                        <a href="https://wa.me/393928491518?text=Ciao!%20Vorrei%20prenotare%20per%20l%27apericena%20del%20giovedì.%20Siamo%20in%20%5Bnumero%5D%20persone.&utm_source=sito"
                           target="_blank"
                           rel="noopener"
                           class="regular-card__cta regular-card__cta--whatsapp">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" width="18" height="18">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Prenota su WhatsApp
                        </a>
                    </div>
                </div>
            </article>

            {{-- Card 2: Pranzi e cene su richiesta --}}
            <article class="regular-card">
                <div class="regular-card__image"
                     style="--card-image: url('{{ asset('images/pranzi-cene.jpg') }}');"
                     role="img"
                     aria-label="Piatti del giorno preparati in bottega"></div>
                <div class="regular-card__body">
                    <span class="regular-card__badge">In orario di apertura</span>
                    <h3 class="regular-card__title">Pranzi e cene</h3>
                    <p class="regular-card__text">
                        Prepariamo ogni giorno piatti freschi con quello che abbiamo di buono
                        in bottega. Non c'è un menu fisso: scrivi per sapere le proposte del
                        giorno e prenotare il tuo posto.
                    </p>
                    <div class="regular-card__actions">
                        <a href="https://wa.me/393928491518?text=Ciao!%20Vorrei%20sapere%20le%20proposte%20del%20giorno.&utm_source=sito"
                           target="_blank"
                           rel="noopener"
                           class="regular-card__cta regular-card__cta--whatsapp">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" width="18" height="18">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Chiedi la proposta del giorno
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>
