<?php

namespace App\Http\Controllers\Web;

use App\CPU\CustomerManager;
use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\CPU\OrderManager;
use App\CPU\CartManager;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\ShippingAddress;
use App\Model\SupportTicket;
use App\Model\Wishlist;
use App\Model\RefundRequest;
use App\Model\Quotation;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use function App\CPU\translate;
use App\CPU\Convert;

class UserProfileController extends Controller
{
    public function user_account(Request $request)
    {
        if (auth('customer')->check()) {
            $customerDetail = User::where('id', auth('customer')->id())->first();
            return view('web-views.users-profile.account-profile', compact('customerDetail'));
        } else {
            return redirect()->route('home');
        }
    }

    public function user_update(Request $request)
    {
        // $request->validate([
        //     'f_name' => 'required',
        //     'l_name' => 'required',
        //     'password' => 'required|min:6|same:con_password'
        // ], [
        //     'f_name.required' => 'First name is required',
        //     'l_name.required' => 'Last name is required',
        // ]);
        $this->validate($request, [
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:1024'],
        ]);
        $email_check=User::where('email', $request->account_email)->where('id','!=', auth('customer')->id())->first();
        if(!empty($email_check))
        {
            Toastr::error('Email id alredy tacken');
            return back();
        }
        $getUser =  User::where('id', auth('customer')->id())->first();
        if (!empty($request->password)) {
            $request->validate([
                'password' => 'min:6|same:con_password'
            ]);

            if ($request['password'] != $request['con_password']) {
                Toastr::error('Password did not match.');
                return back();
            }

            $getUser->password =  strlen($request->password) > 5 ? bcrypt($request->password) : auth('customer')->user()->password;
        }

        $image = $request->file('image');

        if ($image != null) {
            $imageName = ImageManager::update('profile/', auth('customer')->user()->image, 'png', $request->file('image'));
        } else {
            $imageName = auth('customer')->user()->image;
        }



        // User::where('id', auth('customer')->id())->update([
        //     'image' => $imageName,
        // ]);

        $getUser->image = $imageName;
        $getUser->f_name = $request->f_name;
        $getUser->l_name = $request->l_name;
        $getUser->email = $request->account_email;
        $getUser->phone = $request->phone;


        // $userDetails = [
        //     'f_name' => $request->f_name,
        //     'l_name' => $request->l_name,
        //     'phone' => $request->phone,
        //     'password' => strlen($request->password) > 5 ? bcrypt($request->password) : auth('customer')->user()->password,
        // ];

        if (auth('customer')->check()) {
            // User::where(['id' => auth('customer')->id()])->update($userDetails);

            $getUser->save();
            Toastr::info(translate('updated_successfully'));
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function account_delete($id)
    {
        if (auth('customer')->id() == $id) {
            $user = User::find($id);
            auth()->guard('customer')->logout();

            ImageManager::delete('/profile/' . $user['image']);
            session()->forget('wish_list');

            $user->delete();
            Toastr::info(translate('Your_account_deleted_successfully!!'));
            return redirect()->route('home');
        } else {
            Toastr::warning('access_denied!!');
        }
    }

    public function account_address()
    {
        if (auth('customer')->check()) {
            $shippingAddresses = \App\Model\ShippingAddress::where('customer_id', auth('customer')->id())->get();
            return view('web-views.users-profile.account-address', compact('shippingAddresses'));
        } else {
            return redirect()->route('home');
        }
    }

    public function address_store(Request $request)
    {
        $address = [
            'customer_id' => auth('customer')->check() ? auth('customer')->id() : null,
            'contact_person_name' => $request->name,
            'company_name' => $request->company_name,
            'company_bin' => $request->company_bin,
            'purchase_order_no' => $request->purchase_order_no,
            'address_type' => $request->addressAs,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'phone' => $request->phone,
            'is_billing' => $request->is_billing,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shipping_addresses')->insert($address);
        return back();
    }
    public function order_po_add(Request $request)
    {
        if (!empty($request->po_number)) {
            $data = [
                'purchase_order_no' => $request->po_number
            ];
            DB::table('orders')->where('id', $request->order_id)->update($data);
            Toastr::success(translate('PO_number_added_successfully!!'));
            return back();
        }
    }
    public function address_edit(Request $request, $id)
    {
        $shippingAddress = ShippingAddress::where('customer_id', auth('customer')->id())->find($id);
        if (isset($shippingAddress)) {
            return view('web-views.users-profile.account-address-edit', compact('shippingAddress'));
        } else {
            Toastr::warning(translate('access_denied'));
            return back();
        }
    }

    public function address_update(Request $request)
    {
        $updateAddress = [
            'contact_person_name' => $request->name,
            'company_name' => $request->company_name,
            'company_bin' => $request->company_bin,
            'purchase_order_no' => $request->purchase_order_no,
            'address_type' => $request->addressAs,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'phone' => $request->phone,
            'is_billing' => $request->is_billing,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        if (auth('customer')->check()) {
            ShippingAddress::where('id', $request->id)->update($updateAddress);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function address_delete(Request $request)
    {
        if (auth('customer')->check()) {
            ShippingAddress::destroy($request->id);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function account_payment()
    {
        if (auth('customer')->check()) {
            return view('web-views.users-profile.account-payment');
        } else {
            return redirect()->route('home');
        }
    }
    //added zahed
    public function account_dashboard()
    {
        if (auth('customer')->check()) {
            $orders = Order::where('customer_id', auth('customer')->id())->get();
            $all_order_count = sizeof($orders);
            $completed_order_count = $orders->where('order_status', 'delivered')->count();
            $processing_order_count = $orders->whereIn('order_status', ['confirmed', 'out_for_delivery'])->count();
            $canceled_order_count = $orders->where('order_status', 'canceled')->count();
            $pending_order_count = $orders->where('order_status', 'pending')->count();
            return view('web-views.users-profile.account-dashboard', compact('orders', 'all_order_count', 'completed_order_count', 'processing_order_count', 'canceled_order_count', 'pending_order_count'));
        } else {
            return redirect()->route('home');
        }
    }
    //end
    public function account_oder()
    {
        $orders = Order::where('customer_id', auth('customer')->id())->orderBy('id', 'DESC')->paginate(15);
        return view('web-views.users-profile.account-orders', compact('orders'));
    }

    public function account_order_details(Request $request)
    {
        if (auth('customer')->check()) {
            $order = Order::with('details.product')->find($request->id);
            return view('web-views.users-profile.account-order-details', compact('order'));
        } else {
            return redirect()->route('home');
        }
    }

    public function account_quotation()
    {
        if (auth('customer')->check()) {
            $quotation = Quotation::where('customer_id', auth('customer')->id())->orderBy('id', 'DESC')->paginate(10);
            return view('web-views.users-profile.account-quotation', compact('quotation'));
        } else {
            return redirect()->route('home');
        }
    }

    public function quotation_show($id)
    {
        if (auth('customer')->check()) {
            $data = [];
            $quotation = Quotation::with('productQuotations')->where('id', $id)->firstOrFail();
            $data['productIds'] = $quotation->productQuotations->pluck('product_id')->toArray();

            $data['quotation'] = $quotation;
            $data['quotation_contact'] = DB::table('quotation_contact')->where('quotation_id', $id)->first();
            return view('web-views.users-profile.show', $data);
        } else {
            return redirect()->route('home');
        }
    }

    public function quotationDownload($id)
    {
        if (auth('customer')->check()) {
            $data = [];
            $quotation = Quotation::where('id', $id)->firstOrFail();
            $data['quotation'] = $quotation;
            //return view('web-views.users-profile.download_new', $data);
            $mpdf_view = view('web-views.users-profile.download_new', $data);
            Helpers::quotation_mpdf($mpdf_view, 'Quotation_', $quotation->id);
            return redirect()->back();
        } else {
            return redirect()->route('home');
        }
    }

    public function account_wishlist()
    {
        if (auth('customer')->check()) {
            $wishlists = Wishlist::where('customer_id', auth('customer')->id())->get();
            return view('web-views.products.wishlist', compact('wishlists'));
        } else {
            return redirect()->route('home');
        }
    }

    public function account_tickets()
    {
        if (auth('customer')->check()) {
            $supportTickets = SupportTicket::where('customer_id', auth('customer')->id())->get();
            return view('web-views.users-profile.account-tickets', compact('supportTickets'));
        } else {
            return redirect()->route('home');
        }
    }

    public function ticket_submit(Request $request)
    {
        $ticket = [
            'subject' => $request['ticket_subject'],
            'type' => $request['ticket_type'],
            'customer_id' => auth('customer')->check() ? auth('customer')->id() : null,
            'priority' => $request['ticket_priority'],
            'description' => $request['ticket_description'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('support_tickets')->insert($ticket);
        return back();
    }

    public function single_ticket(Request $request)
    {
        $ticket = SupportTicket::where('id', $request->id)->first();
        return view('web-views.users-profile.ticket-view', compact('ticket'));
    }

    public function comment_submit(Request $request, $id)
    {
        DB::table('support_tickets')->where(['id' => $id])->update([
            'status' => 'open',
            'updated_at' => now(),
        ]);

        DB::table('support_ticket_convs')->insert([
            'customer_message' => $request->comment,
            'support_ticket_id' => $id,
            'position' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back();
    }

    public function support_ticket_close($id)
    {
        DB::table('support_tickets')->where(['id' => $id])->update([
            'status' => 'close',
            'updated_at' => now(),
        ]);
        Toastr::success('Ticket closed!');
        return redirect('/account-tickets');
    }

    public function account_transaction()
    {
        $customer_id = auth('customer')->id();
        $customer_type = 'customer';
        if (auth('customer')->check()) {
            $transactionHistory = CustomerManager::user_transactions($customer_id, $customer_type);
            return view('web-views.users-profile.account-transaction', compact('transactionHistory'));
        } else {
            return redirect()->route('home');
        }
    }

    public function support_ticket_delete(Request $request)
    {

        if (auth('customer')->check()) {
            $support = SupportTicket::find($request->id);
            $support->delete();
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function account_wallet_history($user_id, $user_type = 'customer')
    {
        $customer_id = auth('customer')->id();
        if (auth('customer')->check()) {
            $wallerHistory = CustomerManager::user_wallet_histories($customer_id);
            return view('web-views.users-profile.account-wallet', compact('wallerHistory'));
        } else {
            return redirect()->route('home');
        }
    }

    public function track_order()
    {
        return view('web-views.order-tracking-page');
    }

    public function track_order_result(Request $request)
    {
        $user =  auth('customer')->user();
        if (!isset($user)) {
            $user_id = User::where('phone', $request->phone_number)->first()->id;
            $orderDetails = Order::where('id', $request['order_id'])->whereHas('details', function ($query) use ($user_id) {
                $query->where('customer_id', $user_id);
            })->first();
        } else {
            if ($user->phone == $request->phone_number) {
                $orderDetails = Order::where('id', $request['order_id'])->whereHas('details', function ($query) {
                    $query->where('customer_id', auth('customer')->id());
                })->first();
            }
            if ($request->from_order_details == 1) {
                $orderDetails = Order::where('id', $request['order_id'])->whereHas('details', function ($query) {
                    $query->where('customer_id', auth('customer')->id());
                })->first();
            }
        }
        if (isset($orderDetails) && !empty($orderDetails)) {
            return view('web-views.order-tracking', compact('orderDetails'));
        }
        else{
             Toastr::warning(translate('Invalid Order Id or Phone Number'));
             return redirect()->route('home');
        }

        // return redirect()->route('track-order.index')->with('Error', \App\CPU\translate('Invalid Order Id or Phone Number'));

    }

    public function track_last_order()
    {
        $orderDetails = OrderManager::track_order(Order::where('customer_id', auth('customer')->id())->latest()->first()->id);

        if ($orderDetails != null) {
            return view('web-views.order-tracking', compact('orderDetails'));
        } else {
            return redirect()->route('track-order.index')->with('Error', \App\CPU\translate('Invalid Order Id or Phone Number'));
        }
    }

    public function order_cancel($id)
    {
        $order = Order::where(['id' => $id])->first();
        if ($order['payment_method'] == 'cash_on_delivery' && $order['order_status'] == 'pending') {
            OrderManager::stock_update_on_order_status_change($order, 'canceled');
            Order::where(['id' => $id])->update([
                'order_status' => 'canceled'
            ]);
            Toastr::success(translate('successfully_canceled'));
            return back();
        }
        Toastr::error(translate('status_not_changable_now'));
        return back();
    }
    public function refund_request(Request $request, $id)
    {
        $order_details = OrderDetail::find($id);
        $user = auth('customer')->user();

        $wallet_status = Helpers::get_business_settings('wallet_status');
        $loyalty_point_status = Helpers::get_business_settings('loyalty_point_status');
        if ($loyalty_point_status == 1) {
            $loyalty_point = CustomerManager::count_loyalty_point_for_amount($id);

            if ($user->loyalty_point < $loyalty_point) {
                Toastr::warning(translate('you have not sufficient loyalty point to refund this order!!'));
                return back();
            }
        }

        return view('web-views.users-profile.refund-request', compact('order_details'));
    }
    public function store_refund(Request $request)
    {
        $request->validate([
            'order_details_id' => 'required',
            'amount' => 'required',
            'refund_reason' => 'required'

        ]);
        $order_details = OrderDetail::find($request->order_details_id);
        $user = auth('customer')->user();


        $loyalty_point_status = Helpers::get_business_settings('loyalty_point_status');
        if ($loyalty_point_status == 1) {
            $loyalty_point = CustomerManager::count_loyalty_point_for_amount($request->order_details_id);

            if ($user->loyalty_point < $loyalty_point) {
                Toastr::warning(translate('you have not sufficient loyalty point to refund this order!!'));
                return back();
            }
        }
        $refund_request = new RefundRequest;
        $refund_request->order_details_id = $request->order_details_id;
        $refund_request->customer_id = auth('customer')->id();
        $refund_request->status = 'pending';
        $refund_request->amount = $request->amount;
        $refund_request->product_id = $order_details->product_id;
        $refund_request->order_id = $order_details->order_id;
        $refund_request->refund_reason = $request->refund_reason;

        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $product_images[] = ImageManager::upload('refund/', 'png', $img);
            }
            $refund_request->images = json_encode($product_images);
        }
        $refund_request->save();

        $order_details->refund_request = 1;
        $order_details->save();

        Toastr::success(translate('refund_requested_successful!!'));
        return redirect()->route('account-order-details', ['id' => $order_details->order_id]);
    }

    public function generate_invoice($id)
    {
        $order = Order::with('seller')->with('shipping')->where('id', $id)->first();
        $data["email"] = $order->customer["email"];
        $data["order"] = $order;

        //return View('web-views.invoice_new', compact('order', $order));
        // $mpdf_view = \View::make('web-views.invoice')->with('order', $order);
        //$mpdf_view = \View::make('web-views.invoice_new')->with('order', $order);
        //Helpers::gen_mpdf($mpdf_view, 'order_invoice_', $order->id);
        $mpdf_view = view('web-views.invoice_new', compact('order'));
        Helpers::gen_mpdf($mpdf_view, 'Order_invoice_', $order->id);
    }
    public function refund_details($id)
    {
        $order_details = OrderDetail::find($id);

        $refund = RefundRequest::where('customer_id', auth('customer')->id())
            ->where('order_details_id', $order_details->id)->first();

        return view('web-views.users-profile.refund-details', compact('order_details', 'refund'));
    }
    public function shipping_address_update(Request $request)
    {

        $result = DB::table('shipping_addresses')
            ->where('id', $request->address_id)
            ->first();
        session()->put('address_id', $request->address_id);
        //dd($result);
        return response()->json(['response' => 'success', 'result' => $result]);
    }
    public function shipping_address_update_store(Request $request)
    {
        // dd($request->all());
        $data = [
            "contact_person_name" => $request->ship_contact_name,
            "address_type" => $request->ship_addressAs,
            "address" => $request->ship_address,
            "city" => $request->ship_city,
            "zip" => $request->ship_zip,
            "phone" => $request->ship_phone,
        ];
        DB::table('shipping_addresses')->where('id', $request->address_id)->update($data);
        session()->put('address_id', $request->address_id);
        return response()->json(['response' => 'success']);
    }
    public function billing_address_update(Request $request)
    {

        $result = DB::table('shipping_addresses')
            ->where('id', $request->address_id)
            ->first();
        session()->put('billing_address_id', $request->address_id);    
        return response()->json(['response' => 'success', 'result' => $result]);
    }
    public function order_wise_courier(Request $request)
    {
        // dd($request->all());
        $courier=DB::table("courier_service")->where("id",$request->courier_id)->first();
        $data=[
            "courier_id"=>$request->courier_id,
            "courier_name"=>$courier->name
        ];
        DB::table('carts')->where('customer_id',auth('customer')->id())->update($data);
        $discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
        $user_loyalty=DB::table('users')->where('id',auth('customer')->id())->select('loyalty_point')->first();
        $user_point_amt=0;
        if(!empty($user_loyalty->loyalty_point) && $user_loyalty->loyalty_point>0)
            {
                $user_point_amt=($user_loyalty->loyalty_point/2);
            }
        $amount = CartManager::cart_grand_total()-$discount-$user_point_amt;
        return response()->json(['response' => 'success','amount'=>$amount]);
    }
    public function billing_address_update_store(Request $request)
    {
        $data = [
            "contact_person_name" => $request->bill_contact_name,
            "address_type" => $request->bill_addressAs,
            "address" => $request->bill_address,
            "city" => $request->bill_city,
            "company_name" => $request->bill_company_name,
            "company_bin" => $request->bill_company_bin,
            "zip" => $request->bill_zip,
            "phone" => $request->bill_phone,
        ];
        DB::table('shipping_addresses')->where('id', $request->address_id)->update($data);
        session()->put('billing_address_id', $request->address_id);    
        return response()->json(['response' => 'success']);
    }
    public function submit_review(Request $request, $id)
    {

        $order_details = OrderDetail::find($id);
        return view('web-views.users-profile.submit-review', compact('order_details'));
    }
}