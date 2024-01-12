@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Quotations'))

@push('css_or_js')

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
$quotation_info=DB::table('quotation_contact')->where('quotation_id',$quotation->id)->first();
$quotation_data=DB::table('quotations')->where('id',$quotation->id)->first();
if(empty($quotation_info))
{
    $quotation_contact=DB::table('quotations')
                        ->join('users','quotations.customer_id','users.id')
                        ->leftJoin('shipping_addresses', function($join)
                            {
                                $join->on('shipping_addresses.customer_id', '=', 'quotations.customer_id');
                                $join->on('shipping_addresses.is_billing', '=', DB::raw("1"));
                            })
                        ->select('users.f_name','users.l_name','users.phone','users.email'
                        ,'shipping_addresses.company_name as company','shipping_addresses.address')
                        ->where('quotations.id',$quotation->id)->first();
}
else{
    $quotation_contact=$quotation_info;
}

$created_info=DB::table('quotations')->where('id',$quotation->id)->first();
$created_users=DB::table('admins')->where('id',$created_info->user_id)->first();
@endphp
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page"><a
                        href="{{route('admin.quotation.list')}}">{{\App\CPU\translate('Quotations')}}</a>
                </li>
                <li class="breadcrumb-item">{{\App\CPU\translate('View')}} </li>
            </ol>
        </nav>

        <!-- Content Row -->
        <div class="row">
            <div class="card col-md-12" >
                <div class="card-header">

                  @php
                    if($quotation->quotation_status == 1)
                        $status = \App\CPU\translate('file.Pending');
                    else
                        $status = \App\CPU\translate('file.Sent');
                   @endphp

                    <div class="col-md-6">
                        <div class="float-left">
                            <strong>Date: </strong>{!! $quotation->created_at->format('d M Y') !!}<br><strong>
                                Quotation No: </strong>{!! $quotation->reference_no !!}<br>
                            <br>
                            Attn: {!! isset($quotation_contact->f_name) ? $quotation_contact->f_name : ' ' !!} {!! isset($quotation_contact->l_name) ? $quotation_contact->l_name : '' !!}<br>

                            Contact: {!! isset($quotation_contact->phone) ? $quotation_contact->phone : '' !!}<br>
                            Email: {!! isset($quotation_contact->email) ? $quotation_contact->email : '' !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="">
                            <strong>To:</strong><br>
                            {{isset($quotation_contact->company) ? $quotation_contact->company : ' '}}<br>

                            Address: {{isset($quotation_contact->address) ? $quotation_contact->address : ' '}}</br>

                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <table class="table table-bordered product-quotation-list">
                        <thead>
                        <tr><th>#</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            @if($quotation_data->is_vat==1)
                            <th>Vat</th>
                            <th>Unit Vat Amount</th>
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
                            @php
                                $i=1;
                            @endphp
                            @foreach($quotation->productQuotations as $pro)
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
                            <td><strong>{{$i++}}</strong></td>
                            <td>{!! isset($pro->name)?$pro->name:$pro->product->name !!}
                            </br>
                            <strong> ID: </strong> {!! $pro->product->id !!}, <strong> SKU: </strong> {!! isset($pro->code)?$pro->code:$pro->product->code !!}
                            </td>
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
                            $grand_total += round(($pro->total-($discount*$pro->qty)),2);
                            $quote_vat +=($pro->single_unit_vat*$pro->qty) ; 
                         @endphp
                            @endforeach
                        @endif
                        @php
                                                
                        if($quotation->is_vat == 1)
                        {
                            $total_vat=$quote_vat;
                        }
                     @endphp
                    @if($quotation->shipping_amount>0)
                    <tr>
                        <td <?php if($quotation_data->is_vat==1){echo 'colspan="7"';}else{echo 'colspan="4"';}?>><strong>Shipping Fee:</strong></td>
                        <td >{{App\CPU\Helpers::currency_converter($quotation->shipping_amount)}}</td>
                    </tr>
                    @endif
                    <tr>
                        <td <?php if($quotation_data->is_vat==1){echo 'colspan="7"';}else{echo 'colspan="4"';}?>><strong>Total:</strong></td>
                        <!--<td>{!! $quotation->total_tax !!}</td>-->
                        <!--<td>{!! $quotation->total_discount !!}</td>-->
                        <td >{{App\CPU\Helpers::currency_converter($grand_total + $total_vat+$quotation->shipping_amount)}}</td>
                    </tr>
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
                        @if (!empty($quotation->note))
                            <p style="white-space: pre-wrap;overflow-wrap: break-word;">{!! $quotation->note !!}</p> 
                        </br>
                        </br>
                        <strong>NB:</strong>Trams & conditions added by admin
                        @else
                        {!! $quotation_remarks !!}
                        @endif
                    @else
                        @if (!empty($quotation->note))
                           <p style="white-space: pre-wrap;overflow-wrap: break-word;">{!! $quotation->note !!}</p> 
                        @else
                            {!! $quotation_remarks_1 !!}
                        @endif
                    @endif
                    </p>
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


@endsection

@push('script')

@endpush