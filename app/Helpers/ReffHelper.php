<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use App\Models\Reff;
use Illuminate\Validation\Rule;

class ReffHelper
{
    static function reffGenerate($request) {
        $successMessage = Config::get('messages.success.created');
        $errorMessage = Config::get('messages.error.validation');

        if ($request->input('code') == '') {
            do {
                $code = randomString();
                $codeExists = Reff::where('code', $code)->exists();
            } while ($codeExists);
        } else {
            $code = $request->input('code');

            $request->validate([
                'code' => [
                    'required',
                    'string',
                    'min:4',
                    'max:50',
                    Rule::unique('referrable_codes', 'code')
                ],
            ]);
        }

        try {
            Reff::create([
                'code'        => $code,
                'status'      => $request->input('status'),
                'registrar'   => auth()->user()->user_id,
            ]);

            return response()->json([
                'status' => 0,
                'message' => str_replace(':flag', "<b>Reff</b> " . $code, $successMessage),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 1,
                'message' => str_replace(':info', 'Error Code 201', $errorMessage),
            ]);
        }
    }

    static function reffEdit($request) {
        $successMessage = Config::get('messages.success.updated');
        $errorMessage = Config::get('messages.error.validation');

        $reff = Reff::where('edit_id', $request->input('edit_id'))->first();

        if (empty($reff)) {
            return back()->withErrors(['name' => str_replace(':info', 'Error Code 202', $errorMessage),])->onlyInput('name');
        }

        if ($request->input('code') == '') {
            do {
                $code = randomString();
                $codeExists = Reff::where('code', $code)->exists();
            } while ($codeExists);
        } else {
            $code = $request->input('code');

            $request->validate([
                'code' => [
                    'required',
                    'string',
                    'min:4',
                    'max:50',
                    Rule::unique('referrable_codes', 'code')->ignore($reff->edit_id, 'edit_id')
                ],
            ]);
        }

        try {
            $reff->update([
                'code'   => $code,
                'status' => $request->input('status'),
            ]);

            return response()->json([
                'status' => 0,
                'message' => str_replace(':flag', "<b>Reff</b> " . $code, $successMessage),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 1,
                'message' => str_replace(':info', 'Error Code 201', $errorMessage),
            ]);
        }
    }

    static function reffDelete($request) {
        $successMessage = Config::get('messages.success.deleted');
        $errorMessage = Config::get('messages.error.validation');

        $reff = Reff::where('edit_id', $request->input('edit_id'))->first();

        if (empty($reff)) {
            return back()->withErrors(['name' => str_replace(':info', 'Error Code 202', $errorMessage),])->onlyInput('name');
        }

        $code = $reff->code;

        try {
            $reff->delete();

            return response()->json([
                'status' => 0,
                'message' => str_replace(':flag', "<b>Reff</b> " . $code, $successMessage),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 1,
                'message' => str_replace(':info', 'Error Code 201', $errorMessage),
            ]);
        }
    }
}