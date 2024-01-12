@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Order Details'))

@push('css_or_js')
    <style>
        .page-item.active .page-link {
            background-color: {{$web_config['primary_color']}}              !important;
        }

        .page-item.active > .page-link {
            box-shadow: 0 0 black !important;
        }

        .widget-categories .accordion-heading > a:hover {
            color: #FFD5A4 !important;
        }

        .widget-categories .accordion-heading > a {
            color: #FFD5A4;
        }

        body {
            font-family: 'Titillium Web', sans-serif
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
            color: #000;
            font-weight: 900;
            font-size: 13px;

        }

        .spandHeadO {
            color: #000 !important;
            font-weight: 400;
            font-size: 13px;

        }

        .font-name {
            font-weight: 600;
            font-size: 12px;
            color: #030303;
        }

        .amount {
            font-size: 15px;
            color: #030303;
            font-weight: 600;
            margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 60px;

        }

       /* a {
            color: {{$web_config['primary_color']}};
            cursor: pointer;
            text-decoration: none;
            background-color: transparent;
        }

        a:hover {
            cursor: pointer;
        }*/

        @media (max-width: 600px) {
            .sidebar_heading {
                background: #1B7FED;
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }

        @media (max-width: 768px) {
            .for-tab-img {
                width: 100% !important;
            }

            .for-glaxy-name {
                display: none;
            }
        }

        @media (max-width: 360px) {
            .for-mobile-glaxy {
                display: flex !important;
            }

            .for-glaxy-mobile {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 6px;
            }

            .for-glaxy-name {
                display: none;
            }
        }

        @media (max-width: 600px) {
            .for-mobile-glaxy {
                display: flex !important;
            }

            .for-glaxy-mobile {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 6px;
            }

            .for-glaxy-name {
                display: none;
            }

            .order_table_tr {
                display: grid;
            }

            .order_table_td {
                border-bottom: 1px solid #fff !important;
            }

            .order_table_info_div {
                width: 100%;
                display: flex;
            }

            .order_table_info_div_1 {
                width: 34%;
            }

            .order_table_info_div_2 {
                width: 66%;
                text-align: left!important;
            }

            .spandHeadO {
                font-size: 13px;
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 16px;
            }

            .spanTr {
                font-size: 13px;
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 16px;
                margin-top: 10px;
            }

            .amount {
                font-size: 13px;
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 0px;

            }

        }
       /* .generate-invoice{
             padding: 0.625rem 1.375rem!important;
        }  */ 
    </style>
@endpush

@section('content')
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">

            {{-- Content --}}
            <section class="col-lg-12 col-md-12">
                 <div class="j-dashborder-border">
                     <h2 class="desk-account">My Account</h2>
                  <div id="navbar-wrapper">
                    <nav class="navbar navbar-inverse">
                        <div class="navbar-header">
                          <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
                        </div>
                    </nav>
                    <h2 class="mobile-account">My Account</h2>
                  </div>
                <div class="j-flex">

                      <aside id="wrapper">
                         @include('web-views.partials._profile-aside')
                      </aside>
                    
                      
                      <section id="content-wrapper">
                          <div class="row">
                            <div class="col-lg-12">
                <div class="card box-shadow-sm dash-right-side">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <a class="page-link-order" href="{{ route('account-oder') }}">
                            <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'right ml-2' : 'left mr-2'}}"></i>{{\App\CPU\translate('back')}}
                        </a>
                    </div>
                </div>


                <div class="card box-shadow-sm">
                    @if(\App\CPU\Helpers::get_business_settings('order_verification'))
                        <div class="card-header">
                            <h4>{{\App\CPU\translate('order_verification_code')}} : {{$order['verification_code']}}</h4>
                        </div>
                    @endif
                    <div class="payment mb-3 ">
                        @if(isset($order['seller_id']) != 0)
                            @php($shopName=\App\Model\Shop::where('seller_id', $order['seller_id'])->first())
                        @endif
                        
                    <div class="row">
                         <div class="col-md-12" >
                            <div class="" style="background:#f7f7f7;overflow:hidden;padding: 15px;margin: 0px 12px;">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                    <div class="float-left">
                                        <strong>Order No: </strong>{{$order->id}}<br>
                                        <strong>Order Date: </strong>{{date('d M, Y',strtotime($order->created_at))}}<br>
                                        <strong>Order Status: </strong> {{\App\CPU\translate($order['order_status'])}} <br>
                                        <strong> Payment Method: </strong> {{\App\CPU\translate($order['payment_method'])}} <br>
                                        </br>
                                        @if (!empty($order->purchase_order_no))
                                        <strong>PO No: </strong>{{$order->purchase_order_no}}<br>
                                        @endif
                                       </br>
                                       @if($order->billingAddress)
                                                @php($billing=$order->billingAddress)
                                            @else
                                                @php($billing=json_decode($order['$billing_address_data']))
                                            @endif
                                            @if (!empty($billing->company_name))
                                            <strong>Company Name: </strong>{{$billing->company_name}}<br>
                                            <strong>Company BIN: </strong>{{$billing->company_bin}}<br>
                                            @endif
                                    </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="">

                                        <strong>Billing Address:</strong><br>
                                        @if($order->billingAddress)
                                                @php($billing=$order->billingAddress)
                                            @else
                                                @php($billing=json_decode($order['$billing_address_data']))
                                            @endif

                                                @if($billing)
                                                Name: {{$billing->contact_person_name}} <br>
                                                Phone: {{$billing->phone}} <br>
                                                Address: {{$billing->address}}, {{$billing->city}} , {{$billing->zip}}

                                                @endif
                                        </br>
                                        </br>
                                        <strong>Shipping Address:</strong><br>
                                        @if($order->shippingAddress)
                                                @php($shipping=$order->shippingAddress)
                                            @else
                                                @php($shipping=json_decode($order['shipping_address_data']))
                                            @endif

                                                @if($shipping)
                                                Name: {{$shipping->contact_person_name}} <br>
                                                Phone: {{$shipping->phone}} <br>
                                                Address: {{$shipping->address}}, {{$shipping->city}} , {{$shipping->zip}}

                                                @endif
                                    </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>


                        <table class="table table-borderless">
                            <tbody>
                            @php($total_discount=0)
                            @foreach ($order->details as $key=>$detail)
                                @php($product=json_decode($detail->product_details,true))
                                <tr class="border-bottom tm-grid">
                                    <div class="row">
                                        <div class="col-md-12"
                                             onclick="location.href='{{route('frontend.product_details',$product['slug'])}}'">
                                            <td class="" style="width:100px;">
                                                <img class="d-block"
                                                     onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                     src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}"
                                                     alt="VR Collection" width="60">
                                            </td>
                                            <td class="">
                                                <a href="{{route('frontend.product_details',[$product['slug']])}}">
                                                    {{isset($product['name']) ? Str::limit($product['name'],40) : ''}}
                                                </a>
                                                @if($detail->refund_request == 1)
                                                    <small> ({{\App\CPU\translate('refund_pending')}}) </small> <br>
                                                @elseif($detail->refund_request == 2)
                                                    <small> ({{\App\CPU\translate('refund_approved')}}) </small> <br>
                                                @elseif($detail->refund_request == 3)
                                                    <small> ({{\App\CPU\translate('refund_rejected')}}) </small> <br>
                                                @elseif($detail->refund_request == 4)
                                                    <small> ({{\App\CPU\translate('refund_refunded')}}) </small> <br>
                                                @endif<br>
                                                @if($detail->variant)
                                                    <span>{{\App\CPU\translate('variant')}} : </span>
                                                    {{$detail->variant}}
                                                @endif
                                            </td>
                                            <td>
                                                <div
                                                    
                                                    <span>{{\App\CPU\translate('qty')}}: {{$detail->qty}}</span>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                                    <span
                                                        class="font-weight-bold amount">{{\App\CPU\Helpers::currency_converter($detail->price-$detail->discount)}} </span>
                                                   

                                                </div>
                                            </td>
                                            
                                        </div>
                                        <!--<div class="col-md-4">
                                            
                                        </div>-->
                                            <?php
                                            $refund_day_limit = \App\CPU\Helpers::get_business_settings('refund_day_limit');
                                            $order_details_date = $detail->created_at;
                                            $current = \Carbon\Carbon::now();
                                            $length = $order_details_date->diffInDays($current);
                                            $review_check=\App\model\Review::where('product_id',$product['id'])->where('customer_id',auth('customer')->id())->first();
                                            ?>
                                        <div class="col-md-2">
                                            <td>
                                                @if($detail->product && $order->payment_status == 'paid' && $detail->product->digital_product_type == 'ready_product')
                                                    <a href="{{ route('digital-product-download', $detail->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" title="{{\App\CPU\translate('Download')}}">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                @elseif($detail->product && $order->payment_status == 'paid' && $detail->product->digital_product_type == 'ready_after_sell')
                                                    @if($detail->digital_file_after_sell)
                                                        <a href="{{ route('digital-product-download', $detail->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" title="{{\App\CPU\translate('Download')}}">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                    @else
                                                        <span class="btn btn-success disabled" data-toggle="tooltip" data-placement="bottom" title="{{\App\CPU\translate('Product_not_uploaded_yet')}}">
                                                            <i class="fa fa-download"></i>
                                                        </span>
                                                    @endif
                                                @endif
                                            </td>
                                        </div>

                                        <div class="col-md-2">
                                            <td>
                                                @if($order->order_type == 'default_type')
                                                    @if($order->order_status=='delivered' && empty($review_check))
                                                        <a href="{{route('submit-review',[$detail->id])}}"
                                                           class="btn btn--primary btn-sm d-inline-block">{{\App\CPU\translate('review')}}</a>

                                                        @if($detail->refund_request !=0)
                                                            <a href="{{route('refund-details',[$detail->id])}}"
                                                               class="btn btn--primary btn-sm d-inline-block w-100">
                                                                {{\App\CPU\translate('refund_details')}}
                                                            </a>
                                                        @endif
                                                        @if( $length <= $refund_day_limit && $detail->refund_request == 0)
                                                            <a href="{{route('refund-request',[$detail->id])}}"
                                                               class="btn btn--primary btn-sm d-inline-block">{{\App\CPU\translate('refund_request')}}</a>
                                                        @endif
                                                        {{--@else
                                                            <a href="javascript:" onclick="review_message()"
                                                            class="btn btn--primary btn-sm d-inline-block w-100">{{\App\CPU\translate('review')}}</a>

                                                            @if($length <= $refund_day_limit)
                                                                <a href="javascript:" onclick="refund_message()"
                                                                    class="btn btn--primary btn-sm d-inline-block">{{\App\CPU\translate('refund_request')}}</a>
                                                            @endif --}}
                                                    @endif
                                                @else
                                                    <label class="badge badge-secondary">
                                                        <a
                                                            class="btn btn--primary btn-sm">{{\App\CPU\translate('pos_order')}}</a>
                                                    </label>
                                                @endif
                                            </td>
                                        </div>
                                    </div>

                                </tr>
                            @php($total_discount+=($detail->discount*$detail->qty))
                            @endforeach
                            @php($summary=\App\CPU\OrderManager::order_summary($order))
                            </tbody>
                        </table>
                        @php($extra_discount=0)
                        <?php
                        if ($order['extra_discount_type'] == 'percent') {
                            $extra_discount = ($summary['subtotal'] / 100) * $order['extra_discount'];
                        } else {
                            $extra_discount = $order['extra_discount'];
                        }
                        ?>
                        @if($order->delivery_type !=null)

                            <div class="p-2">

                                <h4 style="color: #130505 !important; margin:0px;text-transform: capitalize;">{{\App\CPU\translate('delivery_info')}} </h4>
                                <hr>
                                <div class="m-2">
                                    @if ($order->delivery_type == 'self_delivery')
                                        <p style="color: #414141 !important ; padding-top:5px;">

                                            <span style="text-transform: capitalize">
                                                {{\App\CPU\translate('delivery_man_name')}} : {{$order->delivery_man['f_name'].' '.$order->delivery_man['l_name']}}
                                            </span>
                                            {{-- <br>
                                            <span style="text-transform: capitalize">
                                                {{\App\CPU\translate('delivery_man_phone')}} : {{$order->delivery_man['phone']}}
                                            </span> --}}
                                        </p>
                                    @else
                                        <p style="color: #414141 !important ; padding-top:5px;">
                                        <span>
                                            {{\App\CPU\translate('delivery_service_name')}} : {{$order->delivery_service_name}}
                                        </span>
                                            <br>
                                            <span>
                                            {{\App\CPU\translate('tracking_id')}} : {{$order->third_party_delivery_tracking_id}}
                                        </span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if(!empty($order->order_note))
                            <div class="p-2">
                                <strong>{{\App\CPU\translate('order_note')}}:</strong>
                                <hr>
                                <div class="m-2">
                                    <p>
                                        {{$order->order_note}}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{--Calculation--}}
                <div class="row d-flex justify-content-end">
                    <div class="col-md-8 col-lg-5">
                        <table class="table table-striped table-borderless">
                            <tbody class="totals">
                            <tr>
                                <td style="padding: 5px 10px;">
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('Item')}}</span></div>
                                </td>
                                <td style="padding: 5px 20px;">
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>{{$order->details->count()}}</span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding: 5px 10px;"> 
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('Subtotal')}}</span>
                                    </div>
                                </td>
                                <td style="padding: 5px 20px;">
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>{{\App\CPU\Helpers::currency_converter($summary['subtotal']-$total_discount)}}</span>
                                    </div>
                                </td>
                            </tr>
                            @if($summary['total_tax']>0)
                            <tr>
                                <td style="padding: 5px 10px;">
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('tax_fee')}}</span>
                                    </div>
                                </td>
                                <td style="padding: 5px 20px;">
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>{{\App\CPU\Helpers::currency_converter($summary['total_tax'])}}</span>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @if($order->order_type == 'default_type')
                                <tr>
                                    <td style="padding: 5px 10px;">
                                        <div
                                            class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                                class="product-qty ">{{\App\CPU\translate('Delivery')}} {{\App\CPU\translate('Fee')}}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 5px 20px;">
                                        <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                            <span>{{\App\CPU\Helpers::currency_converter($summary['total_shipping_cost'])}}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!--<tr>-->
                            <!--    <td style="padding: 5px 10px;">-->
                            <!--        <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span-->
                            <!--                class="product-qty ">{{\App\CPU\translate('Discount')}} {{\App\CPU\translate('on_product')}}</span>-->
                            <!--        </div>-->
                            <!--    </td>-->
                            <!--    <td style="padding: 5px 20px;">-->
                            <!--        <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">-->
                            <!--            <span>- {{\App\CPU\Helpers::currency_converter($summary['total_discount_on_product'])}}</span>-->
                            <!--        </div>-->
                            <!--    </td>-->
                            <!--</tr>-->
                            @if($order->discount_amount>0)
                            <tr>
                                <td style="padding: 5px 10px;">
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('Coupon')}} {{\App\CPU\translate('Discount')}}</span>
                                    </div>
                                </td>
                                <td style="padding: 5px 20px;">
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>- {{\App\CPU\Helpers::currency_converter($order->discount_amount)}}</span>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @if($order->loyalty_discount>0)
                            <tr>
                                <td style="padding: 5px 10px;">
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('Loyalty')}} {{\App\CPU\translate('Discount')}}</span>
                                    </div>
                                </td>
                                <td style="padding: 5px 20px;">
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>- {{\App\CPU\Helpers::currency_converter($order->loyalty_discount)}}</span>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @if($order->order_type != 'default_type')
                                <tr>
                                    <td style="padding: 5px 10px;">
                                        <div
                                            class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                                class="product-qty ">{{\App\CPU\translate('extra')}} {{\App\CPU\translate('Discount')}}</span>
                                        </div>
                                    </td>

                                    <td style="padding: 5px 20px;">
                                        <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                            <span>- {{\App\CPU\Helpers::currency_converter($extra_discount)}}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <tr class="border-top border-bottom">
                                <td style="padding: 5px 10px;">
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="font-weight-bold">{{\App\CPU\translate('Total')}}</span>
                                    </div>
                                </td>
                                <td style="padding: 5px 20px;;">
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"><span
                                            class="font-weight-bold amount ">{{\App\CPU\Helpers::currency_converter($order->order_amount)}}</span>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="justify-content mt-4 for-mobile-glaxy mb-20">
                    @if($order->payment_method=='cash_on_delivery' && $order->order_status=='pending')
                    <a href="javascript:"
                        onclick="route_alert('{{ route('order-cancel',[$order->id]) }}','{{\App\CPU\translate('want_to_cancel_this_order?')}}')"
                        class="order-cancle">
                        <i class="fa fa-trash"></i> {{\App\CPU\translate('cancel')}}
                    </a>
                    @endif
                    <a href="{{route('generate-invoice',[$order->id])}}" class="d-genaret-invoice">
                        {{\App\CPU\translate('generate_invoice')}}
                    </a>
                    <a class="dashboard-track-order" type="button"
                       href="{{route('track-order.result',['order_id'=>$order['id'],'from_order_details'=>1])}}"
                       style="color: white">
                        {{\App\CPU\translate('Track')}} {{\App\CPU\translate('Order')}}
                    </a>
                </div>
                </div>
                 </div>
                          </div>
                      </section>
                    
                    </div>
                </div>
            </section>
        </div>
    </div>
  <script>
        const $button  = document.querySelector('#sidebar-toggle');
        const $wrapper = document.querySelector('#wrapper');
        
        $button.addEventListener('click', (e) => {
          e.preventDefault();
          $wrapper.classList.toggle('toggled');
        });
</script>
    
    
@endsection


@push('script')
    <script>
        function review_message() {
            toastr.info('{{\App\CPU\translate('you_can_review_after_the_product_is_delivered!')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }

        function refund_message() {
            toastr.info('{{\App\CPU\translate('you_can_refund_request_after_the_product_is_delivered!')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
@endpush

