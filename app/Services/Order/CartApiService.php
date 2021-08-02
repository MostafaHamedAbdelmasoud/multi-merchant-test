<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 29/11/20
 * Time: 05:36 م
 */

namespace App\Services\Order;

use App\Models\Order\Cart;
use App\Repositories\AppRepository;
use Illuminate\Support\Facades\Auth;

class CartApiService extends AppRepository
{
    public function __construct(Cart $cart)
    {
        parent::__construct($cart);
    }

    public function index($request)
    {
        $this->setConditions([['user_id', Auth::id()]]);

        $this->setRelations([
            'product' => function ($product) {
                $product->select('id', 'name_ar', 'name_en',
                    'price')->with([
                    'tag' => function ($tag) {
                        $tag->select(
                            'id',
                            'name_ar',
                            'name_en',
                        );
                    },
                ]);
            },
        ]);

        return $this->all();
    }

    public function addToCart($request)
    {
        $request->merge([
            'user_id' => Auth::id(),
        ]);

        $this->model->create([
            'product_id' => $request['product_id'],
            'user_id' => $request->user_id,
            'quantity' => $request['quantity'],
        ]);

        return true;
    }

    public function updateCart($request)
    {
        return $this->update($request->cart_id, $request->only(
            'quantity'
        ));
    }

    public function deleteFromCart($request)
    {
        return $this->model->delete($request->cart_id);
    }

}
