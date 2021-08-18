<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Http\Request;

class mughees implements ToCollection
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
        $exam=\App\Exam::find($this->id);
        if(!empty($exam->courseId)){
            $course=\App\Course::find($exam->courseId);
        	
            
            foreach ($collection as $key => $value) {
            	
            	if($value->filter()->isNotEmpty()){
                    if($key!=0){
                    	 $qa=new \App\Questionanswer;
                    	 $qa->question='<p style="font-size: 13pt;"><span style="font-family: Bold;">'.$value[0].'</span></p>';
                         
                    	 $qa->answer1='<p style="font-size: 13pt;"><span style="font-family: Regular;">'.$value[1].'</span></p>';
                    	 $qa->answer2='<p style="font-size: 13pt;"><span style="font-family: Regular;">'.$value[2].'</span></p>';
                         if($course->name=="Ortografía"){
                        	 $qa->correct=$value[3];
                        	 $qa->description='<p style="font-size: 13pt;"><span style="font-family: Regular;">'.$value[4].'</span></p>';
                         }
                         if($course->name!="Ortografía"){
                             $qa->answer3='<p style="font-size: 13pt;"><span style="font-family: Regular;">'.$value[3].'</span></p>';
                             $qa->answer4='<p style="font-size: 13pt;"><span style="font-family: Regular;">'.$value[4].'</span></p>';
                        	 $qa->correct=$value[5];
                        	 $qa->description='<p style="font-size: 13pt;"><span style="font-family: Regular;">'.$value[6].'</span></p>';
                         }
                    	 $qa->examId=$this->id;
                    	 $qa->save();
                    }
            	}    	

            }
        }
        else{
            foreach ($collection as $key => $value) {
                
                if($value->filter()->isNotEmpty()){
                    if($key!=0){
                         $qa=new \App\Questionanswer;
                         $qa->question='<p style="font-size: 13pt;"><span style="font-family: Bold;">'.$value[0].'</span></p>';
                         
                         $qa->answer1='<p style="font-size: 13pt;"><span style="font-family: Regular;">'.$value[1].'</span></p>';
                         $qa->answer2='<p style="font-size: 13pt;"><span style="font-family: Regular;">'.$value[2].'</span></p>';
                         
                         
                             $qa->answer3='<p style="font-size: 13pt;"><span style="font-family: Regular;">'.$value[3].'</span></p>';
                             $qa->answer4='<p style="font-size: 13pt;"><span style="font-family: Regular;">'.$value[4].'</span></p>';
                             $qa->correct=$value[5];
                             $qa->description='<p style="font-size: 13pt;"><span style="font-family: Regular;">'.$value[6].'</span></p>';
                         
                         $qa->examId=$this->id;
                         $qa->save();
                    }
                }       

            }
        }
    }
}
