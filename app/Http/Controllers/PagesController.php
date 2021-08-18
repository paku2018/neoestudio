<?php

namespace App\Http\Controllers;

use App\PackagePrice;
use App\PackagePriceText;
use App\PackageText;
use App\PageContent;
use App\Product;
use App\ServicePackage;
use App\Shipping;
use Illuminate\Http\Request;
use App\Page;
use App\PageVideo;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
/*use Illuminate\Support\Facades\Input;*/
use Intervention\Image\Facades\Image;

class PagesController extends Controller
{
    public function index($pageType)
    {
        $pages = Page::with('page_video')->get();
        return view('pages.index', compact('pages', 'pageType'));
    }

    public function create($pageType)
    {
        return view('pages.create', compact('pageType'));

    }

    public function createContent($pageType, $id)
    {
        return view('pages.content.create', compact('pageType', 'id'));
    }

    public function store(Request $request)
    {
        // validate the form data
        /*$messages = [
            'title.required' => "¡El título de la sección es obligatorio!",
            'description.required' => "Se requiere una descripción de la sección.",
            'image.mimes' => "El icono de sección es obligatorio y solo permite extensiones .jpg, .jpeg y .png"
        ];
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:150',
            'description' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
        ], $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        else {

        }*/
        $str = $request->get('description');
        $mystring2 = ' class="regular" ';
        $count = substr_count($str, 'Regular;');;
        $off = 0;
        for ($i = 0; $i < $count; $i++) {
            $pattern = "/span style=\"[^>]*font-family: Regular;/i";
            preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);

            $pos = $matches[0][1] + 5;
            $str = substr_replace($str, $mystring2, $pos, 0);
            $off = $pos + 17;
        }

        $mystring3 = ' class="bold" ';
        $count = substr_count($str, 'Bold;');
        $off = 0;
        for ($i = 0; $i < $count; $i++) {
            $pattern
                = "/<span style=\"[^>]*font-family: Bold;/i";
            preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);
            $pos = $matches[0][1] + 5;
            $str = substr_replace($str, $mystring3, $pos, 0);
            $off = $pos + 14;

        }

        $mystring4 = ' class="round" ';
        $count = substr_count($str, 'Rounded;');

        $off = 0;
        for ($i = 0; $i < $count; $i++) {
            $pattern = "/span style=\"[^>]*font-family: Rounded;/i";
            preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE, $off);

            $pos = $matches[0][1] + 5;
            $str = substr_replace($str, $mystring4, $pos, 0);
            $off = $pos + 17;
        }
        //$str = $request->get('description');
        $str = str_replace('font-family: Regular;', '', $str);
        $str = str_replace('font-family: Bold;', '', $str);
        $str = str_replace('font-family: Rounded;', '', $str);
        $str = str_replace('sup>', 'tap>', $str);
        $image = '';
        $pid = base64_decode($request->get('pid'));
        $page = Page::where('id', $pid)->first();
        $page_image = $request->file('image');
        if (!empty($page_image)) {
            $messages = [
                'image.mimes' => "El icono de sección es obligatorio y solo permite extensiones .jpg, .jpeg y .png"
            ];
            $validator = Validator::make($request->all(), [
                'image' => 'required|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
            ], $messages);
            if ($validator->fails()) {
                return back()->withErrors($validator);
            } else {
                $newFilename = $page_image->getClientOriginalName();
                $destinationPath = 'neostudio/pages';
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $destinationPathPage = 'neostudio/pages/' . $page->slug;
                if (!is_dir($destinationPathPage)) {
                    mkdir($destinationPathPage, 0777, true);
                }
                $destinationPathPageThumb = 'neostudio/pages/' . $page->slug . '/thumbs';
                if (!is_dir($destinationPathPageThumb)) {
                    mkdir($destinationPathPageThumb, 0777, true);
                }

                //create large thumbnail
                $largethumbnailpath = $destinationPathPageThumb . '/' . $newFilename;
                $this->createSliderImage($page_image, $largethumbnailpath, 500, 500);

                $page_image->move($destinationPathPage, $newFilename);
                $image = $destinationPathPageThumb . '/' . $newFilename;
            }
        }

        $videoPath = '';
        $page_video = $request->file('page_video');
        if (!empty($page_video)) {
            $messages = [
                'page_video.required' => "Cargue un archivo de video y permita solo la extensión de archivo .mp4",
                'page_video.mimes' => "Permitir solo archivo de extensión .mp4"
            ];
            $validator = Validator::make($request->all(), ['page_video' => 'required|mimes:mp4'], $messages);
            if ($validator->fails()) {
                return back()->withErrors($validator);
            } else {
                $newFilename = $page_video->getClientOriginalName();
                $destinationPath = 'video';
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                /*$destinationPathPage = 'video/pages/' . $page->slug;
                if (!is_dir($destinationPathPage)) {
                    mkdir($destinationPathPage, 0777, true);
                }*/
                $page_video->move($destinationPath, $newFilename);
                $videoPath = $destinationPath . '/' . $newFilename;
            }
        }

        $order = $request->get('order');
        if (empty($request->get('title')) === false || empty($str) === false || empty($image) === false || empty($videoPath) === false) {
            $content = new PageContent();
            $content->page_id = $page->id;
            $content->title = $request->get('title');
            $content->description = $str;
            $content->description2 = $request->get('description');
            $content->image = $image;
            $content->video = $videoPath;
            if (isset($order) && empty($order) === false) {
                $content->order = $order;
            }
            $content->save();
        }
        $message = "¡La sección de contenido se agregó correctamente!";
        return redirect()->back()->with('message', $message);
    }

    public function createSliderImage($photo, $path, $width, $height)
    {
        $imageResize = Image::make($photo);
        $imageResize->orientate()
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        $imageResize->save($path, 60)->exif();
    }

    public function edit($pageType, $id)
    {
        if ($pageType == "video") {
            $contents = array();
            $view = 'pages.editVideo';
            $page = Page::where('id', $id)->with('page_video')->first();
        } else {
            $view = 'pages.content.index';
            $page = Page::where('id', $id)->first();
            $contents = PageContent::where('page_id', $id)->orderBy('order', 'asc')->get();
        }
        return view($view, compact('page', 'contents', 'pageType'));
    }

    public function editContentSection($pageType, $id)
    {
        $content = PageContent::where('id', $id)->first();
        $page = Page::where('id', $content->page_id)->first();
        return view('pages.content.edit', compact('page', 'content', 'pageType'));
    }

    public function updateVideo(Request $request, $id)
    {
        $page = Page::where('id', $id)->first();
        $videos = PageVideo::where('page_id', $id)->count();
        $page_video = $request->file('page_video');
        $video_order = $request->get('order');
        // validate the form data
        $messages = [
            'page_video.required' => "Cargue un archivo de video y permita solo la extensión de archivo .mp4",
            'page_video.mimes' => "Permitir solo archivo de extensión .mp4"
        ];
        $validator = Validator::make($request->all(), ['page_video' => 'required|mimes:mp4'], $messages);
        if ($validator->fails() && $videos <= 0) {
            return back()->withErrors($validator);
        } else {
            if (!empty($page_video)) {
                $messages = [
                    'page_video.required' => "Cargue un archivo de video y permita solo la extensión de archivo .mp4",
                    'page_video.mimes' => "Permitir solo archivo de extensión .mp4"
                ];
                $validator = Validator::make($request->all(), ['page_video' => 'required|mimes:mp4'], $messages);
                if ($validator->fails() && $videos <= 0) {
                    return back()->withErrors($validator);
                } else {
                    $newFilename = $page_video->getClientOriginalName();
                    $destinationPath = 'video/pages';
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $destinationPathPage = 'video/pages/' . $page->slug;
                    if (!is_dir($destinationPathPage)) {
                        mkdir($destinationPathPage, 0777, true);
                    }
                    $page_video->move($destinationPathPage, $newFilename);
                    $videoPath = $destinationPathPage . '/' . $newFilename;
                    $updateVideo = array('page_id' => $page->id, 'video' => $videoPath, 'order' => $video_order);
                    if ($videos > 0) {
                        //PageVideo::where('page_id', $id)->update(array('status' => 'Inactive'));
                        PageVideo::where('page_id', $page->id)->update($updateVideo);
                    } else {
                        PageVideo::create($updateVideo);
                    }
                }
            }
            if (empty($video_order) === false) {
                $updateVideo = array('order' => $video_order);
                PageVideo::where('page_id', $page->id)->update($updateVideo);
            }
            $message = "¡El video se actualizó correctamente!";
            return redirect()->back()->with('message', $message);
        }
    }

    public function update(Request $request, $id)
    {
        // validate the form data
        /*$messages = [
            'title.required' => "¡El título de la sección es obligatorio!",
            'description.required' => "Se requiere una descripción de la sección."
        ];
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:150',
            'description' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        else {

        }*/
        $str = $request->get('description');
        /*$mystring2=' class="regular" ';
        $count=substr_count($str, 'Regular;');
;
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

        $str = str_replace('font-family: Regular;', '', $str);
        $str = str_replace('font-family: Bold;', '', $str);
        $str = str_replace('font-family: Rounded;', '', $str);*/
        $str = str_replace('sup>', 'tap>', $str);

        $image = '';
        $pid = base64_decode($request->get('pid'));
        $page_content = PageContent::where('id', $id)->first();
        $page = Page::where('id', $page_content->page_id)->first();
        $page_image = $request->file('image');
        $image = $page_content->image;
        if (!empty($page_image)) {
            $messages = [
                'image.mimes' => "El icono de sección es obligatorio y solo permite extensiones .jpg, .jpeg y .png"
            ];
            $validator = Validator::make($request->all(), [
                'image' => 'required|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
            ], $messages);
            if ($validator->fails()) {
                return back()->withErrors($validator);
            } else {
                $newFilename = $page_image->getClientOriginalName();
                $destinationPath = 'neostudio/pages';
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $destinationPathPage = 'neostudio/pages/' . $page->slug;
                if (!is_dir($destinationPathPage)) {
                    mkdir($destinationPathPage, 0777, true);
                }
                $destinationPathPageThumb = 'neostudio/pages/' . $page->slug . '/thumbs';
                if (!is_dir($destinationPathPageThumb)) {
                    mkdir($destinationPathPageThumb, 0777, true);
                }

                //create large thumbnail
                $largethumbnailpath = $destinationPathPageThumb . '/' . $newFilename;
                $this->createSliderImage($page_image, $largethumbnailpath, 500, 500);

                $page_image->move($destinationPathPage, $newFilename);
                $image = $destinationPathPageThumb . '/' . $newFilename;
            }
        }

        $videoPath = $page_content->video;
        $page_video = $request->file('page_video');
        if (!empty($page_video)) {
            $messages = [
                'page_video.required' => "Cargue un archivo de video y permita solo la extensión de archivo .mp4",
                'page_video.mimes' => "Permitir solo archivo de extensión .mp4"
            ];
            $validator = Validator::make($request->all(), ['page_video' => 'required|mimes:mp4'], $messages);
            if ($validator->fails() && $videos <= 0) {
                return back()->withErrors($validator);
            } else {
                $newFilename = $page_video->getClientOriginalName();
                $destinationPath = 'video';
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                /*$destinationPathPage = 'video/pages/' . $page->slug;
                if (!is_dir($destinationPathPage)) {
                    mkdir($destinationPathPage, 0777, true);
                }*/
                $page_video->move($destinationPath, $newFilename);
                $videoPath = $destinationPath . '/' . $newFilename;
            }
        }
        $order = $request->get('order');
        $content = PageContent::find($id);
        $content->page_id = $page->id;
        $content->title = $request->get('title');
        $content->description = $str;
        $content->description2 = $request->get('description');
        if (isset($order) && empty($order) === false) {
            $content->order = $order;
        }
        $content->image = $image;
        $content->video = $videoPath;
        $content->save();
        $message = "¡La sección de contenido se ha actualizado correctamente!";
        return redirect()->back()->with('message', $message);
    }

    public function delete($id)
    {
        $alert = PageContent::find($id);
        $alert->delete();
        $message = "La sección de contenido se eliminó correctamente";
        return redirect()->back()->with('message', $message);
    }

    //Frontend Work
    public function page($slug = '')
    {
        $slug = request()->segment(1);
        if (empty($slug) === true) {
            $slug = 'inicio';
        }
        $view = '';
        if ($slug == "comienza-new") {
            $view = 'comienza-new';
            $slug = 'comienza';
        }
        $page = Page::where('slug', $slug)->with('page_video')->first();
        $contentCount = PageContent::where('page_id', $page->id)->count();
        $content_befores = array();
        $content_afters = array();
        $contents = array();
        if ($contentCount > 0) {
            $contents = PageContent::where('page_id', $page->id)->orderBy('order', 'asc')->get();
        }
        $top_video = PageVideo::where('page_id', $page->id)->first();
        $products = Product::all();
        $packages = ServicePackage::all();
        $payment_buttons = array('Mensual.png', 'Fraccionado-bw.png', 'Anual-bw.png');

        $user_data = array();
        $paid_package = array();
        $tenure = array();
        $hasPackage = 0;
        if (empty(Session::get('userData')) === false) {
            $user_data = Session::get('userData');
            $hasPackage = \App\Pay::where('userId', $user_data->id)->where('status','paid')->where('type','alumno')->count();
            if($hasPackage > 0){
                $tenure = ['annual' => 'Anual', 'fractional' => 'Fraccionado', 'monthly' => 'Mensual'];
                $pay = \App\Pay::where('userId', $user_data->id)->where('status','paid')->where('type','alumno')->orderBy('id','desc')->first();
                $paid_package_count = \App\PayPackage::where('pay_id', $pay->id)->count();
                if($paid_package_count > 0){
                    $paid_package = \App\PayPackage::where('pay_id', $pay->id)->with('package')->first();
                }
                else{
                    $hasPackage = 0;
                }
            }
        }

        $shipping = array();
        $shippings = array();
        $shippingCount = Shipping::where('status', 'Active')->count();
        if($shippingCount > 0){
            $shipping = Shipping::where('status', 'Active')->whereNotNull('image')->first();
            $shippings = Shipping::where('status', 'Active')->get();
        }

        $texts = PackageText::getTexts();
        $price_types = array('monthly', 'fractional', 'annual');
        $package_data = ServicePackage::where('default', 1)->first();
        $package_price = PackagePrice::where('package_id', $package_data->id)->where('price_type', 'monthly')->first();
        $pcakge_total_text = ['1 mes', '6 meses', '12 meses'];
        $package_price_text = PackagePriceText::where('package_id', $package_data->id)->where('price_type', 'monthly')->first();
        /*if(isset($page->page_video) && empty($page->page_video) === false){
            $video_order = $page->page_video->order;
            $content_befores = PageContent::where('page_id',$page->id)->orderBy('order','asc')->skip(0)->take($video_order)->get();
            $content_afters = PageContent::where('page_id',$page->id)->orderBy('order','asc')->skip($video_order)->take($contentCount - $video_order)->get();
        }*/
        $isMobile = $this->is_mobile();
        if (empty($view) === true) {
            $view = $page->view;
        }
        return view('neoestudio/' . $view, compact('page', 'package_data', 'slug', 'user_data', 'contents', 'content_befores', 'content_afters', 'isMobile', 'top_video', 'products', 'packages', 'payment_buttons', 'shippingCount', 'shipping', 'shippings', 'texts', 'package_price', 'price_types', 'pcakge_total_text', 'package_price_text', 'hasPackage', 'paid_package', 'tenure'));
    }

    public function is_mobile()
    {
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            $is_mobile = false;
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false
        ) {
            $is_mobile = true;
        } else {
            $is_mobile = false;
        }

        return $is_mobile;
    }

    public function createTopVideoContent($pageType, $id)
    {
        $content = PageContent::where('page_id', $id)->first();
        return view('pages.content.video', compact('content', 'pageType', 'id'));
    }

    public function updateTopVideo(Request $request, $id)
    {
        $page = Page::where('id', $id)->first();
        $top_video = $request->file('top_video');
        // validate the form data
        $messages = [
            'top_video.required' => "Cargue un archivo de video y permita solo la extensión de archivo .mp4",
            'top_video.mimes' => "Permitir solo archivo de extensión .mp4"
        ];
        $validator = Validator::make($request->all(), ['top_video' => 'required|mimes:mp4'], $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $newFilename = $top_video->getClientOriginalName();
            $destinationPath = 'neostudio/videos';
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $destinationPathPage = 'neostudio/videos/' . $page->slug;
            if (!is_dir($destinationPathPage)) {
                mkdir($destinationPathPage, 0777, true);
            }
            $top_video->move($destinationPathPage, $newFilename);
            $videoPath = $destinationPathPage . '/' . $newFilename;
            $videoData = array('page_id' => $page->id, 'video' => $videoPath);
            $checkVideo = PageVideo::where('page_id', $page->id)->count();
            if ($checkVideo > 0) {
                PageVideo::where('page_id', $page->id)->update($videoData);
            } else {
                PageVideo::create($videoData);
            }

            $message = "¡El video de la sección superior se agregó correctamente!";
            return redirect()->back()->with('message', $message);
        }
    }

    public function logout()
    {
        Session::put('userData', '');
        return redirect('comienza');
    }

}
