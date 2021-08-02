<?php

namespace App\Models\Order;

use App\Models\Product\Product;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}