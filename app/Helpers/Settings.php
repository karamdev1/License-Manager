<?php

use App\Models\Setting;

function getSetting($key, $default = null) {
    $setting = Setting::find($key);
    return $setting ? $setting->value : env(strtoupper($key), $default);
}

function setSetting($key, $value) {
    Setting::updateOrCreate(
        ['key' => $key],
        ['value' => $value]
    );
}