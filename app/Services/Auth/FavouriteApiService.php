<?php

namespace App\Services\Auth;


use App\Models\User\Favourite;
use App\Repositories\AppRepository;
use Illuminate\Support\Facades\Auth;

class FavouriteApiService extends AppRepository
{


    public function __construct(Favourite $favourite)
    {
        parent::__construct($favourite);
    }


    /**
     * @param $request
     * @return mixed
     */
    public function createFavourite($request)
    {
        $user_id = $request->user_id ?? Auth::id();

        return $this->model->create([
            'user_id' => $user_id,
            'product_id' => $request->product_id,
        ]);
    }


    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {

        if (Auth::user()->type != 1) {

            $user_id = $request->user_id ?? Auth::id();

            $this->setConditions([
                ['user_id', $user_id]
            ]);

            $this->setRelations([
                'product'
            ]);

        }else{
            $this->setConditions([
                ['user_id', Auth::id()]
            ]);
            $this->setRelations([
               'product'=>function($product){
                    $product->select('id','slug');
               },
                'user'=>function($user){
                    $user->select('id','name' , 'phone');
                },
            ]);
        }
        if ($request->is_paginate == 1) {
            return $this->paginate();
        }
        return $this->all();
    }


    /**
     * @param $request
     * @return mixed
     */
    public function get($request)
    {
        return $this->find($request->id);
    }


}
