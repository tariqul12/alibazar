<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CPU\FileManagerLogic;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use Madnest\Madzipper\Facades\Madzipper;
use DB;
class FileManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($folder_path = "cHVibGlj")
    {
        $file = Storage::files(base64_decode($folder_path));
        $directories = Storage::directories(base64_decode($folder_path));

        $folders = FileManagerLogic::format_file_and_folders($directories, 'folder');
        $files = FileManagerLogic::format_file_and_folders($file, 'file');
        // dd($files);
        $data = array_merge($folders, $files);
        return view('admin-views.file-manager.index', compact('data', 'folder_path'));
    }


    public function upload(Request $request)
    {
        if (env('APP_MODE') == 'demo') {
            Toastr::info('This option is disabled for demo.');
            return back();
        }

        $request->validate([
            'images' => 'required_without:file',
            'file' => 'required_without:images',
            'path' => 'required',
        ]);
        if ($request->hasfile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $name = $image->getClientOriginalName();
                Storage::disk('local')->put($request->path . '/' . $name, file_get_contents($image));
            }
        }
        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $name = $file->getClientOriginalName();

            Madzipper::make($file)->extractTo('storage/app/' . $request->path);
            // Storage::disk('local')->put($request->path.'/'. $name, file_get_contents($file));

        }
        Toastr::success(\App\CPU\translate('image_uploaded_successfully'));
        return back()->with('success', \App\CPU\translate('image_uploaded_successfully'));
    }
    public function file_details(Request $request)
    {
       
       $result=DB::table('uploads')->where('file_name',$request->file_name)->first();
       return response()->json($result);
    }
    public function file_details_update(Request $request)
    {
       $data=[
        "img_title"=>$request->img_title,
        "img_alt_tag"=>$request->img_alt_tag,
        "meta_title"=>$request->meta_title,
        "meta_description"=>$request->meta_discription,
       ];
       DB::table('uploads')->where('file_name',$request->file_name)->update($data);
       Toastr::success(trans('Image details update successfully'));
       return back()->with('success', trans('Image_details_update_successfully'));
    }

    public function download($file_name)
    {
        return Storage::download(base64_decode($file_name));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($file_path)
    {
        Storage::disk('local')->delete(base64_decode($file_path));
        Toastr::success(trans('messages.image_deleted_successfully'));
        return back()->with('success', trans('messages.image_deleted_successfully'));
    }
}
