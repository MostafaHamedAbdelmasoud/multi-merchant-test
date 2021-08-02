<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 28/09/20
 * Time: 01:52 م
 */

namespace App\Services\Auth;

use App\Models\User\User;
use App\Repositories\AppRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminApiService
{
    private $userRepo;

    public function __construct()
    {
        $this->userRepo = new AppRepository(new User());
    }

    public function login(Request $request)
    {
        $this->userRepo->setConditions([['type', 1]]);
        $user = $this->userRepo->findByColumn('email', $request->email);
        if (!$user) {
            return false;
        }
        $check = Hash::check($request->password, $user->password);
        if (!$check) {
            return false;
        }
        $user['token'] = $user->createToken('user token')->accessToken;
        return $user;

    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->authAccessToken()->delete();
            return true;
        }
        return false;
    }

}
