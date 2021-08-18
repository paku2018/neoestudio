<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\mughees2;
/*use Illuminate\Support\Facades\Input;*/

class QuestionController extends Controller
{
    public function index($surveyId){

        $survey=\App\Survey::find($surveyId);
        
        $questions=\App\Question::where('surveyId',$surveyId)->get();
        return view('questions.index',compact('questions','survey'));
    }
    public function create($surveyId){
        $survey=\App\Survey::find($surveyId);
        return view('questions.create',compact('survey'));

    }
    public function store(Request $request){
    	$id=$request->get('surveyId');
    	if(!empty('fileP')){
        	Excel::import( new mughees2($id),$request->file('fileP'));
        }
        $message="Preguntas guardadas con éxito";
        return redirect()->back()->with('message',$message);

    }
    public function edit($id){
        $question=\App\Question::find($id);
        
        return view('questions.edit',compact('question'));
    }
    public function update(Request $request, $id){
        $qa=\App\Question::find($id);
        

        $qa->question=$request->get('question');
        $qa->star=$request->get('star');
        $qa->description=$request->get('description');
        $qa->surveyId=$request->get('surveyId');        
        $qa->save();
       
        $message="Pregunta actualizada correctamente";
        return redirect()->back()->with('message',$message);
        
    }
    public function delete($id){
        $qa=\App\Question::find($id);
        $qa->delete();
        $message="Pregunta eliminada correctamente";
        return redirect()->back()->with('message',$message);
    }
    public function qas($id){
        $survey=\App\Survey::find($id);
        $questions=\App\Question::where('surveyId',$id)->get();

        return view('questions.index',compact('questions','survey'));
    }
}
