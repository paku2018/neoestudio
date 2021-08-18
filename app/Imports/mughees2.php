<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Http\Request;

class mughees2 implements ToCollection
{
	private $id;
    
	public function __construct($id){
		$this->id=$id;
	}
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
    	$sId=$this->id;

        $survey=\App\Survey::find($sId);

        
        foreach ($collection as $key => $value) {
        	
        	if($value->filter()->isNotEmpty()){
                if($key>1){
                	 $qa=new \App\Question;
                	 $qa->question=$value[0];
                	 $qa->surveyId=$this->id;
                     $qa->star="si";
                     $qa->description="si";
                	 $qa->save();
                }
                if($key==1){
                    $survey->title=$value[0];
                    $survey->save();
                }

        	}
        	

        }
    }
}
