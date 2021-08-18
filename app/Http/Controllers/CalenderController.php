<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalenderController extends Controller
{
    public function index($studentType){
        $calenders=\App\Calender::where('field1x',$studentType)->get();
        return view('calenders.index',compact('calenders','studentType'));
    }
    public function create($studentType){
        return view('calenders.create',compact('studentType'));

    }
    public function store(Request $request){

        $calender=new \App\Calender;
        $calender->date=$request->get('date');
        $calender->description=$request->get('description');
        $calender->field1x=$request->get('studentType');
        $calender->color=$request->get('color');
        
        $calender->save();
        if(!empty($calender->color)){
            if($calender->color=="#3f5d68"){
                $calender->bgColor="#c1e6ff";
                $calender->save();
            }
            if($calender->color=="#b61a1b"){
                $calender->bgColor="#ffbfc5";
                $calender->save();
            }
        }
        $message="Fecha creado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function edit($id){
        $calender=\App\Calender::find($id);
        return view('calenders.edit',compact('calender'));
    }
    public function update(Request $request, $id){
        $calender=\App\Calender::find($id);
        $calender->date=$request->get('date');
        $calender->description=$request->get('description');
        
        $calender->color=$request->get('color');
        
        $calender->save();
        if(!empty($calender->color)){
            if($calender->color=="#3f5d68"){
                $calender->bgColor="#c1e6ff";
                $calender->save();
            }
            if($calender->color=="#b61a1b"){
                $calender->bgColor="#ffbfc5";
                $calender->save();
            }
        }
        $message="Fetcha actualizado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function delete($id){
    	$calender=\App\Calender::find($id);
        $calender->delete();
        $message="Fetcha eliminado con éxito";
        
        return redirect()->back()->with('message',$message);
    }
}
