<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function LoginView() {
        return view('Auth.login');
    }
    
    public function LoginPost(Request $request) {
        $successMessage = Config::get('messages.success.logged_in');
        $errorMessage = Config::get('messages.error.wrong_creds');

        $request->validate([
            'username' => 'required|string|max:50',
            'password' => 'required|string|min:8|max:50',
            'stay_log' => 'in:1,0',
        ]);

        $credentials = $request->only('username', 'password');

        $remember = $request->has('stay_log');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            Session::put('login_time', now());
            return redirect()->intended('dashboard')->with('msgSuccess', $successMessage);
        }

        return back()->withErrors(['username' => $errorMessage,])->onlyInput('username');
    }
    
    public function Logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $successMessage = Config::get('messages.success.logged_out');

        return redirect('/login')->with('msgSuccess', $successMessage);
    }

    public function RegisterView() {
        return view('Auth.register');
    }

    public function RegisterPost(Request $request) {
        $successMessage = Config::get('messages.success.register_success');
        $errorMessage = Config::get('messages.error.register_fail');

        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|unique:users,username|max:50',
            'password' => 'required|string|confirmed|min:8|max:50',
            'reff' => 'required|string|max:50',
        ]);

        $referrable = $request->input('reff');

        $reff = Reff::where('code', $referrable)->first();

        if (!$reff) {
            return back()->withErrors([
                'username' => $errorMessage,
            ])->onlyInput('username');
        }

        $name = $request->input('name');
        $username = $request->input('username');
        $password = $request->input('password');
        $reffCode = $reff->code;

        try {
            User::create([
                'name'     => $name,
                'username' => $username,
                'password' => $password,
                'reff'     => $reffCode,
            ]);
            return redirect()->intended('register')
                ->with('msgSuccess', $successMessage);
        } catch (Exception $e) {
            return back()->withErrors([
                'username' => $errorMessage,
            ])->onlyInput('username');
        }

        return back()->withErrors([
            'username' => $errorMessage,
        ])->onlyInput('username');
    }
}
