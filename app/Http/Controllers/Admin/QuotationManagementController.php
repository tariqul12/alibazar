<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Customer;
use App\Model\Product;
use App\Model\ProductQuotation;
use App\Model\Quotation;
use App\Model\QuotationRequest;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use function App\CPU\translate;
use Mail;
use URL;
class QuotationManagementController extends Controller
{
    public function index(Request $request) {
        $query_param = [];
        $pro = Quotation::where('reference_no', '!=', '');
        $data['pro'] = $pro = $pro->orderBy('id', 'DESC')->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.quotation.list',$data);
    }

    public function changeRequest(Request $request) {
        $query_param = [];
        // $pro = QuotationRequest::where('id', '!=', '');
        $pro = DB::table('quotation_contact')->where('quotation_id', 0)->orWhere('quotation_via','admin');
        $data['pro'] = $pro = $pro->orderBy('id', 'DESC')->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.quotation.requests',$data);
    }

    public function quotation_request_View($id) {
        $data = [];
        $re = QuotationRequest::where('id',$id)->firstOrFail();
        $viewPath = asset('/public/quotation/').'/'.$re->file_name;
        return redirect()->to($viewPath);
    }

    public function create(Request $request) {
       // session::flash('quotation_cart');
        $data['cat'] = Category::where(['parent_id' => 0])->get();
        $data['br'] = Brand::orderBY('name', 'ASC')->get();
        $data['lims_customer_list'] = User::all();
        $data['items'] = Session::get('quotation_cart') ?? [];
        $data['cartData'] = json_encode($data['items']);
        $data['customer_id'] = $request->get('customer_id');
       // dd($data);
       $quotation_default_vat=Helpers::get_business_settings('quotation_vat');
       $data['quotation_default_vat']=$quotation_default_vat;
        return view('admin-views.quotation.create',$data);
    }

    public function store(Request $request) {
        try{
            $data = $request->except('document');
            $document = $request->document;
            if($document){
                $v = Validator::make(
                    [
                        'extension' => strtolower($request->document->getClientOriginalExtension()),
                    ],
                    [
                        'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                    ]
                );
                if ($v->fails())
                    return redirect()->back()->withErrors($v->errors());
                $documentName = $document->getClientOriginalName();
                $document->move('public/quotation/documents', $documentName);
                $data['document'] = $documentName;
            }
            DB::beginTransaction();
            $requestId = $request->get('request_id');
            $quotationRequest = null;
            if($requestId) {
                $quotationRequest = QuotationRequest::where('id',$requestId)->where('quotation_id',0)->first();
                if(! $quotationRequest){
                    throw new \Exception("Invalid quotation request id");
                }
            }

            $data['reference_no'] = 'QR-' . date("Ymd") . '-'. date("his");
            $data['order_discount'] = $data['total_discount'];
            $data['grand_total'] = $data['total_price'] + $data['shipping_amount'];
            $cartItems = Session::get('quotation_cart');
            $data['cart_info'] = json_encode($cartItems);
            $data['user_id'] = auth('admin')->user()->id;
            $lims_quotation_data = Quotation::create($data);
            #contact info
            $contact_verify=DB::table('quotation_contact')->where('cust_id',$data['customer_id'])->where('quotation_id',0)->orderBy('id','DESC')->first();
            if(isset($contact_verify))
            {
                $contact=[
                    "quotation_id"=>$lims_quotation_data->id,
                    "f_name"=>$contact_verify->f_name,
                    "email"=>$contact_verify->email,
                    "phone"=>$contact_verify->phone,
                    "company"=>$contact_verify->company,
                    "address"=>$contact_verify->address
                ];
                DB::table('quotation_contact')->where('id',$contact_verify->id)->insert($contact);
            }
            User::find($data['customer_id']);
            $quote_vat=0;
            if($request->quotation_vat_status=='1')
            {
                $quote_vat=$request->quote_vat;
                DB::table('quotations')->where('id',$lims_quotation_data->id)->update(['is_vat'=>"1"]);
            }
            if(count($cartItems)) {
                foreach ($cartItems as $key => $cartItem){
                    $per_vat=0;
                    $per_unit_price=$cartItem['price'];
                    $per_vat=$per_unit_price*($quote_vat/100);
                    
                    $product_quotation['name'] = $cartItem['name'] ;
                    $product_quotation['quotation_id'] = $lims_quotation_data->id ;
                    $product_quotation['code'] = $cartItem['code'] ;
                    $product_quotation['product_id'] = $cartItem['id'];
                    $product_quotation['qty'] = $cartItem['qty'];
                    $product_quotation['net_unit_price'] = $cartItem['price'];
                    $product_quotation['discount'] = $cartItem['discount'];
                    $product_quotation['tax'] = 0;
                    $product_quotation['vat'] = $cartItem['vat'];
                    $product_quotation['vat_rate'] = $quote_vat;
                    $product_quotation['total'] =  $cartItem['subtotal'];
                    $product_quotation['description'] =  $cartItem['description'];
                    $product_quotation['single_unit_vat'] =  round($per_vat,2);
                    $product_quotation['single_unit_price_vat'] =  round(($per_unit_price+$per_vat),2);
                    ProductQuotation::create($product_quotation);
                }
            }
            if($quotationRequest) {
                $quotationRequest->quotation_id = $lims_quotation_data->id;
                $quotationRequest->quotation_via = 'admin';
                $quotationRequest->quotation_status = 'done';
                $quotationRequest->save();
            }
            // session()->forget('quotation_cart');
            DB::commit();
            Session::forget('quotation_cart');
            Session::forget('customer_id');
            Session::forget('subject_line');
            Toastr::success('Quotation added successfully');
            return redirect()->route('admin.quotation.list');
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }

    }
     public function qoutation_send_mail($id)
    {
        $quote=DB::table('quotations')->where('id',$id)->select('customer_id')->first();
        $users=DB::table('users')->where('id',$quote->customer_id)->first();
        if ($id) {
            $file_id=$id;
            $quotation = DB::table('quotations')
            ->join('product_quotation', 'product_quotation.quotation_id', 'quotations.id')
            ->leftjoin('products', 'products.id', 'product_quotation.product_id')
            ->where('quotations.id', $id)
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
                'product_quotation.single_unit_price_vat',
                'product_quotation.single_unit_vat',
                'product_quotation.net_unit_price',
                'product_quotation.total',
                'quotations.shipping_cost',
                'quotations.total_vat',
                'quotations.is_vat'
            )
            ->get();
            $data['product_data'] = $quotation;
            $data['quotation_id'] = $file_id;
            $data_format['quotation'] = Quotation::where('id', $id)->firstOrFail();
            $data_format['quotation_details'] = $quotation;
            $data_format['contact_info'] = DB::table('shipping_addresses')->where('customer_id', $quote->customer_id)->where('is_billing',1)->select('company_name as company','address','contact_person_name','phone')->first();
            $mpdf_view = view('email.admin_quotation', $data_format);
            Helpers::quotation_mpdf($mpdf_view, 'Quotation_', $file_id);
            DB::table('quotations')->where('id',$id)->update(['quotation_status'=>2]);
        }
        $files = [
            URL::to('/') . '/storage/app/public/quotation/Quotation_' . $file_id . '.pdf',
        ];
        $data["email"] = $users->email;
        $data["name"] = $users->f_name;
        $data["title"] = "Quotation";
        if(!empty($data["email"]))
        {
            Mail::send('email.mail_body', $data, function ($message) use ($data, $files) {
                $message->to($data["email"], $data["email"])
                    ->subject($data["title"]);
                foreach ($files as $file) {
                    $message->attach($file);
                }
            });
        }
        Toastr::success('Quotation Mail Send Successfully');
        return redirect()->route('admin.quotation.list');
    }
    public function getProductData()
    {

        $product_code = [];
        $product_name = [];
        $product_qty = [];
        $product_data = [];
        //retrieve data of product without variant
        $allProducts = Product::all();

        foreach ($allProducts as $product)
        {
            $product_qty[] = $product->qty;
            $lims_product_data = $product;
            $product_code[] =  $lims_product_data->id;
            $product_name[] = $lims_product_data->name;
            $product_type[] = 'standard';
            $product_id[] = $lims_product_data->id;
            $product_list[] = null;
            $qty_list[] = null;
        }

        $product_data = [$product_code, $product_name, $product_qty, $product_type, $product_id, $product_list, $qty_list];
        return $product_data;
    }

    public function productSearch(Request $request) {
  //  $data = ["White Fotua","46963437","650",0,"No Tax",1,"Piece,dozen box,cartoon box,","*,*,*,","1,12,24,",22,null];
        $product_code = explode(" ",$request['data']);
        $product_variant_id = null;
        $lims_product_data = Product::where('id', $product_code[0])->first();
        $product[] = $lims_product_data->name;
        $product[] = $lims_product_data->id;
        $product[] = $lims_product_data->unit_price;
        $product[] = 0;
        $product[] = "No Vat";
        $product[] = 1;
        $product[] = "Piece,dozen box,cartoon box,";
        $product[] = "*,*,*,";
        $product[] = "1,12,24,";
        $product[] = $lims_product_data->id;
        $product[] = $product_variant_id;
        return $product;
    }

    public function show($id) {
        $data = [];
        $quotation = Quotation::where('id',$id)->firstOrFail();
        //dd($quotation->productQuotations);
        $data['quotation'] = $quotation;
        return view('admin-views.quotation.show',$data);
    }

    public function quotationDownload($id) {
        $data = [];
        $quotation = Quotation::where('id',$id)->firstOrFail();
        $data['quotation'] = $quotation;
        $mpdf_view = view('admin-views.quotation.download_new', $data);
       // return $mpdf_view;
        Helpers::gen_mpdf($mpdf_view, 'quotation_invoice_', $quotation->id);
    }

    public function quotationSessionInsert(Request $request) {
        try{
            $data = $request->all();
            \Log::info('quotation session data'. json_encode($data));
            $product_code = explode(" ",$request['data']);
            $productData = Product::where('id', $product_code[0])->first();
            $cart = Session::get('quotation_cart') ?? [];
            if (array_search($productData->id, array_column($cart, 'id')) !== FALSE) {
                throw new \Exception("this product already added");
            }
            $dis=0;
            if ($productData['discount_type'] == 'percent') {
                 $dis = ($productData['unit_price'] / 100) * $productData['discount'];
            } else {
                $dis = isset($productData['discount'])?$productData['discount']:0;
            }
            $cart[$productData->id] = array(
                "id" => $productData->id,
                "name" => $productData['name'],
                "code" => $productData['code'],
                "price" => ($productData['unit_price']-$dis),
                "qty" => 1,
                "discount" => 0,
                "vat" => 0,
                "single_unit_vat" => 0,
                "product_price" => $productData['unit_price']*1,
                "single_unit_price_vat" => ($productData['unit_price']-$dis)*1,
                "subtotal" => ($productData['unit_price']-$dis),
                "vat_rate" => 0,
                "description" => isset($productData['short_description']) ? strip_tags($productData['short_description']) : "",
            );
            Session::put('quotation_cart', $cart);
            $data['items'] = Session::get('quotation_cart');
            \Log::info('quotationData'. json_encode($data));
            $view = view('admin-views.quotation.order', $data)->render();
            return response()->json([
                'view' => $view,
                'status' => 'success',
                'cartItem' => json_encode($data['items']),
            ]);
        }catch (\Exception $exception){
            $message = ($exception->getMessage()) ? $exception->getMessage() : 'something went wrong';
            return response()->json([
                'status' => 'failed',
                'error' => $message
            ]);
        }

    }

    public function quotationSessionRemove(Request $request) {
        try{
            $data = $request->all();
            \Log::info('quotation session data'. json_encode($data));
            $cart = Session::get('quotation_cart');
            $id = $request->id;
            unset($cart[$id]);
            Session::put('quotation_cart', $cart);
            $data['items'] = Session::get('quotation_cart');
            \Log::info('quotationData'. json_encode($data));
            $view = view('admin-views.quotation.order', $data)->render();
            return response()->json([
                'view' => $view,
                'status' => 'success',
                'cartItem' => json_encode($data['items'])
            ]);
        }catch (\Exception $exception){
            $message = ($exception->getMessage()) ? $exception->getMessage() : 'something went wrong';
            return response()->json([
                'status' => 'failed',
                'error' => $message
            ]);
        }
    }

    public function quotationSessionUpdate(Request $request){
        try{
            $data = $request->all();
            \Log::info('quotation session data'. json_encode($data));
            $cart = Session::get('quotation_cart');
            $id = $request->product_id;
            $cart[$id]['price'] = $data['edit_unit_price'];
            $cart[$id]['qty'] = $data['edit_qty'];
            //$cart[$id]['discount'] = $data['edit_discount'];
            // $cart[$id]['vat_rate'] = $data['vat_rate'];
             $cart[$id]['vat_rate'] = 0;
            $cart[$id]['single_unit_vat'] = $cart[$id]['price']*$cart[$id]['vat_rate']/100;
            $cart[$id]['single_unit_price_vat'] = $cart[$id]['price']+$cart[$id]['single_unit_vat'];
            $cart[$id]['product_price'] = $data['edit_unit_price']*$data['edit_qty'];
            $cart[$id]['vat'] =  $cart[$id]['product_price']*$cart[$id]['vat_rate']/100;
            $cart[$id]['subtotal'] = $cart[$id]['product_price']+$cart[$id]['vat']-$cart[$id]['discount'];
            $cart[$id]['description'] = isset($data['edit_description']) ? $data['edit_description'] : "";
            Session::put('quotation_cart', $cart);
            $data['items'] = Session::get('quotation_cart');
            \Log::info('quotationData'. json_encode($data));
            $view = view('admin-views.quotation.order', $data)->render();
            return response()->json([
                'view' => $view,
                'status' => 'success',
                'cartItem' => json_encode($data['items'])
            ]);
        }catch (\Exception $exception){
            $message = ($exception->getMessage()) ? $exception->getMessage() : 'something went wrong';
            return response()->json([
                'status' => 'failed',
                'error' => $message
            ]);
        }
    }



    public function quotation_request_store(Request $request) {
        try{
            $request_id = $request->get('request_id');
            $quotationRequest = QuotationRequest::where('id',$request_id)->where('quotation_id',0)->first();
            if(! $quotationRequest){
                throw new \Exception("Invalid quotation request id");
            }

            $customer = User::where('phone',$quotationRequest->phone)->first();
            if(! $customer){
                $customer = new User();
                $customer->name = $quotationRequest->f_name;
                $customer->f_name = $quotationRequest->f_name;
                $customer->phone = $quotationRequest->phone;
                $customer->email = $quotationRequest->email;
                $customer->created_by = auth('admin')->user()->id;
                $customer->street_address = $quotationRequest->city;
                $customer->company_name = $quotationRequest->company;
                $customer->save();
            }
            return redirect()->route('admin.quotation.add-new', ['customer_id' => $customer->id,'request_id'=>$request_id]);
        }catch (\Exception $exception){
            \Log::error('quotation request error: '.$exception->getMessage());
            return redirect()->back()->withErrors($exception->getMessage());
        }
        dd($request->request_id);
    }



    public function edit(Request $request,$id) {
        $data = [];
        $quotation = Quotation::where('id',$id)->firstOrFail();
        $contact=DB::table('quotation_contact')->where('quotation_id',$id)->first();        
        $productQuotations = $quotation->productQuotations;
        $items = array();
        $data['edit_mode'] = true;
        if(count($productQuotations)){
            foreach ($productQuotations as $key=>$p_quotation){
                $items[$p_quotation->id]['id'] = $p_quotation->id;
                $items[$p_quotation->id]['name'] = $p_quotation->name;
                $items[$p_quotation->id]['code'] = $p_quotation->code;
                $items[$p_quotation->id]['product_id'] = $p_quotation->product_id;
                $items[$p_quotation->id]['price'] = $p_quotation->net_unit_price;
                $items[$p_quotation->id]['qty'] = $p_quotation->qty;
                $items[$p_quotation->id]['discount'] = $p_quotation->discount;
                $items[$p_quotation->id]['vat'] = $p_quotation->vat;
                $items[$p_quotation->id]['single_unit_vat'] = $p_quotation->single_unit_vat;
                $items[$p_quotation->id]['product_price'] = $p_quotation->total;
                $items[$p_quotation->id]['single_unit_price_vat'] = $p_quotation->single_unit_price_vat;
                $items[$p_quotation->id]['subtotal'] = $p_quotation->total;
                $items[$p_quotation->id]['vat_rate'] = $p_quotation->vat_rate;
                $items[$p_quotation->id]['description'] = $p_quotation->description;
            }
        }
        Session::put('quotation_cart', $items);

        $data['cat'] = Category::where(['parent_id' => 0])->get();
        $data['br'] = Brand::orderBY('name', 'ASC')->get();
        $data['lims_customer_list'] = User::all();
        $data['items'] = Session::get('quotation_cart') ?? [];
        //$data['items'] = $items;
        //dd($quotation->productQuotations,$data['items']);
        $data['customer_id'] = ($request->get('customer_id') && $request->get('customer_id') != '') ? $request->get('customer_id') : $quotation->customer_id;
        $data['quotation'] = $quotation;
        $data['contact']=$contact;
        $quotation_default_vat=Helpers::get_business_settings('quotation_vat');
        $data['quotation_default_vat']=$quotation->productQuotations->first()->vat_rate;
        return view('admin-views.quotation.edit',$data);
    }


    public function update(Request $request,$id) {
        try{
            $quotation = Quotation::where('id',$id)->firstOrFail();
            $data = $request->except('document');
            $data['order_discount'] = $data['total_discount'];
            $data['grand_total'] = $data['total_price'] + $data['shipping_amount'];
            $cartItems = Session::get('quotation_cart');
            $data['cart_info'] = json_encode($cartItems);
            $data['user_id'] = auth('admin')->user()->id;

            $quotation->update($data);
            ProductQuotation::where('quotation_id',$quotation->id)->delete();
         //   $lims_quotation_data = Quotation::create($data);

            User::find($data['customer_id']);
            $quote_vat=0;
            if($request->quotation_vat_status=='1')
            {
                $quote_vat=$request->quote_vat;
                DB::table('quotations')->where('id',$id)->update(['is_vat'=>"1",'vat_rate'=>$quote_vat]);
            }
            else{
                DB::table('quotations')->where('id',$id)->update(['is_vat'=>"0",'vat_rate'=>$quote_vat,'shipping_amount'=>$quotation->shipping_cost,'shipping_vat'=>0]);
            }
            if(count($cartItems)) {
                foreach ($cartItems as $key => $cartItem){
                    $per_vat=0;
                    $per_unit_price=$cartItem['price'];
                    $per_vat=$per_unit_price*($quote_vat/100);

                    $product_quotation['name'] = $cartItem['name'] ;
                    $product_quotation['quotation_id'] = $quotation->id ;
                    $product_quotation['code'] = $cartItem['code'] ;
                    $product_quotation['product_id'] = $cartItem['product_id'];
                    $product_quotation['qty'] = $cartItem['qty'];
                    $product_quotation['net_unit_price'] = $cartItem['price'];
                    $product_quotation['discount'] = $cartItem['discount'];
                    $product_quotation['tax'] = 0;
                    $product_quotation['vat'] = $cartItem['vat'];
                    $product_quotation['vat_rate'] = $quote_vat;
                    $product_quotation['total'] =  $cartItem['subtotal'];
                    $product_quotation['description'] =  $cartItem['description'];
                    $product_quotation['single_unit_vat'] =  round($per_vat,2);;
                    $product_quotation['single_unit_price_vat'] =  round(($per_unit_price+$per_vat),2);
                    ProductQuotation::create($product_quotation);
                }
            }

            session()->forget('quotation_cart');
            DB::commit();
            Toastr::success("Quotation  update successfully");
            return redirect()->route('admin.quotation.list');
        }catch (\Exception $exception){

        }
    }
}