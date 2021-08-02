<?php

namespace App\Services\Api\Order;


use App\Models\Order\Offer;
use App\Models\Order\OrderStatus;
use App\Repositories\AppRepository;


Class OrderStatusApiService extends AppRepository
{

    public function __construct(OrderStatus $orderStatus)
    {
        parent::__construct($orderStatus);
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
    public function createStatus($request)
    {
        return $this->model->create($request->only(
            'name_ar',
            'name_en',
            'type'
        ));
    }
    /**
     * @param $request
     * @return mixed
     */
    public function editStatus($request)
    {
        $model = $this->find($request->id);
        $model = $model->update($request->only(
            'name_ar',
            'name_en',
            'type'

        ));

        return $model;
    }



}
