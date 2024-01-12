<?php

namespace App\CPU;

use App\Model\Cart;
use App\Model\CartShipping;
use App\Model\Color;
use App\Model\Product;
use App\Model\Shop;
use Barryvdh\Debugbar\Twig\Extension\Debug;
use Cassandra\Collection;
use Illuminate\Support\Str;
use App\Model\ShippingType;
use App\Model\CategoryShippingCost;
use DB;
class CartManager
{
    public static function cart_to_db()
    {
        $user = Helpers::get_customer();
        if (session()->has('offline_cart')) {
            $cart = session('offline_cart');
            $storage = [];
            foreach ($cart as $item) {
                $db_cart = Cart::where(['customer_id' => $user->id, 'seller_id' => $item['seller_id'], 'seller_is' => $item['seller_is']])->first();
                $storage[] = [
                    'customer_id' => $user->id,
                    'cart_group_id' => isset($db_cart) ? $db_cart['cart_group_id'] : str_replace('offline', $user->id, $item['cart_group_id']),
                    'product_id' => $item['product_id'],
                    'is_emi' => $item['is_emi'],
                    'color' => $item['color'],
                    'choices' => $item['choices'],
                    'variations' => $item['variations'],
                    'variant' => $item['variant'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'tax' => $item['tax'],
                    'discount' => $item['discount'],
                    'slug' => $item['slug'],
                    'name' => $item['name'],
                    'thumbnail' => $item['thumbnail'],
                    'seller_id' => ($item['seller_is'] == 'admin') ? 1 : $item['seller_id'],
                    'seller_is' => $item['seller_is'],
                    'shop_info' => $item['shop_info'],
                    'shipping_cost' => $item['shipping_cost'],
                    'shipping_type' => $item['shipping_type'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
		$check_cart=DB::table('carts')->where('customer_id',$user->id)->where('product_id',$item['product_id'])->first();
                if(empty($check_cart))
                {
                    Cart::insert($storage);
                } 
            }
            session()->put('offline_cart', collect([]));
        }
    }
    public static function quote_to_db()
    {
        if (session()->has('quote_data')) {
            $cart = DB::table('quote_cart')->where('reference_no',session('quote_data'))->where('customer_id',0)->get();
            $storage = [];
            foreach ($cart as $item) {
                $product = Product::find($item->product_id);
                $price = $product->unit_price;
                $tax = Helpers::tax_calculation($price, $product['tax'], 'percent');
                $storage['reference_no'] = $item->reference_no;
                $storage['customer_id'] = auth('customer')->id();
                $storage['product_id'] = $item->product_id;
                $storage['total_qty'] = $item->total_qty;
                $storage['total_discount'] = Helpers::get_product_discount($product, $price);
                $storage['total_tax'] = $tax;
                $storage['total_price'] = $item->total_qty*$price;
                $storage['shipping_cost'] = CartManager::get_shipping_cost_for_product_category_wise($product, $item->total_qty);
            }
            DB::table('quote_cart')->where('reference_no',session('quote_data'))->where('customer_id',0)->delete();
            DB::table('quote_cart')->insert($storage);
          
            //session()->put('quote_data', collect([]));
        }
    }

    public static function get_cart($group_id = null)
    {
        $user = Helpers::get_customer();
        if (session()->has('offline_cart') && $user == 'offline') {
            $cart = session('offline_cart');
            if ($group_id != null) {
                return $cart->where('cart_group_id', $group_id)->get();
            } else {
                return $cart;
            }
        }

        if ($group_id == null) {
            $cart = Cart::whereIn('cart_group_id', CartManager::get_cart_group_ids())->get();
        } else {
            $cart = Cart::where('cart_group_id', $group_id)->get();
        }

        return $cart;
    }

    public static function get_cart_group_ids($request = null)
    {
        $user = Helpers::get_customer($request);
        if ($user == 'offline') {
            if (session()->has('offline_cart') == false) {
                session()->put('offline_cart', collect([]));
            }
            $cart = session('offline_cart');
            $cart_ids = array_unique($cart->pluck('cart_group_id')->toArray());
        } else {
            $cart_ids = Cart::where(['customer_id' => $user->id])->groupBy('cart_group_id')->pluck('cart_group_id')->toArray();
        }
        return $cart_ids;
    }

    public static function get_shipping_cost($group_id = null)
    {
        $cost = 0;
        if ($group_id == null) {
            $order_wise_shipping_cost = CartShipping::whereIn('cart_group_id', CartManager::get_cart_group_ids())->sum('shipping_cost');
            $cart_shipping_cost = Cart::whereIn('cart_group_id', CartManager::get_cart_group_ids())->sum('shipping_cost');
            $cost = $order_wise_shipping_cost + $cart_shipping_cost;
        } else {
            $data = CartShipping::where('cart_group_id', $group_id)->first();
            $order_wise_shipping_cost = isset($data) ? $data->shipping_cost : 0;
            $cart_shipping_cost = Cart::where('cart_group_id', $group_id)->sum('shipping_cost');
            $cost = $order_wise_shipping_cost + $cart_shipping_cost;
        }
        return $cost;
    }
    public static function get_order_shipping_cost($group_id = null)
    {
        $cost = 0;
        // if ($group_id == null) {
        //     $order_wise_shipping_cost = CartShipping::whereIn('cart_group_id', CartManager::get_cart_group_ids())->sum('shipping_cost');
        //     $cart_shipping_cost = Cart::whereIn('cart_group_id', CartManager::get_cart_group_ids())->sum('shipping_cost');
        //     $cost = $order_wise_shipping_cost;
        // } else {
        //     $data = CartShipping::where('cart_group_id', $group_id)->first();
        //     $order_wise_shipping_cost = isset($data) ? $data->shipping_cost : 0;
        //     $cart_shipping_cost = Cart::where('cart_group_id', $group_id)->sum('shipping_cost');
        //     $cost = $order_wise_shipping_cost;
        // }
        $address_id = session('address_id');
        if (isset($address_id)) {
            $address = DB::table('shipping_addresses')->where('id', $address_id)->first();
            if(!empty($address->city))
            {
                $shipping_method = DB::table('shipping_methods')->where('title', $address->city)->select('cost')->first();
                $cost = $shipping_method->cost;
            }

        } else {
            $address = DB::table('shipping_addresses')->where('is_billing', 0)->where('customer_id', auth('customer')->id())->first();
            if(!empty($address->city))
            {
                $shipping_method = DB::table('shipping_methods')->where('title', $address->city)->select('cost')->first();
                $cost = isset($shipping_method->cost) ? $shipping_method->cost : 0;
            }
        }
        return $cost;
    }

    public static function cart_total($cart)
    {
        $total = 0;
        if (!empty($cart)) {
            foreach ($cart as $item) {
                $product_subtotal = $item['price'] * $item['quantity'];
                $total += $product_subtotal;
            }
        }
        return $total;
    }

    public static function cart_total_applied_discount($cart)
    {
        $total = 0;
        if (!empty($cart)) {
            foreach ($cart as $item) {
                $product_subtotal = ($item['price'] - $item['discount']) * $item['quantity'];
                $total += $product_subtotal;
            }
        }
        return $total;
    }

    public static function cart_total_with_tax($cart)
    {
        $total = 0;
        if (!empty($cart)) {
            foreach ($cart as $item) {
                $product_subtotal = ($item['price'] * $item['quantity']) + ($item['tax'] * $item['quantity']);
                $total += $product_subtotal;
            }
        }
        return $total;
    }

    public static function cart_grand_total($cart_group_id = null)
    {
        $cart = CartManager::get_cart($cart_group_id);
        $shipping_cost = CartManager::get_order_shipping_cost($cart_group_id);
        $total = 0;
        $courier_cost=0;
        if (!empty($cart)) {
            foreach ($cart as $item) {
                if(!empty($item['courier_id']))
                {
                    $courier_prod=DB::table('product_wise_courier')
                    ->where('product_id',$item['product_id'])
                    ->where('courier_id',$item['courier_id'])
                    ->first();
                }
               
                if(!empty($courier_prod->amount))
                {
                    $courier_cost +=($courier_prod->amount*$item['quantity']);
                }
               
                $product_subtotal = ($item['price'] * $item['quantity'])
                    + ($item['tax'] * $item['quantity'])
                    - ($item['discount'] * $item['quantity']);
                $total += $product_subtotal;
                
            }
            //dd($shipping_cost);
            $total += $shipping_cost+$courier_cost;
            
        }
        return $total;
    }

    public static function cart_clean($request = null)
    {
        $cart_ids = CartManager::get_cart_group_ids($request);
        CartShipping::whereIn('cart_group_id', $cart_ids)->delete();
        Cart::whereIn('cart_group_id', $cart_ids)->delete();

        session()->forget('coupon_code');
        session()->forget('coupon_discount');
        session()->forget('payment_method');
        session()->forget('shipping_method_id');
        session()->forget('billing_address_id');
        session()->forget('order_id');
        session()->forget('cart_group_id');
        session()->forget('order_note');
    }

    public static function add_to_cart($request, $from_api = false)
    {
        //dd($request->all());
        $str = '';
        $variations = [];
        $price = 0;
        
        if (empty($request['quantity']) || $request['quantity'] <= 0) {
            return [
                'status' => 0,
                'message' => 'Invalid quantity. Please input valid quantity.'
            ];
        }

        $user = Helpers::get_customer($request);
        $product = Product::find($request->id);

        //check the color enabled or disabled for the product
        if ($request->has('color')) {
            $str = Color::where('code', $request['color'])->first()->name;
            $variations['color'] = $str;
        }

        //Gets all the choice values of customer choice option and generate a string like Black-S-Cotton
        $choices = [];
        
        if(!empty($product->choice_options)){
            foreach (json_decode($product->choice_options) as $key => $choice) {
                $choices[$choice->name] = $request[$choice->name];
                $variations[$choice->title] = $request[$choice->name];
                if ($str != null) {
                    $str .= '-' . str_replace(' ', '', $request[$choice->name]);
                } else {
                    $str .= str_replace(' ', '', $request[$choice->name]);
                }
            }
        }

        if ($user == 'offline') {
            if (session()->has('offline_cart')) {
                $cart = session('offline_cart');
                $check = $cart->where('product_id', $request->id)->where('variant', $str)->first();
                if (isset($check) == false) {
                    $cart = collect();
                    $cart['id'] = time();
                } else {
                    return [
                        'status' => 0,
                        'message' => translate('already_added!')
                    ];
                }
            } else {
                $cart = collect();
                session()->put('offline_cart', $cart);
            }
        } else {
            $cart = Cart::where(['product_id' => $request->id, 'customer_id' => $user->id, 'variant' => $str])->first();
            if (isset($cart) == false) {
                $cart = new Cart();
            } else {
                return [
                    'status' => 0,
                    'message' => translate('already_added!')
                ];
            }
        }

        $cart['color']          = $request->has('color') ? $request['color'] : null;
        $cart['product_id']     = $product->id;
        $cart['is_emi']         = $product->is_emi;
        $cart['product_type']   = $product->product_type;
        $cart['choices']        = json_encode($choices);

        //chek if out of stock
        if (($product['product_type'] == 'physical') && ($product['current_stock'] < $request['quantity'])) {
            return [
                'status' => 0,
                'message' => translate('out_of_stock!')
            ];
        }

        $cart['variations'] = json_encode($variations);
        $cart['variant'] = $str;

        //Check the string and decreases quantity for the stock
        if (!empty($request->variant_val)) {
            // $count = count(json_decode($product->variation));
            // for ($i = 0; $i < $count; $i++) {
            //     if (json_decode($product->variation)[$i]->type == $str) {
            //         $price = json_decode($product->variation)[$i]->price;
            //         if (json_decode($product->variation)[$i]->qty < $request['quantity']) {
            //             return [
            //                 'status' => 0,
            //                 'message' => translate('out_of_stock!')
            //             ];
            //         }
            //     }
            // }
            
            $variation_attr=$product->variation;
            $variation_data=json_decode($variation_attr);
            $price=0;
        
            foreach($variation_data as $row)
                {
                    if($row->type==$request->variant_val)
                    {
                        if($row->qty < $request['quantity'])
                        {
                            return [
                                    'status' => 0,
                                    'message' => translate('out_of_stock!')
                                    ];
                        }
                        else{
                            $price=$row->price;
                            $cart['variant'] = $request->variant_val;
                        }
                    }
                }
        } else {
            $price = $product->unit_price;
        }
        $whole_sale=DB::table('wholesale_prices')
            ->where('product_stock_id',$request->id)
            ->where('min_qty','<=',$request['quantity'])
            ->where('max_qty','>=',$request['quantity'])
            ->first();
        if(!empty($whole_sale))
        {
            $price = $whole_sale->price;
        }
        $tax = Helpers::tax_calculation($price, $product['tax'], 'percent');

        //generate group id
        if ($user == 'offline') {
            $check = session('offline_cart');
            $cart_check = $check->where('seller_id', ($product->added_by == 'admin') ? 1 : $product->user_id)
                ->where('seller_is', $product->added_by)->first();
        } else {
            $cart_check = Cart::where([
                'customer_id' => $user->id,
                'seller_id' => ($product->added_by == 'admin') ? 1 : $product->user_id,
                'seller_is' => $product->added_by
            ])->first();
        }

        if (isset($cart_check)) {
            $cart['cart_group_id'] = $cart_check['cart_group_id'];
        } else {
            $cart['cart_group_id'] = ($user == 'offline' ? 'offline' : $user->id) . '-' . Str::random(5) . '-' . time();
        }
        //generate group id end

        $cart['customer_id'] = $user->id ?? 0;
        $cart['quantity'] = $request['quantity'];
        /*$data['shipping_method_id'] = $shipping_id;*/
        $cart['price'] = $price;
        $cart['tax'] = $tax;
        $cart['slug'] = $product->slug;
        $cart['name'] = $product->name;
        $cart['discount'] = Helpers::get_product_discount($product, $price);
        /*$data['shipping_cost'] = $shipping_cost;*/
        $cart['thumbnail'] = $product->thumbnail;
        $cart['seller_id'] = ($product->added_by == 'admin') ? 1 : $product->user_id;
        $cart['seller_is'] = $product->added_by;
        $cart['shipping_cost'] = CartManager::get_order_shipping_cost();
        if ($product->added_by == 'seller') {
            $cart['shop_info'] = Shop::where(['seller_id' => $product->user_id])->first()->name;
        } else {
            $cart['shop_info'] = Helpers::get_business_settings('company_name');
        }

        $shippingMethod = Helpers::get_business_settings('shipping_method');

        if ($shippingMethod == 'inhouse_shipping') {
            $admin_shipping = ShippingType::where('seller_id', 0)->first();
            $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
        } else {
            if ($product->added_by == 'admin') {
                $admin_shipping = ShippingType::where('seller_id', 0)->first();
                $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
            } else {
                $seller_shipping = ShippingType::where('seller_id', $product->user_id)->first();
                $shipping_type = isset($seller_shipping) == true ? $seller_shipping->shipping_type : 'order_wise';
            }
        }
        $cart['shipping_type'] = $shipping_type;
        if ($user == 'offline') {
            $offline_cart = session('offline_cart');
            $offline_cart->push($cart);
            session()->put('offline_cart', $offline_cart);
        } else {
            $cart->save();
        }

        return [
            'status' => 1,
            'message' => translate('successfully_added!')
        ];
    }
    //quote add
    public static function add_to_quote($request, $from_api = false)
    {
        $str = '';
        $variations = [];
        $price = 0;
        
        if (empty($request['quantity']) || $request['quantity'] <= 0) {
            return [
                'status' => 0,
                'message' => 'Invalid quantity. Please input valid quantity.'
            ];
        }

        $user = Helpers::get_customer($request);
        $product = Product::find($request->id);
        if ($str != null) {
            $count = count(json_decode($product->variation));
            for ($i = 0; $i < $count; $i++) {
                if (json_decode($product->variation)[$i]->type == $str) {
                    $price = json_decode($product->variation)[$i]->price;
                    if (json_decode($product->variation)[$i]->qty < $request['quantity']) {
                        return [
                            'status' => 0,
                            'message' => translate('out_of_stock!')
                        ];
                    }
                }
            }
        } else {
            $price = $product->unit_price;
        }
        //chek if out of stock
        if (($product['product_type'] == 'physical') && ($product['current_stock'] < $request['quantity'])) {
            return [
                'status' => 0,
                'message' => translate('out_of_stock!')
            ];
        }
        $tax = Helpers::tax_calculation($price, $product['tax'], 'percent');
        //quote insert
        $ref_no=rand(0, 999999);
        if (session()->has('quote_data')) {
            $cart['reference_no'] = session('quote_data');
        }
        else{
            $cart['reference_no'] = 'QR-' . date("Ymd").'-'. $ref_no;
        }
        // $cart['reference_no'] = 'qr-' . date("Ymd");
        $cart['customer_id'] = $user->id ?? 0;
        $cart['product_id'] =$request->id;
        $cart['total_qty'] = $request['quantity'];
        $cart['total_discount'] = Helpers::get_product_discount($product, $price);
        $cart['total_tax'] = $tax;
        $cart['total_price'] = $request['quantity']*$price;
        $cart['shipping_cost'] = CartManager::get_shipping_cost_for_product_category_wise($product, $request['quantity']);
        $count_quote=0;
        if(auth('customer')->id())
        {
           $check=DB::table('quote_cart')
                ->where('product_id',$request->id)
                ->where('customer_id',auth('customer')->id())
                ->first();
                
            if(!empty($check))
            {
                return [
                    'status' => 0,
                    'message' => translate('already_added!')
                ];
            }
            else{
                DB::table('quote_cart')->insert($cart);
                $quote_count = DB::table('quote_cart')
                ->where('customer_id', auth('customer')->id())
                ->count();
                session()->put('quote_count', $quote_count);
                $count_quote=session()->has('quote_count')?session('quote_count'):0;
            }

        }
        else{
            $check=DB::table('quote_cart')
                ->where('product_id',$request->id)
                ->where('reference_no',$cart['reference_no'])
                ->first();     
            if(!empty($check))
            {
                return [
                    'status' => 0,
                    'message' => translate('already_added!')
                ];
            }
            else{
                DB::table('quote_cart')->insert($cart);
                session()->put('quote_data', $cart['reference_no']);
            } 
        }
        return [
            'count_quote'=>$count_quote,
            'status' => 1,
            'message' => translate('successfully_added!')
        ];
    }
    public static function update_cart_qty($request)
    {
        $user = Helpers::get_customer($request);
        $status = 1;
        $qty = 0;
        $unit_price=0;
        $tax=0;
        $discount=0;
        $sub_total=0;
        $summary_total=0;
        $summary_tax=0;
        $summary_shipping_cost=0;
        $summary_discount_on_product=0;
        $cart = Cart::where(['id' => $request->key, 'customer_id' => $user->id])->first();

        $product = Product::find($cart['product_id']);
        $count = count(json_decode($product->variation));
        // if ($count) {
        //     for ($i = 0; $i < $count; $i++) {
        //         if (json_decode($product->variation)[$i]->type == $cart['variant']) {
        //             if (json_decode($product->variation)[$i]->qty < $request->quantity) {
        //                 $status = 0;
        //                 $qty = $cart['quantity'];
        //             }
        //         }
        //     }
        // } else 
        if (($product['product_type'] == 'physical') && $product['current_stock'] < $request->quantity) {
            $status = 0;
            $qty = $cart['quantity'];
        }

        if ($status) {
            $qty = $request->quantity;
            $cart['quantity'] = $request->quantity;
            $cart['shipping_cost'] =  CartManager::get_shipping_cost_for_product_category_wise($product, $request->quantity);
            $unit_price= $cart['price'];
            $tax= $cart['tax'];
            $discount= $cart['discount'];
            $sub_total=$unit_price* $qty-$discount;
        }

        $cart->save();
        $summary_cart=DB::table('carts')->where('customer_id',auth('customer')->id())->get();
        foreach($summary_cart as $row)
        {
            $summary_total +=($row->price*$row->quantity);
            $summary_tax +=($row->tax*$row->quantity);
            $summary_discount_on_product+=($row->discount*$row->quantity);
        }
        $shipping=CartManager::get_shipping_cost();
        $total_summary=$summary_total+$summary_tax+$shipping-$summary_discount_on_product;
        return [
            'key'=>$request->key,
            'status' => $status,
            'qty' => $qty,
            'unit_price'=>$unit_price,
            'tax'=>$tax,
            'discount'=>$discount,
            'shipping_cost'=>$cart['shipping_cost'],
            'sub_total'=>$sub_total,
            'summary_total'=>($summary_total-$summary_discount_on_product),
            'summary_tax'=>$summary_tax,
            'summary_shipping_cost'=>CartManager::get_shipping_cost(),
            'total_summary'=>$total_summary,
            'message' => $status == 1 ? translate('successfully_updated!') : translate('sorry_stock_is_limited')
        ];
    }
    public static function update_offline_cart_qty($request)
    {
        //dd($request->all());
        $user = Helpers::get_customer($request);
        $status = 1;
        $qty = 0;
        //$cart = Cart::where(['id' => $request->key, 'customer_id' => $user->id])->first();
        $data = session('offline_cart')->groupBy('cart_group_id');
        foreach($data as $group)
        {
            foreach($group as $cart)
            {
                if($cart['id']==$request->key)
                {
                    $product = Product::find($cart['product_id']);
                    if (($product['product_type'] == 'physical') && $product['current_stock'] < $request->quantity) {
                            $status = 0;
                            $qty = $cart['quantity'];
                        }
                   
                    if ($status==1) {
                        $qty = $request->quantity;
                        $cart['quantity'] = $request->quantity;
                        $cart['shipping_cost'] =  CartManager::get_shipping_cost_for_product_category_wise($product, $request->quantity);
                    }
                   // dd(session('offline_cart'));
                    return [
                    'status' => $status,
                    'qty' => $qty,
                    'message' => $status == 1 ? translate('successfully_updated!') : translate('sorry_stock_is_limited')
                    ];
                }

            }

        }
       
    }
    public static function get_shipping_cost_for_product_category_wise($product, $qty)
    {
        $shippingMethod = Helpers::get_business_settings('shipping_method');
        $cost = 0;

        if ($shippingMethod == 'inhouse_shipping') {
            $admin_shipping = ShippingType::where('seller_id', 0)->first();
            $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
        } else {
            if ($product->added_by == 'admin') {
                $admin_shipping = ShippingType::where('seller_id', 0)->first();
                $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
            } else {
                $seller_shipping = ShippingType::where('seller_id', $product->user_id)->first();
                $shipping_type = isset($seller_shipping) == true ? $seller_shipping->shipping_type : 'order_wise';
            }
        }

        if ($shipping_type == 'category_wise') {
            $categoryID = 0;
            foreach (json_decode($product->category_ids) as $ct) {
                if ($ct->position == 1) {
                    $categoryID = $ct->id;
                }
            }

            if ($shippingMethod == 'inhouse_shipping') {
                $category_shipping_cost = CategoryShippingCost::where('seller_id', 0)->where('category_id', $categoryID)->first();
            } else {
                if ($product->added_by == 'admin') {
                    $category_shipping_cost = CategoryShippingCost::where('seller_id', 0)->where('category_id', $categoryID)->first();
                } else {
                    $category_shipping_cost = CategoryShippingCost::where('seller_id', $product->user_id)->where('category_id', $categoryID)->first();
                }
            }



            if ($category_shipping_cost->multiply_qty == 1) {
                $cost = $qty * $category_shipping_cost->cost;
            } else {
                $cost = $category_shipping_cost->cost;
            }
        } else if ($shipping_type == 'product_wise') {

            if ($product->multiply_qty == 1) {
                $cost = $qty * $product->shipping_cost;
            } else {
                $cost = $product->shipping_cost;
            }
        } else {
            $cost = 0;
        }

        return $cost;
    }
}