<?php

namespace App\Http\Controllers;

use App\PackagePriceDescription;
use App\PackagePriceText;
use App\PackageText;
use App\PageContent;
use App\Product;
use App\Service;
use App\ServicePackage;
use App\PackagePrice;
use App\ServiceType;
use Illuminate\Http\Request;
use App\Page;
use App\PageVideo;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
/*use Illuminate\Support\Facades\Input;*/
use Intervention\Image\Facades\Image;
use DB;

class ServicesController extends Controller
{
    public function index()
    {
        $services_types = ServiceType::all();
        return view('services.type.index', compact('services_types'));
    }

    public function create()
    {
        return view('services.create');

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
                    $destinationPath = 'neostudio/services';
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $destinationPathPageThumb = 'neostudio/services/thumbs';
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

    public function create_type()
    {
        return view('services.type.create');

    }

    public function store_type(Request $request)
    {
        // validate the form data
        $messages = [
            'title.required' => "¡El título de la sección es obligatorio!"
        ];
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:150'
        ], $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {

            $order = $request->get('order');
            //if (empty($request->get('title')) === false || empty($str) === false || empty($image) === false || empty($videoPath) === false) {
            $service_type = new ServiceType();
            $service_type->title = $request->get('title');
            if (isset($order) && empty($order) === false) {
                $service_type->order = $order;
            }
            $service_type->save();
            //}
            $message = "¡El tipo de servicio se agregó correctamente!";
            return redirect()->back()->with('message', $message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $services = Service::where('id',$id)->get();
        return view('services.index', compact('services', 'id'));
    }

    public function packages(){
        $service_packages = ServicePackage::all();
        return view('services.package.index', compact('service_packages'));
    }

    public function create_package()
    {
        $package_prices  = array('annual', 'fractional', 'monthly');
        return view('services.package.create', compact('package_prices'));
    }

    public function store_package(Request $request)
    {
        // validate the form data
        $messages = [
            'title.required' => "¡Se requiere el título del paquete de servicio!",
            'annual_price_annual.required' => "¡Precio anual requerido para el tipo de precio anual!",
            'annual_price_fractional.required' => "Se requiere un precio de seis meses para el tipo de precio anual.",
            'annual_price_monthly.required' => "¡Precio mensual requerido para el tipo de precio anual!",
            'fractional_price_annual.required' => "¡Precio anual requerido para el tipo de precio fraccional!",
            'fractional_price_fractional.required' => "Se requiere un precio de seis meses para el tipo de precio fraccional.",
            'fractional_price_monthly.required' => "¡Precio mensual requerido para el tipo de precio fraccional!",
            'monthly_price_annual.required' => "¡Precio anual requerido para el tipo de precio mensual!",
            'monthly_price_fractional.required' => "Se requiere un precio de seis meses para el tipo de precio mensual.",
            'monthly_price_monthly.required' => "¡Precio mensual requerido para el tipo de precio mensual!"
        ];
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:150',
            'annual_price_annual' => 'required',
            'annual_price_fractional' => 'required',
            'annual_price_monthly' => 'required',
            'fractional_price_annual' => 'required',
            'fractional_price_fractional' => 'required',
            'fractional_price_monthly' => 'required',
            'monthly_price_annual' => 'required',
            'monthly_price_fractional' => 'required',
            'monthly_price_monthly' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $image = '';
            $page_image = $request->file("image");
            if (!empty($page_image)) {
                $messages = [
                    'image.mimes' => "La foto del paquete de servicio es obligatoria y solo permite extensiones .jpg, .jpeg y .png"
                ];
                $validator = Validator::make($request->all(), [
                    'image' => 'required|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
                ], $messages);
                if ($validator->fails()) {
                    return back()->withErrors($validator);
                } else {
                    $newFilename = $page_image->getClientOriginalName();
                    $destinationPath = 'neostudio/service_packages';
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $destinationPathPageThumb = 'neostudio/service_packages/thumbs';
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

            $image_active = '';
            $page_image_active = $request->file("image_active");
            if (!empty($page_image_active)) {
                $messages = [
                    'image_active.mimes' => "La foto del paquete de servicio es obligatoria y solo permite extensiones .jpg, .jpeg y .png"
                ];
                $validator = Validator::make($request->all(), [
                    'image_active' => 'required|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
                ], $messages);
                if ($validator->fails()) {
                    return back()->withErrors($validator);
                } else {
                    $newFilename = $page_image_active->getClientOriginalName();
                    $destinationPath = 'neostudio/service_packages';
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $destinationPathPageThumb = 'neostudio/service_packages/thumbs';
                    if (!is_dir($destinationPathPageThumb)) {
                        mkdir($destinationPathPageThumb, 0777, true);
                    }

                    //create large thumbnail
                    $smallThumbnailpath = $destinationPathPageThumb . '/' . $newFilename;
                    $this->createSliderImage($page_image_active, $smallThumbnailpath, 250, 200);

                    $page_image_active->move($destinationPath, $newFilename);
                    $image_active = $destinationPathPageThumb . '/' . $newFilename;
                }
            }
            $order = $request->get('order');
            $ServicePackage = new ServicePackage();
            $ServicePackage->title = $request->get('title');
            $ServicePackage->image = $image;
            $ServicePackage->image_active = $image_active;
            if (isset($order) && empty($order) === false) {
                $ServicePackage->order = $order;
            }
            $ServicePackage->price_text = $request->get('price_text');
            $ServicePackage->save();

            $price_types = array('annual', 'fractional', 'monthly');
            foreach ($price_types AS $price_type){
                PackagePrice::create(array('package_id' => $ServicePackage->id, 'price_type' => $price_type, 'price_annual' => $request->get($price_type.'_price_annual'), 'price_fractional' => $request->get($price_type.'_price_fractional'), 'price_monthly' => $request->get($price_type.'_price_monthly')));
                PackagePriceText::create(array('package_id' => $ServicePackage->id, 'price_type' => $price_type, 'text_annual' => $request->get($price_type.'_text_annual'), 'text_fractional' => $request->get($price_type.'_text_fractional'), 'text_monthly' => $request->get($price_type.'_text_monthly')));
            }

            $package_price_descriptions_annual = $request->get('annual');
            $package_price_descriptions_fractional = $request->get('fractional');
            $package_price_descriptions_monthly = $request->get('monthly');
            $annual = array($package_price_descriptions_annual[0], $package_price_descriptions_fractional[0], $package_price_descriptions_monthly[0]);
            if(isset($annual) && count($annual) > 0){
                $annualPrice = PackagePrice::where('package_id',$ServicePackage->id)->where('price_type','annual')->first();
                PackagePriceDescription::create(['package_price_id' => $annualPrice->id, 'annual' => $annual[0], 'fractional' => $annual[1], 'monthly' => $annual[2]]);
            }
            $fractional = array($package_price_descriptions_annual[1], $package_price_descriptions_fractional[1], $package_price_descriptions_monthly[1]);
            if(isset($fractional) && count($fractional) > 0){
                $fractionalPrice = PackagePrice::where('package_id',$ServicePackage->id)->where('price_type','fractional')->first();
                PackagePriceDescription::create(['package_price_id' => $fractionalPrice->id, 'annual' => $fractional[0], 'fractional' => $fractional[1], 'monthly' => $fractional[2]]);
            }
            $monthly = array($package_price_descriptions_annual[2], $package_price_descriptions_fractional[2], $package_price_descriptions_monthly[2]);
            if(isset($monthly) && count($monthly) > 0){
                $monthlyPrice = PackagePrice::where('package_id',$ServicePackage->id)->where('price_type','monthly')->first();
                PackagePriceDescription::create(['package_price_id' => $monthlyPrice->id, 'annual' => $monthly[0], 'fractional' => $monthly[1], 'monthly' => $monthly[2]]);

            }

            $message = "¡El paquete de servicios se agregó correctamente!";
            return redirect()->back()->with('message', $message);
        }
    }

    public function edit_package($id)
    {
        $service_package = ServicePackage::where('id',$id)->first();
        $package_prices = PackagePrice::where('package_id', $id)->get();
        $package_texts = PackagePriceText::where('package_id', $id)->get();
        $package_price_descriptions = PackagePriceDescription::getDescriptions();
        return view('services.package.edit', compact('service_package', 'package_prices', 'package_texts', 'package_price_descriptions'));

    }

    public function update_package(Request $request, $id)
    {
        // validate the form data
        $messages = [
            'title.required' => "¡Se requiere el título del paquete de servicio!",
            'annual_price_annual.required' => "¡Precio anual requerido para el tipo de precio anual!",
            'annual_price_fractional.required' => "Se requiere un precio de seis meses para el tipo de precio anual.",
            'annual_price_monthly.required' => "¡Precio mensual requerido para el tipo de precio anual!",
            'fractional_price_annual.required' => "¡Precio anual requerido para el tipo de precio fraccional!",
            'fractional_price_fractional.required' => "Se requiere un precio de seis meses para el tipo de precio fraccional.",
            'fractional_price_monthly.required' => "¡Precio mensual requerido para el tipo de precio fraccional!",
            'monthly_price_annual.required' => "¡Precio anual requerido para el tipo de precio mensual!",
            'monthly_price_fractional.required' => "Se requiere un precio de seis meses para el tipo de precio mensual.",
            'monthly_price_monthly.required' => "¡Precio mensual requerido para el tipo de precio mensual!"
        ];
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:150',
            'annual_price_annual' => 'required',
            'annual_price_fractional' => 'required',
            'annual_price_monthly' => 'required',
            'fractional_price_annual' => 'required',
            'fractional_price_fractional' => 'required',
            'fractional_price_monthly' => 'required',
            'monthly_price_annual' => 'required',
            'monthly_price_fractional' => 'required',
            'monthly_price_monthly' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $ServicePackage = ServicePackage::find($id);
            $image = $ServicePackage->image;
            $page_image = $request->file("image");
            if (!empty($page_image)) {
                $messages = [
                    'image.mimes' => "La foto del paquete de servicio es obligatoria y solo permite extensiones .jpg, .jpeg y .png"
                ];
                $validator = Validator::make($request->all(), [
                    'image' => 'required|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
                ], $messages);
                if ($validator->fails()) {
                    return back()->withErrors($validator);
                } else {
                    $newFilename = $page_image->getClientOriginalName();
                    $destinationPath = 'neostudio/service_packages';
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $destinationPathPageThumb = 'neostudio/service_packages/thumbs';
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

            $image_active = $ServicePackage->image_active;
            $page_image_active = $request->file("image_active");
            if (!empty($page_image_active)) {
                $messages = [
                    'image_active.mimes' => "La foto del paquete de servicio es obligatoria y solo permite extensiones .jpg, .jpeg y .png"
                ];
                $validator = Validator::make($request->all(), [
                    'image_active' => 'required|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
                ], $messages);
                if ($validator->fails()) {
                    return back()->withErrors($validator);
                } else {
                    $newFilename = $page_image_active->getClientOriginalName();
                    $destinationPath = 'neostudio/service_packages';
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $destinationPathPageThumb = 'neostudio/service_packages/thumbs';
                    if (!is_dir($destinationPathPageThumb)) {
                        mkdir($destinationPathPageThumb, 0777, true);
                    }

                    //create large thumbnail
                    $smallThumbnailpath = $destinationPathPageThumb . '/' . $newFilename;
                    $this->createSliderImage($page_image_active, $smallThumbnailpath, 250, 200);

                    $page_image_active->move($destinationPath, $newFilename);
                    $image_active = $destinationPathPageThumb . '/' . $newFilename;
                }
            }

            $order = $request->get('order');
            $ServicePackage->title = $request->get('title');
            $ServicePackage->image = $image;
            $ServicePackage->image_active = $image_active;
            $ServicePackage->price_text = $request->get('price_text');
            if (isset($order) && empty($order) === false) {
                $ServicePackage->order = $order;
            }
            $ServicePackage->save();

            $price_types = array('annual', 'fractional', 'monthly');
            foreach ($price_types AS $price_type){
                PackagePrice::where('package_id',$ServicePackage->id)->where('price_type',$price_type)->update(array('price_annual' => $request->get($price_type.'_price_annual'), 'price_fractional' => $request->get($price_type.'_price_fractional'), 'price_monthly' => $request->get($price_type.'_price_monthly')));
                PackagePriceText::where('package_id',$ServicePackage->id)->where('price_type',$price_type)->update(array('text_annual' => $request->get($price_type.'_text_annual'), 'text_fractional' => $request->get($price_type.'_text_fractional'), 'text_monthly' => $request->get($price_type.'_text_monthly')));
            }

            //Package Invoice Description - 210711
            $package_price_descriptions_annual = $request->get('annual');
            if(isset($package_price_descriptions_annual) && count($package_price_descriptions_annual) > 0){
                foreach ($package_price_descriptions_annual AS $price_id => $description){
                    if(isset($price_id) && empty($price_id) === false){
                        $check = PackagePriceDescription::where('package_price_id', $price_id)->count();
                        if($check > 0){
                            PackagePriceDescription::where('package_price_id', $price_id)->update(['annual' => $description]);
                        }
                        else{
                            PackagePriceDescription::create(['package_price_id' => $price_id, 'annual' => $description]);
                        }
                    }
                }
            }
            $package_price_descriptions_fractional = $request->get('fractional');
            if(isset($package_price_descriptions_fractional) && count($package_price_descriptions_fractional) > 0){
                foreach ($package_price_descriptions_fractional AS $price_id => $description){
                    if(isset($price_id) && empty($price_id) === false){
                        $check = PackagePriceDescription::where('package_price_id', $price_id)->count();
                        if($check > 0){
                            PackagePriceDescription::where('package_price_id', $price_id)->update(['fractional' => $description]);
                        }
                        else{
                            PackagePriceDescription::create(['package_price_id' => $price_id, 'fractional' => $description]);
                        }
                    }
                }
            }
            $package_price_descriptions_monthly = $request->get('monthly');
            if(isset($package_price_descriptions_monthly) && count($package_price_descriptions_monthly) > 0){
                foreach ($package_price_descriptions_monthly AS $price_id => $description){
                    if(isset($price_id) && empty($price_id) === false){
                        $check = PackagePriceDescription::where('package_price_id', $price_id)->count();
                        if($check > 0){
                            PackagePriceDescription::where('package_price_id', $price_id)->update(['monthly' => $description]);
                        }
                        else{
                            PackagePriceDescription::create(['package_price_id' => $price_id, 'monthly' => $description]);
                        }
                    }
                }
            }

            $message = "¡El paquete de servicios se ha actualizado correctamente!";
            return redirect()->back()->with('message', $message);
        }
    }

    public function packages_text(){
        $packages_texts = PackageText::all();
        return view('services.package.texts.create', compact('packages_texts'));
    }

    public function store_texts(Request $request){
        $titles = $request->get('titles');
        if(count($titles) > 0){
            foreach ($titles AS $key => $title){
                PackageText::where('type', $key)->update(array('title' => $title));
            }
        }
        $message = "¡Los textos de Pacakges se actualizaron con éxito!";
        return redirect()->back()->with('message', $message);
    }

    public function delete($id)
    {
        $alert = PageContent::find($id);
        $alert->delete();
        $message = "La sección de contenido se eliminó correctamente";
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

    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        return view('services.edit', compact('product'));
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
                    $destinationPath = 'neostudio/services';
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $destinationPathPageThumb = 'neostudio/services/thumbs';
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

    public function delete_package(Request $request, $id)
    {
        $package = ServicePackage::find($id);
        $pricesCount = PackagePrice::where('package_id',$package->id)->count();
        if($pricesCount > 0){
            $prices = PackagePrice::where('package_id',$package->id)->select(DB::raw('group_concat(id) AS id'))->get();
            $price_ids = explode(',',$prices[0]->id);
            $descriptionsCount = PackagePriceDescription::whereIn('package_price_id',$price_ids)->count();
            if($descriptionsCount > 0){
                DB::table('package_price_descriptions')->whereIn('id',$price_ids)->delete();
            }
            DB::table('package_prices')->where('package_id',$package->id)->delete();
        }

        $textsCount = PackagePriceText::where('package_id',$package->id)->count();
        if($textsCount > 0){
            DB::table('package_price_texts')->where('package_id',$package->id)->delete();
        }

        $package->delete();
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

    public function get_package_data(Request $request){
        $package_id = $request['id'];
        $price_type = $request['price_type'];
        $data = array();
        $count = PackagePrice::where('package_id',$package_id)->where('price_type', $price_type)->count();
        if($count > 0){
            $package = PackagePrice::where('package_id',$package_id)->where('price_type', $price_type)->first();
            $data[] = $package->price_monthly;
            $data[] = (float) str_replace('€','',$package->price_fractional);
            $data[] = (float) str_replace('€','',$package->price_annual);
        }
        return \GuzzleHttp\json_encode($data);
    }

    public function get_package_text(Request $request){
        $package_id = $request['id'];
        $price_type = $request['price_type'];
        $data = array();
        $count = PackagePriceText::where('package_id',$package_id)->where('price_type', $price_type)->count();
        if($count > 0){
            $package = PackagePriceText::where('package_id',$package_id)->where('price_type', $price_type)->first();
            $data[] = $package->text_monthly;
            $data[] = $package->text_annual;
            $data[] = $package->text_fractional;
        }
        return \GuzzleHttp\json_encode($data);
    }

    public function set_package_data(Request $request){
        $input = $request->all();
        $data = array('package_id' => $input['package_id'], 'number' => $input['number'], 'packageTenure' => $input['packageTenure'], 'userId' => $input['userId']);
        Session::put('product_payment',null);
        Session::put('package_payment',$data);
    }

    public function set_product_data(Request $request){
        $input = $request->all();
        $data = array('total_quantity' => $input['total_quantity'], 'total_price' => $input['total_price'], 'shipping' => $input['shipping'], 'shipping_id' => $input['shipping_id'], 'pids' => $input['pids'], 'userId' => $input['userId'], 'ships' => $input['ships']);
        Session::put('package_payment',null);
        Session::put('product_payment',$data);
    }
}
