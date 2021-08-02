<?php

namespace App\Models\Store;

use App\Models\Division\Category;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_en',
        'name_ar',
        'merchant_id',
        'is_verified',
        'rate',
        'description_ar',
        'description_en',
        'meta_description_ar',
        'meta_description_en',
        'keywords',
    ];

    protected $appends = [
        'name',
        'description',
        'meta_description'
    ];

    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

    public function getMetaDescriptionAttribute()
    {
        return $this['meta_description_' . app()->getLocale()];
    }

    public function getDescriptionAttribute()
    {
        return $this['description_' . app()->getLocale()];
    }

    public function merchant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }


    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


}
