<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderRequest;
use App\Services\Api\Order\OrderApiService;

class OrderApiController extends Controller
{
    private $orderApiService;

    public function __construct(OrderApiService $orderApiService)
    {
        $this->middleware('auth:api');
        $this->middleware('check.role:1')
            ->only('updateStatus');
//        $this->middleware('check.role:2')
//            ->only('updateStatus','grandTotal' , 'checkout' );
        // $this->middleware('auth:api')->only('checkout');
        // $this->middleware('auth:web')
        //     ->only('checkout');

        $this->orderApiService = $orderApiService;
    }

    public function calculate()
    {
        $process = $this->orderApiService->calculate();
        return $this->sendResponse($process);
    }

    //update status
    public function updateStatus(OrderRequest $request)
    {
        $process = $this->orderApiService->updateStatus($request, $request->id);
        return $this->sendResponse($process);
    }

    public function grandTotal(OrderRequest $request)
    {
        $process = $this->orderApiService->grandTotal($request);
        if ($process == false) {
            return $this->sendError($process, 'please, add product to cart');
        } if (!is_array($process) ){
            return $this->sendError( $process,'please use a valid coupon or '.$process);
        }
        return $this->sendResponse($process);
    }

    public function checkout(OrderRequest $request)
    {

        $process = $this->orderApiService->checkout($request);
        if (!$process) {
            return $this->sendError($process);
        }
        return $this->sendResponse($process);
//        $this->orderApiService->storePaymentData($order, $request);
    }

    public function delete(OrderRequest $request)
    {
        $process = $this->orderApiService->deleteOrder($request->order_id);
        if (!$process) {
            return $this->sendError($process);
        }
        return $this->sendResponse($process);
    }


}
