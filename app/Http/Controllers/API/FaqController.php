<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
class FaqController extends Controller
{
    public function getFaqFolders(Request $request){

    	$queryString=$request->json('queryString');
        $tab=$request->json('tab');

    	if(!empty($queryString)){
            //accent work
            $queryString=str_replace("á","&aacute;",$queryString);
            $queryString=str_replace("ú","&uacute;",$queryString);
            $queryString=str_replace("ó","&oacute;",$queryString);
            $queryString=str_replace("é","&eacute;",$queryString);
            $queryString=str_replace("í","&iacute;",$queryString);

            //end accent work
    		//$onlyFolders=\App\Folder::where('type','faqs')->where('name','like','%' . $queryString . '%')->get();
    		$arrayF=array();
    		$folders=\App\Folder::where('type','faqs')->get();
    		
    		if(!empty($folders)){
    			foreach ($folders as $key => $value) {
    				if(!empty($value)){
    					$faqs=\App\Faq::where('folderId',$value->id)->where('question','like','%' . $queryString . '%')->get();
    					
    					if(!empty($faqs)){
    						foreach ($faqs as $key => $faq) {
    							array_push($arrayF,$faq->id);
    						}
    					}
    					$faqs2=\App\Faq::where('folderId',$value->id)->where('answer','like','%' . $queryString . '%')->get();
    					
    					if(!empty($faqs2)){
    						foreach ($faqs2 as $key => $faq) {
    							array_push($arrayF,$faq->id);
    						}
    					}
    				}

    			}
    		}
    		$fols = new Collection();
    		if(!empty($arrayF)){
	    		$uniqueIds=array_unique($arrayF);
	    		
	    		foreach ($uniqueIds as $key => $u) {
	    			$faq=\App\Faq::find($u);
	    			$fols->push($faq);
	    		}
    		}
    		/*if(!empty($onlyFolders)){
    			foreach ($onlyFolders as $key => $o) {
	    			
	    			$fols->push($o);
	    		}
    		}*/
    		if(empty($fols)){
    			$fols=array();
    		}
            if(!empty($tab)){
                    if(!empty($fols)){
                        foreach ($fols as $key => $value) {
                            $str=str_replace('font-size: 13pt','font-size: 30px',$value->question1);
                            $str=str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('question1',$str);

                            $str=str_replace('font-size: 13pt','font-size: 30px',$value->answer1);
                            $str=str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer1',$str);

                            
                        }
                    }
                }
    		return response()->json(['status'=>'Successfull','data'=>$fols,'queryString'=>'yes']);
    	}
    	if(empty($queryString)){
    		$folders=\App\Folder::where('type','faqs')->get();
    		return response()->json(['status'=>'Successfull','data'=>$folders,'queryString'=>'no']);
    	}

    	
    }
    public function getFolderFaqs(Request $request){
    	$folderId=$request->json('folderId');
        $tab=$request->json('tab');
    	$faqs=\App\Faq::where('folderId',$folderId)->get();
        if(!empty($tab)){
                    if(!empty($faqs)){
                        foreach ($faqs as $key => $value) {
                            $str=str_replace('font-size: 13pt','font-size: 30px',$value->question1);
                            $str=str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('question1',$str);

                            $str=str_replace('font-size: 13pt','font-size: 30px',$value->answer1);
                            $str=str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer1',$str);

                            
                        }
                    }
                }
    	return response()->json(['status'=>'Successfull','data'=>$faqs]);
    }

    public function faqSearch(Request $request){
        $query=$request->json('query');
        $tab=$request->json('tab');
        if(!empty($query)){
            $query=str_replace("á","&aacute;",$query);
            $query=str_replace("ú","&uacute;",$query);
            $query=str_replace("ó","&oacute;",$query);
            $query=str_replace("é","&eacute;",$query);
            $query=str_replace("í","&iacute;",$query);
            $idArray=array();
            $faqs1=\App\Faq::where('folderId',$request->json('folderId'))->where('question','like','%' .$query. '%')->get();
            if(!empty($faqs1)){
                foreach ($faqs1 as $key => $value) {
                    array_push($idArray,$value->id);
                }
            }
            $faqs2=\App\Faq::where('folderId',$request->json('folderId'))->where('answer','like','%' .$query. '%')->get();
            if(!empty($faqs2)){
                foreach ($faqs2 as $key => $value) {
                    array_push($idArray,$value->id);
                }
            }
            if(!empty($idArray)){
                $uniqueId=array_unique($idArray);
                $data=new Collection;
                foreach ($uniqueId as $keyu => $valueu) {
                    $faq=\App\Faq::find($valueu);
                    $data->push($faq);
                }
                return response()->json(['status'=>'Successfull','data'=>$data]);
            }
            $uniqueId=array();
            return response()->json(['status'=>'Successfull','data'=>$uniqueId]);
        }
        $faqs=\App\Faq::where('folderId',$request->json('folderId'))->get();
        if(!empty($tab)){
                    if(!empty($faqs)){
                        foreach ($faqs as $key => $value) {
                            $str=str_replace('font-size: 13pt','font-size: 30px',$value->question1);
                            $str=str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('question1',$str);

                            $str=str_replace('font-size: 13pt','font-size: 30px',$value->answer1);
                            $str=str_replace('font-size: 13px', 'font-size: 30px', $str);
                            $value->setAttribute('answer1',$str);

                            
                        }
                    }
                }
        return response()->json(['status'=>'Successfull','data'=>$faqs]);




    }
}
