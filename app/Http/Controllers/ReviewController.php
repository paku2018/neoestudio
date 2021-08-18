<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function indexFolder($studentType){
        $folders=\App\Folder::where('type',"reviews")->where('studentType',$studentType)->orderBy('id','desc')->get();
        return view('reviews.folders.index',compact('folders','studentType'));
    }
    public function createFolder($studentType){
        return view('reviews.folders.create',compact('studentType'));

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
        return view('reviews.folders.edit',compact('folder'));
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
    public function reviewsFoldersStatusChange($id){
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
    public function insideReviewsFolders($studentType,$folderId){
        $folder=\App\Folder::find($folderId);
        $reviews=\App\Exam::where('studentType',$studentType)->where('folderId',$folderId)->get();
        return view('reviews.index',compact('reviews','studentType','folder'));

    }
    public function insideReviewsFoldersCreate($studentType,$folderId){
        $folder=\App\Folder::find($folderId);
        return view('reviews.create',compact('studentType','folder'));

    }
    public function insideReviewsFoldersStore(Request $request){
        $exam=new \App\Exam;
        
        $exam->name=$request->get('name');
        $exam->studentType=$request->get('studentType');
        $exam->courseId=$request->get('courseId');
        $exam->scheduleDate=$request->get('scheduleDate');
        $exam->timeFrom=$request->get('timeFrom')*60;
        
        $exam->folderId=$request->get('folderId');
        $exam->status="Deshabilitado";
        $exam->save();
        $message="Repaso creado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function insideReviewsFoldersEdit($id){
        $review=\App\Exam::find($id);
        return view('reviews.edit',compact('review'));
    }
    public function insideReviewsFoldersUpdate(Request $request, $id){
        $exam=\App\Exam::find($id);
        $exam->name=$request->get('name');
        
        $exam->courseId=$request->get('courseId');
        $exam->scheduleDate=$request->get('scheduleDate');
        $exam->timeFrom=$request->get('timeFrom')*60;
        
       
        $exam->save();
        $message="Repaso actualizado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function insideReviewsFoldersDelete($id){
        $exam=\App\Exam::find($id);
        $exam->delete();
        $message="Repaso eliminado con éxito";
        return redirect()->back()->with('message',$message);
    }
}
