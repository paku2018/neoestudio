<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/*use Illuminate\Support\Facades\Input;*/
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Mail;
use Illuminate\Support\Collection;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Spatie\DbDumper\Databases\MySql;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $admins = \App\User::where('role', 'admin')->get();

        return view('admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admins.create');

    }

    public function store(Request $request)
    {
        $admin = new \App\User;
        if (!empty($request->get('email'))) {
            $exists = \App\User::where('email', $request->get('email'))->exists();
            if ($exists == true) {
                return redirect()->back()->with('message2', 'El Email ya existe');
            }

        }
        if (!empty($request->get('telephone'))) {
            $exists = \App\User::where('telephone', $request->get('telephone'))->exists();
            if ($exists == true) {
                return redirect()->back()->with('message2', 'El teléfono ya existe');
            }

        }
        $admin->name = $request->get('name');
        $admin->userName = $request->get('userName');
        $admin->email = $request->get('email');
        $admin->password = $request->get('password');
        $admin->telephone = $request->get('telephone');

        $image = $request->file("image");


        if (!empty($image)) {
            $newFilename = $image->getClientOriginalName();
            $mimeType = $image->getMimeType();
            $destinationPath = 'adminImages';
            $image->move($destinationPath, $newFilename);
            $picPath = 'adminImages/' . $newFilename;
            $imageUrl = $picPath;
            $admin->photo = $imageUrl;

        }
        $admin->role = "admin";
        $admin->save();
        $message = "Administrador creado con éxito";
        return redirect()->back()->with('message', $message);
    }

    public function edit($id)
    {
        $admin = \App\User::find($id);
        return view('admins.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = \App\User::find($id);
        $admin->name = $request->get('name');
        $admin->userName = $request->get('userName');
        $admin->email = $request->get('email');
        $admin->password = $request->get('password');
        $admin->telephone = $request->get('telephone');
        $admin->course = $request->get('course');
        $check = $request->get('check');
        $image = $request->file("image");

        if ($check == null) {

            if (!empty($image)) {
                $newFilename = $image->getClientOriginalName();
                $mimeType = $image->getMimeType();
                $destinationPath = 'adminImages';
                $image->move($destinationPath, $newFilename);
                $picPath = 'adminImages/' . $newFilename;
                $imageUrl = $picPath;
                $admin->photo = $imageUrl;

            }
        }
        $admin->save();
        $message = "Administrador actualizado con éxito";
        return redirect()->back()->with('message', $message);
    }

    public function delete($id)
    {
        $admin = \App\User::find($id);
        $admin->delete();
        $message = "Administrador eliminado exitosamente";
        return redirect()->back()->with('message', $message);
    }

    public function commulative()
    {
        $combines = \App\CombineResult::all();
        return view('commulative', compact('combines'));
    }

    public function studentRankingsById($id)
    {
        $studentId = $id;
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
                                    $course->setAttribute('totalPoints', $studentCombineResult->totalPoints);
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
                    if ($value['points'] != 'null') {
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
                            if (!empty($studentB->baremo)) {
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


                        }
                    }
                }
            }

            //end only topic with baremo

        }


        return view('students/studentrankingsbyid', compact('id', 'resultArray'));
    }

    public function studentRankings2ById($id)
    {
        $studentId = $id;
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
                $specialCount = \App\CombineResult::where('studentId', $studentId)->where('courseId', $value->id)->whereIn('folderId', $fa)->get()->count();
                //end avg
                $studentCombineResultsScore = 0;
                foreach ($studentCombineResults as $key => $val) {
                    $studentCombineResultsScore = $studentCombineResultsScore + $val->points;
                }//end foreach
                $allStudents = \App\CombineResult::where('courseId', $value->id)->whereIn('folderId', $fa)->select('studentId')->distinct()->get();

                $allStudentsScores = array();


                foreach ($allStudents as $askey => $asValue) {
                    $mm1 = \App\User::find($asValue->studentId);
                    if (!empty($mm1)) {
                        $ex1 = \App\CombineResult::where('studentId', $asValue->studentId)->where('courseId', $value->id)->whereIn('folderId', $fa)->exists();

                        if ($ex1 == true) {
                            $individualCombineResults = \App\CombineResult::where('studentId', $asValue->studentId)->where('courseId', $value->id)->whereIn('folderId', $fa)->get();

                            $individualCombineResultsScore = 0;
                            foreach ($individualCombineResults as $icrkey => $icrValue) {
                                $individualCombineResultsScore = $individualCombineResultsScore + $icrValue->points;

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
                                $div = $div + $valueF->field1x;
                            }
                            if ($div < 1) {
                                $div = 1;
                            }

                            $courseA['points'] = round($studentCombineResultsScore / $div, 2);

                        }
                        if ($value->name != "Inglés") {
                            if ($specialCount < 1) {
                                $specialCount = 1;
                            }
                            $courseA['points'] = round($studentCombineResultsScore / $specialCount, 2);


                        }


                        array_push($coursesArray, $courseA);

                    }
                }//end foreach
            }//end exist true

        }

        $sinSum = 0;
        $conSum = 0;
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

                    //$resultArray['withoutBaremo']=$withoutArray;
                    array_push($coursesArray, $withoutArray);
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
                    if ($ex3 == true) {
                        $individualCombineResultsGlobalBaremo = \App\CombineResult::where('studentId', $value3->studentId)->whereIn('folderId', $fa)->where('courseId', '!=', $cikO)->get();
                        $individualCombineResultsScoreGlobalBaremo = 0;
                        foreach ($individualCombineResultsGlobalBaremo as $icrgbkey => $icrgbValue) {
                            if ($icrgbValue->courseId != $cik2) {
                                $individualCombineResultsScoreGlobalBaremo = $individualCombineResultsScoreGlobalBaremo + $icrgbValue->points;
                            }
                        }

                        $individualCombineResultsScoreGlobalBaremo = $individualCombineResultsScoreGlobalBaremo + (int)$sb->baremo;

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

                        array_push($allStudentsScoresGlobalBaremo, $individualCombineResultsScoreGlobalBaremo);
                    }
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
                    array_push($coursesArray, $withArray);

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
        return view('students/studentrankings2byid', compact('id', 'coursesArray'));
    }

    public function contactMail(Request $request)
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $affair = $request->get('affair');
        $mess = $request->get('message');

        $messages = [
            'email.required' => "correo electronico es requerido",
            'affair.required' => "Se requiere telefono",
            'message.required' => "Se requiere mensaje",
            'email.email' => "Proporcione un correo electrónico válido"
        ];

        // validate the form data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'affair' => 'required',
            'message' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->all());
        }

        Mail::send('mail3', ['name' => $name, 'email' => $email, 'affair' => $affair, 'mess' => $mess], function ($message) use ($email) {
            $message->to('info@neoestudioguardiacivil.es')->subject
            ('Neoestudio Contacto');
            $message->from($email);
        });
        return redirect()->back()->with('message', 'El mensaje ha sido enviado correctamente. Nos pondremos en contacto con usted a la mayor brevedad posible.');
    }

    public function getIpAddress()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }

    public function submitRegisterate(Request $request)
    {
        $package_payment = array();
        if (Session::has('package_payment')) {
            $package_payment = Session::get('package_payment');
        }

        $product_payment = array();
        if (Session::has('product_payment')) {
            $product_payment = Session::get('product_payment');
        }

        if (empty($request->get('userId'))) {
            $exists33 = \App\User::where('email', $request->get('electronico'))->exists();
            if ($exists33 == true) {
                //$message = "Correo electrónico ya apartadas";
                $message = "Has introducido un <strong>teléfono</strong> o <strong>correo electrónico</strong> que <strong>ya consta</strong> en nuestra base de datos. Por favor, <strong>inicia sesión</strong> para poder acceder a la ventana de pedidos.";
                return redirect()->back()->with('errors', $message)->withInput($request->input());
            }
            $exists34 = \App\User::where('telephone', $request->get('telefono'))->exists();
            if ($exists34 == true) {
                //$message = "Teléfono móvil ya apartadas";
                $message = "Has introducido un <strong>teléfono</strong> o <strong>correo electrónico</strong> que <strong>ya consta</strong> en nuestra base de datos. Por favor, <strong>inicia sesión</strong> para poder acceder a la ventana de pedidos.";
                return redirect()->back()->with('errors', $message)->withInput($request->input());
            }
            $baremo = (fmod($request->get('baremo'), 1) !== 0.00);
            if (!$baremo) {
                $message = "El <strong>baremo</strong> son los <strong>puntos</strong> que se <strong>suman</strong> a la <strong>nota</strong> de la <strong>oposición</strong> por la posesión de <strong>títulos</strong> u otros <strong>méritos</strong>. Debe escribirse un <strong>número entero</strong> o <strong>decimal</strong> con un <strong>punto</strong>. Ej: 7.5";
                return redirect()->back()->with('errors', $message)->withInput($request->input());
            }

            $student = new \App\User;
            $student->email = $request->get('electronico');
            $student->telephone = $request->get('telefono');
            $student->type = "Prueba";
            $student->emailSubscription = null;
            $student->ipAddress = $this->getIpAddress();
            $ex = \App\User::exists();
            if ($ex == true) {
                $max = \App\User::where('role', 'student')->where('type', 'Prueba')->max('scale');
                if ($max == null) {
                    $student->scale = 0;
                }
                if ($max != null) {
                    $student->scale = $max + 1;
                }
            }
            if ($ex == false) {
                $student->scale = 0;
            }
            $student->role = "student";
            $student->save();

            $news = \App\Alert::where('studentType', $student->type)->get();
            foreach ($news as $key => $value) {
                $ar = new \App\AlertRecord;
                $ar->studentId = $student->id;
                $ar->news = $value->news;
                $ar->newsId = $value->id;
                $ar->status = "unseen";
                $ar->save();
            }
            $efe = \App\Folder::where('studentType', $student->type)->where('type', 'exams')->exists();
            $rfe = \App\Folder::where('studentType', $student->type)->where('type', 'reviews')->exists();
            $pfe = \App\Folder::where('studentType', $student->type)->where('type', 'personalities')->exists();
            if ($efe == true) {
                $ef = \App\Folder::where('studentType', $student->type)->where('type', 'exams')->get();
                $efArray = array();
                foreach ($ef as $efv) {
                    array_push($efArray, $efv->id);
                }
                $examExists = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $efArray)->exists();


                if ($examExists == true) {
                    $exams = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $efArray)->get();
                    foreach ($exams as $exam) {
                        $notiE = new \App\Notification;
                        $notiE->studentId = $student->id;
                        $notiE->type = "exams";
                        $notiE->status = "pending";
                        $notiE->typeId1 = $exam->id;

                        $notiE->save();
                    }
                }
            }
            if ($rfe == true) {
                $rf = \App\Folder::where('studentType', $student->type)->where('type', 'reviews')->get();
                $rfArray = array();
                foreach ($rf as $rfv) {
                    array_push($rfArray, $rfv->id);
                }
                $reviewExists = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $rfArray)->exists();
                if ($reviewExists == true) {
                    $reviews = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $rfArray)->get();
                    foreach ($reviews as $review) {
                        $notiE = new \App\Notification;
                        $notiE->studentId = $student->id;
                        $notiE->type = "reviews";
                        $notiE->status = "pending";
                        $notiE->typeId1 = $review->id;

                        $notiE->save();
                    }

                }
            }
            if ($pfe == true) {
                $pf = \App\Folder::where('studentType', $student->type)->where('type', 'personalities')->get();
                $pfArray = array();
                foreach ($pf as $pfv) {
                    array_push($pfArray, $pfv->id);
                }
                $personalityExists = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $pfArray)->exists();
                if ($personalityExists == true) {
                    $personalities = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $pfArray)->get();
                    foreach ($personalities as $personality) {
                        $notiE = new \App\Notification;
                        $notiE->studentId = $student->id;
                        $notiE->type = "personalities";
                        $notiE->status = "pending";
                        $notiE->typeId1 = $personality->id;

                        $notiE->save();
                    }

                }
            }
            $descargasExists = \App\DownloadUpload::where('status', 'Habilitado')->where('studentType', $student->type)->where('option', 'Descargas')->exists();
            $subidasExists = \App\Folder::where('status', 'Habilitado')->where('studentType', $student->type)->where('type', 'Subidas')->exists();
            $topicExists = \App\Topic::where('studentType', $student->type)->exists();
            if ($topicExists == true) {
                $topics = \App\Topic::where('studentType', $student->type)->get();
                $topicArray = array();
                foreach ($topics as $topic) {
                    array_push($topicArray, $topic->id);
                }
                if (!empty($topicArray)) {
                    $audioExists = \App\Material::where('status', 'Habilitado')->where('type', 'audio')->whereIn('topicId', $topicArray)->exists();
                    $videoExists = \App\Material::where('status', 'Habilitado')->where('type', 'video')->whereIn('topicId', $topicArray)->exists();
                }
            }
            $folderExists = \App\Folder::where('studentType', $student->type)->where('type', 'surveys')->exists();
            if ($folderExists == true) {
                $folders = \App\Folder::where('studentType', $student->type)->where('type', 'surveys')->get();
                $folderArray = array();
                foreach ($folders as $folder) {
                    array_push($folderArray, $folder->id);
                }
                if (!empty($folderArray)) {
                    $surveyExists = \App\Survey::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $folderArray)->exists();
                }
            }

            if ($descargasExists == true) {
                $dess = \App\DownloadUpload::where('status', 'Habilitado')->where('studentType', $student->type)->where('option', 'Descargas')->get();
                foreach ($dess as $key => $des) {
                    $notiDes = new \App\Notification;
                    $notiDes->studentId = $student->id;
                    $notiDes->type = "Descargas";
                    $notiDes->status = "pending";
                    $notiDes->typeId1 = $des->id;
                    $notiDes->typeId2 = $des->folderId;
                    $notiDes->save();
                }

            }
            if ($subidasExists == true) {
                $subs = \App\Folder::where('status', 'Habilitado')->where('studentType', $student->type)->where('type', 'Subidas')->get();
                foreach ($subs as $sub) {
                    $notiSub = new \App\Notification;
                    $notiSub->studentId = $student->id;
                    $notiSub->type = "Subidas";
                    $notiSub->status = "pending";
                    $notiSub->typeId2 = $sub->id;
                    $notiSub->save();
                }

            }
            if ($topicExists == true) {
                if ($audioExists == true) {
                    $auds = \App\Material::where('status', 'Habilitado')->where('type', 'audio')->whereIn('topicId', $topicArray)->get();
                    foreach ($auds as $aud) {
                        $notiA = new \App\Notification;
                        $notiA->studentId = $student->id;
                        $notiA->type = "audio";
                        $notiA->status = "pending";
                        $notiA->typeId1 = $aud->id;
                        $notiA->typeId2 = $aud->folderId;
                        $notiA->save();
                    }

                }
                if ($videoExists == true) {
                    $vids = \App\Material::where('status', 'Habilitado')->where('type', 'video')->whereIn('topicId', $topicArray)->get();
                    foreach ($vids as $vid) {
                        $notiV = new \App\Notification;
                        $notiV->studentId = $student->id;
                        $notiV->type = "video";
                        $notiV->status = "pending";
                        $notiV->typeId1 = $vid->id;
                        $notiV->typeId2 = $vid->folderId;
                        $notiV->save();

                    }
                }
            }
            if ($folderExists == true) {
                if ($surveyExists == true) {
                    $surs = \App\Survey::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $folderArray)->get();
                    foreach ($surs as $sur) {
                        $notiSur = new \App\Notification;
                        $notiSur->studentId = $student->id;
                        $notiSur->type = "surveys";
                        $notiSur->status = "pending";
                        $notiSur->typeId1 = $sur->id;
                        $notiSur->save();
                    }

                }
            }
            $register = new \App\Register;
            $register->usuario = $request->get('usuario');
            $register->contrasena = $request->get('contrasena');
            $register->dni = $request->get('dni');
            $register->domi = $request->get('domi');
            $register->electronico = $request->get('electronico');
            $register->localidad = $request->get('localidad');
            $register->telefono = $request->get('telefono');
            $register->postal = $request->get('postal');
            $register->surname = $request->get('surname');
            $register->baremo = $request->get('baremo');
            $register->userId = $student->id;
            $register->save();
            $student->baremo = $register->baremo;
            $student->password = $register->contrasena;
            $student->save();

            $reason = $request->get('reason');
            Session::put('userData', $student);
            if (!empty($reason)) {
                $userId = $student->id;

                if ($reason == "books") {
                    return view('payments/books', compact('userId'));
                }
                if ($reason == "alumno") {
                    return view('payments/alumno', compact('userId'));
                }
                if ($reason == "alumnoConvocado") {
                    return view('payments/alumnoConvocado', compact('userId'));
                }
            }
            if (empty($reason)) {
                $userId = $student->id;
                $message = "Registrado correctamente";
                if (isset($package_payment) && empty($package_payment) === false && count($package_payment) > 0) {
                    return Redirect::intended('temario');
                } else if (isset($product_payment) && empty($product_payment) === false && count($product_payment) > 0) {
                    return Redirect::intended('coursePay');
                }
                return Redirect::intended('comienza');
                //return view('neoestudio/comienza', compact('message', 'userId'));
            }


        }
        /*$exists=\App\User::where('email',$request->get('electronico'))->exists();
        if($exists==true){
            $message="Correo electrónico ya apartadas";
        return redirect()->back()->with('message',$message);
        }
        $exists2=\App\User::where('telephone',$request->get('telefono'))->exists();
        if($exists2==true){
            $message="Teléfono móvil ya apartadas";
        return redirect()->back()->with('message',$message);
        }*/
        $register = new \App\Register;
        $register->usuario = $request->get('usuario');
        $register->contrasena = $request->get('contrasena');
        $register->dni = $request->get('dni');
        $register->domi = $request->get('domi');
        $register->electronico = $request->get('electronico');
        $register->localidad = $request->get('localidad');
        $register->telefono = $request->get('telefono');
        $register->postal = $request->get('postal');
        $register->surname = $request->get('surname');
        $register->baremo = $request->get('baremo');
        $register->userId = $request->get('userId');
        $register->save();

        $userId = $register->userId;
        $user = \App\User::find($userId);
        $user->baremo = $register->baremo;
        $user->password = $register->contrasena;
        $user->save();

        $reason = $request->get('reason');

        if ($reason != "nul") {
            if ($reason == "books") {
                return view('payments/books', compact('userId'));
            }
            if ($reason == "alumno") {
                return view('payments/alumno', compact('userId'));
            }
            if ($reason == "alumnoConvocado") {
                return view('payments/alumnoConvocado', compact('userId'));
            }
        }
        if ($reason == "nul") {
            /*$message="Registrado correctamente";
                    return view('neoestudio/comienza',compact('message','userId'));*/
            $pays = \App\Pay::where('userId', $userId)->orderBy('updated_at', 'desc')->get();
            $booksExists = \App\Pay::where('userId', $userId)->where('type', 'books')->exists();
            $alumnoExists = \App\Pay::where('userId', $userId)->where('type', 'alumno')->exists();
            $alumnoConvocadoExists = \App\Pay::where('userId', $userId)->where('type', 'alumnoConvocado')->exists();

            return view('payments/pays', compact('pays', 'userId', 'booksExists', 'alumnoExists', 'alumnoConvocadoExists'));
        }
        if (empty($reason)) {
            $pays = \App\Pay::where('userId', $userId)->orderBy('updated_at', 'desc')->get();
            $booksExists = \App\Pay::where('userId', $userId)->where('type', 'books')->exists();
            $alumnoExists = \App\Pay::where('userId', $userId)->where('type', 'alumno')->exists();
            $alumnoConvocadoExists = \App\Pay::where('userId', $userId)->where('type', 'alumnoConvocado')->exists();

            return view('payments/pays', compact('pays', 'userId', 'booksExists', 'alumnoExists', 'alumnoConvocadoExists'));
        }
        //return view('payments/payment',compact('userId'));
    }

    public function submitLoginInfo(Request $request)
    {
        $package_payment = array();
        if (Session::has('package_payment')) {
            $package_payment = Session::get('package_payment');
        }

        $product_payment = array();
        if (Session::has('product_payment')) {
            $product_payment = Session::get('product_payment');
        }

        $exists = \App\User::where('email', $request->get('email'))->where('telephone', $request->get('telephone'))->where('role', 'student')->exists();

        if ($exists == false) {
            $message = "correo electrónico o teléfono incorrecto";
            return redirect()->back()->with('message', $message);
        }
        if ($exists == true) {
            $reason = $request->get('reason');
            $user = \App\User::where('email', $request->get('email'))->where('telephone', $request->get('telephone'))->first();
            $exists2 = \App\Register::where('userId', $user->id)->exists();
            if ($exists2 == false) {
                $userId = $user->id;
                $email = $user->email;
                $telephone = $user->telephone;

                return view('neoestudio/registerate', compact('userId', 'email', 'telephone', 'reason'));

            }
            if ($exists2 == true) {
                Session::put('userData', $user);
                $userId = $user->id;
                $pays = \App\Pay::where('userId', $userId)->orderBy('updated_at', 'desc')->get();
                $booksExists = \App\Pay::where('userId', $userId)->where('type', 'books')->exists();
                $alumnoExists = \App\Pay::where('userId', $userId)->where('type', 'alumno')->exists();
                $alumnoConvocadoExists = \App\Pay::where('userId', $userId)->where('type', 'alumnoConvocado')->exists();
                if (!empty($reason)) {
                    return view('payments/pays', compact('pays', 'userId', 'booksExists', 'alumnoExists', 'alumnoConvocadoExists'));
                } else {
                    if (empty($pays) === false && count($pays) > 0 && !empty($reason)) {
                        return view('payments/pays', compact('pays', 'userId', 'booksExists', 'alumnoExists', 'alumnoConvocadoExists'));
                    } else {
                        if (isset($package_payment) && empty($package_payment) === false && count($package_payment) > 0) {
                            return Redirect::intended('temario');
                        } else if (isset($product_payment) && empty($product_payment) === false && count($product_payment) > 0) {
                            return Redirect::intended('coursePay');
                        }
                        return Redirect::intended('comienza');
                    }
                }
            }
        }
    }

    public function checkNotif(Request $request)
    {
        $notifs = \App\Notification::where('studentId', $request->json('studentId'))->get();
        return response()->json($notifs);
    }

    public function onExam(Request $request)
    {
        $studentId = $request->json('studentId');
        $examExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'exams')->exists();
        if ($examExists == true) {
            $exam = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'exams')->first();
            $exam->status = "seen";
            $exam->save();
        }
        return response()->json(['status' => 'successfull']);
    }

    public function checkNotifications(Request $request)
    {
        $studentId = $request->json('studentId');
        //$studentId=26;
        $examExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'exams')->exists();
        $reviewExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'reviews')->exists();
        $personalityExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'personalities')->exists();
        $surveyExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'surveys')->exists();
        $descargasExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'Descargas')->exists();
        $subidasExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'Subidas')->exists();
        $audioExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'audio')->exists();
        $videoExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'video')->exists();
        $descargasPdfExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'DescargasPdf')->exists();

        $fols = new Collection();
        $a1 = array();
        $a1['isActive'] = false;
        $fols->push($a1);

        $a2 = array();
        $a2['isActive'] = false;
        $fols->push($a2);

        $aCal = array();
        $aCal['isActive'] = false;
        $fols->push($aCal);

        $exA = array();
        $exA['isActive'] = $examExists;
        if ($examExists == true) {
            $examCount = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'exams')->get()->count();
            $exA['count'] = $examCount;
        }
        if ($examExists == false) {
            $exA['count'] = 0;
        }
        $fols->push($exA);

        /* $a9=array();
        $a9['isActive']=false;
        $fols->push($a9);*/

        $pdfA = array();
        $pdfA['isActive'] = $descargasPdfExists;
        if ($descargasPdfExists == true) {
            $descargasPdfCount = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'DescargasPdf')->get()->count();
            $pdfA['count'] = $descargasPdfCount;
        }
        if ($descargasPdfExists == false) {
            $pdfA['count'] = 0;
        }
        $fols->push($pdfA);

        $aA = array();
        $aA['isActive'] = $audioExists;
        if ($audioExists == true) {
            $audioCount = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'audio')->get()->count();
            $aA['count'] = $audioCount;
        }
        if ($audioExists == false) {
            $aA['count'] = 0;
        }
        $fols->push($aA);

        $vA = array();
        $vA['isActive'] = $videoExists;
        if ($videoExists == true) {
            $videoCount = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'video')->get()->count();
            $vA['count'] = $videoCount;
        }
        if ($videoExists == false) {
            $vA['count'] = 0;
        }
        $fols->push($vA);

        $a3 = array();
        $a3['isActive'] = false;
        $fols->push($a3);

        $a4 = array();
        $a4['isActive'] = false;
        $fols->push($a4);

        $rA = array();
        $rA['isActive'] = $reviewExists;
        if ($reviewExists == true) {
            $reviewCount = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'reviews')->get()->count();
            $rA['count'] = $reviewCount;
        }
        if ($reviewExists == false) {
            $rA['count'] = 0;
        }
        $fols->push($rA);

        $pA = array();
        $pA['isActive'] = $personalityExists;
        if ($personalityExists == true) {
            $personalityCount = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'personalities')->get()->count();
            $pA['count'] = $personalityCount;
        }
        if ($personalityExists == false) {
            $pA['count'] = 0;
        }
        $fols->push($pA);

        $a5 = array();
        $a5['isActive'] = false;
        $fols->push($a5);

        $dA = array();
        $dA['isActive'] = $descargasExists;
        if ($descargasExists == true) {
            $descargasCount = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'Descargas')->get()->count();
            $dA['count'] = $descargasCount;
        }
        if ($descargasExists == false) {
            $dA['count'] = 0;
        }
        $fols->push($dA);

        $sA = array();
        $sA['isActive'] = $surveyExists;
        if ($surveyExists == true) {
            $surveyCount = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'surveys')->get()->count();
            $sA['count'] = $surveyCount;
        }
        if ($surveyExists == false) {
            $sA['count'] = 0;
        }
        $fols->push($sA);

        $a6 = array();
        $a6['isActive'] = false;
        $fols->push($a6);

        //check payment

        $now = Carbon::now();
        $isActive = false;
        $pays = \App\Pay::where('userId', $studentId)->get();
        if (!empty($pays)) {
            foreach ($pays as $key => $value) {
                if ($now->lte(Carbon::parse($value->deadline))) {
                    if ($value->status != "paid") {
                        $isActive = true;
                    }
                }
            }
        }
        $a7 = array();
        $a7['isActive'] = $isActive;
        $fols->push($a7);

        $a8 = array();
        $a8['isActive'] = false;
        $fols->push($a8);

        return response()->json(['status' => 'Successfull', 'data' => $fols]);


    }

    public function getDates(Request $request)
    {
        $studentType = $request->json('studentType');
        $dates = \App\Calender::where('field1x', $studentType)->get();

        /*$folderArray=array();
        $dates=array();
        foreach ($folders as $key => $folder) {
            array_push($folderArray,$folder->id);
        }
        $exams=\App\Exam::whereIn('folderId',$folderArray)->get();
        foreach ($exams as $key => $exam) {
            array_push($dates,$exam->scheduleDate);
        }*/
        return response()->json(['status' => 'Successfull', 'data' => $dates]);
    }

    public function backups()
    {
        $files = File::files(base_path("backupsdown"));

        return view('admins.backups', compact('files'));
    }

    public function backupsDownload($name)
    {

        $pp = public_path() . "/backupsdown";

        $mat = "$name";

        $re = str_replace("/public", "", $pp);

        //$file= "public_path()". "/$mat";
        $file = "$re/" . "$mat";


        ob_end_clean();
        $headers = array('Content-Type' => \File::mimeType($file));
        //return response()->file($file);
        return response()->download($file, $mat, $headers);
        //$files = glob(base_path('backups/'.$name));
        // dd($files);
        //\Zipper::make(base_path("backups/download.zip"))->add($files)->close();
        //return response()->download(base_path("backups/download.zip"))->deleteFileAfterSend('true');
    }

    public function backupsImport($name)
    {
        $pp = public_path() . "/backups";
        $re = str_replace("/public", "", $pp);
        $nameA = explode(".", $name);
        $nameF = $nameA[0] . ".sql";
        $file = "$re/" . "$nameF";
        $tr = DB::unprepared(file_get_contents($file));
        $files = File::files(base_path("backupsdown"));
        $message = "Imported Successfully";
        return view('admins.backups', compact('files', 'message'));

    }

    public function takeBackup()
    {
        $date = Carbon::now()->toDateString();
        $randomN = "," . Carbon::now()->hour . "-" . Carbon::now()->minute . "-" . Carbon::now()->second;
        File::put('backups/' . $date . $randomN . 'backup.sql', '');

        MySql::create()->setDbName('neoappes')
            ->setUserName('neoes_')
            ->setPassword('aA115yr4.')
            ->setHost('mysql-5703.dinaserver.com')
            ->setPort('3306')
            ->dumpToFile(base_path('backups/' . $date . $randomN . 'backup.sql'));

        File::put('backupsdown/' . $date . $randomN . 'backup.txt', '');
        MySql::create()->setDbName('neoappes')
            ->setUserName('neoes_')
            ->setPassword('aA115yr4.')
            ->setHost('mysql-5703.dinaserver.com')
            ->setPort('3306')
            ->dumpToFile(base_path('backupsdown/' . $date . $randomN . 'backup.txt'));
        $files = File::files(base_path("backupsdown"));
        $message = "Backup took Successfully";
        return view('admins.backups', compact('files', 'message'));
    }

    public function backupsUpload(Request $request)
    {
        $image = $request->file("image");
        $image2 = $request->file("image");


        if (!empty($image)) {
            $newFilename = $image->getClientOriginalName();
            $ty = explode(".", $image->getClientOriginalName());

            if ($ty[1] != "txt") {
                $files = File::files(base_path("backupsdown"));
                $message = "File type not correct";
                return view('admins.backups', compact('files', 'message'));
            }

            $destinationPath = "backupsdown";
            $newFilename = $ty[0] . ".txt";
            $image->move($destinationPath, $newFilename);
            $destinationPath2 = "backups";
            $newFilename2 = $ty[0] . ".sql";
            copy($destinationPath . "/" . $newFilename, $destinationPath2 . "/" . $newFilename2);
            $files = File::files(base_path("backupsdown"));
            $message = "Uploaded Successfully";
            return view('admins.backups', compact('files', 'message'));


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
                $specialCount = \App\CombineResult::where('studentId', $studentId)->where('courseId', $value->id)->whereIn('folderId', $fa)->get()->count();
                //end avg
                $studentCombineResultsScore = 0;
                foreach ($studentCombineResults as $key => $val) {
                    $studentCombineResultsScore = $studentCombineResultsScore + $val->points;
                }//end foreach
                $allStudents = \App\CombineResult::where('courseId', $value->id)->whereIn('folderId', $fa)->select('studentId')->distinct()->get();

                $allStudentsScores = array();


                foreach ($allStudents as $askey => $asValue) {
                    $mm1 = \App\User::find($asValue->studentId);
                    if (!empty($mm1)) {
                        $ex1 = \App\CombineResult::where('studentId', $asValue->studentId)->where('courseId', $value->id)->whereIn('folderId', $fa)->exists();

                        if ($ex1 == true) {
                            $individualCombineResults = \App\CombineResult::where('studentId', $asValue->studentId)->where('courseId', $value->id)->whereIn('folderId', $fa)->get();

                            $individualCombineResultsScore = 0;
                            foreach ($individualCombineResults as $icrkey => $icrValue) {
                                $individualCombineResultsScore = $individualCombineResultsScore + $icrValue->points;

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
                                $div = $div + $valueF->field1x;
                            }

                            $courseA['points'] = round($studentCombineResultsScore, 2) / $div;

                        }
                        if ($value->name != "Inglés") {
                            if ($specialCount < 1) {
                                $specialCount = 1;
                            }
                            $courseA['points'] = round($studentCombineResultsScore / $specialCount, 2);


                        }


                        array_push($coursesArray, $courseA);

                    }
                }//end foreach
            }//end exist true

        }
        $sinSum = 0;
        $conSum = 0;
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

                    //$resultArray['withoutBaremo']=$withoutArray;
                    array_push($coursesArray, $withoutArray);
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
                    if ($ex3 == true) {
                        $individualCombineResultsGlobalBaremo = \App\CombineResult::where('studentId', $value3->studentId)->whereIn('folderId', $fa)->where('courseId', '!=', $cikO)->get();
                        $individualCombineResultsScoreGlobalBaremo = 0;
                        foreach ($individualCombineResultsGlobalBaremo as $icrgbkey => $icrgbValue) {
                            if ($icrgbValue->courseId != $cik2) {
                                $individualCombineResultsScoreGlobalBaremo = $individualCombineResultsScoreGlobalBaremo + $icrgbValue->points;
                            }
                        }

                        $individualCombineResultsScoreGlobalBaremo = $individualCombineResultsScoreGlobalBaremo + (int)$sb->baremo;

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

                        array_push($allStudentsScoresGlobalBaremo, $individualCombineResultsScoreGlobalBaremo);
                    }
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
                    array_push($coursesArray, $withArray);

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
}
