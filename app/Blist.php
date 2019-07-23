<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Blist extends Model
{
    use Searchable;

    protected $fillable = ['name', 'description'];

    public function products()
    {
    	return $this->belongsToMany('App\Product')
        ->withPivot(['note'])
        ->withTimestamps();
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function savedBy()
    {
        return $this->belongsToMany('App\User', 'blist_user_saved')
            ->withTimestamps();
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();
        $array['user_name'] = $this->user->name;
        $products = $this->products->toArray();
        $array['products'] = $products;
        $array['savedBy'] = $this->savedBy;
        $array['saved_count'] = $this->savedBy->count();
        
        return $array;
    }
}
