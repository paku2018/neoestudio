<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(){
        $news=\App\Alert::all();
        return view('news.index',compact('news'));
    }
    public function create(){
        return view('news.create');

    }
    public function store(Request $request){
        $str=$request->get('news');
        
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
        
        /*$mystring=$request->get('news');
        $count=substr_count($mystring, 'style="font-family: Regular;"');
        $mystring2='class="proxima" ';
        $off=0;
        for($i=0;$i<$count;$i++){
            $pos=strpos($mystring,'style="font-family: Regular;"',$off);
            $mystring=substr_replace($mystring, $mystring2,$pos,0);
            $off=$pos+17;
        }
        */
        $str=str_replace('font-family: Regular;','',$str);
        
        $str=str_replace('font-family: Bold;','',$str);

        $str=str_replace('font-family: Rounded;','',$str);
        $str=str_replace('sup>','tap>',$str);

        
        $alert=new \App\Alert;
        $alert->news=$str;
        $alert->news2=$request->get('news');
        $alert->studentType=$request->get('studentType');
        $alert->save();
        $users=\App\User::where('role','student')->where('type',$alert->studentType)->get();

        foreach ($users as $key => $value) {
            $ar=new \App\AlertRecord;

            $ar->studentId=$value->id;
            $ar->news=$alert->news;
            $ar->newsId=$alert->id;
            $ar->status="unseen";
            $ar->save();
        }
        $message="Novedades creadas con éxito";
        return redirect()->back()->with('message',$message);
    }
    public function edit($id){
        $news=\App\Alert::find($id);
        return view('news.edit',compact('news'));
    }
    public function update(Request $request, $id){
        $str=$request->get('news');
        
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
        
        /*$mystring=$request->get('news');
        $count=substr_count($mystring, 'style="font-family: Regular;"');
        $mystring2='class="proxima" ';
        $off=0;
        for($i=0;$i<$count;$i++){
            $pos=strpos($mystring,'style="font-family: Regular;"',$off);
            $mystring=substr_replace($mystring, $mystring2,$pos,0);
            $off=$pos+17;
        }
        */
        $str=str_replace('font-family: Regular;','',$str);
        
        $str=str_replace('font-family: Bold;','',$str);

        $str=str_replace('font-family: Rounded;','',$str);
        $str=str_replace('sup>','tap>',$str);
        $alert=\App\Alert::find($id);
        $alert->news=$str;
        $alert->news2=$request->get('news');
        $alert->studentType=$request->get('studentType');
        $alert->save();
        $message="Novedades actualizadas con éxito";
        $alertRecords=\App\AlertRecord::where('newsId',$id)->get();
        if(!empty($alertRecords)){
            foreach ($alertRecords as $key => $value) {
                $value->news=$alert->news;
                $value->save();
            }
        }
        return redirect()->back()->with('message',$message);
    }
    public function delete($id){
        $alert=\App\Alert::find($id);
        $alert->delete();
        $message="Novedades eliminadas con éxito";
        $alertRecords=\App\AlertRecord::where('newsId',$id)->get();
        if(!empty($alertRecords)){
            foreach ($alertRecords as $key => $value) {
                $value->delete();
            }
        }
        return redirect()->back()->with('message',$message);
    }
}
