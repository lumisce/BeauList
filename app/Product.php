<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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

      public function quantityprices()
      {
         return $this->hasMany('App\QuantityPrice');
      }

      public function user()
      {
         return $this->belongsToMany('App\User')
            ->using('App\ProductUser')
            ->as('rating')
            ->withPivot(['score'])
            ->withTimestamps();
      }
}
