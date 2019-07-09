<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blist extends Model
{
    protected $fillable = ['name'];

    public function products()
    {
    	return $this->belongsToMany('App\Product')->withTimestamps();
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
