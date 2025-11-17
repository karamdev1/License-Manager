<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\KeyController;
use App\Models\App;
use App\Models\Key;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function ApiConnect(Request $request) {
        $app_id = $request->query('app_id');
        $keyName = $request->query('key');

        $app = App::where('app_id', $app_id)->first();
        if (!$app) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $key = Key::where('key', $keyName)->first();

        if (!$key || $key->status != "Active" || Carbon::parse($key->expire_date)->lt(Carbon::today())) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Authenticated',
            'expire_date' => $key->expire_date,
            'duration' => $key->duration,
            'rank' => $key->rank,
            'price' => KeyController::keyPriceCalculator($key->rank, $key->app->ppd_basic, $key->app->ppd_premium, $key->max_devices, $key->duration),
        ]);
    }
}
