<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class PersonalityController extends Controller
{
    public function getAllPersonalityExams(Request $request)
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
        $folder = \App\Folder::where('type', 'personalities')->where('studentType', $request->json('studentType'))->first();
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
            $isActive = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'personalities')->where('typeId1', $value->id)->exists();
            $value->setAttribute('isActive', $isActive);
        }
        $personalityExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'personalities')->exists();
        if ($personalityExists == true) {
            $personalitys = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'personalities')->get();
            foreach ($personalitys as $key => $value) {
                $value->delete();
            }

        }
        return response()->json(['status' => "Successfull", 'data' => $exams]);
    }


}
