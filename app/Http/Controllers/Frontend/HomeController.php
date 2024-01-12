<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Banner;
use App\Model\Brand;
use App\Model\Category;
use App\Model\DealOfTheDay;
use App\Model\OrderDetail;
use App\Model\Product;
use App\Model\Review;
use App\Model\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index() {
        $home_categories = Category::where('home_status', true)->priority()->orderBy('name','asc')->get();
        $home_categories->map(function ($data) {
            $id = '"'.$data['id'].'"';
            $data['products'] = Product::active()
                ->where('category_ids', 'like', "%{$id}%")
                /*->whereJsonContains('category_ids', ["id" => (string)$data['id']])*/
                ->inRandomOrder()->take(12)->get();
        });
        $data['home_categories'] = $home_categories;
        $data['featured_products'] = Product::with(['reviews'])->active()
            ->where('featured', 1)
            ->withCount(['order_details'])->orderBy('order_details_count', 'DESC')
            ->take(12)
            ->get();
        $data['latest_products'] = Product::with(['reviews'])->active()->orderBy('id', 'desc')->take(8)->get();
        $data['categories'] = Category::with(['childes.childes'])->where('position', 0)->priority()->orderBy('name','asc')->take(11)->get();
        //$data['brands'] = Brand::take(15)->get();
        $data['brands'] = Brand::where('name','!=', 'Non Brand')->take(15)->get();
        $data['banners'] = Banner::where('banner_type','Main Banner')->where('published',1)->orderBy('id','desc')->get();
        $data['section_banner'] = Banner::where('banner_type','Main Section Banner')->where('published',1)->orderBy('id','desc')->first();
        $data['vertical_banner'] = Banner::where('banner_type','Footer Banner')->where('published',1)->orderBy('id','desc')->first();
        $data['bottom_banner'] = Banner::where('banner_type','Bottom Banner')->where('published',1)->orderBy('id','desc')->first();
        $data['sideBanners'] = Banner::where('banner_type','Side Banner')->where('published',1)->orderBy('id','desc')->get();
        //dd($home_categories);
        return view('frontend.home.index',$data);
    }
}