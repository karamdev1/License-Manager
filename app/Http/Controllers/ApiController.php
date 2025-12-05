<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\App;
use App\Models\License;

class ApiController extends Controller
{
    public function Authenticate(Request $request) {
        $licenseInput = $request->input('license');
        $app_id = $request->input('app');
        $serial = $request->input('serial');

        if (!$licenseInput || !$app_id || !$serial) {
            return response()->json([
                'status' => 1,
                'message' => 'Inputs are required',
            ]);
        }

        $app = App::where('app_id', $app_id)->first();
        $license = License::where('license', $licenseInput)
            ->where('app_id', $app_id)
            ->where('status', 'Active')
            ->first();

        if (empty($app) || empty($license)) {
            return response()->json([
                'status' => 1,
                'message' => 'App or License Not Found',
            ]);
        }

        $devices = $license->devices;
        $deviceArray = $devices ? explode(',', $devices) : [];

        if (count($deviceArray) >= $license->max_devices && !in_array($serial, $deviceArray)) {
            return response()->json([
                'status' => 1,
                'message' => 'Maximum number of devices reached',
            ]);
        }

        if (!in_array($serial, $deviceArray)) {
            $deviceArray[] = $serial;
            $license->devices = implode(',', $deviceArray);
            $license->save();
        }

        return response()->json([
            'status' => 0,
            'message' => 'Authenticated',
        ]);
    }
}