<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blist extends Model
{
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
}
