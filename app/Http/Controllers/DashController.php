<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\Key;
use App\Models\App;

class DashController extends Controller
{
    public function Dashboard() {
        if (auth()->user()->permissions == "Owner") {
            $keys = Key::orderBy('created_at', 'desc')->paginate(10, ['*'], 'keys_page');
        } else {
            $keys = Key::where('created_by', auth()->user()->username)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'keys_page');
        }
        $apps = App::orderBy('created_at', 'desc')->paginate(10, ['*'], 'apps_page');
        $currency = Config::get('messages.settings.currency');

        return view('Home.dashboard', compact('keys', 'apps', 'currency'));
    }
}
