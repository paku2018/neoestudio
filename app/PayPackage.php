<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayPackage extends Model
{
    protected $table = 'pay_packages';

    public function package()
    {
        return $this->hasOne('App\ServicePackage', 'id', 'package_id');
    }
}
