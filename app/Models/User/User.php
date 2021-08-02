<?php

namespace App\Models\User;


use App\Models\Store\Store;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'type', 'phone',
        'email', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'user_type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getUserTypeAttribute()
    {
        $users = ['Admin','Merchant', 'Customer'];
        return $users[($this->type) ? $this->type - 1 : 0];
    }


    /**
     * Get the number of models to return per page.
     *
     * @return int
     */
    public function getPerPage()
    {
        return request('perPage', parent::getPerPage());
    }

    /**
     * indicates if it is admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->type == 1;
    }

    /**
     * indicates if it is customer
     *
     * @return bool
     */
    public function isCustomer()
    {
        return $this->type == 3;
    }

    /**
     * indicates if it is merchant
     *
     * @return bool
     */
    public function isMerchant()
    {
        return $this->type == 2;
    }


    public function authAccessToken()
    {
        return $this->hasMany(OauthAccessToken::class);
    }



    public function stores()
    {
        return $this->hasMany(Store::class,'merchant_id');
    }



}
