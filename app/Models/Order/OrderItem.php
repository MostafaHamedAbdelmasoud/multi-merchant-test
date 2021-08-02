<?php

namespace App\Models\Order;

use App\Models\Product\Variant;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'variant_id',
        'offer_id',
        'quantity',
        'item_price',
        'total_item_price',
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function order ()
    {
        return $this->belongsTo(Order::class);
    }

}
