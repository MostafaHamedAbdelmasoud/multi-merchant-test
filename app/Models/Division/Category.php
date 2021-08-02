<?php

namespace App\Models\Division;

use App\Models\Store\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    use HasFactory;
    protected $fillable = [
        'name_ar',
        'store_id',
        'name_en',
    ];

    protected $appends = [
        'name'
    ];



    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }


    public function tags()
    {
        return $this->hasMany(Tag::class);
    }


    public function store()
    {
        return $this->belongsTo(Store::class);
    }


}
