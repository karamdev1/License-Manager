<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use app\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
use Carbon\Carbon;

abstract class Controller
{
    static function statusColor($status) {
        if ($status == 'Active') {
            return 'success';
        } elseif ($status == 'Inactive') {
            return 'danger';
        } else {
            return 'warning';
        }
    }

    static function permissionColor($perm) {
        if ($perm == 'Owner') {
            return 'danger';
        } elseif ($perm == 'Manager') {
            return 'warning';
        } elseif ($perm == 'Reseller') {
            return 'primary';
        } else {
            return 'dark';
        }
    }

    static function timeElapsed($dateString) {
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

    static function censorText($text, $visibleChars = 5, $asterisks = 2) {
        $visible = substr($text, 0, $visibleChars);
        $hidden = str_repeat('*', $asterisks);
        return $visible . $hidden;
    }

    static function randomString($length = 15) {
        return Str::random($length);
    }

    static function userUsername($user_id) {
        $user = User::where('user_id', $user_id)->first();
        return $user?->username ?? 'N/A';
    }
}