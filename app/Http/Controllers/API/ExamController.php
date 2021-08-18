<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
class ExamController extends Controller
{
    public function getAllExams(Request $request)
    {
        $studentId = $request->json('studentId');

        $ue = \App\User::where('id', $studentId)->exists();
        if ($ue == false) {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $u = \App\User::find($studentId);
        if ($u->field1x == "Bloquear") {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $getAllCoursesIds = \App\Exam::where('courseId', '!=', null)->select('courseId')->distinct()->get();
        $offset = 0;
        $limit = '20';
        $req_offset = $request->json('offset');
        if (isset($req_offset) && empty($req_offset) === false) {
            $offset = ($req_offset == 1) ? 0 : (($req_offset - 1) * $limit);
        }
        $folders = \App\Folder::where('type', 'exams')->where('studentType', $request->json('studentType'))->limit($limit)->offset($offset)->get();
        $cIterator = 0;
        foreach ($folders as $folderKey => $folder) {
            foreach ($getAllCoursesIds as $key => $value) {

                $courseName = \App\Course::find($value->courseId)->name;
                $exams = \App\Exam::where('folderId', $folder->id)->where('courseId', $value->courseId)->get();
                foreach ($exams as $key => $value) {
                    if ($value->status == "Habilitado") {
                        $value->setAttribute('studentStatus', 'Habilitado');
                    }
                    /*if($value->status=="Deshabilitado"){
                     $value->setAttribute('studentStatus','Deshabilitado');
                    }*/

                    $sR = \App\StudentExamRecord::where('studentId', $studentId)->where('examId', $value->id)
                        ->where('isCurrent', 'yes')->first();
                    if (!empty($sR)) {
                        if ($sR->status == "started") {
                            $endingTime = Carbon::parse($sR->officialEndingTime);
                            $currentTime = Carbon::now();
                            if ($endingTime->gte($currentTime)) {
                                $sR->examDuration = $endingTime->diffInSeconds($currentTime);
                                $sR->save();
                            }
                        }
                        $value->setAttribute('examDuration', $sR->examDuration);
                        $value->setAttribute('studentExamStatus', $sR->status);
                        $value->setAttribute('studentStatus', 'Habilitado');
                        $value->setAttribute('studentExamRecordId', $sR->id);
                        if ($sR->status == "end") {
                            $value->setAttribute('studentStatus', 'Deshabilitado');
                        }
                    }
                    if (empty($sR)) {
                        $isn = \App\StudentExamRecord::where('studentId', $studentId)->where('examId', $value->id)
                            ->where('isCurrent', 'no')->first();
                        if (!empty($isn)) {
                            $value->setAttribute('studentExamStatus', $isn->status);
                            $value->setAttribute('studentStatus', 'Deshabilitado');
                            $value->setAttribute('examDuration', $value->timeFrom);
                            $value->setAttribute('studentExamRecordId', $isn->id);
                        }
                        if (empty($isn)) {
                            $value->setAttribute('examDuration', $value->timeFrom);
                            $value->setAttribute('studentExamStatus', 'notAttempted');
                            if ($value->status == "Habilitado") {
                                $value->setAttribute('studentStatus', 'Habilitado');
                            }
                            if ($value->status == "Deshabilitado") {
                                $value->setAttribute('studentStatus', 'Deshabilitado');
                            }
                        }
                    }
                    $existR = \App\Reschedule::where('studentId', $studentId)->where('examId', $value->id)->
                    where('status', "Habilitado")->exists();
                    if ($existR == false) {
                        if (!empty($sR)) {
                            if ($sR->status != "started" && $sR->status != "paused") {
                                $value->setAttribute('studentStatus', 'Deshabilitado');
                            }
                        }

                    }
                    if ($existR == true) {
                        $reschedule = \App\Reschedule::where('studentId', $studentId)->where('examId', $value->id)->first();
                        if ($reschedule->status == "Habilitado") {
                            $value->setAttribute('studentStatus', 'Habilitado');
                        }
                        if ($reschedule->status == "Deshabilitado") {
                            $value->setAttribute('studentStatus', 'Deshabilitado');
                        }
                    }
                    $isActive = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'exams')->where('typeId1', $value->id)->exists();
                    $value->setAttribute('isActive', $isActive);

                }
                $headArray[$folderKey]['folderName'] = $folder->name;
                $headArray[$folderKey][$courseName] = $exams->toArray();
            }

        }
        if (empty($headArray)) {
            $headArray = array();
        }
        $examExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'exams')->exists();
        if ($examExists == true) {
            $exs = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'exams')->get();
            foreach ($exs as $key => $value) {
                $value->delete();
                //$value->status="seen";
                //$value->save();
            }
        }
        return response()->json(['data' => $headArray, 'status' => 'Successfull']);

    }

    public function getAllExam(Request $request)
    {
        $studentId = $request->json('studentId');

        $ue = \App\User::where('id', $studentId)->exists();
        if ($ue == false) {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $u = \App\User::find($studentId);
        if ($u->field1x == "Bloquear") {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $getAllCoursesIds = \App\Exam::where('courseId', '!=', null)->select('courseId')->distinct()->get();
        $offset = 0;
        $limit = '1';
        $req_offset = $request->json('offset');
        if (isset($req_offset) && empty($req_offset) === false) {
            $offset = ($req_offset == 1) ? 0 : (($req_offset - 1) * $limit);
        }
        $folders = \App\Folder::where('type', 'exams')->where('studentType', $request->json('studentType'))->limit($limit)->offset($offset)->get();
        $cIterator = 0;
        foreach ($folders as $folderKey => $folder) {
            foreach ($getAllCoursesIds as $key => $value) {

                $courseName = \App\Course::find($value->courseId)->name;
                $exams = \App\Exam::where('folderId', $folder->id)->where('courseId', $value->courseId)->get();
                foreach ($exams as $key => $value) {
                    if ($value->status == "Habilitado") {
                        $value->setAttribute('studentStatus', 'Habilitado');
                    }
                    /*if($value->status=="Deshabilitado"){
                     $value->setAttribute('studentStatus','Deshabilitado');
                    }*/

                    $sR = \App\StudentExamRecord::where('studentId', $studentId)->where('examId', $value->id)
                        ->where('isCurrent', 'yes')->first();
                    if (!empty($sR)) {
                        if ($sR->status == "started") {
                            $endingTime = Carbon::parse($sR->officialEndingTime);
                            $currentTime = Carbon::now();
                            if ($endingTime->gte($currentTime)) {
                                $sR->examDuration = $endingTime->diffInSeconds($currentTime);
                                $sR->save();
                            }
                        }
                        $value->setAttribute('examDuration', $sR->examDuration);
                        $value->setAttribute('studentExamStatus', $sR->status);
                        $value->setAttribute('studentStatus', 'Habilitado');
                        $value->setAttribute('studentExamRecordId', $sR->id);
                        if ($sR->status == "end") {
                            $value->setAttribute('studentStatus', 'Deshabilitado');
                        }
                    }
                    if (empty($sR)) {
                        $isn = \App\StudentExamRecord::where('studentId', $studentId)->where('examId', $value->id)
                            ->where('isCurrent', 'no')->first();
                        if (!empty($isn)) {
                            $value->setAttribute('studentExamStatus', $isn->status);
                            $value->setAttribute('studentStatus', 'Deshabilitado');
                            $value->setAttribute('examDuration', $value->timeFrom);
                            $value->setAttribute('studentExamRecordId', $isn->id);
                        }
                        if (empty($isn)) {
                            $value->setAttribute('examDuration', $value->timeFrom);
                            $value->setAttribute('studentExamStatus', 'notAttempted');
                            if ($value->status == "Habilitado") {
                                $value->setAttribute('studentStatus', 'Habilitado');
                            }
                            if ($value->status == "Deshabilitado") {
                                $value->setAttribute('studentStatus', 'Deshabilitado');
                            }
                        }
                    }
                    $existR = \App\Reschedule::where('studentId', $studentId)->where('examId', $value->id)->
                    where('status', "Habilitado")->exists();
                    if ($existR == false) {
                        if (!empty($sR)) {
                            if ($sR->status != "started" && $sR->status != "paused") {
                                $value->setAttribute('studentStatus', 'Deshabilitado');
                            }
                        }

                    }
                    if ($existR == true) {
                        $reschedule = \App\Reschedule::where('studentId', $studentId)->where('examId', $value->id)->first();
                        if ($reschedule->status == "Habilitado") {
                            $value->setAttribute('studentStatus', 'Habilitado');
                        }
                        if ($reschedule->status == "Deshabilitado") {
                            $value->setAttribute('studentStatus', 'Deshabilitado');
                        }
                    }
                    $isActive = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'exams')->where('typeId1', $value->id)->exists();
                    $value->setAttribute('isActive', $isActive);

                }
                $headArray[$folderKey]['folderName'] = $folder->name;
                $headArray[$folderKey][$courseName] = $exams->toArray();
            }

        }
        if (empty($headArray)) {
            $headArray = array();
        }
        $examExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'exams')->exists();
        if ($examExists == true) {
            $exs = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'exams')->get();
            foreach ($exs as $key => $value) {
                $value->delete();
                //$value->status="seen";
                //$value->save();
            }
        }
        return response()->json(['data' => $headArray, 'status' => 'Successfull']);

    }

    public function getAllExamFolders(Request $request)
    {
        $studentId = $request->json('studentId');

        $ue = \App\User::where('id', $studentId)->exists();
        if ($ue == false) {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $u = \App\User::find($studentId);
        if ($u->field1x == "Bloquear") {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $offset = 0;
        $limit = '20';
        $req_offset = $request->json('offset');
        if (isset($req_offset) && empty($req_offset) === false) {
            $offset = ($req_offset == 1) ? 0 : (($req_offset - 1) * $limit);
        }
        $folders = \App\Folder::where('type', 'exams')->where('studentType', $request->json('studentType'))->get();
        return response()->json(['data' => $folders, 'status' => 'Successfull']);
    }

    public function getAllExamsOfFolder(Request $request)
    {
        $folderId = $request->json('folderId');
        $studentId = $request->json('studentId');
        $ue = \App\User::where('id', $studentId)->exists();
        if ($ue == false) {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $u = \App\User::find($studentId);
        if ($u->field1x == "Bloquear") {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $getAllCoursesIds = \App\Exam::where('courseId', '!=', null)->where('folderId', $folderId)->select('courseId')->distinct()->get();
        $offset = 0;
        $limit = '20';
        $req_offset = $request->json('offset');
        if (isset($req_offset) && empty($req_offset) === false) {
            $offset = ($req_offset == 1) ? 0 : (($req_offset - 1) * $limit);
        }
        $folders = \App\Folder::where('id', $folderId)->where('type', 'exams')->where('studentType', $request->json('studentType'))->get();
        $cIterator = 0;
        foreach ($folders as $folderKey => $folder) {
            foreach ($getAllCoursesIds as $key => $value) {

                $courseName = \App\Course::find($value->courseId)->name;
                $exams = \App\Exam::where('folderId', $folder->id)->where('courseId', $value->courseId)->get();
                foreach ($exams as $key => $value) {
                    if ($value->status == "Habilitado") {
                        $value->setAttribute('studentStatus', 'Habilitado');
                    }
                    /*if($value->status=="Deshabilitado"){
                     $value->setAttribute('studentStatus','Deshabilitado');
                    }*/

                    $sR = \App\StudentExamRecord::where('studentId', $studentId)->where('examId', $value->id)
                        ->where('isCurrent', 'yes')->first();
                    if (!empty($sR)) {
                        if ($sR->status == "started") {
                            $endingTime = Carbon::parse($sR->officialEndingTime);
                            $currentTime = Carbon::now();
                            if ($endingTime->gte($currentTime)) {
                                $sR->examDuration = $endingTime->diffInSeconds($currentTime);
                                $sR->save();
                            }
                        }
                        $value->setAttribute('examDuration', $sR->examDuration);
                        $value->setAttribute('studentExamStatus', $sR->status);
                        $value->setAttribute('studentStatus', 'Habilitado');
                        $value->setAttribute('studentExamRecordId', $sR->id);
                        if ($sR->status == "end") {
                            $value->setAttribute('studentStatus', 'Deshabilitado');
                        }
                    }
                    if (empty($sR)) {
                        $isn = \App\StudentExamRecord::where('studentId', $studentId)->where('examId', $value->id)
                            ->where('isCurrent', 'no')->first();
                        if (!empty($isn)) {
                            $value->setAttribute('studentExamStatus', $isn->status);
                            $value->setAttribute('studentStatus', 'Deshabilitado');
                            $value->setAttribute('examDuration', $value->timeFrom);
                            $value->setAttribute('studentExamRecordId', $isn->id);
                        }
                        if (empty($isn)) {
                            $value->setAttribute('examDuration', $value->timeFrom);
                            $value->setAttribute('studentExamStatus', 'notAttempted');
                            if ($value->status == "Habilitado") {
                                $value->setAttribute('studentStatus', 'Habilitado');
                            }
                            if ($value->status == "Deshabilitado") {
                                $value->setAttribute('studentStatus', 'Deshabilitado');
                            }
                        }
                    }
                    $existR = \App\Reschedule::where('studentId', $studentId)->where('examId', $value->id)->
                    where('status', "Habilitado")->exists();
                    if ($existR == false) {
                        if (!empty($sR)) {
                            if ($sR->status != "started" && $sR->status != "paused") {
                                $value->setAttribute('studentStatus', 'Deshabilitado');
                            }
                        }

                    }
                    if ($existR == true) {
                        $reschedule = \App\Reschedule::where('studentId', $studentId)->where('examId', $value->id)->first();
                        if ($reschedule->status == "Habilitado") {
                            $value->setAttribute('studentStatus', 'Habilitado');
                        }
                        if ($reschedule->status == "Deshabilitado") {
                            $value->setAttribute('studentStatus', 'Deshabilitado');
                        }
                    }
                    $isActive = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'exams')->where('typeId1', $value->id)->exists();
                    $value->setAttribute('isActive', $isActive);

                }
                $headArray[$folderKey]['folderName'] = $folder->name;
                $headArray[$folderKey][$courseName] = $exams->toArray();
            }

        }
        if (empty($headArray)) {
            $headArray = array();
        }
        $examExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'exams')->exists();
        if ($examExists == true) {
            $exs = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'exams')->get();
            foreach ($exs as $key => $value) {
                $value->delete();
            }
        }
        return response()->json(['data' => $headArray, 'status' => 'Successfull']);

    }

    public function startExam(Request $request)
    {
        $studentId = $request->json('studentId');
        $tab = $request->json('tab');
        $ue = \App\User::where('id', $studentId)->exists();
        if ($ue == false) {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $u = \App\User::find($studentId);
        if ($u->field1x == "Bloquear") {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        if (!empty($request->json('studentAttemptId')) && !empty($request->json('studentAnswered'))) {
            $studentAttempt = \App\StudentAttempt::find($request->json('studentAttemptId'));
            if ($request->json('studentAnswered') == $studentAttempt->studentAnswered) {
                $studentAttempt->studentAnswered = null;
                $studentAttempt->save();
                $studentAttempts = \App\StudentAttempt::where('studentExamRecordId', $studentAttempt->studentExamRecordId)->get();

                if (!empty($tab)) {
                    if (!empty($studentAttempts)) {
                        foreach ($studentAttempts as $key => $value) {
                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->question);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('question', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer1);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer1', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer2);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer2', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer3);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer3', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer4);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer4', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->description);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('description', $str);
                        }
                    }
                }

                $count = \App\StudentAttempt::where('studentExamRecordId', $studentAttempt->studentExamRecordId)
                    ->where('studentAnswered', null)->count();
                if ($count != 0) {
                    $allAttempted = "no";
                }
                if ($count == 0) {
                    $allAttempted = "yes";
                }
                $totalItems = \App\StudentAttempt::where('studentExamRecordId', $studentAttempt->studentExamRecordId)->count();
                $studentExamRecord = \App\StudentExamRecord::find($studentAttempt->studentExamRecordId);
                return response()->json(['status' => 'Successfull', 'data' => $studentAttempts, 'canPause' => $studentExamRecord->canPause, 'studentExamRecordId' => $studentExamRecord->id, 'allAttempted' => $allAttempted, 'totalItems' => $totalItems]);
            }
            if ($request->json('studentAnswered') != $studentAttempt->studentAnswered) {
                $studentAttempt->studentAnswered = $request->json('studentAnswered');
                $studentAttempt->save();
            }

            $studentAttempts = \App\StudentAttempt::where('studentExamRecordId', $studentAttempt->studentExamRecordId)->get();

            if (!empty($tab)) {
                if (!empty($studentAttempts)) {
                    foreach ($studentAttempts as $key => $value) {
                        $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->question);
                        $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                        $value->setAttribute('question', $str);

                        $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer1);
                        $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                        $value->setAttribute('answer1', $str);

                        $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer2);
                        $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                        $value->setAttribute('answer2', $str);

                        $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer3);
                        $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                        $value->setAttribute('answer3', $str);

                        $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer4);
                        $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                        $value->setAttribute('answer4', $str);

                        $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->description);
                        $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                        $value->setAttribute('description', $str);
                    }
                }
            }

            $count = \App\StudentAttempt::where('studentExamRecordId', $studentAttempt->studentExamRecordId)
                ->where('studentAnswered', null)->count();
            if ($count != 0) {
                $allAttempted = "no";
            }
            if ($count == 0) {
                $allAttempted = "yes";
            }
            $totalItems = \App\StudentAttempt::where('studentExamRecordId', $studentAttempt->studentExamRecordId)->count();
            $studentExamRecord = \App\StudentExamRecord::find($studentAttempt->studentExamRecordId);
            return response()->json(['status' => 'Successfull', 'data' => $studentAttempts, 'canPause' => $studentExamRecord->canPause, 'studentExamRecordId' => $studentExamRecord->id, 'allAttempted' => $allAttempted, 'totalItems' => $totalItems]);
        }

        $examId = $request->json('examId');
        $examDuration = \App\Exam::find($examId)->timeFrom;
        $studentId = $request->json('studentId');
        $exists = \App\StudentExamRecord::where('studentId', $studentId)->where('examId', $examId)->where('isCurrent', 'yes')->exists();
        if ($exists == true) {
            $isPause = \App\StudentExamRecord::where('studentId', $studentId)->where('examId', $examId)->where('isCurrent', 'yes')->where('status', 'paused')->exists();
            if ($isPause == true) {
                $paused = \App\StudentExamRecord::where('studentId', $studentId)->where('examId', $examId)->where('isCurrent', 'yes')->where('status', 'paused')
                    ->first();
                $paused->status = "started";
                $paused->canPause = "no";
                $paused->resumedTime = Carbon::now()->toDateTimeString();
                $paused->save();
                $studentAttempts = \App\StudentAttempt::where('studentExamRecordId', $paused->id)->get();

                if (!empty($tab)) {
                    if (!empty($studentAttempts)) {
                        foreach ($studentAttempts as $key => $value) {
                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->question);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('question', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer1);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer1', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer2);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer2', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer3);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer3', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer4);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer4', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->description);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('description', $str);
                        }
                    }
                }

                //time
                $preOfficial = Carbon::parse($paused->officialEndingTime);
                $pauTime = $paused->pausedTime;
                $diff = $preOfficial->diffInSeconds(Carbon::parse($pauTime));
                $paused->officialEndingTime = Carbon::now()->addSeconds($diff)->toDateTimeString();
                $paused->save();
                $totalItems = \App\StudentAttempt::where('studentExamRecordId', $paused->id)->count();
                //end time
                return response()->json(['status' => 'Successfull', 'data' => $studentAttempts, 'canPause' => $paused->canPause,
                    'examDuration' => $paused->examDuration, 'studentExamRecordId' => $paused->id, 'totalItems' => $totalItems]);
            }
            $isStarted = \App\StudentExamRecord::where('studentId', $studentId)->where('examId', $examId)
                ->where('status', 'started')->where('isCurrent', 'yes')->exists();
            if ($isStarted == true) {
                $started = \App\StudentExamRecord::where('studentId', $studentId)->where('examId', $examId)->where('isCurrent', 'yes')->where('status', 'started')
                    ->first();
                $studentAttempts = \App\StudentAttempt::where('studentExamRecordId', $started->id)->get();

                if (!empty($tab)) {
                    if (!empty($studentAttempts)) {
                        foreach ($studentAttempts as $key => $value) {
                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->question);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('question', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer1);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer1', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer2);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer2', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer3);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer3', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer4);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer4', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->description);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('description', $str);
                        }
                    }
                }
                //time manupulation
                $endingTime = Carbon::parse($started->officialEndingTime);
                $currentTime = Carbon::now();
                if ($endingTime->gte($currentTime)) {
                    $started->examDuration = $endingTime->diffInSeconds($currentTime);
                    $started->save();
                }

                $totalItems = \App\StudentAttempt::where('studentExamRecordId', $started->id)->count();
                //dd($endingTime->diffInSeconds($currentTime),$endingTime->format('Y-m-d H:i:s'),$currentTime->format('Y-m-d H:i:s'));

                //end time
                return response()->json(['status' => 'Successfull', 'data' => $studentAttempts, 'canPause' => $started->canPause,
                    'examDuration' => $started->examDuration, 'studentExamRecordId' => $started->id, 'totalItems' => $totalItems]);
            }
            $isEnd = \App\StudentExamRecord::where('studentId', $studentId)->where('examId', $examId)
                ->where('status', 'end')->where('isCurrent', 'yes')->exists();
            if ($isEnd == true) {
                $ended = \App\StudentExamRecord::where('studentId', $studentId)->where('examId', $examId)->where('isCurrent', 'yes')->where('status', 'end')
                    ->first();
                $studentAttempts = \App\StudentAttempt::where('studentExamRecordId', $ended->id)->get();

                if (!empty($tab)) {
                    if (!empty($studentAttempts)) {
                        foreach ($studentAttempts as $key => $value) {
                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->question);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('question', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer1);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer1', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer2);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer2', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer3);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer3', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer4);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer4', $str);

                            $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->description);
                            $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('description', $str);
                        }
                    }
                }

                $totalItems = \App\StudentAttempt::where('studentExamRecordId', $ended->id)->count();
                return response()->json(['status' => 'Successfull', 'data' => $studentAttempts, 'canPause' => $ended->canPause,
                    'examDuration' => $ended->examDuration, 'studentExamRecordId' => $ended->id, 'totalItems' => $totalItems]);
            }
        }
        $studentExamRecord = new \App\StudentExamRecord;
        $studentExamRecord->examDuration = $examDuration;
        $studentExamRecord->studentId = $studentId;
        $studentExamRecord->examId = $examId;
        $studentExamRecord->isCurrent = "yes";
        $studentExamRecord->status = "started";
        $studentExamRecord->canPause = "yes";
        $studentExamRecord->save();
        //time
        $endingTime = Carbon::now()->addSeconds($examDuration);
        $currentTime = Carbon::now();
        $studentExamRecord->startingTime = $currentTime->toDateTimeString();
        $studentExamRecord->officialEndingTime = $endingTime->toDateTimeString();
        $studentExamRecord->save();
        //time end
        $qas = \App\Questionanswer::where('examId', $examId)->get();
        foreach ($qas as $key => $value) {
            $studentAttempt = new \App\StudentAttempt;
            $studentAttempt->qaId = $value->id;
            $str = $value->question;
            $regularExpression = "/class=\"[^<]*\"\s/i";
            $str = preg_replace($regularExpression, "", $str);

            $mystring2 = ' class="regular" ';
            $count = substr_count($str, 'Regular;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern = "/span style=\"[^>]*font-family: Regular;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring2, $pos, 0);

                    $off = $pos + 17;
                }

            }
            $mystring3 = ' class="bold" ';
            $count = substr_count($str, 'Bold;');

            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern = "/<span style=\"[^>]*font-family: Bold;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;

                    $str = substr_replace($str, $mystring3, $pos, 0);

                    $off = $pos + 14;
                }


            }

            $mystring4 = ' class="round" ';
            $count = substr_count($str, 'Rounded;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring4, $pos, 0);

                    $off = $pos + 17;
                }
            }
            $str = str_replace('font-family: Regular;', '', $str);
            $str = str_replace('font-family: Bold;', '', $str);
            $str = str_replace('font-family: Rounded;', '', $str);
            $str = str_replace('sup>', 'tap>', $str);
            $studentAttempt->question = $str;
            //ans1
            $str = $value->answer1;
            $regularExpression = "/class=\"[^<]*\"\s/i";
            $str = preg_replace($regularExpression, "", $str);
            $mystring2 = ' class="regular" ';
            $count = substr_count($str, 'Regular;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern = "/span style=\"[^>]*font-family: Regular;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring2, $pos, 0);

                    $off = $pos + 17;
                }
            }
            $mystring3 = ' class="bold" ';
            $count = substr_count($str, 'Bold;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern
                    = "/<span style=\"[^>]*font-family: Bold;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring3, $pos, 0);

                    $off = $pos + 14;
                }
            }
            $mystring4 = ' class="round" ';
            $count = substr_count($str, 'Rounded;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring4, $pos, 0);

                    $off = $pos + 17;
                }
            }
            $str = str_replace('font-family: Regular;', '', $str);
            $str = str_replace('font-family: Bold;', '', $str);
            $str = str_replace('font-family: Rounded;', '', $str);
            $str = str_replace('sup>', 'tap>', $str);
            $studentAttempt->answer1 = $str;
            //ans2
            $str = $value->answer2;
            $regularExpression = "/class=\"[^<]*\"\s/i";
            $str = preg_replace($regularExpression, "", $str);
            $mystring2 = ' class="regular" ';
            $count = substr_count($str, 'Regular;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern = "/span style=\"[^>]*font-family: Regular;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring2, $pos, 0);

                    $off = $pos + 17;
                }
            }
            $mystring3 = ' class="bold" ';
            $count = substr_count($str, 'Bold;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern
                    = "/<span style=\"[^>]*font-family: Bold;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring3, $pos, 0);

                    $off = $pos + 14;
                }
            }
            $mystring4 = ' class="round" ';
            $count = substr_count($str, 'Rounded;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring4, $pos, 0);

                    $off = $pos + 17;
                }
            }
            $str = str_replace('font-family: Regular;', '', $str);
            $str = str_replace('font-family: Bold;', '', $str);
            $str = str_replace('font-family: Rounded;', '', $str);
            $str = str_replace('sup>', 'tap>', $str);
            $studentAttempt->answer2 = $str;
            //ans3
            $str = $value->answer3;
            $regularExpression = "/class=\"[^<]*\"\s/i";
            $str = preg_replace($regularExpression, "", $str);
            $mystring2 = ' class="regular" ';
            $count = substr_count($str, 'Regular;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern = "/span style=\"[^>]*font-family: Regular;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring2, $pos, 0);

                    $off = $pos + 17;
                }
            }
            $mystring3 = ' class="bold" ';
            $count = substr_count($str, 'Bold;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern
                    = "/<span style=\"[^>]*font-family: Bold;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring3, $pos, 0);

                    $off = $pos + 14;
                }
            }
            $mystring4 = ' class="round" ';
            $count = substr_count($str, 'Rounded;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring4, $pos, 0);

                    $off = $pos + 17;
                }
            }
            $str = str_replace('font-family: Regular;', '', $str);
            $str = str_replace('font-family: Bold;', '', $str);
            $str = str_replace('font-family: Rounded;', '', $str);
            $str = str_replace('sup>', 'tap>', $str);
            $studentAttempt->answer3 = $str;
            //ans4
            $str = $value->answer4;
            $regularExpression = "/class=\"[^<]*\"\s/i";
            $str = preg_replace($regularExpression, "", $str);
            $mystring2 = ' class="regular" ';
            $count = substr_count($str, 'Regular;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern = "/span style=\"[^>]*font-family: Regular;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring2, $pos, 0);

                    $off = $pos + 17;
                }
            }
            $mystring3 = ' class="bold" ';
            $count = substr_count($str, 'Bold;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern
                    = "/<span style=\"[^>]*font-family: Bold;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring3, $pos, 0);

                    $off = $pos + 14;
                }
            }
            $mystring4 = ' class="round" ';
            $count = substr_count($str, 'Rounded;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring4, $pos, 0);

                    $off = $pos + 17;
                }
            }
            $str = str_replace('font-family: Regular;', '', $str);
            $str = str_replace('font-family: Bold;', '', $str);
            $str = str_replace('font-family: Rounded;', '', $str);
            $str = str_replace('sup>', 'tap>', $str);
            $studentAttempt->answer4 = $str;
            $studentAttempt->correct = $value->correct;
            //description
            $str = $value->description;
            $regularExpression = "/class=\"[^<]*\"\s/i";
            $str = preg_replace($regularExpression, "", $str);
            $mystring2 = ' class="regular" ';
            $count = substr_count($str, 'Regular;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern = "/span style=\"[^>]*font-family: Regular;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring2, $pos, 0);

                    $off = $pos + 17;
                }
            }
            $mystring3 = ' class="bold" ';
            $count = substr_count($str, 'Bold;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern
                    = "/<span style=\"[^>]*font-family: Bold;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring3, $pos, 0);

                    $off = $pos + 14;
                }
            }
            $mystring4 = ' class="round" ';
            $count = substr_count($str, 'Rounded;');
            $off = 0;
            for ($i = 0; $i < $count; $i++) {
                $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                if (!empty($matches[0][1])) {
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring4, $pos, 0);

                    $off = $pos + 17;
                }
            }
            $str = str_replace('font-family: Regular;', '', $str);
            $str = str_replace('font-family: Bold;', '', $str);
            $str = str_replace('font-family: Rounded;', '', $str);
            $str = str_replace('sup>', 'tap>', $str);
            $studentAttempt->description = $str;
            $studentAttempt->studentExamRecordId = $studentExamRecord->id;
            $studentAttempt->image = "https://neoestudio.net/" . $value->image;
            $studentAttempt->save();
        }
        $studentAttempts = \App\StudentAttempt::where('studentExamRecordId', $studentExamRecord->id)->get();

        if (!empty($tab)) {
            if (!empty($studentAttempts)) {
                foreach ($studentAttempts as $key => $value) {
                    $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->question);
                    $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                    $value->setAttribute('question', $str);

                    $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer1);
                    $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                    $value->setAttribute('answer1', $str);

                    $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer2);
                    $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                    $value->setAttribute('answer2', $str);

                    $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer3);
                    $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                    $value->setAttribute('answer3', $str);

                    $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer4);
                    $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                    $value->setAttribute('answer4', $str);

                    $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->description);
                    $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                    $value->setAttribute('description', $str);
                }
            }
        }

        $totalItems = \App\StudentAttempt::where('studentExamRecordId', $studentExamRecord->id)->count();


        return response()->json(['status' => 'Successfull', 'data' => $studentAttempts,
            'canPause' => $studentExamRecord->canPause, 'examDuration' => $examDuration, 'studentExamRecordId' => $studentExamRecord->id, 'totalItems' => $totalItems]);
    }

    public function storeAnswer(Request $request)
    {


    }

    public function pauseAnswer(Request $request)
    {
        $studentExamRecordId = $request->json('studentExamRecordId');
        $studentExamRecord = \App\StudentExamRecord::find($studentExamRecordId);

        $ue = \App\User::where('id', $studentExamRecord->studentId)->exists();
        if ($ue == false) {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $u = \App\User::find($studentExamRecord->studentId);
        if ($u->field1x == "Bloquear") {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        if ($studentExamRecord->status == "paused") {
            $data = array();
            return response()->json(['status' => 'Successfull', 'data' => $data]);
        }
        $exam = \App\Exam::find($studentExamRecord->examId);
        $res = $exam->timeFrom - $request->json('time');

        $studentExamRecord->status = "paused";
        $endT = Carbon::parse($studentExamRecord->officialEndingTime);
        $studentExamRecord->examDuration = $endT->diffInSeconds(Carbon::now());
        //$studentExamRecord->examDuration=$exam->timeFrom-$res;
        $studentExamRecord->pausedTime = Carbon::now()->toDateTimeString();


        $studentExamRecord->save();

        return response()->json(['status' => 'Successfull', 'data' => $studentExamRecord]);
    }

    public function endExam(Request $request)
    {
        $correctCount = 0;
        $wrongCount = 0;
        $attemptedCount = 0;
        $nonAttemptedCount = 0;

        $studentExamRecordId = $request->json('studentExamRecordId');
        $studentExamRecord = \App\StudentExamRecord::find($studentExamRecordId);


        $ue = \App\User::where('id', $studentExamRecord->studentId)->exists();
        if ($ue == false) {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $u = \App\User::find($studentExamRecord->studentId);
        if ($u->field1x == "Bloquear") {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }

        $exam = \App\Exam::find($studentExamRecord->examId);
        //reschedule game
        $exists = \App\Reschedule::where('studentId', $studentExamRecord->studentId)->where('examId', $exam->id)->exists();
        if ($exists == true) {
            $ress = \App\Reschedule::where('studentId', $studentExamRecord->studentId)->where('examId', $exam->id)->get();
            foreach ($ress as $key => $r) {
                $r->status = "Deshabilitado";
                $r->save();
            }
        }
        //end reshchedule
        if (!empty($exam->courseId)) {
            $course = \App\Course::find($exam->courseId);
        }
        $totalTime = gmdate("i:s", $exam->timeFrom);
        if ($studentExamRecord->status != "end") {
            $studentExamRecord->studentAttemptedEndingTime = Carbon::now()->toDateTimeString();


            if (!empty($request->json('time'))) {
                $res = $exam->timeFrom - $request->json('time');
                $studentExamRecord->examDuration = $res;
                $studentExamRecord->status = "end";
                $studentExamRecord->studentAttemptedEndingTime = Carbon::now()->toDateTimeString();
                $studentExamRecord->endingWay = "appRequest";
                $studentExamRecord->save();
            }
            if (empty($request->json('time'))) {

                $res = $exam->timeFrom;
                $studentExamRecord->examDuration = $res;
                $studentExamRecord->status = "end";
                $studentExamRecord->studentAttemptedEndingTime = Carbon::now()->toDateTimeString();
                $studentExamRecord->endingWay = "appRequest";
                $studentExamRecord->save();

            }
        }

        $studentExamDuration = gmdate("i:s", $studentExamRecord->examDuration);
        $answersArray = array();


        $studentAttempts = \App\StudentAttempt::where('studentExamRecordId', $studentExamRecord->id)->get();
        $studentAttemptsCount = \App\StudentAttempt::where('studentExamRecordId', $studentExamRecord->id)->count();
        $score = 0;
        $folder = \App\Folder::find($exam->folderId);
        if ($folder->type == "exams") {
            foreach ($studentAttempts as $key => $value) {
                $studentAnswered = $value->studentAnswered;
                $correctValue = $value->correct;
                if ($correctValue == 'a') {
                    $correctAnswer = "answer1";
                }
                if ($correctValue == 'b') {
                    $correctAnswer = "answer2";
                }
                if ($correctValue == 'c') {
                    $correctAnswer = "answer3";
                }
                if ($correctValue == 'd') {
                    $correctAnswer = "answer4";
                }
                if (empty($studentAnswered)) {
                    $nonAttemptedCount = $nonAttemptedCount + 1;
                    $answersArray[$key] = "notAttempted";
                }
                if (!empty($studentAnswered)) {
                    if ($course->name == "Conocimientos" || $course->name == "Inglés") {
                        if ($studentAnswered == $correctAnswer) {
                            $correctCount = $correctCount + 1;
                            $attemptedCount = $attemptedCount + 1;
                            $answersArray[$key] = "correct";
                            $score = $score + 1;
                        }
                        if ($studentAnswered != $correctAnswer) {
                            $wrongCount = $wrongCount + 1;
                            $attemptedCount = $attemptedCount + 1;
                            $answersArray[$key] = "wrong";
                            $score = $score - 0.33;
                        }
                    }
                    if ($course->name == "Ortografía") {
                        if ($studentAnswered == $correctAnswer) {
                            $correctCount = $correctCount + 1;
                            $attemptedCount = $attemptedCount + 1;
                            $answersArray[$key] = "correct";
                            $score = $score + 1;
                        }
                        if ($studentAnswered != $correctAnswer) {
                            $wrongCount = $wrongCount + 1;
                            $attemptedCount = $attemptedCount + 1;
                            $answersArray[$key] = "wrong";
                        }
                    }
                    if ($course->name == "Psicotécnicos") {
                        if ($studentAnswered == $correctAnswer) {
                            $correctCount = $correctCount + 1;
                            $attemptedCount = $attemptedCount + 1;
                            $answersArray[$key] = "correct";
                            $score = $score + 2;
                        }
                        if ($studentAnswered != $correctAnswer) {
                            $wrongCount = $wrongCount + 1;
                            $attemptedCount = $attemptedCount + 1;
                            $answersArray[$key] = "wrong";
                            $score = $score - 0.666;
                        }

                    }

                }

            }
            /*if($course->name=="Psicotécnicos"){
                $one=15/$studentAttemptsCount;
                $last=$wrongCount/3;
                $second=$correctCount-$last;
                $score=$one*$second;
            }*/
            if ($course->name == "Psicotécnicos") {
                if ($score < 9) {
                    $studentExamRecord->result = "NO APTO";
                }
                if ($score >= 9) {
                    $studentExamRecord->result = "APTO";
                }
            }
            if ($course->name == "Inglés") {
                if ($score < 8) {
                    $studentExamRecord->result = "NO APTO";
                }
                if ($score >= 8) {
                    $studentExamRecord->result = "APTO";
                }
            }
            if ($course->name == "Conocimientos") {
                if ($score < 12.5) {
                    $studentExamRecord->result = "NO APTO";
                }
                if ($score >= 12.5) {
                    $studentExamRecord->result = "APTO";
                }
            }
            if ($course->name == "Ortografía") {
                if ($score < 15) {
                    $studentExamRecord->result = "NO APTO";
                }
                if ($score >= 15) {
                    $studentExamRecord->result = "APTO";
                }
            }
        }
        if ($folder->type != "exams") {

            $folder = \App\Folder::find($exam->folderId);
            if ($folder->type == "personalities") {
                foreach ($studentAttempts as $key => $value) {
                    $studentAnswered = $value->studentAnswered;
                    $correctValue = $value->correct;
                    if ($correctValue == 'a y b') {
                        $correctAnswer = array("answer1", "answer2");
                    }
                    if ($correctValue == 'c y d') {
                        $correctAnswer = array("answer3", "answer4");
                    }
                    if (empty($studentAnswered)) {
                        $nonAttemptedCount = $nonAttemptedCount + 1;
                        $answersArray[$key] = "notAttempted";
                    }
                    if (!empty($studentAnswered)) {
                        if (in_array($studentAnswered, $correctAnswer)) {
                            $correctCount = $correctCount + 1;
                            $attemptedCount = $attemptedCount + 1;
                            $answersArray[$key] = "correct";
                            $score = $score + 1;
                        } else {
                            $wrongCount = $wrongCount + 1;
                            $attemptedCount = $attemptedCount + 1;
                            $answersArray[$key] = "wrong";
                            $score = $score - 0.33;
                        }
                    }

                }
            }
            if ($folder->type == "reviews") {
                foreach ($studentAttempts as $key => $value) {
                    $studentAnswered = $value->studentAnswered;
                    $correctValue = $value->correct;
                    if ($correctValue == 'a') {
                        $correctAnswer = "answer1";
                    }
                    if ($correctValue == 'b') {
                        $correctAnswer = "answer2";
                    }
                    if ($correctValue == 'c') {
                        $correctAnswer = "answer3";
                    }
                    if ($correctValue == 'd') {
                        $correctAnswer = "answer4";
                    }
                    if (empty($studentAnswered)) {
                        $nonAttemptedCount = $nonAttemptedCount + 1;
                        $answersArray[$key] = "notAttempted";
                    }
                    if (!empty($studentAnswered)) {
                        if ($studentAnswered == $correctAnswer) {
                            $correctCount = $correctCount + 1;
                            $attemptedCount = $attemptedCount + 1;
                            $answersArray[$key] = "correct";
                            $score = $score + 1;
                        }
                        if ($studentAnswered != $correctAnswer) {
                            $wrongCount = $wrongCount + 1;
                            $attemptedCount = $attemptedCount + 1;
                            $answersArray[$key] = "wrong";
                        }
                    }
                }
            }
        }
        if ($score < 0) {
            $score = 0;
        }

        $studentExamRecord->score = round($score, 2);
        $studentExamRecord->save();

        if ($studentAttemptsCount == 0) {
            $studentAttemptsCount = 1;
        }
        $correctP = $correctCount / $studentAttemptsCount;
        $correctPercentage = $correctP * 100;
        $wrongP = $wrongCount / $studentAttemptsCount;
        $wrongPercentage = $wrongP * 100;
        $nullP = $nonAttemptedCount / $studentAttemptsCount;
        $nullPercentage = $nullP * 100;
        if ($folder->type == "exams") {
            $course = \App\Course::find($exam->courseId);
            if ($course->name == "Psicotécnicos") {
                $totalPoints = 15;
            }
            if ($course->name == "Inglés") {
                $totalPoints = 20;
            }
            if ($course->name == "Conocimientos") {
                $totalPoints = 25;
            }
            if ($course->name == "Ortografía") {
                $totalPoints = 20;
            }
            $existsCmb = \App\CombineResult::where('courseId', $exam->courseId)
                ->where('studentId', $studentExamRecord->studentId)->where('folderId', $exam->folderId)->exists();
            if ($existsCmb == true) {
                $find = \App\CombineResult::where('courseId', $exam->courseId)
                    ->where('studentId', $studentExamRecord->studentId)->where('folderId', $exam->folderId)->first();
                $find->points = $find->points + $studentExamRecord->score;
                $find->totalPoints = $find->totalPoints + $totalPoints;
                $find->field1x = $find->field1x + 1;
                $find->save();
            }
            if ($existsCmb == false) {
                $combineResult = new \App\CombineResult;
                $combineResult->courseId = $exam->courseId;
                $combineResult->folderId = $exam->folderId;
                $combineResult->studentId = $studentExamRecord->studentId;
                $combineResult->points = $studentExamRecord->score;
                $combineResult->totalPoints = $totalPoints;
                $combineResult->field1x = 1;
                $combineResult->save();
            }
        }
        return response()->json(['status' => 'Successfull', 'examName' => $exam->name, 'score' => $studentExamRecord->score, 'correctCount' => $correctCount, 'wrongCount' => $wrongCount, 'attemptedCount' => $attemptedCount, 'nonAttemptedCount' => $nonAttemptedCount, 'examDuration' => $studentExamDuration, 'totalTime' => $totalTime, 'answersArray' => $answersArray, 'correctPercentage' => $correctPercentage, 'wrongPercentage' => $wrongPercentage, 'nullPercentage' => $nullPercentage,
            'result' => $studentExamRecord->result]);

    }

    public function timeTest()
    {
        $examDuration = "3600";
        //time
        $endingTime = Carbon::now()->addSeconds($examDuration);
        $currentTime = Carbon::now();
        dd($endingTime, $currentTime);
    }

    public function getRecords()
    {
        $records = \App\StudentExamRecord::all();
        return response()->json($records);
    }

    public function reviewExam(Request $request)
    {
        $studentExamRecordId = $request->json('studentExamRecordId');
        $tab = $request->json('tab');
        $studentExamRecord = \App\StudentExamRecord::find($studentExamRecordId);
        $ue = \App\User::where('id', $studentExamRecord->studentId)->exists();
        if ($ue == false) {
            return response()->json(['status', 'Unsuccessfull', 'message' => 'User not found']);
        }
        $u = \App\User::find($studentExamRecord->studentId);
        if ($u->field1x == "Bloquear") {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }


        $exam = \App\Exam::find($studentExamRecord->examId);

        $folder = \App\Folder::find($exam->folderId);

        $studentAttempts = \App\StudentAttempt::select('*', DB::raw("REPLACE(description,'text-align: start','text-align: justify') AS description"))->where('studentExamRecordId', $studentExamRecord->id)->get();
        if (!empty($tab)) {
            if (!empty($studentAttempts)) {
                foreach ($studentAttempts as $key => $value) {
                    $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->question);
                    $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                    $value->setAttribute('question', $str);

                    $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer1);
                    $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                    $value->setAttribute('answer1', $str);

                    $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer2);
                    $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                    $value->setAttribute('answer2', $str);

                    $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer3);
                    $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                    $value->setAttribute('answer3', $str);

                    $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->answer4);
                    $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                    $value->setAttribute('answer4', $str);

                    $str = str_replace('font-size: 13pt', 'font-size: 30px', $value->description);
                    $str = str_replace('font-size: 13px', 'font-size: 30px', $str);
                    $value->setAttribute('description', $str);
                }
            }
        }
        $totalItems = \App\StudentAttempt::where('studentExamRecordId', $studentExamRecord->id)->count();
        if ($folder->type == "exams") {
            foreach ($studentAttempts as $key => $value) {
                $studentAnswered = $value->studentAnswered;
                $correctValue = $value->correct;
                if ($correctValue == 'a') {
                    $correctAnswer = "answer1";
                }
                if ($correctValue == 'b') {
                    $correctAnswer = "answer2";
                }
                if ($correctValue == 'c') {
                    $correctAnswer = "answer3";
                }
                if ($correctValue == 'd') {
                    $correctAnswer = "answer4";
                }
                if (empty($studentAnswered)) {
                    $value->setAttribute('status', 'notAttempted');
                }
                if (!empty($studentAnswered)) {

                    if ($studentAnswered == $correctAnswer) {
                        $value->setAttribute('status', 'correct');
                    }
                    if ($studentAnswered != $correctAnswer) {
                        $value->setAttribute('status', 'wrong');

                    }
                }
            }
        }
        if ($folder->type != "exams") {
            if ($folder->type == "personalities") {
                foreach ($studentAttempts as $key => $value) {
                    $studentAnswered = $value->studentAnswered;
                    $correctValue = $value->correct;
                    if ($correctValue == 'a y b') {
                        $correctAnswer = array("answer1", "answer2");
                    }
                    if ($correctValue == 'c y d') {
                        $correctAnswer = array("answer3", "answer4");
                    }
                    if (empty($studentAnswered)) {
                        $value->setAttribute('status', 'notAttempted');
                    }
                    if (!empty($studentAnswered)) {
                        if (in_array($studentAnswered, $correctAnswer)) {
                            $value->setAttribute('status', 'correct');
                        } else {
                            $value->setAttribute('status', 'wrong');
                        }
                    }
                }
            }
            if ($folder->type == "reviews") {
                foreach ($studentAttempts as $key => $value) {
                    $studentAnswered = $value->studentAnswered;
                    $correctValue = $value->correct;
                    if ($correctValue == 'a') {
                        $correctAnswer = "answer1";
                    }
                    if ($correctValue == 'b') {
                        $correctAnswer = "answer2";
                    }
                    if ($correctValue == 'c') {
                        $correctAnswer = "answer3";
                    }
                    if ($correctValue == 'd') {
                        $correctAnswer = "answer4";
                    }
                    if (empty($studentAnswered)) {
                        $value->setAttribute('status', 'notAttempted');
                    }
                    if (!empty($studentAnswered)) {
                        if ($studentAnswered == $correctAnswer) {
                            $value->setAttribute('status', 'correct');
                        }
                        if ($studentAnswered != $correctAnswer) {
                            $value->setAttribute('status', 'wrong');
                        }
                    }
                }
            }
        }

        if ($folder->type == "exams") {

            /*$combineResult=\App\CombineResult::where('folderId',$folder->id)->where('courseId',$exam->courseId)->where('studentId',$u->id)->first();
            if(!empty($combineResult)){
                $combineResult->startRevisionTime=Carbon::now()->toDateTimeString();
                $combineResult->revisionStatus="start";
                $combineResult->save();
            }*/
            //for perfect revision
            $ttD = Carbon::now()->toDateString();
            $exists = \App\Revision::where('studentId', $u->id)->where('courseId', $exam->courseId)->where('revisionDate', $ttD)->where('studentType', $u->type)->exists();
            if ($exists == false) {

                $revision = new \App\Revision;
                $revision->revisionDate = $ttD;

                $revision->studentId = $u->id;
                $revision->courseId = $exam->courseId;
                $revision->startRevisionTime = Carbon::now()->toDateTimeString();
                $revision->revisionStatus = "start";
                $revision->studentType = $u->type;
                $revision->save();
            }
            if ($exists == true) {
                $revision = \App\Revision::where('studentId', $u->id)->where('courseId', $exam->courseId)->where('revisionDate', $ttD)->where('studentType', $u->type)->first();
                $revision->startRevisionTime = Carbon::now()->toDateTimeString();
                $revision->revisionStatus = "start";
                $revision->save();
            }
            // end revsion
        }
        return response()->json(['status' => 'Successfull', 'data' => $studentAttempts, 'totalItems' => $totalItems]);

    }

    public function endReview(Request $request)
    {
        $todayDate = Carbon::now()->toDateString();
        $studentExamRecordId = $request->json('studentExamRecordId');
        $studentExamRecord = \App\StudentExamRecord::find($studentExamRecordId);
        $ue = \App\User::where('id', $studentExamRecord->studentId)->exists();
        if ($ue == false) {
            return response()->json(['status', 'Unsuccessfull', 'message' => 'User not found']);
        }
        $u = \App\User::find($studentExamRecord->studentId);
        if ($u->field1x == "Bloquear") {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }


        $exam = \App\Exam::find($studentExamRecord->examId);

        $folder = \App\Folder::find($exam->folderId);
        if ($folder->type == "exams") {
            $revision = \App\Revision::where('courseId', $exam->courseId)->where('studentId', $u->id)->where('studentType', $u->type)->where('revisionDate', $todayDate)->first();
            if (!empty($revision)) {
                if ($revision->revisionStatus == "start") {
                    $revision->revisionStatus = "end";
                    $now = Carbon::now()->toDateTimeString();
                    $diff = Carbon::parse($revision->startRevisionTime)->diffInSeconds(Carbon::parse($now));
                    $revision->revision = $revision->revision + $diff;
                    $revision->save();
                }
            }

        }
        return response()->json(['status' => 'Successfull']);
    }

    public function getStudents()
    {
        $users = \App\User::all();
        if (empty($users)) {
            $users = array();
        }
        return response()->json($users);
    }

    public function getExams()
    {
        $exams = \App\Exam::all();
        if (empty($exams)) {
            $exams = array();
        }
        return response()->json($exams);
    }

    public function getFolders()
    {
        $folders = \App\Folder::all();
        if (empty($folders)) {
            $folders = array();
        }
        return response()->json($folders);
    }

    public function reviewDrawr(Request $request)
    {
        $id = $request->json('id');
        $correctCount = 0;
        $wrongCount = 0;
        $attemptedCount = 0;
        $nonAttemptedCount = 0;
        $score = 0;
        $record = \App\StudentExamRecord::find($id);
        $ue = \App\User::where('id', $record->studentId)->exists();
        if ($ue == false) {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $u = \App\User::find($record->studentId);
        if ($u->field1x == "Bloquear") {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }

        $exam = \App\Exam::find($record->examId);
        $course = array();
        if(isset($exam->courseId) && empty($exam->courseId) == false){
            $course = \App\Course::find($exam->courseId);
        }
        $folder = \App\Folder::find($exam->folderId);
        if ($folder->type != "personalities") {

            $questions = \App\StudentAttempt::where('studentExamRecordId', $record->id)->get();

            $studentAttemptsCount = \App\StudentAttempt::where('studentExamRecordId', $record->id)->count();
            foreach ($questions as $key => $value) {
                $studentAnswered = $value->studentAnswered;
                $correctValue = $value->correct;
                if ($correctValue == 'a') {
                    $correctAnswer = "answer1";
                }
                if ($correctValue == 'b') {
                    $correctAnswer = "answer2";
                }
                if ($correctValue == 'c') {
                    $correctAnswer = "answer3";
                }
                if ($correctValue == 'd') {
                    $correctAnswer = "answer4";
                }
                if (empty($studentAnswered)) {
                    $nonAttemptedCount = $nonAttemptedCount + 1;
                    $answersArray[$key] = "notAttempted";
                }
                if (!empty($studentAnswered)) {

                    if ($studentAnswered == $correctAnswer) {
                        $correctCount = $correctCount + 1;
                        $attemptedCount = $attemptedCount + 1;
                        $answersArray[$key] = "correct";
                    }
                    if ($studentAnswered != $correctAnswer) {
                        $wrongCount = $wrongCount + 1;
                        $attemptedCount = $attemptedCount + 1;
                        $answersArray[$key] = "wrong";
                    }


                }
            }
            //}

            $correctScore = 0;
            $wrongScore = 0;
            foreach ($questions as $key => $value) {
                $studentAnswered = $value->studentAnswered;
                $correctValue = $value->correct;
                if ($correctValue == 'a') {
                    $correctAnswer = "answer1";
                }
                if ($correctValue == 'b') {
                    $correctAnswer = "answer2";
                }
                if ($correctValue == 'c') {
                    $correctAnswer = "answer3";
                }
                if ($correctValue == 'd') {
                    $correctAnswer = "answer4";
                }

                if (!empty($studentAnswered) && empty($course) === false) {
                    if ($course->name == "Conocimientos" || $course->name == "Inglés") {
                        if ($studentAnswered == $correctAnswer) {

                            $correctScore = $correctScore + 1;
                        }
                        if ($studentAnswered != $correctAnswer) {

                            $score = $score - 0.33;
                            $wrongScore = $wrongScore + 0.33;
                        }
                    }
                    if ($course->name == "Ortografía") {
                        if ($studentAnswered == $correctAnswer) {

                            $score = $score + 1;
                            $correctScore = $correctScore + 1;
                        }

                    }
                    if ($course->name == "Psicotécnicos") {
                        if ($studentAnswered == $correctAnswer) {

                            $score = $score + 2;
                            $correctScore = $correctScore + 2;
                        }
                        if ($studentAnswered != $correctAnswer) {

                            $score = $score - 0.666;
                            $wrongScore = $wrongScore + 0.666;
                        }
                    }

                }

            }
        }
        if ($folder->type == "personalities") {

            $questions = \App\StudentAttempt::where('studentExamRecordId', $record->id)->get();

            $studentAttemptsCount = \App\StudentAttempt::where('studentExamRecordId', $record->id)->count();
            foreach ($questions as $key => $value) {
                $studentAnswered = $value->studentAnswered;
                $correctValue = $value->correct;
                if ($correctValue == 'a y b') {
                    $correctAnswer = array("answer1", "answer2");
                }
                if ($correctValue == 'c y d') {
                    $correctAnswer = array("answer3", "answer4");
                }
                if (empty($studentAnswered)) {
                    $nonAttemptedCount = $nonAttemptedCount + 1;
                    $answersArray[$key] = "notAttempted";
                }
                if (!empty($studentAnswered)) {
                    if (in_array($studentAnswered, $correctAnswer)) {
                        $correctCount = $correctCount + 1;
                        $attemptedCount = $attemptedCount + 1;
                        $answersArray[$key] = "correct";

                    } else {
                        $wrongCount = $wrongCount + 1;
                        $attemptedCount = $attemptedCount + 1;
                        $answersArray[$key] = "wrong";

                    }
                }
            }
            //}

            $correctScore = 0;
            $wrongScore = 0;
            foreach ($questions as $key => $value) {
                $studentAnswered = $value->studentAnswered;
                $correctValue = $value->correct;
                if ($correctValue == 'a y b') {
                    $correctAnswer = array("answer1", "answer2");
                }
                if ($correctValue == 'c y d') {
                    $correctAnswer = array("answer3", "answer4");
                }

                if (!empty($studentAnswered)) {


                    if (in_array($studentAnswered, $correctAnswer)) {
                        $correctScore = $correctScore + 1;
                        $score = $score + 1;
                    } else {
                        $wrongScore = $wrongScore + 1;
                        $score = $score - 0.33;
                    }


                }

            }
        }

        $totalCount = \App\StudentAttempt::where('studentExamRecordId', $record->id)->count();
        $score = 0;
        $time = $record->examDuration / 60;
        $first = intval($time);

        $second = $record->examDuration - $first * 60;
        $firstL = strlen($first);
        if ($firstL < 2) {
            $first = "0" . $first;
        }
        $secondL = strlen($second);
        if ($secondL < 2) {
            $second = "0" . $second;
        }
        $time = $first . ":" . $second;
        $score = $record->score;
        $wrongScore = number_format($wrongScore, 2);
        return response()->json(['status' => 'Successfull', 'time' => $time, 'totalQuestions' => $totalCount, 'correctCount' => $correctCount, 'correctScore' => $correctScore, 'wrongCount' => $wrongCount, 'wrongScore' => $wrongScore, 'nonAttemptedCount' => $nonAttemptedCount, 'nonAttemptedScore' => '0', 'score' => $score]);


    }


}
