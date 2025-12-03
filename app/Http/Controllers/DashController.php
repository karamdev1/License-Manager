<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\License;
use App\Models\App;
use App\Models\User;
use App\Models\UserHistory;
use App\Models\Reff;
use Illuminate\Validation\Rule;

class DashController extends Controller
{
    static function UsersCreated($edit_id) {
        $reff = Reff::where('edit_id', $edit_id)->first();
        if (!$reff) return "N/A";

        return $reff->users->count();
    }

    public function dashboard() {
        $licenses = License::orderBy('created_at', 'desc')->limit(10)->get();
        $currency = Config::get('messages.settings.currency');
        $loginTime = session('login_time');
        $sessionLifetime = session('session_lifetime');
        $expiryTime = $loginTime ? $loginTime->copy()->addMinutes($sessionLifetime) : null;

        return view('Home.dashboard', compact('licenses', 'currency', 'expiryTime', 'loginTime', 'sessionLifetime'));
    }

    public function managereferrable() {
        $errorMessage = Config::get('messages.error.validation');
        $reffs = Reff::get();

        parent::require_ownership();
        
        return view('Home.manage_reff', compact('reffs'));
    }

    public function managereferrablegenerate() {
        $errorMessage = Config::get('messages.error.validation');

        parent::require_ownership();

        return view('Home.generate_reff');
    }

    public function managereferrablegenerate_action(Request $request) {
        $successMessage = Config::get('messages.success.created');
        $errorMessage = Config::get('messages.error.validation');

        parent::require_ownership();

        $request->validate([
            'status'   => 'required|in:Active,Inactive',
        ]);

        if ($request->input('code') == '') {
            do {
                $code = parent::randomString(16);
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

            return redirect()->route('admin.referrable.generate')->with('msgSuccess', str_replace(':flag', "<b>Reff</b> " . $code, $successMessage));
        } catch (\Exception $e) {
            return back()->withErrors(['name' => str_replace(':info', 'Error Code 202', $errorMessage),])->onlyInput('name');
        }
    }

    public function managereferrableedit($id) {
        $errorMessage = Config::get('messages.error.validation');
        $reff = Reff::where('edit_id', $id)->first();

        parent::require_ownership();

        if (empty($reff)) {
            return back()->withErrors(['name' => str_replace(':info', 'Error Code 202', $errorMessage),])->onlyInput('name');
        }

        return view('Home.edit_reff', compact('reff'));
    }

    public function managereferrableedit_action(Request $request) {
        $successMessage = Config::get('messages.success.updated');
        $errorMessage = Config::get('messages.error.validation');

        parent::require_ownership();

        $request->validate([
            'edit_id'  => 'required|string|min:4|max:36|exists:referrable_codes,edit_id',
            'status'   => 'required|in:Active,Inactive',
        ]);

        $reff = Reff::where('edit_id', $request->input('edit_id'))->first();

        if (empty($reff)) {
            return back()->withErrors(['name' => str_replace(':info', 'Error Code 203', $errorMessage),])->onlyInput('name');
        }

        if ($request->input('code') == '') {
            do {
                $code = parent::randomString(16);
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

            return redirect()->route('admin.referrable.edit', $request->input('edit_id'))->with('msgSuccess', str_replace(':flag', "<b>Reff</b> " . $code, $successMessage));
        } catch (\Exception $e) {
            return back()->withErrors(['name' => str_replace(':info', 'Error Code 202', $errorMessage),])->onlyInput('name');
        }
    }

    public function managereferrabledelete(Request $request) {
        $successMessage = Config::get('messages.success.deleted');
        $errorMessage = Config::get('messages.error.validation');

        parent::require_ownership();

        $request->validate([
            'edit_id'  => 'required|string|min:4|max:36|exists:referrable_codes,edit_id',
        ]);

        $reff = Reff::where('edit_id', $request->input('edit_id'))->first();

        if (empty($reff)) {
            return back()->withErrors(['name' => str_replace(':info', 'Error Code 203', $errorMessage),])->onlyInput('name');
        }

        $code = $reff->code;

        try {
            $reff->delete();

            return redirect()->route('admin.referrable')->with('msgSuccess', str_replace(':flag', "<b>Reff</b> " . $code, $successMessage));
        } catch (\Exception $e) {
            return back()->withErrors(['name' => str_replace(':info', 'Error Code 202', $errorMessage),])->onlyInput('name');
        }
    }
}
