<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class topicController extends Controller
{
    public function index(){
        $topics=\App\Topic::all();
        return view('topics.index',compact('topics'));
    }
    public function create(){
        return view('topics.create');

    }
    public function store(Request $request){

        $topic=new \App\Topic;
        $topic->name=$request->get('name');
        $topic->courseId=$request->get('courseId');
        $topic->studentType=$request->get('studentType');
        $topic->status="Deshabilitado";
        $topic->save();
        $message="Tema creado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function edit($id){
        $topic=\App\Topic::find($id);
        return view('topics.edit',compact('topic'));
    }
    public function update(Request $request, $id){
        $topic=\App\Topic::find($id);
        $topic->name=$request->get('name');
        $topic->courseId=$request->get('courseId');
        $topic->studentType=$request->get('studentType');
        $topic->save();
        $message="Tema actualizado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function delete($id){
    	$topic=\App\Topic::find($id);
        $topic->delete();
        $message="Tema eliminado con éxito";
        
        return redirect()->back()->with('message',$message);
    }
    public function changeStatus($id){
        $topic=\App\Topic::find($id);
        if($topic->status=="Deshabilitado"){
            $topic->status="Habilitado";
            $topic->save();
            return redirect()->back()->with('message','Status changed successfully');       
        }
        if($topic->status=="Habilitado"){
            $topic->status="Deshabilitado";
            $topic->save();
            return redirect()->back()->with('message','Status changed successfully');       
        }
    }
}
