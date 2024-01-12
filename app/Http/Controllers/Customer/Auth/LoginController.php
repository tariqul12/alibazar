<?php

namespace App\Http\Controllers\Customer\Auth;

use App\CPU\CartManager;
use App\CPU\Helpers;
use App\CPU\SMS_module;
use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use App\Model\Wishlist;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;
use Gregwar\Captcha\PhraseBuilder;
use DB;
use Illuminate\Support\Facades\Auth;
use URL;

class LoginController extends Controller
{
    public $company_name;

    public function __construct()
    {
        $this->middleware('guest:customer', ['except' => ['logout']]);
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

    public function login()
    {
        session()->put('keep_return_url', url()->previous());
        return view('customer-view.auth.login');
    }

    public function submit(Request $request)
    {
        session()->put('keep_return_url', url()->previous());
        $request->validate([
            'user_id' => 'required',
            'password' => 'required|min:8'
        ]);

        $remember = ($request['remember']) ? true : false;

        $user = User::where(['phone' => $request->user_id])->orWhere(['email' => $request->user_id])->first();

        if (isset($user) == false) {
            Toastr::error('Credentials do not match or account has been suspended.');
            return back()->withInput();
        }

        $phone_verification = Helpers::get_business_settings('phone_verification');
        $email_verification = Helpers::get_business_settings('email_verification');
        if ($phone_verification && !$user->is_phone_verified) {
            return redirect(route('customer.auth.check', [$user->id]));
        }
        if ($email_verification && !$user->is_email_verified) {
            return redirect(route('customer.auth.check', [$user->id]));
        }

        if (isset($user) && $user->is_active && auth('customer')->attempt(['email' => $user->email, 'password' => $request->password], $remember)) {
            $wish_list = Wishlist::whereHas('wishlistProduct', function ($q) {
                return $q;
            })->where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray();

            session()->put('wish_list', $wish_list);
            CartManager::quote_to_db();
            Toastr::info('Welcome to ' . Helpers::get_business_settings('company_name') . '!');
            CartManager::cart_to_db();
            // return redirect(session('keep_return_url'));
            return back();
        }

        Toastr::error('Credentials do not match or account has been suspended.');
        return back()->withInput();
    }
    public function login_otp_send(Request $request)
    {
        //dd($request['identity']);
        $request->validate([
            'identity' => 'required',
        ]);
        session()->put('keep_return_url', url()->previous());
        session()->put('login_identity', $request['identity']);
        DB::table('customer_otp_verification')->where('user_type', 'customer')->where('identity', 'like', "%{$request['identity']}%")->delete();
        if (isset($request['identity'])) {
            $token = rand(1000, 9999);
            $phone_no = "88" . $request['identity'];
            DB::table('customer_otp_verification')->insert([
                'identity' => $request['identity'],
                'token' => $token,
                'user_type' => 'customer',
                'created_at' => now(),
            ]);
            SMS_module::send($phone_no, $token);
            Toastr::success('Check your phone.Login OTP sent.');
            //return redirect(session('keep_return_url'));
            return response()->json(['response' => 'success']);
        }
        Toastr::error('No such user found!');
        return back();
    }
    public function resend_otp(Request $request)
    {
        $phone_num = session('login_identity');
        if ($phone_num) {
            DB::table('customer_otp_verification')->where('user_type', 'customer')->where('identity', 'like', "%{$phone_num}%")->delete();
            $token = rand(1000, 9999);
            $phone_no = "88" . $phone_num;
            DB::table('customer_otp_verification')->insert([
                'identity' => $phone_num,
                'token' => $token,
                'user_type' => 'customer',
                'created_at' => now(),
            ]);
            SMS_module::send($phone_no, $token);
            Toastr::success('Check your phone.Login OTP sent.');
            return response()->json(['response' => 'success']);
        }
        Toastr::error('No such user found!');
        return back();
    }
    public function review_login_otp_send(Request $request)
    {
        //dd($request->all());
        session()->put('keep_return_url', url()->previous());
        session()->put('review_phone', $request['phone_no']);
        $users_check = DB::table('users')->where('phone', $request['phone_no'])->first();
        if (!empty($users_check->phone)) {
            Toastr::error('Already you Have a Account.Please Click Login!');
            return response()->json(['response' => 'error']);
        }
        DB::table('customer_otp_verification')->where('user_type', 'customer')->where('identity', 'like', "%{$request['phone_no']}%")->delete();
        if (isset($request['phone_no'])) {
            $token = rand(1000, 9999);
            $phone_no = "88" . $request['phone_no'];
            DB::table('customer_otp_verification')->insert([
                'identity' => $request['phone_no'],
                'token' => $token,
                'user_type' => 'customer',
                'created_at' => now(),
            ]);
            SMS_module::send($phone_no, $token);
            Toastr::success('Check your phone.Login OTP sent.');
            //return redirect(session('keep_return_url'));
            return response()->json(['response' => 'success']);
        }
    }
    public function review_login_submit(Request $request)
    {
        $phone_no = session('review_phone');
        $user_otp = DB::table('customer_otp_verification')
            ->where('identity', $phone_no)
            ->where('token', $request->user_otp)
            ->first();
        if (!empty($user_otp)) {
            $data = [
                "phone" => $phone_no,
            ];
            $insert_id = DB::table('users')->insertGetId($data);
            if (auth('customer')->loginUsingId($insert_id, true)) {
                Toastr::info('Welcome to ' . Helpers::get_business_settings('company_name') . '!');
                CartManager::cart_to_db();
                session()->forget('review_phone');
                $url = session('keep_return_url');
                return response()->json(['response' => 'success', 'url' => $url]);
            }
        }
    }
    public function login_with_otp(Request $request)
    {
        $user_otp = DB::table('customer_otp_verification')
            ->where('identity', $request->identity)
            ->where('token', $request->user_otp)
            ->first();
        $user = User::where('phone', $request->identity)->first();
        if (!empty($user_otp) && !empty($user)) {

            $phone_verification = Helpers::get_business_settings('phone_verification');
            if ($phone_verification  && !$user->is_phone_verified) {
                return redirect(route('customer.auth.check', [$user->id]));
            }
            if (auth('customer')->loginUsingId($user->id, true)) {
                $wish_list = Wishlist::whereHas('wishlistProduct', function ($q) {
                    return $q;
                })->where('customer_id', auth('customer')->id())->pluck('product_id')->toArray();
                session()->put('wish_list', $wish_list);
                CartManager::quote_to_db();
                $quote_count = DB::table('quote_cart')
                    ->where('customer_id', auth('customer')->id())
                    ->count();
                session()->put('quote_count', $quote_count);
                Toastr::info('Welcome to ' . Helpers::get_business_settings('company_name') . '!');
                CartManager::cart_to_db();
                // dd(auth()->user());
                session()->forget('login_identity');
                return response()->json(['response' => 'success']);
            } else {
                return response()->json(['response' => 'error']);
            }
        } elseif (empty($user_otp)) {
            return response()->json(['response' => 'error_msg']);
        } else {
            // $url = URL::to('/customer/auth/sign-up');
            return response()->json(['response' => 'signup']);
        }
    }
    public function login_for_signup_otp(Request $request)
    {
        //dd($request->all());
        $user_otp = DB::table('customer_otp_verification')
            ->where('identity', $request->identity)
            ->where('token', $request->user_otp)
            ->first();
        if (isset($user_otp)) {
            $url = URL::to('/customer/auth/sign-up');
            //dd($url);
            return response()->json(['response' => 'success', 'url' => $url]);
        } else {
            return response()->json(['response' => 'error']);
        }
    }
    public function logout(Request $request)
    {
        auth()->guard('customer')->logout();
        session()->forget('wish_list');
        session()->forget('quote_count');
        Toastr::info('Come back soon, ' . '!');
        return redirect()->route('home');
    }
    public function email_verify(Request $request)
    {
        $user_verify = DB::table('users')
            ->where('email', $request->identity)
            ->first();
        session()->put('customer_email', $request->identity);
        if (isset($user_verify)) {
            return response()->json(['response' => 'success']);
        } else {
            return response()->json(['response' => 'error']);
        }
    }
}
