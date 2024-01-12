
<!doctype html>
<html class="no-js" lang="en">

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
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
    crossorigin="anonymous">
  <link rel="stylesheet" href="{{asset('public/assets/back-end/mushok/css/owl.carousel.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/back-end/mushok/css/owl.theme.default.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/back-end/mushok/css/main.css')}}">

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
    $vat_percent =BusinessSetting::where('type', 'vat_settings')->first()->value;
@endphp    
  
  <div style="background: #fff;">
    <div >
        <table style="width: 100%;">
          <tr>
            <td style="width:15%;"><img src="{{asset("storage/app/public/admin/musok.png")}}" style="width: 80px;"></td>
            <td style="width:70%;text-align: center;font-size: 14px;">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার </td>
            <td style="width:15%;"><p>মূসক ৬.৩ </p></td>
          </tr>
        </table>

        <table style="width: 100%;">
          
          <tr>
            <td style="width:0%;"></td>
            <td style="width:65%;text-align:center;">
                <p style="text-align:center;font-size: 15px;">কর চালানপত্র </p>
                <p style="text-align: center;margin: 0px;font-size: 12px;">[বিধি ৪০ এর উপ-বিধি (১)এর দফা (গ) ও দফা (চ) দ্রষ্টব্য] </p>
                
            </td>
          </tr>
        </table>

        <table style="width: 100%;margin-bottom: 20px;">
          
          <tr>
            <td style="width:15%;"></td>
            <td style="width:85%;">
                <p style="margin: 0px;font-size: 12px;">নিবন্ধিত ব্যক্তির নাম: Malamal.xyz Ltd </p>
                
                <p style="margin: 0px;font-size: 12px;font-family: 'Poppins', sans-serif;">নিবন্ধিত ব্যক্তির বিআইএন: <span>003683345-00101</span></p>
                
                <p style="margin: 0px;font-size: 12px;">চালানপত্র ইস্যু ঠিকানা: Medona Tower 28, Level 12, Mohakhali C/A, Dhaka 1212 </p>

            </td>
          </tr>
        </table>



          <table style="width:100%;margin-bottom: 20px;">
             <tbody>
              <tr >
                <td style="width: 60%;">
                    <p style="margin: 0px;font-size: 12px;">ক্রেতার নাম:<span> {{$order->customer['f_name'].' '.$order->customer['l_name']}}</span></p>
                    <p style="margin: 0px;font-size: 12px;">ক্রেতার বিআইএন:<span> {{$order->billingAddress ? $order->billingAddress['company_bin'] : ""}}</span></p>
                    <p style="margin: 0px;font-size: 12px;">সরবরাহের গন্তব্যস্থল:<span> {{$order->billingAddress ? $order->billingAddress['address'] : ""}}</span></p>
                </td>
                <td style="width: 40%;">
                    <p style="margin: 0px;font-size: 12px;">চালানপত্র নম্বর:<span>{{isset($order->challan_no)?$order->challan_no:'__________________'}}</span></p>
                    <p style="margin: 0px;font-size: 12px;">ইস্যুর তারিখ:<span> {{date('d M Y')}}</span></p>
                    <p style="margin: 0px;font-size: 12px;">ইস্যুর সময়:<span> {{date('H:i:s')}}</span></p>
                    
                </td>
              </tr>
             
              
            </tbody>
          </table>
          <!-- --- -->
          <table style="width: 100%;margin-top: 10px;border: 1px solid #000;">
            @php
                $subtotal=0;
                $total=0;
                $sub_total=0;
                $total_tax=0;
                $total_shipping_cost=0;
                $total_discount_on_product=0;
                $extra_discount=0;
                $total_mushok_rate=0;
                $total_mushok_rate_value=0;
                
            @endphp
              <tbody>
                <tr style="text-align:center; font-size: 12px;border-bottom: 1px solid #000;">
                  <td style="padding: 6px;border: 1px solid #000;border-bottom: 1px solid #000">ক্রমিক </td>
                  <td style="padding: 6px;border: 1px solid #000;width: 19%;">পণ্য বা সেবার বর্ণনা </br> (প্রযোজ্য ক্ষেত্রে ব্র্যান্ড নামসহ) </td>
                  <td style="padding: 6px;border: 1px solid #000;">সরবরাহের একক </td>
                  <td style="padding: 6px;border: 1px solid #000;">পরিমাণ </td>
                  <td style="padding: 6px;border: 1px solid #000;">একক</br> মূল্য (টাকায় ) </td>
                  <td style="padding: 6px;border: 1px solid #000;">মোট </br> মূল্য (টাকায়) </td>
                  <td style="padding: 6px;border: 1px solid #000;">সম্পূরক শুল্কের</br> পরিমাণ</br> (টাকায়) </td>
                  <td style="padding: 6px;border: 1px solid #000;">মূল্য সংযোজন </br>করের হার/</br> সুনির্দিষ্ট কর  </td>
                  <td style="padding: 6px;border: 1px solid #000;">মূল্য সংযোজন</br> কর/ সুনির্দিষ্ট </br>কর এর পরিমাণ </br>(টাকায়) </td>
                  <td style="padding: 6px;border: 1px solid #000;"> সকল প্রকার</br> শুল্ক ও করসহ</br> মূল্য</td>
                  
                </tr>
                
                @foreach(\App\Model\OrderDetail::where('order_id', $order->id)->get() as $key=>$details)
                @php $subtotal=($details['price']*$details->qty) @endphp  
                
                <tr style="text-align:center; font-size: 12px;border-bottom: 1px solid #000;">
                  <td style="padding:6px;border: 1px solid #000;">{{$key+1}}</td>
                  <td style="padding:6px;border: 1px solid #000; font-size: 12px;">{{$details['product']?$details['product']->name:''}}</br>{{\App\CPU\translate('variation')}} : {{$details['variant']}}</td>
                  <td style="padding:6px;border: 1px solid #000; font-size: 12px;text-align:center;">Piece </td>
                  <td style="padding:6px;border: 1px solid #000; font-size: 12px;text-align:center;">{{$details->qty}}</td>
                  <td style="padding:6px;border: 1px solid #000; font-size: 12px;text-align:center;">{{$details->price}}</td>
                  <td style="padding:6px;border: 1px solid #000; font-size: 12px;text-align:center;">{{$details->qty * ($details->price)}}</td>
                  <td style="padding:6px;border: 1px solid #000; font-size: 12px;text-align:center;">-</td>
                  <td style="padding:6px;border: 1px solid #000; font-size: 12px;text-align:center;">{{$vat_percent}}%</td>
                  <td style="padding:6px;border: 1px solid #000; font-size: 12px;text-align:center;">{{round((($vat_percent/100) * ($details->price)),2)}}</td>
                  <td style="padding:6px;border: 1px solid #000; font-size: 12px;text-align:center;">{{round(($details->qty * ($details->price)) + (($vat_percent/100) * ($details->price)),)}}</td>
                </tr>
                @php
                $total_mushok_rate +=($vat_percent/100) * ($details->price);
                $total_mushok_rate_value +=($details->qty * ($details->price)) + (($vat_percent/100) * ($details->price));
                $sub_total+=$details['price']*$details['qty'];
                $total_tax+=$details['tax'];
                $total_shipping_cost+=$details['shipping_cost'];
                $total_discount_on_product+=$details['discount'];
                $total+=($subtotal+$total_tax-$total_discount_on_product);
              @endphp
            @endforeach                
                <tr style="font-size: 12px;">
                  <td colspan="6" style="padding:6px;border: 1px solid #000;text-align: right;">সর্বমোট:</td>
                  <td style="padding:6px;border: 1px solid #000;text-align: center; font-size: 12px;"></td>
                  <td style="padding:6px;border: 1px solid #000;text-align: center; font-size: 12px;"></td>
                  <td style="padding:6px;border: 1px solid #000;text-align: center; font-size: 12px;">{{$total_mushok_rate}}</td>
                  <td style="padding:6px;border: 1px solid #000;text-align: center; font-size: 12px;">{{$total_mushok_rate_value}}</td>
                </tr>
              </tbody>
          </table>

          <table style="width: 100%;margin-top: 10px;">
              <tbody>
                <tr>
                  <td style="font-size:12px">প্রতিষ্ঠান কর্তৃপক্ষের দায়িত্বপ্রাপ্ত ব্যক্তির নাম:</td>
                </tr>
                <tr>
                  <td style="font-size:12px">পদবী:</td>
                </tr>
                <tr>
                  <td style="font-size:12px">স্বাক্ষর:</td>
                </tr>
                <tr>
                  <td style="font-size:12px">উৎসে কর্তনযোগ্য সরবরাহের ক্ষেত্রে ফরমটি সমন্বিত কর চালানপত্র ও উৎসে কর কর্তন সনদপত্র হিসাবে বিবেচিত হইবে এবং উহা উৎসে কর কর্তনযোগ্য সরবরাহের</br> ক্ষেত্রে প্রযোজ্য হবে। </td>
                </tr>
                <tr>
                  <td style="font-size:12px;">১সকল প্রকার কর ব্যতীত মূল্য:</td>
                </tr>
                <tr>
                  <td style="font-size:12px;height: 200px;"></td>
                </tr>
              </tbody>
          </table>
          <!-- --- -->
           
    </div>
    
  </div>  

  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
    crossorigin="anonymous"></script>
  <script src="{{asset('public/assets/back-end/mushok/js/jquery-3.6.1.min.js')}}"></script>
  <script src="{{asset('public/assets/back-end/mushok/js/owl.carousel.min.js')}}"></script>
  <script src="{{asset('public/assets/back-end/mushok/js/main.js')}}"></script>
</body>
</html>