<?php

namespace App\Http\Controllers;

use App\PageContent;
use App\Product;
use App\Shipping;
use Illuminate\Http\Request;
use App\Page;
use App\PageVideo;
use Illuminate\Support\Facades\Validator;
/*use Illuminate\Support\Facades\Input;*/
use Intervention\Image\Facades\Image;

class ShippingController extends Controller
{
    public function index()
    {
        $shippings = Shipping::all();
        return view('shippings.index', compact('shippings'));
    }

    public function create()
    {
        return view('shippings.create');

    }

    public function store(Request $request)
    {
        // validate the form data
        $messages = [
            'title.required' => "¡Se requiere título de envío!",
            'price.required' => "¡Se requiere precio de envío!"
        ];
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:150',
            'price' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $image = '';
            $page_image = $request->file("image");
            if (!empty($page_image)) {
                $messages = [
                    'image.mimes' => "Se requiere foto de envío y solo permite extensiones .jpg, .jpeg y .png"
                ];
                $validator = Validator::make($request->all(), [
                    'image' => 'required|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
                ], $messages);
                if ($validator->fails()) {
                    return back()->withErrors($validator);
                } else {
                    $newFilename = $page_image->getClientOriginalName();
                    $destinationPath = 'neostudio/shippings';
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $destinationPathPageThumb = 'neostudio/shippings/thumbs';
                    if (!is_dir($destinationPathPageThumb)) {
                        mkdir($destinationPathPageThumb, 0777, true);
                    }

                    //create large thumbnail
                    $smallThumbnailpath = $destinationPathPageThumb . '/' . $newFilename;
                    $this->createSliderImage($page_image, $smallThumbnailpath, 200, 150);

                    $page_image->move($destinationPath, $newFilename);
                    $image = $destinationPathPageThumb . '/' . $newFilename;
                }
            }

            $shipping = new Shipping();
            $shipping->title = $request->get('title');
            $shipping->image = $image;
            $shipping->price = round($request->get('price'), 2);
            $shipping->save();
            $message = "¡El envío se agregó con éxito!";
            return redirect()->back()->with('message', $message);
        }
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

    public function edit($id)
    {
        $shipping = Shipping::where('id', $id)->first();
        return view('shippings.edit', compact('shipping'));
    }

    public function update(Request $request, $id)
    {
        // validate the form data
        $messages = [
            'title.required' => "¡Se requiere título de envío!",
            'price.required' => "¡Se requiere precio de envío!",
        ];
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:150',
            'price' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $shipping = Shipping::find($id);
            $image = $shipping->image;
            $page_image = $request->file("image");
            if (!empty($page_image)) {
                $messages = [
                    'image.mimes' => "Se requiere foto de envío y solo permite extensiones .jpg, .jpeg y .png"
                ];
                $validator = Validator::make($request->all(), [
                    'image' => 'required|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
                ], $messages);
                if ($validator->fails()) {
                    return back()->withErrors($validator);
                } else {
                    $newFilename = $page_image->getClientOriginalName();
                    $destinationPath = 'neostudio/shippings';
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $destinationPathPageThumb = 'neostudio/shippings/thumbs';
                    if (!is_dir($destinationPathPageThumb)) {
                        mkdir($destinationPathPageThumb, 0777, true);
                    }

                    //create large thumbnail
                    $smallThumbnailpath = $destinationPathPageThumb . '/' . $newFilename;
                    $this->createSliderImage($page_image, $smallThumbnailpath, 200, 150);

                    $page_image->move($destinationPath, $newFilename);
                    $image = $destinationPathPageThumb . '/' . $newFilename;
                }
            }
            $shipping->title = $request->get('title');
            $shipping->image = $image;
            $shipping->price = round($request->get('price'), 2);
            $shipping->save();
            $message = "¡El envío se ha actualizado correctamente!";
            return redirect()->back()->with('message', $message);
        }
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
        $page = Page::where('slug', $slug)->with('page_video')->first();
        $contentCount = PageContent::where('page_id', $page->id)->count();
        $content_befores = array();
        $content_afters = array();
        $contents = array();
        if ($contentCount > 0) {
            $contents = PageContent::where('page_id', $page->id)->orderBy('order', 'asc')->get();
        }
        /*if(isset($page->page_video) && empty($page->page_video) === false){
            $video_order = $page->page_video->order;
            $content_befores = PageContent::where('page_id',$page->id)->orderBy('order','asc')->skip(0)->take($video_order)->get();
            $content_afters = PageContent::where('page_id',$page->id)->orderBy('order','asc')->skip($video_order)->take($contentCount - $video_order)->get();
        }*/
        $isMobile = $this->is_mobile();
        return view('neoestudio/' . $page->view, compact('page', 'slug', 'contents', 'content_befores', 'content_afters', 'isMobile'));
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
}
