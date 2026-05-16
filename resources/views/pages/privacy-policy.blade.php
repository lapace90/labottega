@extends('layouts.app')

@section('title', 'Informativa sulla Privacy — La Bottega del Gusto')
@section('description', 'Informativa sulla privacy e trattamento dei dati personali di La Bottega del Gusto di Montopoli in Val d\'Arno, ai sensi del GDPR.')
@section('og_title', 'Informativa sulla Privacy — La Bottega del Gusto')
@section('og_description', 'Come trattiamo i dati personali dei clienti ai sensi del GDPR — La Bottega del Gusto.')

@section('content')
<section class="section legal">
    <div class="container legal__container">
        <h1 class="legal__title">Informativa sulla Privacy</h1>
        <p class="legal__updated">Ultimo aggiornamento: 16 maggio 2026</p>

        <p>
            La presente informativa descrive come La Bottega del Gusto raccoglie, utilizza e protegge
            i dati personali dei propri clienti, ai sensi del Regolamento (UE) 2016/679 (GDPR)
            e del D.Lgs. 196/2003 (Codice Privacy).
        </p>

        <h2>1. Titolare del trattamento</h2>
        <p>
            <strong>La Bottega del Gusto S.A.S. di Pace Jessica</strong><br>
            Piazza Michele Da Montopoli, 3<br>
            56020 Montopoli in Val d'Arno (PI) — Italia<br>
            P.IVA: 02260110503<br>
            PEC: <a href="mailto:labottegadelgusto2025@pec.it">labottegadelgusto2025@pec.it</a><br>
            Email: <a href="mailto:labottegadelgustosas@gmail.com">labottegadelgustosas@gmail.com</a><br>
            Cellulare: <a href="tel:+393928491518">+39 392 8491518</a>
        </p>

        <h2>2. Quali dati raccogliamo</h2>
        <p>Quando effettui un ordine sul Sito, raccogliamo i seguenti dati personali:</p>
        <ul>
            <li>Nome e cognome</li>
            <li>Numero di telefono</li>
            <li>Indirizzo email (opzionale)</li>
            <li>Eventuali note al venditore</li>
            <li>Dati relativi all'ordine (prodotti, importi, data e ora di ritiro)</li>
        </ul>
        <p>
            Non raccogliamo dati di pagamento, in quanto il pagamento avviene direttamente
            in bottega al momento del ritiro.
        </p>
        <p>
            Non raccogliamo dati personali tramite cookie analitici o di profilazione.
            Per maggiori dettagli sui cookie tecnici utilizzati, consulta la nostra
            <a href="{{ route('cookie-policy') }}">Cookie Policy</a>.
        </p>

        <h2>3. Perché trattiamo i tuoi dati</h2>
        <p>I dati personali raccolti vengono utilizzati per le seguenti finalità:</p>

        <h3>a) Gestione dell'ordine</h3>
        <ul>
            <li>Esecuzione del contratto di vendita</li>
            <li>Preparazione e consegna/ritiro dell'ordine</li>
            <li>Comunicazioni relative all'ordine (conferma, eventuali variazioni)</li>
            <li><em>Base giuridica: esecuzione del contratto (art. 6.1.b GDPR)</em></li>
        </ul>

        <h3>b) Obblighi di legge</h3>
        <ul>
            <li>Adempimenti fiscali e contabili</li>
            <li>Conservazione documenti per legge</li>
            <li><em>Base giuridica: obbligo legale (art. 6.1.c GDPR)</em></li>
        </ul>

        <h3>c) Comunicazioni di servizio</h3>
        <ul>
            <li>Risposta a richieste di informazioni o reclami</li>
            <li><em>Base giuridica: legittimo interesse (art. 6.1.f GDPR)</em></li>
        </ul>

        <h2>4. Come proteggiamo i tuoi dati</h2>
        <p>
            I dati personali sono trattati con strumenti elettronici e cartacei, adottando
            misure di sicurezza adeguate per prevenire l'accesso non autorizzato, la perdita
            o la divulgazione.
        </p>
        <p>
            I dati conservati sul Sito sono protetti da connessione HTTPS, password e
            accessi controllati.
        </p>

        <h2>5. Chi ha accesso ai tuoi dati</h2>
        <p>I dati personali sono trattati esclusivamente dal personale autorizzato della Bottega del Gusto.</p>
        <p>I dati possono essere comunicati a:</p>
        <ul>
            <li>Consulenti contabili e fiscali (per adempimenti di legge)</li>
            <li>Fornitori di servizi informatici (hosting, manutenzione sito)</li>
            <li>Autorità competenti (su richiesta legittima)</li>
        </ul>
        <p>I dati non vengono mai venduti, ceduti o utilizzati per scopi di marketing verso terzi.</p>

        <h2>6. Dove conserviamo i tuoi dati</h2>
        <p>
            I dati sono conservati su server situati nell'Unione Europea, presso fornitori
            che garantiscono il rispetto del GDPR.
        </p>
        <p>Non trasferiamo dati personali al di fuori dello Spazio Economico Europeo.</p>

        <h2>7. Per quanto tempo conserviamo i tuoi dati</h2>
        <p>
            I dati relativi agli ordini sono conservati per il tempo necessario all'esecuzione
            dell'ordine e per i successivi adempimenti fiscali e contabili (10 anni, ai sensi
            del Codice Civile).
        </p>
        <p>
            I dati di contatto (telefono, email) possono essere conservati per il tempo
            strettamente necessario alla gestione del rapporto commerciale.
        </p>

        <h2>8. I tuoi diritti</h2>
        <p>Ai sensi degli artt. 15–22 del GDPR, hai diritto di:</p>
        <ul>
            <li>Accedere ai tuoi dati personali (art. 15)</li>
            <li>Richiedere la rettifica di dati inesatti (art. 16)</li>
            <li>Richiedere la cancellazione dei dati ("diritto all'oblio", art. 17)</li>
            <li>Richiedere la limitazione del trattamento (art. 18)</li>
            <li>Ricevere i tuoi dati in formato strutturato (portabilità, art. 20)</li>
            <li>Opporti al trattamento (art. 21)</li>
            <li>Revocare il consenso, dove applicabile</li>
        </ul>
        <p>Per esercitare questi diritti, contattaci a:</p>
        <ul>
            <li>Email: <a href="mailto:labottegadelgustosas@gmail.com">labottegadelgustosas@gmail.com</a></li>
            <li>PEC: <a href="mailto:labottegadelgusto2025@pec.it">labottegadelgusto2025@pec.it</a></li>
        </ul>
        <p>Risponderemo entro 30 giorni dalla richiesta.</p>

        <h2>9. Reclami</h2>
        <p>
            Se ritieni che il trattamento dei tuoi dati violi il GDPR, hai diritto di
            proporre reclamo al Garante per la Protezione dei Dati Personali:
        </p>
        <address>
            Garante per la Protezione dei Dati Personali<br>
            Piazza Venezia, 11 — 00187 Roma<br>
            <a href="https://www.garanteprivacy.it" target="_blank" rel="noopener">www.garanteprivacy.it</a>
        </address>

        <h2>10. Cookie</h2>
        <p>
            Il Sito utilizza solo cookie tecnici necessari al funzionamento. Non sono
            utilizzati cookie analitici, di profilazione o di marketing.
        </p>
        <p>
            Per maggiori dettagli, consulta la <a href="{{ route('cookie-policy') }}">Cookie Policy</a>.
        </p>

        <h2>11. Modifiche a questa informativa</h2>
        <p>
            La presente informativa può essere aggiornata in qualsiasi momento. Le
            modifiche saranno pubblicate su questa pagina con la data di ultimo aggiornamento.
        </p>

        <h2>12. Contatti</h2>
        <p>Per qualsiasi domanda sulla privacy:</p>
        <ul>
            <li>Email: <a href="mailto:labottegadelgustosas@gmail.com">labottegadelgustosas@gmail.com</a></li>
            <li>PEC: <a href="mailto:labottegadelgusto2025@pec.it">labottegadelgusto2025@pec.it</a></li>
            <li>WhatsApp: <a href="https://wa.me/393928491518" target="_blank" rel="noopener">+39 392 8491518</a></li>
        </ul>
        <p class="legal__note">
            Le informazioni qui contenute sono fornite in buona fede e basate sulla
            normativa vigente. Per casi specifici, contatta direttamente il titolare.
        </p>

        <p class="legal__back">
            <a href="{{ route('home') }}">← Torna alla home</a>
        </p>
    </div>
</section>
@endsection

@push('head')
    @include('partials.schema-webpage', [
        'pageName'        => 'Informativa sulla Privacy — La Bottega del Gusto',
        'pageDescription' => 'Come trattiamo i dati personali dei clienti ai sensi del GDPR — La Bottega del Gusto di Montopoli in Val d\'Arno.',
    ])
@endpush
