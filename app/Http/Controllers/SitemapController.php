<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Product;
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
            $sitemap->add(
                Url::create(route('events.show', ['slug' => $event->slug]))
                    ->setLastModificationDate($event->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.6)
            );
        });

        // Shop
        $sitemap->add(
            Url::create(route('shop.index'))
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.9)
        );

        // Categorie attive
        Category::where('is_active', true)->get()->each(function (Category $category) use ($sitemap) {
            $sitemap->add(
                Url::create(route('shop.category', ['slug' => $category->slug]))
                    ->setLastModificationDate($category->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.7)
            );
        });

        // Prodotti disponibili
        Product::available()->get()->each(function (Product $product) use ($sitemap) {
            $sitemap->add(
                Url::create(route('shop.product', ['slug' => $product->slug]))
                    ->setLastModificationDate($product->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.6)
            );
        });

        return response($sitemap->render(), 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
