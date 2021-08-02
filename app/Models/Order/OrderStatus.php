<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'type',
    ];


    protected $appends = [
        'name'
    ];


    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }


}
