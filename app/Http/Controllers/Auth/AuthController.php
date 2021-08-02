<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Models\User\User;
use App\Services\Auth\AuthApiService;

use App\Services\Auth\AuthMethods;
use App\Traits\HelpersTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use   HelpersTrait, AuthMethods;

    private $authService;

    public function __construct(AuthApiService $authService)
    {
        $this->middleware('auth:api')
            ->only('logout');

//        $this->middleware('check.role:1')
//            ->only('ban');

        $this->authService = $authService;
    }

    public function login(AuthRequest $request)
    {
        $request->merge([
            'phone' => $request->username
        ]);
        $user = $this->authService->login($request, $request->type);
        if ($user == false) {
            return $this->sendError(
                'invalid phone or password'
            );
        }

        return $this->sendResponse($user);
    }

    public function Regsiter(AuthRequest $request)
    {
        $request->merge([
            'phone' => $request->username
        ]);
        $user = $this->authService->reg($request, $request->type);
        if ($user == false) {
            return $this->sendError(
                'invalid phone or password'
            );
        }

        return $this->sendResponse($user);
    }

    public function logout(AuthRequest $request)
    {
        $user = $this->authService->logout($request);
        return $this->sendResponse($user);
    }

    public function changePassword(AuthRequest $request)
    {
        $validator = Validator([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|same:new_password',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->messages());
        }
        $user = $this->authService->changePassword(
            $request->old_password, $request->password, $request->user_id
        );
        return $this->sendResponse($user);
    }

    public function ban(AuthRequest $request)
    {
        $process = $this->authService->ban($request);
        return $this->sendResponse($process);
    }

}
