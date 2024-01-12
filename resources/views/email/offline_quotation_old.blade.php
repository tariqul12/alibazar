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
@endphp
    <div class="report-sec" style="background: #fff;widht:1400px!important;height:100%; border:0.5px solid black; padding:10px;margin-left:-30px;margin-right:-30px;">
        <div class="quotation-box" style="height:89%;">
            <div class="report-logo">
                <img src="{!! asset('public/assets/frontend/img/reportlogo.png') !!}" style="width: 250px;margin-left: 40px;margin-bottom: 15px;">
            </div>

            <table style="width: 100%;">
                <tr>
                    <td style="width: 65%;">
                        <div class="ref-box" style="margin-bottom: 25px;">
                            <h6 style="font-size: 13px;font-weight: bold;margin: 0px;font-family: 'Poppins', sans-serif!important;">Ref: {!! session('quote_data') !!}</h6>
                            <h6 style="font-size: 11px;font-weight: bold;margin-bottom: 20;font-family: 'Poppins', sans-serif!important;">Date: {{ date('d M Y') }}</h6>
                        </div>
                        <br>
                         <div style="height:40px"></div>
                        <div class="to-box">
                            <p style="font-size: 11px;font-family: 'Poppins', sans-serif!important;margin-top:20px;padding-top:20px;overflow:hidden;">To</p>
                            <h6 style="margin: 30px;font-size: 13px;font-weight: bold;font-family: 'Poppins', sans-serif!important;"><u>Mokam Limited</u></h6>
                            <p style="margin: 0px;font-size: 11px;font-family: 'Poppins', sans-serif!important;">Address: inside in Dhaka</p>
                        </div>
                    </td>
                    <td style="vertical-align: top">
                        <div class="quotation-creator">
                            <h3 style="margin-top: 0;font-weight: bold;important;font-size: 35px;margin-bottom: 40px;border-bottom:2px solid black;font-family: 'Poppins', sans-serif!important;">QUOTATION</h3>
                            <br>
                            <h6 style="font-size: 12px;font-weight:bold;margin-bottom: 8px;font-family: 'Poppins', sans-serif!important;">Attn:
                                {!! $contact_info->f_name !!} {!! $contact_info->l_name !!}</h6>
                            
                            <p style="margin: 0px;font-size: 11px;font-family: 'Poppins', sans-serif!important;">Contact: {!! $contact_info->phone !!}</p>
                            <p style="margin: 0px;font-size: 11px;font-family: 'Poppins', sans-serif!important;">Email: {!! $contact_info->email !!}</p>
                        </div>
                    </td>
                </tr>
            </table>
            <br>
            <table
                style="border: 2px solid #000; width: 100%; border-collapse: collapse;font-size: 14px;text-align: center">
                <thead>
                    <tr style="background: #f2f2f2;">
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">No
                        </th>
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">Item
                            Name</th>
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">Spec
                        </th>
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">Unit
                        </th>
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">QTY
                        </th>
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">Unit
                            Price (W/O Vat)</th>
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">VAT
                        </th>
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">Unit
                            Vat Amount</th>
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;font-size:10px;">Unit
                            Price (with VAT)</th>
                        <th style="text-align: center;vertical-align: bottom;padding: 5px;border: 1px solid black;border-right:0px;font-size:10px;width:12%;">
                            Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($quotation))
                    @php
                        $grand_total=0;
                    @endphp
                        @foreach ($quotation as $key => $pro)
                            <tr class="text-center">
                                <td style="padding: 2px;border: 1px solid black;font-size:10px;"> {!! $key + 1 !!}</td>
                                <td style="padding: 2px;border: 1px solid black;font-size:10px;word-wrap: break-word;"> {!! $pro->pro_name !!}</td>
                                <td style="padding: 2px;border: 1px solid black;font-size:10px;word-wrap: break-word;">{!! $pro->pro_name !!}
                                </td>
                                <td style="padding: 2px;border: 1px solid black;font-size:10px;">{!! $pro->unit !!}</td>
                                <td style="padding: 2px;border: 1px solid black;font-size:10px;">{!! $pro->qty !!}</td>
                                <td style="padding: 2px;border: 1px solid black;font-size:11px;">Tk.{!! $pro->unit_price !!}</td>
                                <td style="padding: 2px;border: 1px solid black;font-size:11px;"> Tk.{!! $pro->tax !!}</td>
                                <td style="padding: 2px;border: 1px solid black;font-size:11px;">Tk.<?php echo isset($pro->single_unit_vat)?$pro->single_unit_vat:''?> </td>
                                <td style="padding: 2px;border: 1px solid black;font-size:11px;"> Tk.{!! $pro->net_unit_price !!} </td>
                                <td style="padding: 2px;border: 1px solid black;border-right:0px;font-size:11px;">Tk.{!! $pro->total !!} </td>
                            </tr>
                            @php
                                $grand_total +=($pro->total+$pro->shipping_cost+ $pro->tax);
                            @endphp
                        @endforeach
                    @endif
                    <tr>
                        <td colspan="9" style="padding: 4px;border: 0.5px solid black;font-size:10px;text-align:right"><strong>Total:</strong> </td>
                        <td colspan="2" style="padding: 4px;text-align: right; border: 1px solid black;font-size:11px;"><strong>Tk.{{$grand_total}}</strong></td>
                    </tr>
                   
                    
                    
                </tbody>
            </table>
            </br>
            <table style="border: 1px solid #000; width: 100%; border-collapse: collapse;font-size: 14px;text-align: center;margin-top:20px;">
                
                <tbody>
                    
                    <tr>
                        <td colspan="10" class="remarks" style="text-align: left; border: 1px solid black; padding: 5px;border-right:0px;">
                            <h5 style="margin: 0px;font-size: 13px;font-weight: bold;">TERMS & CONDITIONS: </h5>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10" style="padding: 10px 5px;text-align: left; border: 1px solid black;font-size:12px;">
                            {!! $quotation_remarks !!}
                            
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="best-regards">
                <p style="margin-top: 50px;font-size: 15px;font-weight: bold;font-family: 'Poppins', sans-serif!important;">Thank You</p>
                <p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif!important;">Malamal Team</p>
                <p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif!important;">Helpline: 0197525821</p>
                <p style="color:gray;margin: 0px;font-size: 11px;font-family: 'Poppins', sans-serif!important;margin-top:10px"><small>This is an electronically generated quotation and does not require a signature</small></p>
            </div> 
        </div>
        <div class="pad-address" style="text-align: right;position: absolute!important;bottom: 0px!important;right: 0px!important;vertical-align: bottom;">
            <!--<h2 style="margin:0px;">Malamal.xyz.Ltd</h2>-->
            <img src="{!! asset('public/assets/frontend/img/malamal-logo.png') !!}" style="width: 260px;">
            <p style="margin: 0px;font-size: 10px;font-family: 'Poppins', sans-serif!important;"><small>Bangladesh's First Dedicated Online Platform For Industrial Products</small></p>
            <p style="margin: 0px;font-size: 9px;position: absolute!important;font-family: 'Poppins', sans-serif!important;"><strong>Register Office:</strong> Level 11 & 12, Medona Tower, 28, Mohakhali C/A, Dhaka-1212</p>
            <p style="margin: 0px;font-size: 9px;font-family: 'Poppins', sans-serif!important;vertical-align: bottom;inline-size: 100px;"><strong>Sales Center:</strong> {{$shop_address}}</span></p>
            <p style="margin: 0px;font-size: 9px;font-family: 'Poppins', sans-serif!important;vertical-align: bottom;"><strong>Email:</strong> {{$company_email}}</span></p>
            <p style="margin: 0px;font-size: 9px;font-family: 'Poppins', sans-serif!important;vertical-align: bottom;"><strong>Phone:</strong> {{$company_phone}}</span></p>
            
        </div>
    </div>
</body>

</html>
