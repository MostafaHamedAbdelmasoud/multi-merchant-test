<?php

namespace App\Models\Order;

use App\Models\Payment\PaymentType;
use App\Models\User\Address;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'payment_type_id',
        'order_status_id',
        'coupon_id',
        'coupon_price',
        'address_id',
        'subtotal',
        'shipping_price',
        'grand_total',
        'notes',
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function orderStatus ()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function paymentType ()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function orderItems ()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}
