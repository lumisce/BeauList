<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function blists()
    {
        return $this->hasMany('App\Blist');
    }

    public function savedBlists()
    {
        return $this->belongsToMany('App\Blist', 'blist_user_saved')
            ->withTimestamps();
    }
    
    public function ratedProducts()
    {
        return $this->belongsToMany('App\Product', 'product_user_rated')
            ->as('rating')
            ->withPivot(['score'])
            ->withTimestamps();
    }

    public function favoriteProducts()
    {
        return $this->belongsToMany('App\Product', 'product_user_favorite')
            ->withTimestamps();
    }

    public function favoriteBrands()
    {
        return $this->belongsToMany('App\Brand', 'brand_user_favorite')
            ->withTimestamps();
    }

    public function productsHistory()
    {
        return $this->belongsToMany('App\Product')
            ->using('App\ProductUserHistory');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
