<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(\App\Services\CartService::class);
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $cart = app(\App\Services\CartService::class);
            $view->with([
                'cartCount'      => $cart->count(),
                'cartProductIds' => $cart->productIds(),
                'cartIsEmpty'    => $cart->isEmpty(),
            ]);
        });

        Blade::if('shopEnabled', function () {
            return \App\Helpers\SettingHelper::shopEnabled();
        });
    }
}
