<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageText extends Model
{
    //

    static public function getTexts(){
        $data = array();
        $texts = PackageText::all();
        if($texts){
            foreach ($texts AS $text){
                $data[$text->type] = $text->title;
            }
        }
        return $data;
    }
}
