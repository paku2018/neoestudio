<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function indexFolder($studentType){
        $folders=\App\Folder::where('type',"exams")->where('studentType',$studentType)->get();
        
        return view('exams.folders.index',compact('folders','studentType'));
    }
    public function createFolder($studentType){
        return view('exams.folders.create',compact('studentType'));

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
        return view('exams.folders.edit',compact('folder'));
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
    public function examsFoldersStatusChange($id){
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
    public function insideExamsFolders($studentType,$folderId){
        $folder=\App\Folder::find($folderId);
        $exams=\App\Exam::where('studentType',$studentType)->where('folderId',$folderId)->get();
        return view('exams.index',compact('exams','studentType','folder'));

    }
    public function insideExamsFoldersCreate($studentType,$folderId){
        $folder=\App\Folder::find($folderId);
        return view('exams.create',compact('studentType','folder'));

    }
    public function insideExamsFoldersStore(Request $request){
        $exam=new \App\Exam;
        
        $exam->name=$request->get('name');
        $exam->studentType=$request->get('studentType');
        $exam->courseId=$request->get('courseId');
        $exam->scheduleDate=$request->get('scheduleDate');
        $exam->timeFrom=$request->get('timeFrom')*60;
        
        $exam->folderId=$request->get('folderId');
        $exam->status="Deshabilitado";
        $exam->save();
        $message="Examen creado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function insideExamsFoldersEdit($id){
        $exam=\App\Exam::find($id);
        return view('exams.edit',compact('exam'));
    }
    public function insideExamsFoldersUpdate(Request $request, $id){
        $exam=\App\Exam::find($id);
        $exam->name=$request->get('name');
        
        $exam->courseId=$request->get('courseId');
        $exam->scheduleDate=$request->get('scheduleDate');
        $exam->timeFrom=$request->get('timeFrom')*60;
        
       
        $exam->save();
        $message="Examen actualizado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function insideExamsFoldersDelete($id){
        $exam=\App\Exam::find($id);
        $exam->delete();
        $message="Examen eliminado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function insideExamsFoldersStatusChange($id){
        $exam=\App\Exam::find($id);
        if($exam->status=="Deshabilitado"){
            $exam->status="Habilitado";
            $exam->save();
            
            $folder=\App\Folder::find($exam->folderId);
            $exists=\App\User::where('type',$exam->studentType)->where('role','student')->exists();
            if($exists==true){
                $users=\App\User::where('type',$exam->studentType)->where('role','student')->get();
                foreach($users as $user){
                    $notiExists=\App\Notification::where('studentId',$user->id)->where('type',$folder->type)->where('typeId1',$id)->exists();
                    if($notiExists==true){
                        $noti=\App\Notification::where('studentId',$user->id)->where('type',$folder->type)->where('typeId1',$id)->first();
                        $noti->status="pending";
                        $noti->save();
                    }
                    if($notiExists==false){
                        $noti=new \App\Notification;
                        $noti->studentId=$user->id;
                        $noti->type=$folder->type;
                        $noti->status="pending";
                        $noti->typeId1=$id;
                        $noti->save();
                    }

                }
            }
            return redirect()->back()->with('message','Status changed successfully');       
        }
        if($exam->status=="Habilitado"){
            $exam->status="Deshabilitado";
            $exam->save();
            return redirect()->back()->with('message','Status changed successfully');       
        }
    }
}
