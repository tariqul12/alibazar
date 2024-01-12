<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Cart;
use App\Model\Category;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use function App\CPU\translate;

class CartController extends Controller
{
    public function shop_cart(Request $request)
    {
        $data['categories'] = Category::with(['childes.childes'])->where('position', 0)->priority()->take(11)->get();
        return view("frontend.shop.cart",$data);
        if (auth('customer')->check() && Cart::where(['customer_id' => auth('customer')->id()])->count() > 0) {
            return view('web-views.shop-cart');
        }
        Toastr::info(translate('no_items_in_basket'));
        return redirect('/');
    }
}
