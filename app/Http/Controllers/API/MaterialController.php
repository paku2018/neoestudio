<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
class MaterialController extends Controller
{
    public function getFiles(Request $request){
    	$type=$request->json('type');
    	$courseName=$request->json('course');
    	$course=\App\Course::where('name',$courseName)->first();
    	$materials=\App\Material::where('courseId',$course->id)->where('type',$type)->get();
    	$message="success";
    	$status=200;
    	return response()->json(['data'=>$materials,'message'=>$message,'status'=>$status]);
    }
    public function getTopics(Request $request){
        $topics=\App\Topic::where('studentType',$request->json('studentType'))->get();
        $studentId=$request->json('studentId');
        $type=$request->json('type');
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        foreach ($topics as $key => $topic) {
            $isActive=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type',$type)->where('typeId2',$topic->id)->exists();
            if($isActive==true){
                $topic->setAttribute('isActive',$isActive);
                $topicCount=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type',$type)->where('typeId2',$topic->id)->get()->count();
                $topic->setAttribute('count',$topicCount);
            }
            if($isActive==false){
                $topic->setAttribute('isActive',$isActive);
                $topic->setAttribute('count',0);
            }
        }
        return response()->json(['status'=>'Successfull','data'=>$topics]);
    }
    public function getAudioFiles(Request $request){
        $id=$request->json('id');
        $studentId=$request->json('studentId');
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $topic=\App\Topic::find($id);
        $array = new Collection();
        $exists=\App\Material::where('topicId',$id)->where('type','audio')->where('status','Habilitado')->exists();
                
                if($exists==true){
                    $audios=\App\Material::where('topicId',$id)->where('type','audio')->where('status','Habilitado')->get();
                    
                    foreach ($audios as $key => $audio) {
                        if(!empty($audio)){
                            $obj=array();
                            $obj['id']=$audio->id;
                            $obj['url']='https://neoestudio.net/'.$audio->material;
                            if(empty($audio->name)){
                                $obj['title']=$whatIWant = str_replace("_"," ",substr($audio->material, strpos($audio->material, "/") + 1));
                            }
                            if(!empty($audio->name)){
                                $obj['title']=$audio->name;
                            }
                            $obj['artist']= $topic->name;
                            $obj['artwork']='https://neoestudio.net/neostudio/Logo.png';
                            //$obj['duration']=100;
                            $isActive=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','audio')->where('typeId1',$audio->id)->where('typeId2',$topic->id)->exists();
                            $obj['isActive']=$isActive;
                            $array->push($obj);
                            //$array[$key]='neoestudio.net/'.$audio->material;
                        }
                    }
                    
                }
                //for ios
                $array2 = new Collection();
        $exists2=\App\Material::where('topicId',$id)->where('type','audio')->where('status','Habilitado')->exists();
                
                if($exists2==true){
                    $audios2=\App\Material::where('topicId',$id)->where('type','audio')->where('status','Habilitado')->get();
                    
                    foreach ($audios2 as $key => $audio2) {
                        if(!empty($audio2)){
                            $obj2=array();
                            $obj2['id']=$audio2->id;
                            $obj2['url']='http://neoestudio.net/'.$audio2->material;
                            if(empty($audio2->name)){
                                $obj2['title']=$whatIWant = str_replace("_"," ",substr($audio2->material, strpos($audio2->material, "/") + 1));
                            }
                            if(!empty($audio2->name)){
                                $obj2['title']=$audio2->name;
                            }
                            //$obj2['title']=$whatIWant = str_replace("_"," ",substr($audio2->material, strpos($audio2->material, "/") + 1));
                            $obj2['artist']= $topic->name;
                            $obj2['artwork']='http://neoestudio.net/neostudio/Logo.png';
                            //$obj['duration']=100;
                            $isActive=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','audio')->where('typeId1',$audio2->id)->where('typeId2',$topic->id)->exists();
                            $obj2['isActive']=$isActive;
                            $array2->push($obj2);
                            //$array[$key]='neoestudio.net/'.$audio->material;
                        }
                    }
                    
                }
                //end ios
                if(!empty($array)){
                    $audioExists=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','audio')->where('typeId2',$topic->id)->exists();
                    if($audioExists==true){
                        $audio11=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','audio')->where('typeId2',$topic->id)->get();
                        foreach ($audio11 as $key => $value11) {
                            $value11->delete();
                        }
                        
                    }
           return response()->json(['status'=>'Successfull','data'=>$array,'ios'=>$array2]);
        }
        if(empty($array)){
            $array=array();
            $array2=array();
            $audioExists=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','audio')->where('typeId2',$topic->id)->exists();
                    if($audioExists==true){
                        $audio12=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','audio')->where('typeId2',$topic->id)->get();
                        foreach ($audio12 as $key => $value) {
                            $value->delete();
                            //$value->status="seen";
                            //$value->save();
                        }
                    }
            return response()->json(['status'=>'Unsuccessfull','data'=>$array,'ios'=>$array2]);
        }
    }
    public function getVideoFiles(Request $request){
        $id=$request->json('id');
        $studentId=$request->json('studentId');
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $exists=\App\Material::where('topicId',$id)->where('type','video')->where('status','Habilitado')->exists();
                $array2=new Collection();
                $ios=new Collection();
                if($exists==true){
                    $videos=\App\Material::where('topicId',$id)->where('type','video')->where('status','Habilitado')->get();
                    
                    foreach ($videos as $key => $video) {
                        if(!empty($video)){
                            $arrayM=array();
                            if(empty($video->name)){
                                $arrayM['title']=$whatIWant = str_replace("_"," ",substr($video->material, strpos($video->material, "/") + 1));
                            }
                            if(!empty($video->name)){
                                $arrayM['title']=$video->name;
                            }
                            $arrayM['url']='https://neoestudio.net/'.$video->material;
                            $isActive=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','video')->where('typeId1',$video->id)->where('typeId2',$id)->exists();
                            $arrayM['isActive']=$isActive;
                            
                            $array2->push($arrayM);


                        }
                    }
                    foreach ($videos as $key => $video) {
                        if(!empty($video)){
                            $arrayMIo=array();
                            if(empty($video->name)){
                                $arrayMIo['title']=$whatIWant = str_replace("_"," ",substr($video->material, strpos($video->material, "/") + 1));
                            }
                            if(!empty($video->name)){
                                $arrayMIo['title']=$video->name;
                            }
                            $arrayMIo['url']='http://neoestudio.net/'.$video->material;
                            $isActiveIo=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','video')->where('typeId1',$video->id)->where('typeId2',$id)->exists();
                            $arrayMIo['isActive']=$isActiveIo;
                            
                            $ios->push($arrayMIo);


                        }
                    }
                    
                }
                if(!empty($array2)){
                    $videoExists=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','video')->where('typeId2',$id)->exists();
                    if($videoExists==true){
                        $video11=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','video')->where('typeId2',$id)->get();
                        foreach ($video11 as $key => $value) {
                            $value->delete();
                            //$value->status="seen";
                            //$value->save();
                        }
                        
                    }
           return response()->json(['status'=>'Successfull','data'=>$array2,'ios'=>$ios]);
        }
        if(empty($array2)){
            $array2=new Collection();
            $ios=new Collection();
            $videoExists=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','video')->where('typeId2',$id)->exists();
                    if($videoExists==true){
                        $video12=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','video')->where('typeId2',$id)->get();
                        foreach ($video12 as $key => $value) {
                            $value->delete();
                            //$value->status="seen";
                            //$value->save();
                        }
                    }
            return response()->json(['status'=>'Successfull','data'=>$array2,'ios'=>$ios]);
        }
    }
    public function getAudios(){

    	$topics=\App\Topic::where('status','Habilitado')->where('studentType','Prueba')->get();
    	foreach ($topics as $k => $topic) {
    		if(!empty($topic)){
    			$exists=\App\Material::where('topicId',$topic->id)->where('type','audio')->where('status','Habilitado')->exists();
    			
    			if($exists==true){
    				$audios=\App\Material::where('topicId',$topic->id)->where('type','audio')->where('status','Habilitado')->get();
                    
    				foreach ($audios as $key => $audio) {
    					if(!empty($audio)){

    						$array[$topic->name][$key]='https://neoestudio.net/'.$audio->material;
    					}
    				}
                    
    			}
            
    		}
    		
    	}
        
        if(!empty($array)){
    	   return response()->json(['status'=>'Successfull','data'=>$array]);
        }
        if(empty($array)){
            $array=array();
            return response()->json(['status'=>'Unsuccessfull','data'=>$array]);
        }
    }
    public function getVideos(){
    	$topics=\App\Topic::where('status','Habilitado')->where('studentType','Prueba')->get();
    	foreach ($topics as $key => $topic) {
    		if(!empty($topic)){
    			$exists=\App\Material::where('topicId',$topic->id)->where('type','video')->where('status','Habilitado')->exists();

    			if($exists==true){
    				$videos=\App\Material::where('topicId',$topic->id)->where('type','video')->where('status','Habilitado')->get();
    				foreach ($videos as $key => $video) {
    					$array[$topic->name][$key]='https://neoestudio.net/'.$video->material;
    				}
    			}
    		}
    		
    	}
    	if(!empty($array)){
           return response()->json(['status'=>'Successfull','data'=>$array]);
        }
        if(empty($array)){
            $array=array();
            return response()->json(['status'=>'Unsuccessfull','data'=>$array]);
        }
    }
    public function uploadSpinner(Request $request){
        $file=Input::file('file');
        if(!empty($file)){
                
            $newFilename=$file->getClientOriginalName();
            $destinationPath='spinner';
            $file->move($destinationPath,$newFilename);
        }
        return response()->json('success');
    }
    
    public function getPdfFiles(Request $request)
    {
        $id = $request->json('id');
        $studentId = $request->json('studentId');
        $ue = \App\User::where('id', $studentId)->exists();
        if ($ue == false) {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $u = \App\User::find($studentId);
        if ($u->field1x == "Bloquear") {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $topic = \App\Topic::find($id);
        $array = new Collection();
        $exists = \App\Material::where('topicId', $id)->where('type', 'pdf')->where('status', 'Habilitado')->exists();

        if ($exists == true) {
            $pdfs = \App\Material::where('topicId', $id)->where('type', 'pdf')->where('status', 'Habilitado')->get();

            foreach ($pdfs as $key => $pdf) {
                if (!empty($pdf)) {
                    $obj = array();
                    $obj['id'] = $pdf->id;
                    $obj['url'] = 'https://neoestudio.net/' . $pdf->material;
                    if (empty($pdf->name)) {
                        $obj['title'] = $whatIWant = str_replace("_", " ", substr($pdf->material, strpos($pdf->material, "/") + 1));
                    }
                    if (!empty($pdf->name)) {
                        $obj['title'] = $pdf->name;
                    }
                    $obj['artist'] = $topic->name;
                    $obj['artwork'] = 'https://neoestudio.net/neostudio/Logo.png';
                    //$obj['duration']=100;
                    $isActive = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'pdf')->where('typeId1', $pdf->id)->where('typeId2', $topic->id)->exists();
                    $obj['isActive'] = $isActive;
                    $array->push($obj);
                    //$array[$key]='neoestudio.net/'.$audio->material;
                }
            }

        }
        //for ios
        $array2 = new Collection();
        $exists2 = \App\Material::where('topicId', $id)->where('type', 'pdf')->where('status', 'Habilitado')->exists();

        if ($exists2 == true) {
            $pdfs2 = \App\Material::where('topicId', $id)->where('type', 'pdf')->where('status', 'Habilitado')->get();

            foreach ($pdfs2 as $key => $pdf2) {
                if (!empty($pdf2)) {
                    $obj2 = array();
                    $obj2['id'] = $pdf2->id;
                    $obj2['url'] = 'http://neoestudio.net/' . $pdf2->material;
                    if (empty($pdf2->name)) {
                        $obj2['title'] = $whatIWant = str_replace("_", " ", substr($pdf2->material, strpos($pdf2->material, "/") + 1));
                    }
                    if (!empty($pdf2->name)) {
                        $obj2['title'] = $pdf2->name;
                    }
                    //$obj2['title']=$whatIWant = str_replace("_"," ",substr($pdf2->material, strpos($pdf2->material, "/") + 1));
                    $obj2['artist'] = $topic->name;
                    $obj2['artwork'] = 'http://neoestudio.net/neostudio/Logo.png';
                    //$obj['duration']=100;
                    $isActive = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'pdf')->where('typeId1', $pdf2->id)->where('typeId2', $topic->id)->exists();
                    $obj2['isActive'] = $isActive;
                    $array2->push($obj2);
                    //$array[$key]='neoestudio.net/'.$audio->material;
                }
            }

        }
        //end ios
        if (!empty($array)) {
            $pdfExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'pdf')->where('typeId2', $topic->id)->exists();
            if ($pdfExists == true) {
                $pdf11 = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'pdf')->where('typeId2', $topic->id)->get();
                foreach ($pdf11 as $key => $value11) {
                    $value11->delete();
                }

            }
            return response()->json(['status' => 'Successfull', 'data' => $array, 'ios' => $array2]);
        }
        if (empty($array)) {
            $array = array();
            $array2 = array();
            $pdfExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'pdf')->where('typeId2', $topic->id)->exists();
            if ($pdfExists == true) {
                $pdf12 = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'pdf')->where('typeId2', $topic->id)->get();
                foreach ($pdf12 as $key => $value) {
                    $value->delete();
                    //$value->status="seen";
                    //$value->save();
                }
            }
            return response()->json(['status' => 'Unsuccessfull', 'data' => $array, 'ios' => $array2]);
        }
    }

    public function getPdfs()
    {

        $topics = \App\Topic::where('status', 'Habilitado')->where('studentType', 'Prueba')->get();
        foreach ($topics as $k => $topic) {
            if (!empty($topic)) {
                $exists = \App\Material::where('topicId', $topic->id)->where('type', 'pdf')->where('status', 'Habilitado')->exists();

                if ($exists == true) {
                    $pdfs = \App\Material::where('topicId', $topic->id)->where('type', 'pdf')->where('status', 'Habilitado')->get();

                    foreach ($pdfs as $key => $pdf) {
                        if (!empty($pdf)) {

                            $array[$topic->name][$key] = 'https://neoestudio.net/' . $pdf->material;
                        }
                    }

                }

            }

        }

        if (!empty($array)) {
            return response()->json(['status' => 'Successfull', 'data' => $array]);
        }
        if (empty($array)) {
            $array = array();
            return response()->json(['status' => 'Unsuccessfull', 'data' => $array]);
        }
    }
}
