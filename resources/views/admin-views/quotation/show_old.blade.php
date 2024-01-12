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
$quotation_contact=DB::table('quotation_contact')->where('quotation_id',$quotation->id)->first();
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
                            Attn: {!! $quotation_contact->f_name !!} {!! $quotation_contact->l_name !!}<br>
    
                            Contact: {!! $quotation_contact->phone !!}<br>
                            Email: {!! $quotation_contact->email !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="">
                            <strong>To:</strong><br>
                            {{$quotation_contact->company}}<br>

                            Address: {{$quotation_contact->address}}</br>

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
                            <th>SubTotal</th>
                        </tr></thead>

                        <tbody>
                        @if(count($quotation->productQuotations))
                            @foreach($quotation->productQuotations as $pro)
                        <tr>
                            <td><strong>{!! $pro->product_id !!}</strong></td>
                            <td>{!! $pro->product->name !!}</td>
                            <td>{!! $pro->qty !!} pc</td>
                            <td>{!! App\CPU\Helpers::currency_converter($pro->net_unit_price) !!}</td>
                            <td>{!! $pro->total !!}</td>
                        </tr>
                            @endforeach
                        @endif
                        <tr>
                            <td colspan="4"><strong>Total:</strong></td>
                         
                            <td>{!! App\CPU\Helpers::currency_converter($quotation->total_price) !!}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
  
                <div class="" style="overflow: hidden;margin: 0px 20px;">
                    @php
                    $quotation_info=\App\Model\BusinessSetting::where('type','quotation_remarks')->first();
                    if($quotation_info != null ) $quotation_remarks=$quotation_info->value;                                            
                    @endphp
                    <b>TERMS & CONDITIONS: </b>
                    <p>
                    {!! $quotation_remarks !!}
                    </p>
            </div>
                <div class="" style="overflow: hidden;margin: 10px 20px;">
                    <p>
                        <strong>Note:</strong>

                        {!! $quotation->note !!}

                    </p>
                    <strong>Created By:</strong> {!! $quotation->customer->f_name ?? ' ' !!}
                    <!--{!! $quotation->customer->email ?? ' ' !!}-->
                    <br>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('script')

@endpush
