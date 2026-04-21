# La Bottega del Gusto

Sito vetrina per **La Bottega del Gusto**, bottega alimentare di Montopoli in Val d'Arno (PI). Una homepage con hero, presentazione, elenco eventi futuri e contatti, più un pannello admin per gestire gli eventi.

## Stack

- **Laravel 12** (PHP ^8.2)
- **PostgreSQL 17** (via Docker)
- **Filament 3** — pannello admin su `/admin`
- **Spatie Translatable** — contenuti IT/EN (al momento IT attivo)
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
  Http/Controllers/      # HomeController, EventController
  Models/                # Event (con HasTranslations)
resources/views/
  layouts/app.blade.php  # Layout base con <head> SEO
  pages/                 # home, events/index, events/show
  partials/              # hero, about, events, contact, socials, schema
  components/            # event-card
public/
  css/main.css           # CSS statico
  js/hero-slider.js      # Slider hero
  images/                # Foto bottega
routes/web.php           # /, /eventi, /eventi/{slug}, /events, /events/{slug}
```

## Contenuti

- **Homepage**: hero slider (4 foto), sezione chi siamo, prossimi eventi, contatti con mappa.
- **Eventi**: gestiti da admin (titolo, slug, date, cover, locale). Il modello ha scope `upcoming()` che filtra solo pubblicati e non conclusi.
- **SEO**: canonical, hreflang IT / x-default, Open Graph, Twitter Card, JSON-LD `FoodEstablishment` + `Event`, link al sitemap.

## Asset immagini

Le foto della bottega sono gestite fuori dal repo in `../labottega-assets/originali/`, suddivise in `orizzontali/`, `verticali/`, `video/`. Quelle effettivamente pubblicate sono copiate in `public/images/` mantenendo il nome originale.

## Note

- Le route `/events/*` passano `defaults('locale', 'en')` ma `EventController` usa `app()->getLocale()` — serve un middleware che imposti il locale dalla route prima di attivare davvero la versione inglese.
- Il base image del Dockerfile è `php:8.4-fpm-alpine` con `apk upgrade` per le patch Alpine. Se lo scanner continua a segnalare vulnerabilità, valutare di pinnare una versione PHP più specifica.

## Licenza

Progetto privato. Laravel è MIT.
