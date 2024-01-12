@extends('layouts.front-end.app')

@section('title','Track Order')

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="{{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="{{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <link rel="stylesheet" media="screen"
          href="{{asset('public/assets/front-end')}}/vendor/nouislider/distribute/nouislider.min.css"/>
@endpush

@section('content')
    <!-- Order Details Modal-->
    <?php
    $order = \App\Model\OrderDetail::where('order_id', $orderDetails->id)->get();
    ?>
    <div class="modal fade" id="order-details">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ \App\CPU\translate('Order No')}} - {{$orderDetails['id']}}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body pb-0">
                    @php( $totalTax = 0)

                    @php($sub_total=0)
                    @php($total_tax=0)
                    @php($total_shipping_cost=0)
                    @php($total_discount_on_product=0)
                    @php($extra_discount=0)
                    @php($coupon_discount=0)
                    @foreach($order as $product)
                        @php($productDetails = App\Model\Product::where('id', $product->product_id)->first())

                        <div class="d-sm-flex justify-content-between mb-4 pb-3 pb-sm-2 border-bottom">
                            <div class="media d-block d-sm-flex text-center text-sm-left">
                                <a class="d-inline-block mx-auto mr-sm-4"
                                   href="{{route('frontend.product_details',$productDetails->slug)}}" style="width: 10rem;">
                                    <img
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$productDetails['thumbnail']}}">
                                </a>
                                <div class="media-body pt-2">
                                    <h4 class="product-title font-size-base mb-2"><a
                                            href="{{route('frontend.product_details',$productDetails->slug)}}">{{$productDetails['name']}}</a>
                                    </h4>
                                    @if($product['variation'])
                                        @foreach(json_decode($product['variation'],true) as $key1 =>$variation)
                                            <div class="text-muted"><span
                                                    class="mr-2">{{$key1}} :</span>{{$variation}}</div>
                                        @endforeach
                                    @endif
                                    <div
                                        class="font-size-lg text-accent pt-2">{{\App\CPU\Helpers::currency_converter($product['price'])}}</div>
                                </div>
                            </div>
                            <div class="pt-2 pl-sm-3 mx-auto mx-sm-0 text-center">
                                <div class="text-muted mb-2">{{ \App\CPU\translate('Quantity')}}:</div>{{$product['qty']}}
                            </div>
                            <div class="pt-2 pl-sm-2 mx-auto mx-sm-0 text-center">
                                <div class="text-muted mb-2">{{ \App\CPU\translate('Tax')}}:
                                </div>{{\App\CPU\Helpers::currency_converter($product['tax'])}}
                            </div>
                            <div class="pt-2 pl-sm-3 mx-auto mx-sm-0 text-center">
                                <div class="text-muted mb-2">{{ \App\CPU\translate('Subtotal')}}</div>{{\App\CPU\Helpers::currency_converter($product['price']*$product['qty'])}}
                            </div>
                        </div>
                        @php($sub_total+=$product['price']*$product['qty'])
                        @php($total_tax+=$product['tax'])
                        @php($total_discount_on_product+=$product['discount'])
                    @endforeach

                    @php($total_shipping_cost=$orderDetails['shipping_cost'])

                    <?php
                            if ($orderDetails['extra_discount_type'] == 'percent') {
                                $extra_discount = ($sub_total / 100) * $orderDetails['extra_discount'];
                            } else {
                                $extra_discount = $orderDetails['extra_discount'];
                            }
                            if(isset($orderDetails['discount_amount'])){
                                $coupon_discount =$orderDetails['discount_amount'];
                            }
                        ?>
                </div>
                <!-- Footer-->
                <div class="modal-footer flex-wrap justify-content-between bg-secondary font-size-md">

                        <div class="px-2 py-1">
                            <span
                                class="text-muted">{{ \App\CPU\translate('Subtotal')}}:&nbsp;</span>{{\App\CPU\Helpers::currency_converter($sub_total)}}
                            <span></span>
                        </div>
                        <div class="px-2 py-1">
                            <span
                                class="text-muted">{{ \App\CPU\translate('Shipping')}}:&nbsp;</span>{{\App\CPU\Helpers::currency_converter($total_shipping_cost)}}
                            <span></span>
                        </div>
                        <div class="px-2 py-1">
                            <span class="text-muted">{{ \App\CPU\translate('Tax')}}:&nbsp;</span> {{\App\CPU\Helpers::currency_converter($total_tax)}}
                            <span></span>
                        </div>

                        <div class="px-2 py-1">
                            <span
                                class="text-muted">{{ \App\CPU\translate('Discount')}}:&nbsp;</span>
                            - {{\App\CPU\Helpers::currency_converter($total_discount_on_product)}}
                            <span></span>
                        </div>
                </div>
                <div class="modal-footer flex-wrap justify-content-between bg-secondary font-size-md">
                    <div class="px-2 py-1">
                        <span
                            class="text-muted">{{ \App\CPU\translate('Coupon Discount')}}:&nbsp;</span>
                        - {{\App\CPU\Helpers::currency_converter($coupon_discount)}}
                        <span></span>
                    </div>
                    @if ($orderDetails['order_type'] == 'POS')
                    <div class="px-2 py-1">
                        <span
                            class="text-muted">{{ \App\CPU\translate('Extra Discount')}}:&nbsp;</span>
                        - {{\App\CPU\Helpers::currency_converter($extra_discount)}}
                        <span></span>
                    </div>
                    @endif
                    <div class="px-2 py-1">
                        <span class="text-muted">{{ \App\CPU\translate('Total')}}:&nbsp; </span>
                        <span class="font-size-lg">
                             {{\App\CPU\Helpers::currency_converter($sub_total+$total_tax+$total_shipping_cost-($orderDetails->discount)-$total_discount_on_product - $coupon_discount - $extra_discount)}}
                        </span>
                    </div>
            </div>
            </div>
        </div>
    </div>
    
    <section class="new-traking-sec">
        <div class="container">
            <h5 class="modal-title">{{ \App\CPU\translate('Order No')}} - {{$orderDetails['id']}}</h5>
            <div class="row">
                <div class="col-md-12">
                    <div class="traking-sec-box">
                        <h3>Order Summery</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="traking-sec-item">
                                    <ul>
                                    @if($orderDetails->shippingAddress)
                                        @php($shipping_address=$orderDetails->shippingAddress)
                                    @else
                                        @php($shipping_address=json_decode($orderDetails['shipping_address_data']))
                                    @endif                                    
                                    @if($orderDetails->billingAddress)
                                        @php($billing=$orderDetails->billingAddress)
                                    @else
                                        @php($billing=json_decode($orderDetails['billing_address_data']))
                                    @endif                                    

                                        <li><span class="track-address-cont">Order Code:</span>{{$orderDetails['id']}}</li>
                                        <li><span class="track-address-cont">Customer:</span>{{$orderDetails->customer['f_name']}} {{$orderDetails->customer['l_name']}}</li>
                                        <li><span class="track-address-cont">Email:</span>{{$orderDetails->customer['email']}}</li>
                                        <li><span class="track-address-cont">Delivery Address:</span>
                                                @if($shipping_address)
                                                    {{$shipping_address->address}},
                                                    {{$shipping_address->city}}
                                                    , {{$shipping_address->zip}}

                                                @endif
                                        </li>
                                        <li><span class="track-address-cont">Billing Address: </span> 
                                                @if($billing)
                                                    {{$billing->address}},
                                                    {{$billing->city}}
                                                    , {{$billing->zip}}

                                                @else
                                                    {{$shipping->address}},
                                                    {{$shipping->city}}
                                                    , {{$shipping->zip}}
                                                @endif
                                        
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="traking-sec-item">
                                    <ul>
                                        <li><span class="track-address-cont">Order Date:</span> {{date('d M Y',strtotime($orderDetails['created_at']))}} </li>
                                        <li><span class="track-address-cont">Total Order Amount:</span>{{\App\CPU\Helpers::currency_converter($orderDetails['order_amount'])}}</li>
                                        <li><span class="track-address-cont">Shipping Method:</span> {{\App\CPU\translate($orderDetails['shipping_type'])}}</li>
                                        <li><span class="track-address-cont">Payment Method:</span> 
                                        {{\App\CPU\translate($orderDetails['payment_method'])}}
                                        </li>
                                        <li><span class="track-address-cont">Order Status:</span>
                                        
                                        {{\App\CPU\translate($orderDetails['order_status'])}}
                                        
                                        <!--@if($orderDetails['order_status']=='failed' || $orderDetails['order_status']=='canceled')-->
                                        <!--        {{\App\CPU\translate($orderDetails['order_status'] =='failed' ? 'Failed To Deliver' : $orderDetails['order_status'])}}-->
                                        <!--@elseif($orderDetails['order_status']=='confirmed' || $orderDetails['order_status']=='processing' || $orderDetails['order_status']=='delivered')-->
                                        <!--        {{\App\CPU\translate($orderDetails['order_status']=='processing' ? 'packaging' : $orderDetails['order_status'])}}-->
                                        <!--@else-->
                                        <!--        {{\App\CPU\translate($orderDetails['order_status'])}}-->
                                        <!--@endif                                        -->
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="traking-sec" style="display:none;">
                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="traking-box">
                                    <h3>Shipping Address</h3>
                                    @if($orderDetails->shippingAddress)
                                        @php($shipping_address=$orderDetails->shippingAddress)
                                    @else
                                        @php($shipping_address=json_decode($orderDetails['shipping_address_data']))
                                    @endif                                    
                                    <h4>{{$shipping_address? $shipping_address->contact_person_name : ''}}</h4>
                                    <p{{$shipping_address ? $shipping_address->city : ''}},{{$shipping_address ? $shipping_address->zip  : ''}}</p>
                                    <p><strong>Phone:</strong> {{$shipping_address ? $shipping_address->phone  : ''}}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="traking-box">

                                    @if($orderDetails->billingAddress)
                                        @php($billing=$orderDetails->billingAddress)
                                    @else
                                        @php($billing=json_decode($orderDetails['billing_address_data']))
                                    @endif                                    
                                    <h3>Billing Address</h3>
                                    <h4>{{$billing ? $billing->contact_person_name : ''}}</h4>
                                    <p>{{$billing ? $billing->city : ''}},{{$billing ? $billing->zip  : ''}}</p>
                                    <p><strong>Phone:</strong> {{$billing ? $billing->phone  : ''}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
   
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="traking-details">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="traking-details-cont">
                                    @php( $totalTax = 0)
                
                                    @php($sub_total=0)
                                    @php($total_tax=0)
                                    @php($total_shipping_cost=0)
                                    @php($total_discount_on_product=0)
                                    @php($extra_discount=0)
                                    @php($coupon_discount=0)
                                    @foreach($order as $product)
                                        @php($productDetails = App\Model\Product::where('id', $product->product_id)->first())



                                    <div class="traking-details-item">
                                        <div class="traking-details-item-img">
                                            <a href="{{route('frontend.product_details',$productDetails->slug)}}">
                                            <img src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$productDetails['thumbnail']}}" alt="product-image" >
                                            </a>
                                        </div>
                                        <div class="traking-details-item-text">
                                            <h5 class="product-title">{{$productDetails['name']}}</h5>
                                            @if($product['variation'])
                                                @foreach(json_decode($product['variation'],true) as $key1 =>$variation)
                                                    <p>{{$key1}}: <span> {{$variation}}</span></p>
                                                @endforeach
                                            @endif                                            
                                            <div class="traking-details-item-p-box">
                                               <div class="traking-details-item-price">
                                                   <span>Price</span><p>{{\App\CPU\Helpers::currency_converter($product['price'])}}</p>
                                                 
                                               </div>
                                               <div class="traking-details-qty">
                                                   <span>{{ \App\CPU\translate('Quantity')}}</span>
                                                  <p> {{$product['qty']}}</p>
                                                  
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                        @php($sub_total+=$product['price']*$product['qty'])
                                        @php($total_tax+=$product['tax'])
                                        @php($total_discount_on_product+=$product['discount'])
                                    @endforeach
                
                                    @php($total_shipping_cost=$orderDetails['shipping_cost'])
                
                                    <?php
                                            if ($orderDetails['extra_discount_type'] == 'percent') {
                                                $extra_discount = ($sub_total / 100) * $orderDetails['extra_discount'];
                                            } else {
                                                $extra_discount = $orderDetails['extra_discount'];
                                            }
                                            if(isset($orderDetails['discount_amount'])){
                                                $coupon_discount =$orderDetails['discount_amount'];
                                            }
                                        ?>                                     
                                    

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="traking-details-cont">
                                    <div class="history-tl-container">
                                      <ul class="tl">
                                        @if ($orderDetails['order_status']!='returned' && $orderDetails['order_status']!='failed')
                                        <li class="tl-item" ng-repeat="item in retailer_history">
                                            <i class="fa-solid fa-check"></i>
                                          <div class="timestamp">
                                            {{date('d M Y',strtotime($orderDetails['created_at']))}}  
                                            <br> {{date('H:i:s',strtotime($orderDetails['created_at']))}}
                                          </div>
                                          <div class="item-title">{{ \App\CPU\translate($orderDetails['order_status'])}}</div>
                                          <div class="item-detail">{{ \App\CPU\translate('First step')}}</div>
                                        </li>
                                            @php($oderHistory = \App\Model\OrderStatusHistory::where('order_id', $orderDetails['id'])->whereIn('status',  array('processing','processed','delivered'))->orderby('id','DESC')->first())
                                            @if(!empty($oderHistory['created_at']))

                                                <li class="tl-item" ng-repeat="item in retailer_history">
                                                @if(($orderDetails['order_status']=='processing') || ($orderDetails['order_status']=='processed') || ($orderDetails['order_status']=='delivered'))
                                                    <i class="fa-solid fa-check"></i>
                                                @endif                                            
                                                  <div class="timestamp">
                                                    @php($oderHistory = \App\Model\OrderStatusHistory::where('order_id', $orderDetails['id'])->whereIn('status',  array('processing','processed','delivered'))->orderby('id','DESC')->first())
                                                        @if(!empty($oderHistory['created_at']))
                                                        {{date('d M Y',strtotime($oderHistory['created_at']))}}  
                                                        <br> {{date('H:i:s',strtotime($oderHistory['created_at']))}}
                                                        @else
                                                        <br> 
                                                        @endif                    
                                                    </div>
                                                  <div class="item-title">{{ \App\CPU\translate('Packaging order')}}</div>
                                                  <div class="item-detail">{{ \App\CPU\translate('Second step')}}</div>
                                                </li>
                                            @endif

                                            @php($oderHistory = \App\Model\OrderStatusHistory::where('order_id', $orderDetails['id'])->whereIn('status',  array('processed','delivered'))->orderby('id','DESC')->first())
                                            @if(!empty($oderHistory['created_at']))
                                                <li class="tl-item" ng-repeat="item in retailer_history">
                                                @if(($orderDetails['order_status']=='processed') || ($orderDetails['order_status']=='delivered'))
                                                    <i class="fa-solid fa-check"></i>
                                                @endif
                                                  <div class="timestamp">
                                                    @php($oderHistory = \App\Model\OrderStatusHistory::where('order_id', $orderDetails['id'])->whereIn('status',  array('processed','delivered'))->orderby('id','DESC')->first())
                                                        @if(!empty($oderHistory['created_at']))
                                                        {{date('d M Y',strtotime($oderHistory['created_at']))}}  
                                                        <br> {{date('H:i:s',strtotime($oderHistory['created_at']))}}
                                                        @else
                                                        <br> 
                                                        @endif                                             
                                                  </div>
                                                  <div class="item-title">{{ \App\CPU\translate('Preparing Shipment')}}</div>
                                                  <div class="item-detail">{{ \App\CPU\translate('Third step')}}</div>
                                                </li>
                                            @endif                                             
                                            @php($oderHistory = \App\Model\OrderStatusHistory::where('order_id', $orderDetails['id'])->whereIn('status',  array('delivered'))->orderby('id','DESC')->first())
                                                @if(!empty($oderHistory['created_at']))
                                        
                                                <li class="tl-item" ng-repeat="item in retailer_history">
                                                @if(($orderDetails['order_status']=='delivered'))
                                                    <i class="fa-solid fa-check"></i>
                                                @endif
                                                  <div class="timestamp">
                                                    @php($oderHistory = \App\Model\OrderStatusHistory::where('order_id', $orderDetails['id'])->whereIn('status',  array('delivered'))->orderby('id','DESC')->first())
                                                        @if(!empty($oderHistory['created_at']))
                                                        {{date('d M Y',strtotime($oderHistory['created_at']))}}  
                                                        <br> {{date('H:i:s',strtotime($oderHistory['created_at']))}}
                                                        @else
                                                        <br> 
                                                        @endif                                             
                                                  </div>
                                                  <div class="item-title">{{ \App\CPU\translate('Order Shipped')}}</div>
                                                  <div class="item-detail">{{ \App\CPU\translate('Fourth step')}}</div>
                                                </li>
                                            @endif
                                        @elseif($orderDetails['order_status']=='returned')
                                            <li class="tl-item" ng-repeat="item in retailer_history">
                                                <h1 class="text-warning">{{ \App\CPU\translate('Product Successfully Returned')}}</h1>
                                            </li>                                        
                                        @else
                                            <li class="tl-item" ng-repeat="item in retailer_history">
                                                <h1 class="text-danger">{{ \App\CPU\translate("Sorry we can`t complete your order")}}</h1>
                                            </li>                                        
                                        @endif

                                      </ul>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Page Title (Dark)-->
    <div class="container" style="display:none">

        <div class="pt-3 pb-3">
            <h2>{{ \App\CPU\translate('My Order')}}</h2>
        </div>
        <div class="btn--primary">
            <div class="container d-lg-flex justify-content-between py-2 py-lg-3">

                <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                    <h4 class="text-light mb-0">{{ \App\CPU\translate('Order ID')}} : <span
                            class="h4 font-weight-normal text-light">{{$orderDetails['id']}}</span></h4>
                </div>
            </div>
        </div>

    </div>
    <!-- Page Content-->
    
    
    <div class="container mb-md-3" style="display:none">
        <!-- Details-->
        <div class="row" style="background: #e2f0ff; margin: 0; width: 100%;">
            <div class="col-sm-4">
                <div class="pt-2 pb-2 text-center rounded-lg">
                    <span class="font-weight-medium text-dark mr-2">{{ \App\CPU\translate('Order Status')}}:</span><br>
                    <span class="text-uppercase ">
                        @if($orderDetails['order_status'] =='processing')
                            {{ 'Packaging' }}
                        @elseif($orderDetails['order_status'] =='failed')
                            {{ 'Failed to Deliver' }}
                        @else
                            {{ $orderDetails['order_status'] }}
                        @endif
                    </span>
                    {{-- <span class="text-uppercase ">Courier</span> --}}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="pt-2 pb-2 text-center rounded-lg">
                    <span class="font-weight-medium text-dark mr-2">{{ \App\CPU\translate('Payment Status')}}:</span> <br>
                    <span class="text-uppercase">{{$orderDetails['payment_status']}}</span>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="pt-2 pb-2 text-center rounded-lg">
                    <span class="font-weight-medium text-dark mr-2"> {{ \App\CPU\translate('Estimated Delivary Date')}}: </span> <br>
                    <span class="text-uppercase"
                          style="font-weight: 600; color: {{$web_config['primary_color']}}">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$orderDetails['updated_at'])->format('Y-m-d')}}</span>
                </div>
            </div>
        </div>
        <!-- Progress-->
        <div class="card border-0 box-shadow-lg mt-5">
            <div class="card-body pb-2">
                <ul class="nav nav-tabs media-tabs nav-justified">
                    @if ($orderDetails['order_status']!='returned' && $orderDetails['order_status']!='failed')

                        <li class="nav-item">
                            <div class="nav-link">
                                <div class="align-items-center">
                                    <div class="media-tab-media"
                                         style="margin: 0 auto; background: #4bcc02; color: white;">
                                        <i class="czi-check"></i>
                                    </div>
                                    <div class="media-body" style="text-align: center;">
                                        <div class="media-tab-subtitle text-muted font-size-xs mb-1">{{ \App\CPU\translate('First step')}}</div>
                                        <h6 class="media-tab-title text-nowrap mb-0">{{ \App\CPU\translate('Order placed')}}</h6>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item ">
                            <div class="nav-link ">
                                <div class="align-items-center">
                                    <div class="media-tab-media"
                                         style="margin: 0 auto; @if(($orderDetails['order_status']=='processing') || ($orderDetails['order_status']=='processed') || ($orderDetails['order_status']=='delivered')) background: #4bcc02; color: white; @endif ">
                                        @if(($orderDetails['order_status']=='processing') || ($orderDetails['order_status']=='processed') || ($orderDetails['order_status']=='delivered'))
                                            <i class="czi-check"></i>
                                        @endif
                                    </div>
                                    <div class="media-body" style="text-align: center;">
                                        <div class="media-tab-subtitle text-muted font-size-xs mb-1">{{ \App\CPU\translate('Second step')}}</div>
                                        <h6 class="media-tab-title text-nowrap mb-0">{{ \App\CPU\translate('Packaging order')}}</h6>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item">
                            <div class="nav-link  ">
                                <div class="align-items-center">
                                    <div class="media-tab-media"
                                         style="margin: 0 auto; @if(($orderDetails['order_status']=='processed') || ($orderDetails['order_status']=='delivered')) background: #4bcc02; color: white; @endif ">
                                        @if(($orderDetails['order_status']=='processed') || ($orderDetails['order_status']=='delivered'))
                                            <i class="czi-check"></i>
                                        @endif
                                    </div>
                                    <div class="media-body" style="text-align: center;">
                                        <div class="media-tab-subtitle text-muted font-size-xs mb-1">{{ \App\CPU\translate('Third step')}}</div>
                                        <h6 class="media-tab-title text-nowrap mb-0">{{ \App\CPU\translate('Preparing Shipment')}}</h6>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item">
                            <div class="nav-link ">
                                <div class="align-items-center">
                                    <div class="media-tab-media"
                                         style="margin: 0 auto; @if(($orderDetails['order_status']=='delivered')) background: #4bcc02; color: white; @endif">
                                        @if(($orderDetails['order_status']=='delivered'))
                                            <i class="czi-check"></i>
                                        @endif
                                    </div>
                                    <div class="media-body" style="text-align: center;">
                                        <div class="media-tab-subtitle text-muted font-size-xs mb-1">{{ \App\CPU\translate('Fourth step')}}</div>
                                        <h6 class="media-tab-title text-nowrap mb-0">{{ \App\CPU\translate('Order Shipped')}}</h6>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @elseif($orderDetails['order_status']=='returned')
                        <li class="nav-item">
                            <div class="nav-link" style="text-align: center;">
                                <h1 class="text-warning">{{ \App\CPU\translate('Product Successfully Returned')}}</h1>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <div class="nav-link" style="text-align: center;">
                                <h1 class="text-danger">{{ \App\CPU\translate("Sorry we can`t complete your order")}}</h1>
                            </div>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
        <!-- Footer-->
        <div class="d-sm-flex flex-wrap justify-content-between align-items-center text-center pt-3">
            <div class="custom-control custom-checkbox mt-1 mr-3">
            </div>
            <a class="btn btn--primary btn-sm mt-2 mb-2" href="#order-details" data-toggle="modal">{{ \App\CPU\translate('View Order Details')}}</a>
        </div>
    </div>

@endsection

@push('script')
    <script src="{{asset('public/assets/front-end')}}/vendor/nouislider/distribute/nouislider.min.js"></script>
@endpush