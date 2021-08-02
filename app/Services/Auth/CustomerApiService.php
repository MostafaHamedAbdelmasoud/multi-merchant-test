<?php

namespace App\Services\Auth;

use App\Models\User\Address;
use App\Models\User\User;
use App\Repositories\AppRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerApiService extends AppRepository
{

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    private function getUserId($userId)
    {
        $user = Auth::user();

        return ($user->type == 1) ? $userId : $user->id;
    }

    public function updateCustomer(Request $request)
    {
        if (Auth::user()->type == 1) {
            $user = $this->find($request->id);
        } else {
            $user = Auth::user();
        }

        $this->setConditions([['type', $request->type]]);

        $request->merge([
            'verified_code' =>
                ($request->phone && $request->phone != Auth::user()->phone) ? 0 : null,
            'email_verified_at' => ($request->phone && $request->phone != Auth::user()->phone) ?
                null : Auth::user()->email_verified_at
        ]);

        if ($user->email != $request->email) {
            // todo: send verification email
        }

        $user->update($request->only(
            'phone',
            'name',
            'verified_code',
            'email',
            'email_verified_at',
        ));

        return true;
    }


    public function get($id)
    {

        $userId = $this->getUserId($id);


        $this->setColumns([
            'id',
            'name',
            'phone',
            'email',
            'is_ban',
            'type',
            'email_verified_at',
        ]);

        $user = $this->find($userId);

        return $user;
    }

    public function index(Request $request)
    {

        $this->setConditions([['type', 2]]);
        $this->setOrConditions([['type', 3]]);

        if ($request->is_paginate != 1) {
            return $this->all();
        }
        return $this->paginate();
    }
}
