<?php

namespace App\Helpers;

use Carbon\Carbon;

class LicenseInfo
{
    static function licensePriceCalculator($price, $devices, $duration) {
        $price = (int) $price;
        $devices = (int) $devices;
        $duration = (int) $duration;

        $duration = $duration / 30;
        $total = $price * $duration * $devices;

        return $total;
    }

    static function saldoPriceCut($devices, $duration) {
        $basePrice = 10;
        $devices = (int) $devices;
        $duration = (int) $duration;

        $duration = $duration / 30;
        $total = $basePrice * $duration * $devices;
        $total = [$total, number_format($total)];

        return $total;
    }

    static function RemainingDays($expire_date) {
        if (empty($expire_date)) {
            return 'N/A';
        }

        try {
            $expire = Carbon::parse($expire_date);
        } catch (\Exception $e) {
            return 'N/A';
        }

        $remainingDays = now()->diffInDays($expire, false) + 1;
        return max(0, (int) $remainingDays);
    }

    static function RemainingDaysColor($remainingDays) {
        if ($remainingDays == "N/A") {
            return "red-600";
        } elseif ($remainingDays <= 10) {
            return 'red-600';
        } elseif ($remainingDays <= 20) {
            return 'yellow-300';
        } elseif ($remainingDays <= 30) {
            return 'green-600';
        } else {
            return 'green-600';
        }
    }

    static function RankColor($rank) {
        if ($rank == "Basic" || $rank == "basic") {
            return "green-600";
        } elseif ($rank == "Premium" || $rank == "premium") {
            return "yellow-300";
        } else {
            return "red-600";
        }
    }

    static function DevicesHooked($serials) {
        $items = preg_split('/[\s,]+/', trim($serials), -1, PREG_SPLIT_NO_EMPTY);
        $count = count($items);
        return $count;
    }
}