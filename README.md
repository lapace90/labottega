# La Bottega del Gusto

Sito vetrina per **La Bottega del Gusto**, bottega alimentare di Montopoli in Val d'Arno (PI). Una homepage con hero, presentazione, elenco eventi futuri e contatti, più un pannello admin per gestire gli eventi. Sito solo in italiano.

## Stack

- **Laravel 12** (PHP ^8.2)
- **PostgreSQL 17** (via Docker)
- **Filament 3** — pannello admin su `/admin`
- **Spatie Sitemap** + **Spatie Schema.org** — SEO
- **CSS** statico in `public/css/main.css`

## Avvio in locale (Docker)

Requisiti: Docker e Docker Compose.

```bash
cp .env.example .env
docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan storage:link
```

- App: http://localhost:8001
- Admin: http://localhost:8001/admin
- Postgres: `127.0.0.1:5434`

Per creare il primo utente admin:

```bash
docker compose exec app php artisan make:filament-user
```

## Avvio in locale (senza Docker)

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
composer dev   # avvia server + queue + logs + vite
```

## Struttura

```
app/
  Filament/Resources/    # Resource admin (es. EventResource)
  Http/Controllers/      # HomeController, EventController, SitemapController
  Models/                # Event
resources/views/
  layouts/app.blade.php  # Layout base con <head> SEO
  pages/                 # home, cookie-policy, events/index, events/show
  partials/              # hero, about, events, contact, socials, schema
  components/            # event-card, cookie-banner
public/
  css/main.css           # CSS statico
  js/hero-slider.js      # Slider hero
  images/                # Foto bottega
routes/web.php           # /, /eventi, /eventi/{slug}, /cookie-policy, /sitemap.xml
```

## Contenuti

- **Homepage**: hero slider (4 foto), sezione chi siamo, prossimi eventi, contatti con mappa.
- **Eventi**: gestiti da admin (titolo, slug, date, cover, descrizione). Il modello ha scope `upcoming()` (pubblicati e non conclusi) e `past()` (pubblicati e conclusi). La pagina `/eventi` mostra di default gli upcoming; con `?past=1` mostra i passati.
- **Cookie**: banner consenso + pagina `/cookie-policy`. La mappa Google Maps viene caricata solo dopo consenso esplicito.
- **SEO**: canonical, hreflang `it`, Open Graph, Twitter Card, JSON-LD `FoodEstablishment` + `Event`, link al sitemap.

## Asset immagini

Le foto della bottega sono gestite fuori dal repo in `../labottega-assets/originali/`, suddivise in `orizzontali/`, `verticali/`, `video/`. Quelle effettivamente pubblicate sono copiate in `public/images/` mantenendo il nome originale.

## Note

- Il base image del Dockerfile è `php:8.4-fpm-alpine` con `apk upgrade` per le patch Alpine. Se lo scanner continua a segnalare vulnerabilità, valutare di pinnare una versione PHP più specifica.

## Licenza

Progetto privato. Laravel è MIT.
