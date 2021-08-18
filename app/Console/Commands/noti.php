<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Spatie\DbDumper\Databases\MySql;
class noti extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
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
        
        $studentExamsRecords=\App\StudentExamRecord::where('status','started')->get();

        foreach ($studentExamsRecords as $key => $value) {
            $exam=\App\Exam::find($value->examId);
            $officialEndingTime=$value->officialEndingTime;
            $current=Carbon::now()->toDateTimeString();

            if(Carbon::parse($current)->gte(Carbon::parse($officialEndingTime))){
               
                $value->studentAttemptedEndingTime=Carbon::now()->toDateTimeString();
                $value->examDuration=$exam->timeFrom;
                $value->status="end";
                $value->endingWay="programmatically";
                $value->save();

            }

        }
    }
}
