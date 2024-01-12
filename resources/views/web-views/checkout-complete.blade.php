@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Order Complete'))

@push('css_or_js')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

        body {
            font-family: 'Montserrat', sans-serif
        }

        .card {
            border: none
        }

        .totals tr td {
            font-size: 13px
        }

        .footer span {
            font-size: 12px
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .spanTr {
            color: {{$web_config['primary_color']}};
            font-weight: 700;

        }

        .spandHeadO {
            color: #030303;
            font-weight: 500;
            font-size: 20px;

        }

        .font-name {
            font-weight: 600;
            font-size: 13px;
        }

        .amount {
            font-size: 17px;
            color: {{$web_config['primary_color']}};
        }

        @media (max-width: 600px) {
            .orderId {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 91px;
            }

            .p-5 {
                padding: 2% !important;
            }

            .spanTr {

                font-weight: 400 !important;
                font-size: 12px;
            }

            .spandHeadO {

                font-weight: 300;
                font-size: 12px;

            }

            .table th, .table td {
                padding: 5px;
            }
        }
    </style>
@endpush

@section('content')
    <?php
    $user_id=auth('customer')->user()->id;
    $orderDetails = \App\Model\Order::where('id',$order_id)->whereHas('details',function ($query) use($user_id){
                $query->where('customer_id',$user_id);
            })->first();
    
    $order = \App\Model\OrderDetail::where('order_id', $orderDetails->id)->get();
    ?>

    <div class="container mt-4 mb-5 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="card" style="padding: 20px;border: 1px solid #dae1e7!important;border-radius: 0px;">
                    <div class="row">
                        <div class="col-md-8 col-lg-8">
                            <div class="">
                                @if(auth('customer')->check())
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="order-success-box">
                                                    <center>
                                                        <i style="font-size: 25px;color: #e9611e;margin-right: 6px;" class="fa fa-check-circle"></i>
                                                    </center>
                                                    <h5 style="font-size: 20px; font-weight: 900">{{\App\CPU\translate('Thank_You_for_your_Order!')}}!</h5>
                                                </div>
                                                
                                            </div>
                                        </div>
            
                                        <span class="font-weight-bold d-block" style="font-size: 17px;">{{\App\CPU\translate('Hello')}}, {{auth('customer')->user()->f_name}} {{auth('customer')->user()->l_name}}</span>
                                        <span>{{\App\CPU\translate('Your order has been placed and is being processed. When the order will be shipped you be notified according to the method of delivery you selected. An invoice of this order will be mailed to you shortly and you can also Track this order from "Track Order" section. Alternatively, you will find updated details from time to time in your customer dashboard under My Orders section". Thank you once again, Stay Malamal.')}}</span>
                                        
                                        <div class="success-price-sum">
                                            <p>{{\App\CPU\Helpers::currency_converter($orderDetails['order_amount']-$orderDetails['loyalty_discount'])}}</p><span>Paid through {{\App\CPU\translate($orderDetails['payment_method'])}}</span>
                                        </div>
                                        
                                        <!--<div class="row mt-4">
                                            <div class="col-6">
                                                <a href="{{route('home')}}" class="btn btn--primary">
                                                    {{\App\CPU\translate('Continue_Shopping')}}
                                                </a>
                                            </div>
            
                                            <div class="col-6">
                                                <a href="{{route('account-oder')}}"
                                                   class="btn btn-secondary pull-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                                    {{\App\CPU\translate('check_orders')}}
                                                </a>
                                            </div>
                                        </div>-->
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="order-complete-right-side">
                                <div class="j-address">
                                    <div class="card address-box" style="text-transform: capitalize;">
                                        <div class="card-header justify-content-between" style="padding: 5px;">
                                            <div class="dash-address-pin">
                                                <svg class="svg-inline--fa fa-thumbtack fa-2x iconHad" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="thumbtack" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><path fill="currentColor" d="M32 32C32 14.3 46.3 0 64 0H320c17.7 0 32 14.3 32 32s-14.3 32-32 32H290.5l11.4 148.2c36.7 19.9 65.7 53.2 79.5 94.7l1 3c3.3 9.8 1.6 20.5-4.4 28.8s-15.7 13.3-26 13.3H32c-10.3 0-19.9-4.9-26-13.3s-7.7-19.1-4.4-28.8l1-3c13.8-41.5 42.8-74.8 79.5-94.7L93.5 64H64C46.3 64 32 49.7 32 32zM160 384h64v96c0 17.7-14.3 32-32 32s-32-14.3-32-32V384z"></path></svg><!-- <i class="fa fa-thumb-tack fa-2x iconHad" aria-hidden="true"></i> Font Awesome fontawesome.com -->
                                            </div>
                                            <div class="dash-address">
                                                <span> Address (Shipping address) </span>
                                            </div>
                                        </div>
                                        <div class="card-body dash-add-detail">
                                            @if($orderDetails->shippingAddress)
                                                @php($shipping_address=$orderDetails->shippingAddress)
                                            @else
                                                @php($shipping_address=json_decode($orderDetails['shipping_address_data']))
                                            @endif                                    
                                            <div class="font-name"><span>{{$shipping_address? $shipping_address->contact_person_name : ''}}</span>
                                            </div>
                                            <div><span class="font-nameA"> <strong>Phone  :</strong>  {{$shipping_address ? $shipping_address->phone  : ''}}</span>
                                            </div>
                                            <div><span class="font-nameA"> <strong>City  :</strong>  {{$shipping_address ? $shipping_address->city  : ''}}</span>
                                            </div>
                                            <div><span class="font-nameA"> <strong> Zip code :</strong> {{$shipping_address ? $shipping_address->zip  : ''}}</span>
                                            </div>
                                            <div><span class="font-nameA"> <strong>Address :</strong> {{$shipping_address ? $shipping_address->address  : ''}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="corporate-sme" style="display:none">
                                    <p class="corporate-sme-p">Mark your Purchase Order (PO) No. here with this Order</p>
                                    <div class="input-group mb-3" style="width:80%">
                                      <input type="text" class="form-control border-radius" placeholder="Enter your PO no. here" >
                                      <div class="input-group-append">
                                        <button class="sme-po-number" type="button">SAVE</button>
                                      </div>
                                    </div>
                                    <p style="color: gray;">This Purchase Order No. will be Included in all order related emails & SMS's sent to you</p>
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                 </div>
            </div>
            <div class="col-md-12">
                <div class="complete-order-all-btn-sec">
                    <div class="complete-order-all-btn-box">
                        <ul>
                            <li><a href="{{route('track-order.result',['order_id'=>$orderDetails->id,'from_order_details'=>1])}}">You can now Track <i class="fa-solid fa-truck-fast"></i></a></li>
                          
                            <li><a href="{{route('account-oder')}}"><span> My Orders </span></a></li>
                        </ul>
                    </div>
                    <div class="complete-item-process">
                        <ul>
                            <li class="active">
                                <div class="process-item">
                                    <div class="process-item-icon">
                                        <i class="fa fa-box-open"></i>
                                    </div>
                                    <p>Order Placed</p>
                                    <center class="icon-center">
                                        <i style="font-size: 15px;color: #0E2F56;margin-right: 6px;" class="fa fa-check-circle"></i>
                                    </center>
                                </div>
                                
                            </li>
                            <li>
                                <div class="process-item">
                                    <div class="process-item-icon">
                                        <i class="fa-solid fa-rotate"></i>
                                    </div>
                                    <p>Processing</p>
                                </div>
                            </li>
                            <li>
                                <div class="process-item">
                                    <div class="process-item-icon">
                                        <i class="fa-solid fa-truck-fast"></i>
                                    </div>
                                    <p>Shipping</p>
                                </div>
                            </li>
                            <li>
                                <div class="process-item">
                                    <div class="process-item-icon">
                                        <i class="fa-solid fa-truck-ramp-box"></i>
                                    </div>
                                    <p>Delivery</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="complete-order-all-btn-sec">
                    <div class="complete-order-summary">
                        <h4>Your Order Summery ({{count($order)}} Items)</h4>
                        <p>Order No: {{$orderDetails['id']}}</p>
                    </div>
                    <div class="complete-order-cont">
                        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table" style="width: 100%">
                           <thead class="complete-cart-tb-head">
                              <tr class="">
                                 <th class="font-weight-bold" style="width: 5%;">SL#</th>
                                 <th class="font-weight-bold" style="width: 30%;">Product details</th>
                                 <th class="font-weight-bold" style="width: 5%;">Quantity</th>
                                 <th class="font-weight-bold" style="width: 15%;">Unit price</th>
                                 <!--<th class="font-weight-bold" style="width: 15%;">Qty</th>-->
                                 <th class="font-weight-bold" style="width: 15%;">Subtotal</th>
                                 <!--<th class="font-weight-bold" style="width: 15%;">Shipping cost </th>
                                 <th class="font-weight-bold" style="width: 5%;">Action</th>-->
                              </tr>
                           </thead>
                           <tbody>
                            @php( $totalTax = 0)
        
                            @php($sub_total=0)
                            @php($total_tax=0)
                            @php($total_shipping_cost=0)
                            @php($total_discount_on_product=0)
                            @php($extra_discount=0)
                            @php($coupon_discount=0)
                            @php($sl=1)
                            @foreach($order as $product)
                                @php($productDetails = App\Model\Product::where('id', $product->product_id)->first())
                              <tr class="tr-border">
                                 <td>{{$sl++}}</td>
                                 <td>
                                    <div class="d-flex">
                                       <div style="width: 30%;">
                                          <a href="{{route('frontend.product_details',$productDetails->slug)}}">
                                          <img style="height: 62px;" onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'" src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$productDetails['thumbnail']}}" alt="Product">
                                          </a>
                                       </div>
                                       <div class="ml-2 text-break" style="width:70%;">
                                          <a href="{{route('frontend.product_details',$productDetails->slug)}}">{{$productDetails['name']}}</a>
                                       </div>
                                    </div>
                                    <div class="d-flex">
                                        @if($product['variation'])
                                            @foreach(json_decode($product['variation'],true) as $key1 =>$variation)
                                                <div class="text-muted"><span
                                                        class="mr-2">{{$key1}} :</span>{{$variation}}</div>
                                            @endforeach
                                        @endif                                        
                                    </div>
                                 </td>
                                 <td>
                                    <div class=" text-accent">{{$product['qty']}}</div>
                                 </td>
                                 <td>
                                    <div class=" text-accent">{{\App\CPU\Helpers::currency_converter($product['price']-$product['discount'])}}</div>
                                 </td>
                                
                                 <td>
                                    <div>
                                       <span id="sub_total199"> {{\App\CPU\Helpers::currency_converter(($product['price']-$product['discount'])*$product['qty'])}}</span>
                                    </div>
                                 </td>
                                 
                              </tr>
                        @php($sub_total+=$product['price']*$product['qty'])
                        @php($total_tax+=$product['tax'])
                        @php($total_discount_on_product+=$product['discount'])
                    @endforeach

                           </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection

@push('script')

@endpush