<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/*use Illuminate\Support\Facades\Input;*/

use ZanySoft\Zip\ZipManager;
use ZanySoft\Zip\Zip;


class MaterialController extends Controller
{
    public function index($type,$topicId){
        $materials=\App\Material::where('type',$type)->where('topicId',$topicId)->get();
        return view('materials.index',compact('materials','type','topicId'));
    }
    public function index2($type,$studentType){
        $topics=\App\Topic::where('studentType',$studentType)->get();

        return view('materials.index2',compact('topics','type','studentType'));
    }
    public function create($type,$topicId){
        $type=$type;
        return view('materials.create',compact('type','topicId'));
    }
    public function store(Request $request){

        ini_set('max_input_time', '-1');
        ini_set('max_execution_time', 0);
        ini_set('upload_max_filesize', '120000M');
        ini_set('post_max_size', '24000M');
        ini_set('memory_limit', '120000M');

        $materialFile=$request->file('material');

        if($request->get('type')=="audio"){
            
            if(!empty($materialFile)){
                $newFilename=$materialFile->getClientOriginalName();
                
                $mimeType=$materialFile->getMimeType();
                if($mimeType!="application/zip"){
                    return redirect()->back()->with('message2','archivo zip requerido');   
                }
                $destinationPath='audio';
                $materialFile->move($destinationPath,$newFilename);
                $filePath='audio/' . $newFilename;
                $zip = Zip::open($filePath);
                $listFiles = $zip->listFiles();

                foreach ($listFiles as $key => $value) {
                    $material=new \App\Material;
                   // $material->name=$value;
                    $material->material='audio/'.$value;
                    $material->topicId=$request->get('topicId');
                    $material->type="audio";
                    $material->status="Deshabilitado";
                    $material->save();
                }
            }

        }
        if($request->type=="video"){

            if(!empty($materialFile)){
                $newFilename=$materialFile->getClientOriginalName();
                
                $mimeType=$materialFile->getMimeType();
                if($mimeType!="application/zip"){
                    return redirect()->back()->with('message2','archivo zip requerido');   
                }
                $destinationPath='video';
                $materialFile->move($destinationPath,$newFilename);
                $filePath='video/' . $newFilename;
                $zip = Zip::open($filePath);
                $listFiles = $zip->listFiles();
                foreach ($listFiles as $key => $value) {
                    $material=new \App\Material;
                    //$material->name=$value;
                    $material->material='video/'.$value;
                    $material->topicId=$request->get('topicId');
                    $material->type="video";
                    $material->status="Deshabilitado";
                    $material->save();
                }
            }
        }
        if($request->type=="pdf"){ //20200115

            if(!empty($materialFile)){
                $newFilename=$materialFile->getClientOriginalName();

                $mimeType=$materialFile->getMimeType();
                if($mimeType!="application/zip" && $mimeType!="application/pdf"){
                    return redirect()->back()->with('message2','zip de archivos pdf requerido o archivo pdf requerido');
                }
                $destinationPath='pdf';
                $materialFile->move($destinationPath,$newFilename);
                $filePath='pdf/' . $newFilename;
                //PDF Zip Upload
                if($mimeType=="application/zip"){
                    $zip = Zip::open($filePath);
                    $listFiles = $zip->listFiles();
                    foreach ($listFiles as $key => $value) {
                        $material=new \App\Material;
                        //$material->name=$value;
                        $material->material='pdf/'.$value;
                        $material->topicId=$request->get('topicId');
                        $material->type="pdf";
                        $material->status="Deshabilitado";
                        $material->save();
                    }
                }

                //Single File PDf Upload
                if($mimeType=="application/pdf"){
                    $material=new \App\Material;
                    $material->material='pdf/'.$newFilename;
                    $material->topicId=$request->get('topicId');
                    $material->type="pdf";
                    $material->status="Deshabilitado";
                    $material->save();
                }
            }
        }
        if($request->type=="others"){
            if(!empty($materialFile)){
                $newFilename=$materialFile->getClientOriginalName();
                $mimeType=$materialFile->getMimeType();
                $destinationPath='others';
                $materialFile->move($destinationPath,$newFilename);
                $filePath='others/' . $newFilename;
                $zip = Zip::open($filePath);
                $listFiles = $zip->listFiles();
                foreach ($listFiles as $key => $value) {
                    $material=new \App\Material;
                    //$material->name=$value;
                    $material->material='others/'.$value;
                    $material->topicId=$request->get('topicId');
                    $material->type="others";
                    $material->status="Deshabilitado";
                    $material->save();
                }
            }
        }
        
        
        $message="Material stored successfully";

        return redirect()->back()->with('message',$message);
    }
    public function edit($id){
        $material=\App\Material::find($id);
        return view('materials.edit',compact('material'));
        
    }
    public function update(Request $request, $id){
        $material=\App\Material::find($id);
        
        
        $check=$request->get('check');
        $materialFile=$request->file("material");

        if($check==null){

            if(!empty($materialFile)){
                $newFilename=$materialFile->getClientOriginalName();
                
                //$mimeType=$materialFile->getMimeType();
                if($material->type=="audio"){
                    $destinationPath='audio';
                    $materialFile->move($destinationPath,$newFilename);
                    $picPath='audio/' . $newFilename;
                    $materialUrl=$picPath;
                    $material->material=$materialUrl;
                }
                if($material->type=="video"){
                    $destinationPath='video';
                    $materialFile->move($destinationPath,$newFilename);
                    $picPath='video/' . $newFilename;
                    $materialUrl=$picPath;
                    $material->material=$materialUrl;
                }
                if($material->type=="pdf"){
                    $destinationPath='pdf';
                    $materialFile->move($destinationPath,$newFilename);
                    $picPath='pdf/' . $newFilename;
                    $materialUrl=$picPath;
                    $material->material=$materialUrl;
                }
                //$material->name=$newFilename;
                //$material->type=$mimeType;
            }
        }
        $material->name=$request->get('name');
        $material->save();
        
        $message="Material updated successfully";
        return redirect()->back()->with('message',$message);
    }
    public function delete($id){
    	$material=\App\Material::find($id);
        $material->delete();
        $message="Material deleted successfully";
        return redirect()->back()->with('message',$message);
    }
	
        public function download($id){

        $material=\App\Material::find($id);
        $mat=$material->material;
        //$pp=public_path();
        $re=public_path();

        //$re=str_replace(array("/public","\public"),array("",""),$pp);
        //$file= "public_path()". "/$mat";
        $file= "$re". "/$mat";
       return response()->download($file);
        //return response()->file($mat);
        //return response()->streamDownload(function () {
          //  echo file_get_contents("$mat");
        //}, 'fileI');
       
    }
    public function changeStatus($id){
        $material=\App\Material::find($id);
        $topic=\App\Topic::find($material->topicId);
        if($material->status=="Deshabilitado"){
            $material->status="Habilitado";
            $material->save();
            if($material->type=="Descargas"){
                $exists=\App\User::where('type',$topic->studentType)->where('role','student')->exists();
                if($exists==true){
                    $users=\App\User::where('type',$topic->studentType)->where('role','student')->get();
                    foreach($users as $user){
                        $notiExists=\App\Notification::where('studentId',$user->id)->where('type',$material->type)->where('typeId1',$id)->where('typeId2',$topic->id)->exists();
                        if($notiExists==true){
                            $noti=\App\Notification::where('studentId',$user->id)->where('type',$material->type)->where('typeId1',$id)->where('typeId2',$topic->id)->first();
                            $noti->status="pending";
                            $noti->save();
                        }
                        if($notiExists==false){
                            $noti=new \App\Notification;
                            $noti->studentId=$user->id;
                            $noti->type=$material->type;
                            $noti->status="pending";
                            $noti->typeId1=$id;
                            $noti->typeId2=$topic->id;
                            $noti->save();
                        }

                    }
                }
            }
            return redirect()->back()->with('message','Status changed successfully');       
        }
        if($material->status=="Habilitado"){
            $material->status="Deshabilitado";
            $material->save();
            return redirect()->back()->with('message','Status changed successfully');       
        }
    }

    public function deleteTopic($id){

        $materials=\App\Material::where('topicId',$id)->get();
        foreach ($materials as $key => $value) {
            $value->delete();
            
        }
        return redirect()->back()->with('message','Folder deleted');
    }
}
