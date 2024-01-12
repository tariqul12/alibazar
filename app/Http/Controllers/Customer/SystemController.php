<?php

namespace App\Http\Controllers\Customer;

use App\CPU\CartManager;
use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\CartShipping;
use App\Model\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SystemController extends Controller
{
    public function set_payment_method($name)
    {
        if (auth('customer')->check() || session()->has('mobile_app_payment_customer_id')) {
            session()->put('payment_method', $name);
            return response()->json([
                'status' => 1
            ]);
        }
        return response()->json([
            'status' => 0
        ]);
    }

    public function set_shipping_method(Request $request)
    {
        if ($request['cart_group_id'] == 'all_cart_group') {
            foreach (CartManager::get_cart_group_ids() as $group_id) {
                $request['cart_group_id'] = $group_id;
                self::insert_into_cart_shipping($request);
            }
        } else {
            self::insert_into_cart_shipping($request);
        }

        return response()->json([
            'status' => 1
        ]);
    }

    public static function insert_into_cart_shipping($request)
    {
        $shipping = CartShipping::where(['cart_group_id' => $request['cart_group_id']])->first();
        if (isset($shipping) == false) {
            $shipping = new CartShipping();
        }
        $shipping['cart_group_id'] = $request['cart_group_id'];
        $shipping['shipping_method_id'] = $request['id'];
        $shipping['shipping_cost'] = ShippingMethod::find($request['id'])->cost;
        $shipping->save();
    }
    public function emi_details(Request $request)
    {
        
       $result=DB::table('bank_emi')->where('bank_id',$request->bank_id)
                ->get();
    return response()->json(['response' => 'success', 'result' => $result]); 
    }
    public function choose_shipping_address(Request $request)
    {
        $physical_product = $request->physical_product;
        $shipping = [];
        $billing = [];
        parse_str($request->shipping, $shipping);
        parse_str($request->billing, $billing);

        if (isset($shipping['save_address']) && $shipping['save_address'] == 'on') {

            if ($shipping['contact_person_name'] == null || $shipping['address'] == null || $shipping['city'] == null ) {
                return response()->json([
                    'errors' => ['']
                ], 403);
            }

            $address_id = DB::table('shipping_addresses')->insertGetId([
                'customer_id' => auth('customer')->id(),
                'contact_person_name' => $shipping['contact_person_name'],
                'address_type' => $shipping['address_type'],
                'address' => $shipping['address'],
                'city' => $shipping['city'],
                'zip' => $shipping['zip'],
                'phone' => $shipping['phone'],
                'latitude' => $shipping['latitude'],
                'longitude' => $shipping['longitude'],
                'is_billing' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        } else if (isset($shipping['shipping_method_id']) && $shipping['shipping_method_id'] == 0) {

            if ($shipping['contact_person_name'] == null || $shipping['address'] == null || $shipping['city'] == null ) {
                return response()->json([
                    'errors' => ['']
                ], 403);
            }

            $address_id = DB::table('shipping_addresses')->insertGetId([
                'customer_id' => 0,
                'contact_person_name' => $shipping['contact_person_name'],
                'address_type' => $shipping['address_type'],
                'address' => $shipping['address'],
                'city' => $shipping['city'],
                'zip' => $shipping['zip'],
                'phone' => $shipping['phone'],
                'latitude' => $shipping['latitude'],
                'longitude' => $shipping['longitude'],
                'is_billing' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $address_id = isset($shipping['shipping_method_id']) ? $shipping['shipping_method_id'] : 0;
        }


        if ($request->billing_addresss_same_shipping == 'false') {
            if (isset($billing['save_address_billing']) && $billing['save_address_billing'] == 'on') {

                if ($billing['billing_contact_person_name'] == null || $billing['billing_address'] == null || $billing['billing_city'] == null ) {
                    return response()->json([
                        'errors' => ['']
                    ], 403);
                }

                $billing_address_id = DB::table('shipping_addresses')->insertGetId([
                    'customer_id' => auth('customer')->id(),
                    'contact_person_name' => $billing['billing_contact_person_name'],
                    'address_type' => $billing['billing_address_type'],
                    'address' => $billing['billing_address'],
                    'city' => $billing['billing_city'],
                    'zip' => $billing['billing_zip'],
                    'phone' => $billing['billing_phone'],
                    'latitude' => $billing['billing_latitude'],
                    'longitude' => $billing['billing_longitude'],
                    'is_billing' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);


            } else if ($billing['billing_method_id'] == 0) {

                if ($billing['billing_contact_person_name'] == null || $billing['billing_address'] == null || $billing['billing_city'] == null ) {
                    return response()->json([
                        'errors' => ['']
                    ], 403);
                }

                $billing_address_id = DB::table('shipping_addresses')->insertGetId([
                    'customer_id' => 0,
                    'contact_person_name' => $billing['billing_contact_person_name'],
                    'address_type' => $billing['billing_address_type'],
                    'address' => $billing['billing_address'],
                    'city' => $billing['billing_city'],
                    'zip' => $billing['billing_zip'],
                    'phone' => $billing['billing_phone'],
                    'latitude' => $billing['billing_latitude'],
                    'longitude' => $billing['billing_longitude'],
                    'is_billing' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $billing_address_id = $billing['billing_method_id'];
            }
        } else {
            $billing_address_id = $shipping['shipping_method_id'];
        }

        session()->put('address_id', $address_id);
        session()->put('billing_address_id', $billing_address_id);

        return response()->json([], 200);
    }
    public function shipping_address_add(Request $request)
    {
       //dd($request->all());
        if(isset($request->contact_person_name) && auth('customer')->check())
        {
           // $courier=DB::table('courier_service')->where("id",$request->shipp_courier)->first();
            $data=[
                "customer_id"=>auth('customer')->id(),
                "contact_person_name"=>$request->contact_person_name,
                "address_type"=>$request->address_type,
                "address"=>$request->address,
                "city"=>$request->city,
                "zip"=>$request->zip,
                "phone"=>$request->phone,
                //"shipping_courier"=>$courier->name,
                // "courier_id"=>$request->shipp_courier,
                "created_at"=>NOW(),
                "is_billing"=>0,
            ];
            $address_id=DB::table('shipping_addresses')->insertGetId($data);
            session()->put('address_id', $address_id);
            $shipping_id=0;
            //$address_id=DB::table('shipping_addresses')->where('customer_id',auth('customer')->id())->where('is_billing',0)->first()->id;

            if(!empty($address_id))
            {
                $shipping_id=1;
            }
            $discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
            $user_loyalty=DB::table('users')->where('id',auth('customer')->id())->select('loyalty_point')->first();
            $user_point_amt=0;
            if(!empty($user_loyalty->loyalty_point) && $user_loyalty->loyalty_point>0)
                {
                    $user_point_amt=($user_loyalty->loyalty_point/2);
                }
            $amount = CartManager::cart_grand_total()-$discount-$user_point_amt;
            return response()->json(['response' => 'success','shipping_id'=>$shipping_id,'amount'=>$amount]);
        }
        else{
            session()->put('address_id', $request->shipping_method_id);
            $discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
            $user_loyalty=DB::table('users')->where('id',auth('customer')->id())->select('loyalty_point')->first();
            $user_point_amt=0;
            if(!empty($user_loyalty->loyalty_point) && $user_loyalty->loyalty_point>0)
                {
                    $user_point_amt=($user_loyalty->loyalty_point/2);
                }
            $amount = CartManager::cart_grand_total()-$discount-$user_point_amt;
            return response()->json(['response' => 'bill','amount'=>$amount]);
        }

    }
    public function billing_address_add(Request $request)
    {
        if(isset($request->contact_person_name) && auth('customer')->check())
        {
            $data=[
                "customer_id"=>auth('customer')->id(),
                "contact_person_name"=>$request->contact_person_name,
                "address_type"=>$request->address_type,
                "address"=>$request->address,
                "city"=>$request->city,
                "zip"=>$request->zip,
                "phone"=>$request->phone,
                "company_name"=>$request->company_name,
                "company_bin"=>$request->company_bin,
                // "purchase_order_no"=>$request->purchase_order,
                "created_at"=>NOW(),
                "is_billing"=>1,
            ];
            $address_id=DB::table('shipping_addresses')->insertGetId($data);
            session()->put('billing_address_id', $address_id);
            return response()->json(['response' => 'success']);
        }
        else{
            session()->put('billing_address_id', $request->billing_method_id);
            return response()->json(['response' => 'review']);
        }

    }

}
