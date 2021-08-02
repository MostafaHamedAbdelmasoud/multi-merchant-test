<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 10/11/20
 * Time: 02:53 م
 */

namespace App\Services\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

trait AuthMethods
{
    public function login(Request $request, $type = 4)
    {
        $this->setColumns(['id', 'name',
            'email_verified_at', 'password', 'type', 'phone'
        ]);
        $this->setConditions([['type', 2]]);
        $this->setOrConditions([['type', 3]]);
        $user = $this->findByColumn('email', $request->email);
        if (!$user) {
            return false;
        }
        if ($user->is_ban == 1) {
            abort(403, 'your account has been banned');
        }
        $check = Hash::check($request->password, $user->password);
        if (!$check) {
            return false;
        };


        $user['token'] = $user->createToken($user->user_type . ' Token')->accessToken;
        return $user;
    }

    public function logout()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->authAccessToken()->delete();

            return true;
        }
        return false;
    }

}
