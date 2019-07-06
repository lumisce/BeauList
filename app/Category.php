<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function scopeParents($query)
    {
    	return $query->whereNull('parent');
    }

    public function scopeChildren($query)
    {
    	return $query->where('parent', '>', 0);
    }

    public function products()
    {
    	return $this->hasMany('App\Product');
    }
}
