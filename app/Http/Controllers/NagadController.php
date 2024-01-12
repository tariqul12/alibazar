<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Karim007\LaravelNagad\Facade\NagadPayment;
use Karim007\LaravelNagad\Facade\NagadRefund;
use App\CPU\CartManager;
use App\CPU\OrderManager;
use DB;
class NagadController extends Controller
{
    //
    public function pay(Request $request)
    {
        // $amount = $request->nagad_amount;
        $discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
        $user_loyalty=DB::table('users')->where('id',auth('customer')->id())->select('loyalty_point')->first();
        $user_point_amt=0;
        if(!empty($user_loyalty->loyalty_point) && $user_loyalty->loyalty_point>0)
            {
                $user_point_amt=($user_loyalty->loyalty_point/2);
            }
        $amount = round(CartManager::cart_grand_total()-$discount-$user_point_amt,2);
        $trx_id = uniqid();
        //if you have multipule/dynamic callback url then uncomment bellow line and use dynamic callbackurl
        //otherwise don't do anything
        //config(['nagad.callback_url' => env('NAGAD_CALLBACK_URL')]);

        $response = NagadPayment::create($amount, $trx_id); // 1st parameter is amount and 2nd is unique invoice number
        if (isset($response) && $response->status == "Success") {
            return redirect()->away($response->callBackUrl);
        }
        return redirect()->back()->with("error-alert", "Invalid request try again after few time later");
    }
    public function callback(Request $request)
    {
        if (!$request->status && !$request->order_id) {
            return response()->json([
                "error" => "Not found any status"
            ], 500);
        }

        // if (config("nagad.response_type") == "json") {
        //     return response()->json($request->all());
        // }

        $verify = NagadPayment::verify($request->payment_ref_id); // $paymentRefId which you will find callback URL request parameter

        if (isset($verify->status) && $verify->status == "Success") {
            return $this->success($verify->orderId);
        } else {
            return $this->fail($verify->orderId);
        }
    }

    public function refund($paymentRefId)
    {
        $refundAmount = 1000;
        $verify = NagadRefund::refund($paymentRefId, $refundAmount);
        if (isset($verify->status) && $verify->status == "Success") {
            return $this->success($verify->orderId);
        } else {
            return $this->fail($verify->orderId);
        }
    }
    public function success($transId)
    {
        $order_ids = [];
        $unique_id = OrderManager::gen_unique_id();
        foreach (CartManager::get_cart_group_ids() as $group_id) {
            $data = [
                'payment_method' => 'nagad',
                'order_status' => 'confirmed',
                'payment_status' => 'paid',
                'transaction_ref' => $transId,
                'order_group_id' => $unique_id,
                'cart_group_id' => $group_id
            ];
            $order_id = OrderManager::generate_order($data);
            array_push($order_ids, $order_id);
        }
        CartManager::cart_clean();
        return view("nagad::success", compact('transId'));
    }
    public function fail($transId)
    {
        return view("nagad::failed", compact('transId'));
    }
}
