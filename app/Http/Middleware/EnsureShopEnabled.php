<?php

namespace App\Http\Middleware;

use App\Helpers\SettingHelper;
use Closure;
use Illuminate\Http\Request;

class EnsureShopEnabled
{
    public function handle(Request $request, Closure $next)
    {
        if (!SettingHelper::shopEnabled()) {
            if ($request->isMethod('GET')) {
                return redirect()->route('shop.coming-soon');
            }
            return response()->json(['error' => 'Lo shop non è attualmente disponibile.'], 403);
        }

        return $next($request);
    }
}
