<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackagePriceText extends Model
{
    protected $table = 'package_price_texts';
    protected $fillable = [
        'package_id', 'price_type', 'text_annual', 'text_fractional', 'text_monthly'
    ];
}
