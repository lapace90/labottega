<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Salumi',
            'Formaggi',
            'Pane e schiacciate',
            'Pizza',
            'Pasta',
            'Aperibox',
            'Vini',
            'Bibite',
            'Conserve',
            'Frutta e verdura',
            'Dolci',
            'Altro',
        ];

        foreach ($names as $index => $name) {
            Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
