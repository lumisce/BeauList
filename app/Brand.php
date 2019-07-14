<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany('App\User', 'brand_user_favorite')
        ->withTimestamps();
    }
}
