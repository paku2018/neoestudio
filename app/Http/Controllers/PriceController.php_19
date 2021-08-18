<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PriceController extends Controller
{
     public function index($studentType){
     	
     	if($studentType=="Alumno"){
     		$prices=\App\Price::where('studentType','Alumno')->get();
     		return view('prices.index',compact('prices','studentType'));
     	}
     	if($studentType=="Alumno Convocado"){
     		$prices=\App\Price::where('studentType','Alumno Convocado')->get();
     		return view('prices.index',compact('prices','studentType'));
     	}        
    }
    public function create($studentType){

        return view('prices.create',compact('studentType'));

    }
    public function store(Request $request){

        $price=new \App\Price;
        $price->type=$request->get('type');
        $price->amount=$request->get('amount');
        $price->studentType=$request->get('studentType');
        $price->save();
        
        $message="Precio creado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function edit($id){
        $price=\App\Price::find($id);
        return view('prices.edit',compact('price'));
    }
    public function update(Request $request, $id){
        $price=\App\Price::find($id);
        
        $price->amount=$request->get('amount');
        $price->save();
        $message="Precio actualizado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function delete($id){
    	$price=\App\Price::find($id);
        $price->delete();
        $message="Precio eliminado con éxito";
        
        return redirect()->back()->with('message',$message);
    }
    public function courseindex(){
        $amounts=\App\Amount::where('amountType','books')->get();
        $amounts2=\App\Amount::where('amountType','strike')->get();
        return view('amounts.index',compact('amounts','amounts2'));
    }
    public function coursecreate($type){
        return view('amounts.create',compact('type'));

    }
    public function coursestore(Request $request){

        $amount=new \App\Amount;
        $amount->amount=$request->get('amount');
        $amount->amountType=$request->get('amountType');
        $amount->save();
        $message="Curso online precio con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function courseedit($id){
        $amount=\App\Amount::find($id);
        return view('amounts.edit',compact('amount'));
    }
    public function courseupdate(Request $request, $id){
        $amount=\App\Amount::find($id);
        $amount->amount=$request->get('amount');
        $amount->save();
        $message="Curso online precio actualizado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function coursedelete($id){
        $amount=\App\Amount::find($id);
        $amount->delete();
        $message="Curso online precio eliminado con éxito";
        
        return redirect()->back()->with('message',$message);
    }
}
