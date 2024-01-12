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

</style>

<aside class="col-lg-4 pt-4 pt-lg-0">
    <div class="cart_total" id="cart_total">
      
        <div class="pay-title">
            <h5>Payment Summary</h5>
        </div>
        <div class="pay-box">
        @php
            use Illuminate\Support\Facades\DB;
            $user_loyalty=DB::table('users')->where('id',auth('customer')->id())->select('loyalty_point')->first();
            $user_point_amt=0;
            if(!empty($user_loyalty->loyalty_point)&&$user_loyalty->loyalty_point>0)
                {
                    $user_point_amt=($user_loyalty->loyalty_point/2);
                }
        @endphp
        @php($sub_total=0)
        @php($total_tax=0)
        @php($total_shipping_cost=0)
        @php($total_discount_on_product=0)
        @if(auth('customer')->check())
        @php($cart=\App\CPU\CartManager::get_cart())
        @else
        @php($cart = session('offline_cart'))
        @endif
        @php($shipping_cost=\App\CPU\CartManager::get_order_shipping_cost())
        @if($cart->count() > 0)
            @foreach($cart as $key => $cartItem)
                @if(auth('customer')->check())
                @else
                @php($shipping_cost=$cartItem['shipping_cost'])
                @endif
                
                @php($sub_total+=$cartItem['price']*$cartItem['quantity'])
                @php($total_tax+=$cartItem['tax']*$cartItem['quantity'])
                @php($total_discount_on_product+=$cartItem['discount']*$cartItem['quantity'])
            @endforeach
            @php($total_shipping_cost=$shipping_cost)
        @else
            <span>{{\App\CPU\translate('empty_cart')}}</span>
        @endif
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\translate('sub_total')}}</span>
            <span class="cart_value" id="sub_total_summary">
                {{\App\CPU\Helpers::currency_converter($sub_total-$total_discount_on_product)}}
            </span>
        </div>
        @if($total_tax>0)
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\translate('VAT')}}</span>
            <span class="cart_value" id="tax_summary">
                {{\App\CPU\Helpers::currency_converter($total_tax)}}
            </span>
        </div>
        @endif
     {{-- <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\translate('Delivery Charges')}}</span>
            @if($total_shipping_cost>0)
            <span class="cart_value" id="shipping_summary">
                {{\App\CPU\Helpers::currency_converter($total_shipping_cost)}}
            </span>
            @else
            <span class="cart_value" id="shipping_summary" style="color:green">Free</span>
            @endif
        </div> --}}
        @if ($user_point_amt>0)
            <div class="d-flex justify-content-between">
                <span class="cart_title">{{\App\CPU\translate('Loyalty_Discount')}}</span>
                <span class="cart_value">
                    {{\App\CPU\Helpers::currency_converter($user_point_amt)}}
                </span>
            </div>
        @endif
        {{-- <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\translate('discount_on_product')}}</span>
            <span class="cart_value">
                - {{\App\CPU\Helpers::currency_converter($total_discount_on_product)}}
            </span>
        </div> --}}
        @if(session()->has('coupon_discount'))
            <div class="d-flex justify-content-between">
                <span class="cart_title">{{\App\CPU\translate('coupon_discount')}}</span>
                <span class="cart_value" id="coupon-discount-amount">
                    - {{session()->has('coupon_discount')?\App\CPU\Helpers::currency_converter(session('coupon_discount')):0}}
                </span>
                
            </div>
            @php($coupon_dis=session('coupon_discount'))
        @else
            <div class="mt-2">
                <form class="needs-validation" action="javascript:" method="post" novalidate id="coupon-code-ajax">
                    <div class="form-group coupon-group">
                        <input class="form-control input_code" type="text" name="code" placeholder="{{\App\CPU\translate('Coupon code')}}"
                               required>
                        <div class="invalid-feedback">{{\App\CPU\translate('please_provide_coupon_code')}}</div>
                        <button class="btn-block" type="button" onclick="couponCode()">{{\App\CPU\translate('apply_code')}}</button>
                    </div>
                    <!--<button class="btn-block" type="button" onclick="couponCode()">{{\App\CPU\translate('apply_code')}}</button>-->
                </form>
            </div>
            @php($coupon_dis=0)
        @endif
        <hr class="mt-2 mb-2">
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\translate('total')}}</span>
            <span class="cart_value" id="total_summary">
               {{\App\CPU\Helpers::currency_converter($sub_total+$total_tax+$total_shipping_cost-$coupon_dis-$total_discount_on_product-$user_point_amt)}}
            </span>
        </div>

        {{-- <div class="d-flex justify-content-center">
            <span class="cart_total_value mt-2">
                {{\App\CPU\Helpers::currency_converter($sub_total+$total_tax+$total_shipping_cost-$coupon_dis-$total_discount_on_product)}}
            </span>
        </div> --}}
       </div> 
    </div>
    <!--<div class="container mt-2">
        <div class="row p-0">
            <div class="col-md-3 p-0 text-center mobile-padding">
                <img class="order-summery-footer-image" src="{{asset("public/assets/front-end/png/delivery.png")}}" alt="">
                <div class="deal-title">3 {{\App\CPU\translate('days_free_delivery')}} </div>
            </div>

            <div class="col-md-3 p-0 text-center">
                <img class="order-summery-footer-image" src="{{asset("public/assets/front-end/png/money.png")}}" alt="">
                <div class="deal-title">{{\App\CPU\translate('money_back_guarantee')}}</div>
            </div>
            <div class="col-md-3 p-0 text-center">
                <img class="order-summery-footer-image" src="{{asset("public/assets/front-end/png/Genuine.png")}}" alt="">
                <div class="deal-title">100% {{\App\CPU\translate('genuine')}} {{\App\CPU\translate('product')}}</div>
            </div>
            <div class="col-md-3 p-0 text-center">
                <img class="order-summery-footer-image" src="{{asset("public/assets/front-end/png/Payment.png")}}" alt="">
                <div class="deal-title">{{\App\CPU\translate('authentic_payment')}}</div>
            </div>
        </div>
    </div>-->
</aside>