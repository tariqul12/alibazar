
<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>{{\App\CPU\translate('invoice')}}</title>
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
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
    crossorigin="anonymous">
  

  
  

  <meta name="theme-color" content="#fafafa">
</head>

<body style="font-family: 'Poppins', sans-serif;">
    @php
    use App\Model\BusinessSetting;
    $company_phone =BusinessSetting::where('type', 'company_phone')->first()->value;
    $company_email =BusinessSetting::where('type', 'company_email')->first()->value;
    $shop_address =BusinessSetting::where('type', 'shop_address')->first()->value;
    $company_name =BusinessSetting::where('type', 'company_name')->first()->value;
    $company_web_logo =BusinessSetting::where('type', 'company_web_logo')->first()->value;
    $company_mobile_logo =BusinessSetting::where('type', 'company_mobile_logo')->first()->value;
@endphp
  <div style="background: #fff;height:100%;margin-left:-30px;margin-right:-30px;margin-top:-30px;font-family: 'Poppins', sans-serif;">
    <div style="height:90%;">
        <table style="width: 100%;font-family: 'Poppins', sans-serif;">
             <tbody>
              <tr>
                <td style="width: 50%;">
                    <!--<p style="margin: 0px;font-size: 18px!important;font-weight: bold;">Malamal.xyz.bd</p>-->
                    <p style="margin: 0px;font-size: 15px;font-weight: bold;font-family: 'Poppins', sans-serif;">{{$company_name}}</p>
                    <p style="margin: 0px;font-size: 10px; font-weight: bold;font-family: 'Poppins', sans-serif;"><br> BIN: 003682245-0101</p>
                    <p style="margin: 0px;font-size: 10px;inline-size: 100px;font-family: 'Poppins', sans-serif;">{{$shop_address}}</p>
                    <p style="margin: 0px;font-size: 10px;margin-bottom: 7px;font-family: 'Poppins', sans-serif;"> Phone: {{ $company_phone}}</p>
                </td>
                <td style="width: 50%;">
                    <img src="{!! asset('public/assets/frontend/img/quotation_logo.png') !!}" style="width: 250px;margin-left: 80px;margin-bottom: 15px;">
                </td>
              </tr>
              <tr style="border-bottom: 1px solid gray; "><td colspan="11" style="margin-bottom:10px;"></td></tr>
              <tr style=""><td colspan="11" style="margin-bottom:10px;"></td></tr>
            </tbody>
          </table>
          <!-- --- -->
          <table style="margin-top:10px;padding-top:10px;margin-bottom:20px;">
             <tbody>
              <tr>
                <td style="border:none;">
                    <h5 style="margin: 0px;font-size: 12px; margin-bottom: 15px;font-weight: bold;padding-bottom: 20px;">Invoice Date: {{date('d M Y',strtotime($order['created_at']))}}</h5>
                    
                </td>
               </tr>
             <td colspan="11" style="margin-top:20px;padding-top:20px;"></td>
            </tbody>
          </table>
          
          <table style="width: 100%;">
             <tbody>
              <tr style="">
                <td style="width: 62%;">
                     @php
                        $billing_address=json_decode($order->billing_address_data,true);
                      @endphp
                    <div style="margin-top:100px;">
                      <p style="margin: 0px;font-weight: bold;font-family: 'Poppins', sans-serif;">Billing Address</p>
                      <p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif;">{{$billing_address ? $billing_address['contact_person_name'] : ""}}</p>
                      <p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif;">{{$billing_address ? $billing_address['company_name'] : ""}}</p>
                      <p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif;">{{$billing_address ? $billing_address['company_bin'] : ""}}</p>
                      <p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif;">{{$billing_address ? $billing_address['address'] : ""}}</p>
                      <p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif;">{{$billing_address ? $billing_address['city'] : ""}}- {{$billing_address ? $billing_address['zip'] : ""}}</p>
                      <p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif;">{{$billing_address ? $billing_address['phone'] : ""}}</p>
                    </div>
                </td>
                <td style="width: 38%;">
                    <div style="margin-top: 30px;margin-left:100px;">
                      @php
                        $shipping_address=json_decode($order->shipping_address_data,true);
                      @endphp
                      <p style="margin: 0px;font-weight: bold;">Shipping Address</p>
                      <p style="margin: 0px;font-size: 12px;">{{$shipping_address ? $shipping_address['contact_person_name'] : ""}}</p>
                      <p style="margin: 0px;font-size: 12px;">{{$shipping_address ? $shipping_address['address'] : ""}}</p>
                      <p style="margin: 0px;font-size: 12px;">{{$shipping_address ? $shipping_address['city'] : ""}} {{$shipping_address ? $shipping_address['zip'] : ""}}</p>
                      <p style="margin: 0px;font-size: 12px;">{{$shipping_address ? $shipping_address['phone'] : ""}}</p>
                      
                    </div>
                </td>
              </tr>
              
            </tbody>
          </table>
          
          <table style="width: 100%;">
             <tbody>
             <!-- <tr style="">
                <td style="width: 70%;">
                    <div style="margin-top:100px;">
                      <p style="margin: 0px;font-weight: bold;">Billing Address</p>
                      <p style="margin: 0px;font-size: 13px;">{{$order->billingAddress ? $order->billingAddress['contact_person_name'] : ""}}</p>
                      <p style="margin: 0px;font-size: 13px;">{{$order->billingAddress ? $order->billingAddress['company_bin'] : ""}}</p>
                      <p style="margin: 0px;font-size: 13px;">{{$order->billingAddress ? $order->billingAddress['phone'] : ""}}</p>
                      <p style="margin: 0px;font-size: 13px;">{{$order->billingAddress ? $order->billingAddress['address'] : ""}}</p>
                      <p style="margin: 0px;font-size: 13px;">{{$order->billingAddress ? $order->billingAddress['city'] : ""}} {{$order->billingAddress ? $order->billingAddress['zip'] : ""}}</p>
                    </div>
                </td>
                <td style="width: 30%;">
                    <div style="margin-top: 30px;margin-left:100px;">
                      <p style="margin: 0px;font-weight: bold;">Shipping Address</p>
                      <p style="margin: 0px;font-size: 13px;">{{$order->customer['f_name'].' '.$order->customer['l_name']}}</p>
                      <p style="margin: 0px;font-size: 13px;">{{$order->shippingAddress ? $order->shippingAddress['address'] : ""}}</p>
                      <p style="margin: 0px;font-size: 13px;">{{$order->shippingAddress ? $order->shippingAddress['city'] : ""}} {{$order->shippingAddress ? $order->shippingAddress['zip'] : ""}}</p>
                      <p style="margin: 0px;font-size: 13px;">{{$order->customer['phone']}}</p>
                      
                    </div>
                </td>
              </tr>-->
              <tr>
                  <td colspan="7" style="margin-top:20px;padding-top:20px;"></td>
                </tr>
              <tr>
                <td style="width: 63%;border:none;">
                   <p style="margin: 26px 0px;font-size: 12px;"><span style="font-weight: bold;">Purchase Order No:</span> {{ $order->purchase_order_no }}</p></br>
                </td>
              </tr>
              <tr><td colspan="11" style="margin-top:20px;padding-top:20px;"></td></tr>
              <tr>
                <td style="width: 63%;border:none;">
                   <h4 style="font-size: 17px;font-weight: bold;">Invoice No: <span>{{ $order->id }}</span></h4>
                   
                </td>
              </tr>
              
              <tr>
                <td style="width: 63%;border:none;">
                   <p style="font-size: 12px;">Dear {{$order->billingAddress ? $order->billingAddress['contact_person_name'] : ""}},</p>
                </td>
              </tr>
              <tr><td colspan="11" style="margin-top:1px;padding-top:1px;"></td></tr>
              <tr>
                <td style="border:none;">
                   <p style="font-size: 12px;">Thank you very much for your order. Please find your Invoice as per follows:</p>
                </td>
              </tr>
              <tr><td colspan="11" style="margin-top:5px;padding-top:5px;"></td></tr>
            </tbody>
          </table>
          <!-- --- -->
          <table style="width: 100%;">
            @php
                $subtotal=0;
                $total=0;
                $sub_total=0;
                $total_tax=0;
                $total_shipping_cost=0;
                $total_discount_on_product=0;
                $extra_discount=0;
                
            @endphp
              <tbody>
                <tr style="border-bottom: 1px solid #ccc6c6;background: #c3c1c1;">
                  <th scope="col" style="padding: 5px; font-size:12px;">SL</th>
                  <th scope="col" style="width: 45%;padding: 5px 0px; font-size:12px;">Product</th>
                  <th scope="col" style="padding: 5px 0px; font-size:12px;">Qty</th>
                  <th scope="col" style="padding: 5px 0px; font-size:12px;">Unit Price</th>
                @if($order->discount_status_show=='1')
                  <th scope="col" style="padding: 5px 0px; font-size:12px;">Discount</th>
                  @endif
                  <th scope="col" style="padding: 5px 0px; font-size:12px;">Total Price</th>
                </tr>
                
                @foreach(\App\Model\OrderDetail::where('order_id', $order->id)->get() as $key=>$details)
                @php $subtotal=($details['price']*$details->qty) @endphp
                <tr style="border-bottom: 1px solid #ccc6c6;background: #fff;">
                  <td style="font-size:11px;padding:6px;">{{$key+1}}</td>
                  <td style="font-size:11px;padding:5px;"><strong>  
                    {{$details['product']?$details['product']->name:''}}
                    @if(!empty($details['variant'])) 
                    <br>
                    {{\App\CPU\translate('variation')}} : {{$details['variant']}}</strong></td>
                    @endif
                  <td style="font-size:11px;padding:5px;">{{$details->qty}}</td>
                  <td style="font-size:11px;padding:5px;">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($details['price']))}}</td>
                 @if($order->discount_status_show=='1')
                  <td style="font-size:11px;padding:5px;">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($details['discount']))}}</td>
                  @endif
                  <td style="font-size:11px;padding:5px;">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($subtotal))}}</td>
                  
                </tr>
                @php
                $sub_total+=$details['price']*$details['qty'];
                $total_shipping_cost+=$details['shipping_cost'];
                $total_discount_on_product+=($details['discount']*$details['qty']);
                $total+=($subtotal+$total_tax-$total_discount_on_product);
              @endphp
            @endforeach
                @php
                  $total_tax= (isset($order['vat_amount'])) ? $order['vat_amount'] : 0;
                  $extra_discount=0;
                  if($order->extra_discount_type=='percent')
                  {
                    $extra_discount=$sub_total*($order->extra_discount/100);
                  }
                  else{
                     $extra_discount=$order->extra_discount;
                  }
                @endphp
                <tr style="border-bottom: 1px solid #ccc6c6;background: #f1f1f1;">
                  <td></td>
                  <td <?php if($order->discount_status_show=='1'){echo 'colspan="4"';}else{echo 'colspan="3"';}?> style="font-size:11px;padding:5px;">Subtotal</td>
                  <td style="font-size:11px;padding:5px;">Tk.{{$sub_total}}</td>
                </tr>
                @if($total_tax > 0)
                <tr style="border-bottom: 1px solid #ccc6c6;background: #fff;">
                  <td></td>
                  <td <?php if($order->discount_status_show=='1'){echo 'colspan="4"';}else{echo 'colspan="3"';}?> style="font-size:11px;padding:5px">VAT</td>
                  <td style="font-size:11px;padding:5px;">Tk. {{$total_tax}}</td>
                </tr>
                @endif
                
                @if($order['shipping_cost'] > 0)
                <tr style="border-bottom: 1px solid #ccc6c6;background: #f1f1f1;">
                  <td></td>
                  <td <?php if($order->discount_status_show=='1'){echo 'colspan="4"';}else{echo 'colspan="3"';}?> style="font-size:11px;padding:5px;">Delivery Fee</td>
                  <td style="font-size:11px;padding:5px;">Tk. {{$order['shipping_cost']}}</td>
                </tr>
                @endif
                
                @if($order['discount_amount'] > 0)
                <tr style="border-bottom: 1px solid #ccc6c6;">
                    <td></td>
                    <td <?php if($order->discount_status_show=='1'){echo 'colspan="4"';}else{echo 'colspan="3"';}?> style="font-size:11px;padding:5px;background: #fff;">Coupon Discount</td>
                    <td style="font-size:11px;padding:5px;">Tk. {{$order['discount_amount']}}</td>
                </tr>
                @endif
                @if($extra_discount > 0)
                <tr style="border-bottom: 1px solid #ccc6c6;">
                    <td></td>
                    <td <?php if($order->discount_status_show=='1'){echo 'colspan="4"';}else{echo 'colspan="3"';}?> style="font-size:11px;padding:5px;background: #fff;">Extra Discount</td>
                    <td style="font-size:11px;padding:5px;">Tk. {{$extra_discount}}</td>
                </tr>
                @endif
                @if($order['loyalty_discount'] > 0)
                <tr style="border-bottom: 1px solid #ccc6c6;">
                  <td></td>
                  <td <?php if($order->discount_status_show=='1'){echo 'colspan="4"';}else{echo 'colspan="3"';}?> style="font-size:11px;padding:5px;background: #fff;">Loyalty Discount</td>
                  <td style="font-size:11px;padding:5px;">Tk. {{$order['loyalty_discount']}}</td>
                </tr> 
                @endif
                
                <tr style="border-bottom: 1px solid #ccc6c6;background: #f1f1f1;">
                  <td></td>
                  <td <?php if($order->discount_status_show=='1'){echo 'colspan="4"';}else{echo 'colspan="3"';}?> style="font-size:11px;padding:5px;">Total</td>
                  <td style="font-size:11px;padding:5px;">Tk. {{$order->order_amount}}</td>
                </tr>
              </tbody>
          </table><br>
          <!-- --- -->
            <table>
             <tbody>
              <tr style="margin: 20px 0px;display: block;">
                <td style="border:none;">
                    <p style="font-size:12px;margin: 0px;">Payment Method: {{\App\CPU\translate($order->payment_method)}} </p>
                    <p style="font-size:12px;margin: 0px;">Preferred Courier Service: {{$order->courier_name ? $order->courier_name: ""}}</p>
                </td>
              </tr><br>
              <tr style="margin: 20px 0px;display: block;">
                <td style="border:none;">
                    <p style="font-size:12px;margin: 0px;font-weight: bold;"; ><strong>Thanking You</strong></p>
                    <p style="font-size:12px;margin: 0px;">Sales Team</p>
                    <p style="font-size:12px;margin: 0px;">{{$company_name}}</p>
                </td>
              </tr><br>
              <tr style="margin: 20px 0px;display: block;">
                <td style="border:none;">
                    <p style="font-size:12px;margin: 0px;">For any further query please call us on hotline no:</p>
                    <p style="font-size:12px;margin: 0px;">+8809638212121</p>
                    <p style="font-size:12px;margin: 0px;">Email: sales@malamal.com.bd</p>
                </td>
              </tr>
            </tbody>
          </table>
          <!-- --- -->
    </div>
    
    <table style="margin-top:45px;">
              <tbody>
                <tr>
                  <td>
                      <table class="table" style="margin-bottom: 0px!important;">
                           <tbody>
                            <tr>
                              <td style="border: none;width: 60%;padding: 10px; background:#f1f1f1;">
                                <p style="margin:0px;font-size:10px">Bangladesh's Most Reliable Ecommerce Platform For Industrial Tools</p>
                                <p style="margin:0px;font-size:10px">{{url('/')}}</p>
                              </td>
                              <td style="border: none;padding: 10px;background:#f1f1f1;">
                                <p style="margin:0px;font-size:10px">**This is an Auto-generated Copy and does not require a signature**</p>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                  </td>
                </tr>
              </tbody>
          </table>
  </div>  

  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>