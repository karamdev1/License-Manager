<?php

use Carbon\Carbon;
use Illuminate\Support\Str;

function timeElapsed($dateString) {
    if (empty($dateString)) {
        return 'N/A';
    }

    try {
        $date = Carbon::parse($dateString);
        return $date->diffForHumans([
            'parts' => 1,
            'short' => false,
            'syntax' => Carbon::DIFF_RELATIVE_TO_NOW
        ]);
    } catch (\Exception $e) {
        return 'N/A';
    }
}

function censorText($text, $visibleChars = 5, $asterisks = 2) {
    $visible = substr($text, 0, $visibleChars);
    $hidden = str_repeat('*', $asterisks);
    return $visible . $hidden;
}

function randomString($length = 15) {
    return Str::random($length);
}