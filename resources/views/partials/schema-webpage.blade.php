<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebPage",
    "name": {!! json_encode($pageName) !!},
    "description": {!! json_encode($pageDescription) !!},
    "url": "{{ url()->current() }}",
    "isPartOf": {
        "@@type": "WebSite",
        "name": "La Bottega del Gusto",
        "url": "{{ url('/') }}"
    },
    "inLanguage": "it-IT"
}
</script>
