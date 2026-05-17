<?php

namespace App\Http\Controllers;

use App\Helpers\SettingHelper;
use App\Models\Category;
use App\Models\Product;

class ShopController extends Controller
{
    public function comingSoon()
    {
        if (SettingHelper::shopEnabled()) {
            return redirect()->route('shop.index');
        }

        return view('pages.shop.coming-soon');
    }

    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('sort_order')
            ->get()
            ->map(function (Category $category) {
                $category->featured_products = Product::where('category_id', $category->id)
                    ->where('is_available', true)
                    ->orderBy('sort_order')
                    ->with('variants')
                    ->limit(4)
                    ->get();
                return $category;
            });

        return view('pages.shop.index', compact('categories'));
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->where('is_available', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->with('variants')
            ->paginate(12);

        $otherCategories = Category::where('is_active', true)
            ->where('id', '!=', $category->id)
            ->orderBy('sort_order')
            ->get();

        return view('pages.shop.category', compact('category', 'products', 'otherCategories'));
    }

    public function product(string $slug)
    {
        $product = Product::available()
            ->where('slug', $slug)
            ->with(['variants', 'category'])
            ->firstOrFail();

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_available', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('pages.shop.product', compact('product', 'related'));
    }
}
