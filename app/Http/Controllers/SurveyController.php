<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function indexFolder($studentType){
        $folders=\App\Folder::where('type','surveys')->where('studentType',$studentType)->get();
        return view('surveys.folders.index',compact('folders','studentType'));
    }
    public function createFolder($studentType){
        return view('surveys.folders.create',compact('studentType'));

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
        return view('surveys.folders.edit',compact('folder'));
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
    public function surveysFoldersStatusChange($id){
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
    public function insideSurveysFolders($studentType,$folderId){
        $folder=\App\Folder::find($folderId);

        $surveys=\App\Survey::where('studentType',$studentType)->where('folderId',$folderId)->get();

        return view('surveys.index',compact('surveys','studentType','folder'));

    }
    public function insideSurveysFoldersCreate($studentType,$folderId){
        $folder=\App\Folder::find($folderId);
        return view('surveys.create',compact('studentType','folder'));

    }
    public function insideSurveysFoldersStore(Request $request){
        $survey=new \App\Survey;
        
        $survey->name=$request->get('name');
        $survey->studentType=$request->get('studentType');
        $survey->status="Deshabilitado";
        $survey->folderId=$request->get('folderId');
        $survey->save();
        $message="Encuestas creado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function insideSurveysFoldersEdit($id){
        $survey=\App\Survey::find($id);
        return view('surveys.edit',compact('survey'));
    }
    public function insideSurveysFoldersUpdate(Request $request, $id){
        $survey=\App\Survey::find($id);
        $survey->name=$request->get('name'); 
        $survey->save();
        $message="Encuestas actualizado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function insideSurveysFoldersDelete($id){
        $survey=\App\Survey::find($id);
        $survey->delete();
        $message="Encuestas eliminado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function insideSurveysFoldersStatusChange($id){
        $survey=\App\Survey::find($id);
        if($survey->status=="Deshabilitado"){
            $survey->status="Habilitado";
            $survey->save();
            
            $exists=\App\User::where('type',$survey->studentType)->where('role','student')->exists();
            if($exists==true){
                $users=\App\User::where('type',$survey->studentType)->where('role','student')->get();
                foreach($users as $user){
                    $notiExists=\App\Notification::where('studentId',$user->id)->where('type','surveys')->where('typeId1',$id)->exists();
                    if($notiExists==true){
                        $noti=\App\Notification::where('studentId',$user->id)->where('type','surveys')->where('typeId1',$id)->first();
                        $noti->status="pending";
                        $noti->save();
                    }
                    if($notiExists==false){
                        $noti=new \App\Notification;
                        $noti->studentId=$user->id;
                        $noti->type="surveys";
                        $noti->status="pending";
                        $noti->typeId1=$id;
                        $noti->save();
                    }

                }
            }
            return redirect()->back()->with('message','Status changed successfully');       
        }
        if($survey->status=="Habilitado"){
            $survey->status="Deshabilitado";
            $survey->save();
            return redirect()->back()->with('message','Status changed successfully');       
        }
    }
    public function studentSurveysById($id){
        
        $studentSurveyRecords=\App\StudentSurveyRecord::where('studentId',$id)->get();
       
        $student=\App\User::find($id);
        //dd($studentExamRecords);
        return view('students.surveyrecords',compact('student','studentSurveyRecords'));
    }
    public function studentSurveysAttempted($id){
        $surveyRecord=\App\StudentSurveyRecord::find($id);
        $survey=\App\Survey::find($surveyRecord->surveyId);
        $questions=\App\StudentSurveyAttempt::where('surveyRecordId',$id)->get();

        return view('students.surveyAttempts',compact('questions','survey','surveyRecord'));
    }
}
