<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create();

        // Homepage
        $sitemap->add(
            Url::create(route('home'))
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(1.0)
        );

        // Listing eventi
        $sitemap->add(
            Url::create(route('events.index'))
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8)
        );

        // Singoli eventi pubblicati (solo futuri + in corso)
        Event::upcoming()->get()->each(function (Event $event) use ($sitemap) {
            $slug = $event->getTranslation('slug', 'it');

            if (! $slug) {
                return;
            }

            $sitemap->add(
                Url::create(route('events.show', ['slug' => $slug]))
                    ->setLastModificationDate($event->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.6)
            );
        });

        return response($sitemap->render(), 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
