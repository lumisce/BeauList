<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Brand extends Model
{
    use Searchable;
    
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

    public function toSearchableArray()
    {
        $array = $this->toArray();
        $array['product_count'] = $this->products->count();
        $array['favBy'] = $this->favoritedBy;
        $array['fav_count'] = $this->favoritedBy->count();
        
        return $array;
    }
}
