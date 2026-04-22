@extends('layouts.app')

@section('title', 'Cookie Policy — La Bottega del Gusto')
@section('description', 'Informativa sui cookie utilizzati dal sito La Bottega del Gusto di Montopoli in Val d\'Arno.')

@section('content')
<section class="section legal">
    <div class="container legal__container">
        <h1 class="legal__title">Cookie Policy</h1>
        <p class="legal__updated">Ultimo aggiornamento: {{ \Carbon\Carbon::now()->locale('it')->isoFormat('D MMMM YYYY') }}</p>

        <h2>1. Cosa sono i cookie</h2>
        <p>
            I cookie sono piccoli file di testo che i siti visitati salvano sul dispositivo dell'utente
            per permettere il funzionamento del sito o per raccogliere informazioni sulla navigazione.
            Al posto dei cookie, i siti possono anche usare tecnologie simili come il <em>localStorage</em> del browser.
        </p>

        <h2>2. Cookie utilizzati da questo sito</h2>

        <h3>a) Cookie tecnici (sempre attivi)</h3>
        <p>
            Sono necessari al funzionamento del sito e non richiedono consenso.
            Per legge possono essere installati senza consenso preventivo.
        </p>
        <ul>
            <li>
                <strong><code>laravel_session</code></strong> — cookie di sessione usato dal framework
                per tenere coerente la navigazione. Scade alla chiusura della sessione (circa 2 ore).
            </li>
            <li>
                <strong><code>XSRF-TOKEN</code></strong> — cookie di sicurezza contro attacchi CSRF.
                Scade alla chiusura della sessione.
            </li>
            <li>
                <strong><code>cookieConsent</code> (localStorage)</strong> — registra la scelta
                espressa sul banner cookie per non ripresentarlo a ogni visita.
            </li>
        </ul>

        <h3>b) Cookie di terze parti (richiedono consenso)</h3>
        <p>
            L'unico contenuto di terze parti presente sul sito è la mappa di Google Maps nella sezione contatti.
            La mappa <strong>non viene caricata automaticamente</strong>: finché non acconsenti (tramite il banner
            cookie o cliccando sul pulsante “Carica la mappa”), nessun dato viene inviato a Google.
        </p>
        <ul>
            <li>
                <strong>Google Maps (Google Ireland Ltd.)</strong> — una volta caricata la mappa,
                Google può installare cookie propri (es. <code>NID</code>, <code>CONSENT</code>, <code>1P_JAR</code>)
                per funzionamento, preferenze e sicurezza.
                Informativa:
                <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">policies.google.com/privacy</a>.
            </li>
        </ul>

        <h3>c) Cookie non utilizzati</h3>
        <p>
            Questo sito <strong>non utilizza</strong> strumenti di analisi del traffico (Google Analytics,
            Meta Pixel, Hotjar, ecc.), né cookie pubblicitari o di profilazione.
            I collegamenti ai profili Facebook e Instagram nella pagina sono semplici link in uscita
            e non caricano alcun widget che imposti cookie.
        </p>

        <h2>3. Come gestire le preferenze</h2>
        <p>
            Puoi modificare in qualsiasi momento la tua scelta sui cookie cliccando su
            <button type="button" class="legal__inline-btn" onclick="window.openCookieBanner && window.openCookieBanner()">Gestisci cookie</button>
            oppure sul link “Gestisci cookie” nel footer.
        </p>
        <p>
            In alternativa, puoi bloccare o cancellare i cookie direttamente dalle impostazioni del tuo browser:
            <a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener">Chrome</a>,
            <a href="https://support.mozilla.org/it/kb/Attivare%20e%20disattivare%20i%20cookie" target="_blank" rel="noopener">Firefox</a>,
            <a href="https://support.apple.com/it-it/guide/safari/sfri11471/mac" target="_blank" rel="noopener">Safari</a>,
            <a href="https://support.microsoft.com/it-it/microsoft-edge" target="_blank" rel="noopener">Edge</a>.
        </p>

        <h2>4. Titolare del trattamento</h2>
        <p>
            <strong>LA BOTTEGA DEL GUSTO S.A.S. DI PACE JESSICA</strong><br>
            Società in accomandita semplice (S.a.s.)<br>
            Sede legale: Piazza San Michele, 4 — 56020 Montopoli in Val d'Arno (PI), Italia<br>
            P.IVA: 02260110503 &middot; C.F.: 02260110503 &middot; REA: PI-193599<br>
            PEC: <a href="mailto:labottegadelgusto2025@pec.it">labottegadelgusto2025@pec.it</a><br>
            Email: <a href="mailto:labottegadelgustosas@gmail.com">labottegadelgustosas@gmail.com</a><br>
            Telefono: <a href="tel:+390571466695">+39 0571 466695</a>
        </p>

        <h2>5. Diritti dell'utente</h2>
        <p>
            Ai sensi degli articoli 15–22 del Regolamento UE 2016/679 (GDPR), l'utente ha diritto ad accedere
            ai propri dati, chiederne la rettifica o la cancellazione, opporsi al trattamento, limitarlo
            o richiederne la portabilità. Per esercitare questi diritti è possibile scrivere:
        </p>
        <ul>
            <li>
                per richieste informali, all'indirizzo ordinario:
                <a href="mailto:labottegadelgustosas@gmail.com">labottegadelgustosas@gmail.com</a>
            </li>
            <li>
                per richieste ufficiali, alla casella PEC:
                <a href="mailto:labottegadelgusto2025@pec.it">labottegadelgusto2025@pec.it</a>
            </li>
        </ul>
        <p>
            È inoltre possibile presentare reclamo al Garante per la protezione dei dati personali:
            <a href="https://www.garanteprivacy.it" target="_blank" rel="noopener">garanteprivacy.it</a>.
        </p>

        <h2>6. Aggiornamenti</h2>
        <p>
            Questa informativa può essere aggiornata per adeguamenti tecnici o normativi.
            La versione corrente è sempre disponibile a questa pagina.
        </p>

        <p class="legal__back">
            <a href="{{ route('home') }}">← Torna alla home</a>
        </p>
    </div>
</section>
@endsection
