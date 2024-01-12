<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\RequestCallBack;
use App\Model\ShippingAddress;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Subscription;
use App\Model\BusinessSetting;
use Rap2hpoutre\FastExcel\FastExcel;

class CustomerController extends Controller
{
    public function customer_list(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $customers = User::with(['orders'])
                ->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('f_name', 'like', "%{$value}%")
                            ->orWhere('l_name', 'like', "%{$value}%")
                            ->orWhere('phone', 'like', "%{$value}%")
                            ->orWhere('email', 'like', "%{$value}%");
                    }
                });
            $query_param = ['search' => $request['search']];
        } else {
            $customers = User::with(['orders']);
        }
        $customers = $customers->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.customer.list', compact('customers', 'search'));
    }

    public function status_update(Request $request)
    {
        User::where(['id' => $request['id']])->update([
            'is_active' => $request['status']
        ]);

        DB::table('oauth_access_tokens')
            ->where('user_id', $request['id'])
            ->delete();

        return response()->json([], 200);
    }

    public function view(Request $request, $id)
    {

        $customer = User::find($id);
        if (isset($customer)) {
            $query_param = [];
            $search = $request['search'];
            $orders = Order::where(['customer_id' => $id]);
            $shippingAddresses = ShippingAddress::where('customer_id', $id)->get();
            if ($request->has('search')) {

                $orders = $orders->where('id', 'like', "%{$search}%");
                $query_param = ['search' => $request['search']];
            }
            $orders = $orders->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
            return view('admin-views.customer.customer-view', compact('customer', 'orders', 'search', 'shippingAddresses'));
        }
        Toastr::error('Customer not found!');
        return back();
    }

    public function delete($id)
    {
        $customer = User::find($id);
        $customer->delete();
        Toastr::success('Customer deleted successfully!');
        return back();
    }

    public function subscriber_list(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $subscription_list = Subscription::where('email', 'like', "%{$search}%");

            $query_param = ['search' => $request['search']];
        } else {
            $subscription_list = new Subscription;
        }
        $subscription_list = $subscription_list->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.customer.subscriber-list', compact('subscription_list', 'search'));
    }

    public function export_subscriber_list()
    {
        $items = Subscription::latest()->get();
        return (new FastExcel($items))->download('subscribers_list.xlsx');
    }

    public function customer_settings()
    {
        $data = BusinessSetting::where('type', 'like', 'wallet_%')->orWhere('type', 'like', 'loyalty_point_%')->get();
        $data = array_column($data->toArray(), 'value', 'type');

        return view('admin-views.customer.customer-settings', compact('data'));
    }
    public function request_call_back()
    {
        //$data['call_back']= RequestCallBack::orderBy('id','DESC')->paginate(25);
        $data['call_back'] = DB::table('request_call_back')
            ->join('products', 'products.id', 'request_call_back.product_id')
            ->select('request_call_back.*', 'products.slug', 'products.name as product_name')
            ->orderBy('id', 'DESC')->paginate(25);
        return view('admin-views.customer.request_list', $data);
    }

    public function update_request_call_back($id, $status)
    {
        $getRequest = RequestCallBack::where('id', $id)->first();
        if ($getRequest) {
            $getRequest->status = $status;
            $getRequest->save();
        }

        Toastr::success('Request callback status successfully updated!');
        return back();
    }
    public function customer_update_settings(Request $request)
    {
        if (env('APP_MODE') == 'demo') {
            Toastr::info(\App\CPU\translate('update_option_is_disable_for_demo'));
            return back();
        }

        $request->validate([
            'add_fund_bonus' => 'nullable|numeric|max:100|min:0',
            'loyalty_point_exchange_rate' => 'nullable|numeric',
        ]);
        BusinessSetting::updateOrInsert(['type' => 'wallet_status'], [
            'value' => $request['customer_wallet'] ?? 0
        ]);
        BusinessSetting::updateOrInsert(['type' => 'loyalty_point_status'], [
            'value' => $request['customer_loyalty_point'] ?? 0
        ]);
        BusinessSetting::updateOrInsert(['type' => 'wallet_add_refund'], [
            'value' => $request['refund_to_wallet'] ?? 0
        ]);
        BusinessSetting::updateOrInsert(['type' => 'loyalty_point_exchange_rate'], [
            'value' => $request['loyalty_point_exchange_rate'] ?? 0
        ]);
        BusinessSetting::updateOrInsert(['type' => 'loyalty_point_item_purchase_point'], [
            'value' => $request['item_purchase_point'] ?? 0
        ]);
        BusinessSetting::updateOrInsert(['type' => 'loyalty_point_minimum_point'], [
            'value' => $request['minimun_transfer_point'] ?? 0
        ]);

        Toastr::success(\App\CPU\translate('customer_settings_updated_successfully'));
        return back();
    }

    public function get_customers(Request $request)
    {
        $key = explode(' ', $request['q']);
        $data = User::where('id', '!=', 0)->where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('f_name', 'like', "%{$value}%")
                    ->orWhere('l_name', 'like', "%{$value}%")
                    ->orWhere('phone', 'like', "%{$value}%");
            }
        })
            ->limit(8)
            ->get([DB::raw('id, CONCAT(f_name, " ", l_name, " (", phone ,")") as text')]);
        if ($request->all) $data[] = (object)['id' => false, 'text' => trans('messages.all')];


        return response()->json($data);
    }


    /**
     * Export product list by excel
     * @param Request $request
     * @param $type
     */
    public function export(Request $request)
    {

        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $customers = User::with(['orders'])
                ->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('f_name', 'like', "%{$value}%")
                            ->orWhere('l_name', 'like', "%{$value}%")
                            ->orWhere('phone', 'like', "%{$value}%")
                            ->orWhere('email', 'like', "%{$value}%");
                    }
                });
        } else {
            $customers = User::with(['orders']);
        }
        $items = $customers->latest()->get();

        return (new FastExcel($items))->download('customer_list.xlsx');
    }

    // added for malamal
    public function store(Request $request)
    {
        try {
            $customer = new User();
            $customer->name = $request->name;
            $customer->f_name = $request->name;
            $customer->phone = $request->phone_number;
            $customer->email = $request->email;
            $customer->created_by = auth('admin')->user()->id;
            $customer->street_address = $request->address;
            $customer->designation = $request->designation;
            $customer->company_name = $request->company_name;
            $customer->save();
            Toastr::success('Customer added successfully');
            if (isset($request->quotation) && $request->quotation == 1) {
                 $address=[
                    "customer_id"=>$customer->id,
                    "contact_person_name"=>$request->name,
                    "address_type"=>'home',
                    "address"=>$request->address,
                    "phone"=>$request->phone_number,
                    "company_name"=>$request->company_name,
                    "is_billing"=>1
                ];
                DB::table('shipping_addresses')->insert($address);
                $quote_address = [
                    "quotation_id" => isset($request->quotation_no) ? $request->quotation_no : 0,
                    "cust_id" => $customer->id,
                    "f_name" => $request->name,
                    "designation" => $request->designation,
                    "address" => $request->address,
                    "email" => $request->email,
                    "phone" => $request->phone_number,
                    "company" => $request->company_name,
                ];
                DB::table('quotation_contact')->insert($quote_address);
                if(isset($request->edit_mode) && $request->edit_mode == 1){
                    //('admin.quotation.edit',[$p['id']])
                    return redirect()->route('admin.quotation.edit', [$request->quotation_no,'customer_id' => $customer->id,'subject_line'=> $request->subject_name]);
                } else {
                    session(['customer_id' => $customer->id]);
                    session(['subject_line' => $request->subject_name]);
                    return redirect()->route('admin.quotation.add-new');
                }

            }
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    public function get_quotation_customer(Request $request)
    {

        // $user_id = DB::table('users')->where('id', $request->customer_id)->first()->id;
        $quotation_contact = DB::table('quotation_contact')->where('cust_id', $request->customer_id)->first();
        
        if($quotation_contact)
        {
            $data=$quotation_contact;
        }
        else{
            $data=DB::table('users')
                    ->leftjoin('shipping_addresses','shipping_addresses.customer_id','users.id')
                    ->where('users.id', $request->customer_id)
                    ->select('shipping_addresses.company_name as company','users.phone','users.email')
                    ->first();
        }
        return response()->json(['response' => 'success', 'quotation_contact' => $data]);
    }
    public function quotation_customer_contact(Request $request)
    {
        try {
            if (isset($request->quotation_edit_id)) {
                $data = [
                    "email" => $request->quote_email,
                    "phone" => $request->quote_phone,
                    "company" => $request->quote_company,
                    "address" => $request->quote_company_address
                ];
                DB::table('quotation_contact')->where('id', $request->quotation_edit_id)->update($data);
            } else {
                if ($request->quotation_cust_id) {
                    $user = DB::table('users')->where('id', $request->quotation_cust_id)->first();
                    $quote_address = [
                        "quotation_id" => isset($request->quotation_no) ? $request->quotation_no : 0,
                        "cust_id" => $request->quotation_cust_id,
                        "f_name" => $user->f_name,
                        "address" => $request->quote_company_address,
                        "email" => $request->quote_email,
                        "phone" => $request->quote_phone,
                        "company" => $request->quote_company,
                    ];
                    DB::table('quotation_contact')->insert($quote_address);
                }
            }
            Toastr::success('Address update successfully');
            return redirect()->route('admin.quotation.add-new', ['customer_id' => $request->quotation_cust_id, 'subject_line' => '']);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    public function quotation_customer_contact_update(Request $request)
    {
        $quote_address = [
            "address" => $request->edit_quote_company_address,
            "email" => $request->edit_quote_email,
            "phone" => $request->edit_quote_phone,
            "company" => $request->edit_quote_company,
        ];
        DB::table('quotation_contact')->where('quotation_id',$request->edit_quotation_id)->update($quote_address);
        Toastr::success('Address update successfully');
        return redirect()->back();
    }
    //end
}