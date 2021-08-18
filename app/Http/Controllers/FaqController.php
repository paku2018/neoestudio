<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function indexFolder(){
        $folders=\App\Folder::where('type','faqs')->get();
        return view('faqs.folders.index',compact('folders'));
    }
    public function createFolder(){
        return view('faqs.folders.create');

    }
    public function storeFolder(Request $request){

        $folder=new \App\Folder;
        $folder->name=$request->get('name');
        $folder->type="faqs";
        $folder->save();
        $message="Carpeta creado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function editFolder($id){
        $folder=\App\Folder::find($id);
        return view('faqs.folders.edit',compact('folder'));
    }
    public function updateFolder(Request $request, $id){
        $folder=\App\Folder::find($id);
        $folder->name=$request->get('name');
        $folder->save();
        $message="Carpeta actualizado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function deleteFolder($id){
    	$folder=\App\Folder::find($id);
        $folder->delete();
        $message="Carpeta eliminado con éxito";
        
        return redirect()->back()->with('message',$message);
    }

    public function indexFaq($id){
    	$folder=\App\Folder::find($id);
        $faqs=\App\Faq::where('folderId',$id)->get();
        return view('faqs.index',compact('faqs','folder'));
    }
    public function createFaq($id){
    	$folder=\App\Folder::find($id);
        return view('faqs.create',compact('folder'));

    }
    public function storeFaq(Request $request){

        $faq=new \App\Faq;
        $faq->question=$request->get('question');
        $faq->answer=$request->get('answer');
        $faq->folderId=$request->get('folderId');
        $faq->save();
        $str=$faq->question;
        $mystring2=' class="regular" ';
            $count=substr_count($str, 'Regular;');
            $off=0;
            for($i=0;$i<$count;$i++){
                $pattern = "/span style=\"[^>]*font-family: Regular;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE,$off);  
                $pos=$matches[0][1]+5;
                $str=substr_replace($str, $mystring2,$pos,0);
                $off=$pos+17;
            }
            $mystring3=' class="bold" ';
            $count=substr_count($str, 'Bold;');
            $off=0;
            for($i=0;$i<$count;$i++){
                $pattern 
                = "/<span style=\"[^>]*font-family: Bold;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE,$off);
                $pos=$matches[0][1]+5;
                $str=substr_replace($str, $mystring3,$pos,0);
                $off=$pos+14;   
            }
            $mystring4=' class="round" ';
            $count=substr_count($str, 'Rounded;');
            $off=0;
            for($i=0;$i<$count;$i++){
                $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE,$off);
                
                $pos=$matches[0][1]+5;
                $str=substr_replace($str, $mystring4,$pos,0);
                $off=$pos+17;
            }
            $str=str_replace('font-family: Regular;','',$str);
            $str=str_replace('font-family: Bold;','',$str);
            $str=str_replace('font-family: Rounded;','',$str);
            $str=str_replace('sup>','tap>',$str);
            $faq->question1=$str;
            $faq->save();
            $str=$faq->answer;
            $mystring2=' class="regular" ';
            $count=substr_count($str, 'Regular;');
            $off=0;
            for($i=0;$i<$count;$i++){
                $pattern = "/span style=\"[^>]*font-family: Regular;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE,$off);  
                $pos=$matches[0][1]+5;
                $str=substr_replace($str, $mystring2,$pos,0);
                $off=$pos+17;
            }
            $mystring3=' class="bold" ';
            $count=substr_count($str, 'Bold;');
            $off=0;
            for($i=0;$i<$count;$i++){
                $pattern 
                = "/<span style=\"[^>]*font-family: Bold;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE,$off);
                $pos=$matches[0][1]+5;
                $str=substr_replace($str, $mystring3,$pos,0);
                $off=$pos+14;   
            }
            $mystring4=' class="round" ';
            $count=substr_count($str, 'Rounded;');
            $off=0;
            for($i=0;$i<$count;$i++){
                $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE,$off);
                
                $pos=$matches[0][1]+5;
                $str=substr_replace($str, $mystring4,$pos,0);
                $off=$pos+17;
            }
            $str=str_replace('font-family: Regular;','',$str);
            $str=str_replace('font-family: Bold;','',$str);
            $str=str_replace('font-family: Rounded;','',$str);
            $str=str_replace('sup>','tap>',$str);
            $faq->answer1=$str;
            $faq->save();
        $message="FAQ creado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function editFaq($id){
        $faq=\App\Faq::find($id);
        return view('faqs.edit',compact('faq'));
    }
    public function updateFaq(Request $request, $id){
        $faq=\App\Faq::find($id);
        $faq->question=$request->get('question');
        $faq->answer=$request->get('answer');
        $faq->save();
        $str=$faq->question;
        $mystring2=' class="regular" ';
            $count=substr_count($str, 'Regular;');
            $off=0;
            for($i=0;$i<$count;$i++){
                $pattern = "/span style=\"[^>]*font-family: Regular;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE,$off);  
                $pos=$matches[0][1]+5;
                $str=substr_replace($str, $mystring2,$pos,0);
                $off=$pos+17;
            }
            $mystring3=' class="bold" ';
            $count=substr_count($str, 'Bold;');
            $off=0;
            for($i=0;$i<$count;$i++){
                $pattern 
                = "/<span style=\"[^>]*font-family: Bold;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE,$off);
                $pos=$matches[0][1]+5;
                $str=substr_replace($str, $mystring3,$pos,0);
                $off=$pos+14;   
            }
            $mystring4=' class="round" ';
            $count=substr_count($str, 'Rounded;');
            $off=0;
            for($i=0;$i<$count;$i++){
                $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE,$off);
                
                $pos=$matches[0][1]+5;
                $str=substr_replace($str, $mystring4,$pos,0);
                $off=$pos+17;
            }
            $str=str_replace('font-family: Regular;','',$str);
            $str=str_replace('font-family: Bold;','',$str);
            $str=str_replace('font-family: Rounded;','',$str);
            $str=str_replace('sup>','tap>',$str);
            $faq->question1=$str;
            $faq->save();
            $str=$faq->answer;
            $mystring2=' class="regular" ';
            $count=substr_count($str, 'Regular;');
            $off=0;
            for($i=0;$i<$count;$i++){
                $pattern = "/span style=\"[^>]*font-family: Regular;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE,$off);  
                $pos=$matches[0][1]+5;
                $str=substr_replace($str, $mystring2,$pos,0);
                $off=$pos+17;
            }
            $mystring3=' class="bold" ';
            $count=substr_count($str, 'Bold;');
            $off=0;
            for($i=0;$i<$count;$i++){
                $pattern 
                = "/<span style=\"[^>]*font-family: Bold;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE,$off);
                $pos=$matches[0][1]+5;
                $str=substr_replace($str, $mystring3,$pos,0);
                $off=$pos+14;   
            }
            $mystring4=' class="round" ';
            $count=substr_count($str, 'Rounded;');
            $off=0;
            for($i=0;$i<$count;$i++){
                $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
                preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE,$off);
                
                $pos=$matches[0][1]+5;
                $str=substr_replace($str, $mystring4,$pos,0);
                $off=$pos+17;
            }
            $str=str_replace('font-family: Regular;','',$str);
            $str=str_replace('font-family: Bold;','',$str);
            $str=str_replace('font-family: Rounded;','',$str);
            $str=str_replace('sup>','tap>',$str);
            $faq->answer1=$str;
            $faq->save();
        $message="FAQ actualizado con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function deleteFaq($id){
    	$faq=\App\Faq::find($id);
        $faq->delete();
        $message="FAQ eliminado con éxito";
        
        return redirect()->back()->with('message',$message);
    }
}
