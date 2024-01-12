<?php

namespace App\Http\Controllers;

use App\CPU\CartManager;
use App\CPU\Convert;
use App\CPU\Helpers;
use App\CPU\OrderManager;
use App\Library\sslcommerz\SslCommerzNotification;
use App\Model\BusinessSetting;
use App\Model\Cart;
use App\Model\Currency;
use App\Model\Order;
use App\Model\Product;
use App\Services\paymentMethods\PortwalletService;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/*use Illuminate\Support\Str;
use PortWallet\Exceptions\PortWalletException;
use PortWallet\PortWallet;
use PortWallet\PortWalletClient;*/
use function App\CPU\convert_price;

class PortwalletPaymentController extends Controller
{

   /* public function index(Request $request)
    {
        $currency_model = Helpers::get_business_settings('currency_model');
        if ($currency_model == 'multi_currency') {
            $currency_code = 'BDT';
        } else {
            $default = BusinessSetting::where(['type' => 'system_default_currency'])->first()->value;
            $currency_code = Currency::find($default)->code;
        }

        $discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
        $value = CartManager::cart_grand_total() - $discount;
        $user = Helpers::get_customer();

        $config = Helpers::get_business_settings('portwallet_pay');

        $apiKey = $config['api_key'];
        $secretKey = $config['secret_key'];

        $mode = env('APP_MODE');
        if ($mode == 'live') {
            PortWallet::setApiMode("live");
        }
        $code = base64_encode($apiKey.':'.md5($secretKey.time()));
        dd($code);
        $portWallet = new PortWalletClient($apiKey,$secretKey);
        $referenceId = OrderManager::gen_unique_id();
        $data = array(
            'order' => array(
                'amount' =>  Convert::usdTobdt($value),
               // 'currency' => $currency_code,
                'currency' => 'BDT',
                'redirect_url' => route('portwallet-redirect',['transId' => $referenceId]),
                'ipn_url' => route('portwallet-ipn',['transId' => $referenceId]),
                'reference' => $referenceId,
                'validity' => 900,
            ),
            'product' => array(
                'name' => 'x Polo T-shirt',
                'description' => 'x Polo T-shirt with shipping and handling',
            ),
            'billing' => array(
                'customer' => array(
                    'name' => $user->f_name . ' Chandra ' . $user->l_name,
                    //'email' => $user->email ?? "sajan.chandra@sslwirelss.com",
                    'email' => "sajan.chandra@sslwirelss.com",
                    'phone' => $user->phone,
                    'address' => array(
                        'street' => "dhaka",
                        'city' => "Dhaka",
                        'state' => "dhaka",
                        'zipcode' => "2122",
                        'country' => "BD",
                    ),
                ),
            )
        );

        try {
            \Log::info("port wallet data: ". json_encode($data));
            $invoice = $portWallet->invoice->create($data);
            \Log::info('portwallet response data: '. json_encode($invoice));
            $paymentUrl = $invoice->getPaymentUrl();
            echo "<meta http-equiv='refresh' content='0;url=" . $paymentUrl . "'>";
            exit;
        } catch (\InvalidArgumentException $ex) {
            \Log::error("invalid argument exception: ". $ex->getMessage());
        }catch (PortWalletException $ex) {
           \Log::error("portwallet error: ". $ex->getMessage());
            Toastr::error('Misconfiguration or data is missing!');
            return back();
        }
    }

    public function redirect(Request $request)
    {
        $config = Helpers::get_business_settings('portwallet_pay');
        $apiKey = $config['api_key'];
        $secretKey = $config['secret_key'];
        $mode = env('APP_MODE');
        if ($mode == 'live') {
            PortWallet::setApiMode("live");
        }
        $portWallet = new PortWalletClient($apiKey,$secretKey);
        $invoiceId = $_POST['invoice'];
        $amount = $_POST['amount'];

        $invoice = $portWallet->invoice->retrieve($invoiceId);

        \Log::info("retrieve response data:". $invoice);
        $orderInfo = $invoice->getOrder();
        $tran_id = $request->input('tran_id');
        $unique_id = OrderManager::gen_unique_id();
        $order_ids = [];
        if(isset($orderInfo['status']) && $orderInfo['status'] == 'ACCEPTED'){

            foreach (CartManager::get_cart_group_ids() as $group_id) {
                $data = [
                    'payment_method' => 'portwallet',
                    'order_status' => 'confirmed',
                    'payment_status' => 'paid',
                    'transaction_ref' => $tran_id,
                    'order_group_id' => $unique_id,
                    'cart_group_id' => $group_id
                ];
                $order_id = OrderManager::generate_order($data);
                array_push($order_ids, $order_id);
            }
            CartManager::cart_clean();
            return view('web-views.checkout-complete');
        } else {
            DB::table('orders')
                ->whereIn('id', $order_ids)
                ->update(['order_status' => 'failed']);
            Toastr::error('Payment failed!');
            return back();
        }
    }

    public function ipn(Request $request)
    {
        $config = Helpers::get_business_settings('portwallet_pay');
        $apiKey = $config['api_key'];
        $secretKey = $config['secret_key'];
        $mode = env('APP_MODE');
        if ($mode == 'live') {
            PortWallet::setApiMode("live");
        }
        $portWallet = new PortWalletClient($apiKey,$secretKey);
        $invoiceId = $_POST['invoice'];
        $amount = $_POST['amount'];

        $invoice = $portWallet->invoice->ipnValidate($invoiceId, $amount);
        \Log::info("ipn response data:". $invoice);
        $orderInfo = $invoice->getOrder();
        $tran_id = $request->input('tran_id');
        $unique_id = OrderManager::gen_unique_id();
        $order_ids = [];
        if(isset($orderInfo['status']) && $orderInfo['status'] == 'ACCEPTED'){

            foreach (CartManager::get_cart_group_ids() as $group_id) {
                $data = [
                    'payment_method' => 'portwallet',
                    'order_status' => 'confirmed',
                    'payment_status' => 'paid',
                    'transaction_ref' => $tran_id,
                    'order_group_id' => $unique_id,
                    'cart_group_id' => $group_id
                ];
                $order_id = OrderManager::generate_order($data);
                array_push($order_ids, $order_id);
            }
            CartManager::cart_clean();
            return view('web-views.checkout-complete');
        } else {
            DB::table('orders')
                ->whereIn('id', $order_ids)
                ->update(['order_status' => 'failed']);
            Toastr::error('Payment failed!');
            return back();
        }
    }*/


    public function indexV2(Request $request){
        $emi_enable=0;
        if(!empty($request->is_emi) && $request->is_emi ==1)
        {
            $emi_enable=1;
        }
        $currency_model = Helpers::get_business_settings('currency_model');
        if ($currency_model == 'multi_currency') {
            $currency_code = 'BDT';
        } else {
            $default = BusinessSetting::where(['type' => 'system_default_currency'])->first()->value;
            $currency_code = Currency::find($default)->code;
        }

        $discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
        $value = CartManager::cart_grand_total() - $discount;
        $user = Helpers::get_customer();

        $config = Helpers::get_business_settings('portwallet_pay');

        $apiKey = $config['api_key'];
        $secretKey = $config['secret_key'];

        $mode = env('APP_MODE');
        $portWalletService = new PortwalletService($apiKey,$secretKey,$mode);
        $referenceId = OrderManager::gen_unique_id();
        $data = array(
            'order' => array(
                'amount' =>  Convert::usdTobdt($value),
                // 'currency' => $currency_code,
                'currency' => 'BDT',
                'redirect_url' => route('portwallet-redirect',['transId' => $referenceId]),
                'ipn_url' => route('portwallet-ipn',['transId' => $referenceId]),
                'reference' => $referenceId,
                'validity' => 900,
            ),
            'product' => array(
                'name' => 'x Polo T-shirt',
                'description' => 'x Polo T-shirt with shipping and handling',
            ),
            'billing' => array(
                'customer' => array(
                    'name' => $user->f_name . ' Chandra ' . $user->l_name,
                    //'email' => $user->email ?? "sajan.chandra@sslwirelss.com",
                    'email' => "sajan.chandra@sslwirelss.com",
                    'phone' => $user->phone,
                    'address' => array(
                        'street' => "dhaka",
                        'city' => "Dhaka",
                        'state' => "dhaka",
                        'zipcode' => "2122",
                        'country' => "BD",
                    ),
                ),
            ),
            'emi' => array(
                'enable' => $emi_enable
            ),
        );

        try {
            $paymentResponseData = [];
            \Log::info("port wallet data: ". json_encode($data));
            $initPayment = $portWalletService->initPayment($data);

            \Log::info('portwallet response data: '. json_encode($initPayment));
            if($initPayment){
                $paymentResponseData = json_decode($initPayment,true);
            }
            $paymentUrl = "";
            if(isset($paymentResponseData['data']['action']) && is_array($paymentResponseData['data']['action'])) {
                $actionData = $paymentResponseData['data']['action'];
                if(isset($actionData['type']) && $actionData['type'] == 'redirect' && $actionData['url'] != '' ){
                    $paymentUrl = $actionData['url'];
                } else {
                    throw new \Exception("Invalid data found");
                }
            }

            echo "<meta http-equiv='refresh' content='0;url=" . $paymentUrl . "'>";
            exit;
        } catch (\InvalidArgumentException $ex) {
            \Log::error("invalid argument exception: ". $ex->getMessage());
            Toastr::error('Misconfiguration or data is missing!');
            return back();
        }
    }


    public function redirectV2(Request $request){
        try{

            $config = Helpers::get_business_settings('portwallet_pay');
            $apiKey = $config['api_key'];
            $secretKey = $config['secret_key'];
            $mode = env('APP_MODE');
            $portWalletService = new PortwalletService($apiKey,$secretKey,$mode);

            $invoiceId = $request->input('invoice');

            $invoiceData = [];
            $orderInfo = [];
            $invoice = $portWalletService->queryPayment($invoiceId);
           if($invoice) {
               $invoiceData = json_decode($invoice,true);
           }
           if(isset($invoiceData['result']) && $invoiceData['result'] == 'success' && isset($invoiceData['data']['order']) && isset($invoiceData['data']['reference'])) {
               $orderInfo = $invoiceData['data']['order'];
               $tran_id = $invoiceData['data']['reference'];
           } else {
               throw new \Exception("Invalid invoice data");
           }
            $unique_id = OrderManager::gen_unique_id();
            $order_id = '';
            $order_ids = [];
            if(isset($orderInfo['status']) && $orderInfo['status'] == 'ACCEPTED'){

                foreach (CartManager::get_cart_group_ids() as $group_id) {
                    $data = [
                        'payment_method' => 'portwallet',
                        'order_status' => 'confirmed',
                        'payment_status' => 'paid',
                        'transaction_ref' => $tran_id,
                        'order_group_id' => $unique_id,
                        'cart_group_id' => $group_id
                    ];
                    $order_id = OrderManager::generate_order($data);
                    array_push($order_ids, $order_id);
                }
                CartManager::cart_clean();
                return view('web-views.checkout-complete', compact('order_id'));
            } else {
                DB::table('orders')
                    ->whereIn('id', $order_ids)
                    ->update(['order_status' => 'failed']);
                Toastr::error('Payment failed!');
                return back();
            }
        }catch (\Exception $exception){
            \Log::error('payment redirection: '.$exception->getMessage());
            Toastr::error('Payment failed!');
            return back();
        }
    }


    public function ipnV2(Request $request) {
        try{
            \Log::info('ipn data:'. $request->all());
            $config = Helpers::get_business_settings('portwallet_pay');
            $apiKey = $config['api_key'];
            $secretKey = $config['secret_key'];
            $mode = env('APP_MODE');
            $portWalletService = new PortwalletService($apiKey,$secretKey,$mode);

            $invoiceId = $request->input('invoice');

            $invoiceData = [];
            $orderInfo = [];
            $invoice = $portWalletService->queryPayment($invoiceId);
            if($invoice) {
                $invoiceData = json_decode($invoice,true);
            }
            if(isset($invoiceData['result']) && $invoiceData['result'] == 'success' && isset($invoiceData['data']['order']) && isset($invoiceData['data']['reference'])) {
                $orderInfo = $invoiceData['data']['order'];
                $tran_id = $invoiceData['data']['reference'];
            } else {
                throw new \Exception("Invalid invoice data");
            }
            $unique_id = OrderManager::gen_unique_id();
            $order_ids = [];
            if(isset($orderInfo['status']) && $orderInfo['status'] == 'ACCEPTED'){

                foreach (CartManager::get_cart_group_ids() as $group_id) {
                    $data = [
                        'payment_method' => 'portwallet',
                        'order_status' => 'confirmed',
                        'payment_status' => 'paid',
                        'transaction_ref' => $tran_id,
                        'order_group_id' => $unique_id,
                        'cart_group_id' => $group_id
                    ];
                    $order_id = OrderManager::generate_order($data);
                    array_push($order_ids, $order_id);
                }
                CartManager::cart_clean();
               return 'success';
            } else {
                DB::table('orders')
                    ->whereIn('id', $order_ids)
                    ->update(['order_status' => 'failed']);
                return 'failed';
            }
        }catch (\Exception $exception){
            \Log::error('payment redirection: '.$exception->getMessage());
            return 'failed';
        }
    }

}