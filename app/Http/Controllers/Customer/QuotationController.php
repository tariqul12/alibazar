<?php

namespace App\Http\Controllers\Customer;

use App\CPU\CartManager;
use App\CPU\Helpers;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Brian2694\Toastr\Facades\Toastr;
use App\Model\Quotation;
use DB;
use Mail;
use Barryvdh\DomPDF\PDF;
use URL;

class QuotationController extends Controller
{
    public function show_quotation()
    {
        return view('customer-view.quotation.index');
    }
   public function quote_store(Request $request)
    {
        #assign Data
        $total_qty = 0;
        $total_discount = 0;
        $total_tax = 0;
        $total_vat=0;
        $amt_total = 0;
        $shipping_cost = 0;
        #if customer is login
        if (auth('customer')->id()) {
            $quote_cart = DB::table('quote_cart')
                ->where('customer_id', auth('customer')->id())
                ->get();

            foreach ($quote_cart as $row) {
                $total_qty += $row->total_qty;
                // $total_tax += $row->total_tax;
                $total_discount += $row->total_discount;
                $amt_total += $row->total_price;
            }
            #quotation vat calculation
            if($request->vat_app==1){
                $quote_vat=Helpers::get_business_settings('quotation_vat');
                $total_vat=$amt_total*($quote_vat/100);
            }
            $data = [
                'reference_no' => 'QR-' . date("Ymd") . '-' . date("his"),
                'user_id' => 0,
                'customer_id' => auth('customer')->id(),
                'total_item' => 0,
                'total_qty' => $total_qty,
                'total_discount' => $total_discount,
                'total_tax' => $total_tax,
                'total_vat' => $total_vat,
                'order_tax_rate' => 0,
                'order_tax' => 0,
                'total_price' => $amt_total-$total_discount,
                'order_discount' => 0,
                'shipping_cost' => $shipping_cost,
                'grand_total' => ($amt_total + $total_vat - $total_discount + $shipping_cost),
                'quotation_status' => 2,
                'created_at' =>  date('Y-m-d H:i:s'),
                'is_vat'=>$request->vat_app,
            ];
            $insert_id = DB::table('quotations')->insertGetId($data);

            #generate pdf and send mail
            $this->quotationPdfGenereteAndMailsend($insert_id, $quote_cart, $request);

            DB::table('quote_cart')
                ->where('customer_id', auth('customer')->id())
                ->delete();
            Toastr::success('Successfully Added.');
            return redirect()->route('customer.quotation_success');
        } else {
            #if walking customer
            $quote_cart = DB::table('quote_cart')
                ->where('reference_no', session('quote_data'))
                ->get();

            foreach ($quote_cart as $row) {
                $total_qty += $row->total_qty;
               // $total_tax += $row->total_tax;
                $total_discount += $row->total_discount;
                $amt_total += $row->total_price;
            }
             #quotation vat calculation
            if($request->vat_app==1){
                $quote_vat=Helpers::get_business_settings('quotation_vat');
                $total_vat=$amt_total*($quote_vat/100);
            }
            $data = [
                'reference_no' => session('quote_data'),
                'user_id' => 0,
                'customer_id' => 0,
                'total_item' => 0,
                'total_qty' => $total_qty,
                'total_discount' => $total_discount,
                'total_tax' => $total_tax,
                'total_vat' => $total_vat,
                'order_tax_rate' => 0,
                'order_tax' => 0,
                'total_price' => $amt_total-$total_discount,
                'order_discount' => 0,
                'shipping_cost' => $shipping_cost,
                'grand_total' => ($amt_total + $total_vat - $total_discount + $shipping_cost),
                'quotation_status' => 2,
                'created_at' =>  date('Y-m-d H:i:s'),
                'is_vat'=>$request->vat_app,
            ];
            $insert_id = DB::table('quotations')->insertGetId($data);

            #generate pdf and send mail
            $this->quotationPdfGenereteAndMailsend($insert_id, $quote_cart, $request);

            DB::table('quote_cart')
                ->where('reference_no', session('quote_data'))
                ->delete();
            session()->forget('quote_data');
            Toastr::success('Successfully Added.');
            return redirect()->route('customer.quotation_success');
        }
    }
    public function quotationPdfGenereteAndMailsend($insert_id, $quote_cart, $request)
    {
        $quotation_contact = [
            "quotation_id" => $insert_id,
            "f_name" => $request->f_name,
            "l_name" => $request->l_name,
            "email" => $request->email,
            "phone" => $request->phone,
            "company" => $request->company,
            "address" => $request->address,
            "send_mail" => $request->send_mail,
            "comments" => $request->comments,
            "created_at" => NOW(),
            'is_vat'=>$request->vat_app,
        ];
        DB::table('quotation_contact')->insert($quotation_contact);
        $quote_vat=Helpers::get_business_settings('quotation_vat');
        foreach ($quote_cart as $row) {
            $per_vat=0;
            $per_unit_price=(($row->total_price-$row->total_discount) / $row->total_qty);
            $per_vat=$per_unit_price*($quote_vat/100);
            $prod_data = [
                "quotation_id" => $insert_id,
                "product_id" => $row->product_id,
                "qty" => $row->total_qty,
                "net_unit_price" => ($row->total_price / $row->total_qty),
                "discount" => $row->total_discount,
                "vat_rate"=>$quote_vat,
                "single_unit_vat"=>round($per_vat,2),
                "single_unit_price_vat"=>round(($per_unit_price+$per_vat),2),
                "tax" => $row->total_tax,
                "total" => $row->total_price,
                "created_at" => NOW(),
            ];
            DB::table('product_quotation')->insert($prod_data);
        }

        $quotation = DB::table('quotations')
            ->join('product_quotation', 'product_quotation.quotation_id', 'quotations.id')
            ->join('products', 'products.id', 'product_quotation.product_id')
            ->where('quotations.id', $insert_id)
            ->select(
                'products.name as pro_name',
                'products.thumbnail',
                'products.features as details',
                'products.unit',
                'product_quotation.qty',
                'products.unit_price',
                'products.discount',
                 'products.discount_type',
                'product_quotation.tax',
                'product_quotation.vat_rate',
                'product_quotation.single_unit_vat',
                'product_quotation.single_unit_price_vat',
                'product_quotation.net_unit_price',
                'product_quotation.total',
                'quotations.shipping_cost',
                'quotations.total_vat',
                'quotations.is_vat'
            )
            ->get();

        $data["email"] = $request->email;
        if ($request->send_mail == '') $data["cc_email"] = $request->email;
        else $data["cc_email"] = $request->send_mail;
        $data["name"] = $request->f_name;
        $data['product_data'] = $quotation;
        $data['quotation_id'] = $insert_id;
        $data["title"] = "Quotation";

        if (auth('customer')->id()) {
            $quotation = Quotation::where('id', $insert_id)->firstOrFail();
            $data_format['quotation'] = $quotation;
            $mpdf_view = view('web-views.users-profile.download_new', $data_format);
            Helpers::quotation_mpdf($mpdf_view, 'Quotation_', $insert_id);
        } else {
            $data_format['quotation'] = Quotation::where('id', $insert_id)->firstOrFail();
            $data_format['quotation_details'] = $quotation;
            $data_format['contact_info'] = DB::table('quotation_contact')->where('quotation_id', $insert_id)->first();
            $mpdf_view = view('email.offline_quotation', $data_format);
            Helpers::quotation_mpdf($mpdf_view, 'Quotation_', $insert_id);
        }

        $files = [
            URL::to('/') . '/storage/app/public/quotation/Quotation_' . $insert_id . '.pdf',
        ];
        Mail::send('email.mail_body', $data, function ($message) use ($data, $files) {
            $message->to($data["email"], $data["email"])
                ->cc($data["cc_email"])
                ->subject($data["title"]);
            foreach ($files as $file) {
                $message->attach($file);
            }
        });
        session()->forget('quote_count');
    }
    public function quotation_upload(Request $request)
    {
        //dd($request->document);
        $request->validate([
            'document' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:4096',
        ]);
        $documentName = time() . '.' . $request->document->extension();
        $request->document->move(public_path('quotation'), $documentName);
        $path = "public/quotation/" . $documentName;
        if (auth('customer')->check()) {
            $data = [
                "quotation_id" => 0,
                "f_name" => auth('customer')->user()->f_name,
                "l_name" => auth('customer')->user()->l_name,
                "email" => auth('customer')->user()->email,
                "phone" => auth('customer')->user()->phone,
                "rfq_file" => $path,
                "file_name" => $documentName,
            ];
            DB::table('quotation_contact')->insert($data);
        }
        Toastr::success('Successfully Upload.');
        return redirect()->route('account-quotation');
    }
    public function quotation_rfq_upload(Request $request)
    {
        //dd($request->document);
        $request->validate([
            'document' => 'required|mimes:pdf|max:4096',
        ]);
        $documentName = time() . '.' . $request->document->extension();
        $request->document->move(public_path('quotation'), $documentName);
        $path = "public/quotation/" . $documentName;
        $quotation_contact = [
            "quotation_id" => 0,
            "f_name" => $request->f_name,
            "l_name" => $request->l_name,
            "email" => $request->email,
            "phone" => $request->phone,
            "company" => $request->company,
            "address" => $request->address,
            // "industry" => $request->industry,
            // "city" => $request->city,
            "comments" => $request->comments,
            "rfq_file" => $path,
            "file_name" => $documentName,
            "created_at" => NOW(),
        ];
        DB::table('quotation_contact')->insert($quotation_contact);
        Toastr::success('Successfully Send Quotation.');
        return redirect()->route('customer.quotation_rfq_success');
    }
    public function product_variation(Request $request)
    {
        // dd($request->all());
        $product = DB::table('products')->where('id', $request->product_id)->first();
        $variation_attr = $product->variation;
        $variation_data = json_decode($variation_attr);
        $price = 0;

        foreach ($variation_data as $row) {
            if ($row->type == $request->value) {
                $price = $row->price;
            }
        }
        return response()->json(['response' => 'success', 'price' => $price]);
    }
    public function product_wholesale(Request $request)
    {
         $price=0;
         $qty=$request->qty;
         $products=DB::table('products')->where('id',$request->product_id)->first();
         $whole_sale=DB::table('wholesale_prices')
                        ->where('product_stock_id',$request->product_id)
                        ->where('min_qty','<=',$qty)
                        ->where('max_qty','>=',$qty)
                        ->first();
        $discount=0;
        if($products->discount_type=='flat')
        {
            $discount=$products->discount;
        }
        else{
            $discount=$products->unit_price*($products->discount/100);
        }
        //$price=($products->unit_price-$discount);
        if(empty($whole_sale))
        {
            $price=($products->unit_price-round($discount,2))*$qty;
        }
        else{
            $price=$whole_sale->price*$qty;
        }
        //$price=($products->unit_price - round($discount,2))*$qty;
       return response()->json(['response' => 'success', 'price' =>$price]);
    }
    
    public function request_call_back(Request $request)
    {
        $user_id = auth('customer')->id();
        session()->put('keep_return_url', url()->previous());
        $data = [
            'name' => $request->name,
            'phone' => $request->phone_no,
            'product_id' => $request->product_id,
            'preferred_dt' => $request->preffered_dt,
            'preffered_time' => $request->preffered_time . ' ' . $request->time_type,
            'customer_id' => isset($user_id) ? $user_id : '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        DB::table('request_call_back')->insert($data);
        Toastr::success('Request has successfully sent!');
        return redirect(session('keep_return_url'));
    }
    public function removeFromQuote(Request $request)
    {
        DB::table('quote_cart')
            ->where('id', $request->key)
            ->delete();
        session()->forget('quote_count');
        $quote_count = DB::table('quote_cart')
            ->where('customer_id', auth('customer')->id())
            ->get()->count();
        session()->put('quote_count', $quote_count);
        return response()->json(['data' => view('layouts.front-end.partials.quote_details')->render()]);
    }

    public function successQuote(Request $request)
    {
        return view('layouts.front-end.partials.quote_success');
    }
    public function successRfqQuote(Request $request)
    {
        return view('layouts.front-end.partials.quote_rfq_success');
    }
    public function updateQuantity(Request $request)
    {
        dd($request->all());
        $response = CartManager::update_cart_qty($request);

        session()->forget('coupon_code');
        session()->forget('coupon_discount');

        if ($response['status'] == 0) {
            return response()->json($response);
        }

        return response()->json(view('layouts.front-end.partials.cart_details')->render());
    }

    public function success()
    {
        return response()->json(['message' => 'Payment succeeded'], 200);
    }

    public function fail()
    {
        return response()->json(['message' => 'Payment failed'], 403);
    }
    public function ask_question(Request $request)
    {
        $user_id = auth('customer')->id();
        session()->put('keep_return_url', url()->previous());
        $data = [
            'question' => $request->question,
            'customer_id' => $user_id,
            'product_id' => $request->product_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        DB::table('product_questions')->insert($data);
        Toastr::success('Question has successfully sent!');
        return redirect(session('keep_return_url'));
    }
}