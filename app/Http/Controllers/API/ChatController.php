<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
class ChatController extends Controller
{
    public function storeChatStudent(Request $request){
        $studentId=$request->get('studentId');
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
    	if(!empty($request->get('message'))){
            $threadE=\App\Thread::where('studentId',$request->get('studentId'))->exists();
            if($threadE==false){
                $thread=new \App\Thread;
                $thread->studentId=$request->get('studentId');
                $thread->status="opened";
                $thread->save();
                $chat=new \App\Chat;
                $chat->message=$request->get('message');
                $chat->type="message";
                $chat->sender="student";
                $chat->userId=$request->get('studentId');
                $chat->field1x=$request->get('studentId');
                $chat->field2x="opened";
                $chat->save();
                $chats=\App\Chat::orderBy('created_at','asc')->get();
                $studentId=$request->get('studentId');
                $user=\App\User::find($studentId);
                if(!empty($user)){
                    $lastChat=\App\Chat::orderBy('created_at','desc')->first();
                    if(!empty($lastChat)){
                        $user->chatRecord=$lastChat->id;
                        $user->save();
                    }
                }
                $chats=\App\Chat::where('field1x',$request->get('studentId'))->orderBy('created_at','asc')->get();
                return response()->json(['status'=>'Successfull','chats'=>$chats,'user'=>$user]);
            }
            if($threadE==true){
                

                $thread=\App\Thread::where('studentId',$request->get('studentId'))->first();
                $thread->status="opened";
                $thread->save();
                $chatS=\App\Chat::where('field1x',$thread->studentId)->orderBy('created_at','desc')->first();
                $chat=new \App\Chat;
                $chat->message=$request->get('message');
                $chat->type="message";
                $chat->sender="student";
                $chat->userId=$request->get('studentId');
                $chat->field1x=$request->get('studentId');
                if($chatS->field2x=="closed"){
                    $chat->field2x="opened";
                }
                if($chatS->field2x=="opened"){
                    $chat->field2x=null;
                }
                
                $chat->save();
                $chats=\App\Chat::orderBy('created_at','asc')->get();
                $studentId=$request->get('studentId');
                $user=\App\User::find($studentId);
                if(!empty($user)){
                    $lastChat=\App\Chat::orderBy('created_at','desc')->first();
                    if(!empty($lastChat)){
                        $user->chatRecord=$lastChat->id;
                        $user->save();
                    }
                }
                $chats=\App\Chat::where('field1x',$request->get('studentId'))->orderBy('created_at','asc')->get();
                return response()->json(['status'=>'Successfull','chats'=>$chats,'user'=>$user]);
            }
    		
    	}
    	$file=Input::file('file');
    		
    		if(!empty($file)){
                $threadE=\App\Thread::where('studentId',$request->get('studentId'))->exists();
                if($threadE==false){
                    $thread=new \App\Thread;
                    $thread->studentId=$request->json('studentId');
                    $thread->status="opened";
                    $thread->save();
                    $chat=new \App\Chat;
                    $newFilename=$file->getClientOriginalName();
                    $destinationPath='chatfiles';
                    $file->move($destinationPath,$newFilename);
                    $picPath='chatfiles/' . $newFilename;
                    $chat->file='https://neoestudio.net/'.$picPath;
                    if(!empty($request->get('type'))){
                        $chat->type=$request->get('type');
                    }
                    if(empty($request->get('type'))){
                    //$chat->fileType=$request->get('type');
                       $chat->type="file";
                    }
                    $chat->sender="student";
                    $chat->userId=$request->get('studentId');
                    $chat->fileName=$newFilename;
                    $chat->field1x=$request->get('studentId');
                    $chat->field2x="opened";
                    $chat->save();
                    
                    $studentId=$request->get('studentId');
                        $user=\App\User::find($studentId);
                        if(!empty($user)){
                            $lastChat=\App\Chat::orderBy('created_at','desc')->first();
                            if(!empty($lastChat)){
                                $user->chatRecord=$lastChat->id;
                                $user->save();
                            }
                        }
                        $chats=\App\Chat::where('field1x',$request->get('studentId'))->orderBy('created_at','asc')->get();
                    return response()->json(['status'=>'Successfull','chats'=>$chats,'user'=>$user]);
                }
                if($threadE==true){
                    
                    $thread=\App\Thread::where('studentId',$request->get('studentId'))->first();
                    $thread->status="opened";
                    $thread->save();
                    $chatS=\App\Chat::where('field1x',$thread->studentId)->orderBy('created_at','desc')->first();
                    $chat=new \App\Chat;
                    $newFilename=$file->getClientOriginalName();
                    $destinationPath='chatfiles';
                    $file->move($destinationPath,$newFilename);
                    $picPath='chatfiles/' . $newFilename;
                    $chat->file='https://neoestudio.net/'.$picPath;
                    if(!empty($request->get('type'))){
                        $chat->type=$request->get('type');
                    }
                    if(empty($request->get('type'))){
                    //$chat->fileType=$request->get('type');
                       $chat->type="file";
                    }
                    $chat->sender="student";
                    $chat->userId=$request->get('studentId');
                    $chat->fileName=$newFilename;
                    $chat->field1x=$request->get('studentId');
                    if($chatS->field2x=="closed"){
                    $chat->field2x="opened";
                    }
                    if($chatS->field2x=="opened"){
                        $chat->field2x=null;
                    }
                    $chat->save();
                    
                    $studentId=$request->get('studentId');
                        $user=\App\User::find($studentId);
                        if(!empty($user)){
                            $lastChat=\App\Chat::orderBy('created_at','desc')->first();
                            if(!empty($lastChat)){
                                $user->chatRecord=$lastChat->id;
                                $user->save();
                            }
                        }
                        $chats=\App\Chat::where('field1x',$request->get('studentId'))->orderBy('created_at','asc')->get();
                    return response()->json(['status'=>'Successfull','chats'=>$chats,'user'=>$user]);
                }

    			
    		}
    	
    }
    
    public function getChat(Request $request){
        $studentId=$request->json('studentId');
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $studentId=$request->json('studentId');
        $threadE=\App\Thread::where('studentId',$studentId)->exists();
        if($threadE==false){
            $threadStatus="empty";
        }
        if($threadE==true){
            $thread=\App\Thread::where('studentId',$studentId)->first();
            $threadStatus=$thread->status;
        }
        $user=\App\User::find($studentId);
        if(!empty($user)){
            $lastChat=\App\Chat::where('field1x',$studentId)->orderBy('created_at','desc')->first();
            if(!empty($lastChat)){
                $user->chatRecord=$lastChat->id;
                $user->save();
            }
        }
        $ios=\App\Chat::where('field1x',$studentId)->orderBy('created_at','asc')->get();
        foreach ($ios as $key => $value) {
            if($value->type=="audio"||$value->type=="file"){
                $p='http://neoestudio.net/chatfiles/'.$value->fileName;
                $value->setAttribute('file',$p);
            }
        }
        $chats=\App\Chat::where('field1x',$studentId)->orderBy('created_at','asc')->get();
        $exists=\App\Chat::where('sender','teacher')->where('field1x',$studentId)->exists();
        if($exists==true){
            $teacherChat=\App\Chat::where('sender','teacher')->where('field1x',$studentId)->orderBy('created_at','desc')->first();
            $teacher=\App\User::find($teacherChat->userId);
            if(!empty($teacher)){
                $photo='https://neoestudio.net/'.$teacher->photo;
            
                $teacher->setAttribute('profilePicture',$photo);
            }
            //$teacher->photo='http://95.179.208.227/acadmy/public/'.$teacher->photo;
            //$teacher->save();
            return response()->json(['status'=>'Successfull','chats'=>$chats,'ios'=>$ios,'teacher'=>$teacher,'user'=>$user,'threadStatus'=>$threadStatus]);
        }
        if($exists==false){
         return response()->json(['status'=>'Successfull','chats'=>$chats,'ios'=>$ios,'teacher'=>null,'user'=>$user,'threadStatus'=>$threadStatus]);   
        }
	    
    }
    public function chatCount(Request $request){
        $studentId=$request->json('studentId');
        $ue=\App\User::where('id',$studentId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $u=\App\User::find($studentId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found']);
        }
        $userId=$request->json('studentId');
        $user=\App\User::find($userId);
        if(!empty($user)){
            if(empty($user->chatRecord)){
                $user->chatRecord=-1;
                $user->save();
            }
            $exists=\App\Chat::where('id','>',$user->chatRecord)->where('sender','teacher')->where('field1x',$studentId)->exists();
            if($exists==true){
                $count=\App\Chat::where('id','>',$user->chatRecord)->where('sender','teacher')->where('field1x',$studentId)->count();
                return response()->json(['status'=>'Successfull','count'=>$count]);
            }
            if($exists==false){
              
                return response()->json(['status'=>'Successfull','count'=>0]);
            }
        }
    }
}
