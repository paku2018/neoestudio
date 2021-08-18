<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
class ReviewController extends Controller
{
    //api for get review of folders with there exams
    public function getAllReviewExams(Request $request)
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
        $folder = \App\Folder::where('type', 'reviews')->where('studentType', $request->json('studentType'))->first();

        $offset = 0;
        $limit = '25';
        $req_offset = $request->json('offset');
        if (isset($req_offset) && empty($req_offset) === false) {
            $offset = ($req_offset == 1) ? 0 : (($req_offset - 1) * $limit);
        }
        $exams = \App\Exam::where('folderId', $folder->id)->limit($limit)->offset($offset)->get();
        foreach ($exams as $key => $value) {
            if ($value->status == "Habilitado") {
                $value->setAttribute('studentStatus', 'Habilitado');
            }
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
            $isActive = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'reviews')->where('typeId1', $value->id)->exists();
            $value->setAttribute('isActive', $isActive);
        }

        if (empty($exams)) {
            $exams = array();
        }


        $reviewExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'reviews')->exists();
        if ($reviewExists == true) {
            $reviews = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'reviews')->get();
            foreach ($reviews as $key => $value) {
                //$value->status="seen";
                //$value->save();
                $value->delete();
            }

        }

        return response()->json(['status' => "Successfull", 'data' => $exams]);
    }

    //api for get folders only
    public function getAllReviewFolders(Request $request)
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
        $limit = '25';
        $req_offset = $request->json('offset');
        if (isset($req_offset) && empty($req_offset) === false) {
            $offset = ($req_offset == 1) ? 0 : (($req_offset - 1) * $limit);
        }
        $firstFolder = \App\Folder::where('type', 'reviews')->where('studentType', $request->json('studentType'))->first();
        $folders = \App\Folder::where('type', 'reviews')->where('studentType', $request->json('studentType'))->orderByRaw(DB::raw('IF(id = '.$firstFolder->id.', 1, 0) ASC'))->get();
        foreach ($folders as $key => $value) {
            if ($value->status == "Habilitado") {
                $value->setAttribute('studentStatus', 'Habilitado');
            }
        }

        if (empty($folders)) {
            $folders = array();
        }
        return response()->json(['status' => "Successfull", 'data' => $folders]);
    }

    public function getreviewFolderExams(Request $request)
    {
        $folderId = $request->json('folderId');
        $studentType = $request->json('studentType');
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
        $limit = '25';
        $req_offset = $request->json('offset');
        if (isset($req_offset) && empty($req_offset) === false) {
            $offset = ($req_offset == 1) ? 0 : (($req_offset - 1) * $limit);
        }
        $exams = \App\Exam::where('folderId', $folderId)->where('studentType', $studentType)->limit($limit)->offset($offset)->get();
        foreach ($exams as $key => $value) {
            if ($value->status == "Habilitado") {
                $value->setAttribute('studentStatus', 'Habilitado');
            }
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
            $isActive = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'reviews')->where('typeId1', $value->id)->exists();
            $value->setAttribute('isActive', $isActive);
        }

        if (empty($exams)) {
            $exams = array();
        }


        $reviewExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'reviews')->exists();
        if ($reviewExists == true) {
            $reviews = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'reviews')->get();
            foreach ($reviews as $key => $value) {
                //$value->status="seen";
                //$value->save();
                $value->delete();
            }

        }

        return response()->json(['status' => "Successfull", 'data' => $exams]);
    }

    //api to enabe examp for student - SK - 210623
    public function updateStatus(Request $request){
        $examId = $request->json('examId');
        $studentType = $request->json('studentType');
        $studentId = $request->json('studentId');
        $ue = \App\User::where('id', $studentId)->exists();
        if ($ue == false) {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $u = \App\User::find($studentId);
        if ($u->field1x == "Bloquear") {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $exam = \App\Exam::where('id', $examId)->where('studentType', $studentType)->first();
        if(isset($exam) && empty($exam) === false){
            \App\Exam::where('id', $exam->id)->update(['status' => 'Habilitado']);
            return response()->json(['status' => 'Successful', 'message' => 'Status is updated']);
        }
        return response()->json(['status' => 'Unsuccessful', 'message' => 'No exam found!']);

    }
}
