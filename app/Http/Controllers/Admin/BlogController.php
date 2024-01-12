<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function App\CPU\translate;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $data['blog_cat'] = DB::table('blog_category')->paginate(5);
        return view('admin-views.blog.category_add', $data);
    }

    public function edit($id)
    {
        $data['blog_cat'] = DB::table('blog_category')->where('id', $id)->first();
        return view('admin-views.blog.category_edit', $data);
    }

    public function store(Request $request)
    {
        //dd($request->all());

        try {
            $data = [
                'name' => $request->cat_name,
                'slug' => $request->slug,
            ];
            DB::table('blog_category')->insert($data);
            Toastr::success(translate('Category added successfully'));
            return redirect()->route('admin.blog.category_list');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        //dd($request->all());
        try {
            $data = [
                'name' => $request->cat_name,
                'slug' => $request->slug,
            ];
            DB::table('blog_category')->where('id', $request->cat_id)->update($data);
            Toastr::success(translate('Category Update successfully'));
            return redirect()->route('admin.blog.category_list');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    public function category_delete($id)
    {
        DB::table('blog_category')->where('id', $id)->delete();
        Toastr::success(translate('Category Delete successfully'));
        return redirect()->route('admin.blog.category_list');
    }
    public function blog_list(Request $request)
    {
        $data['blog_post'] = DB::table('blog_post')
            ->join('blog_category', 'blog_category.id', 'blog_post.cat_id')
            ->select('blog_post.*', 'blog_category.name as cat_name')
            ->paginate(5);
        return view('admin-views.blog.blog_list', $data);
    }
    public function blog_add(Request $request)
    {
        $data['blog_cat'] = DB::table('blog_category')->get();
        return view('admin-views.blog.blog_add', $data);
    }
    public function blog_store(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'post_img' => 'required|mimes:jpeg,png,jpg,gif|max:4096',
            ]);
            $documentName = time() . '.' . $request->post_img->extension();
            $request->post_img->move(public_path('blog'), $documentName);
            $path = "public/blog/" . $documentName;
            $cat_slug = DB::table('blog_category')->where('id', $request->cat_id)->select('slug')->first();
            $data = [
                "title" => $request->title,
                "cat_id" => $request->cat_id,
                "post" => $request->post,
                "slug" => $cat_slug->slug,
                "post_img" => $path,
                "meta_key" => $request->meta_key,
                "meta_description" => $request->meta_description,
                "created_by" => Auth::id(),
            ];
            DB::table('blog_post')->insert($data);
            Toastr::success(translate('Blog Save successfully'));
            return redirect()->route('admin.blog.blog_list');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    public function blog_edit($id)
    {
        $data['blog_post'] = DB::table('blog_post')
            ->join('blog_category', 'blog_category.id', 'blog_post.cat_id')
            ->select('blog_post.*', 'blog_category.name as cat_name','blog_category.id as category_id')
            ->where('blog_post.id', $id)
            ->first();
        $data['blog_cat'] = DB::table('blog_category')->get();
        return view('admin-views.blog.blog_edit', $data);
    }
    public function blog_update(Request $request)
    {
        // dd($request->all());
        try {
            
            if($request->post_img)
            {
                $request->validate([
                    'post_img' => 'required|mimes:jpeg,png,jpg,gif|max:4096',
                ]);
                $documentName = time() . '.' . $request->post_img->extension();
                $request->post_img->move(public_path('blog'), $documentName);
                $path = "public/blog/" . $documentName;
            }
            $cat_slug = DB::table('blog_category')->where('id', $request->cat_id)->select('slug')->first();
            $blog_img = DB::table('blog_post')->where('id', $request->blog_id)->select('post_img')->first();
            $data = [
                "title" => $request->title,
                "cat_id" => $request->cat_id,
                "post" => $request->post,
                "slug" => $cat_slug->slug,
                "post_img" =>isset($path)?$path:$blog_img->post_img,
                "meta_key" => $request->meta_key,
                "meta_description" => $request->meta_description,
                "created_by" => Auth::id(),
            ];
            DB::table('blog_post')->where('id',$request->blog_id)->update($data);
            Toastr::success(translate('Blog update successfully'));
            return redirect()->route('admin.blog.blog_list');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    public function blog_delete($id)
    {
        DB::table('blog_post')->where('id', $id)->delete();
        Toastr::success(translate('Blog Delete successfully'));
        return redirect()->route('admin.blog.blog_list');
    }
}
