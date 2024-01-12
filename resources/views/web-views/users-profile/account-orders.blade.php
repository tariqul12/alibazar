@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('My Order List'))

@push('css_or_js')
    <style>
        .widget-categories .accordion-heading > a:hover {
            color: #FFD5A4 !important;
        }

        .widget-categories .accordion-heading > a {
            color: #FFD5A4;
        }

        body {
            font-family: 'Titillium Web', sans-serif;
        }

        .card {
            border: none
        }

        .totals tr td {
            font-size: 13px
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .spandHeadO {
            color: #000 !important;
            font-weight: 600 !important;
            font-size: 14px;

        }

        .tdBorder {
            border- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 1px solid #f7f0f0;
            text-align: center;
        }

        .bodytr {
            text-align: center;
            vertical-align: middle !important;
        }

        .sidebar h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}} !important;
            transition: .2s ease-in-out;
        }

        tr td {
            padding: 10px 8px !important;
        }

        td button {
            padding: 3px 13px !important;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{$web_config['primary_color']}};
            }

            .orderDate {
                display: none;
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }
        
        
       
    </style>
@endpush

@section('content')

  <!--  <div class="container rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9 mt-2 sidebar_heading">
                
            </div>
        </div>
    </div>-->

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <!-- Sidebar-->
        
        <!-- Content  -->
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
                                        <h1 class="h3 float-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} headerTitle">{{\App\CPU\translate('my_order')}}</h1>
                                        <div class="dash-view-right" style="overflow: auto;padding:20px">
                                        <div class="">
                                        @foreach($orders as $key=>$order)    
                                        @php($OrderDetail = \App\Model\OrderDetail::where('order_id', $order->id)->get())
                                            <div class="accordion" >
                                              <div class="answer-group">
                                                  <div class="t-order-item-box">
                                                    <div class="t-sec">
                                                        <div class="t-sec-item">
                                                            <div class="t-order-item">
                                                                <p>Order No.{{$order['id']}} <span style="font-size: 12px;">({{count($OrderDetail)}} Item)</span></p>
                                                            </div>
                                                        </div>
                                                        <div class="t-sec-item">
                                                            <div class="t-order-date">
                                                                <p>Order Date: {{date('d M Y',strtotime($order['created_at']))}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="t-sec-item">
                                                            <div class="t-po-number1">
                                                                <p>Status: 
                                                                    @if($order['order_status']=='failed' || $order['order_status']=='canceled')
                                                                            {{\App\CPU\translate($order['order_status'] =='failed' ? 'Failed To Deliver' : $order['order_status'])}}
                                                                    @elseif($order['order_status']=='confirmed' || $order['order_status']=='processing' || $order['order_status']=='delivered')
                                                                            {{\App\CPU\translate($order['order_status']=='processing' ? 'packaging' : $order['order_status'])}}
                                                                    @else
                                                                            {{\App\CPU\translate($order['order_status'])}}
                                                                    @endif
                                                                </p>                            
                                                            </div>
                                                        </div>
                                        
                                                        <div class="t-sec-item ">
                                                            <div class="t-po-number">
                                                                <p>PO Number :@if(!empty($order['purchase_order_no'])) {{$order['purchase_order_no']}} @endif</p>
                                                               @if(empty($order['purchase_order_no']))
                                                                <div class="input-group table-pio" >
                                                                  <input type="text" class="form-control" id="po_number{{$order['id']}}"style="border-radius: 0px;">
                                                                  <button class="btn t-op-btn" type="button" id="button-addon2" onclick="purchaseNoAdd('{{$order['id']}}')">Add</button>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="t-sec-item">
                                                            <div class="t-order-amount">
                                                                <p>Amount: <strong> {{\App\CPU\Helpers::currency_converter($order['order_amount'])}}</strong></p>
                                                            </div>
                                                        </div>
                                                        <div class="t-sec-item-collapse">
                                                            <span class="collapsed"  data-toggle="collapse" data-target="#collapse-{{$key}}" aria-expanded="true" aria-controls="collapse-{{$key}}"><i class="fa fa-angle-down"></i></span>
                                                        </div>
                                                    </div>
                                                   </div>
                                                   
                                                <div id="collapse-{{$key}}" class="collapse t-collapse"  >
                                                  <div class="card-body">
                                                    <table class="table table-borderless">
                                                       <tbody>
                                                    @foreach($OrderDetail as $product)
                                                        @php($productDetails = App\Model\Product::where('id', $product->product_id)->first())
                                        
                                                          <tr class="tm-grid">
                                                             <td class="">
                                                                <img class="d-block" onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'" src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{ $productDetails['thumbnail'] ?? '' }}" alt="VR Collection" width="60">
                                                             </td>
                                                             <td class="for-glaxy-name">
                                                                <p>{{$productDetails['name'] ?? ''}}</p>
                                                                @if($product['variation'])
                                                                    @foreach(json_decode($product['variation'],true) as $key1 =>$variation)
                                                                        <p>{{$key1}}: <span> {{$variation}}</span></p>
                                                                    @endforeach
                                                                @endif                         
                                                             </td>
                                                             <td>
                                                                <p>Qty: {{($product['qty'])}}</p>
                                                             </td>
                                                             <td>
                                                                <p>Discount: {{\App\CPU\Helpers::currency_converter($product['discount'])}}</p>
                                                             </td>
                                                             <td>
                                                                <div class="text-right">
                                                                   <span class="t-cancle">Price:{{\App\CPU\Helpers::currency_converter($product['price'])}} </span>
                                                                </div>
                                                             </td>
                                                             <!--<div class="col-md-4">
                                                                </div>-->
                                                             <td>
                                                             </td>
                                                             <td>
                                                             </td>
                                                          </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="6">
                                                        <div class="justify-content mt-4 for-mobile-glaxy ">
                                                            <a href="{{ route('account-order-details', ['id'=>$order->id]) }}" class="btn-view">
                                                                <i class="fa fa-eye"></i> {{\App\CPU\translate('view')}}
                                                            </a>                    
                                                            @if($order->payment_method=='cash_on_delivery' && $order->order_status=='pending')
                                                            <a href="javascript:"
                                                                onclick="route_alert('{{ route('order-cancel',[$order->id]) }}','{{\App\CPU\translate('want_to_cancel_this_order?')}}')"
                                                                class="order-cancle">
                                                                <i class="fa fa-trash"></i> {{\App\CPU\translate('cancel')}}
                                                            </a>
                                                            @endif
                                                            <a href="{{route('generate-invoice',[$order->id])}}" class="btn-generate-invoice for-glaxy-mobile">
                                                                {{\App\CPU\translate('generate_invoice')}}
                                                            </a>
                                                            <a class="btn-track-order" type="button"
                                                               href="{{route('track-order.result',['order_id'=>$order['id'],'from_order_details'=>1])}}"
                                                               style="color: white">
                                                                {{\App\CPU\translate('Track')}} {{\App\CPU\translate('Order')}}
                                                            </a>
                                        
                                                        </div>
                                                            
                                                        </td>
                                                    </tr>
                                                       </tbody>
                                                    </table>
                                                  </div>
                                                  <div class="card-footer">
                                                      <div class="collapse-footer-cont">
                                                          <div class="collapse-footer-item1">
                                                              <div class="t-order-date">
                                                                <p>Order Date: {{date('d M Y',strtotime($order['created_at']))}}</p>
                                                            </div>
                                                          </div>
                                                          <div class="collapse-footer-item2">
                                                              <div class="t-order-amount">
                                                                <p>Amount: <strong> {{\App\CPU\Helpers::currency_converter($order['order_amount'])}}</strong></p>
                                                            </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                                </div>
                                                
                                                
                                                
                                              </div>
                                            </div>
                                        @endforeach    
                                            
                                        </div>
                                           
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
        function cancel_message() {
            toastr.info('{{\App\CPU\translate('order_can_be_canceled_only_when_pending.')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
        function purchaseNoAdd(order_id){
            var po_number = $("#po_number" + order_id).val();
            if (po_number=='') {
                toastr.error('{{ \App\CPU\translate('Please_input_PO_number') }}');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{{ route('order_po_add') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    order_id: order_id,
                    po_number: po_number
                },
                success: function(response) {
                    location.reload();
                }
            });
        }
    </script>
@endpush
