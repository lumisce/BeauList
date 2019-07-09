<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductUser extends Pivot
{
    protected $fillable = ['score'];
    public $incrementing = true;
}
