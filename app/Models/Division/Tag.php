<?php

namespace App\Models\Division;

use App\Models\Order\CustomTagShippingPrice;
use App\Models\Order\Offer;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'category_id',
    ];

    protected $appends = [
        'name',
    ];


    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'tag_id');
    }



}
