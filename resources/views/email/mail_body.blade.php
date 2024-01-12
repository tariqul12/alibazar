
<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Malamal | Home</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta property="og:title" content="">
  <meta property="og:type" content="">
  <meta property="og:url" content="">
  <meta property="og:image" content="">

  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&display=swap" rel="stylesheet">
  <!-- CSS only -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" >
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"  />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js"></script>

  <meta name="theme-color" content="#fafafa">
</head>

<body>
@php
use App\Model\BusinessSetting;
$company_phone =BusinessSetting::where('type', 'company_phone')->first()->value;
$company_email =BusinessSetting::where('type', 'company_email')->first()->value;
$shop_address =BusinessSetting::where('type', 'shop_address')->first()->value;
$company_name =BusinessSetting::where('type', 'company_name')->first()->value;
$company_web_logo =BusinessSetting::where('type', 'company_web_logo')->first()->value;
$company_mobile_logo =BusinessSetting::where('type', 'company_mobile_logo')->first()->value;
$quotation_info=DB::table('quotation_contact')->where('quotation_id',$quotation_id)->first();
$quotation_data=DB::table('quotations')->where('id',$quotation_id)->first();
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
                        ->where('quotations.id',$quotation_id)->first();
}
else{
    $quotation_contact=$quotation_info;
}

$created_info=DB::table('quotations')->where('id',$quotation_id)->first();
$created_users=DB::table('admins')->where('id',$created_info->user_id)->first();
@endphp
  <div style="width: 750px;padding: 20px;background: #fff;">
    <div style="border:3px solid #e9611e;">
      <div style="padding: 30px;">
        <table style="width: 100%;" >
             <tbody>
              <tr>
                <td style="width: 40%;">
                  <img src="{!! asset('public/assets/frontend/img/quotation_logo.png') !!}" style="width: 180px;">
                </td>
                <td style="width: 60%;text-align:right;">
                    <div style="display:flex;text-align:right;float:right;">
                        <h4 style="font-size: 18px;display:inline-block;margin-top:-40px">Download Our Apps:</h4>
                        <a href="" style="display: inline-block;padding: 5px;"><img src="{!! asset('public/assets/frontend/img/playstore.png') !!}"></a>
                        <a href="" style="display: inline-block;padding: 5px;"><img src="{!! asset('public/assets/frontend/img/app-store.png') !!}"></a>
                    </div>
                   
                 
                </td>
              </tr>
            </tbody>
          </table>
          
          <table style="width: 100%;margin-top: 20px;">
             <tbody>
              <tr>
                <td style="padding:5px 0px;">
                  <h4 style="font-size: 17px;margin:0px;font-weight: bold;">Dear {{$name}},</h4>
                </td>
              </tr>
              <tr>
                <td style="padding:5px 0px;">
                  <p style="font-size: 13px;margin:0px;">We thank you for your valuable enquiry. Our quote for your requirements is as below:</p>
                </td>
              </tr>
            </tbody>
          </table>

          <table style="width: 100%;border: 2px solid #000;">
              <tbody>
                <tr style="border-bottom: 1px solid #ccc6c6;background: #c3c1c1;">
                  <th scope="col" style="width: 20%;padding: 6px 5px;">Item Details</th>
                  <th scope="col" style="padding: 6px 0px;text-align: center;">Quantity</th>
                <th scope="col" style="padding: 6px 0px;text-align: center;">Unit Price</th>
                @if($quotation_data->is_vat==1)
                <th scope="col" style="padding: 6px 0px;text-align: center;">Vat</th>
                <th scope="col" style="padding: 6px 0px;text-align: center;">Unit Vat Amount</th>
                <th scope="col" style="padding: 6px 0px;text-align: center;">Unit Price(With Vat)</th>
                <th scope="col" style="padding: 6px 0px;text-align: center;">Total Price</th>
                @else
                <th scope="col" style="padding: 6px 0px;text-align: center;">Total Price</th>
                @endif
                </tr>
                @php
                $grand_total=0;
                 $total_vat=0;
                $quote_vat=0;
                $discount=0;
               @endphp
                @foreach ($product_data as $item)
                @php
                if($item->discount_type=='percent')
                        	{
                        	    $discount=($item->net_unit_price*($item->discount/100));
                        	}
                        	else{
                            	$discount=$item->discount;
                        	}
                            
                    	@endphp
                <tr style="border-bottom: 1px solid #ccc6c6;background: #fff;">
                  <td style="font-size:12px!important;padding:5px!important;">
                    <table style="width: 100%;">
                         <tbody>
                          <tr>
                            <!--<td style="width:100px;">-->
                            <!--  <img src="{{ \App\CPU\ProductManager::product_image_path('thumbnail') }}/{{ $item->thumbnail }}" style="width: 100%;">-->
                            <!--</td>-->
                            <td style="padding:4px 0px">
                              <div style="padding: 0px;margin: 0px;list-style: none;margin-left: 20px;">
                                <?php echo $item->pro_name;?>
                              </div>
                            </td>
                          </tr>
                          
                        </tbody>
                      </table>
                  </td>
                  <td style="font-size:15px!important;padding:5px!important;text-align: center;">{{$item->qty}} {{$item->unit}}</td>
                  <td style="font-size:15px!important;padding:5px!important;text-align: center;">Tk. {{ round(($item->net_unit_price-$discount),2)}}</td>
                    @if($quotation_data->is_vat==1)
                    <td style="font-size:15px!important;padding:5px!important;text-align: center;">{!! $item->vat_rate !!} %</td>
                    <td style="font-size:15px!important;padding:5px!important;text-align: center;">TK.{!! round($item->single_unit_vat,2) !!}</td>
                    <td style="font-size:15px!important;padding:5px!important;text-align: center;">TK.{!! round($item->single_unit_price_vat,2) !!}</td>
                    <td style="font-size:15px!important;padding:5px!important;text-align: center;">Tk.{!! round((($item->total+($item->single_unit_vat*$item->qty))-($discount*$item->qty)),2) !!}</td>
                    @else
                     <td style="font-size:15px!important;padding:5px!important;text-align: center;">Tk.{!! round(($item->total-($discount*$item->qty)),2) !!}</td>
                    @endif
                  
                </tr>
                @php
                $grand_total +=($item->total-($discount*$item->qty));
                 $quote_vat +=($item->single_unit_vat*$item->qty) ;
             @endphp
                @endforeach
                     @php
                                                
                        if($quotation_data->is_vat == 1)
                        {
                            $total_vat=$quote_vat;
                        }
                     @endphp
                <tr style="border-bottom: 1px solid #ccc6c6;background: #f1f1f1;">
                  <td  <?php if($quotation_data->is_vat==1){echo 'colspan="6"';}else{echo 'colspan="3"';}?> style="font-size:15px!important;padding:5px!important;">Note: </td>
                  <td style="font-size: 20px!important;padding:5px!important;font-weight: bold;color: #e9611e;text-align: right;">Total: Tk. {{ round(($grand_total+$total_vat+$quotation_data->shipping_amount),2)}}</td>
                </tr>
               
              </tbody>
          </table>
          <table style="width: 100%;margin-top: 20px;">
             <tbody>
              <tr>
                <td style="text-align: center;">
                  <a href="{{url('')}}" style="font-size: 25px;text-align: center;background: #e9611e;text-decoration: none;color: #fff;padding: 5px 20px;display: inline-block;">ORDER NOW</a>
                </td>
              </tr>
              
            </tbody>
          </table>
          <table style="width: 100%;margin-top: 30px;">
             <tbody>
              <tr>
                <td>
                  <h4 style="font-size: 18px;font-weight: bold;margin:0px;">Terms & Conditions:</h4>
                </td>
              </tr>
              <tr>
                <td>
                  <p style="margin:0px;font-size: 13px;">1. This is a real time Quotation generated automatically and only shows the product price.</p>
                  <p style="margin:0px;font-size: 13px;">2. Quotation is valid for the next 3 days.</p>
                  <p style="margin:0px;font-size: 13px;">3. Delivary charges, VAT & AIT to be added separately</p>
                  <p style="margin:0px;font-size: 13px;">4. For customized Quotation as per your need, Please mail us at "sales@malamal.com.bd"</p>
                </td>
              </tr>
            </tbody>
          </table>
      </div>
      <div style="height:4px;background: #f5f5f5;"></div>
      <div style="padding: 30px;">
          <table style="width: 100%;">
             <tbody>
              <tr>
                <td>
                  <h4 style="font-size: 18px;font-weight: bold;">EFT / RTGS Instructions</h4>
                </td>
              </tr>
              <tr>
                <td>
                  <img src="{!! asset('public/assets/frontend/img/bank.png') !!}" style="width: 150px">
                </td>
              </tr>
            </tbody>
          </table>

          <table style="width: 100%;margin-top: 10px;border:1px solid #e9ecef;">
             <tbody>
              <tr style="background: #e9ecef;">
                <td style="padding: 2px 5px;font-size: 13px;">Beneficiary Name: </td>
                <td style="padding: 2px 5px;font-size: 13px;">MALAMAL.XYZ LTD</td>
              </tr>
              <tr>
                <td style="padding: 2px 5px;font-size: 13px;">Beneficiary A/C no.: </td>
                <td style="padding: 2px 5px;font-size: 13px;">1502204753760001</td>
              </tr>
              <tr style="background: #e9ecef;">
                <td style="padding: 2px 5px;font-size: 13px;">Type of A/C:</td>
                <td style="padding: 2px 5px;font-size: 13px;">Current Account</td>
              </tr>
              <tr>
                <td style="padding: 2px 5px;font-size: 13px;">Bank Name:</td>
                <td style="padding: 2px 5px;font-size: 13px;">Brac Bank</td>
              </tr>
              <tr style="background: #e9ecef;">
                <td style="padding: 2px 5px;font-size: 13px;">Branch:</td>
                <td style="padding: 2px 5px;font-size: 13px;">Nawabpur Road, Dhaka</td>
              </tr>
              <tr>
                <td style="padding: 2px 5px;font-size: 13px;">Routing Number:</td>
                <td style="padding: 2px 5px;font-size: 13px;">060274726</td>
              </tr>
            </tbody>
          </table>

          <table style="width: 100%;margin-top: 10px;">
             <tbody>
              <tr>
                <td>
                  <p style="font-size: 13px;">This is an electronically generated quotation and does not require a signature.</p>
                </td>
              </tr>
              <tr>
                <td>
                  <p style="margin: 0px;font-size: 13px;">Thank You,</p>
                  <p style="margin: 0px;font-size: 13px;">Malamal.xyz Team</p>
                </td>
              </tr>
            </tbody>
          </table>

          <table style="width: 100%;margin-top: 30px;">
             <tbody>
              <tr>
                <td colspan="5" style="text-align:center;">
                  <h4 style="text-align: center;border-bottom: 2px solid gray;display: inline-block;font-size: 18px;font-weight: bold;margin-bottom: 20px;">Our Popular Brand</h4>
                </td>
              </tr>
              <tr style="border-bottom:2px solid gray;">
                <td style="border-right: 2px solid gray;text-align: center;border-bottom:2px solid gray;">
                  <a href=""><img src="{!! asset('public/assets/frontend/img/bosch.png') !!}" style="width: 100px"></a>
                </td>
                <td style="border-right: 2px solid gray;text-align: center;border-bottom:2px solid gray;">
                  <a href=""><img src="{!! asset('public/assets/frontend/img/daewoo.png') !!}" style="width: 100px"></a>
                </td>
                <td style="border-right: 2px solid gray;text-align: center;border-bottom:2px solid gray;">
                  <a href=""><img src="{!! asset('public/assets/frontend/img/harden.png') !!}" style="width: 100px"></a>
                </td>
                <td style="border-right: 2px solid gray;text-align: center;border-bottom:2px solid gray;">
                  <a href=""><img src="{!! asset('public/assets/frontend/img/incco.png') !!}" style="width: 100px"></a>
                </td>
                <td style="text-align: center;border-bottom:2px solid gray;">
                  <a href=""><img src="{!! asset('public/assets/frontend/img/makita.png') !!}" style="width: 100px"></a>
                </td>
              </tr>
              <tr>
                <td style="border-right: 2px solid gray;text-align: center;">
                  <a href=""><img src="{!! asset('public/assets/frontend/img/rivcen.png') !!}" style="width: 100px"></a>
                </td>
                <td style="border-right: 2px solid gray;text-align: center;">
                  <a href=""><img src="{!! asset('public/assets/frontend/img/total.png') !!}" style="width: 100px"></a>
                </td>
                <td style="border-right: 2px solid gray;text-align: center;">
                  <a href=""><img src="{!! asset('public/assets/frontend/img/vital.png') !!}" style="width: 100px"></a>
                </td>
                <td style="border-right: 2px solid gray;text-align: center;">
                  <a href=""><img src="{!! asset('public/assets/frontend/img/winner-fuel.png') !!}" style="width: 100px"></a>
                </td>
                <td style="text-align: center;">
                  <a href=""><img src="{!! asset('public/assets/frontend/img/winner.png') !!}" style="width: 100px"></a>
                </td>
              </tr>
              
            </tbody>
          </table>
    </div>
    <div style="height:10px;background: #f5f5f5;"></div>

    <div style="padding:10px;">
          <table style="width: 100%;">
             <tbody>
              <tr>
                <td><a href="" style="display: inline-block;padding: 5px;"><img src="{!! asset('public/assets/frontend/img/telephone.png') !!}"></a></td>
                <td>
                  <div style="border-right: 2px solid gray;width: 90%;">
                    <p style="margin: 0px;color: gray;font-size: 13px;">+880963 8212121</p>
                    <p style="margin: 0px;color: gray;font-size: 13px;">+8801972 525821(B2B Sales)</p>
                    <p style="margin: 0px;color: gray;font-size: 13px;">(Sat-Tue : 10am-7pm)</p>
                  </div>
                </td>
                <td>
                  <h3 style="color: gray;font-size: 16px;">info@malamal.com.bd</h3>
                </td>
                <td style="text-align: right;">
                  <a href="" style="display: inline-block;padding: 5px;"><img src="{!! asset('public/assets/frontend/img/facebook.png') !!}"></a>
                  <a href="" style="display: inline-block;padding: 5px;"><img src="{!! asset('public/assets/frontend/img/twitter.png') !!}"></a>
                  <a href="" style="display: inline-block;padding: 5px;"><img src="{!! asset('public/assets/frontend/img/instagram.png') !!}"></a>
                  <a href="" style="display: inline-block;padding: 5px;"><img src="{!! asset('public/assets/frontend/img/whatsapp.png') !!}"></a>
                  <!--<a href="" style="border: 1px solid gray;height: 25px;display: inline-block;width: 25px;border-radius: 30px;text-align: center;padding: 5px;color: gray;font-size: 20px;"><i class="fa-brands fa-twitter"></i></a>
                  <a href="" style="border: 1px solid gray;height: 25px;display: inline-block;width: 25px;border-radius: 30px;text-align: center;padding: 5px;color: gray;font-size: 20px;"><i class="fa-brands fa-instagram"></i></a>
                  <a href="" style="border: 1px solid gray;height: 25px;display: inline-block;width: 25px;border-radius: 30px;text-align: center;padding: 5px;color: gray;font-size: 20px;"><i class="fa-brands fa-whatsapp"></i></a>-->
                </td>
              </tr>
            </tbody>
          </table>
    </div>
          <table style="width: 100%;background: #f5f5f5">
             <tbody>
              <tr>
                <td style="padding: 10px;">
                  <a href="" style="color: gray;font-size: 13px;padding: 0xp 20px;display: inline-block;padding: 0px 10px;border-right: 2px solid gray;">FAQs</a>
                  <a href="" style="color: gray;font-size: 13px;padding: 0xp 20px;display: inline-block;padding: 0px 10px;border-right: 2px solid gray;">Terms & Conditions</a>
                  <a href="" style="color: gray;font-size: 13px;padding: 0xp 20px;display: inline-block;padding: 0px 10px;border-right: 2px solid gray;">Track Order</a>
                </td>
                <td style="text-align: right;padding: 10px;">
                  <h3 style="color: gray;font-size: 15px;font-weight: normal; margin: 0px;">Copyright© 2023 Malamal.xyz ltd</h3>
                </td>
              </tr>
            </tbody>
          </table>

      
    </div>
  </div>  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>