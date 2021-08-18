<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PersonalityController extends Controller
{
    public function indexFolder($studentType){
        $folders=\App\Folder::where('type','personalities')->where('studentType',$studentType)->get();
        return view('personalities.folders.index',compact('folders','studentType'));
    }
    public function createFolder($studentType){
        return view('personalities.folders.create',compact('studentType'));

    }
    public function storeFolder(Request $request){

        $folder=new \App\Folder;
        $folder->name=$request->get('name');
        $folder->type=$request->get('option');
        $folder->studentType=$request->get('studentType');
        $folder->status="Deshabilitado";
        $folder->save();
        $message="Carpeta creado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function editFolder($id){
        $folder=\App\Folder::find($id);
        return view('personalities.folders.edit',compact('folder'));
    }
    public function updateFolder(Request $request, $id){
        $folder=\App\Folder::find($id);
        $folder->name=$request->get('name');
        $folder->save();
        $message="Carpeta actualizado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function deleteFolder($id){
        $folder=\App\Folder::find($id);
        $folder->delete();
        $message="Carpeta eliminado con éxito";
        
        return redirect()->back()->with('message',$message);
    }
    public function personalitiesFoldersStatusChange($id){
        $folder=\App\Folder::find($id);
        if($folder->status=="Deshabilitado"){
            $folder->status="Habilitado";
            $folder->save();
            return redirect()->back()->with('message','Status changed successfully');       
        }
        if($folder->status=="Habilitado"){
            $folder->status="Deshabilitado";
            $folder->save();
            return redirect()->back()->with('message','Status changed successfully');       
        }
    }
    public function insidePersonalitiesFolders($studentType,$folderId){
        $folder=\App\Folder::find($folderId);
        $personalities=\App\Exam::where('studentType',$studentType)->where('folderId',$folderId)->get();
        return view('personalities.index',compact('personalities','studentType','folder'));

    }
    public function insidePersonalitiesFoldersCreate($studentType,$folderId){
        $folder=\App\Folder::find($folderId);
        return view('personalities.create',compact('studentType','folder'));

    }
    public function insidePersonalitiesFoldersStore(Request $request){
        $exam=new \App\Exam;
        
        $exam->name=$request->get('name');
        $exam->studentType=$request->get('studentType');
        
        $exam->scheduleDate=$request->get('scheduleDate');
        $exam->timeFrom=$request->get('timeFrom')*60;
        
        $exam->folderId=$request->get('folderId');
        $exam->status="Deshabilitado";
        $exam->save();
        $message="Personalidad creado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function insidePersonalitiesFoldersEdit($id){
        $personality=\App\Exam::find($id);
        return view('personalities.edit',compact('personality'));
    }
    public function insidePersonalitiesFoldersUpdate(Request $request, $id){
        $exam=\App\Exam::find($id);
        $exam->name=$request->get('name');
        
        
        $exam->scheduleDate=$request->get('scheduleDate');
        $exam->timeFrom=$request->get('timeFrom')*60;
        
       
        $exam->save();
        $message="Personalidad actualizado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function insidePersonalitiesFoldersDelete($id){
        $exam=\App\Exam::find($id);
        $exam->delete();
        $message="Personalidad eliminado con éxito";
        return redirect()->back()->with('message',$message);
    }
}
