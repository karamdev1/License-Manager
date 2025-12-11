<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

function getSetting($key, $default = null) {
    if (Schema::hasTable('settings')) {
        $setting = Setting::where('key', $key)->first();
        return $setting ? $setting->value : env(strtoupper($key), $default);
    }

    return env(strtoupper($key), $default);
}

function setSetting($key, $value) {
    if (Schema::hasTable('settings')) {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
