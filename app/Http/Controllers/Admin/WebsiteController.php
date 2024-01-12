<?php

namespace App\Http\Controllers\Admin;
use App\Model\Page;

use Brian2694\Toastr\Facades\Toastr;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WebsiteController extends Controller
{
	public function header(Request $request)
	{
		return view('admin-views.website_settings.header');
	}
	public function footer()
	{	
	// 	$label_data=DB::select('select * from footer where type = ?', ['widget_label_one']);
	// 	$label_link=DB::select('select * from footer where type = ?', ['widget_label_link']);
	// 	$label = json_encode($label_data);
	// 	$label = preg_replace("_\\\_", "", $label);
	// 	$label = preg_replace("/\"/", "", $label);
	// 	$link = json_encode($label_link);
	// 	$link = preg_replace("_\\\_", "", $link);
	// 	$link = preg_replace("/\"/", "", $link);

	   $data1=DB::table('footer')->where('widget_col',1)->get();
	   $data2=DB::table('footer')->where('widget_col',2)->get();
	  
	    return view('admin-views.website_settings.footer',compact('data1','data2'));
	}
	public function pages()
	{
		$pages=Page::paginate(15);	
		return view('admin-views.website_settings.pages.index', compact('pages'));
	}
	public function appearance(Request $request)
	{
		return view('admin-views.website_settings.appearance');
	}
	// public function footer_widget_one(Request $req){
	// 	$json_label=json_encode($req->label);
	// 	$json_url=json_encode($req->url);
	// 	DB::update('update footer set value = ? where type = ?', [$json_label,'widget_label_one']);
	// 	DB::update('update footer set value = ? where type = ?', [$json_url,'widget_label_link']);
		
	// }

	public function footer_widget_one_store(Request $req){
		
		$deleted = DB::table('footer')->insert([
			'type' => $req->type,
			'value' => $req->value,
			'widget_col'=>$req->widget_col,
		]);
		Toastr::success('Footer Widget link added successfully.');
        return redirect()->route('admin.website.footer');
	
	}

	public function footer_widget_one(Request $req){		
		$c=$req->count;	
		for ($i=0; $i < $c ; $i++) { 

		DB::update('update footer set value = ? , type = ? where id= ?',  [$req['value'][$i] ,$req['type'][$i],$req['wid1id'][$i]]);

		}
		Toastr::success('Footer Widget link updated successfully.');
        return redirect()->route('admin.website.footer');		
	}
	
	public function footer_widget_one_destroy($id){
		
		$deleted = DB::table('footer')->where('id',$id)->delete();

		Toastr::success('Footer Widget link deleted successfully.');
        return redirect()->route('admin.website.footer');
	
	}


	public function footer_widget_two_store(Request $req){
		
		$deleted = DB::table('footer')->insert([
			'type' => $req->type,
			'value' => $req->value,
			'widget_col'=>$req->widget_col,
		]);
		Toastr::success('Footer Widget link added successfully.');
        return redirect()->route('admin.website.footer');
	
	}

	public function footer_widget_two(Request $req){		
		$c=$req->count;	

		for ($i=0; $i < $c ; $i++) { 

		DB::update('update footer set value = ? , type = ?  where id= ? ',  [$req['value'][$i] ,$req['type'][$i],$req['wid2id'][$i]]);

		}
		Toastr::success('Footer Widget link updated successfully.');
        return redirect()->route('admin.website.footer');		
	}
	
	public function footer_widget_two_destroy($id){
		
		$deleted = DB::table('footer')->where('id',$id)->delete();

		Toastr::success('Footer Widget link deleted successfully.');
        return redirect()->route('admin.website.footer');
	
	}
	
	


}