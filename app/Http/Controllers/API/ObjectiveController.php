<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
class ObjectiveController extends Controller
{
    public function audios(Request $request){
    	$state=$request->json('state');
    	//$state="kill";
    	$studentId=$request->json('studentId');
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
    	//$studentId=1;
    	$todayDate=Carbon::now()->toDateString();

    	$exists=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->exists();

    	if($exists==false){
	    	if($state=="start"){

	    		$objective=new \App\Objective;
	    		$objective->studentId=$studentId;
	    		$objective->stateAudio="start";
	   			$objective->date=$todayDate;
	   			$objective->audioStartTime=Carbon::now()->toDateTimeString();
	   			$objective->save();
	   			return response()->json(['status'=>'Successfull','message'=>'start']);
	    	}
    	}


    	if($exists==true){

    		if($state=="start"){

	    		$objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();

	    		$current=Carbon::now()->toDateTimeString();

	    		if(!empty($objective->stateAudio)){

		    		if($objective->stateAudio=="start"){

		    			$start=$objective->audioStartTime;
		    			$diff=Carbon::parse($start)->diffInSeconds(Carbon::parse($current));

		    			$objective->audios=$objective->audios+$diff;
		    			$objective->audioStartTime=Carbon::now()->toDateTimeString();
		    			$objective->save();
		    			return response()->json(['status'=>'Successfull','message'=>'start']);
		    		}
		    		if($objective->stateAudio=="pause"){

		    			//$start=$objective->audioPauseTime;
			    		//$diff=Carbon::parse($start)->diffInSeconds(Carbon::parse($current));
			    		//$objective->audios=$objective->audios+$diff;
			    		$objective->stateAudio="start";
			    		$objective->audioStartTime=Carbon::now()->toDateTimeString();
			    		$objective->save();
			    		return response()->json(['status'=>'Successfull','message'=>'start']);
		    		}
		    		if($objective->stateAudio=="end"){
		    			$objective->stateAudio="start";
		    			$objective->audioStartTime=Carbon::now()->toDateTimeString();
		    			$objective->save();
		    			return response()->json(['status'=>'Successfull','message'=>'started']);
		    		}

	    		}
	    		if(empty($objective->stateAudio)){

	    			$objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();
	    			//$objective->studentId=$studentId;
		    		$objective->stateAudio="start";
		   			//$objective->date=$todayDate;
		   			$objective->audioStartTime=Carbon::now()->toDateTimeString();
		   			$objective->save();
		   			return response()->json(['status'=>'Successfull','message'=>'start']);
	    		}

    		}
    		if($state=="pause"){
                $objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();
                if($objective->stateAudio!="start"){
                    return response()->json(['status'=>'Successfull','message'=>'pause']);
                }
                if($objective->stateAudio=="start"){


    	    		$current=Carbon::now()->toDateTimeString();
    	    		$start=$objective->audioStartTime;
    	    		$diff=Carbon::parse($start)->diffInSeconds(Carbon::parse($current));
    	    		$objective->audios=$objective->audios+$diff;
    	    		$objective->stateAudio="pause";
    	    		$objective->audioPauseTime=Carbon::now()->toDateTimeString();
    	    		$objective->save();
    	    		return response()->json(['status'=>'Successfull','message'=>'pause']);
                }
    		}
    		if($state=="end"){
    			$objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();
	    		$current=Carbon::now()->toDateTimeString();
	    		if($objective->stateAudio=="end"){
	    			return response()->json(['status'=>'Successfull','message'=>'end']);
	    		}
	    		if($objective->stateAudio=="pause"){
	    			$objective->audioEndTime==$objective->audioPauseTime;
                    $objective->stateAudio="end";
                    $objective->save();
                    return response()->json(['status'=>'Successfull','message'=>'end']);
	    		}
	    		if($objective->stateAudio=="start"){
	    			$start=$objective->audioStartTime;
	    		}

	    		//$start=$objective->audioStartTime;
	    		$diff=Carbon::parse($start)->diffInSeconds(Carbon::parse($current));
	    		$objective->audios=$objective->audios+$diff;
	    		$objective->stateAudio="end";
	    		$objective->audioEndTime=Carbon::now()->toDateTimeString();
	    		$objective->save();
	    		return response()->json(['status'=>'Successfull','message'=>'end']);
    		}
    		if($state=="kill"){

    			$objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();

    			if($objective->stateAudio=="start"){

    				$current=Carbon::now()->toDateTimeString();
		    		$start=$objective->audioStartTime;
		    		$diff=Carbon::parse($start)->diffInSeconds(Carbon::parse($current));
		    		$objective->audios=$objective->audios+$diff;
		    		$objective->stateAudio="pause";
		    		$objective->audioPauseTime=Carbon::now()->toDateTimeString();
		    		$objective->save();

		    		return response()->json(['status'=>'Successfull','message'=>'pause']);
    			}
    			if($objective->stateAudio=="pause"){

    				/*$current=Carbon::now()->toDateTimeString();
		    		$start=$objective->audioPauseTime;
		    		$diff=Carbon::parse($start)->diffInSeconds(Carbon::parse($current));
		    		$objective->audios=$objective->audios+$diff;
		    		$objective->stateAudio="pause";
		    		$objective->audioPauseTime=Carbon::now()->toDateTimeString();*/

		    		return response()->json(['status'=>'Successfull','message'=>'pause']);

    			}
    			return response()->json(['status'=>'Successfull']);
    		}
    	}
    }

    public function videos(Request $request){
        $state=$request->json('state');
        //$state="kill";
        $studentId=$request->json('studentId');
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        //$studentId=1;
        $todayDate=Carbon::now()->toDateString();

        $exists=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->exists();

        if($exists==false){
            if($state=="start"){

                $objective=new \App\Objective;
                $objective->studentId=$studentId;
                $objective->stateVideo="start";
                $objective->date=$todayDate;
                $objective->videoStartTime=Carbon::now()->toDateTimeString();
                $objective->save();
                return response()->json(['status'=>'Successfull','message'=>'start']);
            }
        }


        if($exists==true){

            if($state=="start"){

                $objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();

                $current=Carbon::now()->toDateTimeString();

                if(!empty($objective->stateVideo)){

                    if($objective->stateVideo=="start"){

                        $start=$objective->videoStartTime;
                        $diff=Carbon::parse($start)->diffInSeconds(Carbon::parse($current));

                        $objective->classes=$objective->classes+$diff;
                        $objective->videoStartTime=Carbon::now()->toDateTimeString();
                        $objective->save();
                        return response()->json(['status'=>'Successfull','message'=>'start']);
                    }
                    if($objective->stateVideo=="pause"){

                        //$start=$objective->audioPauseTime;
                        //$diff=Carbon::parse($start)->diffInSeconds(Carbon::parse($current));
                        //$objective->audios=$objective->audios+$diff;
                        $objective->stateVideo="start";
                        $objective->videoStartTime=Carbon::now()->toDateTimeString();
                        $objective->save();
                        return response()->json(['status'=>'Successfull','message'=>'start']);
                    }
                    if($objective->stateVideo=="end"){
                        $objective->stateVideo="start";
                        $objective->videoStartTime=Carbon::now()->toDateTimeString();
                        $objective->save();
                        return response()->json(['status'=>'Successfull','message'=>'started']);
                    }

                }
                if(empty($objective->stateVideo)){

                    $objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();
                    //$objective->studentId=$studentId;
                    $objective->stateVideo="start";
                    //$objective->date=$todayDate;
                    $objective->videoStartTime=Carbon::now()->toDateTimeString();
                    $objective->save();
                    return response()->json(['status'=>'Successfull','message'=>'start']);
                }

            }
            if($state=="pause"){
                $objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();
                if($objective->stateVideo!="start"){
                    return response()->json(['status'=>'Successfull','message'=>'pause']);
                }
                if($objective->stateVideo=="start"){


                    $current=Carbon::now()->toDateTimeString();
                    $start=$objective->videoStartTime;
                    $diff=Carbon::parse($start)->diffInSeconds(Carbon::parse($current));
                    $objective->classes=$objective->classes+$diff;
                    $objective->stateVideo="pause";
                    $objective->videoPauseTime=Carbon::now()->toDateTimeString();
                    $objective->save();
                    return response()->json(['status'=>'Successfull','message'=>'pause']);
                }
            }
            if($state=="end"){
                $objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();
                $current=Carbon::now()->toDateTimeString();
                if($objective->stateVideo=="end"){
                    return response()->json(['status'=>'Successfull','message'=>'end']);
                }
                if($objective->stateVideo=="pause"){
                    $objective->videoEndTime==$objective->videoPauseTime;
                    $objective->stateVideo="end";
                    $objective->save();
                    return response()->json(['status'=>'Successfull','message'=>'end']);
                }
                if($objective->stateVideo=="start"){
                    $start=$objective->videoStartTime;
                }

                //$start=$objective->audioStartTime;
                $diff=Carbon::parse($start)->diffInSeconds(Carbon::parse($current));
                $objective->classes=$objective->classes+$diff;
                $objective->stateVideo="end";
                $objective->videoEndTime=Carbon::now()->toDateTimeString();
                $objective->save();
                return response()->json(['status'=>'Successfull','message'=>'end']);
            }
            if($state=="kill"){

                $objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();

                if($objective->stateVideo=="start"){

                    $current=Carbon::now()->toDateTimeString();
                    $start=$objective->videoStartTime;
                    $diff=Carbon::parse($start)->diffInSeconds(Carbon::parse($current));
                    $objective->classes=$objective->classes+$diff;
                    $objective->stateVideo="pause";
                    $objective->videoPauseTime=Carbon::now()->toDateTimeString();
                    $objective->save();

                    return response()->json(['status'=>'Successfull','message'=>'pause']);
                }
                if($objective->stateAudio=="pause"){

                    /*$current=Carbon::now()->toDateTimeString();
                    $start=$objective->audioPauseTime;
                    $diff=Carbon::parse($start)->diffInSeconds(Carbon::parse($current));
                    $objective->audios=$objective->audios+$diff;
                    $objective->stateAudio="pause";
                    $objective->audioPauseTime=Carbon::now()->toDateTimeString();*/

                    return response()->json(['status'=>'Successfull','message'=>'pause']);

                }
                return response()->json(['status'=>'Successfull']);
            }
        }
    }
    public function videosOld(Request $request){
    	$studentId=$request->json('studentId');

        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
    	//$studentId=1;
    	//$time=20;
    	$time=$request->json('time');
    	$todayDate=Carbon::now()->toDateString();
    	$exists=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->exists();
    	if($exists==false){
    		$objective=new \App\Objective;
	    	$objective->studentId=$studentId;
	    	$objective->classes=$time;
	    	$objective->lastVideoTime=$time;
	    	$objective->stateVideo="start";
	    	$objective->date=$todayDate;
	    	$objective->videoStartTime=Carbon::now()->toDateTimeString();
	    	$objective->save();
	    	return response()->json(['status'=>'firstTime-Successfull','time'=>$time]);
    	}
    	if($exists==true){

    		$objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();

    		if(empty($objective->videoStartTime)){

    			$objective->studentId=$studentId;
	    		$objective->classes=$time;
	    		$objective->videoStartTime=Carbon::now()->toDateTimeString();
	    		$objective->lastVideoTime=$time;
	    		$objective->stateVideo="start";
	    		$objective->save();
	    		return response()->json(['status'=>'firstExists-Successfull','time'=>$time]);

    		}
    		else{

    			$start=$objective->videoStartTime;
    			$current=Carbon::now()->toDateTimeString();
    			$diff=Carbon::parse($start)->diffInSeconds(Carbon::parse($current));
    			//dd($diff,$objective->lastVideoTime);
    			//return response()->json(['dif'=>$diff,'onjlvt'=>$objective->lastVideoTime]);
    			if($diff<$objective->lastVideoTime){
    				//$mi=$objective->classes-$diff;
    				$objective->classes=$objective->classes-$objective->lastVideoTime;
    				$objective->save();
    				$objective->classes=$objective->classes+$diff;
    				$objective->save();
    				//return response()->json(['obj'=>$objective,'dif'=>$diff]);
    				$objective->classes=$objective->classes+$time;
    				$objective->save();
    				$objective->videoStartTime=Carbon::now()->toDateTimeString();
    				$objective->lastVideoTime=$time;
    				$objective->save();
    				return response()->json(['status'=>'less-Successfull','time'=>$time]);
    				//dd($objective);
    			}
    			if($diff>$objective->lastVideoTime){

    				$objective->classes=$objective->classes+$time;
    				$objective->videoStartTime=Carbon::now()->toDateTimeString();
    				$objective->lastVideoTime=$time;
    				$objective->save();
    			}
    			return response()->json(['status'=>'gre-Successfull','time'=>$time]);
    		}

    	}
    }

    public function estudioTemario(Request $request){
    	$studentId=$request->json('studentId');
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
    	//$time=$request->json('time');
    	//$studentId=1;

    	$action=$request->json('action');
    	//$action="minus";
    	$todayDate=Carbon::now()->toDateString();
    	$exists=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->exists();

    	if($exists==false){

	    	if($action=="plus"){
	    		$objective=new \App\Objective;
	    		$objective->studentId=$studentId;
	    		$objective->estudioTemario=$objective->estudioTemario+30;
	    		$objective->date=$todayDate;
	    		$objective->save();
	    		return response()->json(['status'=>'Successfull']);
	    	}
    	}
    	if($exists==true){
    		$objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();
    		if($action=="plus"){
    			$objective->estudioTemario=$objective->estudioTemario+30;
	    		$objective->save();
	    		return response()->json(['status'=>'Successfull']);
    		}
    		if($action=="minus"){
    			$objective->estudioTemario=$objective->estudioTemario-30;
	    		$objective->save();
	    		return response()->json(['status'=>'Successfull']);
    		}
    	}
    }
    public function repasoTemario(Request $request){
    	$studentId=$request->json('studentId');
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
    	//$time=$request->json('time');
    	//$studentId=1;

    	$action=$request->json('action');
    	//$action="minus";
    	$todayDate=Carbon::now()->toDateString();
    	$exists=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->exists();
    	if($exists==false){

	    	if($action=="plus"){
	    		$objective=new \App\Objective;
	    		$objective->studentId=$studentId;
	    		$objective->repasoTemario=$objective->repasoTemario+10;
	    		$objective->date=$todayDate;
	    		$objective->save();
	    		return response()->json(['status'=>'Successfull']);
	    	}
    	}
    	if($exists==true){
    		$objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();
    		if($action=="plus"){
    			$objective->repasoTemario=$objective->repasoTemario+10;
	    		$objective->save();
	    		return response()->json(['status'=>'Successfull']);
    		}
    		if($action=="minus"){
    			$objective->repasoTemario=$objective->repasoTemario-10;
	    		$objective->save();
	    		return response()->json(['status'=>'Successfull']);
    		}
    	}
    }

    public function getObjectives(Request $request){

    	$studentId=$request->json('studentId');
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
    	//$studentId=1;
    	$todayDate=Carbon::now()->toDateString();
    	$resultArray=array();
    	$exists=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->exists();

        if($exists==false){

            $courses=\App\Course::all();
            foreach($courses as $key=>$course){
                if($course->id==1){
                    $resultArray[$key]['courseName']=$course->name;
                    $resultArray[$key]['Estudio_temario']=0;
                    $resultArray[$key]['Repaso_temario']=0;
                    $resultArray[$key]['Estudio_temario1']=0;
                    $resultArray[$key]['Repaso_temario1']=0;
                    $resultArray[$key]['Audiolibro']=0;
                    $resultArray[$key]['Audiolibro1']=0;
                    $resultArray[$key]['clases']=0;
                    $resultArray[$key]['clases1']=0;
                }
                $exams=\App\Exam::where('courseId',$course->id)->get();
                    $eArray=array();
                    $timeCount=0;
                    $timeCountE=0;
                    if(!empty($exams)){
                        foreach ($exams as $evalue) {
                            array_push($eArray,$evalue->id);
                        }
                    }


                    $res=\App\StudentExamRecord::where('studentId',$studentId)->where('status','end')
                    ->where('isCurrent','yes')->whereIn('examId',$eArray)->get();


                    if(!empty($res)){

                        foreach ($res as $reskey => $resvalue) {
                            $saet=$resvalue->studentAttemptedEndingTime;
                            $da=Carbon::parse($saet)->toDateString();

                            if($todayDate==$da){

                                $ed=$resvalue->examDuration/60;
                                $hoursE=floor($resvalue->examDuration/3600);
                                $hoursE2=$hoursE*60;
                                $em2 = floor(($resvalue->examDuration / 60) % 60)+$hoursE2;
                                $es2=$resvalue->examDuration % 60;
                                $edSec2=$em2*60+$es2;
                                $timeCountE=$timeCountE+$edSec2;
                            }
                        }

                    }

                    $revisionExists=\App\Revision::where('studentId',$studentId)->where('studentType',$u->type)
                    ->where('courseId',$course->id)->where('revisionDate',$todayDate)->exists();


                    if($revisionExists==true){
                        $revision=\App\Revision::where('studentId',$studentId)->where('studentType',$u->type)
                        ->where('courseId',$course->id)->where('revisionDate',$todayDate)->first();
                        $timeCount=$revision->revision+$timeCountE;

                        //end review
                        $hoursT=floor($timeCount/3600);
                        $hoursT2=$hoursT*60;
                        $minutesT2 = floor(($timeCount / 60) % 60)+$hoursT2;
                        $secondsT2 = $timeCount % 60;
                        $minutesTSec2=$minutesT2*60+$secondsT2;
                        $resultArray[$key]['Examen_y_repaso1']=$minutesTSec2;
                        $resultArray[$key]['Examen_y_repaso']=$minutesT2.",".$secondsT2;
                    }
                    if($revisionExists==false){
                        $timeCount=$timeCountE;
                        $hoursT=floor($timeCount/3600);
                        $hoursT2=$hoursT*60;
                        $minutesT2 = floor(($timeCount / 60) % 60)+$hoursT2;
                        $secondsT2 = $timeCount % 60;
                        $minutesTSec2=$minutesT2*60+$secondsT2;
                        $resultArray[$key]['Examen_y_repaso1']=$minutesTSec2;
                        $resultArray[$key]['Examen_y_repaso']=$minutesT2.",".$secondsT2;

                    }

            }
        }
    	if($exists==true){
    		$objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();
    		$courses=\App\Course::all();
    		foreach($courses as $key=>$course){
    			if($course->id==1){

	    			$resultArray[$key]['courseName']=$course->name;
    				if(empty($objective->estudioTemario)){
    					$resultArray[$key]['Estudio_temario']=0;
                        $resultArray[$key]['Estudio_temario1']=0;
    				}
    				if(!empty($objective->estudioTemario)){
    					$resultArray[$key]['Estudio_temario1']=$objective->estudioTemario*60;
                        $resultArray[$key]['Estudio_temario']=$objective->estudioTemario;
    				}
    				if(empty($objective->repasoTemario)){
    					$resultArray[$key]['Repaso_temario']=0;
                        $resultArray[$key]['Repaso_temario1']=0;
    				}
    				if(!empty($objective->repasoTemario)){
    					$resultArray[$key]['Repaso_temario']=$objective->repasoTemario;
                        $resultArray[$key]['Repaso_temario1']=$objective->repasoTemario*60;
    				}
    				if(empty($objective->audios)){
    					$resultArray[$key]['Audiolibro']=0;
                        $resultArray[$key]['Audiolibro1']=0;
    				}
    				if(!empty($objective->audios)){

                        $hoursA=floor($objective->audios/3600);
                        $hoursA1=$hoursA*60;
                        $minutesA = floor(($objective->audios / 60) % 60)+$hoursA1;
                        $secondsA = $objective->audios % 60;
                        $minutesASec=$minutesA*60+$secondsA;
    					//$resultArray[$key]['Audiolibro']=intval($objective->audios/60);
                        $resultArray[$key]['Audiolibro']=$minutesA.",".$secondsA;
                        $resultArray[$key]['Audiolibro1']=$minutesASec;
    				}
    				if(empty($objective->classes)){
    					$resultArray[$key]['clases']=0;
                        $resultArray[$key]['clases1']=0;
    				}
    				if(!empty($objective->classes)){
                        $hoursC=floor($objective->classes/3600);
                        $hoursC1=$hoursC*60;
                        $minutesC = floor(($objective->classes / 60) % 60)+$hoursC1;
                        $secondsC = $objective->classes % 60;
                        $minutesCSec=$minutesC*60+$secondsC;
    					//$resultArray[$key]['clases']=intval($objective->classes/60);
                        $resultArray[$key]['clases']=$minutesC.",".$secondsC;
                        $resultArray[$key]['clases1']=$minutesCSec;
    				}


    			}
    			$exams=\App\Exam::where('courseId',$course->id)->get();
	    			$eArray=array();
	    			$timeCount=0;
                    $timeCountE=0;
	    			if(!empty($exams)){
		    			foreach ($exams as $evalue) {
		    				array_push($eArray,$evalue->id);
		    			}
	    			}


	    			$res=\App\StudentExamRecord::where('studentId',$studentId)->where('status','end')
	    			->where('isCurrent','yes')->whereIn('examId',$eArray)->where('studentAttemptedEndingTime','like',$todayDate.'%')->get();


	    			//dd($res);

	    			if(!empty($res)){

	    				foreach ($res as $reskey => $resvalue) {
	    					$saet=$resvalue->studentAttemptedEndingTime;
	    					$da=Carbon::parse($saet)->toDateString();

	    					if($todayDate==$da){
	    						$ed=$resvalue->examDuration/60;
                                $hoursE=floor($resvalue->examDuration/3600);
                                $hoursE1=$hoursE*60;
                                $em1 = floor(($resvalue->examDuration / 60) % 60)+$hoursE1;
                                $es1=$resvalue->examDuration % 60;
                                $edSec1=$em1*60+$es1;
	    						$timeCount=$timeCount+$edSec1;
	    					}
	    				}

	    			}
                    //review
                    $revisionExists=\App\Revision::where('studentId',$studentId)->where('studentType',$u->type)
                    ->where('courseId',$course->id)->where('revisionDate',$todayDate)->exists();


                    if($revisionExists==true){
                        $revision=\App\Revision::where('studentId',$studentId)->where('studentType',$u->type)
                        ->where('courseId',$course->id)->where('revisionDate',$todayDate)->first();
                        $timeCount=$revision->revision+$timeCountE;

                        //end review
                        $hoursT=floor($timeCount/3600);
                        $hoursT2=$hoursT*60;
                        $minutesT2 = floor(($timeCount / 60) % 60)+$hoursT2;
                        $secondsT2 = $timeCount % 60;
                        $minutesTSec2=$minutesT2*60+$secondsT2;
                        if($course->id==1 && empty($objective->pdfCounter) === false){
                            $hoursPdf=floor($objective->pdfCounter/3600);
                            $hoursPdf1=$hoursPdf*60;
                            $minutesPdf = floor(($objective->pdfCounter / 60) % 60)+$hoursPdf1;
                            $secondsPdf = $objective->pdfCounter % 60;
                            $minutesPdfSec=$minutesPdf*60+$secondsPdf;
                            $resultArray[$key]['Examen_y_repaso1']=($minutesTSec2+$minutesPdfSec);

                            $pdfTotalMInutes = ($minutesTSec2+$minutesPdfSec);
                            $hoursPdf2=floor($pdfTotalMInutes/3600);
                            $hoursPdf3=$hoursPdf2*60;
                            $minutesPdf2 = floor(($pdfTotalMInutes / 60) % 60)+$hoursPdf3;
                            $secondsPdf2 = $pdfTotalMInutes % 60;
                            $resultArray[$key]['Examen_y_repaso']=$minutesPdf2.",".$secondsPdf2;
                        }
                        else{
                            $resultArray[$key]['Examen_y_repaso1']=$minutesTSec2;
                            $resultArray[$key]['Examen_y_repaso']=$minutesT2.",".$secondsT2;
                        }
                    }
                    if($revisionExists==false){
                        $timeCount=$timeCountE;
                        $hoursT=floor($timeCount/3600);
                        $hoursT2=$hoursT*60;
                        $minutesT2 = floor(($timeCount / 60) % 60)+$hoursT2;
                        $secondsT2 = $timeCount % 60;
                        $minutesTSec2=$minutesT2*60+$secondsT2;
                        $resultArray[$key]['Examen_y_repaso1']=$minutesTSec2;
                        $resultArray[$key]['Examen_y_repaso']=$minutesT2.",".$secondsT2;

                    }
    		}
    	}
    	if(!empty($resultArray)){
    		//dd($resultArray);
    		$total=0;
    		foreach ($resultArray as $key => $value) {
    			if($key==0){
    			$total=$value['Estudio_temario1']+$value['Repaso_temario1']+$value['Audiolibro1']+$value['clases1'];
    			}
    			$total=$total+$value['Examen_y_repaso1'];
    		}


    		$per=$total/10800;
    		$percentage=intval($per*100);
    		if($percentage>=100){
    			$percentage2=100;
    		}
    		if($percentage<100){
    			$percentage2=$percentage;
    		}
            //if($percentage>100){
            //    $percentage=100;
            //}
            //$hours = floor($total / 60);
            //$minutes = ($total % 60);
            //$hours=intval($hours);
            //$total=$total*60;
            $hours=floor($total/3600);
            $minutes = floor(($total / 60) % 60);
    		//$ti=number_format($total/60,2);
            $ti=$hours.",".$minutes;
    		//return response()->json(['1'=>$ti,'2'=>$total]);
    		$tiTotal=3;



    	}
    	if(empty($resultArray)){
    		$courses=\App\Course::all();
    		foreach($courses as $key=>$course){
    			if($course->id==1){
    				$resultArray[$key]['courseName']=$course->name;
	    			$resultArray[$key]['Estudio_temario']=0;
	    			$resultArray[$key]['Repaso_temario']=0;
	    			$resultArray[$key]['Audiolibro']=0;
	    			$resultArray[$key]['clases']=0;
	    		}
	    		$resultArray[$key]['Examen_y_repaso']=0;

    		}
    	}
    	if(empty($resultArray)){
    		$percentage=0;
    		$percentage2=0;
    		$ti=0;
    		$tiTotal=3;
    	}
    	return response()->json(['status'=>'Successfull','data'=>$resultArray,'percentage'=>$percentage,'percentage2'=>$percentage2,'ti'=>$ti,'tTotal'=>$tiTotal]);
    }

    public function getObjectivesDb(Request $request){
        $studentId=$request->json('studentId');
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
    	$data=\App\Objective::where('studentId',$request->json('studentId'))->get();
    	$todayDate=Carbon::now()->toDateString();
    	return response()->json(['todayDate'=>$todayDate,'data'=>$data]);
    }
     public function deleteObjectivesDb(Request $request){
        $studentId=$request->json('studentId');
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
     	$todayDate=Carbon::now()->toDateString();
    	$data1=\App\Objective::where('studentId',$request->json('studentId'))->where('date',$todayDate)->first();
    	$data1->delete();
    	$data=\App\Objective::where('studentId',$request->json('studentId'))->get();
    	return response()->json(['todayDate'=>$todayDate,'data'=>$data]);
    }
    public function objectiveRanking(Request $request){
        $studentId=$request->json('studentId');

        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $student=\App\User::find($studentId);
        if(!empty($student)){
            //$studentId=1;
            //Weekly
            $exists1=\App\Objective::where('studentId',$studentId)
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->exists();
            $exams=\App\Exam::whereIn('courseId',[1,2,3,4])->get();
            $eArray=array();
            if(!empty($exams)){
                foreach ($exams as $evalue) {
                    array_push($eArray,$evalue->id);
                }
            }
            $exists2=\App\StudentExamRecord::where('studentId',$studentId)->where('status','end')
                    ->where('isCurrent','yes')->whereIn('examId',$eArray)
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->exists();

                    $studentTotalTime=0;
            if($exists1==true){
                $studentObjectives=\App\Objective::where('studentId',$studentId)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();


                foreach ($studentObjectives as $key => $value) {

                    if(!empty($value->estudioTemario)){
                        $studentTotalTime=$studentTotalTime+$value->estudioTemario*60;
                    }
                    if(!empty($value->repasoTemario)){
                        $studentTotalTime=$studentTotalTime+$value->repasoTemario*60;
                    }
                    if(!empty($value->audios)){
                        $hoursA=floor($value->audios/3600);
                        $hoursA1=$hoursA*60;
                        $a1 = floor(($value->audios / 60) % 60)+$hoursA1;
                        $as1=$value->audios % 60;
                        $a1Sec=$a1*60+$as1;
                        //$a1=floor(($value->audios / 60) % 60);
                        $studentTotalTime=$studentTotalTime+$a1Sec;
                    }
                    if(!empty($value->classes)){
                        $hoursM=floor($value->classes/3600);
                        $hoursM1=$hoursM*60;
                        $c1 = floor(($value->classes / 60) % 60)+$hoursM1;
                        $cs1=$value->classes % 60;
                        $c1Sec=$c1*60+$cs1;
                        //$c1=floor(($value->classes / 60) % 60);
                        $studentTotalTime=$studentTotalTime+$c1Sec;
                    }

                }

            }
            if($exists2==true){

                $timeCount=0;
                $res=\App\StudentExamRecord::where('studentId',$studentId)->where('status','end')
                    ->where('isCurrent','yes')->whereIn('examId',$eArray)
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                   ->get();


                foreach($res as $reskey=>$resvalue){
                    $ed=$resvalue->examDuration/60;
                    $hoursE=floor($resvalue->examDuration/3600);
                    $hoursE4=$hoursE*60;
                    $em = floor(($resvalue->examDuration / 60) % 60)+$hoursE4;
                    $es=$resvalue->examDuration % 60;
                    $edSec=$em*60+$es;
                    $timeCount=$timeCount+$edSec;
                }

                $studentTotalTime=$studentTotalTime+$timeCount;
            }

            $allStudents=\App\User::where('role','student')->where('type',$student->type)->get();
            $scoresArray=array();
            foreach ($allStudents as $askey => $asvalue) {
                $uu=\App\User::find($asvalue->id);
                if(!empty($uu)){

                    $exists3=\App\Objective::where('studentId',$asvalue->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->exists();
                        $allStudentTotalTime=0;
                    if($exists3==true){
                        $allStudentObjectives=\App\Objective::where('studentId',$asvalue->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();


                        foreach ($allStudentObjectives as $key => $value) {
                            if(!empty($value->estudioTemario)){
                                $allStudentTotalTime=$allStudentTotalTime+$value->estudioTemario*60;
                            }
                            if(!empty($value->repasoTemario)){
                                $allStudentTotalTime=$allStudentTotalTime+$value->repasoTemario*60;
                            }
                            if(!empty($value->audios)){
                                $hoursB=floor($value->audios/3600);
                                $hoursB1=$hoursB*60;
                                $a2 = floor(($value->audios / 60) % 60)+$hoursB1;
                                $as2=$value->audios % 60;
                                $a2Sec=$a2*60+$as2;
                                //$a2=floor(($value->audios / 60) % 60);
                                $allStudentTotalTime=$allStudentTotalTime+$a2Sec;
                            }

                            if(!empty($value->classes)){
                                $hoursN=floor($value->classes/3600);
                                $hoursN1=$hoursN*60;
                                $c2 = floor(($value->classes / 60) % 60)+$hoursN1;
                                $cs2=$value->classes % 60;
                                $c2Sec=$c2*60+$cs2;
                                //$c2=floor(($value->classes / 60) % 60);
                                $allStudentTotalTime=$allStudentTotalTime+$c2Sec;

                            }
                        }

                    }

                    $exists4=\App\StudentExamRecord::where('studentId',$asvalue->id)->where('status','end')
                            ->where('isCurrent','yes')->whereIn('examId',$eArray)
                            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                            ->exists();


                    if($exists4==true){
                        $allTimeCount=0;
                        $allRes=\App\StudentExamRecord::where('studentId',$asvalue->id)->where('status','end')
                            ->where('isCurrent','yes')->whereIn('examId',$eArray)
                            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                           ->get();

                        foreach($allRes as $reskey=>$resvalue){
                            $ed=$resvalue->examDuration/60;
                            $hoursE=floor($resvalue->examDuration/3600);
                            $hoursE2=$hoursE*60;
                            $em = floor(($resvalue->examDuration / 60) % 60)+$hoursE2;
                            $es=$resvalue->examDuration % 60;
                            $edSec=$em*60+$es;
                            $allTimeCount=$allTimeCount+$edSec;
                        }

                        $allStudentTotalTime=$allStudentTotalTime+$allTimeCount;
                    }

                    if(!empty($allStudentTotalTime)){
                        array_push($scoresArray,$allStudentTotalTime);
                    }
                }

            }
            if(!empty($scoresArray)){
                $uniqueScores=array_unique($scoresArray);

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



                        if($unique==$studentTotalTime){
                            //return response()->json($studentTotalTime);
                            $weeklyRankPercentage=intval($per);
                            //$hours = floor($unique / 60);
                            //$minutes = ($unique % 60);
                            //$hours=intval($hours);
                            //$studentWeeklyTime=$hours.",".$minutes;
                            //return response()->json($studentTotalTime);
                            $ss=$studentTotalTime;
                            $hours = floor($ss / 3600);
                            $minutes = floor(($ss / 60) % 60);
                            $studentWeeklyTime=$hours.",".$minutes;


                            //$sWT=$studentTotalTime/1080;
                            $sWT=$studentTotalTime/64800;

                            $studentWeeklyPercentage=intval($sWT*100);
                        }

                    }
                    //dd($weeklyRankPercentage,$studentWeeklyTime,$studentWeeklyPercentage);
            }
            //end Weekly

            //Yearly
            $exists1a=\App\Objective::where('studentId',$studentId)
                ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
                ->exists();
            $exams=\App\Exam::whereIn('courseId',[1,2,3,4])->get();
            $eArray=array();
            if(!empty($exams)){
                foreach ($exams as $evalue) {
                    array_push($eArray,$evalue->id);
                }
            }
            $exists2a=\App\StudentExamRecord::where('studentId',$studentId)->where('status','end')
                    ->where('isCurrent','yes')->whereIn('examId',$eArray)
                    ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
                    ->exists();
                $studentTotalTime=0;
            if($exists1a==true){
                $studentObjectives=\App\Objective::where('studentId',$studentId)->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get();


                foreach ($studentObjectives as $key => $value) {

                    if(!empty($value->estudioTemario)){
                        $studentTotalTime=$studentTotalTime+$value->estudioTemario*60;
                    }
                    if(!empty($value->repasoTemario)){
                        $studentTotalTime=$studentTotalTime+$value->repasoTemario*60;
                    }
                    if(!empty($value->audios)){
                        $hoursC=floor($value->audios/3600);
                        $hoursC1=$hoursC*60;
                        $a3 = floor(($value->audios / 60) % 60)+$hoursC1;
                        $as3=$value->audios % 60;
                        $a3Sec=$a3*60+$as3;
                        //$a3=floor(($value->audios / 60) % 60);
                        $studentTotalTime=$studentTotalTime+$a3Sec;
                    }
                    if(!empty($value->classes)){
                        $hoursO=floor($value->classes/3600);
                        $hoursO1=$hoursO*60;
                        $c3 = floor(($value->classes / 60) % 60)+$hoursO1;
                        $cs3=$value->classes % 60;
                        $c3Sec=$c3*60+$cs3;
                        //$c3=floor(($value->classes / 60) % 60);
                        $studentTotalTime=$studentTotalTime+$c3Sec;
                    }
                }
            }
            if($exists2a==true){

                $timeCount=0;
                $res=\App\StudentExamRecord::where('studentId',$studentId)->where('status','end')
                    ->where('isCurrent','yes')->whereIn('examId',$eArray)
                    ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
                   ->get();


                foreach($res as $reskey=>$resvalue){
                    $ed=$resvalue->examDuration/60;
                    $hoursE=floor($resvalue->examDuration/3600);
                    $hoursE2=$hoursE*60;
                    $em = floor(($resvalue->examDuration / 60) % 60)+$hoursE2;
                    $es=$resvalue->examDuration % 60;
                    $edSec=$em*60+$es;
                    $timeCount=$timeCount+$edSec;
                }

                $studentTotalTime=$studentTotalTime+$timeCount;
            }
            $allStudents=\App\User::where('role','student')->where('type',$student->type)->get();
            $scoresArray=array();
            foreach ($allStudents as $askey => $asvalue) {
                $uu2=\App\User::find($asvalue->id);
                    if(!empty($uu2)){
                    $exists3a=\App\Objective::where('studentId',$asvalue->id)->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->exists();

                    if($exists3a==true){
                        $allStudentObjectives=\App\Objective::where('studentId',$asvalue->id)->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get();

                        $allStudentTotalTime=0;
                        foreach ($allStudentObjectives as $key => $value) {
                            if(!empty($value->estudioTemario)){
                                $allStudentTotalTime=$allStudentTotalTime+$value->estudioTemario*60;
                            }
                            if(!empty($value->repasoTemario)){
                                $allStudentTotalTime=$allStudentTotalTime+$value->repasoTemario*60;
                            }
                            if(!empty($value->audios)){
                                $hoursD=floor($value->audios/3600);
                                $hoursD1=$hoursD*60;
                                $a4 = floor(($value->audios / 60) % 60)+$hoursD1;
                                $as4=$value->audios % 60;
                                $a4Sec=$a4*60+$as4;
                                //$a4=floor(($value->audios / 60) % 60);
                                $allStudentTotalTime=$allStudentTotalTime+$a4Sec;
                            }

                            if(!empty($value->classes)){
                                $hoursP=floor($value->classes/3600);
                                $hoursP1=$hoursP*60;
                                $c4 = floor(($value->classes / 60) % 60)+$hoursP1;
                                $cs4=$value->classes % 60;
                                $c4Sec=$c4*60+$cs4;
                                //$c4=floor(($value->classes / 60) % 60);
                                $allStudentTotalTime=$allStudentTotalTime+$c4Sec;

                            }
                        }

                    }

                    $exists4a=\App\StudentExamRecord::where('studentId',$asvalue->id)->where('status','end')
                            ->where('isCurrent','yes')->whereIn('examId',$eArray)
                            ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
                            ->exists();


                    if($exists4a==true){
                        $allTimeCount=0;
                        $allRes=\App\StudentExamRecord::where('studentId',$asvalue->id)->where('status','end')
                            ->where('isCurrent','yes')->whereIn('examId',$eArray)
                            ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
                           ->get();

                        foreach($allRes as $reskey=>$resvalue){
                            $ed=$resvalue->examDuration;
                            $hoursE=floor($resvalue->examDuration/3600);
                            $hoursE1=$hoursE*60;
                            $em = floor(($resvalue->examDuration / 60) % 60)+$hoursE1;
                            $es=$resvalue->examDuration % 60;
                            $edSec=$em*60+$es;
                            $allTimeCount=$allTimeCount+$edSec;
                        }

                        $allStudentTotalTime=$allStudentTotalTime+$allTimeCount;
                    }

                    if(!empty($allStudentTotalTime)){
                        array_push($scoresArray,$allStudentTotalTime);
                    }
                }

            }
            if(!empty($scoresArray)){
                $uniqueScores=array_unique($scoresArray);

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

                        if($unique==$studentTotalTime){

                            $yearlyRankPercentage=intval($per);
                            //$hours = floor($unique / 60);
                            //$minutes = ($unique % 60);
                            //$hours=intval($hours);
                            //$studentYearlyTime=$hours.",".$minutes;
                            $ss=$studentTotalTime;
                            $hours = floor($ss / 3600);
                            $minutes = floor(($ss / 60) % 60);
                            $studentYearlyTime=$hours.",".$minutes;

                            $sYT=$studentTotalTime/2520000;
                            $studentYearlyPercentage=intval($sYT*100);
                        }

                    }
                    //dd($YearlyRankPercentage,$studentYearlyTime,$studentYearlyPercentage);
            }
        }

        if(empty($yearlyRankPercentage)){
            $yearlyRankPercentage=0;
        }
        if(empty($studentYearlyTime)){
            $studentYearlyTime=0;
        }
        if(empty($studentYearlyPercentage)){
            $studentYearlyPercentage=0;
        }
        if(empty($weeklyRankPercentage)){
            $weeklyRankPercentage=0;
        }
        if(empty($studentWeeklyTime)){
            $studentWeeklyTime=0;
        }
        if(empty($studentWeeklyPercentage)){
            $studentWeeklyPercentage=0;
        }
        $regex=\App\Register::where('userId',$student->id)->exists();
                    if($regex==true){
                    $reg=\App\Register::where('userId',$student->id)->first();
                    $userName=$reg->surname;
                    }
                    if(empty($userName)){
                        $userName=null;
                    }
                    $con=\App\User::where('type',$student->type)->count();
        return response()->json(['status'=>'Successfull','studentWeeklyPercentage'=>$studentWeeklyPercentage,'studentWeeklyTime'=>$studentWeeklyTime,'studentYearlyPercentage'=>$studentYearlyPercentage,'studentYearlyTime'=>$studentYearlyTime,'weeklyRankPercentage'=>$weeklyRankPercentage,'yearlyRankPercentage'=>$yearlyRankPercentage,'username'=>$userName,'numberOfStudents'=>$con]);

        //end Yearly
    }

    public function pdfCounter(Request $request){
        $state=$request->json('state');
        //$state="kill";
        $studentId=$request->json('studentId');
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        //$studentId=1;
        $todayDate=Carbon::now()->toDateString();

        $exists=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->exists();

        if($exists==false){
            if($state=="start"){

                $objective=new \App\Objective;
                $objective->studentId=$studentId;
                $objective->statePdf="start";
                $objective->date=$todayDate;
                $objective->pdfStartTime=Carbon::now()->toDateTimeString();
                $objective->save();
                return response()->json(['status'=>'Successfull','message'=>'start']);
            }
        }


        if($exists==true){

            if($state=="start"){

                $objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();

                $current=Carbon::now()->toDateTimeString();

                if(!empty($objective->statePdf)){

                    if($objective->statePdf=="start"){

                        $start=$objective->pdfStartTime;
                        $diff=Carbon::parse($start)->diffInSeconds(Carbon::parse($current));

                        $objective->pdfCounter=$objective->pdfCounter+$diff;
                        $objective->pdfStartTime=Carbon::now()->toDateTimeString();
                        $objective->save();
                        return response()->json(['status'=>'Successfull','message'=>'start']);
                    }
                    if($objective->statePdf=="end"){
                        $objective->statePdf="start";
                        $objective->pdfStartTime=Carbon::now()->toDateTimeString();
                        $objective->save();
                        return response()->json(['status'=>'Successfull','message'=>'started']);
                    }

                }
                if(empty($objective->statePdf)){

                    $objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();
                    //$objective->studentId=$studentId;
                    $objective->statePdf="start";
                    //$objective->date=$todayDate;
                    $objective->pdfStartTime=Carbon::now()->toDateTimeString();
                    $objective->save();
                    return response()->json(['status'=>'Successfull','message'=>'start']);
                }

            }
            if($state=="end"){
                $objective=\App\Objective::where('date',$todayDate)->where('studentId',$studentId)->first();
                $current=Carbon::now()->toDateTimeString();
                if($objective->statePdf=="end"){
                    return response()->json(['status'=>'Successfull','message'=>'end']);
                }
                if($objective->statePdf=="start"){
                    $start=$objective->pdfStartTime;
                }

                //$start=$objective->audioStartTime;
                $diff=Carbon::parse($start)->diffInSeconds(Carbon::parse($current));
                $objective->pdfCounter=$objective->pdfCounter+$diff;
                $objective->statePdf="end";
                $objective->pdfEndTime=Carbon::now()->toDateTimeString();
                $objective->save();
                return response()->json(['status'=>'Successfull','message'=>'end']);
            }
        }
    }
}
