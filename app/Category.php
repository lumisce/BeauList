<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use Searchable;
    
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
