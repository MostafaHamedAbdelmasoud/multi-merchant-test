<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'country_id'
    ];

    protected $appends = [
        'name'
    ];

    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function districts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(District::class, 'city_id');
    }
}
