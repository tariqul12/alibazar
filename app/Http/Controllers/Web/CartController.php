<?php

namespace App\Http\Controllers\Web;


use App\CPU\CartManager;
use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Cart;
use App\Model\Color;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
class CartController extends Controller
{
    public function variant_price(Request $request)
    {
        $product = Product::find($request->id);
        $str = '';
        $quantity = 0;
        $price = 0;

        if ($request->has('color')) {
            $str = Color::where('code', $request['color'])->first()->name;
        }

        foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
            if ($str != null) {
                $str .= '-' . str_replace(' ', '', $request[$choice->name]);
            } else {
                $str .= str_replace(' ', '', $request[$choice->name]);
            }
        }

        if ($str != null) {
            $count = count(json_decode($product->variation));
            for ($i = 0; $i < $count; $i++) {
                if (json_decode($product->variation)[$i]->type == $str) {
                    $tax = Helpers::tax_calculation(json_decode($product->variation)[$i]->price, $product['tax'], $product['tax_type']);
                    $discount = Helpers::get_product_discount($product, json_decode($product->variation)[$i]->price);
                    $price = json_decode($product->variation)[$i]->price - $discount + $tax;
                    $quantity = json_decode($product->variation)[$i]->qty;
                }
            }
        } else {
            $tax = Helpers::tax_calculation($product->unit_price, $product['tax'], $product['tax_type']);
            $discount = Helpers::get_product_discount($product, $product->unit_price);
            $price = $product->unit_price - $discount + $tax;
            $quantity = $product->current_stock;
        }

        return [
            'price' => \App\CPU\Helpers::currency_converter($price * $request->quantity),
            'discount' => \App\CPU\Helpers::currency_converter($discount),
            'tax' => \App\CPU\Helpers::currency_converter($tax),
            'quantity' => $quantity
        ];
    }

    public function addToCart(Request $request)
    {
        $cart = CartManager::add_to_cart($request);
        session()->forget('coupon_code');
        session()->forget('coupon_discount');
        return response()->json($cart);
    }
    public function addToQuote(Request $request)
    {
        $cart = CartManager::add_to_quote($request);
        session()->forget('coupon_code');
        session()->forget('coupon_discount');
        return response()->json($cart);
    }
    public function updateNavCart()
    {
        return response()->json(['data' => view('layouts.front-end.partials.cart')->render()]);
    }
    // public function updateNavQuotation()
    // {
    //     $count=session()->has('quote_count')?session('quote_count'):0;
    //     return response()->json(['data' =>$count]);
    // }
    //removes from Cart
    public function removeFromCart(Request $request)
    {
        $user = Helpers::get_customer();
        if ($user == 'offline') {

            if (session()->has('offline_cart') == false) {
                session()->put('offline_cart', collect([]));
            }
            $cart = session('offline_cart');

            $new_collection = collect([]);
            foreach ($cart as $item) {
                if ($item['id'] !=  $request->key) {
                    $new_collection->push($item);
                }
            }

            session()->put('offline_cart', $new_collection);
            return response()->json(['data' => view('layouts.front-end.partials.cart_details_offline')->render()]);
           // return response()->json($new_collection);
        } else {
            Cart::where(['id' => $request->key, 'customer_id' => auth('customer')->id()])->delete();
        }

        session()->forget('coupon_code');
        session()->forget('coupon_discount');
        session()->forget('shipping_method_id');
        session()->forget('order_note');
        $check=Cart::where(['id' => $request->key, 'customer_id' => auth('customer')->id()])->first();
        if(!empty($check))
        {
            return response()->json(['data' => view('layouts.front-end.partials.cart_details')->render()]);
        }
        else{
            return  redirect()->route('shop-cart');
        }
        
    }
    //review cart remove
   public function removeReviewFromCart(Request $request)
    {
        $user = Helpers::get_customer();
        Cart::where(['id' => $request->key, 'customer_id' => auth('customer')->id()])->delete();
        $discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
        $user_loyalty=DB::table('users')->where('id',auth('customer')->id())->select('loyalty_point')->first();
        $user_point_amt=0;
        if(!empty($user_loyalty->loyalty_point) && $user_loyalty->loyalty_point>0)
            {
                $user_point_amt=($user_loyalty->loyalty_point/2);
            }
        $price = CartManager::cart_grand_total()-$discount-$user_point_amt;
        session()->forget('coupon_code');
        session()->forget('coupon_discount');
        session()->forget('shipping_method_id');
        session()->forget('order_note');

        return response()->json(['data' => view('layouts.front-end.partials.review_details')->render(),'amount'=>$price]);
    }
    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $response = CartManager::update_cart_qty($request);

        session()->forget('coupon_code');
        session()->forget('coupon_discount');

        if ($response['status'] == 0) {
            return response()->json($response);
        }

        return response()->json(view('layouts.front-end.partials.cart_details')->render());
    }
    //review checkout
    public function updateReviewQuantity(Request $request)
    {
        $response = CartManager::update_cart_qty($request);
        // dd($response);
        $discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
        $user_loyalty=DB::table('users')->where('id',auth('customer')->id())->select('loyalty_point')->first();
        $user_point_amt=0;
        if(!empty($user_loyalty->loyalty_point) && $user_loyalty->loyalty_point>0)
            {
                $user_point_amt=($user_loyalty->loyalty_point/2);
            }
        $price = CartManager::cart_grand_total()-$discount-$user_point_amt;
        session()->forget('coupon_code');
        session()->forget('coupon_discount');
        return response()->json(['response'=>$response,'amount'=>$price]);
    }
    public function updateShopCartQuantity(Request $request)
    {
        $response = CartManager::update_cart_qty($request);

        session()->forget('coupon_code');
        session()->forget('coupon_discount');

        if ($response['status'] == 0) {
            return response()->json($response);
        }

        return response()->json(view('layouts.front-end.partials.cart_details')->render());
    }
    public function updateQuoteQuantity(Request $request)
    {
        // dd($request->all());
        if(auth('customer')->check())
        {
            $data=DB::table('quote_cart')->where('id', $request->key)->first();
            $product = Product::find($data->product_id);
            $price = $product->unit_price;
            $new_price=$price*$request->quantity;
            $tax = Helpers::tax_calculation($new_price, $product['tax'], 'percent');
            $db_data=[
                "total_qty"=>$request->quantity,
                "total_price"=>$new_price,
                "total_tax"=>$tax,
            ];
            DB::table('quote_cart')->where('id', $request->key)->update($db_data);
            return response()->json(['response' => 'success']);
        }else
        {
            $data=DB::table('quote_cart')->where('id', $request->key)->first();
            $product = Product::find($data->product_id);
            $price = $product->unit_price;
            $new_price=$price*$request->quantity;
            $tax = Helpers::tax_calculation($new_price, $product['tax'], 'percent');
            $db_data=[
                "total_qty"=>$request->quantity,
                "total_price"=>$new_price,
                "total_tax"=>$tax,
            ];
            DB::table('quote_cart')->where('id', $request->key)->update($db_data);
            return response()->json(['response' => 'success']);
        }
        //session()->put('quote_data[0].total_qty',$request->quantity);
        
    }
    public function updateOfflineShopCartQuantity(Request $request)
    {
        $response = CartManager::update_offline_cart_qty($request);

        session()->forget('coupon_code');
        session()->forget('coupon_discount');

        if ($response['status'] == 0) {
            return response()->json($response);
        }

        return response()->json(view('layouts.front-end.partials.cart_details_offline')->render());
    }
}
