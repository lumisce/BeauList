<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\Helpers\Common;

class Product extends Model
{
    use Searchable;
    
    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function blists()
    {
        return $this->belongsToMany('App\Blist');
    }

    public function quantityPrices()
    {
        return $this->hasMany('App\QuantityPrice');
    }

    public function ratedBy()
    {
        return $this->belongsToMany('App\User', 'product_user_rated')
        ->using('App\ProductUser')
        ->as('rating')
        ->withPivot(['score'])
        ->withTimestamps();
    }

    public function favoritedBy()
    {
        return $this->belongsToMany('App\User', 'product_user_favorite')
        ->withTimestamps();
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();
        $array['brand'] = $this->brand->toArray();
        $cat = $this->category;
        $array['category0_name'] = Category::find($cat->parent)->name;
        $array['category1_name'] = $array['category0_name'] . " > " .$cat->name;
        $rating = Common::avgrating($this);
        $array['rank_score'] = Common::rankscore($this);
        $array['rating_score'] = $rating[0] ? $rating[0] : 0;
        $array['rating_count'] = $rating[1];
        $qps = $this->quantityprices->toArray();
        $array['quantityprices'] = $qps;
        $array['blists'] = $this->blists->toArray();
        $array['favBy'] = $this->favoritedBy;
        $array['fav_count'] = $this->favoritedBy->count();
        
        return $array;
    }
}
