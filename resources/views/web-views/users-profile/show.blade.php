@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('My Quotation List'))

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
            border-bottom: 3px solid {{$web_config['primary_color']}}                                   !important;
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
    @php
    use App\Model\BusinessSetting;
    $company_phone =BusinessSetting::where('type', 'company_phone')->first()->value;
    $company_email =BusinessSetting::where('type', 'company_email')->first()->value;
    $shop_address =BusinessSetting::where('type', 'shop_address')->first()->value;
    $company_name =BusinessSetting::where('type', 'company_name')->first()->value;
    $company_web_logo =BusinessSetting::where('type', 'company_web_logo')->first()->value;
    $company_mobile_logo =BusinessSetting::where('type', 'company_mobile_logo')->first()->value;
    $quotation_contact=DB::table('quotation_contact')->where('quotation_id',$quotation->id)->first();
    $quotation_data=DB::table('quotations')->where('id',$quotation->id)->first();
    if (empty($quotation_contact))
    {
        $quotation_contact=DB::table('users')->where('id',auth('customer')->id())->first();
    }
    $created_info=DB::table('quotations')->where('id',$quotation->id)->first();
    $created_users=DB::table('admins')->where('id',$created_info->user_id)->first();
@endphp
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
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <a class="page-link-order" href="{{ route('account-quotation') }}">
                                            <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'right ml-2' : 'left mr-2'}}"></i>{{\App\CPU\translate('back')}}
                                        </a>
                                    </div>
                                    @if(sizeof($productIds) > 0)
                                    <div class="col-md-6 mb-4">
                                        <form id="" class="quote-to-cart-form">
                                        @csrf
                                        <input type="hidden" name="id" value="" class="product_id">
                                        <input type="hidden" name="quantity" value="1">
                                        </form>
                                        <a href="javascript:void(0)" class="quo-move-to-cart" onclick="quoteMoveToCart({{json_encode($productIds)}})"><i class="navbar-tool-icon czi-cart"></i> MOVE TO CART</a>
                                    </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-12" >
                                        <div class="view-quotatoin-detail">
                        
                                          @php
                                            if($quotation->quotation_status == 1)
                                                $status = \App\CPU\translate('file.Pending');
                                            else
                                                $status = \App\CPU\translate('file.Sent');
                                           @endphp
                                            <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="float-left">
                                                    <strong>Date: </strong>{!! $quotation->created_at->format('d M Y') !!}<br><strong>
                                                        Quotation No: </strong>{!! $quotation->reference_no !!}<br>
                                                    <!--<strong>Status: </strong>{!! $status !!}<br><br>-->
                                                    <!--Attn:{!! $quotation->customer->f_name !!} {!! $quotation->customer->l_name !!}<br>
                            
                                                    Contact: {!! $quotation->customer->phone !!}<br>
                                                    Email: {!! $quotation->customer->email !!}-->
                                                    <br>
                                                    Attn: {!! $quotation_contact->f_name !!} {!! $quotation_contact->l_name !!}<br>
                            
                                                    Contact: {!! $quotation_contact->phone !!}<br>
                                                    Email: {!! $quotation_contact->email !!}<br>
                                                    <br>
                                                    @if (!empty($quotation->subject))
                                                    Sub: {!! $quotation->subject !!}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="">

                                                    <strong>To:</strong><br>
                                                    {{isset($quotation_contact->company)?$quotation_contact->company:""}}<br>
                                                    
                                                    Address: {{isset($quotation_contact->address)?$quotation_contact->address:""}}</br>


                                                    <!--<br>{!! $quotation->customer->phone !!}<br>{!! $quotation->customer->name !!}<br>-->
                        

                                                    {{-- <strong>To:</strong>
                                                    <br>Name: {!! $quotation_contact->f_name !!} {!! $quotation_contact->l_name !!} 
                                                    <br>Email: {!! $quotation_contact->email !!}
                                                    <br>Company: {!! $quotation_contact->company !!}
                                                    <br>Phone: {!! $quotation_contact->phone !!}
                                                    <br>Address: {!! $quotation_contact->address !!} --}}

                                                </div>
                                            </div>
                                            </div>
                                        </div>
                        
                                        <div class="card-body view-show-card">
                                            <table class="table table-bordered product-quotation-list mobile-table">
                                                <thead>
                                                <tr><th>#</th>
                                                    <th>Product</th>
                                                    <th>Qty</th>
                                                    <th>Unit Price</th>
                                                    @if($quotation_data->is_vat==1)
                                                    <th>Vat</th>
                                                    <th>Unit Vat Amoun</th>
                                                    <th>Unit Price(With Vat)</th>
                                                    <th>Total Price</th>
                                                   @else
                                                    <th>Total Price</th>
                                                     @endif
                                                </tr></thead>
                        
                                                <tbody>
                                                @php
                                                $grand_total=0;
                                                $total_vat=0;
                                                $quote_vat=0;
                                                @endphp
                                                @if(count($quotation->productQuotations))
                                                    @foreach($quotation->productQuotations as $key => $pro)
					@php
                                   	 if($pro->discount_type=='percent')
                                    	{
                                    	    $discount=($pro->net_unit_price*($pro->discount/100));
                                    	}
                                    	else{
                                        	$discount=$pro->discount;
                                    	}
                                        
                                	@endphp
                                                <tr>
                                                    <td><strong>{!! $key+1 !!}</strong></td>
                                                    <td>{!! $pro->product->name !!}</td>
                                                    <td>{!! $pro->qty !!} pc</td>
                                                    <td>{{App\CPU\Helpers::currency_converter($pro->net_unit_price-$pro->discount)}}<!--{!! $pro->net_unit_price !!}--></td>
                                                     @if($quotation_data->is_vat==1)
                                                    <td>{!! $pro->vat_rate !!} %</td>
                                                    <td>TK.{!! $pro->single_unit_vat !!}</td>
                                                    <td>TK.{!! $pro->single_unit_price_vat !!}</td>
                                                    <td>Tk.{!! round((($pro->total+($pro->single_unit_vat*$pro->qty))-($discount*$pro->qty)),2) !!}</td>
                                                    @else
                                                     <td>Tk.{!! round(($pro->total-($discount*$pro->qty)),2) !!}</td>
                                                     @endif
                                                </tr>
                                                 @php
                                                       $grand_total+= round(($pro->total-($discount*$pro->qty)),2);
                                                        $quote_vat +=($pro->single_unit_vat*$pro->qty) ; 
                                                    @endphp
                                                    @endforeach
                                                @endif
                                                @php
                                                $total_vat=0;
                                                    if($quotation->is_vat == 1)
                                                    {
                                                        $total_vat=$quote_vat;
                                                    }
                                                 @endphp
                                              
                                                <tr>
                                                    <td <?php if($quotation_data->is_vat==1){echo 'colspan="7"';}else{echo 'colspan="4"';}?>><strong>Total:</strong></td>
                                                    <!--<td>{!! $quotation->total_tax !!}</td>-->
                                                    <!--<td>{!! $quotation->total_discount !!}</td>-->
                                                    <td >{{App\CPU\Helpers::currency_converter($grand_total + $total_vat)}}</td>
                                                </tr>

                                                {{-- @if($quotation->order_tax>0)
                                                <tr>
                                                    <td colspan="4"><strong>Order Tax:</strong></td>
                                                    <td><!--{!! $quotation->order_tax !!}--></td>
                                                </tr>
                                                @endif
                                                @if($quotation->order_discount>0)
                                                <tr>
                                                    <td colspan="4"><strong>Order Discount:</strong></td>
                                                    <td><!--{!! $quotation->order_discount ?? 0 !!}--></td>
                                                </tr>
                                                @endif
                                                @if($quotation->shipping_cost>0)
                                                <tr>
                                                    <td colspan="4"><strong>Shipping Cost:</strong></td>
                                                    <td><!--{!! $quotation->shipping_cost ?? 0 !!}--></td>
                                                </tr>
                                                @endif --}}
                                                <!--<tr>
                                                    <td colspan="4"><strong>Grand Total:</strong></td>
                                                    <td>{!! $quotation->grand_total ?? 0 !!}</td>
                                                </tr>-->
                                                </tbody>
                                            </table>
                                        </div>
                        
                                        
                                        <div class="" style="overflow: hidden;margin: 0px 20px;">
                                            
                                                                
                                            @php
                                            $quotation_info=\App\Model\BusinessSetting::where('type','quotation_remarks')->first();
                                            if($quotation_info != null ) $quotation_remarks=$quotation_info->value;
                                            $quotation_info1=\App\Model\BusinessSetting::where('type','quotation_remarks_1')->first();
                                            if($quotation_info1 != null ) $quotation_remarks_1=$quotation_info1->value;
                                            @endphp
                                                 <b>TERMS & CONDITIONS: </b>
                                                <p>
                                                @if($total_vat>0)
                                                     {!! $quotation_remarks !!}
                                                @else
                                                    {!! $quotation_remarks_1 !!}
                                                @endif
                                        </div>
                                        <div class="" style="overflow: hidden;margin: 10px 20px;">
                                            
                                            @if ($created_info->user_id==1)
                                                <strong>Created By:</strong> {{$created_users->name}}
                                            @else
                                                <strong>Created By:</strong> {!! $quotation->customer->f_name ?? ' ' !!}
                                            @endif
                                            
                                            <!--{!! $quotation->customer->email ?? ' ' !!}-->
                                            <br>
                                        </div>
                                    </div>
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
        
        function quoteMoveToCart(product_ids){
            var products = JSON.parse(JSON.stringify(product_ids));
            for (var i = 0; i < products.length; i++) {
                $('.quote-to-cart-form').attr("id", "add-to-cart-form-"+products[i]);
                $('.product_id').val(products[i]);
                addToCart(products[i]);
            }
        }
    </script>
@endpush