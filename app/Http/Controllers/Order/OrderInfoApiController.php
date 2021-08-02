<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 07/12/20
 * Time: 04:18 م
 */

namespace App\Http\Controllers\Api\Order;


use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderRequest;
use App\Services\Api\Order\OrderInfoApiService;
use Illuminate\Http\Request;
use  PDF;
use Illuminate\Support\Facades\Storage;


class OrderInfoApiController extends Controller
{
    private $orderService;

    public function __construct(OrderInfoApiService $orderService)
    {
        $this->middleware('auth:api')->except('shippingCallback');
        $this->orderService = $orderService;
    }

    public function getUserOrders()
    {
        $process = $this->orderService->getUserOrders();
        return $this->sendResponse($process);
    }

    public function orderDetails(OrderRequest $request)
    {
        $process = $this->orderService->orderDetails($request->order_id);
        return $this->sendResponse($process);
    }

    public function allOrders(Request $request)
    {
        $process = $this->orderService->allOrders($request);
        return $this->sendResponse($process);
    }

    public function search(OrderRequest $request)
    {
        $process = $this->orderService->search($request->key, $request->status);
        return $this->sendResponse($process);
    }

}
