<?php

namespace App\Http\Controllers\Web;

use App\CPU\Helpers;
use App\CPU\OrderManager;
use App\CPU\ProductManager;
use App\CPU\CartManager;
use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\Brand;
use App\Model\BusinessSetting;
use App\Model\Cart;
use App\Model\CartShipping;
use App\Model\Category;
use App\Model\Contact;
use App\Model\DealOfTheDay;
use App\Model\FlashDeal;
use App\Model\FlashDealProduct;
use App\Model\HelpTopic;
use App\Model\OrderDetail;
use App\Model\Product;
use App\Model\ProSearch;
use App\Model\Review;
use App\Model\Seller;
use App\Model\Subscription;
use App\Model\ShippingMethod;
use App\Model\Shop;
use App\Model\Order;
use App\Model\Page;
use App\Model\Transaction;
use App\Model\Translation;
use App\User;
use App\Model\Wishlist;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use function App\CPU\translate;
use App\Model\ShippingType;
use Facade\FlareClient\Http\Response;
use Gregwar\Captcha\PhraseBuilder;
use Gregwar\Captcha\CaptchaBuilder;
use App\CPU\CustomerManager;
use App\CPU\Convert;

class WebController extends Controller
{
    public function maintenance_mode()
    {
        $maintenance_mode = Helpers::get_business_settings('maintenance_mode') ?? 0;
        if ($maintenance_mode) {
            return view('web-views.maintenance-mode');
        }
        return redirect()->route('home');
    }

    public function home()
    {
        $brand_setting = BusinessSetting::where('type', 'product_brand')->first()->value;
        $home_categories = Category::where('home_status', true)->priority()->orderBy('name', 'asc')->get();
        $home_categories->map(function ($data) {
            $id = '"' . $data['id'] . '"';
            $data['products'] = Product::active()
                // ->where('category_ids', 'like', "'%\"id\":{$data['id']}%'")
                ->whereJsonContains('category_ids', ["id" => $data['id']])
                ->inRandomOrder()->take(12)->get();
        });
        
        
        //products based on top seller
        $top_sellers = Seller::approved()->with('shop')
            ->withCount(['orders'])->orderBy('orders_count', 'DESC')->take(12)->get();
        //end

        //feature products finding based on selling
        $featured_products = Product::with(['reviews'])->active()
            ->where('featured', 1)
            ->withCount(['order_details'])->orderBy('order_details_count', 'DESC')
            ->take(12)
            ->get();
            
        //end

        $latest_products = Product::with(['reviews'])->active()->orderBy('id', 'desc')->take(8)->get();
        // return $latest_products;
        $categories = Category::where('position', 0)->priority()->orderBy('name', 'asc')->take(13)->get();
        $brands = Brand::where('name','!=', 'Non Brand')->where('status', 1)->get();
        //best sell product
        $bestSellProduct = OrderDetail::with('product.reviews')
            ->whereHas('product', function ($query) {
                $query->active();
            })
            ->select('product_id', DB::raw('COUNT(product_id) as count'))
            ->groupBy('product_id')
            ->orderBy("count", 'desc')
            ->take(4)
            ->get();
        // dd($bestSellProduct);
        //Top rated
        $topRated = Review::with('product')
            ->whereHas('product', function ($query) {
                $query->active();
            })
            ->select('product_id', DB::raw('AVG(rating) as count'))
            ->groupBy('product_id')
            ->orderBy("count", 'desc')
            ->take(4)
            ->get();
        

        // if ($bestSellProduct->count() == 0) {
        //     $bestSellProduct = $latest_products;
        // }

        // if ($topRated->count() == 0) {
        //     $topRated = $bestSellProduct;
        // }

        $deal_of_the_day = DealOfTheDay::join('products', 'products.id', '=', 'deal_of_the_days.product_id')->select('deal_of_the_days.*', 'products.unit_price')->where('products.status', 1)->where('deal_of_the_days.status', 1)->first();

        return view(
            'web-views.home',
            compact('featured_products', 'topRated', 'bestSellProduct', 'latest_products', 'categories', 'brands', 'deal_of_the_day', 'top_sellers', 'home_categories', 'brand_setting')
        );
    }

    public function flash_deals($id)
    {
        $deal = FlashDeal::with(['products.product.reviews', 'products.product' => function ($query) {
            $query->active();
        }])
            ->where(['id' => $id, 'status' => 1])
            ->whereDate('start_date', '<=', date('Y-m-d'))
            ->whereDate('end_date', '>=', date('Y-m-d'))
            ->first();

        $discountPrice = FlashDealProduct::with(['product'])->whereHas('product', function ($query) {
            $query->active();
        })->get()->map(function ($data) {
            return [
                'discount' => $data->discount,
                'sellPrice' => $data->product->unit_price,
                'discountedPrice' => $data->product->unit_price - $data->discount,

            ];
        })->toArray();


        // dd($deal->toArray());

        if (isset($deal)) {
            return view('web-views.deals', compact('deal', 'discountPrice'));
        }
        Toastr::warning(translate('not_found'));
        return back();
    }

    public function search_shop(Request $request)
    {
        $key = explode(' ', $request['shop_name']);
        $sellers = Shop::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
            }
        })->whereHas('seller', function ($query) {
            return $query->where(['status' => 'approved']);
        })->paginate(30);
        return view('web-views.sellers', compact('sellers'));
    }
    public function blog_page()
    {
        $blog_data = DB::table('blog_post')->orderBy('id', 'DESC')->paginate(6);
        return view('web-views.blog', compact('blog_data'));
    }
    public function blog_view($id)
    {
        $blog_data = DB::table('blog_post')->where('id', $id)->first();
        $view_count = $blog_data->view_count;
        $total_view = $view_count + 1;
        $blog_latest = DB::table('blog_post')->orderBy('created_at', 'DESC')->limit(5)->get();
        $blog_popular = DB::table('blog_post')->orderBy('view_count', 'DESC')->limit(5)->get();
        DB::table('blog_post')->where('id', $id)->update(['view_count' => $total_view, 'updated_at' => date('Y-m-d')]);
        return view('web-views.blog_view', compact('blog_data', 'blog_latest', 'blog_popular'));
    }
    public function all_categories()
    {
        $categories = Category::all();
        return view('web-views.categories', compact('categories'));
    }

    public function categories_by_category($id)
    {
        $category = Category::with(['childes.childes'])->where('id', $id)->first();
        return response()->json([
            'view' => view('web-views.partials._category-list-ajax', compact('category'))->render(),
        ]);
    }

    public function all_brands()
    {
        // $brands = Brand::active()->paginate(24);
        $brands = Brand::active()->where('name','!=', 'Non Brand')->orderBy('name', 'ASC')->get();
        return view('web-views.brands', compact('brands'));
    }

    public function all_sellers()
    {
        $business_mode = Helpers::get_business_settings('business_mode');
        if (isset($business_mode) && $business_mode == 'single') {
            Toastr::warning(translate('access_denied!!'));
            return back();
        }
        $sellers = Shop::whereHas('seller', function ($query) {
            return $query->approved();
        })->paginate(24);
        return view('web-views.sellers', compact('sellers'));
    }

    public function seller_profile($id)
    {
        $seller_info = Seller::find($id);
        return view('web-views.seller-profile', compact('seller_info'));
    }

    public function searched_products(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Product name is required!',
        ]);

        $result = ProductManager::search_products_web($request['name']);
        $products = $result['products'];

        if ($products == null) {
            $result = ProductManager::translated_product_search_web($request['name']);
            $products = $result['products'];
        }

        return response()->json([
            'result' => view('web-views.partials._search-result', compact('products'))->render(),
        ]);
    }

    public function checkout_details(Request $request)
    {
        $cart_group_ids = CartManager::get_cart_group_ids();
        // return count($ cart_group_ids);
        $shippingMethod = Helpers::get_business_settings('shipping_method');
        $carts = Cart::whereIn('cart_group_id', $cart_group_ids)->get();

        $physical_product = false;
        foreach ($carts as $cart) {
            if ($cart->product_type == 'physical') {
                $physical_product = true;
            }
        }

        foreach ($carts as $cart) {
            if ($shippingMethod == 'inhouse_shipping') {
                $admin_shipping = ShippingType::where('seller_id', 0)->first();
                $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
            } else {
                if ($cart->seller_is == 'admin') {
                    $admin_shipping = ShippingType::where('seller_id', 0)->first();
                    $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
                } else {
                    $seller_shipping = ShippingType::where('seller_id', $cart->seller_id)->first();
                    $shipping_type = isset($seller_shipping) == true ? $seller_shipping->shipping_type : 'order_wise';
                }
            }

            // if ($shipping_type == 'order_wise') {
            //     $cart_shipping = CartShipping::where('cart_group_id', $cart->cart_group_id)->first();
            //     if (!isset($cart_shipping)) {
            //         Toastr::info(translate('select_shipping_method_first'));
            //         return redirect('shop-cart');
            //     }
            // }
        }


        if (count($cart_group_ids) > 0) {
            return view('web-views.checkout-shipping', compact('physical_product'));
        }

        Toastr::info(translate('no_items_in_basket'));
        return redirect('/');
    }

    public function checkout_payment()
    {
        $cart_group_ids = CartManager::get_cart_group_ids();

        $shippingMethod = Helpers::get_business_settings('shipping_method');
        $carts = Cart::whereIn('cart_group_id', $cart_group_ids)->get();

        $cod_show = false;
        foreach ($carts as $cart) {
            if ($cart->product_type == 'physical') {
                $cod_show = true;
            }
            if ($shippingMethod == 'inhouse_shipping') {
                $admin_shipping = ShippingType::where('seller_id', 0)->first();
                $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
            } else {
                if ($cart->seller_is == 'admin') {
                    $admin_shipping = ShippingType::where('seller_id', 0)->first();
                    $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
                } else {
                    $seller_shipping = ShippingType::where('seller_id', $cart->seller_id)->first();
                    $shipping_type = isset($seller_shipping) == true ? $seller_shipping->shipping_type : 'order_wise';
                }
            }
            if ($shipping_type == 'order_wise') {
                $cart_shipping = CartShipping::where('cart_group_id', $cart->cart_group_id)->first();
                if (!isset($cart_shipping)) {
                    Toastr::info(translate('select_shipping_method_first'));
                    return redirect('shop-cart');
                }
            }
        }

        if (session()->has('address_id') && count($cart_group_ids) > 0) {
            return view('web-views.checkout-payment', compact('cod_show'));
        }

        Toastr::error(translate('incomplete_info'));
        return back();
    }

    public function checkout_complete(Request $request)
    {
        if ($request->payment_method != 'cash_on_delivery') {
            return back()->with('error', 'Something went wrong!');
        }
        $unique_id = OrderManager::gen_unique_id();
        $order_ids = [];
        $cart_group_ids = CartManager::get_cart_group_ids();
        $carts = Cart::whereIn('cart_group_id', $cart_group_ids)->get();

        $physical_product = false;
        foreach ($carts as $cart) {
            if ($cart->product_type == 'physical') {
                $physical_product = true;
            }
        }

        if ($physical_product) {
            foreach ($cart_group_ids as $group_id) {
                $data = [
                    'payment_method' => 'cash_on_delivery',
                    'order_status' => 'pending',
                    'payment_status' => 'unpaid',
                    'transaction_ref' => '',
                    'order_group_id' => $unique_id,
                    'cart_group_id' => $group_id
                ];
                $order_id = OrderManager::generate_order($data);
                array_push($order_ids, $order_id);
            }

            CartManager::cart_clean();


            return view('web-views.checkout-complete', compact('order_id'));
        }

        return back()->with('error', 'Something went wrong!');
    }
    // eft check out
    public function eft_checkout_complete(Request $request)
    {
        if ($request->payment_method != 'EFT') {
            return back()->with('error', 'Something went wrong!');
        }
        $unique_id = OrderManager::gen_unique_id();
        $order_ids = [];
        $cart_group_ids = CartManager::get_cart_group_ids();
        $carts = Cart::whereIn('cart_group_id', $cart_group_ids)->get();

        $physical_product = false;
        foreach ($carts as $cart) {
            if ($cart->product_type == 'physical') {
                $physical_product = true;
            }
        }

        if ($physical_product) {
            foreach ($cart_group_ids as $group_id) {
                $data = [
                    'payment_method' => 'EFT',
                    'order_status' => 'pending',
                    'payment_status' => 'unpaid',
                    'transaction_ref' => '',
                    'order_group_id' => $unique_id,
                    'cart_group_id' => $group_id
                ];
                $order_id = OrderManager::generate_order($data);
                array_push($order_ids, $order_id);
            }

            CartManager::cart_clean();


            return view('web-views.checkout-complete', compact('order_id'));
        }

        return back()->with('error', 'Something went wrong!');
    }
    public function checkout_complete_wallet(Request $request = null)
    {
        $cartTotal = CartManager::cart_grand_total();
        $user = Helpers::get_customer($request);
        if ($cartTotal > $user->wallet_balance) {
            Toastr::warning(translate('inefficient balance in your wallet to pay for this order!!'));
            return back();
        } else {
            $unique_id = OrderManager::gen_unique_id();
            $order_ids = [];
            foreach (CartManager::get_cart_group_ids() as $group_id) {
                $data = [
                    'payment_method' => 'pay_by_wallet',
                    'order_status' => 'confirmed',
                    'payment_status' => 'paid',
                    'transaction_ref' => '',
                    'order_group_id' => $unique_id,
                    'cart_group_id' => $group_id
                ];
                $order_id = OrderManager::generate_order($data);
                array_push($order_ids, $order_id);
            }

            CustomerManager::create_wallet_transaction($user->id, Convert::default($cartTotal), 'order_place', 'order payment');
            CartManager::cart_clean();
        }

        if (session()->has('payment_mode') && session('payment_mode') == 'app') {
            return redirect()->route('payment-success');
        }
        return view('web-views.checkout-complete', compact('order_id'));
    }

    public function order_placed()
    {
        if (auth('customer')->check()) {
            return view('web-views.checkout-complete');
        } else {
            return redirect()->back();
        }
    }

    public function shop_cart(Request $request)
    {
        if (auth('customer')->check() && Cart::where(['customer_id' => auth('customer')->id()])->count() > 0) {
            return view('web-views.shop-cart');
        } else {
            return view('web-views.shop-cart');
        }
        Toastr::info(translate('no_items_in_basket'));
        return redirect('/');
    }

    public function quote_cart(Request $request)
    {
        $data['categories'] = Category::with(['childes.childes'])->where('position', 0)->priority()->take(8)->get();

        if (auth('customer')->check()) {
            $data['quote_count'] = DB::table('quote_cart')->where(['customer_id' => auth('customer')->id()])->count();
            return view('web-views.quote-cart', $data);
        } else {
            $data['quote_count'] =  DB::table('quote_cart')->where(['reference_no' => session('quote_data')])->count();
            return view('web-views.quote-cart', $data);
        }
        Toastr::info(translate('no_items_in_basket'));
        return redirect('/');
    }
    public function quote_contact()
    {
        return view('web-views.quotation_contact');
    }
    public function quote_rfq_contact()
    {
        return view('web-views.quotation_rfq_contact');
    }
    //for seller Shop

    public function seller_shop(Request $request, $id)
    {
        $business_mode = Helpers::get_business_settings('business_mode');

        $active_seller = Seller::approved()->find($id);

        if (($id != 0) && empty($active_seller)) {
            Toastr::warning(translate('not_found'));
            return redirect('/');
        }

        if ($id != 0 && $business_mode == 'single') {
            Toastr::error(translate('access_denied!!'));
            return back();
        }
        $product_ids = Product::active()
            ->when($id == 0, function ($query) {
                return $query->where(['added_by' => 'admin']);
            })
            ->when($id != 0, function ($query) use ($id) {
                return $query->where(['added_by' => 'seller'])
                    ->where('user_id', $id);
            })
            ->pluck('id')->toArray();


        $avg_rating = Review::whereIn('product_id', $product_ids)->avg('rating');
        $total_review = Review::whereIn('product_id', $product_ids)->count();
        if ($id == 0) {
            $total_order = Order::where('seller_is', 'admin')->where('order_type', 'default_type')->count();
        } else {
            $seller = Seller::find($id);
            $total_order = $seller->orders->where('seller_is', 'seller')->where('order_type', 'default_type')->count();
        }


        //finding category ids
        $products = Product::whereIn('id', $product_ids)->paginate(12);

        $category_info = [];
        foreach ($products as $product) {
            array_push($category_info, $product['category_ids']);
        }

        $category_info_decoded = [];
        foreach ($category_info as $info) {
            array_push($category_info_decoded, json_decode($info));
        }

        $category_ids = [];
        foreach ($category_info_decoded as $decoded) {
            foreach ($decoded as $info) {
                array_push($category_ids, $info->id);
            }
        }

        $categories = [];
        foreach ($category_ids as $category_id) {
            $category = Category::with(['childes.childes'])->where('position', 0)->find($category_id);
            if ($category != null) {
                array_push($categories, $category);
            }
        }
        $categories = array_unique($categories);
        //end

        //products search
        if ($request->product_name) {
            $products = Product::active()
                ->when($id == 0, function ($query) {
                    return $query->where(['added_by' => 'admin']);
                })
                ->when($id != 0, function ($query) use ($id) {
                    return $query->where(['added_by' => 'seller'])
                        ->where('user_id', $id);
                })
                ->where('name', 'like', $request->product_name . '%')
                ->paginate(12);
        } elseif ($request->category_id) {
            $products = Product::active()
                ->when($id == 0, function ($query) {
                    return $query->where(['added_by' => 'admin']);
                })
                ->when($id != 0, function ($query) use ($id) {
                    return $query->where(['added_by' => 'seller'])
                        ->where('user_id', $id);
                })
                ->whereJsonContains('category_ids', [
                    ['id' => strval($request->category_id)],
                ])->paginate(12);
        }

        if ($id == 0) {
            $shop = [
                'id' => 0,
                'name' => Helpers::get_business_settings('company_name'),
            ];
        } else {
            $shop = Shop::where('seller_id', $id)->first();
            if (isset($shop) == false) {
                Toastr::error(translate('shop_does_not_exist'));
                return back();
            }
        }

        return view('web-views.shop-page', compact('products', 'shop', 'categories'))
            ->with('seller_id', $id)
            ->with('total_review', $total_review)
            ->with('avg_rating', $avg_rating)
            ->with('total_order', $total_order);
    }

    //ajax filter (category based)
    public function seller_shop_product(Request $request, $id)
    {
        $products = Product::active()->with('shop')->where(['added_by' => 'seller'])
            ->where('user_id', $id)
            ->whereJsonContains('category_ids', [
                ['id' => strval($request->category_id)],
            ])
            ->paginate(12);
        $shop = Shop::where('seller_id', $id)->first();
        if ($request['sort_by'] == null) {
            $request['sort_by'] = 'latest';
        }

        if ($request->ajax()) {
            return response()->json([
                'view' => view('web-views.products._ajax-products', compact('products'))->render(),
            ], 200);
        }

        return view('web-views.shop-page', compact('products', 'shop'))->with('seller_id', $id);
    }

    public function quick_view(Request $request)
    {
        $product = ProductManager::get_product($request->product_id);
        $order_details = OrderDetail::where('product_id', $product->id)->get();
        $wishlists = Wishlist::where('product_id', $product->id)->get();
        $countOrder = count($order_details);
        $countWishlist = count($wishlists);
        $relatedProducts = Product::with(['reviews'])->where('category_ids', $product->category_ids)->where('id', '!=', $product->id)->limit(12)->get();
        return response()->json([
            'success' => 1,
            'view' => view('web-views.partials._quick-view-data', compact('product', 'countWishlist', 'countOrder', 'relatedProducts'))->render(),
        ]);
    }

    public function product($slug)
    {
        $product = Product::active()->with(['reviews'])->where('slug', $slug)->first();
        if ($product != null) {
            $countOrder = OrderDetail::where('product_id', $product->id)->count();
            $countWishlist = Wishlist::where('product_id', $product->id)->count();
            $relatedProducts = Product::with(['reviews'])->active()->where('category_ids', $product->category_ids)->where('id', '!=', $product->id)->limit(12)->get();
            $deal_of_the_day = DealOfTheDay::where('product_id', $product->id)->where('status', 1)->first();

            return view('web-views.products.details', compact('product', 'countWishlist', 'countOrder', 'relatedProducts', 'deal_of_the_day'));
        }

        Toastr::error(translate('not_found'));
        return back();
    }

    public function products(Request $request)
    {
        $request['sort_by'] == null ? $request['sort_by'] == 'latest' : $request['sort_by'];

        $porduct_data = Product::active()->with(['reviews']);

        if ($request['data_from'] == 'category') {
            $products = $porduct_data->get();
            $product_ids = [];
            foreach ($products as $product) {
                foreach (json_decode($product['category_ids'], true) as $category) {
                    if ($category['id'] == $request['id']) {
                        array_push($product_ids, $product['id']);
                    }
                }
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'brand') {
            $query = $porduct_data->where('brand_id', $request['id']);
        }

        if ($request['data_from'] == 'latest') {
            $query = $porduct_data;
        }

        if ($request['data_from'] == 'top-rated') {
            $reviews = Review::select('product_id', DB::raw('AVG(rating) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')->get();
            $product_ids = [];
            foreach ($reviews as $review) {
                array_push($product_ids, $review['product_id']);
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'best-selling') {
            $details = OrderDetail::with('product')
                ->select('product_id', DB::raw('COUNT(product_id) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')
                ->get();
            $product_ids = [];
            foreach ($details as $detail) {
                array_push($product_ids, $detail['product_id']);
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'most-favorite') {
            $details = Wishlist::with('product')
                ->select('product_id', DB::raw('COUNT(product_id) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')
                ->get();
            $product_ids = [];
            foreach ($details as $detail) {
                array_push($product_ids, $detail['product_id']);
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'featured') {
            $query = Product::with(['reviews'])->active()->where('featured', 1);
        }

        if ($request['data_from'] == 'featured_deal') {
            $featured_deal_id = FlashDeal::where(['status' => 1])->where(['deal_type' => 'feature_deal'])->pluck('id')->first();
            $featured_deal_product_ids = FlashDealProduct::where('flash_deal_id', $featured_deal_id)->pluck('product_id')->toArray();
            $query = Product::with(['reviews'])->active()->whereIn('id', $featured_deal_product_ids);
        }

        if ($request['data_from'] == 'search') {
            $key = explode(' ', $request['name']);
            // $product_ids = Product::where(function ($q) use ($key) {
            //     foreach ($key as $value) {
            //         $q->orWhere('name', 'like', "%{$value}%")->orWhere('code', $value);
            //     }
            // })->pluck('id');
            
            $product_ids = Product::where('name', 'like', "%{$request['name']}%")->pluck('id');

            if (sizeof($product_ids) > 0 && !empty($request['search_cat_id'])) {
                $new_product_ids = [];
                $getProducts = Product::select('id', 'category_ids', 'code')->whereIn('id', $product_ids)->get();
                foreach ($getProducts as $product) {
                    foreach (json_decode($product['category_ids'], true) as $category) {
                        if ($category['id'] == $request['search_cat_id']) {
                            array_push($new_product_ids, $product['id']);
                        }
                    }
                }
                $product_ids = $new_product_ids;
            }

            // if (sizeof($product_ids) == 0) {
            //     $product_ids = Translation::where('translationable_type', 'App\Model\Product')
            //         ->where('key', 'name')
            //         ->where(function ($q) use ($key) {
            //             foreach ($key as $value) {
            //                 $q->orWhere('value', 'like', "%{$value}%");
            //             }
            //         })
            //         ->pluck('translationable_id');
            // }

            $query = $porduct_data->WhereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'discounted') {
            $query = Product::with(['reviews'])->active()->where('discount', '!=', 0);
        }

        if ($request['sort_by'] == 'latest') {
            $fetched = $query->latest();
        } elseif ($request['sort_by'] == 'low-high') {
            $fetched = $query->orderBy('unit_price', 'ASC');
        } elseif ($request['sort_by'] == 'high-low') {
            $fetched = $query->orderBy('unit_price', 'DESC');
        } elseif ($request['sort_by'] == 'a-z') {
            $fetched = $query->orderBy('name', 'ASC');
        } elseif ($request['sort_by'] == 'z-a') {
            $fetched = $query->orderBy('name', 'DESC');
        } else {
            $fetched = $query->latest();
        }

        if ($request['min_price'] != null || $request['max_price'] != null) {
            $fetched = $fetched->whereBetween('unit_price', [Helpers::convert_currency_to_usd($request['min_price']), Helpers::convert_currency_to_usd($request['max_price'])]);
        }

        $data = [
            'id' => $request['id'],
            'name' => $request['name'],
            'data_from' => $request['data_from'],
            'sort_by' => $request['sort_by'],
            'page_no' => $request['page'],
            'min_price' => $request['min_price'],
            'max_price' => $request['max_price'],
        ];
        $products = $fetched->paginate(20)->appends($data);

        if ($request->ajax()) {

            return response()->json([
                'total_product' => $products->total(),
                'view' => view('web-views.products._ajax-products', compact('products'))->render()
            ], 200);
        }
        if ($request['data_from'] == 'category') {
            $data['brand_name'] = Category::find((int)$request['id'])->name;
        }
        if ($request['data_from'] == 'brand') {
            $brand_data = Brand::active()->find((int)$request['id']);
            if ($brand_data) {
                $data['brand_name'] = $brand_data->name;
            } else {
                Toastr::warning(translate('not_found'));
                return redirect('/');
            }
        }

        if ($request['data_from'] == 'search' && !empty($request->name)) {
            //zahed
            
            //query in selectings process that exists within a month
            $searchexist = ProSearch::where('query', $request->name)->first();
            // dd($searchexist);
            if ($searchexist == null) //if doesn't exist: create
            {
                $customer_id = auth('customer')->id() ?? 0;
                ProSearch::create([
                    'customer_id' => $customer_id,
                    'query' => $request->name,
                    'count' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else //if exist: update
            {
                $tcount = $searchexist->count + 1;
                ProSearch::where('id', $searchexist->id)->update(['count' => $tcount]);
            }

            //end zahed
        }


        return view('web-views.products.view', compact('products', 'data'), $data);
    }

    public function discounted_products(Request $request)
    {
        $request['sort_by'] == null ? $request['sort_by'] == 'latest' : $request['sort_by'];

        $porduct_data = Product::active()->with(['reviews']);

        if ($request['data_from'] == 'category') {
            $products = $porduct_data->get();
            $product_ids = [];
            foreach ($products as $product) {
                foreach (json_decode($product['category_ids'], true) as $category) {
                    if ($category['id'] == $request['id']) {
                        array_push($product_ids, $product['id']);
                    }
                }
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'brand') {
            $query = $porduct_data->where('brand_id', $request['id']);
        }

        if ($request['data_from'] == 'latest') {
            $query = $porduct_data->orderBy('id', 'DESC');
        }

        if ($request['data_from'] == 'top-rated') {
            $reviews = Review::select('product_id', DB::raw('AVG(rating) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')->get();
            $product_ids = [];
            foreach ($reviews as $review) {
                array_push($product_ids, $review['product_id']);
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'best-selling') {
            $details = OrderDetail::with('product')
                ->select('product_id', DB::raw('COUNT(product_id) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')
                ->get();
            $product_ids = [];
            foreach ($details as $detail) {
                array_push($product_ids, $detail['product_id']);
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'most-favorite') {
            $details = Wishlist::with('product')
                ->select('product_id', DB::raw('COUNT(product_id) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')
                ->get();
            $product_ids = [];
            foreach ($details as $detail) {
                array_push($product_ids, $detail['product_id']);
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'featured') {
            $query = Product::with(['reviews'])->active()->where('featured', 1);
        }

        if ($request['data_from'] == 'search') {
            $key = explode(' ', $request['name']);
            $query = $porduct_data->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            });
        }

        if ($request['data_from'] == 'discounted_products') {
            $query = Product::with(['reviews'])->active()->where('discount', '!=', 0);
        }

        if ($request['sort_by'] == 'latest') {
            $fetched = $query->latest();
        } elseif ($request['sort_by'] == 'low-high') {
            return "low";
            $fetched = $query->orderBy('unit_price', 'ASC');
        } elseif ($request['sort_by'] == 'high-low') {
            $fetched = $query->orderBy('unit_price', 'DESC');
        } elseif ($request['sort_by'] == 'a-z') {
            $fetched = $query->orderBy('name', 'ASC');
        } elseif ($request['sort_by'] == 'z-a') {
            $fetched = $query->orderBy('name', 'DESC');
        } else {
            $fetched = $query;
        }

        if ($request['min_price'] != null || $request['max_price'] != null) {
            $fetched = $fetched->whereBetween('unit_price', [Helpers::convert_currency_to_usd($request['min_price']), Helpers::convert_currency_to_usd($request['max_price'])]);
        }

        $data = [
            'id' => $request['id'],
            'name' => $request['name'],
            'data_from' => $request['data_from'],
            'sort_by' => $request['sort_by'],
            'page_no' => $request['page'],
            'min_price' => $request['min_price'],
            'max_price' => $request['max_price'],
        ];

        $products = $fetched->paginate(5)->appends($data);

        if ($request->ajax()) {
            return response()->json([
                'view' => view('web-views.products._ajax-products', compact('products'))->render()
            ], 200);
        }
        if ($request['data_from'] == 'category') {
            $data['brand_name'] = Category::find((int)$request['id'])->name;
        }
        if ($request['data_from'] == 'brand') {
            $data['brand_name'] = Brand::active()->find((int)$request['id'])->name;
        }

        return view('web-views.products.view', compact('products', 'data'), $data);
    }

    public function viewWishlist()
    {
        $brand_setting = BusinessSetting::where('type', 'product_brand')->first()->value;
        $digital_product_setting = BusinessSetting::where('type', 'digital_product')->first()->value;

        $wishlists = Wishlist::whereHas('wishlistProduct', function ($q) {
            return $q;
        })->where('customer_id', auth('customer')->id())->get();
        return view('web-views.users-profile.account-wishlist', compact('wishlists', 'brand_setting'));
    }

    public function storeWishlist(Request $request)
    {
        if ($request->ajax()) {
            if (auth('customer')->check()) {
                $wishlist = Wishlist::where('customer_id', auth('customer')->id())->where('product_id', $request->product_id)->first();
                if (empty($wishlist)) {

                    $wishlist = new Wishlist;
                    $wishlist->customer_id = auth('customer')->id();
                    $wishlist->product_id = $request->product_id;
                    $wishlist->save();

                    $countWishlist = Wishlist::whereHas('wishlistProduct', function ($q) {
                        return $q;
                    })->where('customer_id', auth('customer')->id())->get();

                    $data = \App\CPU\translate("Product has been added to wishlist");

                    $product_count = Wishlist::where(['product_id' => $request->product_id])->count();
                    session()->put('wish_list', Wishlist::where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray());
                    return response()->json(['success' => $data, 'value' => 1, 'count' => count($countWishlist), 'id' => $request->product_id, 'product_count' => $product_count]);
                } else {
                    $data = \App\CPU\translate("Product already added to wishlist");
                    return response()->json(['error' => $data, 'value' => 2]);
                }
            } else {
                $data = translate('login_first');
                return response()->json(['error' => $data, 'value' => 0]);
            }
        }
    }

    public function deleteWishlist(Request $request)
    {
        Wishlist::where(['product_id' => $request['id'], 'customer_id' => auth('customer')->id()])->delete();
        $data = "Product has been remove from wishlist!";
        $wishlists = Wishlist::where('customer_id', auth('customer')->id())->get();
        session()->put('wish_list', Wishlist::where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray());
        return response()->json([
            'success' => $data,
            'count' => count($wishlists),
            'id' => $request->id,
            'wishlist' => view('web-views.partials._wish-list-data', compact('wishlists'))->render(),
        ]);
    }

    //for HelpTopic
    public function helpTopic()
    {
        $helps = HelpTopic::Status()->latest()->get();
        return view('web-views.help-topics', compact('helps'));
    }

    //for Contact US Page
    public function contacts()
    {
        return view('web-views.contacts');
    }

    public function about_us()
    {
        $about_us = BusinessSetting::where('type', 'about_us')->first();
        return view('web-views.about-us', [
            'about_us' => $about_us,
        ]);
    }

    public function termsandCondition()
    {
        $terms_condition = BusinessSetting::where('type', 'terms_condition')->first();
        return view('web-views.terms', compact('terms_condition'));
    }

    public function privacy_policy()
    {
        $privacy_policy = BusinessSetting::where('type', 'privacy_policy')->first();
        return view('web-views.privacy-policy', compact('privacy_policy'));
    }

    //order Details

    public function orderdetails()
    {
        return view('web-views.orderdetails');
    }

    public function chat_for_product(Request $request)
    {
        return $request->all();
    }

    public function supportChat()
    {
        return view('web-views.users-profile.profile.supportTicketChat');
    }

    public function error()
    {
        return view('web-views.404-error-page');
    }

    public function contact_store(Request $request)
    {
        //recaptcha validation
        $recaptcha = Helpers::get_business_settings('recaptcha');
        if (isset($recaptcha) && $recaptcha['status'] == 1) {

            try {
                $request->validate([
                    'g-recaptcha-response' => [
                        function ($attribute, $value, $fail) {
                            $secret_key = Helpers::get_business_settings('recaptcha')['secret_key'];
                            $response = $value;
                            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $response;
                            $response = \file_get_contents($url);
                            $response = json_decode($response);
                            if (!$response->success) {
                                $fail(\App\CPU\translate('ReCAPTCHA Failed'));
                            }
                        },
                    ],
                ]);
            } catch (\Exception $exception) {
                return back()->withErrors(\App\CPU\translate('Captcha Failed'))->withInput($request->input());
            }
        } else {
            if (strtolower($request->default_captcha_value) != strtolower(Session('default_captcha_code'))) {
                Session::forget('default_captcha_code');
                return back()->withErrors(\App\CPU\translate('Captcha Failed'))->withInput($request->input());
            }
        }

        $request->validate([
            'mobile_number' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ], [
            'mobile_number.required' => 'Mobile Number is Empty!',
            'subject.required' => ' Subject is Empty!',
            'message.required' => 'Message is Empty!',

        ]);
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->mobile_number = $request->mobile_number;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();
        Toastr::success(translate('Your Message Send Successfully'));
        return back();
    }

    public function captcha($tmp)
    {

        $phrase = new PhraseBuilder;
        $code = $phrase->build(4);
        $builder = new CaptchaBuilder($code, $phrase);
        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        $builder->build($width = 100, $height = 40, $font = null);
        $phrase = $builder->getPhrase();

        if (Session::has('default_captcha_code')) {
            Session::forget('default_captcha_code');
        }
        Session::put('default_captcha_code', $phrase);
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }

    public function order_note(Request $request)
    {
        if ($request->has('order_note')) {
            session::put('order_note', $request->order_note);
        }
        return response()->json();
    }

    public function digital_product_download($id)
    {
        $order_data = OrderDetail::with('order.customer')->find($id);
        $customer_id = auth('customer')->id();
        if ($order_data->order->customer->id != $customer_id) {
            Toastr::info(translate('Invalid customer'));
            return redirect('/');
        }

        if ($order_data->product->digital_product_type == 'ready_product' && $order_data->product->digital_file_ready) {
            $file_path = storage_path('app/public/product/digital-product/' . $order_data->product->digital_file_ready);
        } else {
            $file_path = storage_path('app/public/product/digital-product/' . $order_data->digital_file_after_sell);
        }

        return \response()->download($file_path);
    }

    public function subscription(Request $request)
    {
        //dd($request->all());
        $subscription_email = Subscription::where('email', $request->subscription_email)->first();
        if (isset($subscription_email)) {
            Toastr::info(translate('You already subcribed this site!!'));
            return back();
        } else {
            $new_subcription = new Subscription;
            $new_subcription->email = $request->subscription_email;
            $new_subcription->save();

            Toastr::success(translate('Your subscription successfully done!!'));
            return back();
        }
    }
    public function review_list_product(Request $request)
    {

        $productReviews = Review::where('product_id', $request->product_id)->latest()->paginate(2, ['*'], 'page', $request->offset);


        return response()->json([
            'productReview' => view('web-views.partials.product-reviews', compact('productReviews'))->render(),
            'not_empty' => $productReviews->count()
        ]);
    }

    /*Search all items*/
    public function searched_all_items(Request $request)
    {
        try {
            $data = array();
            $searchItem = $request->input('search_item');
            $brandData = Brand::where('name', 'like', "%{$searchItem}%")->where('status', 1)->take(5)->get();
            $categoryData = Category::where('name', 'like', "%{$searchItem}%")->take(5)->get();
            $suggestionsData = ProSearch::where('query', 'like', "%{$searchItem}%")->take(5)->get();
            $products = Product::active()->where('name', 'like', "%{$searchItem}%")->orWhere('code', $searchItem)->latest()->take(5)->get();
            $data['search_data']['brands'] = $brandData;
            $data['search_data']['suggestions'] = $suggestionsData;
            $data['search_data']['categories'] = $categoryData;
            $data['search_item_name'] = $searchItem;
            $data['products'] = $products;
            $viewData = view('web-views.partials._search-result', $data)->render();
            $data['search_data']['html'] = $viewData;
            $status = "success";
        } catch (\Exception $exception) {
            \Log::error("search all items :" . $exception->getMessage());
            $status = 'failed';
        }
        $data['status'] = $status;
        return \response()->json($data);
    }

    public function searched_specific_item(Request $request)
    {
        try {
            $data = array();
            $searchItem = $request->input('search_item');
            $searchType = $request->input('search_type');
            $searchValue = $request->input('search_value');
            $searchItemName = $request->input('search_item_name');
            $porduct_data = Product::active();

            if ($searchType == 'categories') {
                $products = $porduct_data->get();
                $product_ids = [];
                foreach ($products as $product) {
                    foreach (json_decode($product['category_ids'], true) as $category) {
                        if ($category['id'] == $searchItem) {
                            array_push($product_ids, $product['id']);
                        }
                    }
                }
                $query = $porduct_data->whereIn('id', $product_ids);
            }

            if ($searchType == 'brands') {
                $query = $porduct_data->where('brand_id', $searchItem);
            }
            if ($searchType == 'suggestions') {
                $query = $porduct_data->where('name', 'like', "%{$searchItem}%");
            }
            $products = $query->latest()->take(5)->get();
            $data['products'] = $products;
            $data['search_type'] = $searchType;
            $data['search_item_name'] = $searchItemName;
            $brandData = Brand::where('name', 'like', "%{$searchValue}%")->where('status', 1)->take(5)->get();
            $categoryData = Category::where('name', 'like', "%{$searchValue}%")->take(5)->get();
            $suggestionsData = ProSearch::where('query', 'like', "%{$searchValue}%")->take(5)->get();
            $data['search_data']['brands'] = $brandData;
            $data['search_data']['suggestions'] = $suggestionsData;
            $data['search_data']['categories'] = $categoryData;
            //$data['search_data']['search_item'] = $categoryData;
            $viewData = view('web-views.partials._search-result', $data)->render();
            $data['search_data']['html'] = $viewData;
            $status = "success";
        } catch (\Exception $exception) {
            \Log::error("search all items :" . $exception->getMessage());
            $status = 'failed';
        }
        $data['status'] = $status;
        return \response()->json($data);
    }

    public function show_custom_page($slug)
    {
        $page = Page::where('slug', $slug)->first();
        if ($page != null) {
            return view('web-views.custom_page', compact('page'));
        }
        abort(404);
    }
}