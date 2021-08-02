<?php

namespace App\Models\Product;

use App\Models\Division\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'slug',
        'stock',
        'price',
        'tag_id',
    ];

    protected $appends = [
        'name',
        'description',
    ];

    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

    public function getDescriptionAttribute()
    {
        return $this['description_' . app()->getLocale()];
    }


    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }



}
