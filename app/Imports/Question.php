<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class Question implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $value) {
        	echo $key;
        	if($value){
        	// $qa=new \App\QuestionAnswer;
        	// $qa->question=$value[0];
        	// $qa->answer1=$value[1];
        	// $qa->answer2=$value[2];
        	// $qa->answer3=$value[3];
        	// $qa->answer4=$value[4];
        	// $qa->correct=$value[5];
        	// $qa->description=$value[6];
        	// $qa->examId="1";
        	// $qa->save();
        	}
        	

        }
        
    }
}
