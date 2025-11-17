<?php

namespace App\Http\Controllers;

use DateTime;

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
        } elseif ($perm == 'Admin') {
            return 'warning';
        } else {
            return 'dark';
        }
    }

    static function timeElapsed($dateString) {
        if (empty($dateString)) {
            return 'N/A';
        }

        try {
            $date = new DateTime(substr($dateString, 0, 10));
            $now = new DateTime(date('Y-m-d'));
            $diff = $now->diff($date);

            $parts = [];

            if ($diff->y > 0) {
                $parts[] = $diff->y . ' year' . ($diff->y > 1 ? 's' : '');
            }

            if ($diff->m > 0) {
                $parts[] = $diff->m . ' month' . ($diff->m > 1 ? 's' : '');
            }

            if ($diff->d > 0) {
                if ($diff->d == 1) {
                    $parts[] = '1 day';
                } else {
                    $parts[] = $diff->d . ' days';
                }
            }

            if (empty($parts)) {
                return 'Today';
            }

            if ($diff->d == 1) {
                return 'Yesterday';
            }

            return implode(', ', $parts) . ' ago';
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    static function censorText($text, $visibleChars = 6, $asterisks = 2) {
        $visible = substr($text, 0, $visibleChars);
        $hidden = str_repeat('*', $asterisks);
        return $visible . $hidden;
    }

    static function randomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }
}
