<?php

namespace App\Http\Controllers;

use App\PageContent;
use App\Product;
use Illuminate\Http\Request;
use App\Page;
use App\PageVideo;
use Illuminate\Support\Facades\Validator;
/*use Illuminate\Support\Facades\Input;*/
use Intervention\Image\Facades\Image;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');

    }

    public function store(Request $request)
    {
        // validate the form data
        $messages = [
            'name.required' => "¡El título de la sección es obligatorio!",
            'price.required' => "¡Se requiere el precio del producto!",
            'image.mimes' => "El icono de sección es obligatorio y solo permite extensiones .jpg, .jpeg y .png"
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:150',
            'price' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
        ], $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
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
            $page_image = $request->file("image");
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
                    $destinationPath = 'neostudio/products';
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $destinationPathPageThumb = 'neostudio/products/thumbs';
                    if (!is_dir($destinationPathPageThumb)) {
                        mkdir($destinationPathPageThumb, 0777, true);
                    }

                    //create large thumbnail
                    $smallThumbnailpath = $destinationPathPageThumb . '/' . $newFilename;
                    $this->createSliderImage($page_image, $smallThumbnailpath, 250, 200);

                    $page_image->move($destinationPath, $newFilename);
                    $image = $destinationPathPageThumb . '/' . $newFilename;
                }
            }

            $order = $request->get('order');
            //if (empty($request->get('title')) === false || empty($str) === false || empty($image) === false || empty($videoPath) === false) {
            $product = new Product();
            $product->name = $request->get('name');
            $product->description = $str;
            $product->description2 = $request->get('description');
            $product->photo = $image;
            $product->price = round($request->get('price'), 2);
            if (isset($order) && empty($order) === false) {
                $product->order = $order;
            }
            $product->save();
            //}
            $message = "¡El producto se agregó correctamente!";
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
        $product = Product::where('id', $id)->first();
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // validate the form data
        $messages = [
            'name.required' => "¡El título de la sección es obligatorio!",
            'price.required' => "¡Se requiere el precio del producto!"
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:150',
            'price' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $product = Product::find($id);
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
            $image = $product->photo;
            $page_image = $request->file("image");
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
                    $destinationPath = 'neostudio/products';
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $destinationPathPageThumb = 'neostudio/products/thumbs';
                    if (!is_dir($destinationPathPageThumb)) {
                        mkdir($destinationPathPageThumb, 0777, true);
                    }

                    //create large thumbnail
                    $smallThumbnailpath = $destinationPathPageThumb . '/' . $newFilename;
                    $this->createSliderImage($page_image, $smallThumbnailpath, 250, 200);

                    $page_image->move($destinationPath, $newFilename);
                    $image = $destinationPathPageThumb . '/' . $newFilename;
                }
            }

            $order = $request->get('order');
            //if (empty($request->get('title')) === false || empty($str) === false || empty($image) === false || empty($videoPath) === false) {

            $product->name = $request->get('name');
            $product->description = $str;
            $product->description2 = $request->get('description');
            $product->photo = $image;
            $product->price = round($request->get('price'), 2);
            if (isset($order) && empty($order) === false) {
                $product->order = $order;
            }
            $product->save();
            $message = "¡El producto se actualizó correctamente!";
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::where('id', $id)->delete();

        return redirect()->back()->with('message', '¡El producto se eliminó correctamente!');
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
