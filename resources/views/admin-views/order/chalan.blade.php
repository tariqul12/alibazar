
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" >
  

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
  <div style="border: 1px solid black;height:100%;margin-left:-30px;margin-right:-30px;background: #fff;font-family: 'Poppins', sans-serif;">
    <div style="height:95%;padding: 20px 20px;margin-top: 10px; font-family: 'Poppins', sans-serif;">
        <table style="width: 100%;font-family: 'Poppins', sans-serif;" >
             <tbody>
              <tr>
                <td style="width: 50%;">

                    <p style="margin: 0px;font-size: 15px;font-weight: bold;font-family: 'Poppins', sans-serif;">{{$company_name}}</p><br>
                    <p style="margin: 0px;font-size: 10px;font-family: 'Poppins', sans-serif;"><strong>BIN: 003682245-0101</strong></p>
                    <p style="margin: 0px;font-size: 10px;font-family: 'Poppins', sans-serif;">{{$shop_address}}</p>
                    <p style="margin: 0px;font-size: 10px;margin-bottom: 7px;font-family: 'Poppins', sans-serif;">{{ $company_phone}}</p>
                </td>
                <td style="width: 50%;">
                   <img src="{!! asset('public/assets/frontend/img/quotation_logo.png') !!}" style="width: 250px;margin-left: 80px;margin-bottom: 15px;">
                </td>
              </tr>
              <tr style="border-bottom: 1px solid #cacaca;"></tr>
            </tbody>
          </table>
          <!-- --- -->
          <table style="width: 100%;border: 1px solid #000;margin-top:30px;margin-bottom:30px;">
            <tbody>
              <tr>
                <td style="text-align: center;font-size: 18px;font-weight: bold;border: 1px solid #000;margin-top: 10px;padding: 5px;width: 20%;font-family: 'Poppins', sans-serif;">Delivery Chalan</td>
              </tr>
            </tbody>
          </table>
          <table>
             <tbody>
              <tr style="margin-top: 10px;display: block;">
                <td style="width: 80%;">
                     <div style="margin-top:100px;">
                      <p style="margin: 0px;font-weight: bold;font-family: 'Poppins', sans-serif;">Billing Address</p>
                      <p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif;">{{$order->billingAddress ? $order->billingAddress['contact_person_name'] : ""}}</p>
                      <p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif;">{{$order->billingAddress ? $order->billingAddress['company_name'] : ""}}</p>
                      <p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif;">{{$order->billingAddress ? $order->billingAddress['company_bin'] : ""}}</p>
                      <p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif;">{{$order->billingAddress ? $order->billingAddress['address'] : ""}}</p>
                      <p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif;">{{$order->billingAddress ? $order->billingAddress['city'] : ""}} {{$order->billingAddress ? $order->billingAddress['zip'] : ""}}</p>
                      <p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif;">{{$order->billingAddress ? $order->billingAddress['phone'] : ""}}</p>
                    </div>
                </td>
                <td style="width: 12%;"></td>
                <td style="border:none;" >
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
              <tr>
                <td style="width: 63%;border:none;">
                   <h4 style="font-size: 13px;font-weight: bold;font-family: 'Poppins', sans-serif;">Invoice No: <span>{{ $order->id }}</span></h4>
                  
                </td>
              </tr>
              <tr>
                <td style="width: 63%;border:none;">
                   <p style="margin: 0px;font-size: 13px;"><span style="font-weight: bold;font-family: 'Poppins', sans-serif;">Purchase Order No:</span> {{ $order->purchase_order_no }}</p>
                </td>
              </tr>
              
            </tbody>
          </table>
          <table style="width: 100%;margin-top: 10px;">
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
                <tr style="border: 1px solid #000;background: #c3c1c1;">
                  <th scope="col" style="width: 10%;padding: 6px;border: 1px solid #000;font-family: 'Poppins', sans-serif;text-align:center;font-size:12px;">S.L.</th>
                  <th scope="col" style="width: 70%;padding: 6px;border: 1px solid #000;font-family: 'Poppins', sans-serif;text-align:center;font-size:12px;">Product</th>
                  <th scope="col" style="padding: 6px;border: 1px solid #000;font-family: 'Poppins', sans-serif;text-align:center;font-size:12px;">Qty</th>
                  
                </tr>
                @foreach(\App\Model\OrderDetail::where('order_id', $order->id)->get() as $key=>$details)
                @php $subtotal=($details['price']*$details->qty) @endphp
                <tr style="border: 1px solid #000;background: #fff;">
                  <td style="font-size:12px;padding:6px;border: 1px solid #000;font-family: 'Poppins', sans-serif;text-align:center;">{{$key+1}}</td>
                  <td style="font-size:12px;padding:5px;border: 1px solid #000;font-family: 'Poppins', sans-serif;text-align:center;"><strong> {{$details['product']?$details['product']->name:''}}
                   @if(!empty($details['variant']))
                  <br>
                    {{\App\CPU\translate('variation')}} : {{$details['variant']}}</strong></td>
                    @endif
                  <td style="font-size:12px;padding:5px;border: 1px solid #000;font-family: 'Poppins', sans-serif;text-align:center;">{{$details->qty}}</td>
                </tr>
                @php
                $sub_total+=$details['price']*$details['qty'];
                $total_tax+=$details['tax'];
                $total_shipping_cost+=$details['shipping_cost'];
                $total_discount_on_product+=$details['discount'];
                $total+=($subtotal+$total_tax-$total_discount_on_product);
              @endphp
            @endforeach                
                <tr>
                <td colspan="3">
                   <p style="margin:0px;padding: 3px; color: gray;font-family: 'Poppins', sans-serif;"><small> This is an Auto-generated Copy</small></p>  
                </td>
              </tr>
                
              </tbody>
          </table>

          <table style="width: 100%;margin-top: 80px;">
              <tbody>
                
                <tr>
                  <td style="font-size:12px;padding:6px;height: 150px;">
                    <p style="font-size: 17px;font-weight: bold;border-bottom: 1px solid gray;width: 25%;font-family: 'Poppins', sans-serif;">Delivery by</p>
                    <br>
                    <p style="font-family: 'Poppins', sans-serif;margin-top:20px;">Sing:</p>
                    <br>
                    <p style="font-family: 'Poppins', sans-serif;margin-top:20px;">Date:</p>
                  </td>
                  <td style="font-size:12px;padding:5px;border: 0px;font-family: 'Poppins', sans-serif;"></td>
                  <td style="font-size:12px;padding:5px;height: 150px;font-family: 'Poppins', sans-serif;">
                    <p style="font-size: 17px;font-weight: bold;border-bottom: 1px solid gray;width: 25%;font-family: 'Poppins', sans-serif;">Recived by</p>
                    <br>
                    <p style="font-family: 'Poppins', sans-serif;margin-top:20px;">Sing:</p>
                    <br>
                    <p style="font-family: 'Poppins', sans-serif;margin-top:20px;">Date:</p>
                  </td>
                 
                </tr>
                
              </tbody>
          </table>

    </div>
    
  </div>  

  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>