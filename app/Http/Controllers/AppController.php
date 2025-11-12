<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\App;

class AppController extends Controller
{
    public function AppListView() {
        $apps = App::paginate(10);

        return view('App.list', compact('apps'));
    }

    public function AppGenerateView() {
        return view('App.generate');
    }

    public function AppGeneratePost(Request $request) {
        $successMessage = Config::get('messages.success.created');
        $errorMessage = Config::get('messages.error.validation');

        $request->validate([
            'name' => 'required|string|unique:apps,name|min:6|max:50',
            'basic' => 'required|integer|min:1|max:300000',
            'premium' => 'required|integer|min:1|max:300000',
            'status' => 'required|in:Active,Inactive',
        ]);

        try {
            App::create([
                'name'        => $request->input('name'),
                'ppd_basic'   => $request->input('basic'),
                'ppd_premium' => $request->input('premium'),
                'status'      => $request->input('status'),
            ]);

            return redirect()->route('apps.generate')->with('msgSuccess', str_replace(':flag', "App " . $request->input('name'), $successMessage));
        } catch (\Exception $e) {
            return back()->withErrors(['name' => str_replace(':info', 'Error Code 201', $errorMessage),])->onlyInput('name');
        }
    }
}