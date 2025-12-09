<?php

use Illuminate\Http\Exceptions\HttpResponseException;

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