<?php

namespace App\Http\Controllers;

use App\Classes\RedsysApi;
use Illuminate\Http\Request;
/*use Illuminate\Support\Facades\Input;*/
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\mughees;
use Illuminate\Support\Facades\Auth;
use wapmorgan\MediaFile\MediaFile;
use wapmorgan\Mp3Info\Mp3Info;
use Carbon\Carbon;
use Mail;
use PDF;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
//use Importer;
//use File;
use App\User;
use Illuminate\Support\Facades\File;
use Spatie\DbDumper\Databases\MySql;

$GLOBALS["REDSYS_API_PATH"]=realpath(dirname(__FILE__));
    $GLOBALS["REDSYS_LOG_ENABLED"]=true;

    include_once $GLOBALS["REDSYS_API_PATH"]."/Model/message/RESTOperationMessage.php";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Model/message/RESTAuthenticationRequestMessage.php";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Service/RESTService.php";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Service/Impl/RESTInitialRequestService.php";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Service/Impl/RESTAuthenticationRequestService.php";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Service/Impl/RESTOperationService.php";
    include_once $GLOBALS["REDSYS_API_PATH"].'/Utils/RESTLogger.php';
    include_once $GLOBALS["REDSYS_API_PATH"].'/Constants/RESTConstants.php';
    //RESTLogger::initialize($GLOBALS["REDSYS_API_PATH"]."/Log/", RESTLogger::$DEBUG);
class TestController extends Controller
{
    public function submitDoc(Request $request){
        $id=5;
        Excel::import( new mughees($id),$request->file('fileP'));
    }
    public function loginUser(Request $request){
        $exists=User::where('email',$request->get('email'))->where('password',$request->get('password'))->exists();
        if($exists==false){
            return redirect()->back()->with('message2','Email or password are incorrect');
        }
        if($exists==true){
            $user=\App\User::where('email',$request->get('email'))->where('password',$request->get('password'))->first();
            Auth::login($user);
            return redirect()->back()->with('message','Logged In');
        }
    }
    public function logoutUser(){
        Auth::logout();
        return redirect()->back()->with('message','Logged Out');
    }
    public function ts3(){
        $now=Carbon::now();
        dd($now);
        /*$recs=\App\StudentExamRecord::where('studentId',1076)->get();
        foreach ($recs as $key => $value) {
            $ats=\App\StudentAttempt::where('studentExamRecordId',$value->id)->get();
            foreach ($ats as $key => $value2) {
                $value2->delete();
            }
            $value->delete();
        }

        /*$recs=\App\Alert::where('studentType','Prueba')->orderBy('created_at','asc')->get();
         $users=\App\User::where('role','student')->where('type','Prueba')->get();
         $users2=\App\User::where('role','student')->where('type','Alumno')->get();

        $recs2=\App\Alert::where('studentType','Alumno')->orderBy('created_at','asc')->get();
        foreach ($recs2 as $key => $alert) {
            foreach ($users2 as $key => $value) {
                $ar=new \App\AlertRecord;
                $ar->studentId=$value->id;
                $ar->news=$alert->news;
                $ar->newsId=$alert->id;
                $ar->status="seen";
                $ar->save();
            }
        }
        dd('gi');*/

    }
    public function ts(){

        $combineResults=\App\CombineResult::all();

        foreach ($combineResults as $combineResult) {
            $exams=\App\Exam::where('courseId',$combineResult->courseId)->where('folderId',$combineResult->folderId)->get();
            if(!empty($exams)){
                $examsArray=array();
                foreach ($exams as $exam) {
                    array_push($examsArray,$exam->id);
                }
                $examRecordsExists=\App\StudentExamRecord::where('studentId',$combineResult->studentId)->whereIn('examId',$examsArray)->where('status','end')
                    ->where('isCurrent','yes')->exists();
                if($examRecordsExists==false){
                    $combineResult->delete();
                }
                if($examRecordsExists==true){
                    $examRecords=\App\StudentExamRecord::where('studentId',$combineResult->studentId)->whereIn('examId',$examsArray)->where('status','end')
                    ->where('isCurrent','yes')->get();
                    $score=0;

                    foreach ($examRecords as $examRecord) {
                        $score=$score+$examRecord->score;
                    }
                    $count=\App\StudentExamRecord::where('studentId',$combineResult->studentId)->whereIn('examId',$examsArray)->where('status','end')
                    ->where('isCurrent','yes')->get()->count();
                    $course=\App\Course::find($combineResult->courseId);
                    if($course->name=="Psicotécnicos"){
                        $totalPoints=15;
                    }
                    if($course->name=="Inglés"){
                        $totalPoints=20;
                    }
                    if($course->name=="Conocimientos"){
                        $totalPoints=25;
                    }
                    if($course->name=="Ortografía"){
                        $totalPoints=20;
                    }

                    $combineResult->points=$score;
                    $combineResult->totalPoints=$count*$totalPoints;
                    $combineResult->field1x=$count;
                    $combineResult->save();


                }
            }
        }
        dd('hi');
        /*$users=\App\User::where('role','student')->get();
        $uss=array();
        foreach ($users as $key => $value) {
            array_push($uss,$value->id);
        }
        $regs=\App\CombineResult::whereNotIn('studentId',$uss)->get();
        dd($regs);
        //return view('cords');
        /*Mail::send('mail2',[], function($message) {
             $message->to('zaidimughees@gmail.com')->subject
                ('hi');
             $message->from('zaidimughees@gmail.com','Neoestudio');

            });
        //DB::statement('ALTER TABLE pays ADD authCode varchar(255);');
        //DB::statement('ALTER TABLE pays ADD order varchar(255);');
        //DB::statement('ALTER TABLE prices ADD type varchar(255);');
        //DB::statement('ALTER TABLE pays ADD order varchar(255);');
        //DB::statement('ALTER TABLE pays ADD order varchar(255);');
        //DB::statement('ALTER TABLE pays ADD submitTime datetime;');
        //DB::statement('ALTER TABLE pays ADD scheduleTime datetime;');
        dd('done');
       /* $r=\App\CombineResult::where('points',"0.00")->first();
        $r->points=0;
        $r->save();
        //DB::statement('ALTER TABLE studentattempts ADD qaId varchar(255);');
        //dd(base_path());
        //$user=\App\User::where('email','super@admin.com')->first();
        //dd($user);
        //$sql = base_path('ab22.sql');
        //$tr=DB::unprepared(file_get_contents($sql));
        //$sql_dump = File::get($sql);

        //$tr=DB::connection()->getPdo()->exec($sql_dump);
        //dd($tr);
//collect contents and pass to DB::unprepared

        /*$time=Carbon::now()->toDateString();

        File::put('backups/'.$time.'backup.sql','');
        dd('yo');
        MySql::create()->setDbName('neoappes')
        ->setUserName('neoes_')
        ->setPassword('aA115yr4.')
        ->setHost('mysql-5703.dinaserver.com')
        ->setPort('3306')
        ->dumpToFile(base_path($name));
        //$nt=\App\Notification::where('studentId',326)->get();
        //dd($nt);
        //$r=\App\CombineResult::where('studentId',312)->first();
        //dd($r);
        //DB::statement('ALTER TABLE notifications ADD typeId1 varchar(255);');
        //DB::statement('ALTER TABLE notifications ADD typeId2 varchar(255);');
        //DB::statement('ALTER TABLE objectives ADD stateVideo varchar(255);');
        //DB::statement('ALTER TABLE combineresults ADD revisionStatus varchar(255);');
        //DB::statement('ALTER TABLE combineresults ADD revision varchar(255);');
        //$r=\App\CombineResult::where('studentId',316)->first();
        //dd($r);
       // DB::statement('ALTER TABLE combineresults ADD revisionStatus varchar(255);');
        //dd('don');
        /*$pp=public_path();

        $mat="dump.sql";
        $re=str_replace("/public","",$pp);
        //$file= "public_path()". "/$mat";
        $file= "$re". "/$mat";


        ob_end_clean();
        $headers = array('Content-Type' => \File::mimeType($file));

       return response()->download($file,$mat,$headers);

        //DB::statement('ALTER TABLE studentsurveyrecords ADD title LONGTEXT;');
       /* DB::statement('ALTER TABLE combineresults ALTER COLUMN points INTEGER;');
        dd('gh');
        $faqs=\App\Faq::where('folderId',99)->get();
        dd($faqs);
        /*$students=\App\User::where('role','student')->get();
        $ids=array();
        foreach ($students as $key => $value) {
            array_push($ids,$value->id);
        }
        $recs=\App\AlertRecord::whereIn('studentId',$ids)->get();
        dd($recs);

        /*$coms=\App\CombineResult::whereNotIn('studentId',$ids)->get();
        foreach ($coms as $key => $value) {
            $value->delete();
        }
        $objs=\App\Objective::whereNotIn('studentId',$ids)->get();
        foreach ($objs as $key => $value) {
            $value->delete();
        }
        $er=\App\StudentExamRecord::whereNotIn('studentId',$ids)->get();

        foreach ($er as $key => $value) {
            $attempts=\App\StudentAttempt::where('studentExamRecordId',$value->id)->get();
            foreach ($attempts as $key => $at) {
                $at->delete();
            }
            $value->delete();
        }
        $er=\App\StudentSurveyRecord::whereNotIn('studentId',$ids)->get();
        foreach ($er as $key => $value) {
            $attempts=\App\StudentSurveyAttempt::where('surveyRecordId',$value->id)->get();
            foreach ($attempts as $key => $at) {
                $at->delete();
            }
            $value->delete();
        }
        $pays=\App\Pay::whereNotIn('userId',$ids)->get();
        foreach ($pays as $key => $value) {
            $value->delete();
        }
        $nots=\App\Notification::whereNotIn('studentId',$ids)->get();
        foreach ($nots as $key => $value) {
            $value->delete();
        }
        $res=\App\Reschedule::whereNotIn('studentId',$ids)->get();
        foreach ($res as $key => $value) {
            $value->delete();
        }
        dd('ok');

        /*
        DB::statement('ALTER TABLE studentsurveyattempts ADD question1 LONGTEXT;');


       /* $str = 'Welcome to "W3Schools"';
$pattern = "/w3.*?\s?schools/i";
preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE);
print_r($matches[0][1]);*/
        /*$str = '<p style=" jdjsd font-family: Proxima;">hfgbfdj style="font-family:Proxima"</p><span style="font-family:Proxima">sdfsdf</span>';
        $pattern = "/style=.*?font-family: Proxima/i";
        preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE);
        print_r($matches[0][1]);
        /*$word = "fox";
        $mystring = '<p style="font-family:Proxima">hfgbfdj style="font-family:Proxima"</p><span style="font-family:Proxima">sdfsdf</span>';
        $count=substr_count($mystring, 'style="font-family:Proxima"');
        //dd(strpos($mystring,'style="font-family:Proxima"',4));
        $mystring2='class="proxima" ';
        //$pos=2;
        //dd($mystring);
        //$newstr = substr_replace($mystring, $mystring2, $pos, 0);
        $off=0;
        for($i=0;$i<$count;$i++){
            $pos=strpos($mystring,'style="font-family:Proxima"',$off);
            $mystring=substr_replace($mystring, $mystring2,$pos,0);
            $off=$pos+17;
        }
        dd($mystring);

        /*$pp=public_path();

        $mat="backup3.sql";
        $re=str_replace("/public","",$pp);
        //$file= "public_path()". "/$mat";
        $file= "$re". "/$mat";


        ob_end_clean();
        $headers = array('Content-Type' => \File::mimeType($file));

       return response()->download($file,$mat,$headers);
       /* $user=\App\User::where('email','admin@admin.com')->first();
        $user->password="Neo.45.dc!A_oGc*";
        $user->save();
        dd($user);
       //return view('tsmOld');
        /*$studentCode="ddgd";
        $password="sgfdg";
        $type="ddfg";
        $amount="gdfd";
        $time="sdfsdf";
        $tax=105.00;
        $date="13/01/2020";
        $total="605";
       $pdf = PDF::loadView('tsmOld2', ['tax'=>$tax,'date'=>$date,'total'=>$total,'studentCode'=>$studentCode,'password'=>$password,'type'=>$type,'amount'=>$amount,'time'=>$time]);
            $ran=Str::random(6);
            $fileName="$ran-neoestudioinvoice.pdf";
            $pdf->save("invoices/$fileName");
            $pp=public_path();
            $re=str_replace("\public","",$pp);
            $path="$re/invoices/$fileName";
            //dd($path);
            Mail::send('mail',['studentCode'=>$studentCode,'password'=>$password], function($message) use($path){
             $message->to('zaidimughees@gmail.com')->subject
                ('hi');
             $message->from('zaidimughees@gmail.com','Neoestudio');
             $message->attach($path);
            });
       /* $records=\App\StudentExamRecord::all();
        foreach ($records as $key => $value) {
            $value->delete();
        }
        $records2=\App\StudentAttempt::all();
        foreach ($records2 as $key => $value) {
            $value->delete();
        }

        $records3=\App\StudentSurveyRecord::all();
        foreach ($records3 as $key => $value) {
            $value->delete();
        }
        $records4=\App\StudentSurveyAttempt::all();
        foreach ($records4 as $key => $value) {
            $value->delete();
        }

        $records5=\App\CombineResult::all();
        foreach ($records5 as $key => $value) {
            $value->delete();
        }
        $records6=\App\Reschedule::all();
        foreach ($records6 as $key => $value) {
            $value->delete();
        }
        $records7=\App\Result::all();
        foreach ($records7 as $key => $value) {
            $value->delete();
        }
        $records8=\App\Thread::all();
        foreach ($records8 as $key => $value) {
            $value->delete();
        }
        $records9=\App\Notification::all();
        foreach ($records9 as $key => $value) {
            $value->delete();
        }
        $records10=\App\Objective::all();
        foreach ($records10 as $key => $value) {
            $value->delete();
        }
        /*$startDate = Carbon::now(); //returns current day
        $firstDay = $startDate->firstOfMonth();
        dd($firstDay->addDays(24)->addMonth(2)->toDateString());
        /*$chats=\App\Register::all();
        foreach ($chats as $key => $value) {
            $value->delete();
        }
        $threads=\App\User::where('role','student')->get();
        foreach ($threads as $key => $value) {
            $value->delete();
        }
        dd('yes');
        /*$pp=public_path();

        $mat="DB_Backup_3july2020.sql";
        $re=str_replace("/public","",$pp);
        //$file= "public_path()". "/$mat";
        $file= "$re". "/$mat";


        ob_end_clean();
        $headers = array('Content-Type' => \File::mimeType($file));

       return response()->download($file,$mat,$headers);
        /*return view('opo');
        $user=\App\User::find(117);
        $user->baremo=1;
        $user->save();
        dd('ok');*/





    }
    public function getFiguresS(){

        $users=\App\User::all();
        $registers=\App\Register::all();
        return response()->json(['status'=>'succe','users'=>$users,'regs'=>$registers]);
    }
    public function us(Request $request){
        $userId=$request->json('id');

        $ue=\App\User::where('id',$userId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found', 'is_deleted' => true]);
        }
        $u=\App\User::find($userId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found', 'is_block' => true]);
        }
        $user=\App\User::find($userId);
        return response()->json(['status'=>'Successfull','data'=>$user]);
    }
    public function ge(Request $request){
       $studentId=$request->json('studentId');
        $studentId=220;
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $student=\App\User::find($studentId);
        $folders=\App\Folder::where('type','exams')->where('studentType',$student->type)->get();

        $resultArray=array();
        $courseKnow=\App\Course::where('name','Psicotécnicos')->first();
                $cik=$courseKnow->id;
        foreach ($folders as $folderkey => $folder) {
            //course with topic
            $courses=\App\Course::all();
            $coursesA=array();

            foreach ($courses as $coursekey => $course) {
                //p

                    $m=null;
                    $s=null;
                    $h=null;
                    $ch=null;
                    $count=null;
                    $tfp=null;
                    $count=\App\CombineResult::select('points')->where('folderId',$folder->id)->where('courseId',$cik)
                                    ->get()->count();

                    $tfp=intval(round(0.25*$count));

                    if($tfp>=1){
                        $combineResults=\App\CombineResult::where('folderId',$folder->id)->where('courseId',$cik)
                        ->orderByRaw("CAST(points AS SIGNED) ASC")->get();
                        //dd($combineResults);
                        $allS=array();
                        foreach ($combineResults as $combinekey => $combine) {
                            $um=\App\User::find($combine->studentId);
                            if(!empty($um)){
                                array_push($allS,$combine->points);
                            }
                        }
                        $m=$allS[$tfp-1];
                    }

                    if($tfp<1){
                        $m=0;
                    }
                    $ch=\App\CombineResult::where('folderId',$folder->id)->where('courseId',$cik)
                                ->orderByRaw("CAST(points AS SIGNED) DESC")->get();


                    if(!empty($ch[0])){
                        $h=$ch[0]->points;
                        $s=$h-$m;

                    }


                //end p
                if($course->name=="Psicotécnicos"){

                    $studentCombineResult=\App\CombineResult::where('folderId',$folder->id)->where('courseId',$course->id)
                    ->where('studentId',$studentId)->first();

                    if(empty($studentCombineResult)){
                        $course->setAttribute('rankName',"Ranking de $course->name");
                        $course->setAttribute('percentage','null');
                        $course->setAttribute('points','null');
                        $course->setAttribute('totalPoints','null');
                    }
                    if(!empty($studentCombineResult)){
                        //for current
                        $studentCombineResult=\App\CombineResult::where('folderId',$folder->id)->where('courseId',$course->id)
                        ->where('studentId',$studentId)->first();
                        $directScore=$studentCombineResult->points;

                        $f=$studentCombineResult->points-$m;


                        $weightedC=15*$f/$s;

                        //end for current
                        $combineResults=\App\CombineResult::where('folderId',$folder->id)->where('courseId',$course->id)
                            ->orderByRaw("CAST(points AS SIGNED) ASC")->get();

                        $allScores=array();
                        foreach ($combineResults as $combinekey => $combine) {
                            $um=\App\User::find($combine->studentId);
                            if(!empty($um)){

                                $f=$combine->points-$m;

                                $weightedA=15*$f/$s;
                                array_push($allScores,$weightedA);
                            }


                        }
                        $uniqueScores=array_unique($allScores);
                        sort($uniqueScores);

                        $highestKey=count($uniqueScores)-1;
                        $percentages=array();

                        foreach ($uniqueScores as $uniquekey => $unique) {

                            if($highestKey==0){
                                $per=100;
                            }
                            if($highestKey!=0){
                                $per=$uniquekey/$highestKey*100;
                            }

                            array_push($percentages,$per);

                            if($unique==$weightedC){

                                $course->setAttribute('rankName',"Ranking de $course->name");
                                $course->setAttribute('percentage',intval($per));
                                if($weightedC<0){
                                    $course->setAttribute('points',0);
                                }
                                if($weightedC>=0){
                                    $course->setAttribute('points',round($weightedC,2));
                                }

                                $course->setAttribute('totalPoints','15');

                            }
                        }
                    }
                }

                if($course->name!="Psicotécnicos"){
                    $studentCombineResult=\App\CombineResult::where('folderId',$folder->id)->where('courseId',$course->id)
                    ->where('studentId',$studentId)->first();
                    if(empty($studentCombineResult)){
                        $course->setAttribute('rankName',"Ranking de $course->name");
                        $course->setAttribute('percentage','null');
                        $course->setAttribute('points','null');
                        $course->setAttribute('totalPoints','null');
                    }
                    if(!empty($studentCombineResult)){
                        $combineResults=\App\CombineResult::where('folderId',$folder->id)->where('courseId',$course->id)
                            ->orderByRaw("CAST(points AS SIGNED) ASC")->get();
                        $allScores=array();
                        foreach ($combineResults as $combinekey => $combine) {
                            $um=\App\User::find($combine->studentId);
                            if(!empty($um)){
                                array_push($allScores,$combine->points);
                            }
                        }
                        $uniqueScores=array_unique($allScores);
                        sort($uniqueScores);
                        $highestKey=count($uniqueScores)-1;
                        $percentages=array();
                        foreach ($uniqueScores as $uniquekey => $unique) {

                            if($highestKey==0){
                                $per=100;
                            }
                            if($highestKey!=0){
                                $per=$uniquekey/$highestKey*100;
                            }

                            array_push($percentages,$per);

                            if($unique==$studentCombineResult->points){

                                $course->setAttribute('rankName',"Ranking de $course->name");
                                $course->setAttribute('percentage',intval($per));
                                $course->setAttribute('points',round($unique,2));
                                $course->setAttribute('totalPoints',$studentCombineResult->totalPoints);

                            }
                        }
                    }
                }
            }

            $cA=$courses->toArray();
            $resultArray[$folderkey]['folderName']=$folder->name;
            $resultArray[$folderkey]['courses']=$cA;
            //end course with topic


            //start only topic without baremo
            $exists1=\App\CombineResult::where('folderId',$folder->id)->where('studentId',$studentId)->exists();

            if($exists1==false){
                $withoutArray=array();
                $withoutArray['rankName']="Rank. $folder->name sin baremo";
                $withoutArray['percentage']=null;
                $withoutArray['points']=null;
                $withoutArray['totalPoints']=null;
                $resultArray[$folderkey]['withoutBaremo']=$withoutArray;

                $withArray=array();
                $withArray['rankName']="Rank. $folder->name con baremo";
                $withArray['percentage']=null;
                $withArray['points']=null;
                $withArray['totalPoints']=null;
                $resultArray[$folderkey]['withBaremo']=$withArray;

            }
            if($exists1==true){
                $courseKnow=\App\Course::where('name','Psicotécnicos')->first();
                $cik=$courseKnow->id;

                $studentAllTopics=\App\CombineResult::where('folderId',$folder->id)->where('studentId',$studentId)->get();
                $studentAllTopicsScore=0;
                $studentAllTopicsScoreTotal=0;
                foreach ($studentAllTopics as $studentalltopickey => $value) {
                    if($value->courseId!=$cik){
                        $studentAllTopicsScore=$studentAllTopicsScore+$value->points;
                    }
                }
                if(!empty($weightedC)){
                    if($weightedC<0){
                        $weightedC=0;
                    }
                    $studentAllTopicsScore=$studentAllTopicsScore+$weightedC;
                }

                foreach ($studentAllTopics as $studentalltopickey => $value) {
                    if($value->courseId!=$cik){
                        $studentAllTopicsScoreTotal=$studentAllTopicsScoreTotal+$value->totalPoints;
                    }
                }


                if(!empty($weightedC)){

                    $studentAllTopicsScoreTotal=$studentAllTopicsScoreTotal+15;
                }
                dd($studentAllTopicsScoreTotal);

                $allStudents=\App\CombineResult::where('folderId',$folder->id)->select('studentId')->distinct()->get();

                $allStudentsIds=array();
                foreach ($allStudents as $askey => $allStudent) {
                    $um2=\App\User::find($allStudent->studentId);
                    if(!empty($um2)){
                        array_push($allStudentsIds,$allStudent->studentId);
                    }
                }

                $scoresWithoutBaremo=array();
                foreach ($allStudentsIds as $asidkey => $allStudentId) {

                    $allResults=\App\CombineResult::where('folderId',$folder->id)->where('studentId',$allStudentId)->get();
                    $allResultsScores=0;
                    foreach ($allResults as $allresultkey => $allResult) {
                        if($allResult->courseId!=$cik){
                            $allResultsScores=$allResultsScores+$allResult->points;
                        }
                    }
                    //for wei
                    $allResultsP=\App\CombineResult::where('folderId',$folder->id)->where('studentId',$allStudentId)->where('courseId',$cik)->get();

                    if(!empty($allResultsP)){
                        $allResultsScoresP=0;
                        foreach ($allResultsP as $allresultkeyP => $allResultP) {
                            $allResultsScoresP=$allResultsScoresP+$allResultP->points;
                        }
                        $fP=$allResultsScoresP-$m;
                        $wP=15*$fP/$s;
                        if($wP<0){
                            $wP=0;
                        }
                        $allResultsScores=$allResultsScores+$wP;

                    }
                    //end forwei

                    array_push($scoresWithoutBaremo,$allResultsScores);
                }


                $uniqueScoresWithoutBaremo=array_unique($scoresWithoutBaremo);
                sort($uniqueScoresWithoutBaremo);

                $highestKeyWithoutBaremo=count($uniqueScoresWithoutBaremo)-1;
                $percentagesWithoutBaremo=array();
                foreach ($uniqueScoresWithoutBaremo as $oswbkey => $oswbvalue) {

                    if($highestKeyWithoutBaremo==0){
                                $perWithoutBaremo=100;
                    }
                    if($highestKeyWithoutBaremo!=0){
                        $perWithoutBaremo=$oswbkey/$highestKeyWithoutBaremo*100;
                    }
                    array_push($percentagesWithoutBaremo,$perWithoutBaremo);
                    if($oswbvalue==$studentAllTopicsScore){

                        $withoutArray=array();
                        $withoutArray['rankName']="Rank. $folder->name sin baremo";
                        $withoutArray['percentage']=intval($perWithoutBaremo);
                        $withoutArray['points']=round($studentAllTopicsScore,2);
                        $withoutArray['totalPoints']=$studentAllTopicsScoreTotal;
                        $resultArray[$folderkey]['withoutBaremo']=$withoutArray;

                    }
                }

                //end only topic without baremo
                //start only topic with baremo
                $studentAllTopics2=\App\CombineResult::where('folderId',$folder->id)->where('studentId',$studentId)->get();
                if(!empty($studentAllTopics2)){
                    $studentAllTopicsScore2=0;
                    $studentAllTopicsScore2Total=0;
                    foreach ($studentAllTopics2 as $studentalltopickey => $value) {
                        if($value->courseId!=$cik){
                            $studentAllTopicsScore2=$studentAllTopicsScore2+$value->points;
                        }
                    }
                    if(!empty($weightedC)){
                        if($weightedC<0){
                            $weightedC=0;
                        }
                        $studentAllTopicsScore2=$studentAllTopicsScore2+$weightedC;
                    }

                    foreach ($studentAllTopics2 as $studentalltopickey => $value) {
                        if($value->courseId!=$cik){
                            $studentAllTopicsScore2Total=$studentAllTopicsScore2Total+$value->totalPoints;
                        }
                    }
                    if(!empty($weightedC)){
                        $studentAllTopicsScore2Total=$studentAllTopicsScore2Total+15;
                    }

                    if(!empty($student->baremo)){
                        $studentAllTopicsScore2=$studentAllTopicsScore2+$student->baremo;
                    }

                    $allStudents=\App\CombineResult::where('folderId',$folder->id)->select('studentId')->distinct()->get();
                    $scoresWithBaremo=array();
                    foreach ($allStudents as $askey => $allStudent) {
                        $studentB=\App\User::find($allStudent->studentId);
                        if(!empty($studentB)){
                            $allResults2=\App\CombineResult::where('folderId',$folder->id)
                            ->where('studentId',$allStudent->studentId)->get();
                            $allResultsScores2=0;
                            foreach ($allResults2 as $allresultkey => $allResult2) {
                                if($allResult2->courseId!=$cik){
                                    $allResultsScores2=$allResultsScores2+$allResult2->points;
                                }
                            }
                            if(!empty($studentB->baremo)){
                                $allResultsScores2=$allResultsScores2+$studentB->baremo;
                            }
                            //for wei
                            $allResultsP2=\App\CombineResult::where('folderId',$folder->id)->where('studentId',$allStudent->studentId)->where('courseId',$cik)->get();
                            if(!empty($allResultsP2)){
                                $allResultsScoresP2=0;
                                foreach ($allResultsP2 as $allresultkeyP2 => $allResultP2) {
                                    $allResultsScoresP2=$allResultsScoresP2+$allResultP2->points;
                                }

                                $fP2=$allResultsScoresP2-$m;

                                $wP2=15*$fP2/$s;
                                if($wP2<0){
                                    $wP2=0;
                                }

                                $allResultsScores2=$allResultsScores2+$wP2;

                            }
                            //end forwei

                            array_push($scoresWithBaremo,$allResultsScores2);
                        }
                    }

                    $uniqueScoresWithBaremo=array_unique($scoresWithBaremo);
                    sort($uniqueScoresWithBaremo);
                    $highestKeyWithBaremo=count($uniqueScoresWithBaremo)-1;
                    $percentagesWithBaremo=array();

                    foreach ($uniqueScoresWithBaremo as $oswbkey => $oswbvalue) {
                        if($highestKeyWithBaremo==0){
                            $perWithBaremo=100;
                        }
                        if($highestKeyWithBaremo!=0){
                            $perWithBaremo=$oswbkey/$highestKeyWithBaremo*100;
                        }
                        array_push($percentagesWithBaremo,$perWithBaremo);
                        if($oswbvalue==$studentAllTopicsScore2){

                            $withArray=array();
                            $withArray['rankName']="Rank. $folder->name con baremo";
                            $withArray['percentage']=intval($perWithBaremo);
                            $withArray['points']=round($studentAllTopicsScore2,2);
                            $withArray['totalPoints']=$studentAllTopicsScore2Total;
                            $resultArray[$folderkey]['withBaremo']=$withArray;


                        }
                    }
                }
            }

            //end only topic with baremo

        }
        return response()->json(['status'=>'Successfull','data'=>$resultArray]);
    }
    public function iden(){
        $now=Carbon::now()->toDateTimeString();
        $exists=\App\Pay::where('process','auto')->where('status','pending')->exists();
        if($exists==true){
            $pays=\App\Pay::where('process','auto')->where('status','pending')->get();

            foreach ($pays as $key => $pay) {
                if(!empty($pay)){
                    $userId=$pay->userId;
                    $identifierE=\App\Identifier::where('userId',$userId)->exists();
                    if($identifierE==true){
                        $identifier=\App\Identifier::where('userId',$userId)->first();

                        if(!empty($identifier->identifier)){

                            if(Carbon::parse($now)->gte(Carbon::parse($pay->scheduleTime))){

                                $orderID = substr( str_shuffle( str_repeat( 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 10 ) ), 0, 12 );
                                $request = new \RESTOperationMessage();

                                // Operation mandatory data
                                $request->setAmount($pay->amount); // i.e. 1,23 (decimal point depends on currency code)
                                $request->setCurrency("978"); // ISO-4217 numeric currency code
                                $request->setMerchant("351565320");
                                $request->setTerminal("001");
                                $request->setOrder($orderID);
                                $request->setTransactionType(\RESTConstants::$AUTHORIZATION);

                                //Reference information
                                $request->useReference($identifier->identifier);

                                // Other optional parameters example can be added by "addParameter" method
                                $request->addParameter("DS_MERCHANT_PRODUCTDESCRIPTION", "Prueba de pago con DirectPayment y referencia");

                                //Method for a direct payment request (without authentication)
                                $request->useDirectPayment();

                                //Printing SendMessage
                                //echo "<h1>Mensaje a enviar</h1>";
                                //var_dump($request);

                                // Service setting (Signature, Environment, type of payment)
                                $signatureKey = "I8c7RLGs35xGlPYuu95SYweaFHf + eHwA";
                                $service = new \RESTOperationService($signatureKey, \RESTConstants::$ENV_SANDBOX);
                                $response = $service->sendOperation($request);
                                    return $response;
                                // Response analysis
                                //echo "<h1>Respuesta recibida</h1>";
                                //var_dump($response->getResult());

                                switch ($response->getResult()) {
                                    case \RESTConstants::$RESP_LITERAL_OK:
                                        $pay->status="paid";
                                        $pay->response="ok";
                                        $pay->save();
                                        //echo "<h1>Operation was OK</h1>";
                                    break;

                                    case \RESTConstants::$RESP_LITERAL_AUT:
                                            $pay->status="pending";
                                            $pay->response="aut";
                                            $pay->save();
                                        //echo "<h1>Operation requires authentication</h1>";
                                    break;

                                    default:
                                        $pay->status="pending";
                                        $pay->response="not";
                                        $pay->save();
                                        //echo "<h1>Operation was not OK</h1>";
                                    break;
                                }
                            }
                        }
                    }
                }
            }

        }
        return "done";
    }

    public function idenManual($uid){
        $now=Carbon::now()->toDateTimeString();
        if(empty($uid) === false && $uid > 0){
            $exists=\App\Pay::where('userId',$uid)->exists();
            if($exists==true){
                $pays=\App\Pay::where('userId',$uid)->get();
                // Object is created
                $miObj = new RedsysAPI();
                foreach ($pays as $key => $pay) {
                    if(!empty($pay)){
                        $userId=$pay->userId;
                        $identifierE=\App\Identifier::where('userId',$userId)->exists();
                        if($identifierE==true){
                            $identifier=\App\Identifier::where('userId',$userId)->first();
                            //$identifier->identifier = 'a20e9acc176641ac2855331d61d99d1c5e541fc5';
                            if(!empty($identifier->identifier) || 1==1){

                                if(Carbon::parse($now)->gte(Carbon::parse($pay->scheduleTime)) || 1==1){
                                    $orderID = substr( str_shuffle( str_repeat( 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 10 ) ), 0, 12 );
                                    $request = new \RESTOperationMessage();

                                    // Operation mandatory data
                                    $request->setAmount(($pay->amount * 100)); // i.e. 1,23 (decimal point depends on currency code)
                                    $request->setCurrency("978"); // ISO-4217 numeric currency code
                                    $request->setMerchant("351565320");
                                    $request->setTerminal("001");
                                    $request->setOrder($orderID);
                                    $request->setTransactionType(\RESTConstants::$AUTHORIZATION);

                                    //Reference information
                                    $request->useReference('420041577366057d21c9a75b2abef85e5091b16d');
                                    //$request->useReference($identifier->identifier);

                                    // Other optional parameters example can be added by "addParameter" method
                                    $request->addParameter("DS_MERCHANT_PRODUCTDESCRIPTION", "Prueba de pago con DirectPayment y referencia");

                                    //Method for a direct payment request (without authentication)
                                    $request->useDirectPayment();

                                    // Service setting (Signature, Environment, type of payment)
                                    //$signatureKey = "I8c7RLGs35xGlPYuu95SYweaFHf + eHwA";
                                    $signatureKey = "sq7HjrUOBfKmC576ILgskD5srU870gJ7";
                                    $service = new \RESTOperationService($signatureKey, \RESTConstants::$ENV_SANDBOX);
                                    $response = $service->sendOperationManual($request);
echo '<pre>';print_r($response );echo '</pre>';die('Call');
                                    switch ($response->getResult()) {
                                        case \RESTConstants::$RESP_LITERAL_OK:
                                            $pay->status="paid";
                                            $pay->response="ok";
                                            $pay->save();
                                            //echo "<h1>Operation was OK</h1>";
                                        break;

                                        case \RESTConstants::$RESP_LITERAL_AUT:
                                                $pay->status="pending";
                                                $pay->response="aut";
                                                $pay->save();
                                            //echo "<h1>Operation requires authentication</h1>";
                                        break;

                                        default:
                                            $pay->status="pending";
                                            $pay->response="not";
                                            $pay->save();
                                            //echo "<h1>Operation was not OK</h1>";
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return "done";
    }
    public function ide(){
        return redirect()->route('idd');
    }
    public function deletepaysp($id){
        $pay=\App\Pay::find($id);
        $pay->delete();
        dd('don');
    }
}

