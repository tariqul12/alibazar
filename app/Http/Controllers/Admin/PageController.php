<?php

namespace App\Http\Controllers\Admin;
use App\Model\Page;
use Illuminate\Http\Request;
use App\Model\PageTranslation;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-views.website_settings.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = new Page;
        $page->title = $request->title;
        if (Page::where('slug', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug)))->first() == null) {
            $page->slug             = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
            $page->type             = "custom_page";
            $page->content          = $request->content;
            $page->meta_title       = $request->meta_title;
            $page->meta_description = $request->meta_description;
            $page->keywords         = $request->keywords;
            if($request->hasfile('meta_image')){
                $file= $request->file('meta_image');
                $filename= date('YmdHi').'.'.$file->getClientOriginalExtension();
                $file-> move(public_path('assets/metaimg'), $filename);
                $fielpath='/assets/metaimg/'.$filename;
                $page->meta_image = $fielpath;
            }
            $page->save();
            Toastr::success('Page added successfully.');
            return redirect()->route('admin.website.pages');
        }
        Toastr::warning('Slug has been used already');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function edit(Request $request, $id)
   {
        $lang = $request->lang;
        $page_name = $request->page;
        $page = Page::where('slug', $id)->first();
        if($page != null){
          if ($page_name == 'home') {
            return view('admin-views.website_settings.pages.home_page_edit', compact('page','lang'));
          }
          else{
            return view('admin-views.website_settings.pages.edit', compact('page','lang'));
          }
        }
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        if (Page::where('id','!=', $id)->where('slug', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug)))->first() == null) {
            if($page->type == 'custom_page'){
              $page->slug           = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
            }
            if($request->lang == env("DEFAULT_LANGUAGE")){
              $page->title          = $request->title;
              $page->content        = $request->content;
            }
            $page->meta_title       = $request->meta_title;
            $page->meta_description = $request->meta_description;
            $page->keywords         = $request->keywords;
            if($request->hasfile('meta_image')){
                $destination= $page->meta_image;
                if(File::exists(public_path($destination))){
                    File::delete(public_path($destination));
                }
                $file= $request->file('meta_image');
                $filename= date('YmdHi').'.'.$file->getClientOriginalExtension();
                $file-> move(public_path('assets/metaimg'), $filename);
                $fielpath='/assets/metaimg/'.$filename;
                $page->meta_image = $fielpath;
            }
            $page->save();


            Toastr::success('Page Updated successfully.');
            return redirect()->route('admin.website.pages');
        }

        Toastr::warning('Slug has been used already');
      return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $destination= $page->meta_image;
        if(File::exists(public_path($destination))){
            File::delete(public_path($destination));
        }
        if(Page::destroy($id)){
            Toastr::success('Page Deleted successfully.');
            return redirect()->route('admin.website.pages');
        }
        return back();
    }

    public function show_custom_page($slug){
        $page = Page::where('slug', $slug)->first();
        if($page != null){
            return view('frontend.custom_page', compact('page'));
        }
        abort(404);
    }
    public function mobile_custom_page($slug){
        $page = Page::where('slug', $slug)->first();
        if($page != null){
            return view('frontend.m_custom_page', compact('page'));
        }
        abort(404);
    }
}
