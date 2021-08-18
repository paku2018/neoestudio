<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackagePriceDescription extends Model
{
    protected $table = 'package_price_descriptions';
    protected $fillable = [
        'package_price_id', 'annual', 'fractional', 'monthly'
    ];

    static public function getDescriptions(){
        $data = array();
        $rows = self::all();
        if(isset($rows) && empty($rows) === false){
            foreach ($rows AS $row){
                $data[$row->package_price_id]['annual'] = $row->annual;
                $data[$row->package_price_id]['fractional'] = $row->fractional;
                $data[$row->package_price_id]['monthly'] = $row->monthly;
            }
        }
        return $data;
    }
}
