<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderRequest;
use App\Models\Order\Order;
use App\Services\Api\Order\UpdateOrderApiService;
use Illuminate\Http\Request;

class UpdateOrderApiController extends Controller
{
    private $orderService;

    public function __construct(UpdateOrderApiService $orderService)
    {
        $this->middleware(['auth:api']);
        $this->middleware(['check.role:1,2,4'])
            ->only(['recalculate', 'update']);
        $this->middleware(['check.role:1,2,3,4'])
            ->only(['updateStatus','updatePayment']);
        $this->orderService = $orderService;
    }
//
//    public function updateStatus(OrderRequest $request)
//    {
//        $process = $this->orderService->updateStatus($request);
//        if (!$process) {
//            return $this->sendError(['sorry, cant update this order']);
//        }
//        return $this->sendResponse($process);
//    }
//
//    public function updatePayment(OrderRequest $request)
//    {
//        $process = $this->orderService->updatePayment($request);
//        if (!$process) {
//            return $this->sendError(['sorry, cant update this order']);
//        }
//        return $this->sendResponse($process);
//    }

    public function recalculate(OrderRequest $request)
    {
        $process = $this->orderService->recalculate($request);
        return $this->sendResponse($process);
    }

    public function update(OrderRequest $request)
    {
        $process = $this->orderService->updateOrder($request);
        if ($process == 'error') {
            $result = "can't delete this item as the order must contain at least one main service!";
            return $this->sendError($result);
        }
        return $this->sendResponse($process);
    }


}
