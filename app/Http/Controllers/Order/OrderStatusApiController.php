<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Order;


use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderstatusRequest;
use App\Services\Api\Order\OrderStatusApiService;

class OrderStatusApiController extends Controller
{

    private $orderStatusApiService;

    public function __construct(OrderStatusApiService $orderStatusApiService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->orderStatusApiService = $orderStatusApiService;
    }


    public function read(OrderstatusRequest $request)
    {
        $process = $this->orderStatusApiService->get($request);
        return $this->sendResponse($process);
    }


    public function all(OrderstatusRequest $request)
    {
        $process = $this->orderStatusApiService->index($request);
        return $this->sendResponse($process);
    }

    public function create(OrderstatusRequest $request)
    {
        $process = $this->orderStatusApiService->createStatus($request);
        return $this->sendResponse($process);
    }

    public function edit(OrderstatusRequest $request)
    {
        $process = $this->orderStatusApiService->editStatus($request);
        return $this->sendResponse($process);
    }
    public function delete(OrderstatusRequest $request)
    {
        $process = $this->orderStatusApiService->delete($request->id);
        return $this->sendResponse($process);
    }
}
