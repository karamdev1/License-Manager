<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use App\Models\UserHistory;
use App\Http\Requests\UserGenerateRequest;
use App\Http\Requests\UserSaldoUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserDeleteRequest;
use App\Helpers\UserHelper;

class UserController extends Controller
{
    public function userregistrations() {
        require_ownership(1);
        
        $users = User::get();

        $data = $users->map(function ($user) {
            $created = timeElapsed($user->created_at);
            $userStatus = statusColor($user->status);
            $saldo = saldoData($user->saldo, $user->role);
            $saldoS = $saldo[0];
            $saldoC = $saldo[1];
            $roleC = permissionColor($user->role);

            if ($user->referrable != NULL) {
                $reff_status = statusColor($user->referrable->status);
                $reff_code = censorText($user->referrable->code);
            } else {
                $reff_status = 'dark';
                $reff_code = "N/A";
            }

            return [
                'id'        => $user->id,
                'user_id'   => $user->user_id,
                'name'      => $user->name,
                'email'     => "<span class='text-$userStatus blur hover:blur-none transition-all duration-200 p-2 Blur-User'>$user->email</span>",
                'username'  => "<span class='text-$userStatus blur hover:blur-none transition-all duration-200 p-2 Blur-User copy-user' data-copy='$user->username'>$user->username</span>",
                'created'   => "<i class='text-gray-500'>$created</i>",
                'saldo'     => "<span class='text-$saldoC'>$saldoS</span>",
                'role'      => "<span class='text-$roleC '>$user->role</span>",
                'registrar' => userUsername($user->registrar),
                'reff'      => "<span class='text-$reff_status'>$reff_code</span>",
            ];
        });

        return response()->json([
            'status' => 0,
            'data'   => $data
        ]);
    }

    public function userregister(UserGenerateRequest $request) {
        $request->validated();

        return UserHelper::userGenerate($request);
    }

    public function useredit(UserUpdateRequest $request) {
        $request->validated();

        return UserHelper::userEdit($request);
    }

    public function usersaldoedit(UserSaldoUpdateRequest $request) {
        $request->validated();

        return UserHelper::userSaldoEdit($request);
    }

    public function userdelete(UserDeleteRequest $request) {
        $request->validated();

        return UserHelper::userDelete($request);
    }
}
