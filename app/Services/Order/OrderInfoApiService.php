<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 07/12/20
 * Time: 04:21 م
 */

namespace App\Services\Api\Order;


use App\Models\Order\Order;
use App\Repositories\AppRepository;
use Illuminate\Support\Facades\Auth;

class OrderInfoApiService
{

    private $order;

    public function __construct()
    {
        $this->order = new AppRepository(new Order());
    }

    public function getUserOrders()
    {
        $this->order->setConditions([['user_id', Auth::id()]]);
        $this->order->setRelations([
            'orderItems' => function ($item) {
                $item->with([
                    'variant' => function ($variant) {
                        $variant->with([
                            'product' => function ($product) {
                                $product->with([
                                    'variants' => function ($variantNest1) {
                                        $variantNest1->with('color', 'dimension');
                                    }
                                ]);
                            }
                        ]);
                    }
                ]);
            },
            'address', 'coupon',
            'user',
            'paymentType',
        ]);
        return $this->order->all();
    }

    public function orderDetails($orderId)
    {
        $this->order->setRelations([
            'orderItems' => function ($item) {
                $item->with([
                    'variant' => function ($variant) {
                        $variant->with([
                            'product' => function ($product) {
                                $product->with([
                                    'variants' => function ($variantNest1) {
                                        $variantNest1->with('color', 'dimension');
                                    }
                                ]);
                            }
                        ]);
                    }
                ]);
            },
            'address', 'coupon',
            'user',
            'paymentType',
            'orderStatus',
        ]);
        return $this->order->find($orderId);
    }

    public function allOrders($request)
    {
        $this->filter($request);

        $this->order->setSortBy('id');
        $this->order->setSortOrder('desc');
        $this->order->setRelations([
            'coupon',
            'user',
            'paymentType',
            'address',
            'orderItems',
            'orderStatus'
        ]);
        if ($request->username){
            $username = $request->username;
            return $this->order->paginateQuery()
            ->whereHas('user',function ($q) use ($username){
                $q->where('name','like','%'.$username.'%');
            })->paginate();
        }
        if ($request->phone){
            $phone = $request->phone;
            return $this->order->paginateQuery()
            ->whereHas('user',function ($q) use ($phone){
                $q->where('phone','like','%'.$phone.'%');
            })->paginate();
        }
        return $this->order->paginate();
    }


    public function filter($request)
    {
        $conditions = [];

        if ($request->code) {
            $conditions[] = ['code', 'like', '%' . $request->code . '%'];
        }




        $this->order->setConditions($conditions);
    }

}
