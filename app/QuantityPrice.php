<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuantityPrice extends Model
{
    protected $fillable = ['quantity', 'unit', 'price', 'currency', 'product'];
}
