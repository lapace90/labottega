<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $pane = Category::where('slug', 'pane-e-schiacciate')->first();
        $salumi = Category::where('slug', 'salumi')->first();
        $formaggi = Category::where('slug', 'formaggi')->first();
        $vini = Category::where('slug', 'vini')->first();
        $aperibox = Category::where('slug', 'aperibox')->first();

        $pane1 = Product::firstOrCreate(
            ['slug' => 'pane-sciocco-toscano-800g'],
            [
                'category_id' => $pane?->id,
                'name' => 'Pane sciocco toscano 800g',
                'description' => null,
                'pricing_type' => 'piece',
                'price_piece' => 4.50,
                'price_per_kg' => null,
                'is_available' => true,
                'sort_order' => 1,
            ]
        );

        $mortadella = Product::firstOrCreate(
            ['slug' => 'mortadella-igp'],
            [
                'category_id' => $salumi?->id,
                'name' => 'Mortadella IGP',
                'description' => null,
                'pricing_type' => 'weight',
                'price_piece' => null,
                'price_per_kg' => 18.00,
                'is_available' => true,
                'sort_order' => 1,
            ]
        );
        foreach ([100, 200, 300, 500] as $i => $grams) {
            ProductVariant::firstOrCreate(
                ['product_id' => $mortadella->id, 'grams' => $grams],
                ['sort_order' => $i]
            );
        }

        $pecorino = Product::firstOrCreate(
            ['slug' => 'pecorino-di-pienza-dop'],
            [
                'category_id' => $formaggi?->id,
                'name' => 'Pecorino di Pienza DOP',
                'description' => null,
                'pricing_type' => 'weight',
                'price_piece' => null,
                'price_per_kg' => 28.00,
                'is_available' => true,
                'sort_order' => 1,
            ]
        );
        foreach ([100, 200, 300, 500] as $i => $grams) {
            ProductVariant::firstOrCreate(
                ['product_id' => $pecorino->id, 'grams' => $grams],
                ['sort_order' => $i]
            );
        }

        Product::firstOrCreate(
            ['slug' => 'chianti-doc-075l'],
            [
                'category_id' => $vini?->id,
                'name' => 'Chianti DOC 0,75L',
                'description' => null,
                'pricing_type' => 'piece',
                'price_piece' => 8.50,
                'price_per_kg' => null,
                'is_available' => true,
                'sort_order' => 1,
            ]
        );

        Product::firstOrCreate(
            ['slug' => 'aperibox-classica-per-2-persone'],
            [
                'category_id' => $aperibox?->id,
                'name' => 'Aperibox Classica per 2 persone',
                'description' => 'Selezione di salumi misti, pecorino fresco, crostini di campagna, focaccia e un calice di vino',
                'pricing_type' => 'piece',
                'price_piece' => 22.00,
                'price_per_kg' => null,
                'is_available' => true,
                'sort_order' => 1,
            ]
        );

        Product::firstOrCreate(
            ['slug' => 'schiacciata-farcita'],
            [
                'category_id' => $pane?->id,
                'name' => 'Schiacciata farcita',
                'description' => null,
                'pricing_type' => 'piece',
                'price_piece' => 6.00,
                'price_per_kg' => null,
                'is_available' => true,
                'sort_order' => 2,
            ]
        );
    }
}
