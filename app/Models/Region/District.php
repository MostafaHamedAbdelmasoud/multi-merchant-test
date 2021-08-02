<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'city_id'
    ];

    protected $appends = [
        'name'
    ];

    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

}
