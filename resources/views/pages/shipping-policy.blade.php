@extends('layouts.app')

@section('title', 'Spedizioni e Consegne — La Bottega del Gusto')
@section('description', 'Modalità di ritiro e consegna dei prodotti acquistati su labottegadimontopoli.it — Click & Collect e consegna a domicilio.')
@section('og_title', 'Spedizioni e Consegne — La Bottega del Gusto')
@section('og_description', 'Modalità di ritiro Click & Collect e consegna a domicilio nelle frazioni di Montopoli in Val d\'Arno.')

@section('content')
<section class="section legal">
    <div class="container legal__container">
        <h1 class="legal__title">Spedizioni e Consegne</h1>
        <p class="legal__updated">Ultimo aggiornamento: 16 maggio 2026</p>

        <p>La presente pagina descrive le modalità di ritiro e consegna dei prodotti acquistati su labottegadimontopoli.it.</p>

        <h2>1. Modalità disponibili</h2>
        <p>Attualmente è disponibile la seguente modalità:</p>
        <p><strong>&#10003; Click &amp; Collect — Ritiro in bottega</strong></p>
        <p>
            La consegna a domicilio sarà disponibile prossimamente. Per ordini con consegna
            a domicilio, contattaci direttamente:
        </p>
        <ul>
            <li>WhatsApp: <a href="https://wa.me/393928491518" target="_blank" rel="noopener">+39 392 8491518</a></li>
            <li>Email: <a href="mailto:labottegadelgustosas@gmail.com">labottegadelgustosas@gmail.com</a></li>
        </ul>

        <h2>2. Click &amp; Collect (ritiro in bottega)</h2>

        <h3>2.1 — Dove</h3>
        <p>I prodotti ordinati possono essere ritirati presso:</p>
        <address>
            <strong>La Bottega del Gusto</strong><br>
            Piazza Michele Da Montopoli, 3<br>
            56020 Montopoli in Val d'Arno (PI) — Italia
        </address>

        <h3>2.2 — Quando</h3>
        <p>Durante il checkout, puoi scegliere:</p>
        <ul>
            <li>Il giorno di ritiro (entro i prossimi 7 giorni)</li>
            <li>La fascia oraria di ritiro, tra quelle disponibili in base all'orario di apertura della bottega</li>
        </ul>
        <p>
            Gli orari di apertura sono indicati sulla pagina principale del sito e possono
            variare in caso di festività o chiusure straordinarie.
        </p>

        <h3>2.3 — Costo</h3>
        <p>Il ritiro in bottega è <strong>gratuito</strong>.</p>

        <h3>2.4 — Come funziona</h3>
        <ol>
            <li>Effettua l'ordine sul sito, selezionando i prodotti desiderati</li>
            <li>Scegli giorno e fascia oraria di ritiro</li>
            <li>Compila i tuoi dati di contatto (nome, telefono, email opzionale)</li>
            <li>Conferma l'ordine: verrai reindirizzato su WhatsApp per inviarci la tua richiesta</li>
            <li>Riceverai conferma dell'ordine</li>
            <li>Presentati in bottega nel giorno e nella fascia oraria selezionati</li>
            <li>Paga al ritiro (contanti, bancomat o carta di credito/debito)</li>
        </ol>

        <h3>2.5 — Mancato ritiro</h3>
        <p>
            In caso di mancato ritiro nella fascia oraria selezionata, conserveremo l'ordine
            fino al giorno lavorativo successivo. Provvederemo a contattarti per concordare
            un nuovo ritiro.
        </p>
        <p>
            Oltre questo termine, ci riserviamo il diritto di annullare l'ordine.
            Per i prodotti deperibili (pane, salumi, formaggi freschi, ecc.) non è previsto
            rimborso in caso di mancato ritiro non comunicato.
        </p>

        <h2>3. Consegna a domicilio</h2>

        <h3>3.1 — Stato del servizio</h3>
        <p>
            La consegna a domicilio è attualmente disponibile solo su richiesta diretta
            e non tramite ordine automatizzato sul sito.
        </p>
        <p>Per richiedere una consegna a domicilio:</p>
        <ul>
            <li>WhatsApp: <a href="https://wa.me/393928491518" target="_blank" rel="noopener">+39 392 8491518</a></li>
            <li>Email: <a href="mailto:labottegadelgustosas@gmail.com">labottegadelgustosas@gmail.com</a></li>
        </ul>

        <h3>3.2 — Zone di consegna</h3>
        <p>Effettuiamo consegne nelle seguenti località :</p>
        <ul>
            <li>Montopoli in Val d'Arno</li>
            <li>San Romano</li>
            <li>Le Capanne</li>
        </ul>
        <p>Per altre destinazioni o richieste particolari, contattaci.</p>

        <h3>3.3 — Costi e modalità</h3>
        <p>
            I costi e gli orari di consegna sono concordati direttamente al momento
            dell'ordine, in base alla disponibilità della bottega.
        </p>

        <h2>4. Prodotti freschi e deperibili</h2>
        <p>
            I prodotti freschi (pane, schiacciata, prodotti da forno, salumi al taglio,
            formaggi freschi) vengono preparati nel giorno del ritiro per garantire
            la massima freschezza.
        </p>
        <p>
            Si consiglia di consumare questi prodotti entro le indicazioni di scadenza,
            e di conservarli adeguatamente fino al consumo.
        </p>

        <h2>5. Disponibilità dei prodotti</h2>
        <p>
            I prodotti presenti sul Sito sono disponibili in base al magazzino reale della
            bottega. In caso di indisponibilità di un prodotto ordinato (es. esaurimento
            o problema di approvvigionamento), ti contatteremo per:
        </p>
        <ul>
            <li>Sostituire il prodotto con uno simile</li>
            <li>Rimuovere il prodotto dall'ordine e rimborsare la differenza</li>
            <li>Concordare una soluzione alternativa</li>
        </ul>

        <h2>6. Casi particolari</h2>

        <h3>6.1 — Festività e chiusure straordinarie</h3>
        <p>
            Durante festività e chiusure straordinarie, gli slot di ritiro disponibili
            sul Sito vengono aggiornati di conseguenza. In caso di dubbi, contattaci
            prima di effettuare l'ordine.
        </p>

        <h3>6.2 — Maltempo o cause di forza maggiore</h3>
        <p>
            In casi eccezionali (maltempo grave, blackout, problemi sanitari), potremmo
            dover modificare orari o annullare consegne. Ti contatteremo tempestivamente
            per concordare un'alternativa.
        </p>

        <h2>7. Prodotti alcolici</h2>
        <p>
            La vendita di prodotti alcolici (vini, birre, liquori) è limitata a persone
            maggiorenni (18+).
        </p>
        <p>
            Effettuando l'ordine, dichiari di essere maggiorenne. Al momento del ritiro,
            potremmo richiedere un documento di identità per verifica.
        </p>

        <h2>8. Contatti</h2>
        <p>Per qualsiasi domanda su ritiri o consegne:</p>
        <ul>
            <li>WhatsApp: <a href="https://wa.me/393928491518" target="_blank" rel="noopener">+39 392 8491518</a></li>
            <li>Email: <a href="mailto:labottegadelgustosas@gmail.com">labottegadelgustosas@gmail.com</a></li>
            <li>In bottega: Piazza Michele Da Montopoli, 3 — Montopoli in Val d'Arno (PI)</li>
        </ul>

        <p class="legal__note">
            Le informazioni qui contenute sono fornite in buona fede. Per casi specifici,
            contatta direttamente il titolare.
        </p>

        <p class="legal__back">
            <a href="{{ route('home') }}">← Torna alla home</a>
        </p>
    </div>
</section>
@endsection

@push('head')
    @include('partials.schema-webpage', [
        'pageName'        => 'Spedizioni e Consegne — La Bottega del Gusto',
        'pageDescription' => 'Modalità di ritiro Click & Collect e consegna a domicilio nelle frazioni di Montopoli in Val d\'Arno.',
    ])
@endpush
