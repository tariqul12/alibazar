<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Parcel;
use App\Model\Quotation;
use App\Services\parcels\RedxService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use function App\CPU\translate;

class ParcelManagementController extends Controller
{
    public $redexService;
    public function __construct()
    {
        $this->redexService = new RedxService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query_param = [];
        $pro = Parcel::where('id', '!=', '');
        $data['pro'] = $pro = $pro->orderBy('id', 'DESC')->paginate(Helpers::pagination_limit())->appends($query_param);

        return view('admin-views.parcels.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $orderId = $request->get('order_id');
        $data = [];
        $redexData = $this->redexService->getAreas();
        $data['orders'] = Order::where('order_status','confirmed')->where('delivery_status',0)->get();
        $data['areas'] = isset($redexData['areas']) ? $redexData['areas'] : [];
        $data['couriers'] = [];
        $data['order_id'] = $orderId;
        return view('admin-views.parcels.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $order = Order::where('id',$request->order_id)->first();
            if(!$order){
                throw new \Exception("Invalid order Id");
            }
            $customer = $order->customer;
            if(!$customer){
                throw new \Exception("Customer Info not found");
            }
            $shippingAddress = $order->shippingAddress;
            //$postCode = '1212';
            $postCode = $request->post_code;
            $redexData = $this->redexService->getAreas($postCode);
            $areas = isset($redexData['areas']) ? $redexData['areas'] : [];
            $delivery_area_id = isset($areas[0]) ? $areas[0]['id'] : '';
            $delivery_area = isset($areas[0]) ? $areas[0]['name'] : '';
            $params = [
                "customer_name" => $customer->f_name. ' '. $customer->l_name,
                "customer_phone" => $customer->phone,
                "delivery_area" => $delivery_area,
                "delivery_area_id" => $delivery_area_id,
                "customer_address" => $shippingAddress->address,
                "merchant_invoice_id" => $request->order_id,
                "cash_collection_amount" => $order->order_amount,
                "parcel_weight" => $request->weight,
                "value"=> $order->order_amount,
                "instruction" => "",
                /*"parcel_details_json" => [
                    [
                        "name" => "item1",
                        "category" => "category1",
                        "value" => 120.05
                    ],
                    [
                        "name" => "item2",
                        "category" => "category2",
                        "value" => 130.05
                    ]
                ]*/
            ];
            $courierResponse = $this->redexService->createParcel($params);
            $trackingId = '';
            if(isset($courierResponse['trackingId']) && $courierResponse['trackingId'] != ''){
                $trackingId = $courierResponse['trackingId'];
            } else {
                throw new \Exception("Tracking Id not found");
            }
            $parcel = new Parcel();
            $parcel->order_id = $request->order_id;
            $parcel->courier_name = "REDX";
            $parcel->weight = $request->weight;
            $parcel->created_by = auth('admin')->user()->id;
            $parcel->tracking_id = $trackingId;
            $parcel->area = $delivery_area;
            $parcel->post_code = $postCode;
            $parcel->amount = $order->order_amount;
            $order->third_party_delivery_tracking_id = $trackingId;
            $order->delivery_service_name = "REDX";
            $order->delivery_status = '1';/*parcel initiate*/
            $order->save();
            $parcel->save();
            Toastr::success('Order is successfully submitted to courier provider');
            return redirect()->back();
            return redirect()->route('admin.parcel.parcel_list');

        }catch (\Exception $exception){
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function tracking(Request $request) {
        try {
            $trackingNo = $request->get('tracking_no');

         //   $redexData = $this->redexService->trackParcel($trackingNo);
            $parcelInfo = $this->redexService->infoParcel($trackingNo);
            $redexData['tracking_no'] = $trackingNo;
            $redexData['parcelData'] = isset($parcelInfo['parcel_info']) ? $parcelInfo['parcel_info'] : [];

            return view('admin-views.parcels.show',$redexData);
        }catch (\Exception $exception){
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
}
