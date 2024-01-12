<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\DealOfTheDay;
use App\Model\OrderDetail;
use App\Model\Product;
use App\Model\Wishlist;
use App\Model\ProductQuestion;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use function App\CPU\translate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\CPU\ProductManager;
class ProductController extends Controller
{
    public function details($slug) {
        $product = Product::active()->with(['reviews'])->where('slug', $slug)->first();
        //add by zahed for product recent view
        
        DB::table('product_recentview')->insert(
             array(
                    'customer_id'  =>  auth('customer')->id() ?? 0, 
                    'product_id'   =>   $product->id,
                    "created_at"   => Carbon::now(),
                    "updated_at"   => now()
             )
        );
        session()->push('products.recently_viewed', $product->id);
        $products = session()->get('products.recently_viewed');
        //
        
        
        $category_name = '';
        $category_id = 0;
        $category_meta_title = '';
        $category_meta_description = '';
        if ($product != null) {
            $countOrder = OrderDetail::where('product_id', $product->id)->count();
            $countWishlist = Wishlist::where('product_id', $product->id)->count();
            //$relatedProducts = Product::with(['reviews'])->active()/*->where('category_ids', $product->category_ids)*/->where('id', '!=', $product->id)->limit(12)->get();
            
            $relatedProducts = ProductManager::get_related_products($product->id);
            $deal_of_the_day = DealOfTheDay::where('product_id', $product->id)->where('status', 1)->first();
            $data = array();
            $data['relatedProducts'] = $relatedProducts;
            $data['single_product'] = $product;
            $pcategory = !empty($product->category_ids) ? json_decode($product->category_ids, true) : [];

            if(sizeof($pcategory) > 0){
                $category = Category::where('id', $pcategory[0]['id'])->first();
                if($category){
                    $category_name = $category->name;
                    $category_id = $category->id;
                    $category_meta_title = $category->meta_title;
                    $category_meta_description = $category->meta_description;
                }
            }

            $data['product_category_name'] = $category_name;
            $data['product_category_id'] = $category_id;
            $data['product_category_meta_title'] = $category_meta_title;
            $data['product_category_meta_description'] = $category_meta_description;
            // $data['product_questions'] = ProductQuestion::where('product_id', $product->id)->whereNotNull('answer')->orderBy('id','desc')->get()->take(5);
            $data['product_questions'] = ProductQuestion::where('product_id', $product->id)->orderBy('id','desc')->get()->take(5);
            $getReviews = DB::table('reviews')->where('product_id',$product->id)->get();
            $data['total_four_star'] = $getReviews->where('rating',4)->count();
            $data['total_five_star'] = $getReviews->where('rating',5)->count();
            $data['total_three_star'] = $getReviews->where('rating',3)->count();
            $data['total_two_star'] = $getReviews->where('rating',2)->count();
            $data['total_one_star'] = $getReviews->where('rating',1)->count();
            //zahed for recent view
            $data['product_recentview'] = Product::whereIn('id', $products)->get();
            //dd($data['product_recentview']);
            //end zahed

            $data['categories'] = Category::with(['childes.childes'])->where('position', 0)->priority()->take(8)->get();
            // return view('frontend.product.details',$data);
            return view('web-views.products.details',$data);
        }

        Toastr::error(translate('not_found'));
        return back();
    }
    public function product_print($slug)
    {
        $product = Product::active()->with(['reviews'])->where('slug', $slug)->first();
        $category_name = '';
        $category_id = 0;
        $category_meta_title = '';
        $category_meta_description = '';
        if ($product) {
            $countOrder = OrderDetail::where('product_id', $product->id)->count();
            $countWishlist = Wishlist::where('product_id', $product->id)->count();
            $relatedProducts = Product::with(['reviews'])->active()/*->where('category_ids', $product->category_ids)*/->where('id', '!=', $product->id)->limit(12)->get();
            $deal_of_the_day = DealOfTheDay::where('product_id', $product->id)->where('status', 1)->first();
            $data = array();
            // $data['relatedProducts'] = $relatedProducts;
            $data['single_product'] = $product;
            $pcategory = !empty($product->category_ids) ? json_decode($product->category_ids, true) : [];

            if(sizeof($pcategory) > 0){
                $category = Category::where('id', $pcategory[0]['id'])->first();
                if($category){
                    $category_name = $category->name;
                    $category_id = $category->id;
                    $category_meta_title = $category->meta_title;
                    $category_meta_description = $category->meta_description;
                }
            }

            $data['product_category_name'] = $category_name;
            $data['product_category_id'] = $category_id;
            $data['product_category_meta_title'] = $category_meta_title;
            $data['product_category_meta_description'] = $category_meta_description;
            // $data['product_questions'] = ProductQuestion::where('product_id', $product->id)->whereNotNull('answer')->orderBy('id','desc')->get()->take(5);
            $data['product_questions'] = ProductQuestion::where('product_id', $product->id)->orderBy('id','desc')->get()->take(5);
            $getReviews = DB::table('reviews')->where('product_id',$product->id)->get();
            $data['total_four_star'] = $getReviews->where('rating',4)->count();
            $data['total_five_star'] = $getReviews->where('rating',5)->count();
            $data['total_three_star'] = $getReviews->where('rating',3)->count();
            $data['total_two_star'] = $getReviews->where('rating',2)->count();
            $data['total_one_star'] = $getReviews->where('rating',1)->count();
            $data['categories'] = Category::with(['childes.childes'])->where('position', 0)->priority()->take(8)->get();
            // return view('frontend.product.details',$data);
            return view('web-views.products.product_print',$data);
        }

        // Toastr::error(translate('not_found'));
        // return back();            
            //return view('web-views.product_print');
    }

}