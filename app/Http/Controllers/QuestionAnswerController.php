<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\mughees;
/*use Illuminate\Support\Facades\Input;*/
use ZanySoft\Zip\ZipManager;
use ZanySoft\Zip\Zip;
use Illuminate\Support\Arr;

class QuestionAnswerController extends Controller
{
    public function index($examId)
    {

        $exam = \App\Exam::find($examId);

        $questions = \App\Questionanswer::where('examId', $examId)->get();
        return view('questionanswers.index', compact('questions', 'exam'));
    }

    public function create($examId)
    {
        $exam = \App\Exam::find($examId);
        return view('questionanswers.create', compact('exam'));

    }

    public function store(Request $request)
    {
        $id = $request->get('examId');
        if (!empty('fileP')) {
            Excel::import(new mughees($id), $request->file('fileP'));
        }
        $message = "Preguntas Respuestas guardadas con éxito";
        return redirect()->back()->with('message', $message);

    }

    public function edit($id)
    {
        $question = \App\Questionanswer::find($id);

        return view('questionanswers.edit', compact('question'));
    }

    public function update(Request $request, $id)
    {

        $qa = \App\Questionanswer::find($id);
        $qa->question = $request->get('question');
        $qa->answer1 = $request->get('answer1');
        $qa->answer2 = $request->get('answer2');
        $qa->answer3 = $request->get('answer3');
        $qa->answer4 = $request->get('answer4');
        $qa->correct = $request->get('correct');
        $qa->description = $request->get('description');
        $qa->examId = $request->get('examId');
        $materialFile = $request->file("image");
        $check = $request->get('check');

        if ($check == null) {
            if (!empty($materialFile)) {
                $newFilename = $materialFile->getClientOriginalName();
                $mimeType = $materialFile->getMimeType();
                $destinationPath = 'psycho';
                $materialFile->move($destinationPath, $newFilename);
                $filePath = 'psycho/' . $newFilename;
                $qa->image = $filePath;
            }
        }

        $qa->save();
        $ats = \App\StudentAttempt::where('qaId', $id)->get();
        if (!empty($ats)) {
            foreach ($ats as $key => $studentAttempt) {
                $str = $qa->question;
                $regularExpression = "/class=\"[^<]*\"\s/i";
                $str = preg_replace($regularExpression, "", $str);

                $mystring2 = ' class="regular" ';
                $count = substr_count($str, 'Regular;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern = "/span style=\"[^>]*font-family: Regular;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring2, $pos, 0);
                    $off = $pos + 17;
                }
                $mystring3 = ' class="bold" ';
                $count = substr_count($str, 'Bold;');

                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern = "/<span style=\"[^>]*font-family: Bold;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);

                    $pos = $matches[0][1] + 5;

                    $str = substr_replace($str, $mystring3, $pos, 0);

                    $off = $pos + 14;


                }

                $mystring4 = ' class="round" ';
                $count = substr_count($str, 'Rounded;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);

                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring4, $pos, 0);
                    $off = $pos + 17;
                }
                $str = str_replace('font-family: Regular;', '', $str);
                $str = str_replace('font-family: Bold;', '', $str);
                $str = str_replace('font-family: Rounded;', '', $str);
                $str = str_replace('sup>', 'tap>', $str);
                $studentAttempt->question = $str;
                //ans1
                $str = $qa->answer1;
                $regularExpression = "/class=\"[^<]*\"\s/i";
                $str = preg_replace($regularExpression, "", $str);
                $mystring2 = ' class="regular" ';
                $count = substr_count($str, 'Regular;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern = "/span style=\"[^>]*font-family: Regular;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring2, $pos, 0);
                    $off = $pos + 17;
                }
                $mystring3 = ' class="bold" ';
                $count = substr_count($str, 'Bold;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern
                        = "/<span style=\"[^>]*font-family: Bold;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring3, $pos, 0);
                    $off = $pos + 14;
                }
                $mystring4 = ' class="round" ';
                $count = substr_count($str, 'Rounded;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);

                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring4, $pos, 0);
                    $off = $pos + 17;
                }
                $str = str_replace('font-family: Regular;', '', $str);
                $str = str_replace('font-family: Bold;', '', $str);
                $str = str_replace('font-family: Rounded;', '', $str);
                $str = str_replace('sup>', 'tap>', $str);
                $studentAttempt->answer1 = $str;
                //ans2
                $str = $qa->answer2;
                $regularExpression = "/class=\"[^<]*\"\s/i";
                $str = preg_replace($regularExpression, "", $str);
                $mystring2 = ' class="regular" ';
                $count = substr_count($str, 'Regular;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern = "/span style=\"[^>]*font-family: Regular;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring2, $pos, 0);
                    $off = $pos + 17;
                }
                $mystring3 = ' class="bold" ';
                $count = substr_count($str, 'Bold;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern
                        = "/<span style=\"[^>]*font-family: Bold;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring3, $pos, 0);
                    $off = $pos + 14;
                }
                $mystring4 = ' class="round" ';
                $count = substr_count($str, 'Rounded;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);

                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring4, $pos, 0);
                    $off = $pos + 17;
                }
                $str = str_replace('font-family: Regular;', '', $str);
                $str = str_replace('font-family: Bold;', '', $str);
                $str = str_replace('font-family: Rounded;', '', $str);
                $str = str_replace('sup>', 'tap>', $str);
                $studentAttempt->answer2 = $str;
                //ans3
                $str = $qa->answer3;
                $regularExpression = "/class=\"[^<]*\"\s/i";
                $str = preg_replace($regularExpression, "", $str);
                $mystring2 = ' class="regular" ';
                $count = substr_count($str, 'Regular;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern = "/span style=\"[^>]*font-family: Regular;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring2, $pos, 0);
                    $off = $pos + 17;
                }
                $mystring3 = ' class="bold" ';
                $count = substr_count($str, 'Bold;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern
                        = "/<span style=\"[^>]*font-family: Bold;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring3, $pos, 0);
                    $off = $pos + 14;
                }
                $mystring4 = ' class="round" ';
                $count = substr_count($str, 'Rounded;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);

                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring4, $pos, 0);
                    $off = $pos + 17;
                }
                $str = str_replace('font-family: Regular;', '', $str);
                $str = str_replace('font-family: Bold;', '', $str);
                $str = str_replace('font-family: Rounded;', '', $str);
                $str = str_replace('sup>', 'tap>', $str);
                $studentAttempt->answer3 = $str;
                //ans4
                $str = $qa->answer4;
                $regularExpression = "/class=\"[^<]*\"\s/i";
                $str = preg_replace($regularExpression, "", $str);
                $mystring2 = ' class="regular" ';
                $count = substr_count($str, 'Regular;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern = "/span style=\"[^>]*font-family: Regular;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring2, $pos, 0);
                    $off = $pos + 17;
                }
                $mystring3 = ' class="bold" ';
                $count = substr_count($str, 'Bold;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern
                        = "/<span style=\"[^>]*font-family: Bold;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring3, $pos, 0);
                    $off = $pos + 14;
                }
                $mystring4 = ' class="round" ';
                $count = substr_count($str, 'Rounded;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);

                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring4, $pos, 0);
                    $off = $pos + 17;
                }
                $str = str_replace('font-family: Regular;', '', $str);
                $str = str_replace('font-family: Bold;', '', $str);
                $str = str_replace('font-family: Rounded;', '', $str);
                $str = str_replace('sup>', 'tap>', $str);
                $studentAttempt->answer4 = $str;
                $studentAttempt->correct = $qa->correct;
                //description
                $str = $qa->description;
                $regularExpression = "/class=\"[^<]*\"\s/i";
                $str = preg_replace($regularExpression, "", $str);
                $mystring2 = ' class="regular" ';
                $count = substr_count($str, 'Regular;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern = "/span style=\"[^>]*font-family: Regular;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring2, $pos, 0);
                    $off = $pos + 17;
                }
                $mystring3 = ' class="bold" ';
                $count = substr_count($str, 'Bold;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern
                        = "/<span style=\"[^>]*font-family: Bold;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring3, $pos, 0);
                    $off = $pos + 14;
                }
                $mystring4 = ' class="round" ';
                $count = substr_count($str, 'Rounded;');
                $off = 0;
                for ($i = 0; $i < $count; $i++) {
                    $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
                    preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);

                    $pos = $matches[0][1] + 5;
                    $str = substr_replace($str, $mystring4, $pos, 0);
                    $off = $pos + 17;
                }
                $str = str_replace('font-family: Regular;', '', $str);
                $str = str_replace('font-family: Bold;', '', $str);
                $str = str_replace('font-family: Rounded;', '', $str);
                $str = str_replace('sup>', 'tap>', $str);
                $studentAttempt->description = $str;
                $studentAttempt->save();
            }
        }

        $message = "Pregunta Respuesta actualizada correctamente";
        return redirect()->back()->with('message', $message);

    }

    public function delete($id)
    {
        $qa = \App\Questionanswer::find($id);
        $qa->delete();
        $message = "Pregunta Respuesta eliminada correctamente";
        return redirect()->back()->with('message', $message);
    }

    public function qas($id)
    {
        $exam = \App\Exam::find($id);
        $questions = \App\Questionanswer::where('examId', $id)->get();

        return view('questionanswers.index', compact('questions', 'exam'));
    }

    public function insertExamImages(Request $request)
    {

        //dd($ar);
        $examId = $request->get('examId');
        $questions = \App\Questionanswer::where('examId', $examId)->get();
        foreach ($questions as $key => $value) {
            $questionIdsArray[$key] = $value->id;
        }
        //dd($questionIdsArray);

        $materialFile = $request->file('images');

        if (!empty($materialFile)) {
            $newFilename = $materialFile->getClientOriginalName();
            $mimeType = $materialFile->getMimeType();
            if($mimeType!="application/zip"){
                return redirect()->back()->with('message2','archivo zip requerido');
            }
            $destinationPath = 'psycho';
            $materialFile->move($destinationPath, $newFilename);
            $filePath = 'psycho/' . $newFilename;
            $zip = Zip::open($filePath);
            $listFiles = $zip->listFiles();
            natsort($listFiles);
            $i = 0;
            foreach ($listFiles as $value) {

                if (!empty($questionIdsArray[$i])) {
                    //dd($questionIdsArray[$i]);
                    $quest = \App\Questionanswer::find($questionIdsArray[$i]);

                    if (!empty($quest)) {

                        $quest->image = 'psycho/' . $value;
                        $quest->save();
                    }
                }
                $i++;

            }
            //dd('ho');
            //Zipper::make($filePath)->extractTo('psycho');
        }
        $message = "Imágenes almacenadas con éxito";
        return redirect()->back()->with('message', $message);


    }

    public function manually($examId)
    {
        return view('questionanswers.manually', compact('examId'));
    }

    public function manuallyStore(Request $request)
    {
        $qa = new \App\Questionanswer;
        $qa->question = $request->get('question');
        $qa->answer1 = $request->get('answer1');
        $qa->answer2 = $request->get('answer2');
        $qa->answer3 = $request->get('answer3');
        $qa->answer4 = $request->get('answer4');
        $qa->correct = $request->get('correct');
        $qa->description = $request->get('description');
        $qa->examId = $request->get('examId');
        $materialFile = $request->file("image");

        if (!empty($materialFile)) {
            $newFilename = $materialFile->getClientOriginalName();
            $mimeType = $materialFile->getMimeType();
            $destinationPath = 'psycho';
            $materialFile->move($destinationPath, $newFilename);
            $filePath = 'psycho/' . $newFilename;
            $qa->image = $filePath;
        }

        $qa->save();
        return redirect('qas/' . $request->get('examId'));
    }
}
