<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\CPU\OrderManager;
use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\AdminWallet;
use App\Model\BusinessSetting;
use App\Model\DeliveryMan;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\OrderTransaction;
use App\Model\Product;
use App\Model\Seller;
use App\User;
use App\Model\SellerWallet;
use App\Model\ShippingAddress;
use App\Model\ShippingMethod;
use App\Model\Shop;
use Barryvdh\DomPDF\Facade as PDF;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use function App\CPU\translate;
use App\CPU\CustomerManager;
use App\CPU\Convert;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Model\OrderStatusHistory;
use App\CPU\SMS_module;
use Auth;
class OrderController extends Controller
{
    public function list(Request $request, $status)
    {
        $search = $request['search'];
        $filter = $request['filter'];
        $payment_type = $request['payment_type'];
        $from = $request['from'];
        $to = $request['to'];
        $key = $request['search'] ? explode(' ', $request['search']) : '';

        Order::where(['checked' => 0])->update(['checked' => 1]);

        $orders = Order::with(['customer', 'seller.shop'])
            ->when($status != 'all', function ($q) use($status){
                $q->where(function ($query) use ($status) {
                    $query->orWhere('order_status', $status);
                });
            })
            ->when($filter,function($q) use($filter){
                $q->when($filter == 'all', function($q){
                    return $q;
                })
                    ->when($filter == 'POS', function ($q){
                        $q->whereHas('details', function ($q){
                            $q->where('order_type', 'POS');
                        });
                    })
                    ->when($filter == 'admin' || $filter == 'seller', function($q) use($filter){
                        $q->whereHas('details', function ($query) use ($filter){
                            $query->whereHas('product', function ($query) use ($filter){
                                $query->where('added_by', $filter);
                            });
                        });
                    });
            })
            ->when(!empty($payment_type) && $payment_type != 'all', function($dateQuery) use($payment_type) {
                $dateQuery->where('payment_status',$payment_type);
            })
            ->when($request->has('search') && $search!=null,function ($q) use ($key) {
                $q->where(function($qq) use ($key){
                    foreach ($key as $value) {
                        $qq->where('id', 'like', "%{$value}%")
                            ->orWhere('order_status', 'like', "%{$value}%")
                            ->orWhere('transaction_ref', 'like', "%{$value}%");
                    }});
            })->when(!empty($from) && !empty($to), function($dateQuery) use($from, $to) {
                $dateQuery->whereDate('created_at', '>=',$from)
                    ->whereDate('created_at', '<=',$to);
            })
            ->orderBy('id','desc')
                         ->paginate(Helpers::pagination_limit())
                         ->appends(['search'=>$request['search'],'filter'=>$request['filter'],'from'=>$request['from'],'to'=>$request['to'],'payment_type'=>$request['payment_type']]);

            $pending_query = Order::where(['order_status' => 'pending']);
            $pending_count = $this->common_query_status_count($pending_query, $status, $request);

            $confirmed_query = Order::where(['order_status' => 'confirmed']);
            $confirmed_count = $this->common_query_status_count($confirmed_query, $status, $request);

            $processing_query = Order::where(['order_status' => 'processing']);
            $processing_count = $this->common_query_status_count($processing_query, $status, $request);

            $out_for_delivery_query = Order::where(['order_status' => 'out_for_delivery']);
            $out_for_delivery_count = $this->common_query_status_count($out_for_delivery_query, $status, $request);

            $delivered_query = Order::where(['order_status' => 'delivered']);
            $delivered_count = $this->common_query_status_count($delivered_query, $status, $request);

            $canceled_query = Order::where(['order_status' => 'canceled']);
            $canceled_count = $this->common_query_status_count($canceled_query, $status, $request);

            $returned_query = Order::where(['order_status' => 'returned']);
            $returned_count = $this->common_query_status_count($returned_query, $status, $request);

            $failed_query = Order::where(['order_status' => 'failed']);
            $failed_count = $this->common_query_status_count($failed_query, $status, $request);

        return view(
                'admin-views.order.list',
                compact(
                    'orders',
                    'search',
                    'from', 'to', 'status',
                    'filter',
                    'payment_type',
                    'pending_count',
                    'confirmed_count',
                    'processing_count',
                    'out_for_delivery_count',
                    'delivered_count',
                    'returned_count',
                    'failed_count',
                    'canceled_count'
                )
            );
    }
  public function delete_edit_order($id)
    {
        $order=DB::table('order_details')->where('id',$id)->select('order_id','price','tax')->first();
        DB::table('order_details')->where('id',$id)->delete();
        $order_info=DB::table('orders')->where('id',$order->order_id)->select('order_amount')->first();
        $total_amount=$order->price+$order->tax;
        $calulate_amount=($order_info->order_amount-$total_amount);
        DB::table('orders')->where('id',$order->order_id)->update(['order_amount'=>$calulate_amount]);
        Toastr::success('Succesfully Delete');
        return redirect()->route('admin.orders.edit_order',[$order->order_id]);
    }
    public function challan_no_add(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->challan_no = $request->challan_no;
        $order->save();

        Toastr::success(\App\CPU\translate('challan_no_updated_successfully!'));
        return back();
    }
    public function common_query_status_count($query, $status, $request){
        $search = $request['search'];
        $filter = $request['filter'];
        $from = $request['from'];
        $to = $request['to'];
        $key = $request['search'] ? explode(' ', $request['search']) : '';

            return $query->when($status != 'all', function ($q) use($status){
                $q->where(function ($query) use ($status) {
                    $query->orWhere('order_status', $status);
                });
            })
            ->when($filter,function($q) use($filter) {
                $q->when($filter == 'all', function ($q) {
                    return $q;
                })
                ->when($filter == 'POS', function ($q){
                    $q->whereHas('details', function ($q){
                        $q->where('order_type', 'POS');
                    });
                })
                ->when($filter == 'admin' || $filter == 'seller', function($q) use($filter){
                    $q->whereHas('details', function ($query) use ($filter){
                        $query->whereHas('product', function ($query) use ($filter){
                            $query->where('added_by', $filter);
                        });
                    });
                });
            })
            ->when($request->has('search') && $search!=null,function ($q) use ($key) {
                $q->where(function($qq) use ($key){
                    foreach ($key as $value) {
                        $qq->where('id', 'like', "%{$value}%")
                            ->orWhere('order_status', 'like', "%{$value}%")
                            ->orWhere('transaction_ref', 'like', "%{$value}%");
                    }});
            })->when(!empty($from) && !empty($to), function($dateQuery) use($from, $to) {
                $dateQuery->whereDate('created_at', '>=',$from)
                    ->whereDate('created_at', '<=',$to);
            })->count();
    }

    public function details($id)
    {
        $company_name =BusinessSetting::where('type', 'company_name')->first()->value;
        $company_web_logo =BusinessSetting::where('type', 'company_web_logo')->first()->value;

        $order = Order::with('details.product', 'shipping', 'seller.shop')->where(['id' => $id])->first();


        $physical_product = false;
        foreach($order->details as $product){
            if(isset($product->product) && $product->product->product_type == 'physical'){
                $physical_product = true;
            }
        }

        $linked_orders = Order::where(['order_group_id' => $order['order_group_id']])
            ->whereNotIn('order_group_id', ['def-order-group'])
            ->whereNotIn('id', [$order['id']])
            ->get();

        $total_delivered = Order::where(['seller_id' => $order->seller_id, 'order_status' => 'delivered', 'order_type' => 'default_type'])->count();

        $shipping_method = Helpers::get_business_settings('shipping_method');
        $delivery_men = DeliveryMan::where('is_active', 1)->when($order->seller_is == 'admin', function ($query) {
            $query->where(['seller_id' => 0]);
        })->when($order->seller_is == 'seller' && $shipping_method == 'sellerwise_shipping', function ($query) use ($order) {
            $query->where(['seller_id' => $order['seller_id']]);
        })->when($order->seller_is == 'seller' && $shipping_method == 'inhouse_shipping', function ($query) use ($order) {
            $query->where(['seller_id' => 0]);
        })->get();

        $shipping_address = ShippingAddress::find($order->shipping_address);
        return view('admin-views.order.order-details', compact('shipping_address','order', 'linked_orders', 'delivery_men', 'total_delivered', 'company_name', 'company_web_logo', 'physical_product'));
        if($order->order_type == 'default_type')
        {
            return view('admin-views.order.order-details', compact('shipping_address','order', 'linked_orders', 'delivery_men', 'total_delivered', 'company_name', 'company_web_logo', 'physical_product'));
        }else{
            return view('admin-views.pos.order.order-details', compact('order', 'company_name', 'company_web_logo'));
        }

    }

    public function add_delivery_man($order_id, $delivery_man_id)
    {
        if ($delivery_man_id == 0) {
            return response()->json([], 401);
        }
        $order = Order::find($order_id);
        /*if($order->order_status == 'delivered' || $order->order_status == 'returned' || $order->order_status == 'failed' || $order->order_status == 'canceled' || $order->order_status == 'scheduled') {
            return response()->json(['status' => false], 200);
        }*/
        $order->delivery_man_id = $delivery_man_id;
        $order->delivery_type = 'self_delivery';
        $order->delivery_service_name = null;
        $order->third_party_delivery_tracking_id = null;
        $order->save();

        $fcm_token = $order->delivery_man->fcm_token;
        $value = Helpers::order_status_update_message('del_assign') . " ID: " . $order['id'];
        try {
            if ($value != null) {
                $data = [
                    'title' => translate('order'),
                    'description' => $value,
                    'order_id' => $order['id'],
                    'image' => '',
                ];
                Helpers::send_push_notif_to_device($fcm_token, $data);
            }
        } catch (\Exception $e) {
            Toastr::warning(\App\CPU\translate('Push notification failed for DeliveryMan!'));
        }

        return response()->json(['status' => true], 200);
    }
    public function sms_templates()
    {
        return view('admin-views.order.sms_template');
    }
    public function sms_templates_update(Request $request)
    {
        $status=0;
        if($request->status==1)
        {
            $status=1;
        }
        $data=[
            "sms_body"=>$request->body,
            "status"=>$status,
        ];
        DB::table('sms_templates')->where('id',$request->temp_id)->update($data);
        Toastr::success('Update successfully!');
        return view('admin-views.order.sms_template');
    }
    public function status(Request $request)
    {
        $order = Order::find($request->id);
        $user_info=DB::table('users')->where('id',$order->customer_id)->select('phone')->first();
        $phone_no = "88" . $user_info->phone;
        if(!isset($order->customer))
        {
            return response()->json(['customer_status'=>0],200);
        }

        $wallet_status = Helpers::get_business_settings('wallet_status');
        $loyalty_point_status = Helpers::get_business_settings('loyalty_point_status');

        // if($request->order_status=='delivered' && $order->payment_status !='paid'){

        //     return response()->json(['payment_status'=>0],200);
        // }
        if($request->order_status == 'delivered')
        {
            $loyalty_point=0;
            $order_details=DB::table('order_details')
                                ->join('products','products.id','order_details.product_id')
                                ->where('order_details.order_id',$request->id)
                                ->select('products.loyalty_point','order_details.qty')
                                ->get();
              foreach($order_details as $data)
              {
                if ($data->loyalty_point > 0) {
                    $loyalty_point += ($data->loyalty_point * $data->qty);
                }
              } 
            #user table update
            DB::table('users')->where('id', $order->customer_id)->update(["loyalty_point" => $loyalty_point]);              
            #loyalty data insert
            $loyalty_data = [
                "user_id" => $order->customer_id,
                "transaction_id" => $request->id,
                "credit" => $loyalty_point,
                "balance" => $loyalty_point,
                "transaction_type"=>$request->id,
                "created_at" => NOW(),
            ];
            DB::table('loyalty_point_transactions')->insert($loyalty_data);
        }
        $fcm_token = $order->customer->cm_firebase_token;
        $value = Helpers::order_status_update_message($request->order_status);
        try {
            if ($value) {
                $data = [
                    'title' => translate('Order'),
                    'description' => $value,
                    'order_id' => $order['id'],
                    'image' => '',
                ];
                Helpers::send_push_notif_to_device($fcm_token, $data);
            }
        } catch (\Exception $e) {
        }


        try {
            $fcm_token_delivery_man = $order->delivery_man->fcm_token;
            if ($value != null) {
                $data = [
                    'title' => translate('order'),
                    'description' => $value,
                    'order_id' => $order['id'],
                    'image' => '',
                ];
                Helpers::send_push_notif_to_device($fcm_token_delivery_man, $data);
            }
        } catch (\Exception $e) {
        }

        $order->order_status = $request->order_status;
        OrderManager::stock_update_on_order_status_change($order, $request->order_status);
        $order->save();

        if($loyalty_point_status == 1)
        {
            if($request->order_status == 'delivered' && $order->payment_status =='paid'){
                CustomerManager::create_loyalty_point_transaction($order->customer_id, $order->id, Convert::default($order->order_amount-$order->shipping_cost), 'order_place');
            }
        }
        //zahed
            $delivery_history = new OrderStatusHistory();
            $delivery_history->order_id = $request->id;
            $delivery_history->user_id = 0;
            $delivery_history->user_type = 'admin';
            $delivery_history->status = $request->order_status;
            $delivery_history->cause = '';

            $delivery_history->save();
        //end zahed


        $transaction = OrderTransaction::where(['order_id' => $order['id']])->first();
        if (isset($transaction) && $transaction['status'] == 'disburse') {
            return response()->json($request->order_status);
        }

        if ($request->order_status == 'delivered' && $order['seller_id'] != null) {
            OrderManager::wallet_manage_on_order_status_change($order, 'admin');
            OrderDetail::where('order_id', $order->id)->update(
                ['delivery_status'=>'delivered']
            );
        }
        //sms send
        SMS_module::order_send($phone_no,$request->id, $request->order_status);
        return response()->json($request->order_status);
    }

    public function payment_status(Request $request)
    {
        if ($request->ajax()) {
            $order = Order::find($request->id);

            if(!isset($order->customer))
            {
                return response()->json(['customer_status'=>0],200);
            }

            $order = Order::find($request->id);
            $order->payment_status = $request->payment_status;
            $order->save();
            $data = $request->payment_status;
            return response()->json($data);
        }
    }

    public function generate_invoice($id)
    {
        $company_phone =BusinessSetting::where('type', 'company_phone')->first()->value;
        $company_email =BusinessSetting::where('type', 'company_email')->first()->value;
        $company_name =BusinessSetting::where('type', 'company_name')->first()->value;
        $company_web_logo =BusinessSetting::where('type', 'company_web_logo')->first()->value;

        $order = Order::with('seller')->with('shipping')->with('details')->where('id', $id)->first();
        $seller = Seller::find($order->details->first()->seller_id);
        $data["email"] = $order->customer !=null?$order->customer["email"]:\App\CPU\translate('email_not_found');
        $data["client_name"] = $order->customer !=null? $order->customer["f_name"] . ' ' . $order->customer["l_name"]:\App\CPU\translate('customer_not_found');
        $data["order"] = $order;
//         return view('admin-views.order.invoice', compact('order', 'seller', 'company_phone', 'company_name', 'company_email', 'company_web_logo'));//Remove this line before production
        $mpdf_view = View::make('admin-views.order.invoice',
            compact('order', 'seller', 'company_phone', 'company_name', 'company_email', 'company_web_logo')
        );
        Helpers::gen_mpdf($mpdf_view, 'order_invoice_', $order->id);
    }
    public function generate_mushok($id)
    {
        $company_phone =BusinessSetting::where('type', 'company_phone')->first()->value;
        $company_email =BusinessSetting::where('type', 'company_email')->first()->value;
        $company_name =BusinessSetting::where('type', 'company_name')->first()->value;
        $company_web_logo =BusinessSetting::where('type', 'company_web_logo')->first()->value;

        $order = Order::with('seller')->with('shipping')->with('details')->where('id', $id)->first();
        $seller = Seller::find($order->details->first()->seller_id);
        $data["email"] = $order->customer !=null?$order->customer["email"]:\App\CPU\translate('email_not_found');
        $data["client_name"] = $order->customer !=null? $order->customer["f_name"] . ' ' . $order->customer["l_name"]:\App\CPU\translate('customer_not_found');
        $data["order"] = $order;
        $mpdf_view = View::make('admin-views.order.mushok',compact('order', 'seller', 'company_phone', 'company_name', 'company_email', 'company_web_logo'));
        Helpers::gen_mpdf($mpdf_view, 'mushok_', $id);
         //return view('admin-views.order.mushok',compact('id'));
    }
    public function generate_chalan($id)
    {
        $company_phone =BusinessSetting::where('type', 'company_phone')->first()->value;
        $company_email =BusinessSetting::where('type', 'company_email')->first()->value;
        $company_name =BusinessSetting::where('type', 'company_name')->first()->value;
        $company_web_logo =BusinessSetting::where('type', 'company_web_logo')->first()->value;

        $order = Order::with('seller')->with('shipping')->with('details')->where('id', $id)->first();
        $seller = Seller::find($order->details->first()->seller_id);
        $data["email"] = $order->customer !=null?$order->customer["email"]:\App\CPU\translate('email_not_found');
        $data["client_name"] = $order->customer !=null? $order->customer["f_name"] . ' ' . $order->customer["l_name"]:\App\CPU\translate('customer_not_found');
        $data["order"] = $order;
        $mpdf_view = View::make('admin-views.order.chalan',compact('order', 'seller', 'company_phone', 'company_name', 'company_email', 'company_web_logo'));
        Helpers::gen_mpdf($mpdf_view, 'chalan_', $id);
        //return view('admin-views.order.chalan',compact('id','order',  'seller', 'company_phone', 'company_name', 'company_email', 'company_web_logo'));
    }
  
    public function edit_order($id)
    {
        $company_name =BusinessSetting::where('type', 'company_name')->first()->value;
        $company_web_logo =BusinessSetting::where('type', 'company_web_logo')->first()->value;

        $order = Order::with('details.product', 'shipping', 'seller.shop')->where(['id' => $id])->first();


        $physical_product = false;
        foreach($order->details as $product){
            if(isset($product->product) && $product->product->product_type == 'physical'){
                $physical_product = true;
            }
        }

        $linked_orders = Order::where(['order_group_id' => $order['order_group_id']])
            ->whereNotIn('order_group_id', ['def-order-group'])
            ->whereNotIn('id', [$order['id']])
            ->get();

        $total_delivered = Order::where(['seller_id' => $order->seller_id, 'order_status' => 'delivered', 'order_type' => 'default_type'])->count();

        $shipping_method = Helpers::get_business_settings('shipping_method');
        $delivery_men = DeliveryMan::where('is_active', 1)->when($order->seller_is == 'admin', function ($query) {
            $query->where(['seller_id' => 0]);
        })->when($order->seller_is == 'seller' && $shipping_method == 'sellerwise_shipping', function ($query) use ($order) {
            $query->where(['seller_id' => $order['seller_id']]);
        })->when($order->seller_is == 'seller' && $shipping_method == 'inhouse_shipping', function ($query) use ($order) {
            $query->where(['seller_id' => 0]);
        })->get();

        $shipping_address = ShippingAddress::find($order->shipping_address);
        $billing_address = ShippingAddress::find($order->billing_address);
        $product_list=DB::table('products')->select('id','name','unit_price')->get();
        return view('admin-views.order.order_edit', compact('shipping_address','billing_address','order', 'linked_orders','product_list' ,'delivery_men', 'total_delivered', 'company_name', 'company_web_logo', 'physical_product'));
        if($order->order_type == 'default_type')
        {
            return view('admin-views.order.order_edit', compact('shipping_address','billing_address','order','product_list' , 'linked_orders', 'delivery_men', 'total_delivered', 'company_name', 'company_web_logo', 'physical_product'));
        }else{
            return view('admin-views.order.order_edit', compact('order', 'company_name','product_list' , 'company_web_logo'));
        }
    }
    public function order_update(Request $request)
    {
        //dd($request->all());
       
        $discount=0;
        $tax=0;
        $total=0;
        foreach ($request->product_id as $key => $v)
        {   
            $product = DB::table('products')->where('id', $request->product_id[$key])->first();
            $variation_attr = $product->variation;
            $variation_data = json_decode($variation_attr);
            $price = 0;
            foreach ($variation_data as $row) {
                if ($row->type == $request->variant[$key]) {
                    $price = $row->price;
                }
            }    
            $data = [ 
                 'product_id'  => $request->product_id[$key],
                 'qty' => $request->product_quantity[$key],
                 'price' => ($price>0)?$price:$request->price[$key],
                 'tax'  => $request->tax[$key],
                 'discount'  => $request->discount[$key],
                 'variant'=>isset($request->variant[$key])?$request->variant[$key]:'',
                 'updated_by' =>auth('admin')->user()->id
                ];
            
            $discount += $request->discount[$key];
            $tax += $request->tax[$key];
            if($price>0)
            {
                $total += ($price+$request->tax[$key])*$request->product_quantity[$key]+$request->shipping_cost-$discount;
            }
            else{
                $total += ($request->price[$key]+$request->tax[$key])*$request->product_quantity[$key]+$request->shipping_cost-$discount;
            }
            DB::table('order_details')->where('id',$request->details_id[$key])->update($data);
           
        }
        #shipping address
        $new_data_shipping="";
        if(!empty($request->shipping_json))
        {
            $data_shipping = json_decode($request->shipping_json, true);
            $data_shipping['contact_person_name']=$request->shipping_person;
            $data_shipping['phone']=$request->shipping_phone;
            $data_shipping['address']=$request->shipping_address;
            $data_shipping['city']=$request->shipping_city;
            $data_shipping['zip']=$request->shipping_zip;
            $new_data_shipping = json_encode($data_shipping);
        }
         #billing address
        $new_data_billing=null;
        if(!empty($request->billing_json))
        {
            $data_billing = json_decode($request->billing_json, true);
            $data_billing['contact_person_name']=$request->billing_person;
 	    $data_billing['company_name']=$request->billing_company;
            $data_billing['company_bin']=$request->billing_company_bin;
            $data_billing['phone']=$request->billing_phone;
            $data_billing['address']=$request->billing_address;
            $data_billing['city']=$request->billing_city;
            $data_billing['zip']=$request->billing_zip;
            $new_data_billing = json_encode($data_billing);
        }
        $order_table=[
            'order_amount'=>$total,
            'shipping_cost'=>$request->shipping_cost,
            // 'shipping_address' => $request->shipping_method_id,
            'shipping_address_data' =>$new_data_shipping,
            // 'billing_address' => $request->billing_method_id,
            'billing_address_data' => $new_data_billing
        ];
        DB::table('orders')->where('id',$request->order_id)->update($order_table); 
        Toastr::success('Succesfully Update');
        return redirect()->route('admin.orders.list',['all']);
    }
    public function new_order_store(Request $request)
    {
       
        $product_details=DB::table('products')->where('id',$request->new_product_id)->first();
        $order_data=DB::table('orders')->where('id',$request->order_id)->first();
        $product = Product::where(['id' => $request->new_product_id])->first();
            $order_details = [
                'order_id' => $request->order_id,
                'product_id' => $request->new_product_id,
                'seller_id' => 1,
                'product_details' => $product,
                'qty' => $request->quantity,
                'price' => $product_details->unit_price,
                'tax' => $product_details->tax * $request->quantity,
                'discount' => $request->discount * $request->quantity,
                'discount_type' => 'discount_on_product',
                'variant' => '',
                'variation' => '',
                'delivery_status' => 'pending',
                'shipping_method_id' => null,
                'payment_status' => 'unpaid',
                'created_at' => now(),
                'updated_at' => now(),
                'updated_by' =>auth('admin')->user()->id
            ];
            $amount=($product_details->unit_price*$request->quantity);
            if(!empty($request->quantity) && !empty($product_details->unit_price))
            {
                $order=[
                    "order_amount"=>($order_data->order_amount+$amount),
                    "shipping_cost"=>($order_data->shipping_cost+($product_details->shipping_cost*$request->quantity))
                ];
                Product::where(['id' =>$request->new_product_id])->update([
                    'current_stock' => $product['current_stock'] - $request->quantity
                ]);
                DB::table('orders')->where('id',$request->order_id)->update($order);
                DB::table('order_details')->insert($order_details);
            }   
            Toastr::success('Succesfully added');
            return response()->json(['response' => 'success']);
    }
    /*
     *  Digital file upload after sell
     */
    public function digital_file_upload_after_sell(Request $request)
    {
        $request->validate([
            'digital_file_after_sell'    => 'required|mimes:jpg,jpeg,png,gif,zip,pdf'
        ], [
            'digital_file_after_sell.required' => 'Digital file upload after sell is required',
            'digital_file_after_sell.mimes' => 'Digital file upload after sell upload must be a file of type: pdf, zip, jpg, jpeg, png, gif.',
        ]);

        $order_details = OrderDetail::find($request->order_id);
        $order_details->digital_file_after_sell = ImageManager::update('product/digital-product/', $order_details->digital_file_after_sell, $request->digital_file_after_sell->getClientOriginalExtension(), $request->file('digital_file_after_sell'));

        if($order_details->save()){
            Toastr::success('Digital file upload successfully!');
        }else{
            Toastr::error('Digital file upload failed!');
        }
        return back();
    }

    public function inhouse_order_filter()
    {
        if (session()->has('show_inhouse_orders') && session('show_inhouse_orders') == 1) {
            session()->put('show_inhouse_orders', 0);
        } else {
            session()->put('show_inhouse_orders', 1);
        }
        return back();
    }
    public function update_deliver_info(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->delivery_type = 'third_party_delivery';
        $order->delivery_service_name = $request->delivery_service_name;
        $order->third_party_delivery_tracking_id = $request->third_party_delivery_tracking_id;
        $order->delivery_man_id = null;
        $order->save();

        Toastr::success(\App\CPU\translate('updated_successfully!'));
        return back();
    }

    public function bulk_export_data(Request $request, $status)
    {
        $search = $request['search'];
        $filter = $request['filter'];
        $from = $request['from'];
        $to = $request['to'];

        if ($status != 'all') {
            $orders = Order::when($filter,function($q) use($filter){
                $q->when($filter == 'all', function($q){
                    return $q;
                })
                    ->when($filter == 'POS', function ($q){
                        $q->whereHas('details', function ($q){
                            $q->where('order_type', 'POS');
                        });
                    })
                    ->when($filter == 'admin' || $filter == 'seller', function($q) use($filter){
                        $q->whereHas('details', function ($query) use ($filter){
                            $query->whereHas('product', function ($query) use ($filter){
                                $query->where('added_by', $filter);
                            });
                        });
                    });
            })
                ->with(['customer'])->where(function($query) use ($status){
                    $query->orWhere('order_status',$status)
                        ->orWhere('payment_status',$status);
                });
        } else {
            $orders = Order::with(['customer'])
                ->when($filter,function($q) use($filter){
                    $q->when($filter == 'all', function($q){
                        return $q;
                    })
                        ->when($filter == 'POS', function ($q){
                            $q->whereHas('details', function ($q){
                                $q->where('order_type', 'POS');
                            });
                        })
                        ->when(($filter == 'admin' || $filter == 'seller'), function($q) use($filter){
                            $q->whereHas('details', function ($query) use ($filter){
                                $query->whereHas('product', function ($query) use ($filter){
                                    $query->where('added_by', $filter);
                                });
                            });
                        });
                });
        }

        $key = $request['search'] ? explode(' ', $request['search']) : '';
        $orders = $orders->when($request->has('search') && $search!=null,function ($q) use ($key) {
            $q->where(function($qq) use ($key){
                foreach ($key as $value) {
                    $qq->where('id', 'like', "%{$value}%")
                        ->orWhere('order_status', 'like', "%{$value}%")
                        ->orWhere('transaction_ref', 'like', "%{$value}%");
                }});
        })->when(!empty($from) && !empty($to), function($dateQuery) use($from, $to) {
            $dateQuery->whereDate('created_at', '>=',$from)
                ->whereDate('created_at', '<=',$to);
        })->orderBy('id', 'DESC')->get();

        if ($orders->count()==0) {
            Toastr::warning(\App\CPU\translate('Data is Not available!!!'));
            return back();
        }

        $storage = array();

        foreach ($orders as $item) {

            $order_amount = $item->order_amount;
            $discount_amount = $item->discount_amount;
            $shipping_cost = $item->shipping_cost;
            $extra_discount = $item->extra_discount;

            $storage[] = [
                'order_id'=>$item->id,
                'Customer Id' => $item->customer_id,
                'Customer Name'=> isset($item->customer) ? $item->customer->f_name. ' '.$item->customer->l_name:'not found',
                'Order Group Id' => $item->order_group_id,
                'Order Status' => $item->order_status,
                'Order Amount' => Helpers::currency_converter($order_amount),
                'Order Type' => $item->order_type,
                'Coupon Code' => $item->coupon_code,
                'Discount Amount' => Helpers::currency_converter($discount_amount),
                'Discount Type' => $item->discount_type,
                'Extra Discount' => Helpers::currency_converter($extra_discount),
                'Extra Discount Type' => $item->extra_discount_type,
                'Payment Status' => $item->payment_status,
                'Payment Method' => $item->payment_method,
                'Transaction_ref' => $item->transaction_ref,
                'Verification Code' => $item->verification_code,
                'Billing Address' => isset($item->billingAddress)? $item->billingAddress->address:'not found',
                'Billing Address Data' => $item->billing_address_data,
                'Shipping Type' => $item->shipping_type,
                'Shipping Address' => isset($item->shippingAddress)? $item->shippingAddress->address:'not found',
                'Shipping Method Id' => $item->shipping_method_id,
                'Shipping Method Name' => isset($item->shipping)? $item->shipping->title:'not found',
                'Shipping Cost' => Helpers::currency_converter($shipping_cost),
                'Seller Id' => $item->seller_id,
                'Seller Name' => isset($item->seller)? $item->seller->f_name. ' '.$item->seller->l_name:'not found',
                'Seller Email'  => isset($item->seller)? $item->seller->email:'not found',
                'Seller Phone'  => isset($item->seller)? $item->seller->phone:'not found',
                'Seller Is' => $item->seller_is,
                'Shipping Address Data' => $item->shipping_address_data,
                'Delivery Type' => $item->delivery_type,
                'Delivery Man Id' => $item->delivery_man_id,
                'Delivery Service Name' => $item->delivery_service_name,
                'Third Party Delivery Tracking Id' => $item->third_party_delivery_tracking_id,
                'Checked' => $item->checked,

            ];
        }

        return (new FastExcel($storage))->download('Order_All_details.xlsx');
    }
}