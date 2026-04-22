@php
    $openingSpec = app(\App\Services\OpeningHoursService::class)->forSchemaOrg();
@endphp
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "FoodEstablishment",
    "name": "La Bottega del Gusto",
    "image": "{{ asset('images/tagliere-vino.jpeg') }}",
    "@@id": "{{ url('/') }}",
    "url": "{{ url('/') }}",
    "telephone": "+393928491518",
    "priceRange": "€€",
    "address": {
        "@@type": "PostalAddress",
        "streetAddress": "Piazza Michele Da Montopoli, 3",
        "addressLocality": "Montopoli in Val d'Arno",
        "addressRegion": "PI",
        "postalCode": "56020",
        "addressCountry": "IT"
    },
    "geo": {
        "@@type": "GeoCoordinates",
        "latitude": 43.6703471,
        "longitude": 10.7608832
    },
    "knowsAbout": [
        "Cucina toscana",
        "Prodotti tipici locali",
        "Too Good To Go",
        "Riduzione dello spreco alimentare"
    ],
@if(!empty($openingSpec))
    "openingHoursSpecification": {!! json_encode($openingSpec, JSON_UNESCAPED_SLASHES) !!},
@endif
    "event": {
        "@@type": "EventSeries",
        "name": "Apericena toscana",
        "description": "Taglieri di salumi e formaggi del territorio, vini locali, schiacciata calda. Ogni giovedì sera in bottega.",
        "eventSchedule": {
            "@@type": "Schedule",
            "repeatFrequency": "P1W",
            "byDay": "https://schema.org/Thursday",
            "startTime": "19:00",
            "scheduleTimezone": "Europe/Rome"
        },
        "location": {
            "@@type": "Place",
            "name": "La Bottega del Gusto",
            "address": {
                "@@type": "PostalAddress",
                "streetAddress": "Piazza Michele Da Montopoli, 3",
                "addressLocality": "Montopoli in Val d'Arno",
                "addressRegion": "PI",
                "postalCode": "56020",
                "addressCountry": "IT"
            }
        },
        "organizer": {
            "@@type": "Organization",
            "name": "La Bottega del Gusto",
            "url": "{{ url('/') }}"
        },
        "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode"
    },
    "sameAs": [
        "https://www.facebook.com/LaBottegaDelGustoMontopoli",
        "https://www.instagram.com/la.bottegadel.gusto/"
    ]
}
</script>
