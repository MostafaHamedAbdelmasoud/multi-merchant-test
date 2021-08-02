<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'code',
        'currency'
    ];

    protected $appends = [
        'name'
    ];

    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(City::class);
    }

}
