<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductUserHistory extends Pivot
{
    public $incrementing = true;

    public function product()
    {
     	return $this->belongsTo('App\Product');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function quantityPrice()
    {
    	return $this->belongsTo('App\QuantityPrice');
    }

    public function declutteredReason()
    {
    	return $this->belongsTo('App\ProductUserHistoryDeclutteredReason', 
    		'decluttered_reason_id');
    }

    public function received()
    {
    	return $this->belongsTo('App\ProductUserHistoryReceived', 'received_id');
    }

    public function status()
    {
    	return $this->belongsTo('App\ProductUserHistoryStatus', 'status_id');
    }
}
