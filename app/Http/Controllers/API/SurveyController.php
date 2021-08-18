<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SurveyController extends Controller
{
    public function surveyList(Request $request)
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
        $surveys = \App\Survey::where('studentType', $request->json('studentType'))->get();
        foreach ($surveys as $key => $value) {
            $isActive = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'surveys')->where('typeId1', $value->id)->exists();
            $value->setAttribute('isActive', $isActive);
        }
        $surveyExists = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'surveys')->exists();
        if ($surveyExists == true) {
            $surveysN = \App\Notification::where('status', 'pending')->where('studentId', $studentId)->where('type', 'surveys')->get();
            foreach ($surveysN as $key => $value) {
                //$value->status="seen";
                $value->delete();
            }
        }
        return response()->json(['status' => 'Successfull', 'data' => $surveys]);
    }

    public function getSurveyQuestions(Request $request)
    {
        $studentId = $request->json('studentId');
        $survey = \App\Survey::find($request->json('surveyId'));
        $ue = \App\User::where('id', $studentId)->exists();
        if ($ue == false) {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $u = \App\User::find($studentId);
        if ($u->field1x == "Bloquear") {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $exists = \App\StudentSurveyRecord::where('studentId', $request->json('studentId'))
            ->where('surveyId', $request->json('surveyId'))->exists();
        if ($exists == false) {
            $questions = \App\Question::where('surveyId', $request->json('surveyId'))->get();
            foreach ($questions as $key => $value) {
                $value->setAttribute('value', 0);
                $value->setAttribute('answer', 'empty');
            }
            return response()->json(['status' => 'Successfull', 'data' => $questions, 'title' => $survey->title]);
        }
        if ($exists == true) {
            $surveyRecord = \App\StudentSurveyRecord::where('studentId', $request->json('studentId'))
                ->where('surveyId', $request->json('surveyId'))->first();
            $attempts = \App\StudentSurveyAttempt::where('surveyRecordId', $surveyRecord->id)->get();
            //return response()->json($attempts);
            $questions = \App\Question::where('surveyId', $request->json('surveyId'))->get();
            foreach ($questions as $key => $value) {
                if (isset($attempts[$key])) {
                    $value->setAttribute('value', (int)$attempts[$key]->starResponse);
                    $value->setAttribute('answer', $attempts[$key]->descriptionResponse);
                }
            }
            return response()->json(['status' => 'Successfull', 'data' => $questions, 'title' => $survey->title]);
        }

    }

    public function getSurveyTest(Request $request)
    {
        $studentId = $request->json('studentId');
        $survey = \App\Survey::find($request->json('surveyId'));
        $ue = \App\User::where('id', $studentId)->exists();
        if ($ue == false) {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $u = \App\User::find($studentId);
        if ($u->field1x == "Bloquear") {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $data = $request->json('data');
        $exists = \App\StudentSurveyRecord::where('studentId', $request->json('studentId'))
            ->where('surveyId', $request->json('surveyId'))->exists();
        if ($exists == true) {
            $surveyRecord = \App\StudentSurveyRecord::where('studentId', $request->json('studentId'))
                ->where('surveyId', $request->json('surveyId'))->first();
            $studentAttempts = \App\StudentSurveyAttempt::where('surveyRecordId', $surveyRecord->id)->get();
            foreach ($studentAttempts as $key => $value) {
                $value->delete();
            }
            $surveyRecord->delete();
        }
        $studentSurveyRecord = new \App\StudentSurveyRecord;
        $studentSurveyRecord->studentId = $request->json('studentId');
        $studentSurveyRecord->surveyId = $request->json('surveyId');
        $studentSurveyRecord->title = $survey->title;
        $studentSurveyRecord->save();


        if(isset($data) && empty($data) === false){
            foreach ($data as $key => $value) {
                $ssa = new \App\StudentSurveyAttempt;
                $question = \App\Question::where('surveyId', $request->json('surveyId'))->where('id', $value['id'])->first();
                $ssa->surveyRecordId = $studentSurveyRecord->id;
                $ssa->question = $question->question;
                $ssa->star = $question->star;
                $ssa->description = $question->description;
                $ssa->starResponse = $value['value'];
                $ssa->descriptionResponse = $value['answer'];

                $ssa->save();
            }
        }
        return response()->json(['status' => 'Successfull']);

    }
}
