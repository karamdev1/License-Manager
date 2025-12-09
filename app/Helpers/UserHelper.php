<?php

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Config;
use App\Models\User;

function require_ownership($allow_manager = 0, $fail = 1, $json_response = 0) {
    $user = auth()->user();
    $errorMessage = Config::get('messages.error.validation');

    if (!$user) {
        throw new HttpResponseException(
            response()->json([
                'status' => 1,
                'message' => 'Unauthorized.'
            ], 401)
        );
    }

    if ($user->role === "Owner") return true;
    if ($allow_manager == 1 && $user->role === "Manager") return true;

    $finalMessage = str_replace(':info', 'Error Code 403, <b>Access Forbidden</b>', $errorMessage);

    if ($json_response == 1) {
        throw new HttpResponseException(
            response()->json([
                'status' => 1,
                'message' => $finalMessage
            ], 403)
        );
    }

    if ($fail == 1) {
        throw new HttpResponseException(
            back()->withErrors([
                'name' => $finalMessage
            ])->onlyInput('name')
        );
    }
}

function manager_limit($role) {
    if (auth()->user()->role === "Manager") {
        if ($role === "Owner") {
            throw new HttpResponseException(
                back()->withErrors([
                    'name' => '<b>You</b> cannot <b>register</b>, <b>edit</b>, or <b>delete</b> a user with a <b>higher</b> role than yours.'
                ])->onlyInput('name')
            );
            return false;
        }
    }

    return true;
}

function psueAction($user) {
    if ($user->user_id == auth()->user()->user_id && $user->id == auth()->user()->id) {
        throw new HttpResponseException(
            back()->withErrors([
                'name' => 'The selected <b>user</b> is the same as the currently <b>logged-in</b> user.'
            ])->onlyInput('name')
        );
        return false;
    }

    return true;
}

function saldoData($userSaldo, $userRole, $raw = 0) {
    $currency = Config::get('messages.settings.currency');
    $cplace = Config::get('messages.settings.currency_place');
    if ($userSaldo >= 2000000000 || $userRole == "Owner") {
        if ($raw === 1) {
            $saldo = "Unlimited";
        } else {
            $saldo = "∾";
        }
        $saldo_color = "primary";
    } else {
        if ($raw === 1) {
            $saldo = $userSaldo;
        } else {
            if ($cplace == 0) {
                $saldo = number_format($userSaldo) . $currency;
            } else if ($cplace == 1) {
                $saldo = $currency . number_format($userSaldo);
            } else {
                $saldo = number_format($userSaldo) . ' ' . $currency;
            }
            
        }
        if ($userSaldo <= 100) {
            $saldo_color = "danger";
        } else if ($userSaldo <= 1000) {
            $saldo_color = "warning";
        } else {
            $saldo_color = "success";
        }
    }

    $data = [$saldo, $saldo_color];

    return $data;
}

function userUsername($user_id) {
    $user = User::where('user_id', $user_id)->first();
    return $user?->username ?? 'N/A';
}