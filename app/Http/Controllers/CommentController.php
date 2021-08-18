<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(){
        $comments=\App\Comment::all();
        return view('comments.index',compact('comments'));
    }
    public function create(){
        return view('comments.create');

    }
    public function store(Request $request){
        $exists=\App\Comment::where('userId',$request->get('userId'))->exists();
        if($exists==true){
            $comment=\App\Comment::where('userId',$request->get('userId'))->first();
            $comment->comment=$request->get('comment');
            $comment->save();
            $message="Observaciones creado con éxito";
            return redirect()->back()->with('message',$message);
        }
        $comment=new \App\Comment;
        $comment->comment=$request->get('comment');
        $comment->userId=$request->get('userId');
        $comment->save();
        $message="Observaciones creado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function edit($id){
        $comment=\App\Comment::find($id);
        return view('comments.edit',compact('comment'));
    }
    public function update(Request $request, $id){
        $comment=\App\Comment::find($id);
       $comment->comment=$request->get('comment');
        $comment->save();
        $message="Observaciones actualizado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function delete($id){
    	$comment=\App\Comment::find($id);
        $comment->delete();
        $message="Observaciones eliminado con éxito";
        
        return redirect()->back()->with('message',$message);
    }
}
