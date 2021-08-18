<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RankingController extends Controller
{
    public function getTopicCourseVerticalRanking(Request $request)
    {

        $studentId = $request->json('studentId');
        //$studentId=4;
        $ue = \App\User::where('id', $studentId)->exists();
        if ($ue == false) {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $u = \App\User::find($studentId);
        if ($u->field1x == "Bloquear") {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $student = \App\User::find($studentId);
        $folders = \App\Folder::where('type', 'exams')->where('studentType', $student->type)->get();

        $resultArray = array();
        $courseKnow = \App\Course::where('name', 'Psicotécnicos')->first();
        $cik = $courseKnow->id;
        $courseKnow2 = \App\Course::where('name', 'Inglés')->first();
        $cik2 = $courseKnow2->id;
        $courseKnowO = \App\Course::where('name', 'Ortografía')->first();
        $cikO = $courseKnowO->id;
        foreach ($folders as $folderkey => $folder) {
            //course with topic
            $courses = \App\Course::all();
            $coursesA = array();

            foreach ($courses as $coursekey => $course) {


                $studentCombineResult = \App\CombineResult::where('folderId', $folder->id)->where('courseId', $course->id)
                    ->where('studentId', $studentId)->first();
                if (empty($studentCombineResult)) {
                    $course->setAttribute('rankName', "Ranking de $course->name");
                    $course->setAttribute('percentage', 'null');
                    $course->setAttribute('points', 'null');
                    $course->setAttribute('totalPoints', 'null');
                }


                if (!empty($studentCombineResult)) {
                    if ($course->name == "Psicotécnicos") {
                        $f = 1;
                    }
                    if ($course->name == "Inglés") {
                        $f = 2;
                    }
                    if ($course->name == "Ortografía") {
                        $f = 4;
                    }
                    if ($course->name == "Conocimientos") {
                        $f = 4;
                    }
                    if ($studentCombineResult->field1x != $f) {
                        $course->setAttribute('rankName', "Ranking de $course->name");
                        $course->setAttribute('percentage', 'null');
                        $course->setAttribute('points', 'null');
                        $course->setAttribute('totalPoints', 'null');
                    }
                    if ($studentCombineResult->field1x == $f) {
                        $combineResults = \App\CombineResult::where('folderId', $folder->id)->where('courseId', $course->id)
                            ->orderByRaw("CAST(points AS SIGNED) ASC")->get();
                        $allScores = array();
                        foreach ($combineResults as $combinekey => $combine) {
                            $um = \App\User::find($combine->studentId);
                            if (!empty($um)) {
                                array_push($allScores, $combine->points);
                            }
                        }
                        $uniqueScores = array_unique($allScores);
                        sort($uniqueScores);
                        $highestKey = count($uniqueScores) - 1;
                        $percentages = array();
                        foreach ($uniqueScores as $uniquekey => $unique) {

                            if ($highestKey == 0) {
                                $per = 100;
                            }
                            if ($highestKey != 0) {
                                $per = $uniquekey / $highestKey * 100;
                            }

                            array_push($percentages, $per);

                            if ($unique == $studentCombineResult->points) {

                                $course->setAttribute('rankName', "Ranking de $course->name");
                                $course->setAttribute('percentage', intval($per));
                                if ($course->name == "Inglés") {
                                    $divC = \App\CombineResult::where('folderId', $folder->id)->where('courseId', $course->id)->where('studentId', $studentId)->first();
                                    $div = $divC->field1x;
                                    if ($div < 1) {
                                        $div = 1;
                                    }
                                    $course->setAttribute('points', round($unique, 2) / $div);
                                    $course->setAttribute('totalPoints', $studentCombineResult->totalPoints / $div);
                                }
                                if ($course->name != "Inglés") {
                                    $course->setAttribute('points', round($unique, 2));
                                    if ($course->name == "Psicotécnicos") {
                                        $course->setAttribute('totalPoints', 30);
                                    }
                                    if ($course->name != "Psicotécnicos") {
                                        $course->setAttribute('totalPoints', $studentCombineResult->totalPoints);
                                    }

                                }

                            }
                        }
                    }
                }

            }

            $cA = $courses->toArray();
            $resultArray[$folderkey]['folderName'] = $folder->name;
            $resultArray[$folderkey]['courses'] = $cA;
            //end course with topic
            $withSum = 0;
            $withSumTotal = 0;
            $withoutSum = 0;

            if (!empty($cA)) {
                $withoutSum = 0;
                foreach ($cA as $key => $value) {
                    if ($value['points'] != 'null' && $value['rankName'] != "Ranking de Ortografía") {
                        $withoutSum = $withoutSum + $value['points'];
                        $withSumTotal = $withSumTotal + $value['totalPoints'];
                    }
                }
                $withSum = $withoutSum + (int)$student->baremo;
            }

            //start only topic without baremo
            $exists1 = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)->where('courseId', '!=', $cikO)->exists();

            if ($exists1 == false) {
                $withoutArray = array();
                $withoutArray['rankName'] = "Rank. $folder->name sin baremo";
                $withoutArray['percentage'] = null;
                $withoutArray['points'] = null;
                $withoutArray['totalPoints'] = null;
                $resultArray[$folderkey]['withoutBaremo'] = $withoutArray;

                $withArray = array();
                $withArray['rankName'] = "Rank. $folder->name con baremo";
                $withArray['percentage'] = null;
                $withArray['points'] = null;
                $withArray['totalPoints'] = null;
                $resultArray[$folderkey]['withBaremo'] = $withArray;

            }
            if ($exists1 == true) {
                $courseKnow = \App\Course::where('name', 'Psicotécnicos')->first();
                $cik = $courseKnow->id;
                $courseKnow2 = \App\Course::where('name', 'Inglés')->first();
                $cik2 = $courseKnow2->id;

                $studentAllTopics = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)->where('courseId', '!=', $cikO)->get();

                $studentAllTopicsScore = 0;
                $studentAllTopicsScoreTotal = 0;
                foreach ($studentAllTopics as $studentalltopickey => $value) {
                    if ($value->courseId != $cik2) {
                        $studentAllTopicsScore = $studentAllTopicsScore + $value->points;
                    }
                }

                //start ing
                $ingCE = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)
                    ->where('courseId', $cik2)->exists();

                if ($ingCE == true) {
                    $ingC = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)
                        ->where('courseId', $cik2)->get();
                    $divIng = 0;
                    $ingTotal = 0;

                    foreach ($ingC as $key => $ingV) {
                        $divIng = $divIng + $ingV->field1x;
                        $ingTotal = $ingTotal + $ingV->points;
                    }
                    if ($divIng < 1) {
                        $divIng = 1;
                    }
                    $ingP = $ingTotal / $divIng;
                    $studentAllTopicsScore = $studentAllTopicsScore + $ingP;

                }
                //end ing


                foreach ($studentAllTopics as $studentalltopickey => $value) {
                    if ($value->courseId != $cik2) {
                        $studentAllTopicsScoreTotal = $studentAllTopicsScoreTotal + $value->totalPoints;
                    }
                }

                if ($ingCE == true) {
                    $studentAllTopicsScoreTotal = $studentAllTopicsScoreTotal + 20;
                }

                $allStudents = \App\CombineResult::where('folderId', $folder->id)->select('studentId')->distinct()->get();

                $allStudentsIds = array();
                foreach ($allStudents as $askey => $allStudent) {
                    $um2 = \App\User::find($allStudent->studentId);
                    if (!empty($um2)) {
                        array_push($allStudentsIds, $allStudent->studentId);
                    }
                }

                $scoresWithoutBaremo = array();
                foreach ($allStudentsIds as $asidkey => $allStudentId) {

                    $allResults = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $allStudentId)->where('courseId', '!=', $cikO)->get();
                    $allResultsScores = 0;
                    foreach ($allResults as $allresultkey => $allResult) {
                        if ($allResult->courseId != $cik2) {
                            $allResultsScores = $allResultsScores + $allResult->points;
                        }
                    }

                    //start ing
                    $ingEE = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $allStudentId)
                        ->where('courseId', $cik2)->exists();
                    if ($ingEE == true) {
                        $ingE = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $allStudentId)
                            ->where('courseId', $cik2)->get();

                        $ingS = 0;
                        $ingSD = 0;
                        foreach ($ingE as $key => $value) {
                            $ingS = $ingS + $value->points;
                            $ingSD = $ingSD + $value->field1x;
                        }
                        if ($ingSD < 1) {
                            $ingSD = 1;
                        }
                        $ing = $ingS / $ingSD;
                        $allResultsScores = $allResultsScores + $ing;
                    }
                    //end ing

                    array_push($scoresWithoutBaremo, $allResultsScores);
                }


                $uniqueScoresWithoutBaremo = array_unique($scoresWithoutBaremo);
                sort($uniqueScoresWithoutBaremo);

                $highestKeyWithoutBaremo = count($uniqueScoresWithoutBaremo) - 1;
                $percentagesWithoutBaremo = array();

                foreach ($uniqueScoresWithoutBaremo as $oswbkey => $oswbvalue) {

                    if ($highestKeyWithoutBaremo == 0) {
                        $perWithoutBaremo = 100;
                    }
                    if ($highestKeyWithoutBaremo != 0) {
                        $perWithoutBaremo = $oswbkey / $highestKeyWithoutBaremo * 100;
                    }
                    array_push($percentagesWithoutBaremo, $perWithoutBaremo);
                    if ($oswbvalue == $studentAllTopicsScore) {

                        $withoutArray = array();
                        $withoutArray['rankName'] = "Rank. $folder->name sin baremo";
                        $withoutArray['percentage'] = intval($perWithoutBaremo);
                        //$withoutArray['points']=round($studentAllTopicsScore,2);
                        $withoutArray['points'] = round($withoutSum, 2);
                        //$withoutArray['totalPoints']=$studentAllTopicsScoreTotal;
                        $withoutArray['totalPoints'] = $withSumTotal;
                        $resultArray[$folderkey]['withoutBaremo'] = $withoutArray;

                    }
                }


                //end only topic without baremo
                //start only topic with baremo
                $studentAllTopics2 = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)->where('courseId', '!=', $cikO)->get();

                if (!empty($studentAllTopics2)) {
                    $studentAllTopicsScore2 = 0;
                    $studentAllTopicsScore2Total = 0;
                    foreach ($studentAllTopics2 as $studentalltopickey => $value) {
                        if ($value->courseId != $cik2) {
                            $studentAllTopicsScore2 = $studentAllTopicsScore2 + $value->points;
                        }
                    }

                    //start ing
                    $ingC2E = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)
                        ->where('courseId', $cik2)->exists();
                    if ($ingC2E == true) {
                        $ingC2 = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)
                            ->where('courseId', $cik2)->get();
                        $divIng2 = 0;
                        $ingTotal2 = 0;
                        foreach ($ingC2 as $key => $ingV) {
                            $divIng2 = $divIng2 + $ingV->field1x;
                            $ingTotal2 = $ingTotal2 + $ingV->points;
                        }
                        if ($divIng2 < 1) {
                            $divIng2 = 1;
                        }
                        $ingP2 = $ingTotal2 / $divIng2;
                        $studentAllTopicsScore2 = $studentAllTopicsScore2 + $ingP2;

                    }
                    //end ing
                    foreach ($studentAllTopics2 as $studentalltopickey => $value) {
                        if ($value->courseId != $cik2) {
                            $studentAllTopicsScore2Total = $studentAllTopicsScore2Total + $value->totalPoints;
                        }
                    }

                    if ($ingC2E == true) {
                        $studentAllTopicsScore2Total = $studentAllTopicsScore2Total + 20;
                    }

                    if (!empty($student->baremo)) {
                        $studentAllTopicsScore2 = $studentAllTopicsScore2 + (int)$student->baremo;
                    }


                    $allStudents = \App\CombineResult::where('folderId', $folder->id)->select('studentId')->distinct()->get();
                    $scoresWithBaremo = array();
                    foreach ($allStudents as $askey => $allStudent) {
                        $studentB = \App\User::find($allStudent->studentId);
                        if (!empty($studentB)) {
                            $allResults2 = \App\CombineResult::where('folderId', $folder->id)
                                ->where('studentId', $allStudent->studentId)->where('courseId', '!=', $cikO)->get();
                            $allResultsScores2 = 0;
                            foreach ($allResults2 as $allresultkey => $allResult2) {
                                if ($allResult2->courseId != $cik2) {
                                    $allResultsScores2 = $allResultsScores2 + $allResult2->points;
                                }
                            }


                            //start ing
                            $ingE2E = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $allStudent->studentId)
                                ->where('courseId', $cik2)->exists();
                            if ($ingE2E == true) {
                                $ingE2 = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $allStudent->studentId)
                                    ->where('courseId', $cik2)->get();
                                $ingS2 = 0;
                                $ingSD2 = 0;
                                foreach ($ingE2 as $key => $value) {
                                    $ingS2 = $ingS2 + $value->points;
                                    $ingSD2 = $ingSD2 + $value->field1x;
                                }
                                if ($ingSD2 < 1) {
                                    $ingSD2 = 1;
                                }
                                $ing2 = $ingS2 / $ingSD2;
                                $allResultsScores2 = $allResultsScores2 + $ing2;
                            }
                            //end ing
                            if (!empty($studentB->baremo)) {
                                $allResultsScores2 = $allResultsScores2 + (int)$studentB->baremo;
                            }
                            array_push($scoresWithBaremo, $allResultsScores2);
                        }
                    }

                    $uniqueScoresWithBaremo = array_unique($scoresWithBaremo);
                    sort($uniqueScoresWithBaremo);
                    $highestKeyWithBaremo = count($uniqueScoresWithBaremo) - 1;
                    $percentagesWithBaremo = array();


                    foreach ($uniqueScoresWithBaremo as $oswbkey => $oswbvalue) {

                        if ($highestKeyWithBaremo == 0) {
                            $perWithBaremo = 100;
                        }
                        if ($highestKeyWithBaremo != 0) {
                            $perWithBaremo = $oswbkey / $highestKeyWithBaremo * 100;
                        }
                        array_push($percentagesWithBaremo, $perWithBaremo);
                        if ($oswbvalue == $studentAllTopicsScore2) {

                            $withArray = array();
                            $withArray['rankName'] = "Rank. $folder->name con baremo";
                            $withArray['percentage'] = intval($perWithBaremo);
                            //$withArray['points']=round($studentAllTopicsScore2,2);
                            $withArray['points'] = round($withSum, 2);
                            //$withArray['totalPoints']=$studentAllTopicsScore2Total;
                            $withArray['totalPoints'] = $withSumTotal;
                            $resultArray[$folderkey]['withBaremo'] = $withArray;


                        }
                    }

                }
            }

            //end only topic with baremo

        }
        return response()->json(['status' => 'Successfull', 'data' => $resultArray]);

    }

    public function geT(Request $request)
    {

        $folders = \App\Folder::where('type', 'exams')->get();
        $courses = \App\Course::all();
        foreach ($folders as $keyF => $folder) {
            foreach ($courses as $keyC => $course) {
                $courseName = $course->name;
                $exams = \App\Exam::where('courseId', $course->id)->get();
                $examIds = array();
                foreach ($exams as $keyE => $exam) {
                    array_push($examIds, $exam->id);
                }
                $uniqueStudentsExams = \App\StudentExamRecord::whereIn('examId', $examIds)->select('studentId')->distinct()->get();
                $studentIds = array();
                foreach ($uniqueStudentsExams as $keyU => $use) {
                    array_push($studentIds, $use->studentId);
                }
                $marks = array();
                foreach ($studentIds as $keyS => $sId) {
                    $studentExamRecords = \App\StudentExamRecord::whereIn('examId', $examIds)->where('studentId', $sId)->where('isCurrent', 'yes')->get();
                    $mCount = 0;
                    foreach ($studentExamRecord as $keySER => $ser) {
                        $mCount = $mCount + $ser->score;
                    }
                    array_push($marks, $mCount);
                }
            }
        }

    }

    public function getCourseVerticalRanking(Request $request)
    {

        $studentId = $request->json('studentId');
        //$studentId=4;
        $ue = \App\User::where('id', $studentId)->exists();
        if ($ue == false) {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $u = \App\User::find($studentId);
        if ($u->field1x == "Bloquear") {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $student = \App\User::find($studentId);
        $studentType = $student->type;
        $folders = \App\Folder::where('type', 'exams')->where('studentType', $studentType)->get();
        $fa = array();
        foreach ($folders as $fkey => $fvalue) {
            array_push($fa, $fvalue->id);
        }

        $coursesArray = array();
        $eex = \App\CombineResult::where('studentId', $studentId)->whereIn('folderId', $fa)->exists();
        if ($eex == false) {
            $cc = array();
            $cc['rankName'] = "Curso completado";
            $cc['percentage'] = null;
            $cc['points'] = null;
            //$resultArray['completado']=$cc;
            array_push($coursesArray, $cc);
        }
        if ($eex == true) {
            $cs = \App\CombineResult::where('studentId', $studentId)->whereIn('folderId', $fa)->get();
            $to = 0;
            foreach ($cs as $k => $v) {
                $to = $to + $v->field1x;
            }
            $pt = $to * 0.3367;

            $cc = array();
            $cc['rankName'] = "Curso completado";
            $cc['percentage'] = number_format($pt, 2);
            $cc['points'] = null;
            //$resultArray['completado']=$cc;
            array_push($coursesArray, $cc);
        }
        $courses = \App\Course::all();


        $courseKnow = \App\Course::where('name', 'Psicotécnicos')->first();
        $cik = $courseKnow->id;
        $courseKnowO = \App\Course::where('name', 'Ortografía')->first();
        $cikO = $courseKnowO->id;
        $m = null;
        $s = null;


        foreach ($courses as $coursekey => $value) {
            $courseName = $value->name;

            if ($courseName == "Psicotécnicos") {
                $fs = 1;
            }
            if ($courseName == "Inglés") {
                $fs = 2;
            }
            if ($courseName == "Ortografía") {
                $fs = 4;
            }
            if ($courseName == "Conocimientos") {
                $fs = 4;
            }


            $exists = \App\CombineResult::where('studentId', $studentId)->where('courseId', $value->id)->whereIn('folderId', $fa)->exists();
            if ($exists == false) {
                $courseA = array();
                $courseA['rankName'] = "Ranking global de $value->name";
                $courseA['percentage'] = null;
                $courseA['points'] = null;
                array_push($coursesArray, $courseA);

            }

            if ($exists == true) {
                $studentCombineResults = \App\CombineResult::where('studentId', $studentId)->where('courseId', $value->id)->whereIn('folderId', $fa)->get();

                //for average new
                $specialCount = \App\CombineResult::where('studentId', $studentId)->where('courseId', $value->id)->whereIn('folderId', $fa)->where('field1x', $fs)->get()->count();
                //end avg
                $studentCombineResultsScore = 0;
                $chN = "no";
                foreach ($studentCombineResults as $key => $val) {
                    if ($val->field1x == $fs) {
                        $chN = "yes";
                        $studentCombineResultsScore = $studentCombineResultsScore + $val->points;
                    }
                }//end foreach
                if ($chN == "no") {
                    $studentCombineResultsScore = null;
                }

                $allStudents = \App\CombineResult::where('courseId', $value->id)->whereIn('folderId', $fa)->select('studentId')->distinct()->get();

                $allStudentsScores = array();


                foreach ($allStudents as $askey => $asValue) {
                    $mm1 = \App\User::find($asValue->studentId);
                    if (!empty($mm1)) {
                        $ex1 = \App\CombineResult::where('studentId', $asValue->studentId)->where('courseId', $value->id)->whereIn('folderId', $fa)->exists();

                        if ($ex1 == true) {
                            $individualCombineResults = \App\CombineResult::where('studentId', $asValue->studentId)->where('courseId', $value->id)->whereIn('folderId', $fa)->get();

                            $individualCombineResultsScore = 0;
                            $chN2 = "no";
                            foreach ($individualCombineResults as $icrkey => $icrValue) {
                                if ($icrValue->field1x == $fs) {
                                    $chN2 = "yes";
                                    $individualCombineResultsScore = $individualCombineResultsScore + $icrValue->points;
                                }

                            }
                            if ($chN2 == "no") {
                                $individualCombineResultsScore = null;
                            }
                            array_push($allStudentsScores, $individualCombineResultsScore);

                        }
                    }
                }//end foreach

                $allStudentsScoresUnique = array_unique($allStudentsScores);
                sort($allStudentsScoresUnique);

                $highestKey1 = count($allStudentsScoresUnique) - 1;
                $percentagesArray = array();

                foreach ($allStudentsScoresUnique as $alsukey => $alsuValue) {
                    if ($highestKey1 == 0) {
                        $per = 100;
                    }
                    if ($highestKey1 != 0) {
                        $per = $alsukey / $highestKey1 * 100;
                    }
                    array_push($percentagesArray, $per);

                    if ($alsuValue == $studentCombineResultsScore) {


                        $courseA = array();
                        $courseA['rankName'] = "Ranking global de $value->name";
                        $courseA['percentage'] = intval($per);

                        if ($value->name == "Inglés") {

                            $divC = \App\CombineResult::where('courseId', $value->id)->where('studentId', $studentId)->whereIn('folderId', $fa)->get();
                            $div = 0;
                            foreach ($divC as $key => $valueF) {
                                if ($valueF->field1x == $fs) {
                                    $div = $div + $valueF->field1x;
                                }
                            }
                            if ($div < 1) {
                                $div = 1;
                            }
                            if ($studentCombineResultsScore != null) {
                                $courseA['points'] = round($studentCombineResultsScore / $div, 2);
                            }

                            if ($studentCombineResultsScore == null) {
                                $courseA['points'] = null;
                                $courseA['percentage'] = null;
                            }

                        }

                        if ($value->name != "Inglés") {
                            if ($specialCount < 1) {
                                $specialCount = 1;
                            }
                            if ($studentCombineResultsScore != null) {
                                $courseA['points'] = round($studentCombineResultsScore / $specialCount, 2);
                            }
                            if ($studentCombineResultsScore == null) {
                                $courseA['points'] = null;
                                $courseA['percentage'] = null;
                            }

                        }


                        array_push($coursesArray, $courseA);
                        break;


                    }

                }//end foreach

            }//end exist true

        }

        $sinSum = null;
        $conSum = null;
        if (!empty($coursesArray)) {

            foreach ($coursesArray as $valueSpp) {

                if (!empty($valueSpp['rankName']) && $valueSpp['rankName'] != "Ranking global de Ortografía") {
                    if (!empty($valueSpp['points'])) {
                        $sinSum = $sinSum + $valueSpp['points'];
                    }
                }
            }
            $conSum = $sinSum + (int)$student->baremo;
        }

        //end course foreach
        //$resultArray['courses']=$coursesArray;
        $courseKnow = \App\Course::where('name', 'Psicotécnicos')->first();
        $cik = $courseKnow->id;
        $courseKnow2 = \App\Course::where('name', 'Inglés')->first();
        $cik2 = $courseKnow2->id;

        $existsGlobal = \App\CombineResult::where('studentId', $studentId)->whereIn('folderId', $fa)->where('courseId', '!=', $cikO)->exists();
        if ($existsGlobal == false) {

            $withoutArray = array();
            $withoutArray['rankName'] = "Ranking global (sin baremo)";
            $withoutArray['percentage'] = null;
            $withoutArray['points'] = null;
            array_push($coursesArray, $withoutArray);
            //$resultArray['withoutBaremo']=$withoutArray;
        }
        if ($existsGlobal == true) {
            $studentCombineResultsGlobal = \App\CombineResult::where('studentId', $studentId)->whereIn('folderId', $fa)->where('courseId', '!=', $cikO)->get();

            $studentCombineResultsScoreGlobal = 0;
            foreach ($studentCombineResultsGlobal as $key => $value) {
                if ($value->courseId != $cik2) {
                    $studentCombineResultsScoreGlobal = $studentCombineResultsScoreGlobal + $value->points;
                }
            }//end foreach

            //start ing
            $ingCE = \App\CombineResult::where('studentId', $studentId)
                ->where('courseId', $cik2)->whereIn('folderId', $fa)->exists();
            if ($ingCE == true) {
                $ingC = \App\CombineResult::where('studentId', $studentId)
                    ->where('courseId', $cik2)->whereIn('folderId', $fa)->get();
                $divIng = 0;
                $ingTotal = 0;
                foreach ($ingC as $key => $ingV) {
                    $divIng = $divIng + $ingV->field1x;
                    $ingTotal = $ingTotal + $ingV->points;
                }
                if ($divIng < 1) {
                    $divIng = 1;
                }
                $ingP = $ingTotal / $divIng;
                $studentCombineResultsScoreGlobal = $studentCombineResultsScoreGlobal + $ingP;

            }
            //end ing

            $allStudentsGlobal = \App\CombineResult::whereIn('folderId', $fa)->select('studentId')->distinct()->get();
            $allStudentsScoresGlobal = array();

            foreach ($allStudentsGlobal as $key2 => $value2) {
                $mm3 = \App\User::find($value2->studentId);
                if (!empty($mm3)) {
                    $ex2 = \App\CombineResult::where('studentId', $value2->studentId)->whereIn('folderId', $fa)->where('courseId', '!=', $cikO)->exists();

                    if ($ex2 == true) {
                        $individualCombineResultsGlobal = \App\CombineResult::where('studentId', $value2->studentId)->whereIn('folderId', $fa)->where('courseId', '!=', $cikO)->get();

                        $individualCombineResultsScoreGlobal = 0;
                        foreach ($individualCombineResultsGlobal as $icrgkey => $icrgValue) {
                            if ($icrgValue->courseId != $cik2) {
                                $individualCombineResultsScoreGlobal = $individualCombineResultsScoreGlobal + $icrgValue->points;
                            }
                        }


                        $ingEE = \App\CombineResult::whereIn('folderId', $fa)->where('studentId', $value2->studentId)
                            ->where('courseId', $cik2)->exists();
                        if ($ingEE == true) {
                            $ingE = \App\CombineResult::whereIn('folderId', $fa)->where('studentId', $value2->studentId)
                                ->where('courseId', $cik2)->get();
                            $ingS = 0;
                            $ingSD = 0;
                            foreach ($ingE as $key => $value) {
                                $ingS = $ingS + $value->points;
                                $ingSD = $ingSD + $value->field1x;
                            }
                            if ($ingSD < 1) {
                                $ingSD = 1;
                            }
                            $ing = $ingS / $ingSD;
                            $individualCombineResultsScoreGlobal = $individualCombineResultsScoreGlobal + $ing;
                        }
                        //end ing
                        array_push($allStudentsScoresGlobal, $individualCombineResultsScoreGlobal);

                    }
                }

            }//end foreach


            $allStudentsScoresUniqueGlobal = array_unique($allStudentsScoresGlobal);

            sort($allStudentsScoresUniqueGlobal);
            $highestKey2 = count($allStudentsScoresUniqueGlobal) - 1;
            $percentagesArrayGlobal = array();
            foreach ($allStudentsScoresUniqueGlobal as $alsugkey => $alsugValue) {
                if ($highestKey2 == 0) {
                    $per2 = 100;
                }
                if ($highestKey2 != 0) {
                    $per2 = $alsugkey / $highestKey2 * 100;
                }
                array_push($percentagesArrayGlobal, $per2);
                if ($alsugValue == $studentCombineResultsScoreGlobal) {

                    $withoutArray = array();
                    $withoutArray['rankName'] = "Ranking global (sin baremo)";
                    $withoutArray['percentage'] = intval($per2);
                    //$withoutArray['points']=round($studentCombineResultsScoreGlobal,2);
                    $withoutArray['points'] = round($sinSum, 2);
                    if ($sinSum == null) {
                        $withoutArray['points'] = null;
                        $withoutArray['percentage'] = null;
                    }

                    //$resultArray['withoutBaremo']=$withoutArray;
                    array_push($coursesArray, $withoutArray);
                    break;
                }
            }//end foreach
        }//end exist global if


        $existsGlobalBaremo = \App\CombineResult::where('studentId', $studentId)->whereIn('folderId', $fa)->exists();

        if ($existsGlobalBaremo == false) {

            $withArray = array();
            $withArray['rankName'] = "Ranking global (con baremo)";
            $withArray['percentage'] = null;
            $withArray['points'] = null;
            //$resultArray['withBaremo']=$withArray;
            array_push($coursesArray, $withArray);
        }
        if ($existsGlobalBaremo == true) {

            $studentCombineResultsGlobalBaremo = \App\CombineResult::where('studentId', $studentId)->whereIn('folderId', $fa)->where('courseId', '!=', $cikO)->get();

            $studentCombineResultsScoreGlobalBaremo = 0;
            foreach ($studentCombineResultsGlobalBaremo as $bkey => $bvalue) {
                if ($bvalue->courseId != $cik2) {
                    $studentCombineResultsScoreGlobalBaremo = $studentCombineResultsScoreGlobalBaremo + $bvalue->points;
                }
            }//end foreach

            //start ing
            $ingC2E = \App\CombineResult::whereIn('folderId', $fa)->where('studentId', $studentId)
                ->where('courseId', $cik2)->exists();

            if ($ingC2E == true) {
                $ingC2 = \App\CombineResult::whereIn('folderId', $fa)->where('studentId', $studentId)
                    ->where('courseId', $cik2)->get();
                $divIng2 = 0;
                $ingTotal2 = 0;
                foreach ($ingC2 as $key => $ingV) {
                    $divIng2 = $divIng2 + $ingV->field1x;
                    $ingTotal2 = $ingTotal2 + $ingV->points;
                }
                if ($divIng2 < 1) {
                    $divIng2 = 1;
                }
                $ingP2 = $ingTotal2 / $divIng2;
                $studentCombineResultsScoreGlobalBaremo = $studentCombineResultsScoreGlobalBaremo + $ingP2;

            }

            //end ing
            $studentCombineResultsScoreGlobalBaremo = $studentCombineResultsScoreGlobalBaremo + (int)$student->baremo;


            $allStudentsGlobalBaremo = \App\CombineResult::whereIn('folderId', $fa)->select('studentId')->distinct()->get();
            $allStudentsScoresGlobalBaremo = array();
            foreach ($allStudentsGlobalBaremo as $key3 => $value3) {
                $m44 = \App\User::find($value3->studentId);
                if (!empty($m44)) {

                    $ex3 = \App\CombineResult::where('studentId', $value3->studentId)->whereIn('folderId', $fa)->where('courseId', '!=', $cikO)->exists();

                    $sb = \App\User::find($value3->studentId);
                    $individualCombineResultsScoreGlobalBaremo = 0;
                    if ($ex3 == true) {
                        $individualCombineResultsGlobalBaremo = \App\CombineResult::where('studentId', $value3->studentId)->whereIn('folderId', $fa)->where('courseId', '!=', $cikO)->get();

                        foreach ($individualCombineResultsGlobalBaremo as $icrgbkey => $icrgbValue) {
                            if ($icrgbValue->courseId != $cik2) {
                                $individualCombineResultsScoreGlobalBaremo = $individualCombineResultsScoreGlobalBaremo + $icrgbValue->points;
                            }
                        }


                        $ingE2E = \App\CombineResult::whereIn('folderId', $fa)->where('studentId', $value3->studentId)
                            ->where('courseId', $cik2)->exists();
                        if ($ingE2E == true) {

                            $ingE2 = \App\CombineResult::whereIn('folderId', $fa)->where('studentId', $value3->studentId)
                                ->where('courseId', $cik2)->get();
                            $ingS2 = 0;
                            $ingSD2 = 0;
                            foreach ($ingE2 as $key => $value) {
                                $ingS2 = $ingS2 + $value->points;
                                $ingSD2 = $ingSD2 + $value->field1x;
                            }
                            if ($ingSD2 < 1) {
                                $ingSD2 = 1;
                            }
                            $ing2 = $ingS2 / $ingSD2;

                            $individualCombineResultsScoreGlobalBaremo = $individualCombineResultsScoreGlobalBaremo + $ing2;
                        }
                        //end ing


                    }


                    $individualCombineResultsScoreGlobalBaremo = $individualCombineResultsScoreGlobalBaremo + (int)$sb->baremo;
                    array_push($allStudentsScoresGlobalBaremo, $individualCombineResultsScoreGlobalBaremo);
                }
            }//end foreach
            $allStudentsScoresUniqueGlobalBaremo = array_unique($allStudentsScoresGlobalBaremo);
            sort($allStudentsScoresUniqueGlobalBaremo);
            $highestKey3 = count($allStudentsScoresUniqueGlobalBaremo) - 1;
            $percentagesArrayGlobalBaremo = array();


            foreach ($allStudentsScoresUniqueGlobalBaremo as $alsugkey => $alsugValue) {
                if ($highestKey3 == 0) {
                    $per3 = 100;
                }
                if ($highestKey3 != 0) {
                    $per3 = $alsugkey / $highestKey3 * 100;
                }
                array_push($percentagesArrayGlobalBaremo, $per3);
                if ($alsugValue == $studentCombineResultsScoreGlobalBaremo) {
                    $withArray = array();
                    $withArray['rankName'] = "Ranking global (con baremo)";
                    $withArray['percentage'] = intval($per3);
                    //$withArray['points']=round($studentCombineResultsScoreGlobalBaremo,2);
                    $withArray['points'] = round($conSum, 2);
                    //$resultArray['withBaremo']=$withArray;
                    if ($conSum == null) {
                        $withArray['percentage'] = null;
                        //$withArray['points']=round($studentCombineResultsScoreGlobalBaremo,2);
                        $withArray['points'] = null;
                    }
                    array_push($coursesArray, $withArray);
                    break;

                }
            }//end foreach
        }//end exist GlobalBaremo if
        $resultArray['courses'] = $coursesArray;
        $regex = \App\Register::where('userId', $student->id)->exists();
        if ($regex == true) {
            $reg = \App\Register::where('userId', $student->id)->first();
            $userName = $reg->surname;

        }
        if (empty($userName)) {
            $userName = null;
        }
        $con = \App\User::where('type', $student->type)->count();

        return response()->json(['status' => 'Successfull', 'data' => $resultArray, 'username' => $userName, 'numberOfStudents' => $con]);

    }

    public function getTopicCourseHorizontalRanking(Request $request)
    {
        $studentId = $request->json('studentId');
        $student = \App\User::find($studentId);
        $folders = \App\Folder::where('type', 'exams')->get();
        $courseOne = array();
        array_push($courseOne, 1);
        $courseTwo = array();
        array_push($courseTwo, 2);
        $courseThree = array();
        array_push($courseThree, 3);
        $courseFour = array();
        array_push($courseFour, 4);
        $without = array();
        array_push($without, 5);
        $with = array();
        array_push($with, 6);


        $resultArray = array();
        foreach ($folders as $folderkey => $folder) {
            //course with topic
            $courses = \App\Course::all();
            $coursesA = array();

            foreach ($courses as $coursekey => $course) {
                $studentCombineResult = \App\CombineResult::where('folderId', $folder->id)->where('courseId', $course->id)
                    ->where('studentId', $studentId)->first();
                if (empty($studentCombineResult)) {
                    $course->setAttribute('rankName', "Ranking de $course->name");
                    $course->setAttribute('percentage', 'null');
                    $course->setAttribute('points', 'null');
                    $course->setAttribute('totalPoints', 'null');
                    if ($course->id == 1) {
                        array_push($courseOne, null);
                    }
                    if ($course->id == 2) {
                        array_push($courseTwo, null);
                    }
                    if ($course->id == 3) {
                        array_push($courseThree, null);
                    }
                    if ($course->id == 4) {
                        array_push($courseFour, null);
                    }
                }
                if (!empty($studentCombineResult)) {
                    $combineResults = \App\CombineResult::where('folderId', $folder->id)->where('courseId', $course->id)
                        ->orderBy('points', 'asc')->get();
                    $allScores = array();
                    foreach ($combineResults as $combinekey => $combine) {
                        array_push($allScores, $combine->points);
                    }
                    $uniqueScores = array_unique($allScores);
                    sort($uniqueScores);
                    $highestKey = count($uniqueScores) - 1;
                    $percentages = array();
                    foreach ($uniqueScores as $uniquekey => $unique) {

                        if ($highestKey == 0) {
                            $per = 100;
                        }
                        if ($highestKey != 0) {
                            $per = $uniquekey / $highestKey * 100;
                        }

                        array_push($percentages, $per);

                        if ($unique == $studentCombineResult->points) {

                            $course->setAttribute('rankName', "Ranking de $course->name");
                            $course->setAttribute('percentage', $per);
                            $course->setAttribute('points', $unique);
                            $course->setAttribute('totalPoints', $studentCombineResult->totalPoints);
                            if ($course->id == 1) {
                                array_push($courseOne, $per);
                            }
                            if ($course->id == 2) {
                                array_push($courseTwo, $per);
                            }
                            if ($course->id == 3) {
                                array_push($courseThree, $per);
                            }
                            if ($course->id == 4) {
                                array_push($courseFour, $per);
                            }

                        }
                    }
                }
            }
            $cA = $courses->toArray();
            $resultArray[$folderkey]['folderName'] = $folder->name;
            $resultArray[$folderkey]['courses'] = $cA;
            //end course with topic


            //start only topic without baremo
            $exists1 = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)->exists();
            if ($exists1 == false) {
                $withoutArray = array();
                $withoutArray['rankName'] = "Rank. $folder->name sin baremo";
                $withoutArray['percentage'] = null;
                $withoutArray['points'] = null;
                $withoutArray['totalPoints'] = null;
                $resultArray[$folderkey]['withoutBaremo'] = $withoutArray;
                array_push($without, null);

                $withArray = array();
                $withArray['rankName'] = "Rank. $folder->name con baremo";
                $withArray['percentage'] = null;
                $withArray['points'] = null;
                $withArray['totalPoints'] = null;
                $resultArray[$folderkey]['withBaremo'] = $withArray;
                array_push($with, null);

            }
            if ($exists1 == true) {
                $studentAllTopics = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)->get();
                $studentAllTopicsScore = 0;
                $studentAllTopicsScoreTotal = 0;
                foreach ($studentAllTopics as $studentalltopickey => $value) {
                    $studentAllTopicsScore = $studentAllTopicsScore + $value->points;
                }
                foreach ($studentAllTopics as $studentalltopickey => $value) {
                    $studentAllTopicsScoreTotal = $studentAllTopicsScoreTotal + $value->totalPoints;
                }

                $allStudents = \App\CombineResult::where('folderId', $folder->id)->select('studentId')->distinct()->get();

                $allStudentsIds = array();
                foreach ($allStudents as $askey => $allStudent) {
                    array_push($allStudentsIds, $allStudent->studentId);
                }

                $scoresWithoutBaremo = array();
                foreach ($allStudentsIds as $asidkey => $allStudentId) {
                    $allResults = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $allStudentId)->get();
                    $allResultsScores = 0;
                    foreach ($allResults as $allresultkey => $allResult) {
                        $allResultsScores = $allResultsScores + $allResult->points;
                    }

                    array_push($scoresWithoutBaremo, $allResultsScores);
                }

                $uniqueScoresWithoutBaremo = array_unique($scoresWithoutBaremo);
                sort($uniqueScoresWithoutBaremo);

                $highestKeyWithoutBaremo = count($uniqueScoresWithoutBaremo) - 1;
                $percentagesWithoutBaremo = array();
                foreach ($uniqueScoresWithoutBaremo as $oswbkey => $oswbvalue) {

                    if ($highestKeyWithoutBaremo == 0) {
                        $perWithoutBaremo = 100;
                    }
                    if ($highestKeyWithoutBaremo != 0) {
                        $perWithoutBaremo = $oswbkey / $highestKeyWithoutBaremo * 100;
                    }
                    array_push($percentagesWithoutBaremo, $perWithoutBaremo);
                    if ($oswbvalue == $studentAllTopicsScore) {

                        $withoutArray = array();
                        $withoutArray['rankName'] = "Rank. $folder->name sin baremo";
                        $withoutArray['percentage'] = $perWithoutBaremo;
                        $withoutArray['points'] = $studentAllTopicsScore;
                        $withoutArray['totalPoints'] = $studentAllTopicsScoreTotal;
                        $resultArray[$folderkey]['withoutBaremo'] = $withoutArray;
                        array_push($without, $perWithoutBaremo);

                    }
                }
                //end only topic without baremo
                //start only topic with baremo
                $studentAllTopics2 = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)->get();
                if (!empty($studentAllTopics2)) {
                    $studentAllTopicsScore2 = 0;
                    $studentAllTopicsScore2Total = 0;
                    foreach ($studentAllTopics2 as $studentalltopickey => $value) {
                        $studentAllTopicsScore2 = $studentAllTopicsScore2 + $value->points;
                    }
                    foreach ($studentAllTopics2 as $studentalltopickey => $value) {
                        $studentAllTopicsScore2Total = $studentAllTopicsScore2Total + $value->totalPoints;
                    }
                    $studentAllTopicsScore2 = $studentAllTopicsScore2 + (int)$student->baremo;
                    $allStudents = \App\CombineResult::where('folderId', $folder->id)->select('studentId')->distinct()->get();
                    $scoresWithBaremo = array();
                    foreach ($allStudents as $askey => $allStudent) {
                        $studentB = \App\User::find($allStudent->studentId);
                        $allResults2 = \App\CombineResult::where('folderId', $folder->id)
                            ->where('studentId', $allStudent->studentId)->get();
                        $allResultsScores2 = 0;
                        foreach ($allResults2 as $allresultkey => $allResult2) {
                            $allResultsScores2 = $allResultsScores2 + $allResult2->points;
                        }
                        $allResultsScores2 = $allResultsScores2 + (int)$studentB->baremo;
                        array_push($scoresWithBaremo, $allResultsScores2);
                    }
                    $uniqueScoresWithBaremo = array_unique($scoresWithBaremo);
                    sort($uniqueScoresWithBaremo);
                    $highestKeyWithBaremo = count($uniqueScoresWithBaremo) - 1;
                    $percentagesWithBaremo = array();
                    foreach ($uniqueScoresWithBaremo as $oswbkey => $oswbvalue) {
                        if ($highestKeyWithBaremo == 0) {
                            $perWithBaremo = 100;
                        }
                        if ($highestKeyWithBaremo != 0) {
                            $perWithBaremo = $oswbkey / $highestKeyWithBaremo * 100;
                        }
                        array_push($percentagesWithBaremo, $perWithBaremo);
                        if ($oswbvalue == $studentAllTopicsScore2) {

                            $withArray = array();
                            $withArray['rankName'] = "Rank. $folder->name con baremo";
                            $withArray['percentage'] = $perWithBaremo;
                            $withArray['points'] = $studentAllTopicsScore2;
                            $withArray['totalPoints'] = $studentAllTopicsScore2Total;
                            $resultArray[$folderkey]['withBaremo'] = $withArray;
                            array_push($with, $perWithBaremo);


                        }
                    }
                }
            }

            //end only topic with baremo

        }
        $data = array();
        array_push($data, $courseOne);
        array_push($data, $courseTwo);
        array_push($data, $courseThree);
        array_push($data, $courseFour);
        array_push($data, $without);
        array_push($data, $with);
        return response()->json(['data' => $data, 'status' => 'Successfull']);

    }

    public function getTopicCourseHorizontalRanking2(Request $request)
    {
        $studentId = $request->json('studentId');
        $student = \App\User::find($studentId);
        $folders = \App\Folder::where('type', 'exams')->get();

        $resultArray = array();
        $mainData = array();
        $firstArray = array();
        array_push($firstArray, 'Conocimientos');
        array_push($firstArray, 'Inglés');
        array_push($firstArray, 'Psicotécnicos');
        array_push($firstArray, 'Ortografía');
        array_push($firstArray, 'Global sin baremo');
        array_push($firstArray, 'Global con baremo');
        array_push($mainData, $firstArray);
        foreach ($folders as $folderkey => $folder) {
            $data = array();
            array_push($data, $folderkey + 1);
            //course with topic
            $courses = \App\Course::all();
            $coursesA = array();

            foreach ($courses as $coursekey => $course) {
                $studentCombineResult = \App\CombineResult::where('folderId', $folder->id)->where('courseId', $course->id)
                    ->where('studentId', $studentId)->first();
                if (empty($studentCombineResult)) {
                    $course->setAttribute('rankName', "Ranking de $course->name");
                    $course->setAttribute('percentage', 'null');
                    $course->setAttribute('points', 'null');
                    $course->setAttribute('totalPoints', 'null');
                    array_push($data, null);

                }
                if (!empty($studentCombineResult)) {
                    $combineResults = \App\CombineResult::where('folderId', $folder->id)->where('courseId', $course->id)
                        ->orderBy('points', 'asc')->get();
                    $allScores = array();
                    foreach ($combineResults as $combinekey => $combine) {
                        array_push($allScores, $combine->points);
                    }
                    $uniqueScores = array_unique($allScores);
                    sort($uniqueScores);
                    $highestKey = count($uniqueScores) - 1;
                    $percentages = array();
                    foreach ($uniqueScores as $uniquekey => $unique) {

                        if ($highestKey == 0) {
                            $per = 100;
                        }
                        if ($highestKey != 0) {
                            $per = $uniquekey / $highestKey * 100;
                        }

                        array_push($percentages, $per);

                        if ($unique == $studentCombineResult->points) {

                            $course->setAttribute('rankName', "Ranking de $course->name");
                            $course->setAttribute('percentage', $per);
                            $course->setAttribute('points', $unique);
                            $course->setAttribute('totalPoints', $studentCombineResult->totalPoints);
                            array_push($data, $per);


                        }
                    }
                }
            }
            $cA = $courses->toArray();
            $resultArray[$folderkey]['folderName'] = $folder->name;
            $resultArray[$folderkey]['courses'] = $cA;
            //end course with topic


            //start only topic without baremo
            $exists1 = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)->exists();
            if ($exists1 == false) {
                $withoutArray = array();
                $withoutArray['rankName'] = "Rank. $folder->name sin baremo";
                $withoutArray['percentage'] = null;
                $withoutArray['points'] = null;
                $withoutArray['totalPoints'] = null;
                $resultArray[$folderkey]['withoutBaremo'] = $withoutArray;
                array_push($data, null);


                $withArray = array();
                $withArray['rankName'] = "Rank. $folder->name con baremo";
                $withArray['percentage'] = null;
                $withArray['points'] = null;
                $withArray['totalPoints'] = null;
                $resultArray[$folderkey]['withBaremo'] = $withArray;
                array_push($data, null);


            }
            if ($exists1 == true) {
                $studentAllTopics = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)->get();
                $studentAllTopicsScore = 0;
                $studentAllTopicsScoreTotal = 0;
                foreach ($studentAllTopics as $studentalltopickey => $value) {
                    $studentAllTopicsScore = $studentAllTopicsScore + $value->points;
                }
                foreach ($studentAllTopics as $studentalltopickey => $value) {
                    $studentAllTopicsScoreTotal = $studentAllTopicsScoreTotal + $value->totalPoints;
                }

                $allStudents = \App\CombineResult::where('folderId', $folder->id)->select('studentId')->distinct()->get();

                $allStudentsIds = array();
                foreach ($allStudents as $askey => $allStudent) {
                    array_push($allStudentsIds, $allStudent->studentId);
                }

                $scoresWithoutBaremo = array();
                foreach ($allStudentsIds as $asidkey => $allStudentId) {
                    $allResults = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $allStudentId)->get();
                    $allResultsScores = 0;
                    foreach ($allResults as $allresultkey => $allResult) {
                        $allResultsScores = $allResultsScores + $allResult->points;
                    }

                    array_push($scoresWithoutBaremo, $allResultsScores);
                }

                $uniqueScoresWithoutBaremo = array_unique($scoresWithoutBaremo);
                sort($uniqueScoresWithoutBaremo);

                $highestKeyWithoutBaremo = count($uniqueScoresWithoutBaremo) - 1;
                $percentagesWithoutBaremo = array();
                foreach ($uniqueScoresWithoutBaremo as $oswbkey => $oswbvalue) {

                    if ($highestKeyWithoutBaremo == 0) {
                        $perWithoutBaremo = 100;
                    }
                    if ($highestKeyWithoutBaremo != 0) {
                        $perWithoutBaremo = $oswbkey / $highestKeyWithoutBaremo * 100;
                    }
                    array_push($percentagesWithoutBaremo, $perWithoutBaremo);
                    if ($oswbvalue == $studentAllTopicsScore) {

                        $withoutArray = array();
                        $withoutArray['rankName'] = "Rank. $folder->name sin baremo";
                        $withoutArray['percentage'] = $perWithoutBaremo;
                        $withoutArray['points'] = $studentAllTopicsScore;
                        $withoutArray['totalPoints'] = $studentAllTopicsScoreTotal;
                        $resultArray[$folderkey]['withoutBaremo'] = $withoutArray;
                        array_push($data, $perWithoutBaremo);


                    }
                }
                //end only topic without baremo
                //start only topic with baremo
                $studentAllTopics2 = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)->get();
                if (!empty($studentAllTopics2)) {
                    $studentAllTopicsScore2 = 0;
                    $studentAllTopicsScore2Total = 0;
                    foreach ($studentAllTopics2 as $studentalltopickey => $value) {
                        $studentAllTopicsScore2 = $studentAllTopicsScore2 + $value->points;
                    }
                    foreach ($studentAllTopics2 as $studentalltopickey => $value) {
                        $studentAllTopicsScore2Total = $studentAllTopicsScore2Total + $value->totalPoints;
                    }
                    $studentAllTopicsScore2 = $studentAllTopicsScore2 + (int)$student->baremo;
                    $allStudents = \App\CombineResult::where('folderId', $folder->id)->select('studentId')->distinct()->get();
                    $scoresWithBaremo = array();
                    foreach ($allStudents as $askey => $allStudent) {
                        $studentB = \App\User::find($allStudent->studentId);
                        $allResults2 = \App\CombineResult::where('folderId', $folder->id)
                            ->where('studentId', $allStudent->studentId)->get();
                        $allResultsScores2 = 0;
                        foreach ($allResults2 as $allresultkey => $allResult2) {
                            $allResultsScores2 = $allResultsScores2 + $allResult2->points;
                        }
                        $allResultsScores2 = $allResultsScores2 + (int)$studentB->baremo;
                        array_push($scoresWithBaremo, $allResultsScores2);
                    }
                    $uniqueScoresWithBaremo = array_unique($scoresWithBaremo);
                    sort($uniqueScoresWithBaremo);
                    $highestKeyWithBaremo = count($uniqueScoresWithBaremo) - 1;
                    $percentagesWithBaremo = array();
                    foreach ($uniqueScoresWithBaremo as $oswbkey => $oswbvalue) {
                        if ($highestKeyWithBaremo == 0) {
                            $perWithBaremo = 100;
                        }
                        if ($highestKeyWithBaremo != 0) {
                            $perWithBaremo = $oswbkey / $highestKeyWithBaremo * 100;
                        }
                        array_push($percentagesWithBaremo, $perWithBaremo);
                        if ($oswbvalue == $studentAllTopicsScore2) {

                            $withArray = array();
                            $withArray['rankName'] = "Rank. $folder->name con baremo";
                            $withArray['percentage'] = $perWithBaremo;
                            $withArray['points'] = $studentAllTopicsScore2;
                            $withArray['totalPoints'] = $studentAllTopicsScore2Total;
                            $resultArray[$folderkey]['withBaremo'] = $withArray;
                            array_push($data, $perWithBaremo);

                        }
                    }
                }
            }

            //end only topic with baremo
            array_push($mainData, $data);

        }


        return response()->json(['data' => $mainData, 'status' => 'Successfull']);

    }

    public function getTopicCourseHorizontalRanking3(Request $request)
    {

        $studentId = $request->get('studentId');

        $student = \App\User::find($studentId);
        if (empty($student)) {
            echo "Your user deleted";
        }
        if (!empty($student)) {
            $folders = \App\Folder::where('type', 'exams')->where('studentType', $student->type)->get();

            $resultArray = array();
            $mainData = array();
            //$firstArray=array();
            //array_push($firstArray,'Temas');
            //array_push($firstArray,'Conocimientos');
            //array_push($firstArray,'Inglés');
            //array_push($firstArray,'Psicotécnicos');
            //array_push($firstArray,'Ortografía');
            //array_push($firstArray,'Global sin baremo');
            //array_push($firstArray,'Global con baremo');
            //array_push($mainData,$firstArray);
            $courseKnow = \App\Course::where('name', 'Psicotécnicos')->first();
            $cik = $courseKnow->id;
            $courseKnow2 = \App\Course::where('name', 'Inglés')->first();
            $cik2 = $courseKnow2->id;
            $courseKnowO = \App\Course::where('name', 'Ortografía')->first();
            $cikO = $courseKnowO->id;
            foreach ($folders as $folderkey => $folder) {
                $data = array();
                //array_push($data,$folderkey+1);
                array_push($data, $folder->field1x);

                //course with topic
                $courses = \App\Course::all();
                $coursesA = array();

                foreach ($courses as $coursekey => $course) {
                    $studentCombineResult = \App\CombineResult::where('folderId', $folder->id)->where('courseId', $course->id)
                        ->where('studentId', $studentId)->first();

                    if (empty($studentCombineResult)) {
                        $course->setAttribute('rankName', "Ranking de $course->name");
                        $course->setAttribute('percentage', 'null');
                        $course->setAttribute('points', 'null');
                        $course->setAttribute('totalPoints', 'null');
                        array_push($data, null);

                    }

                    if (!empty($studentCombineResult)) {
                        if ($course->name == "Psicotécnicos") {
                            $f = 1;
                        }
                        if ($course->name == "Inglés") {
                            $f = 2;
                        }
                        if ($course->name == "Ortografía") {
                            $f = 4;
                        }
                        if ($course->name == "Conocimientos") {
                            $f = 4;
                        }
                        if ($studentCombineResult->field1x != $f) {
                            $course->setAttribute('rankName', "Ranking de $course->name");
                            $course->setAttribute('percentage', 'null');
                            $course->setAttribute('points', 'null');
                            $course->setAttribute('totalPoints', 'null');
                            array_push($data, null);
                        }
                        if ($studentCombineResult->field1x == $f) {
                            $combineResults = \App\CombineResult::where('folderId', $folder->id)->where('courseId', $course->id)
                                ->orderByRaw("CAST(points AS SIGNED) ASC")->get();
                            $allScores = array();
                            foreach ($combineResults as $combinekey => $combine) {
                                $um = \App\User::find($combine->studentId);
                                if (!empty($um)) {
                                    array_push($allScores, $combine->points);
                                }
                            }

                            $uniqueScores = array_unique($allScores);
                            sort($uniqueScores);

                            $highestKey = count($uniqueScores) - 1;
                            $percentages = array();
                            foreach ($uniqueScores as $uniquekey => $unique) {

                                if ($highestKey == 0) {
                                    $per = 100;
                                }
                                if ($highestKey != 0) {
                                    $per = $uniquekey / $highestKey * 100;
                                }

                                array_push($percentages, $per);

                                if ($unique == $studentCombineResult->points) {

                                    $course->setAttribute('rankName', "Ranking de $course->name");
                                    $course->setAttribute('percentage', intval($per));
                                    if ($course->name == "Inglés") {
                                        $divC = \App\CombineResult::where('folderId', $folder->id)->where('courseId', $course->id)->where('studentId', $studentId)->first();
                                        $div = $divC->field1x;
                                        $course->setAttribute('points', round($unique, 2) / $div);
                                        $course->setAttribute('totalPoints', $studentCombineResult->totalPoints / $div);
                                    }
                                    if ($course->name != "Inglés") {
                                        $course->setAttribute('points', round($unique, 2));
                                        $course->setAttribute('totalPoints', $studentCombineResult->totalPoints);
                                    }
                                    array_push($data, intval($per));

                                }
                            }
                        }
                    }
                }
                $cA = $courses->toArray();
                $resultArray[$folderkey]['folderName'] = $folder->name;
                $resultArray[$folderkey]['courses'] = $cA;
                //end course with topic

                $withSum = 0;
                $withSumTotal = 0;
                $withoutSum = 0;

                if (!empty($cA)) {
                    $withoutSum = 0;
                    foreach ($cA as $key => $value) {
                        if ($value['points'] != 'null' && $value['rankName'] != "Ranking de Ortografía") {
                            $withoutSum = $withoutSum + $value['points'];
                            $withSumTotal = $withSumTotal + $value['totalPoints'];
                        }
                    }
                    $withSum = $withoutSum + (int)$student->baremo;
                }

                $courseKnow = \App\Course::where('name', 'Psicotécnicos')->first();
                $cik = $courseKnow->id;
                //start only topic without baremo
                $exists1 = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)->exists();
                if ($exists1 == false) {
                    $withoutArray = array();
                    $withoutArray['rankName'] = "Rank. $folder->name sin baremo";
                    $withoutArray['percentage'] = null;
                    $withoutArray['points'] = null;
                    $withoutArray['totalPoints'] = null;
                    $resultArray[$folderkey]['withoutBaremo'] = $withoutArray;
                    array_push($data, null);


                    $withArray = array();
                    $withArray['rankName'] = "Rank. $folder->name con baremo";
                    $withArray['percentage'] = null;
                    $withArray['points'] = null;
                    $withArray['totalPoints'] = null;
                    $resultArray[$folderkey]['withBaremo'] = $withArray;
                    array_push($data, null);
                }

                if ($exists1 == true) {
                    $studentAllTopics = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)->where('courseId', '!=', $cikO)->get();
                    $studentAllTopicsScore = 0;
                    $studentAllTopicsScoreTotal = 0;
                    foreach ($studentAllTopics as $studentalltopickey => $value) {
                        if ($value->courseId != $cik2) {
                            $studentAllTopicsScore = $studentAllTopicsScore + $value->points;
                        }
                    }

                    //start ing
                    $ingCE = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)
                        ->where('courseId', $cik2)->exists();
                    if ($ingCE == true) {
                        $ingC = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)
                            ->where('courseId', $cik2)->get();
                        $divIng = 0;
                        $ingTotal = 0;
                        foreach ($ingC as $key => $ingV) {
                            $divIng = $divIng + $ingV->field1x;
                            $ingTotal = $ingTotal + $ingV->points;
                        }
                        if ($divIng < 1) {
                            $divIng = 1;
                        }
                        $ingP = $ingTotal / $divIng;
                        $studentAllTopicsScore = $studentAllTopicsScore + $ingP;

                    }
                    //end ing
                    foreach ($studentAllTopics as $studentalltopickey => $value) {
                        if ($value->courseId != $cik2) {
                            $studentAllTopicsScoreTotal = $studentAllTopicsScoreTotal + $value->totalPoints;
                        }
                    }

                    if ($ingCE == true) {
                        $studentAllTopicsScoreTotal = $studentAllTopicsScoreTotal + 20;
                    }
                    $allStudents = \App\CombineResult::where('folderId', $folder->id)->select('studentId')->distinct()->get();

                    $allStudentsIds = array();
                    foreach ($allStudents as $askey => $allStudent) {
                        $m77 = \App\User::find($allStudent->studentId);
                        if (!empty($m77)) {
                            array_push($allStudentsIds, $allStudent->studentId);
                        }
                    }

                    $scoresWithoutBaremo = array();
                    foreach ($allStudentsIds as $asidkey => $allStudentId) {
                        $allResults = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $allStudentId)->where('courseId', '!=', $cikO)->get();
                        $allResultsScores = 0;
                        foreach ($allResults as $allresultkey => $allResult) {
                            if ($allResult->courseId != $cik2) {
                                $allResultsScores = $allResultsScores + $allResult->points;
                            }
                        }

                        //start ing

                        $ingEE = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $allStudentId)
                            ->where('courseId', $cik2)->exists();
                        if ($ingEE == true) {
                            $ingE = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $allStudentId)
                                ->where('courseId', $cik2)->get();
                            $ingS = 0;
                            $ingSD = 0;
                            foreach ($ingE as $key => $value) {
                                $ingS = $ingS + $value->points;
                                $ingSD = $ingSD + $value->field1x;
                            }
                            if ($ingSD < 1) {
                                $ingSD = 1;
                            }
                            $ing = $ingS / $ingSD;
                            $allResultsScores = $allResultsScores + $ing;
                        }
                        //end ing
                        array_push($scoresWithoutBaremo, $allResultsScores);
                    }

                    $uniqueScoresWithoutBaremo = array_unique($scoresWithoutBaremo);
                    sort($uniqueScoresWithoutBaremo);

                    $highestKeyWithoutBaremo = count($uniqueScoresWithoutBaremo) - 1;
                    $percentagesWithoutBaremo = array();
                    foreach ($uniqueScoresWithoutBaremo as $oswbkey => $oswbvalue) {

                        if ($highestKeyWithoutBaremo == 0) {
                            $perWithoutBaremo = 100;
                        }
                        if ($highestKeyWithoutBaremo != 0) {
                            $perWithoutBaremo = $oswbkey / $highestKeyWithoutBaremo * 100;
                        }
                        array_push($percentagesWithoutBaremo, $perWithoutBaremo);

                        if ($oswbvalue == $studentAllTopicsScore) {

                            $withoutArray = array();
                            $withoutArray['rankName'] = "Rank. $folder->name sin baremo";
                            $withoutArray['percentage'] = intval($perWithoutBaremo);
                            //$withoutArray['points']=round($studentAllTopicsScore,2);
                            $withoutArray['points'] = round($withoutSum, 2);
                            //$withoutArray['totalPoints']=$studentAllTopicsScoreTotal;
                            $withoutArray['totalPoints'] = $withSumTotal;
                            $resultArray[$folderkey]['withoutBaremo'] = $withoutArray;
                            array_push($data, intval($perWithoutBaremo));


                        }
                    }

                    //end only topic without baremo
                    //start only topic with baremo
                    $studentAllTopics2 = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)->where('courseId', '!=', $cikO)->get();
                    if (!empty($studentAllTopics2)) {
                        $studentAllTopicsScore2 = 0;
                        $studentAllTopicsScore2Total = 0;
                        foreach ($studentAllTopics2 as $studentalltopickey => $value) {
                            if ($value->courseId != $cik2) {
                                $studentAllTopicsScore2 = $studentAllTopicsScore2 + $value->points;
                            }
                        }

                        //start ing
                        $ingC2E = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)
                            ->where('courseId', $cik2)->exists();
                        if ($ingC2E == true) {
                            $ingC2 = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $studentId)
                                ->where('courseId', $cik2)->get();
                            $divIng2 = 0;
                            $ingTotal2 = 0;
                            foreach ($ingC2 as $key => $ingV) {
                                $divIng2 = $divIng2 + $ingV->field1x;
                                $ingTotal2 = $ingTotal2 + $ingV->points;
                            }
                            if ($divIng2 < 1) {
                                $divIng2 = 1;
                            }
                            $ingP2 = $ingTotal2 / $divIng2;
                            $studentAllTopicsScore2 = $studentAllTopicsScore2 + $ingP2;

                        }
                        //end ing
                        foreach ($studentAllTopics2 as $studentalltopickey => $value) {
                            if ($value->courseId != $cik2) {
                                $studentAllTopicsScore2Total = $studentAllTopicsScore2Total + $value->totalPoints;
                            }
                        }

                        if ($ingC2E = true) {
                            $studentAllTopicsScore2Total = $studentAllTopicsScore2Total + 20;
                        }
                        $studentAllTopicsScore2 = $studentAllTopicsScore2 + (int)$student->baremo;
                        $allStudents = \App\CombineResult::where('folderId', $folder->id)->select('studentId')->distinct()->get();
                        $scoresWithBaremo = array();
                        foreach ($allStudents as $askey => $allStudent) {
                            $studentB = \App\User::find($allStudent->studentId);
                            if (!empty($studentB)) {
                                $allResults2 = \App\CombineResult::where('folderId', $folder->id)
                                    ->where('studentId', $allStudent->studentId)->where('courseId', '!=', $cikO)->get();
                                $allResultsScores2 = 0;
                                foreach ($allResults2 as $allresultkey => $allResult2) {
                                    if ($allResult2->courseId != $cik2) {
                                        $allResultsScores2 = $allResultsScores2 + $allResult2->points;
                                    }
                                }
                                if (!empty($studentB->baremo)) {
                                    //dd($studentB->baremo,$studentB);
                                    $allResultsScores2 = $allResultsScores2 + (int)$studentB->baremo;

                                }

                                //start ing
                                $ingE2E = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $allStudent->studentId)
                                    ->where('courseId', $cik2)->exists();
                                if ($ingE2E == true) {
                                    $ingE2 = \App\CombineResult::where('folderId', $folder->id)->where('studentId', $allStudent->studentId)
                                        ->where('courseId', $cik2)->get();
                                    $ingS2 = 0;
                                    $ingSD2 = 0;
                                    foreach ($ingE2 as $key => $value) {
                                        $ingS2 = $ingS2 + $value->points;
                                        $ingSD2 = $ingSD2 + $value->field1x;
                                    }
                                    if ($ingSD2 < 1) {
                                        $ingSD2 = 1;
                                    }
                                    $ing2 = $ingS2 / $ingSD2;
                                    $allResultsScores2 = $allResultsScores2 + $ing2;
                                }
                                //end ing
                                array_push($scoresWithBaremo, $allResultsScores2);
                            }
                        }
                        $uniqueScoresWithBaremo = array_unique($scoresWithBaremo);
                        sort($uniqueScoresWithBaremo);
                        $highestKeyWithBaremo = count($uniqueScoresWithBaremo) - 1;
                        $percentagesWithBaremo = array();
                        foreach ($uniqueScoresWithBaremo as $oswbkey => $oswbvalue) {
                            if ($highestKeyWithBaremo == 0) {
                                $perWithBaremo = 100;
                            }
                            if ($highestKeyWithBaremo != 0) {
                                $perWithBaremo = $oswbkey / $highestKeyWithBaremo * 100;
                            }
                            array_push($percentagesWithBaremo, $perWithBaremo);
                            if ($oswbvalue == $studentAllTopicsScore2) {

                                $withArray = array();
                                $withArray['rankName'] = "Rank. $folder->name con baremo";
                                $withArray['percentage'] = intval($perWithBaremo);
                                //$withArray['points']=round($studentAllTopicsScore2,2);
                                $withArray['points'] = round($withSum, 2);
                                //$withArray['totalPoints']=$studentAllTopicsScore2Total;
                                $withArray['totalPoints'] = $withSumTotal;
                                $resultArray[$folderkey]['withBaremo'] = $withArray;
                                array_push($data, intval($perWithBaremo));

                            }
                        }
                    }
                }
                //end only topic with baremo
                array_push($mainData, $data);

            }
            for($i=0;$i<count($mainData);$i++){
                if(!isset($mainData[$i][6])){
                    $mainData[$i][6] = null;
                }
            }
            $mainData = json_encode($mainData);

            //dd($mainData);
            return view('googleChart', compact('mainData'));
            //return response()->json(['data'=>$mainData,'status'=>'Successfull']);
        }

    }
}
