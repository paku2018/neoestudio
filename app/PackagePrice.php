<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackagePrice extends Model
{
    protected $table = 'package_prices';
    protected $fillable = [
        'package_id', 'price_type', 'price_annual', 'price_fractional', 'price_monthly'
    ];
}
