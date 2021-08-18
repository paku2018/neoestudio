<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(){
        $courses=\App\Course::all();
        return view('courses.index',compact('courses'));
    }
    public function create(){
        return view('courses.create');

    }
    public function store(Request $request){

        $course=new \App\Course;
        $course->name=$request->get('name');
        $course->save();
        $message="Curso creado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function edit($id){
        $course=\App\Course::find($id);
        return view('courses.edit',compact('course'));
    }
    public function update(Request $request, $id){
        $course=\App\Course::find($id);
        $course->name=$request->get('name');
        $course->save();
        $message="Curso actualizado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function delete($id){
    	$course=\App\Course::find($id);
        $course->delete();
        $message="Curso eliminado con éxito";
        
        return redirect()->back()->with('message',$message);
    }
}
