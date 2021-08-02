<?php

namespace App\Services\Store;

use App\Models\Store\Store;

use App\Repositories\AppRepository;
use Illuminate\Support\Facades\Auth;


Class StoreApiService extends AppRepository
{

    public function __construct(Store $store)
    {
         parent::__construct($store);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {
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



    /**
     * @param $request
     * @return mixed
     */
    public function createStore($request)
    {
        $request['merchant_id']=Auth::id();
        $request['keywords'] = implode(',',$request->keywords);

        $model = $this->model->create($request->only([
            'name_ar',
            'name_en',
            'description_ar',
            'description_en',
            'meta_description_ar',
            'meta_description_en',
            'merchant_id',
            'keywords',
        ]));
        return $model;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function editStore($request)
    {
        $model = $this->find($request->id);
        $result = $model->update($request->only([
            'name_ar',
            'name_en',
            'image'

        ]));
        return $result;
    }




}
