<style>
    .cart_title {
        font-weight: 400 !important;
        font-size: 16px;
    }

    .cart_value {
        font-weight: 600 !important;
        font-size: 16px;
    }

    .cart_total_value {
        font-weight: 700 !important;
        font-size: 25px !important;
        color: {{$web_config['primary_color']}}     !important;
    }
    
    .pay-title{
    background-color: #0E2F56;
    color: #FFFFFF;
    padding: 15px;
}

.pay-title h5{
    margin: 0px;
    color:#fff;
}
.cart_total {
      background-color: #FFFFFF;
    box-shadow: 0 4px 10px rgb(0 0 0 / 10%)!important;
    border:none;
    
}
.pay-box{
    padding:16px;
}

.nav-tabs .nav-item {
    margin-bottom: -2px!important;
}

</style>
<div class="payment-summary-sec" id="payment_summary">
  <div class="payment-summary">
    <div class="pay-title">
      <h5>Payment Summary</h5>
    </div>
    @php
        use Illuminate\Support\Facades\DB;
        $user_loyalty=DB::table('users')->where('id',auth('customer')->id())->select('loyalty_point')->first();
        $shipping_type=DB::table('shipping_types')->first();
        $user_point_amt=0;
        if(!empty($user_loyalty->loyalty_point)&&$user_loyalty->loyalty_point>0)
            {
                $user_point_amt=($user_loyalty->loyalty_point/2);
            }
    @endphp
    @php($coupon_dis=0)
    @php($sub_total=0)
    @php($total_tax=0)
    @php($total_shipping_cost=0)
    @php($courier_cost=0)
    @php($total_discount_on_product=0)
    @if(auth('customer')->check())
    @php($cart=\App\CPU\CartManager::get_cart())
    @else
    @php($cart = session('offline_cart'))
    @endif
    @php($shipping_cost=\App\CPU\CartManager::get_order_shipping_cost())
    @php($product_wise=\App\CPU\CartManager::get_shipping_cost())
    @if($cart->count() > 0)
        @foreach($cart as $key => $cartItem)
            @php($sub_total+=$cartItem['price']*$cartItem['quantity'])
            @php($total_tax+=$cartItem['tax']*$cartItem['quantity'])
            @php($total_discount_on_product+=$cartItem['discount']*$cartItem['quantity'])
            <?php
            if(!empty($cartItem['courier_id']))
            {
                $courier_prod=DB::table('product_wise_courier')->where('product_id',$cartItem['product_id'])->where('courier_id',$cartItem['courier_id'])->first();
                if(!empty($courier_prod))
                    {
                        if($shipping_type->shipping_type=='order_wise')
                        {
                            $courier_cost +=($courier_prod->amount*$cartItem['quantity']);
                        }
                        else{
                            $courier_cost +=($courier_prod->amount*$cartItem['quantity']);
                        }
                        
                    }
            }
            ?>
        @endforeach
        <?php
         if($shipping_type->shipping_type=='order_wise')
            {
                $total_shipping_cost=$courier_cost+$shipping_cost;
            }
            else{
                $total_shipping_cost=$product_wise;
            }
        ?>
    @else
        <span>{{\App\CPU\translate('empty_cart')}}</span>
    @endif
    <div class="payment-breakdown">
      <div class="item">
        <span class="label">Subtotal</span>
        <span class="amount" id="sub_total_summary">{{\App\CPU\Helpers::currency_converter($sub_total-$total_discount_on_product)}}</span>
      </div>
      @if($total_tax>0)
      <div class="item">
        <span class="label">Vat</span>
        <span class="amount" id="tax_summary">{{\App\CPU\Helpers::currency_converter($total_tax)}}</span>
      </div>
      @endif
      @if ($user_point_amt>0)
        <div class="item">
            <span class="label">Loyalty Discount</span>
            <span class="amount" id="loyalty_summary">{{\App\CPU\Helpers::currency_converter($user_point_amt)}}</span>
        </div>
      @endif
      <div class="item">
        <span class="label">Delivery Charges</span>
         @if($total_shipping_cost>0)
           <span class="amount positive" id="shipping_summary"> {{\App\CPU\Helpers::currency_converter($total_shipping_cost)}}</span>
            @else
            <span class="amount positive" id="shipping_summary" style="color:green"> Free</span>
            @endif
      </div>
        @if(session()->has('coupon_discount'))
            <div class="item" style="display: block!important;">
                
                <p class="coupon_discount_p">
                   
                <span class="label">{{\App\CPU\translate('coupon_discount')}}</span>
                
                <span class="amount" id="coupon-discount-amount">
                    - {{session()->has('coupon_discount')?\App\CPU\Helpers::currency_converter(session('coupon_discount')):0}}
                </span>
                </p>
                <p class="coupon_code_p">(Coupon code: {{session('coupon_code')}}) 
                    <button class="close-code-coupon" type="button" onclick="couponCodeRemove()"><i class="fa-solid fa-xmark"></i></button>
                </p>
            </div>
            
            @php($coupon_dis=session('coupon_discount'))
        @endif
      <div class="item total">
        <span class="label">Total Price</span>
        <span class="amount" id="total_summary_amount">{{\App\CPU\Helpers::currency_converter($sub_total+$total_tax+$total_shipping_cost-$coupon_dis-$total_discount_on_product-$user_point_amt)}}</span>
      </div>
    </div>
    <div class="footnote">
      <p>
        <img src="{{ asset('public/img/icons/shipment.svg') }}" alt="shipment-icon"> Shipping charges applicable as per your location
      </p>
    </div>
  </div>    
  {{-- coupon part --}}
   @if(session()->has('coupon_discount'))
   @else
  <div class="offer-summary" id="">
    <div class="pay-title">
      <h5>Offers Available</h5>
    </div>
 
    <div class="payment-breakdown">
        <div class="check-offer">
            <form class="needs-validation" action="javascript:" method="post" novalidate id="coupon-code-ajax">
            <div class="checkout-offer-input">
                <input type="text" class="form-control cupon-apply-input" name="code" placeholder="Enter Coupon Code" required>
                <div class="invalid-feedback">{{\App\CPU\translate('please_provide_coupon_code')}}</div>
                <button class="btn cupon-apply-btn" type="button" onclick="couponCodeReview()">Apply</button>
            </div>
        </button>
        </div>
    </div>
  </div>
    @php($coupon_dis=0)
  @endif
</div>  

<script>
     function couponCodeReview() {
         var code = $("input[name=code]").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{ route('coupon.apply') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    code: code
                },
                // data: $('#coupon-code-ajax').serializeArray(),
                success: function(data) {
                    /* console.log(data);
                    return false; */
                    if (data.status == 1) {
                        let ms = data.messages;
                        ms.forEach(
                            function(m, index) {
                                toastr.success(m, index, {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                            }
                        );
                      window.bkas_amount=data.price;
                      $("#payment_summary").load(" #payment_summary > *");
                      $("#v-tab-bank-content").load(" #v-tab-bank-content > *");
                      $("#v-tab-card-content").load(" #v-tab-card-content > *");
                    } else {
                        let ms = data.messages;
                        ms.forEach(
                            function(m, index) {
                                toastr.error(m, index, {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                            }
                        );
                    }
                }
            });
        }
        function couponCodeRemove() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{ route('coupon.coupon_remove') }}',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                // data: $('#coupon-code-ajax').serializeArray(),
                success: function(data) {
                    /* console.log(data);
                    return false; */
                    if (data.status == 1) {
                        let ms = data.messages;
                        ms.forEach(
                            function(m, index) {
                                toastr.success(m, index, {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                            }
                        );
                       window.bkas_amount=data.price;
                      $("#payment_summary").load(" #payment_summary > *");
                      $("#v-tab-bank-content").load(" #v-tab-bank-content > *");
                      $("#v-tab-card-content").load(" #v-tab-card-content > *");
                    } else {
                        let ms = data.messages;
                        ms.forEach(
                            function(m, index) {
                                toastr.error(m, index, {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                            }
                        );
                    }
                }
            });
        }
</script>
  
  
  