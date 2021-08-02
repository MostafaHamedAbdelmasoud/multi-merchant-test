<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\Auth\AdminRequest;
use App\Services\Auth\AdminApiService;

class AdminApiController extends Controller
{
    protected $adminApiService;

    public function __construct(AdminApiService $adminApiService)
    {
        $this->adminApiService = $adminApiService;
        $this->middleware('auth:api')
            ->only('logout');
    }

    public function login(AdminRequest $request)
    {
        $data = $this->adminApiService->login($request);
        if ($data === false) {
            return $this->sendError('invalid email or password');
        }
        return $this->sendResponse($data);
    }

    public function logout()
    {
        $data = $this->adminApiService->logout();
        if ($data === false) {
            return $this->sendError('something wrong');
        }
        return $this->sendResponse('Good Bye');
    }
}
