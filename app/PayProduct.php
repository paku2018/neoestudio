<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayProduct extends Model
{
    protected $table = 'pay_products';

    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
