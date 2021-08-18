<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/*use Illuminate\Support\Facades\Input;*/
use Illuminate\Support\Facades\Auth;
class ChatController extends Controller
{
    public function threads(){
        $threads=\App\Thread::all();
        return view('teachers.threads',compact('threads'));
    }
    public function threadStatusChange($id){
        $thread=\App\Thread::find($id);
        if($thread->status=="opened"){
            $thread->status="closed";
            $thread->save();
            $ce=\App\Chat::where('field1x',$thread->studentId)->exists();
            if($ce==true){
                $chat=\App\Chat::where('field1x',$thread->studentId)->orderBy('created_at','desc')->first();
                $chat->field2x="closed";
                $chat->save();
            }
            return redirect()->back()->with('message','Status changed successfully');     
        }
        if($thread->status=="closed"){
            $thread->status="opened";
            $thread->save();
            $ce=\App\Chat::where('field1x',$thread->studentId)->exists();
            if($ce==true){
                $chat=\App\Chat::where('field1x',$thread->studentId)->orderBy('created_at','desc')->first();
                $chat->field2x="opened";
                $chat->save();
            }
            return redirect()->back()->with('message','Status changed successfully');     
        }
        
    }
    public function chats($studentId){
    	$chats=\App\Chat::where('field1x',$studentId)->get();
        $userId=Auth::user()->id;
            $user=\App\User::find($userId);
            if(!empty($user)){
                $lastChat=\App\Chat::where('field1x',$studentId)->orderBy('created_at','desc')->first();
                if(!empty($lastChat)){
                    $user->chatRecord=$lastChat->id;
                    $user->save();
                }
            }
    	return view('teachers.chats',compact('chats','studentId'));
    }
     public function storeChatTeacher(Request $request){

    	if(!empty($request->get('message'))){
    		$chat=new \App\Chat;
    		$chat->message=$request->get('message');
    		$chat->type="message";
    		$chat->sender="teacher";
    		$chat->userId=$request->get('teacherId');
            $chat->field1x=$request->get('field1x');
            $chat->field2x=null;
    		$chat->save();
            $userId=Auth::user()->id;
            $user=\App\User::find($userId);
            if(!empty($user)){
                $lastChat=\App\Chat::where('field1x',$request->get('field1x'))->orderBy('created_at','desc')->first();
                if(!empty($lastChat)){
                    $user->chatRecord=$lastChat->id;
                    $user->save();
                }
            }
    		$chats=\App\Chat::where('field1x',$request->get('field1x'))->orderBy('created_at','asc')->get();
    		return view('teachers.chats',compact('chats'));
    	}
    	$file=$request->file('file');
    	
    		if(!empty($file)){
    			$mime=$file->getMimeType();
    			$arr = explode("/", $mime, 2);
				$first = $arr[0];
    			$chat=new \App\Chat;
	    		$newFilename=$file->getClientOriginalName();
	            $destinationPath='chatfiles';
	            $file->move($destinationPath,$newFilename);
	            $picPath='chatfiles/' . $newFilename;
	            $chat->file='http://neoestudio.net/'.$picPath;
	            if($first=="audio"){
	            	$chat->type="audio";	
	            }
	            if($first!="audio"){
	            	$chat->type="file";	
	            }
	            
	            //$chat->fileType=$file->getMimeType();
	            $chat->sender="teacher";
	            $chat->userId=$request->get('teacherId');
	            $chat->fileName=$newFilename;
                $chat->field1x=$request->get('field1x');
                $chat->field2x=null;
	            $chat->save();
	            $chats=\App\Chat::where('field1x',$request->get('field1x'))->orderBy('created_at','asc')->get();
                $userId=Auth::user()->id;
                $user=\App\User::find($userId);
                if(!empty($user)){
                    $lastChat=\App\Chat::where('field1x',$request->get('field1x'))->orderBy('created_at','desc')->first();
                    if(!empty($lastChat)){
                        $user->chatRecord=$lastChat->id;
                        $user->save();
                    }
                }
	            return view('teachers.chats',compact('chats'));
    		}
    	
    }
    public function downloadChat($id){
        $chat=\App\Chat::find($id);
        $mat=$chat->fileName;
        //$file= public_path(). "/chatfiles/$mat";
        $pp=public_path();

        $re=str_replace("/public","",$pp);
        //$file= "public_path()". "/$mat";
        $file= "$re". "/chatfiles/$mat";
        //$na=explode("/", $mat);
        $name=$mat;
        ob_end_clean();
        $headers = array('Content-Type' => \File::mimeType($file));
       return response()->download($file,$name,$headers);
    }
}
