<?php

namespace App\Http\Controllers;
/*use Illuminate\Support\Facades\Input;*/
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(){
        $teachers=\App\User::where('role','teacher')->get();
        return view('teachers.index',compact('teachers'));
    }
    public function create(){
        return view('teachers.create');

    }
    public function store(Request $request){
        if(!empty($request->get('email'))){
            $exists=\App\User::where('email',$request->get('email'))->exists();
            if($exists==true){
                return redirect()->back()->with('message2','El Email ya existe');       
            }

        }
        if(!empty($request->get('telephone'))){
            $exists=\App\User::where('telephone',$request->get('telephone'))->exists();
            if($exists==true){
                return redirect()->back()->with('message2','El teléfono ya existe');        
            }

        }
        $teacher=new \App\User;
        $teacher->name=$request->get('name');
        $teacher->userName=$request->get('userName');
        $teacher->email=$request->get('email');
        $teacher->password=$request->get('password');
        $teacher->telephone=$request->get('telephone');
       
        $image=$request->file("image");
        
        
        if(!empty($image)){
            $newFilename=$image->getClientOriginalName();
            $mimeType=$image->getMimeType();
            $destinationPath='teacherImages';
            $image->move($destinationPath,$newFilename);
            $picPath='teacherImages/' . $newFilename;
            $imageUrl=$picPath;
            $teacher->photo=$imageUrl;

        }
        $teacher->role="teacher";
        $teacher->save();
        $message="Profesor creado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function edit($id){
        $teacher=\App\User::find($id);
        return view('teachers.edit',compact('teacher'));
    }
    public function update(Request $request, $id){
        $teacher=\App\User::find($id);
        $teacher->name=$request->get('name');
        $teacher->userName=$request->get('userName');
        $teacher->email=$request->get('email');
        $teacher->password=$request->get('password');
        $teacher->telephone=$request->get('telephone');
        
        $check=$request->get('check');
        $image=$request->file("image");

        if($check==null){

            if(!empty($image)){
                $newFilename=$image->getClientOriginalName();
                $mimeType=$image->getMimeType();
                $destinationPath='teacherImages';
                $image->move($destinationPath,$newFilename);
                $picPath='teacherImages/' . $newFilename;
                $imageUrl=$picPath;
                $teacher->photo=$imageUrl;

            }
        }
        $teacher->save();
        $message="Profesor actualizado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function delete($id){
        $teacher=\App\User::find($id);
        $teacher->delete();
        $message="Profesor eliminado exitosamente";
        return redirect()->back()->with('message',$message);
    }
}
