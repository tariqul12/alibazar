<!doctype html>
<html class="no-js" lang="">

<head>
    <title>Malamal | Home</title>
@php
$quotation_info=\App\Model\BusinessSetting::where('type','quotation_subject')->first();
if($quotation_info != null ) $quotation_subject=$quotation_info->value;

$quotation_info=\App\Model\BusinessSetting::where('type','quotation_note')->first();
if($quotation_info != null ) $quotation_note=$quotation_info->value;

$quotation_info=\App\Model\BusinessSetting::where('type','quotation_remarks')->first();
if($quotation_info != null ) $quotation_remarks=$quotation_info->value;

$quotation_info=\App\Model\BusinessSetting::where('type','quotation_signature')->first();
if($quotation_info != null ) $quotation_signature=$quotation_info->value;

@endphp

    
</head>

<body style="font-family: 'Poppins', sans-serif!important;">
    @php
    use App\Model\BusinessSetting;
    $company_phone =BusinessSetting::where('type', 'company_phone')->first()->value;
    $company_email =BusinessSetting::where('type', 'company_email')->first()->value;
    $shop_address =BusinessSetting::where('type', 'shop_address')->first()->value;
    $company_name =BusinessSetting::where('type', 'company_name')->first()->value;
    $company_web_logo =BusinessSetting::where('type', 'company_web_logo')->first()->value;
    $company_mobile_logo =BusinessSetting::where('type', 'company_mobile_logo')->first()->value;
    $quotation_data=DB::table('quotations')->where('id',$quotation->id)->first();
    $quotation_info=DB::table('quotation_contact')->where('quotation_id',$quotation->id)->first();
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
@endphp
    <div class="report-sec" style="background: #fff;widht:1400px!important;height:100%; border:0.5px solid black; padding:10px;margin-left:-30px;margin-right:-30px;">
        <div class="quotation-box" style="height:86%;">
            <div class="report-logo">
                <img src="{!! asset('public/assets/frontend/img/quotation_logo.png') !!}" style="width: 250px;margin-left: 40px;margin-bottom: 15px;">
            </div>

            <table style="width: 100%;">
                <tr>
                    <td style="width: 65%;">
                        <div class="ref-box" style="margin-bottom: 25px;">
                            <h6 style="font-size: 12px;font-weight: bold;margin: 0px;font-family: 'Poppins', sans-serif!important;">Quotation No: {!! $quotation->reference_no !!}</h6>
                            <h6 style="font-size: 11px;font-weight: bold;margin-bottom: 20;font-family: 'Poppins', sans-serif!important;">Date: {{ date('d M Y') }}</h6>
                        </div>
                        <br>
                         <div style="height:40px"></div>
                        <div class="to-box">
                            <p style="font-size: 11px;font-family: 'Poppins', sans-serif!important;margin-top:20px;padding-top:20px;overflow:hidden;">To</p>
                            <h6 style="margin: 30px;font-size: 13px;font-weight: bold;font-family: 'Poppins', sans-serif!important;"><u>{{$quotation_contact->company ?? ''}}</u></h6>
                            <p style="margin: 0px;font-size: 11px;font-family: 'Poppins', sans-serif!important;">Address: {{ $quotation_contact->address ?? '' }} </p>
                        </div>
                    </td>
                    <td style="vertical-align: top">
                        <div class="quotation-creator">
                            <h3 style="margin-top: 0;font-weight: bold;important;font-size: 35px;margin-bottom: 40px;border-bottom:2px solid black;font-family: 'Poppins', sans-serif!important;">QUOTATION</h3>
                            <br>
                            <h6 style="font-size: 12px;font-weight:bold;margin-bottom: 8px;font-family: 'Poppins', sans-serif!important;">Attn:
                                {!! isset($quotation_contact->f_name)?$quotation_contact->f_name:'' !!} {!! isset($quotation_contact->l_name)?$quotation_contact->l_name:'' !!}</h6>
                            
                            <p style="margin: 0px;font-size: 11px;font-family: 'Poppins', sans-serif!important;">Contact: {!! isset($quotation_contact->phone)?$quotation_contact->phone:'' !!}</p>
                            <p style="margin: 0px;font-size: 11px;font-family: 'Poppins', sans-serif!important;">Email: {!! isset($quotation_contact->email)?$quotation_contact->email:'' !!}</p>
                        </div>
                    </td>
                </tr>
            </table>
            {{-- <div class="report-subject" style="margin-top: 0px;">
                <h5 style="text-decoration: underline;font-size: 12px;font-weight: bold;margin-bottom: 10px;font-family: 'Poppins', sans-serif!important;">Subject:
                   {{$quotation_subject}}</h5>
            </div> --}}
            <br>
            <table
                style="border: 2px solid #000; width: 100%; border-collapse: collapse;font-size: 14px;">
                <thead>
                    <tr style="background: #f2f2f2;">
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">No</th>
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">Item Name</th>
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">Spec</th>
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">Unit</th>
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">QTY</th>
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">Unit Price</th>
                        @if($quotation_data->is_vat==1)
                            <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">VAT</th>
                            <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">Unit Vat Amount</th>
                            <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">Unit Price(With Vat)</th>
                        @endif
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;border-right:0px;font-size:10px;width:12%;">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                      @php
                        $grand_total=0;
                        $total_vat=0;
                        $quote_vat=0;
                    @endphp
                    @if (count($quotation->productQuotations))
                  
                        @foreach ($quotation->productQuotations as $key => $pro)
                        		@php
                                    if($pro->discount_type=='percent')
                                    {
                                        $discount=($pro->net_unit_price*($pro->discount/100));
                                    }
                                    else{
                                        $discount=$pro->discount;
                                    }
                                        
                                @endphp
                            <tr class="">
                                <td style="padding: 2px;border: 1px solid black;font-size:10px;text-align:center;"> {!! $key + 1 !!}</td>
                                <td style="padding: 2px;border: 1px solid black;font-size:10px;text-align:center;"> {!! $pro->product->name !!}</td>
                                <td style="padding: 2px;border: 1px solid black;font-size:10px; text-align:left;padding-left:10px;">{!! $pro->product->features !!}</td>
                                
                                
                                <td style="padding: 2px;border: 1px solid black;font-size:10px;text-align:center;">{!! $pro->product->unit !!}</td>
                                <td style="padding: 2px;border: 1px solid black;font-size:10px;text-align:center;">{!! $pro->qty !!}</td>
                                <td style="padding: 2px;border: 1px solid black;font-size:11px;display:none;">Tk.{!!round(($pro->net_unit_price-$discount),2) !!}</td>
                                 @if($quotation_data->is_vat==1)
                                    <td style="padding: 2px;border: 1px solid black;font-size:11px;display:none;"> {!! $pro->vat_rate !!}%</td>
                                    <td style="padding: 2px;border: 1px solid black;font-size:11px;display:none;"> Tk.{!! $pro->single_unit_vat !!}</td>
                                    <td style="padding: 2px;border: 1px solid black;font-size:11px;display:none;">Tk.{!! $pro->single_unit_price_vat !!} </td>
                                    <td style="padding: 2px;border: 1px solid black;border-right:0px;font-size:11px;text-align:center;">Tk.{!! round((($pro->total+($pro->single_unit_vat*$pro->qty))-($discount*$pro->qty)),2) !!} </td>
                               @else
                                <td style="padding: 2px;border: 1px solid black;border-right:0px;font-size:11px;text-align:center;">Tk.{!! round(($pro->total-($discount*$pro->qty)),2) !!} </td>
                               @endif
                            </tr>
                            @php
                                 $grand_total +=round(($pro->total-($discount*$pro->qty)),2);
                                 $quote_vat +=($pro->single_unit_vat*$pro->qty); 
                            @endphp
                        @endforeach
                    @endif

                     @php
                                                
                        if($quotation->is_vat == 1)
                        {
                            $total_vat=$quote_vat;
                        }
                     @endphp
                    <!-- @if($total_vat>0)-->
                    <!--<tr>-->
                    <!--    <td colspan="6" style="padding: 4px;border: 0.5px solid black;font-size:10px;text-align:right"><strong>Vat:</strong></td>-->
                    <!--    <td colspan="2" style="padding: 4px;text-align: right; border: 1px solid black;font-size:11px;">{{App\CPU\Helpers::currency_converter($total_vat)}}</td>-->
                    <!--</tr>-->
                    <!--@endif-->
                   @if($quotation->shipping_amount>0 && $quotation_data->is_vat==1)
                    <tr>
                        <td colspan="5" style="padding: 4px;border: 0.5px solid black;font-size:10px;text-align:right"><strong>Shipping Fee:</strong></td>
                        <td style="padding: 4px;border: 0.5px solid black;font-size:10px;text-align:right">TK.{{$quotation->shipping_cost}}</td>
                        <td style="padding: 4px;border: 0.5px solid black;font-size:10px;text-align:right">{{$quotation->shipping_vat}}%</td>
                        <td style="padding: 4px;border: 0.5px solid black;font-size:10px;text-align:right">TK.{{ round(($quotation->shipping_cost*($quotation->shipping_vat/100)),2)}}</td>
                        <td colspan="2" style="padding: 4px;text-align: right; border: 1px solid black;font-size:11px;">{{App\CPU\Helpers::currency_converter($quotation->shipping_amount)}}</td>
                    </tr>
                    @elseif($quotation->shipping_amount>0)
                    <tr>
                        <td colspan="6" style="padding: 4px;border: 0.5px solid black;font-size:10px;text-align:right"><strong>Shipping Fee:</strong></td>
                        <td colspan="2" style="padding: 4px;text-align: right; border: 1px solid black;font-size:11px;">{{App\CPU\Helpers::currency_converter($quotation->shipping_amount)}}</td>
                    </tr>
                    @endif
                    <tr>
                        <td <?php if($quotation_data->is_vat==1){echo 'colspan="9"';}else{echo 'colspan="6"';}?> style="padding: 4px;border: 0.5px solid black;font-size:10px;text-align:right"><strong>Total:</strong></td>
                        <!--<td>{!! $quotation->total_tax !!}</td>-->
                        <!--<td>{!! $quotation->total_discount !!}</td>-->
                        <td colspan="2" style="padding: 4px;text-align: right; border: 1px solid black;font-size:11px;">{{App\CPU\Helpers::currency_converter($grand_total + $total_vat+$quotation->shipping_amount)}}</td>
                    </tr>
                    <!--<tr>
                        <td colspan="10" class="remarks" style="text-align: left; border: 1px solid black; padding: 5px;border-right:0px;">
                            <h5 style="margin: 0px;font-size: 13px;font-weight: bold;">TERMS & CONDITIONS: </h5>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 2px;border: 1px solid black;font-size:10px;"> 1</td>
                        <td colspan="10" style="padding: 4px;text-align: left; border: 1px solid black;font-size:11px;">
                           The Quoted prices are inclusive of VAT & AIT, Shipping Cost.
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 2px;border: 0.5px solid black;font-size:10px;"> 2</td>
                        <td colspan="10" style="padding: 4px;text-align: left; border: 1px solid black;font-size:11px;">
                            Quotation is valid for next 3 days.
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 2px;border: 0.5px solid black;font-size:10px;"> 3</td>
                        <td colspan="10" style="padding: 4px;text-align: left; border: 1px solid black;font-size:11px;">
                           Delivery Timeline:</strong> From Ready Stock.
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 2px;border: 0.5px solid black;font-size:10px;"> 4</td>
                        <td colspan="10" style="padding: 4px;text-align: left; border: 1px solid black;font-size:11px;">
                           <strong>Payment Terms: </strong>BEFTN made in favor of "Malamal.xyz Ltd"
                        </td>
                    </tr>-->
                    
                    
                </tbody>
            </table>
            </br>
            <table style="border: 1px solid #000; width: 100%; border-collapse: collapse;font-size: 14px;text-align: center;margin-top:20px;">
                
                <tbody>
                    
                    <tr>
                        <td colspan="10" class="remarks" style="text-align: left; border: 1px solid black; padding: 5px;border-right:0px;">
                            <h5 style="margin: 0px;font-size: 12px;font-weight: bold;">TERMS & CONDITIONS: </h5>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10" style="padding: 10px 5px;text-align: left; border: 1px solid black;font-size:12px;">
                            @php
                            $quotation_info=\App\Model\BusinessSetting::where('type','quotation_remarks')->first();
                            if($quotation_info != null ) $quotation_remarks=$quotation_info->value;
                            $quotation_info1=\App\Model\BusinessSetting::where('type','quotation_remarks_1')->first();
                            if($quotation_info1 != null ) $quotation_remarks_1=$quotation_info1->value;
                            @endphp
                            <p>
                            @if($total_vat>0)
                                @if (!empty($quotation->note))
                                {!! $quotation->note !!}
                                </br>
                                @else
                                {!! $quotation_remarks !!}
                                @endif
                            @else
                            {!! $quotation_remarks_1 !!}
                            @endif
                            
                        </td>
                    </tr>
                </tbody>
            </table>
            <!--<div class="note-book">
                <h5 style="font-size: 11px;font-weight: bold;margin-bottom: 30px;text-decoration: underline;font-family: 'Poppins', sans-serif!important;">{{$quotation_note}}</h5>
            </div>-->
            <div class="best-regards">
                 <p style="margin-top: 50px;font-size: 15px;font-weight: bold;font-family: 'Poppins', sans-serif!important;">Thank You</p>
                 {!! $quotation_signature !!}
                <!--<p style="margin-top: 50px;font-size: 15px;font-weight: bold;font-family: 'Poppins', sans-serif!important;">Thank You</p>-->
                <!--<p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif!important;">Malamal Team</p>-->
                <!--<p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif!important;">Helpline: 0197525821</p>-->
                <p style="color:gray;margin: 0px;font-size: 11px;font-family: 'Poppins', sans-serif!important;margin-top:10px"><small>This is an electronically generated quotation and does not require a signature</small></p>
                <!--<div class="regard-name">
                    <p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif!important;">Helpline: 0197525821</p>
                    <p style="margin: 0px;font-size: 11px;font-family: 'Poppins', sans-serif!important;"><small>This is an electronically generated quotation and does not require a signature</small></p>
                </div>-->
            </div> 
        </div>
        <div class="pad-address" style="text-align: right;position: absolute!important;bottom: 0px!important;right: 0px!important;vertical-align: bottom;">
            <!--<h2 style="margin:0px;">Malamal.xyz.Ltd</h2>-->
            <img src="{!! asset('public/assets/frontend/img/malamal-logo.png') !!}" style="width: 260px;">
            <p style="margin: 0px;font-size: 10px;font-family: 'Poppins', sans-serif!important;"><small>Bangladesh's First Dedicated Online Platform For Industrial Products</small></p>
            <p style="margin: 0px;font-size: 9px;position: absolute!important;font-family: 'Poppins', sans-serif!important;"><strong>Register Office:</strong> Level 11 & 12, Medona Tower, 28, Mohakhali C/A, Dhaka-1212</p>
            <p style="margin: 0px;font-size: 9px;font-family: 'Poppins', sans-serif!important;vertical-align: bottom;inline-size: 100px;"><strong>Sales Center:</strong> 100-103, Hazi Samsul Islam Tower, 2nd Floor, Nawabpur Road, Dhaka - 1100 </span></p>
            <p style="margin: 0px;font-size: 9px;font-family: 'Poppins', sans-serif!important;vertical-align: bottom;"><strong>Email:</strong> info@malamal.com.bd, sales@malamal.com.bd </span></p>
            <p style="margin: 0px;font-size: 9px;font-family: 'Poppins', sans-serif!important;vertical-align: bottom;"><strong>Phone:</strong> +8801972525821, +8801972525828</span></p>
            
        </div>
    </div>
</body>

</html>