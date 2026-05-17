<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingHelper
{
    public static function shopEnabled(): bool
    {
        return Setting::getBool('shop_enabled', false);
    }
}
