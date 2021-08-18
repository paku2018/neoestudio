<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
class StudentController extends Controller
{
   public function index(){
        $students=\App\User::where('role','student')->get();
        return view('students.index',compact('students'));
    }
    public function prueba(){
        $students=\App\User::where('role','student')->where('type','Prueba')->get();
        $ty="Prueba";
        return view('students.index',compact('students','ty'));
    }
    public function alumno(){
        $students=\App\User::where('role','student')->where('type','Alumno')->get();
        $ty="Alumno";
        return view('students.index',compact('students','ty'));
    }
    public function alumnoConvocado(){
        $students=\App\User::where('role','student')->where('type','Alumno Convocado')->get();
        $ty="Alumno Convocado";
        return view('students.index',compact('students','ty'));
    }
    public function create(){
        return view('students.create');

    }
    public function store(Request $request){
        if(!empty($request->get('email'))){
            $exists=\App\User::where('email',$request->get('email'))->exists();
            if($exists==true){
                return redirect()->back()->with('message2','El Email ya existe');       
            }

        }
        if(!empty($request->get('telephone'))){
            $exists=\App\User::where('telephone',$request->get('telephone'))->exists();
            if($exists==true){
                return redirect()->back()->with('message2','El teléfono ya existe');        
            }

        }
        $student=new \App\User;
        $student->name=$request->get('name');
        $student->email=$request->get('email');
        
        $student->telephone=$request->get('telephone');
        $student->type="Prueba";
        $ex=\App\User::exists();
        if($ex==true){
            $max=\App\User::where('role','student')->max('scale');
            
            if($max==null){
                $student->scale=0;
            }
            if($max!=null){
                $student->scale=$max+1;
            }
        }
        if($ex==false){
            $student->scale=0;
        }
        $student->role="student";
        $student->save();
        $news=\App\Alert::where('studentType',$student->type)->get();
        
                foreach ($news as $key => $value) {
                    $ar=new \App\AlertRecord;
                    $ar->studentId=$student->id;
                    $ar->news=$value->news;
                    $ar->newsId=$value->id;
                    $ar->status="unseen";
                    $ar->save();
                }
                
                $efe=\App\Folder::where('studentType',$student->type)->where('type','exams')->exists();
                $rfe=\App\Folder::where('studentType',$student->type)->where('type','reviews')->exists();
                $pfe=\App\Folder::where('studentType',$student->type)->where('type','personalities')->exists();
                if($efe==true){
                    $ef=\App\Folder::where('studentType',$student->type)->where('type','exams')->get();
                    $efArray=array();
                    foreach($ef as $efv){
                        array_push($efArray,$efv->id);
                    }
                    $examExists=\App\Exam::where('status','Habilitado')->where('studentType',$student->type)->whereIn('folderId',$efArray)->exists();
                    
                    
                    if($examExists==true){
                        $exams=\App\Exam::where('status','Habilitado')->where('studentType',$student->type)->whereIn('folderId',$efArray)->get();
                        foreach($exams as $exam){
                            $notiE=new \App\Notification;
                            $notiE->studentId=$student->id;
                            $notiE->type="exams";
                            $notiE->status="pending";
                            $notiE->typeId1=$exam->id;
                            
                            $notiE->save();
                        }
                    }
                }
                if($rfe==true){
                    $rf=\App\Folder::where('studentType',$student->type)->where('type','reviews')->get();
                    $rfArray=array();
                    foreach($rf as $rfv){
                        array_push($rfArray,$rfv->id);
                    }
                    $reviewExists=\App\Exam::where('status','Habilitado')->where('studentType',$student->type)->whereIn('folderId',$rfArray)->exists();
                    if($reviewExists==true){
                        $reviews=\App\Exam::where('status','Habilitado')->where('studentType',$student->type)->whereIn('folderId',$rfArray)->get();
                        foreach ($reviews as $review) {
                            $notiE=new \App\Notification;
                            $notiE->studentId=$student->id;
                            $notiE->type="reviews";
                            $notiE->status="pending";
                            $notiE->typeId1=$review->id;
                            
                            $notiE->save();
                        }

                    }
                }
                if($pfe==true){
                    $pf=\App\Folder::where('studentType',$student->type)->where('type','personalities')->get();
                    $pfArray=array();
                    foreach($pf as $pfv){
                        array_push($pfArray,$pfv->id);
                    }
                    $personalityExists=\App\Exam::where('status','Habilitado')->where('studentType',$student->type)->whereIn('folderId',$pfArray)->exists();
                    if($personalityExists==true){
                        $personalities=\App\Exam::where('status','Habilitado')->where('studentType',$student->type)->whereIn('folderId',$pfArray)->get();
                        foreach ($personalities as $personality) {
                            $notiE=new \App\Notification;
                            $notiE->studentId=$student->id;
                            $notiE->type="personalities";
                            $notiE->status="pending";
                            $notiE->typeId1=$personality->id;
                           
                            $notiE->save();
                        }
                        
                    }
                }
                $descargasExists=\App\DownloadUpload::where('status','Habilitado')->where('studentType',$student->type)->where('option','Descargas')->exists();
                $subidasExists=\App\Folder::where('status','Habilitado')->where('studentType',$student->type)->where('type','Subidas')->exists();
                $topicExists=\App\Topic::where('studentType',$student->type)->exists();
                if($topicExists==true){
                    $topics=\App\Topic::where('studentType',$student->type)->get();
                    $topicArray=array();
                    foreach($topics as $topic){
                        array_push($topicArray,$topic->id);
                    }
                    if(!empty($topicArray)){
                        $audioExists=\App\Material::where('status','Habilitado')->where('type','audio')->whereIn('topicId',$topicArray)->exists();
                        $videoExists=\App\Material::where('status','Habilitado')->where('type','video')->whereIn('topicId',$topicArray)->exists();
                    }
                }
                $folderExists=\App\Folder::where('studentType',$student->type)->where('type','surveys')->exists();
                if($folderExists==true){
                    $folders=\App\Folder::where('studentType',$student->type)->where('type','surveys')->get();
                    $folderArray=array();
                    foreach($folders as $folder){
                        array_push($folderArray,$folder->id);
                    }
                    if(!empty($folderArray)){
                        $surveyExists=\App\Survey::where('status','Habilitado')->where('studentType',$student->type)->whereIn('folderId',$folderArray)->exists();       
                    }
                }
                
                if($descargasExists==true){
                    $dess=\App\DownloadUpload::where('status','Habilitado')->where('studentType',$student->type)->where('option','Descargas')->get();
                    foreach ($dess as $key => $des) {
                        $notiDes=new \App\Notification;
                        $notiDes->studentId=$student->id;
                        $notiDes->type="Descargas";
                        $notiDes->status="pending";
                        $notiDes->typeId1=$des->id;
                        $notiDes->typeId2=$des->folderId;
                        $notiDes->save();
                    }
                    
                }
                if($subidasExists==true){
                    $subs=\App\Folder::where('status','Habilitado')->where('studentType',$student->type)->where('type','Subidas')->get();
                    foreach ($subs as $sub) {
                        $notiSub=new \App\Notification;
                        $notiSub->studentId=$student->id;
                        $notiSub->type="Subidas";
                        $notiSub->status="pending";
                        $notiSub->typeId2=$sub->id;
                        $notiSub->save();
                    }
                    
                }
                if($topicExists==true){
                    if($audioExists==true){
                        $auds=\App\Material::where('status','Habilitado')->where('type','audio')->whereIn('topicId',$topicArray)->get();
                        foreach ($auds as $aud) {
                            $notiA=new \App\Notification;
                            $notiA->studentId=$student->id;
                            $notiA->type="audio";
                            $notiA->status="pending";
                            $notiA->typeId1=$aud->id;
                            $notiA->typeId2=$aud->topicId;
                            $notiA->save();
                        }
                        
                    }
                    if($videoExists==true){
                        $vids=\App\Material::where('status','Habilitado')->where('type','video')->whereIn('topicId',$topicArray)->get();
                        foreach ($vids as $vid) {
                           $notiV=new \App\Notification;
                            $notiV->studentId=$student->id;
                            $notiV->type="video";
                            $notiV->status="pending";
                            $notiV->typeId1=$vid->id;
                            $notiV->typeId2=$vid->topicId;
                            $notiV->save();

                        }
                    }
                }
                if($folderExists==true){
                    if($surveyExists==true){
                        $surs=\App\Survey::where('status','Habilitado')->where('studentType',$student->type)->whereIn('folderId',$folderArray)->get();
                        foreach ($surs as $sur) {
                            $notiSur=new \App\Notification;
                            $notiSur->studentId=$student->id;
                            $notiSur->type="surveys";
                            $notiSur->status="pending";
                            $notiSur->typeId1=$sur->id;
                            $notiSur->save();
                        }
                        
                    }   
                }
                
        $message="Alumno creado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function edit($id){
        $student=\App\User::find($id);
        return view('students.edit',compact('student'));
    }
    public function update(Request $request, $id){
        $student=\App\User::find($id);
        $reg=\App\Register::where('userId',$id)->first();
        $reg->surname=$request->get('name');
        $reg->save();
        $student->name=$request->get('name');
        $student->email=$request->get('email');
        $student->password=$request->get('password');
        $student->telephone=$request->get('telephone');
        $student->studentCode=$request->get('studentCode');
        //$student->type=$request->get('type');
        $student->baremo=$request->get('baremo');
        $max=\App\User::where('role','student')->where('type',$request->get('type'))->max('scale');
        if($max==null){
            $student->scale=0;
        }
        if($max!=null){
            $student->scale=$max+1;
        }
        $student->save();
        $message="Alumno actualizado exitosamente";
        return redirect()->back()->with('message',$message);
    }
    public function delete($id){
        $student=\App\User::find($id);
        $student->delete();
        $rex=\App\Register::where('userId',$id)->exists();
        if($rex==true){
            $reg=\App\Register::where('userId',$id)->first();
            $reg->delete();
        }
        $coms=\App\CombineResult::where('studentId',$id)->get();
        foreach ($coms as $key => $value) {
            $value->delete();
        }
        $objs=\App\Objective::where('studentId',$id)->get();
        foreach ($objs as $key => $value) {
            $value->delete();
        }
        $er=\App\StudentExamRecord::where('studentId',$id)->get();
        foreach ($er as $key => $value) {
            $attempts=\App\StudentAttempt::where('studentExamRecordId',$value->id)->get();
            foreach ($attempts as $key => $at) {
                $at->delete();
            }
            $value->delete();
        }
        $er=\App\StudentSurveyRecord::where('studentId',$id)->get();
        foreach ($er as $key => $value) {
            $attempts=\App\StudentSurveyAttempt::where('surveyRecordId',$value->id)->get();
            foreach ($attempts as $key => $at) {
                $at->delete();
            }
            $value->delete();
        }
        $pays=\App\Pay::where('userId',$id)->get();
        foreach ($pays as $key => $value) {
            $value->delete();
        }
        $nots=\App\Notification::where('studentId',$id)->get();
        foreach ($nots as $key => $value) {
            $value->delete();
        }
        $res=\App\Reschedule::where('studentId',$id)->get();
        foreach ($res as $key => $value) {
            $value->delete();
        }
        $message="Alumno eliminado exitosamente";
        return redirect()->back()->with('message',$message);
    }
    public function studentExamsById($id){
        $student=\App\User::find($id);
        $studentExamRecords=\App\StudentExamRecord::where('studentId',$id)->where('status','end')->get();
        
        return view('students.examrecords',compact('student','studentExamRecords'));
    }
    public function studentExamsAttempted($id){
        
        $correctCount=0;
        $wrongCount=0;
        $attemptedCount=0;
        $nonAttemptedCount=0;
        $record=\App\StudentExamRecord::find($id);
        $exam=\App\Exam::find($record->examId);
        $folder=\App\Folder::find($exam->folderId);
        if($folder->type=="exams"){

            $questions=\App\StudentAttempt::where('studentExamRecordId',$record->id)->get();

            $studentAttemptsCount=\App\StudentAttempt::where('studentExamRecordId',$record->id)->count();
            foreach ($questions as $key => $value) {
                $studentAnswered=$value->studentAnswered;
                $correctValue=$value->correct;
                if($correctValue=='a'){
                    $correctAnswer="answer1";
                }
                if($correctValue=='b'){
                    $correctAnswer="answer2";
                }
                if($correctValue=='c'){
                    $correctAnswer="answer3";
                }
                if($correctValue=='d'){
                    $correctAnswer="answer4";
                }
                if(empty($studentAnswered)){
                    $nonAttemptedCount=$nonAttemptedCount+1;
                    $answersArray[$key]="notAttempted";
                }
                if(!empty($studentAnswered)){
                    
                        if($studentAnswered==$correctAnswer){
                            $correctCount=$correctCount+1;
                            $attemptedCount=$attemptedCount+1;
                            $answersArray[$key]="correct";
                        }
                        if($studentAnswered!=$correctAnswer){
                            $wrongCount=$wrongCount+1;
                            $attemptedCount=$attemptedCount+1;
                            $answersArray[$key]="wrong";
                        }
                    
                    

                }
            }
        }
        if($folder->type!="exams"){
            $questions=\App\StudentAttempt::where('studentExamRecordId',$record->id)->get();

            $studentAttemptsCount=\App\StudentAttempt::where('studentExamRecordId',$record->id)->count();
            if($folder->type=="personalities"){
                foreach ($questions as $key => $value) {
                    $studentAnswered=$value->studentAnswered;
                    $correctValue=$value->correct;
                    if($correctValue=='a y b'){
                        $correctAnswer=array("answer1","answer2");
                    }
                    if($correctValue=='c y d'){
                        $correctAnswer=array("answer3","answer4");
                    }
                    if(empty($studentAnswered)){
                        $nonAttemptedCount=$nonAttemptedCount+1;
                        $answersArray[$key]="notAttempted";
                    }
                    if(!empty($studentAnswered)){
                        if(in_array($studentAnswered,$correctAnswer)){
                            $correctCount=$correctCount+1;
                            $attemptedCount=$attemptedCount+1;
                            $answersArray[$key]="correct";
                            
                        }
                        else{
                            $wrongCount=$wrongCount+1;
                            $attemptedCount=$attemptedCount+1;
                            $answersArray[$key]="wrong";
                            
                        }
                    }
                    
                }
            }
            if($folder->type=="reviews"){
                foreach ($questions as $key => $value) {
                    $studentAnswered=$value->studentAnswered;
                    $correctValue=$value->correct;
                    if($correctValue=='a'){
                        $correctAnswer="answer1";
                    }
                    if($correctValue=='b'){
                        $correctAnswer="answer2";
                    }
                    if($correctValue=='c'){
                        $correctAnswer="answer3";
                    }
                    if($correctValue=='d'){
                        $correctAnswer="answer4";
                    }
                    if(empty($studentAnswered)){
                        $nonAttemptedCount=$nonAttemptedCount+1;
                        $answersArray[$key]="notAttempted";
                    }
                    if(!empty($studentAnswered)){
                        if($studentAnswered==$correctAnswer){
                                $correctCount=$correctCount+1;
                                $attemptedCount=$attemptedCount+1;
                                $answersArray[$key]="correct";
                                
                        }
                        if($studentAnswered!=$correctAnswer){
                            $wrongCount=$wrongCount+1;
                            $attemptedCount=$attemptedCount+1;
                            $answersArray[$key]="wrong";
                        }
                    }
                }
            }
        }


            $correctP=$correctCount/$studentAttemptsCount;
        $correctPercentage=$correctP*100;
        $wrongP=$wrongCount/$studentAttemptsCount;
        $wrongPercentage=$wrongP*100;
        $nullP=$nonAttemptedCount/$studentAttemptsCount;
        $nullPercentage=$nullP*100;

        
        return view('students.studentExamAttempted',compact('questions','folder','record','answersArray','correctCount','wrongCount','correctPercentage','wrongPercentage','nullPercentage','nonAttemptedCount'));
    }

    public function rescheduleExamEnable($id){
        $record=\App\StudentExamRecord::find($id);
        $record->isCurrent="no";
        $record->save();
        $exam=\App\Exam::find($record->examId);
        $courseId=$exam->courseId;
        $course=\App\Course::find($courseId);
        if(empty($course)){
            $totalPoints=25;
        }
        if(!empty($course)){
         if($course->name=="Conocimientos"||$course->name=="Inglés"){
                $totalPoints=25;
            }
            if($course->name=="Ortografía"||$course->name=="Psicotécnicos"){
                $totalPoints=20;
            }
        }
        $folderId=$exam->folderId;
        $studentId=$record->studentId;
        $e1=\App\CombineResult::where('studentId',$studentId)->where('courseId',$courseId)->where('folderId',$exam->folderId)->exists();
        if($e1==true){

            $findC=\App\CombineResult::where('studentId',$studentId)->where('courseId',$courseId)->where('folderId',$exam->folderId)->first();

            $findC->points=$findC->points-$record->score;

            $findC->totalPoints=$findC->totalPoints-$totalPoints;
            $findC->field1x=$findC->field1x-1;
            $findC->save();
        }

        $exists=\App\Reschedule::where('studentId',$record->studentId)->where('examId',$record->examId)->exists();
        if($exists==true){
            $reschedule=\App\Reschedule::where('studentId',$record->studentId)->where('examId',$record->examId)->first();
            $reschedule->enabledTime=Carbon::now()->format('Y-m-d H:i:s');
            $reschedule->status="Habilitado";
            $reschedule->save();
            return redirect()->back()->with('message','Exam Rescheduled'); 
        }
        $reschedule=new \App\Reschedule;
        $reschedule->examId=$record->examId;
        $reschedule->studentId=$record->studentId;
        $reschedule->enabledTime=Carbon::now()->format('Y-m-d H:i:s');
        $reschedule->status="Habilitado";
        $reschedule->save();
        return redirect()->back()->with('message','Exam Rescheduled'); 
    }
    public function rescheduleExamDisable($id){
        $reschedule=\App\Reschedule::find($id);
        $reschedule->status="Deshabilitado";
        $reschedule->disabledTime=Carbon::now()->format('Y-m-d H:i:s');
        $reschedule->save();
        return redirect()->back()->with('message','Exam Rescheduled');   
    }
    public function block($id){
        $student=\App\User::find($id);
        if($student->field1x!='Bloquear'){
            $student->field1x="Bloquear";
            $student->save();
            return redirect()->back()->with('message','Bloqueado con éxito');   
        }
        if($student->field1x=='Bloquear'){
            $student->field1x="Desbloquear";
            $student->save();
            return redirect()->back()->with('message','Desbloquear con éxito');   
        }  
    }


}
