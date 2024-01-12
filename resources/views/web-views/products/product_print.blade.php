
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
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
  

  <meta name="theme-color" content="#fafafa">
</head>

<body>
  
  <div style="width: 1080px;height:100%;margin-left:-30px;margin-right:-30px;margin-top:-30px;background: #fff;">
    <div style="height:90%;padding: 20px 60px;margin-top: 30px;">
        <table style="width: 100%;" >
             <tbody>
              <tr>
                <td style="width: 100%;text-align: center;">
                  <img src="{!! asset('/assets/frontend/img/quotation_logo.png') !!}" style="width: 250px;">
                </td>
              </tr>
              <tr><td style="height:30px;"></td></tr>
              <tr style="border-bottom: 1px solid #cacaca;"></tr>
            </tbody>
          </table>
          <!-- --- -->


          <table style="margin-top: 20px;margin-bottom: 30px;">
             <tbody>
              <tr style="">
                <td style="width: 40%;">
                    <img src="{{asset("storage/product/thumbnail/$single_product->thumbnail")}}" style="width: 100%;margin-right: 20px;">
                </td>
                <td style="width: 100%;padding-left: 20px;display: block;">
                    <h2 style="font-size: 20px;font-family: 'Poppins', sans-serif;">{!! $single_product->name !!}</h2>
                    <p style="font-family: 'Poppins', sans-serif;"> <strong></strong></p>
                    <p style="font-family: 'Poppins', sans-serif;">Product SKU #{!! $single_product->code !!}</p>
                    <h2 style="font-size: 20px;font-family: 'Poppins', sans-serif;">{{\App\CPU\Helpers::currency_converter(
                            $single_product->unit_price-(\App\CPU\Helpers::get_product_discount($single_product,$single_product->unit_price))
                            )}}</h2>
                    @if($single_product->is_emi==1)
                      <p style="font-family: 'Poppins', sans-serif;">*EMI Available.</p>
                     @endif
                    <h4 style="font-size: 20px;font-family: 'Poppins', sans-serif;">Features</h4>
                    <div style="font-family: 'Poppins', sans-serif;font-size: 14px;">
                       @if(!empty($single_product->features))
                          {!! $single_product->features !!}
                          @endif
                    </div>
 						
                  <!--   <table>
                      <tbody>
                        <tr>
                          <td style="font-family: 'Poppins', sans-serif;">Brand Name:</td>
                          <td style="padding-left: 10px;font-family: 'Poppins', sans-serif;">{!! $single_product->brand->name ?? ''  !!}</td>
                        </tr>
                        <tr>
                          <td style="font-family: 'Poppins', sans-serif;">Model:</td>
                          <td style="padding-left: 10px;font-family: 'Poppins', sans-serif;">M600DZ</td>
                        </tr>
                        <tr>
                          <td >Input:</td>
                          <td style="padding-left: 10px;">220~240v</td>
                        </tr>
                        <tr>
                          <td>Load:</td>
                          <td style="padding-left: 10px;">600kg</td>
                        </tr>
                      </tbody>
                    </table> -->
                </td>
              </tr>
              
            </tbody>
          </table>
          <!-- --- -->



          <table style="width: 100%;margin-top:50px;">
              <tbody>
                <tr style="display: flex;">
                  <td style="width:40%;margin-right:30px;">
                    <h4 style="font-size: 22px;margin-bottom: 20px;font-family: 'Poppins', sans-serif;">Specification</h4>
                    <div style="font-family: 'Poppins', sans-serif;font-size: 14px;">
                        {!! $single_product->specifications !!}
                            
                    </div>
                  </td>
                  <td style="width:56%">
                    <h4 style="font-size: 22px;margin-bottom: 20px;font-family: 'Poppins', sans-serif;">Description</h4>
                    <div style="font-family: 'Poppins', sans-serif;font-size: 14px;">
                       {!! $single_product->details !!}
                    </div>
                  </td>
                </tr>
                <!--<tr>-->
                <!--  <td>-->
                <!--     <h4 style="font-size: 22px;margin-bottom: 20px;margin-top: 40px;font-family: 'Poppins', sans-serif;">Quick Links</h4>-->
                <!--     <div style="font-family: 'Poppins', sans-serif;">-->
                <!--        {!! $single_product->quick_links !!}-->
                <!--    </div>-->
                <!--  </td>-->
                <!--</tr>-->
              </tbody>
          </table>
          <!-- --- -->
            
    </div>
    <!-- <table style="margin-top:40px;">
              <tbody>
                <tr>
                  <td>
                      <table class="table" style="margin-bottom: 0px!important;">
                           <tbody>
                            <tr style="background:#f1f1f1;">
                              <td style="border: none;width: 30%;padding: 10px 54px; background:#f1f1f1;font-family: 'Poppins', sans-serif;">
                                <h4 style="font-size: 18px;font-family: 'Poppins', sans-serif;">Registered Office:</h4>
                                <p style="margin:0px;font-size:13px;font-family: 'Poppins', sans-serif;">Level 11 & 12, Medona Tower, 28, Mohakhali C/A, Dhaka-1212</p>                              </td>

                              <td style="border: none;width: 30%;padding: 10px 54px;background:#f1f1f1;font-family: 'Poppins', sans-serif;">
                                <h4 style="font-size: 18px;font-family: 'Poppins', sans-serif;">Operational Office:</h4>
                                <p style="margin:0px;font-size:13px;font-family: 'Poppins', sans-serif;">100-103, Hazi Samsul Islam Tower, 2nd Floor, Nawabpur Road, Dhaka - 1100</p>
                              </td>
                              <td style="border: none;padding: 10px 54px; background:#f1f1f1;font-family: 'Poppins', sans-serif;">
                                <h4 style="font-size: 18px;font-family: 'Poppins', sans-serif;">Email us at:</h4>
                                <p style="margin:0px;font-size:13px;font-family: 'Poppins', sans-serif;">sales@malamal.com.bd</p>
                                <p style="margin:0px;font-size:13px;font-family: 'Poppins', sans-serif;">+8809638212121 (10am to 7pm)</p>
                                <p style="margin:0px;font-size:13px;font-family: 'Poppins', sans-serif;">+8809638212121 (10am to 7pm)</p>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                  </td>
                </tr>
              </tbody>
          </table> -->
  </div>
  

  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>