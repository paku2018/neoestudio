<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
class DownloadUploadController extends Controller
{


    public function getUploadFolders(Request $request){
    	$existF=\App\Folder::where('type','Subidas')->where('studentType',$request->json('studentType'))->exists();
        $studentId=$request->json('studentId');
        $user=\App\User::find($studentId);
    	if($existF==false){
            $array=array();
    		return response()->json(['status'=>'Unsuccessfull','data'=>$array]);
    	}
    	if($existF==true){
    		$folders=\App\Folder::where('type','Subidas')->where('studentType',$request->json('studentType'))->get();
    		foreach ($folders as $key => $value) {
                $isActive=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type',"Subidas")->where('typeId2',$value->id)->exists();

                    $value->setAttribute('isActive',$isActive);


            }

    		if(!empty($folders)){
                $subidasExists=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type','Subidas')->exists();
                if($subidasExists==true){
                    $subidas=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type','Subidas')->get();
                    foreach ($subidas as $key => $value) {
                        $value->delete();
                        //$value->status="seen";
                        //$value->save();
                    }
                }
	    		return response()->json(['status'=>'Successfull','data'=>$folders]);
	    	}
	    	if(empty($array)){
	    		$array=array();
                $subidasExists=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type','Subidas')->exists();
                if($subidasExists==true){
                    $subidas=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type','Subidas')->get();
                    foreach ($subidas as $key => $value) {
                        $value->delete();
                        //$value->status="seen";
                        //$value->save();
                    }
                }
            return response()->json(['status'=>'Unsuccessfull','data'=>$array]);
	    	}

    	}
    }
    public function getDownloadFolders(Request $request){
        $studentType=$request->json('studentType');
        $studentId=$request->json('studentId');
        $user=\App\User::find($studentId);
    	$existF=\App\Folder::where('type','Descargas')->where('studentType',$studentType)->exists();
        $existsF2=\App\DownloadUpload::where('folderId','empty')->where('option','Descargas')->
                    where('status','Habilitado')->where('studentType',$studentType)->exists();


    	if($existF==true&&$existsF2==true){
    		$folders=\App\Folder::where('type','Descargas')->where('studentType',$studentType)->get();
            foreach ($folders as $key => $value) {
                $isActive=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type',"Descargas")->where('typeId2',$value->id)->exists();
                if($isActive==true){
                    $value->setAttribute('isActive',$isActive);
                    $count=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type',"Descargas")->where('typeId2',$value->id)->get()->count();
                    $value->setAttribute('count',$count);
                }
                if($isActive==false){
                    $value->setAttribute('isActive',$isActive);
                    $value->setAttribute('count',0);
                }
            }
    		$filesArray=\App\DownloadUpload::where('folderId','empty')->where('option','Descargas')->
                    where('status','Habilitado')->where('studentType',$studentType)->get();
            foreach ($filesArray as $key => $value) {
                $isActive=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type',"Descargas")->where('typeId1',$value->id)->where('typeId2',$value->folderId)->exists();

                    $value->setAttribute('isActive',$isActive);


            }

    		if(empty($folders)){
	    		$folders=array();
	    	}
            if(empty($filesArray)){
                $filesArray=array();
            }
            $descargasExists=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type','Descargas')->where('typeId2','empty')->exists();
                if($descargasExists==true){
                    $descargas=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type','Descargas')->where('typeId2','empty')->get();
                    foreach ($descargas as $key => $value) {
                        $value->delete();
                        //$value->status="seen";
                        //$value->save();
                    }

                }
            return response()->json(['status'=>'Successfull','folders'=>$folders,'files'=>$filesArray]);

    	}
        if($existF==true&&$existsF2==false){
            $folders=\App\Folder::where('type','Descargas')->where('studentType',$studentType)->get();
            foreach ($folders as $key => $value) {
                $isActive=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type',"Descargas")->where('typeId2',$value->id)->exists();
                if($isActive==true){
                    $value->setAttribute('isActive',$isActive);
                    $count=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type',"Descargas")->where('typeId2',$value->id)->get()->count();
                    $value->setAttribute('count',$count);
                }
                if($isActive==false){
                    $value->setAttribute('isActive',$isActive);
                    $value->setAttribute('count',0);
                }
            }

            if(empty($folders)){
                $folders=array();
            }
            if(empty($filesArray)){
                $filesArray=array();
            }
            return response()->json(['status'=>'Successfull','folders'=>$folders,'files'=>$filesArray]);

        }
        if($existF==false&&$existsF2==true){

            $filesArray=\App\DownloadUpload::where('folderId','empty')->where('option','Descargas')->
                    where('status','Habilitado')->where('studentType',$studentType)->get();
            foreach ($filesArray as $key => $value) {
                $isActive=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type',"Descargas")->where('typeId1',$value->id)->where('typeId2',$value->folderId)->exists();

                    $value->setAttribute('isActive',$isActive);

            }

            if(empty($folders)){
                $folders=array();
            }
            if(empty($filesArray)){
                $filesArray=array();
            }
            $descargasExists=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type','Descargas')->where('typeId2','empty')->exists();
                if($descargasExists==true){
                    $descargas=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type','Descargas')->where('typeId2','empty')->get();
                    foreach ($descargas as $key => $value) {
                        $value->delete();
                        //$value->status="seen";
                        //$value->save();
                    }

                }
            return response()->json(['status'=>'Successfull','folders'=>$folders,'files'=>$filesArray]);

        }
        if($existF==false&&$existsF2==false){

            if(empty($folders)){
                $folders=array();
            }
            if(empty($filesArray)){
                $filesArray=array();
            }
            return response()->json(['status'=>'Successfull','folders'=>$folders,'files'=>$filesArray]);

        }
    }
    public function getDownloadFiles(Request $request){
    	$folderId=$request->get('folderId');
        $studentId=$request->json('studentId');

        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['message'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['message'=>'Unsuccessfull','message'=>'User not found']);
        }
    	$exists=\App\DownloadUpload::where('folderId',$folderId)->where('option','Descargas')
    	->exists();

    	if($exists==false){
            $array=array();
    		return response()->json(['message'=>'success','files'=>$array]);
    	}
    	if($exists==true){
    		$array=\App\DownloadUpload::where('folderId',$folderId)->where('option','Descargas')->where('status','Habilitado')
    		->get();

            foreach ($array as $key => $value) {

                $isActive=\App\Notification::where('status','pending')->where('studentId',$u->id)->where('type',"Descargas")->where('typeId1',$value->id)->where('typeId2',$value->folderId)->exists();

                    $value->setAttribute('isActive',$isActive);

            }

            if(!empty($array)){
                $descargasExists=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','Descargas')->exists();
                if($descargasExists==true){
                    $descargas=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','Descargas')->get();
                    foreach ($descargas as $key => $value) {
                        $value->delete();
                        //$value->status="seen";
                        //$value->save();
                    }

                }
           		return response()->json(['message'=>'success','files'=>$array]);
        	}
        	if(empty($array)){
            	$array=array();
                $descargasExists=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','Descargas')->exists();
                if($descargasExists==true){
                    $descargas=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','Descargas')->first();
                    foreach ($descargas as $key => $value) {
                        $value->delete();
                        //$value->status="seen";
                        //$value->save();
                    }
                }
            return response()->json(['message'=>'success','files'=>$array]);
        	}
    	}

    }
    public function uploadFile(Request $request){
        $studentId=$request->get('studentId');
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
    	$folderId=$request->get('folderId');
    	$file=Input::file("file");
        $upload=new \App\DownloadUpload;
        $upload->option="Subidas";
        $upload->studentType=$request->get('studentType');
        $upload->studentId=$request->get('studentId');
        $upload->folderId=$request->get('folderId');
        if(!empty($file)){

            $newFilename=$file->getClientOriginalName();
            $destinationPath='uploads';
            $file->move($destinationPath,$newFilename);
            $picPath='uploads/' . $newFilename;
            $upload->adminDownloadName=$picPath;
        }
        $upload->save();
        return response()->json(['status'=>'Successfull']);

    }

    public function getUploadPdfFolders(Request $request){
    	$existF=\App\Folder::where('type','SubidasPdf')->where('studentType',$request->json('studentType'))->exists();
        $studentId=$request->json('studentId');
        $user=\App\User::find($studentId);
    	if($existF==false){
            $array=array();
    		return response()->json(['status'=>'Unsuccessfull','data'=>$array]);
    	}
    	if($existF==true){
    		$folders=\App\Folder::where('type','SubidasPdf')->where('studentType',$request->json('studentType'))->get();
    		foreach ($folders as $key => $value) {
                $isActive=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type',"SubidasPdf")->where('typeId2',$value->id)->exists();

                    $value->setAttribute('isActive',$isActive);


            }

    		if(!empty($folders)){
                $subidasExists=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type','SubidasPdf')->exists();
                if($subidasExists==true){
                    $subidas=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type','SubidasPdf')->get();
                    foreach ($subidas as $key => $value) {
                        $value->delete();
                        //$value->status="seen";
                        //$value->save();
                    }
                }
	    		return response()->json(['status'=>'Successfull','data'=>$folders]);
	    	}
	    	if(empty($array)){
	    		$array=array();
                $subidasExists=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type','SubidasPdf')->exists();
                if($subidasExists==true){
                    $subidas=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type','SubidasPdf')->get();
                    foreach ($subidas as $key => $value) {
                        $value->delete();
                        //$value->status="seen";
                        //$value->save();
                    }
                }
            return response()->json(['status'=>'Unsuccessfull','data'=>$array]);
	    	}

    	}
    }
    public function getDownloadPdfFolders(Request $request){
        $studentType=$request->json('studentType');
        $studentId=$request->json('studentId');
        $user=\App\User::find($studentId);
    	$existF=\App\Folder::where('type','DescargasPdf')->where('studentType',$studentType)->exists();
        $existsF2=\App\DownloadUpload::where('folderId','empty')->where('option','DescargasPdf')->
                    where('status','Habilitado')->where('studentType',$studentType)->exists();


    	if($existF==true&&$existsF2==true){
    		$folders=\App\Folder::where('type','DescargasPdf')->where('studentType',$studentType)->get();
            foreach ($folders as $key => $value) {
                $isActive=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type',"DescargasPdf")->where('typeId2',$value->id)->exists();
                if($isActive==true){
                    $value->setAttribute('isActive',$isActive);
                    $count=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type',"DescargasPdf")->where('typeId2',$value->id)->get()->count();
                    $value->setAttribute('count',$count);
                }
                if($isActive==false){
                    $value->setAttribute('isActive',$isActive);
                    $value->setAttribute('count',0);
                }
            }
    		$filesArray=\App\DownloadUpload::where('folderId','empty')->where('option','DescargasPdf')->
                    where('status','Habilitado')->where('studentType',$studentType)->get();
            foreach ($filesArray as $key => $value) {
                $isActive=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type',"DescargasPdf")->where('typeId1',$value->id)->where('typeId2',$value->folderId)->exists();

                    $value->setAttribute('isActive',$isActive);


            }

    		if(empty($folders)){
	    		$folders=array();
	    	}
            if(empty($filesArray)){
                $filesArray=array();
            }
            $descargasExists=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type','DescargasPdf')->where('typeId2','empty')->exists();
                if($descargasExists==true){
                    $descargas=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type','DescargasPdf')->where('typeId2','empty')->get();
                    foreach ($descargas as $key => $value) {
                        $value->delete();
                        //$value->status="seen";
                        //$value->save();
                    }

                }
            return response()->json(['status'=>'Successfull','folders'=>$folders,'files'=>$filesArray]);

    	}
        if($existF==true&&$existsF2==false){
            $folders=\App\Folder::where('type','DescargasPdf')->where('studentType',$studentType)->get();
            foreach ($folders as $key => $value) {
                $isActive=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type',"DescargasPdf")->where('typeId2',$value->id)->exists();
                if($isActive==true){
                    $value->setAttribute('isActive',$isActive);
                    $count=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type',"DescargasPdf")->where('typeId2',$value->id)->get()->count();
                    $value->setAttribute('count',$count);
                }
                if($isActive==false){
                    $value->setAttribute('isActive',$isActive);
                    $value->setAttribute('count',0);
                }
            }

            if(empty($folders)){
                $folders=array();
            }
            if(empty($filesArray)){
                $filesArray=array();
            }
            return response()->json(['status'=>'Successfull','folders'=>$folders,'files'=>$filesArray]);

        }
        if($existF==false&&$existsF2==true){

            $filesArray=\App\DownloadUpload::where('folderId','empty')->where('option','DescargasPdf')->
                    where('status','Habilitado')->where('studentType',$studentType)->get();
            foreach ($filesArray as $key => $value) {
                $isActive=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type',"DescargasPdf")->where('typeId1',$value->id)->where('typeId2',$value->folderId)->exists();

                    $value->setAttribute('isActive',$isActive);

            }

            if(empty($folders)){
                $folders=array();
            }
            if(empty($filesArray)){
                $filesArray=array();
            }
            $descargasExists=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type','DescargasPdf')->where('typeId2','empty')->exists();
                if($descargasExists==true){
                    $descargas=\App\Notification::where('status','pending')->where('studentId',$user->id)->where('type','DescargasPdf')->where('typeId2','empty')->get();
                    foreach ($descargas as $key => $value) {
                        $value->delete();
                        //$value->status="seen";
                        //$value->save();
                    }

                }
            return response()->json(['status'=>'Successfull','folders'=>$folders,'files'=>$filesArray]);

        }
        if($existF==false&&$existsF2==false){

            if(empty($folders)){
                $folders=array();
            }
            if(empty($filesArray)){
                $filesArray=array();
            }
            return response()->json(['status'=>'Successfull','folders'=>$folders,'files'=>$filesArray]);

        }
    }
    public function getDownloadPdfFiles(Request $request){
    	$folderId=$request->get('folderId');
        $studentId=$request->json('studentId');

        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['message'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['message'=>'Unsuccessfull','message'=>'User not found']);
        }
    	$exists=\App\DownloadUpload::where('folderId',$folderId)->where('option','DescargasPdf')
    	->exists();

    	if($exists==false){
            $array=array();
    		return response()->json(['message'=>'success','files'=>$array]);
    	}
    	if($exists==true){
    		$array=\App\DownloadUpload::where('folderId',$folderId)->where('option','DescargasPdf')->where('status','Habilitado')
    		->get();

            foreach ($array as $key => $value) {

                $isActive=\App\Notification::where('status','pending')->where('studentId',$u->id)->where('type',"DescargasPdf")->where('typeId1',$value->id)->where('typeId2',$value->folderId)->exists();

                    $value->setAttribute('isActive',$isActive);

            }

            if(!empty($array)){
                $descargasExists=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','DescargasPdf')->exists();
                if($descargasExists==true){
                    $descargas=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','DescargasPdf')->get();
                    foreach ($descargas as $key => $value) {
                        $value->delete();
                        //$value->status="seen";
                        //$value->save();
                    }

                }
           		return response()->json(['message'=>'success','files'=>$array]);
        	}
        	if(empty($array)){
            	$array=array();
                $descargasExists=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','DescargasPdf')->exists();
                if($descargasExists==true){
                    $descargas=\App\Notification::where('status','pending')->where('studentId',$studentId)->where('type','DescargasPdf')->first();
                    foreach ($descargas as $key => $value) {
                        $value->delete();
                        //$value->status="seen";
                        //$value->save();
                    }
                }
            return response()->json(['message'=>'success','files'=>$array]);
        	}
    	}

    }
    public function uploadPdfFile(Request $request){
        $studentId=$request->get('studentId');
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
    	$folderId=$request->get('folderId');
    	$file=Input::file("file");
        $upload=new \App\DownloadUpload;
        $upload->option="SubidasPdf";
        $upload->studentType=$request->get('studentType');
        $upload->studentId=$request->get('studentId');
        $upload->folderId=$request->get('folderId');
        if(!empty($file)){

            $newFilename=$file->getClientOriginalName();
            $destinationPath='uploads';
            $file->move($destinationPath,$newFilename);
            $picPath='uploads/' . $newFilename;
            $upload->adminDownloadName=$picPath;
        }
        $upload->save();
        return response()->json(['status'=>'Successfull']);

    }
}
