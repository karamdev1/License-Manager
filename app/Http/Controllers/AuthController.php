<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\sendResetLinkRequest;
use App\Models\User;
use App\Models\UserHistory;
use App\Models\Reff;

class AuthController extends Controller
{
    public function login() {
        return view('Auth.login');
    }
    
    public function login_action(LoginRequest $request) {
        $successMessage = Config::get('messages.success.logged_in');
        $errorMessage = Config::get('messages.error.wrong_creds');

        $request->validated();

        $credentials = $request->only('username', 'password');

        $remember = $request->has('stay_log');

        $ip = $request->ip();
        $userAgent = $request->header('User-Agent');
        $username = $request->input('username');
        $userRecord = User::where('username', $request->input('username'))->first();
        $user_id = $userRecord ? $userRecord->user_id : null;

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $minutes = $remember ? 60 * 24 * 7 : 30;
            Session::put('session_lifetime', $minutes);
            Session::put('login_time', now());
            User::where('username', $username)->update(['last_login' => now()]);
            UserHistory::create([
                'user_id'    => $user_id,
                'username'   => $username,
                'status'     => 'Success',
                'ip_address' => $ip,
                'user_agent' => $userAgent,
            ]);

            return redirect(route('dashboard'))->with('msgSuccess', $successMessage);
        }

        UserHistory::create([
            'user_id' => $user_id,
            'username' => $username,
            'status' => 'Fail',
            'ip_address' => $ip,
            'user_agent' => $userAgent,
        ]);

        return back()->withErrors(['username' => $errorMessage])->onlyInput('username');
    }

    public function sendResetLink(sendResetLinkRequest $request) {
        $request->validated();

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => 0,
                'message' => "Password Reset request <b>sent</b> successfully",
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'message' => __($status),
            ]);
        }
    }
    
    public function logout(Request $request) {
        $ip = $request->ip();
        $userAgent = $request->header('User-Agent');
        $username = auth()->user()->username;
        $user_id = auth()->user()->user_id;
        UserHistory::create([
            'user_id'    => $user_id,
            'username'   => $username,
            'status'     => 'Success',
            'type'       => 'Logout',
            'ip_address' => $ip,
            'user_agent' => $userAgent,
        ]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $successMessage = Config::get('messages.success.logged_out');

        return redirect(route('login'))->with('msgSuccess', $successMessage);
    }

    public function register() {
        return view('Auth.register');
    }

    public function register_action(RegisterRequest $request) {
        $successMessage = Config::get('messages.success.register_success');
        $errorMessage = Config::get('messages.error.register_fail');

        $request->validated();

        $referrable = $request->input('reff');

        $reff = Reff::where('code', $referrable)->where('status', 'Active')->first();

        if (!$reff) {
            return back()->withErrors(['username' => $errorMessage,])->onlyInput('username');
        }

        $name = $request->input('name');
        $username = $request->input('username');
        $password = $request->input('password');
        $reff = $reff->edit_id;

        try {
            User::create([
                'name'     => $name,
                'username' => $username,
                'password' => $password,
                'reff'     => $reff,
            ]);
            return redirect(route('register'))->with('msgSuccess', $successMessage);
        } catch (Exception $e) {
            return back()->withErrors(['username' => $errorMessage,])->onlyInput('username');
        }

        return back()->withErrors(['username' => $errorMessage,])->onlyInput('username');
    }
}
