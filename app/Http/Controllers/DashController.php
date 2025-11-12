<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Key;
use App\Models\App;

class DashController extends Controller
{
    public function Dashboard() {
        $apps = App::paginate(10, ['*'], 'apps_page');
        $keys = Key::paginate(10, ['*'], 'keys_page');

        return view('Home.dashboard', compact('keys', 'apps'));
    }
}
