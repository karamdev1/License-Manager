<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WebuiUpdateRequest;

class WebuiController extends Controller
{
    public function webui_settings() {
        return view('Settings.webui_settings');
    }

    public function webui_action(WebuiUpdateRequest $request) {
        $validated = $request->validated();
    }
}
