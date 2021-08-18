<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/*use Illuminate\Support\Facades\Input;*/

class DownloadUploadController extends Controller
{
    public function indexFolder($option, $studentType)
    {
        $folders = \App\Folder::where('type', $option)->where('studentType', $studentType)->get();
        return view('downloadsUploads.folders.index', compact('folders', 'option', 'studentType'));
    }

    public function createFolder($option, $studentType)
    {
        return view('downloadsUploads.folders.create', compact('option', 'studentType'));

    }

    public function storeFolder(Request $request)
    {
        $folder = new \App\Folder;
        $folder->name = $request->get('name');
        $folder->type = $request->get('option');
        $folder->studentType = $request->get('studentType');
        $folder->status = "Deshabilitado";
        $folder->save();
        $message = "Carpeta creado con éxito";
        return redirect()->back()->with('message', $message);
    }

    public function editFolder($id)
    {
        $folder = \App\Folder::find($id);
        return view('downloadsUploads.folders.edit', compact('folder'));
    }

    public function updateFolder(Request $request, $id)
    {
        $folder = \App\Folder::find($id);
        $folder->name = $request->get('name');
        $folder->save();
        $message = "Carpeta actualizado con éxito";
        return redirect()->back()->with('message', $message);
    }

    public function deleteFolder($id)
    {
        $folder = \App\Folder::find($id);
        $folder->delete();
        $message = "Carpeta eliminado con éxito";

        return redirect()->back()->with('message', $message);
    }

    public function downloadsUploadsFolderStatusChange($id)
    {
        $folder = \App\Folder::find($id);

        if ($folder->status == "Deshabilitado") {
            $folder->status = "Habilitado";
            $folder->save();
            if ($folder->type == "Subidas") {
                $exists = \App\User::where('type', $folder->studentType)->where('role', 'student')->exists();
                if ($exists == true) {
                    $users = \App\User::where('type', $folder->studentType)->where('role', 'student')->get();
                    foreach ($users as $user) {
                        $notiExists = \App\Notification::where('studentId', $user->id)->where('type', 'Subidas')->where('typeId2', $folder->id)->exists();
                        if ($notiExists == true) {
                            $noti = \App\Notification::where('studentId', $user->id)->where('type', $folder->type)->where('typeId2', $folder->id)->first();
                            $noti->status = "pending";
                            $noti->save();
                        }
                        if ($notiExists == false) {
                            $noti = new \App\Notification;
                            $noti->studentId = $user->id;
                            $noti->type = $folder->type;
                            $noti->status = "pending";
                            $noti->typeId2 = $folder->id;
                            $noti->save();
                        }

                    }
                }
            }
            if ($folder->type == "DescargasPdf") {
                $exists = \App\User::where('type', $folder->studentType)->where('role', 'student')->exists();
                if ($exists == true) {
                    $users = \App\User::where('type', $folder->studentType)->where('role', 'student')->get();
                    foreach ($users as $user) {
                        $notiExists = \App\Notification::where('studentId', $user->id)->where('type', 'DescargasPdf')->where('typeId2', $folder->id)->exists();
                        if ($notiExists == true) {
                            $noti = \App\Notification::where('studentId', $user->id)->where('type', $folder->type)->where('typeId2', $folder->id)->first();
                            $noti->status = "pending";
                            $noti->save();
                        }
                        if ($notiExists == false) {
                            $noti = new \App\Notification;
                            $noti->studentId = $user->id;
                            $noti->type = $folder->type;
                            $noti->status = "pending";
                            $noti->typeId2 = $folder->id;
                            $noti->save();
                        }

                    }
                }
            }
            return redirect()->back()->with('message', 'Status changed successfully');
        }
        if ($folder->status == "Habilitado") {
            $folder->status = "Deshabilitado";
            $folder->save();
            return redirect()->back()->with('message', 'Status changed successfully');
        }
    }

    public function downloadsUploadsOnlyFiles($option, $studentType)
    {
        return view('downloadsUploads.create', compact('option', 'studentType'));
    }

    public function index($option, $folderId, $studentType)
    {
        $folder = \App\Folder::find($folderId);
        $downloadsUploads = \App\DownloadUpload::where('folderId', $folderId)->where('option', $option)
            ->where('studentType', $studentType)->get();
        return view('downloadsUploads.index', compact('downloadsUploads', 'folder', 'option', 'studentType'));
    }

    public function create($option, $folderId, $studentType)
    {
        $folder = \App\Folder::find($folderId);
        return view('downloadsUploads.create', compact('folder', 'option', 'studentType'));

    }

    public function store(Request $request)
    {
        $option = $request->get('option');
        $downloadUpload = new \App\DownloadUpload;
        $downloadUpload->folderId = $request->get('folderId');
        $downloadUpload->option = $request->get('option');
        $downloadUpload->courseId = $request->get('courseId');
        $downloadUpload->studentType = $request->get('studentType');
        $downloadUpload->title = $request->get('title');
        $downloadUpload->status = "Deshabilitado";

        $materialFile = $request->file('materialFile');
        if (!empty($materialFile)) {
            $checkOption = str_replace('Pdf', '', $option);
            if ($checkOption == "Subidas") {
                $newFilename = $materialFile->getClientOriginalName();
                $mimeType = $materialFile->getMimeType();
                if ($mimeType != "application/zip") {
                    return redirect()->back()->with('message2', 'archivo zip requerido');
                }
                $destinationPath = 'uploads';
                $materialFile->move($destinationPath, $newFilename);
                $filePath = 'uploads/' . $newFilename;
                $downloadUpload->file = $filePath;
                $downloadUpload->name = $newFilename;
                $downloadUpload->adminDownloadName = 'uploads/' . $newFilename;
            }
            if ($checkOption == "Descargas") {
                $newFilename = $materialFile->getClientOriginalName();
                $mimeType = $materialFile->getMimeType();
                $destinationPath = 'downloads';
                $materialFile->move($destinationPath, $newFilename);
                $filePath = 'https://neoestudio.net/downloads/' . $newFilename;
                $downloadUpload->file = $filePath;
                $downloadUpload->name = $newFilename;
                $downloadUpload->adminDownloadName = 'downloads/' . $newFilename;
            }
        }
        $downloadUpload->save();
        $message = "downloadUpload creado con éxito";
        return redirect()->back()->with('message', $message);
    }

    public function edit($id, $studentType)
    {

        $downloadUpload = \App\DownloadUpload::find($id);

        return view('downloadsUploads.edit', compact('downloadUpload', 'studentType'));
    }

    public function update(Request $request, $id)
    {
        $downloadUpload = \App\DownloadUpload::find($id);
        $check = $request->get('check');
        $materialFile = $request->file("materialFile");


        if ($check == null) {
            if (!empty($materialFile)) {
                $option = $downloadUpload->option;
                $checkOption = str_replace('Pdf', '', $option);
                if ($checkOption == "Subidas") {
                    $newFilename = $materialFile->getClientOriginalName();
                    $mimeType = $materialFile->getMimeType();
                    if ($option != "SubidasPdf" && $mimeType != "application/zip") {
                        return redirect()->back()->with('message2', 'archivo zip requerido');
                    }
                    $destinationPath = 'uploads';
                    $materialFile->move($destinationPath, $newFilename);
                    $filePath = 'uploads/' . $newFilename;
                    $downloadUpload->file = $filePath;
                    $downloadUpload->name = $newFilename;
                    $downloadUpload->adminDownloadName = 'uploads/' . $newFilename;
                }
                if ($checkOption == "Descargas") {
                    $newFilename = $materialFile->getClientOriginalName();
                    $mimeType = $materialFile->getMimeType();
                    if ($option != "DescargasPdf" && $mimeType != "application/zip") {
                        return redirect()->back()->with('message2', 'archivo zip requerido');
                    }
                    $destinationPath = 'downloads';
                    $materialFile->move($destinationPath, $newFilename);
                    $filePath = 'https://neoestudio.net/downloads/' . $newFilename;
                    $downloadUpload->file = $filePath;
                    $downloadUpload->name = $newFilename;
                    $downloadUpload->adminDownloadName = 'downloads/' . $newFilename;
                }
            }
        }
        $downloadUpload->title = $request->get('title');
        $downloadUpload->courseId = $request->get('courseId');
        $downloadUpload->studentType = $request->get('studentType');
        $downloadUpload->save();
        $message = "Actualizado con éxito";
        return redirect()->back()->with('message', $message);
    }

    public function delete($id)
    {
        $downloadUpload = \App\DownloadUpload::find($id);
        $downloadUpload->delete();
        $message = "Eliminado con éxito";

        return redirect()->back()->with('message', $message);
    }

    public function download($id)
    {      
		$downloadUpload = \App\DownloadUpload::find($id);
        $mat = $downloadUpload->adminDownloadName;
        //$file= public_path(). "/$mat";
        $pp = public_path();

        $file= public_path()."/".$mat;
        //$re = str_replace("/public", "", $pp);
        //$file= "public_path()". "/$mat";
        //$file = "$re" . "/$mat";
        $na = explode("/", $mat);
        $name = $na[1];
        ob_end_clean();
        $headers = array('Content-Type' => \File::mimeType($file));

        return response()->download($file, $name, $headers);

    }

    public function changeStatus($id)
    {
        $material = \App\DownloadUpload::find($id);
        if ($material->status == "Deshabilitado") {
            $material->status = "Habilitado";
            $material->save();

            $exists = \App\User::where('type', $material->studentType)->where('role', 'student')->exists();
            if ($exists == true) {
                $users = \App\User::where('type', $material->studentType)->where('role', 'student')->get();
                foreach ($users as $user) {
                    $notiExists = \App\Notification::where('studentId', $user->id)->where('type', $material->option)->where('typeId1', $material->id)->where('typeId2', $material->folderId)->exists();
                    if ($notiExists == true) {
                        $noti = \App\Notification::where('studentId', $user->id)->where('type', $material->option)->where('typeId1', $material->id)->where('typeId2', $material->folderId)->first();
                        $noti->status = "pending";
                        $noti->save();
                    }
                    if ($notiExists == false) {
                        $noti = new \App\Notification;
                        $noti->studentId = $user->id;
                        $noti->type = $material->option;
                        $noti->status = "pending";
                        $noti->typeId1 = $material->id;
                        $noti->typeId2 = $material->folderId;
                        $noti->save();
                    }

                }
            }
            return redirect()->back()->with('message', 'Status changed successfully');
        }
        if ($material->status == "Habilitado") {
            $material->status = "Deshabilitado";
            $material->save();
            return redirect()->back()->with('message', 'Status changed successfully');
        }
    }

    public function changeStatusFolder($id)
    {
        $material = \App\DownloadUpload::find($id);
        if ($material->status == "Deshabilitado") {
            $material->status = "Habilitado";
            $material->save();
            return redirect()->back()->with('message', 'Status changed successfully');
        }
        if ($material->status == "Habilitado") {
            $material->status = "Deshabilitado";
            $material->save();
            return redirect()->back()->with('message', 'Status changed successfully');
        }
    }
}
