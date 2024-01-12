
<div class="feature_header">
    <span>{{ \App\CPU\translate('shopping_cart')}}</span>
</div>

<!-- Grid-->
<hr class="view_border">
@php($shippingMethod=\App\CPU\Helpers::get_business_settings('shipping_method'))
@php($cart=\App\Model\Cart::where(['customer_id' => auth('customer')->id()])->get()->groupBy('cart_group_id'))



<div class="row">
    @php($getCart=\App\CPU\CartManager::get_cart())
    <!-- List of items-->
    @if($getCart->count() > 0)
    <section class="col-lg-8">
        @else
        <section class="col-lg-12">
        @endif
        <div class="cart-header">
            
            <p>Your Cart ({{ $getCart->count() }} item)</p>
          </div>
          
          
            @foreach($cart as $group_key=>$group)
            <div class="cart_information mb-3">
                @foreach($group as $cart_key=>$cartItem)
                @if ($shippingMethod=='inhouse_shipping')
                    <?php

                        $admin_shipping = \App\Model\ShippingType::where('seller_id',0)->first();
                        $shipping_type = isset($admin_shipping)==true?$admin_shipping->shipping_type:'order_wise';

                    ?>
                @else
                    <?php
                        if($cartItem->seller_is == 'admin'){
                            $admin_shipping = \App\Model\ShippingType::where('seller_id',0)->first();
                            $shipping_type = isset($admin_shipping)==true?$admin_shipping->shipping_type:'order_wise';
                        }else{
                            $seller_shipping = \App\Model\ShippingType::where('seller_id',$cartItem->seller_id)->first();
                            $shipping_type = isset($seller_shipping)==true?$seller_shipping->shipping_type:'order_wise';
                        }
                    ?>
                @endif

                    @if($cart_key==0)
                        @if($cartItem->seller_is=='admin')
                            <!--<p>-->
                            <!--    <span>{{ \App\CPU\translate('shop_name')}} : </span>-->
                            <!--    <a href="{{route('shopView',['id'=>0])}}" class="j-white">{{\App\CPU\Helpers::get_business_settings('company_name')}}</a>-->
                            <!--</p>-->
                        @else
                            <b>
                                <span>{{ \App\CPU\translate('shop_name')}}:</span>
                                <a href="{{route('shopView',['id'=>$cartItem->seller_id])}}">
                                    {{\App\Model\Shop::where(['seller_id'=>$cartItem['seller_id']])->first()->name}}
                                </a>
                            </b>
                        @endif
                    @endif
                @endforeach
                <!--<div class="table-responsive">-->
                <div class="" id="cart_details">
                    <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        style="width: 100%">
                        <thead class="cart-tb-head">
                            <tr class="">
                                <th class="font-weight-bold" style="width: 5%;">{{\App\CPU\translate('SL#')}}</th>
                                @if ( $shipping_type != 'order_wise')
                                <th class="font-weight-bold" style="width: 30%;">{{\App\CPU\translate('product_details')}}</th>
                                @else
                                <th class="font-weight-bold" style="width: 45%;">{{\App\CPU\translate('product_details')}}</th>
                                @endif
                                <th class="font-weight-bold" style="width: 15%;">{{\App\CPU\translate('unit_price')}}</th>
                                <th class="font-weight-bold" style="width: 15%;">{{\App\CPU\translate('qty')}}</th>
                                <th class="font-weight-bold" style="width: 15%;">{{\App\CPU\translate('price')}}</th>
                                {{-- @if ( $shipping_type != 'order_wise')
                                    <th class="font-weight-bold" style="width: 15%;">{{\App\CPU\translate('shipping_cost')}} </th>
                                @endif --}}
                                <th class="font-weight-bold" style="width: 5%;">Action</th>
                            </tr>
                        </thead>

                @foreach($group as $cart_key=>$cartItem)

                        <tbody>
                            <tr class="tr-border">
                                <td>{{$cart_key+1}}</td>
                                <td>
                                    <div class="d-flex">
                                        <div style="width: 30%;">
                                            <a href="{{route('frontend.product_details',$cartItem['slug'])}}">
                                                <img style="height: 62px;"
                                                        onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'"
                                                        src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$cartItem['thumbnail']}}"
                                                        alt="Product">
                                            </a>
                                        </div>
                                        <div class="ml-2 text-break" style="width:70%;">
                                            <a href="{{route('frontend.product_details',$cartItem['slug'])}}">{{$cartItem['name']}}</a>

                                        </div>

                                    </div>
                                    <div class="d-flex">

                                        @foreach(json_decode($cartItem['variations'],true) as $key1 =>$variation)
                                            <div class="text-muted mr-2">
                                                <span class="{{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}"
                                                    style="font-size: 12px;">
                                                    {{$key1}} : {{$variation}}</span>

                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <div
                                            class=" text-accent">{{ \App\CPU\Helpers::currency_converter($cartItem['price']-$cartItem['discount']) }}</div>
                                        {{-- @if($cartItem['discount'] > 0)
                                            <strike style="font-size: 12px!important;color: grey!important;">
                                                {{\App\CPU\Helpers::currency_converter($cartItem['price'])}}
                                            </strike>
                                        @endif --}}
                                        </div>
                                </td>
                                <td>
                                    <div>
                                        @php($minimum_order=\App\Model\Product::select('minimum_order_qty')->find($cartItem['product_id']))
                                        {{-- <select name="quantity[{{ $cartItem['id'] }}]" id="cartQuantity{{$cartItem['id']}}"
                                                onchange="updateCartQuantity('{{$cartItem['id']}}')">
                                            @for ($i = $minimum_order_limit??1; $i <= 10; $i++)
                                                <option
                                                    value="{{$i}}" {{$cartItem['quantity'] == $i?'selected':''}}>
                                                    {{$i}}
                                                </option>
                                            @endfor
                                        </select> --}}
                                        <div class="count-and-price">
                                        <div class="spinbutton-wrapper">
                                            <div class="spinbutton" style="display: flex;">
                                                <button class="minus" type="button" onclick="reviewDecreaseQtycart('{{ $minimum_order->minimum_order_qty }}','{{$cartItem['id']}}')">-</button>
                                                <input style="width: 75px;min-height: 26px;" class="val" type="number" name="quantity[{{ $cartItem['id'] }}]" id="cartQuantity{{$cartItem['id']}}"
                                                    onchange="updateReviewCartQuantity('{{ $minimum_order->minimum_order_qty }}', '{{$cartItem['id']}}')" min="{{ $minimum_order->minimum_order_qty ?? 1 }}" value="{{$cartItem['quantity']}}">
                                                <button class="plus" type="submit" onclick="reviewincreaseQtycart('{{ $minimum_order->minimum_order_qty }}','{{$cartItem['id']}}')">+</button>
                                            </div>
                                        </div>
                                        </div>
                                        
                                    </div>
                                </td>
                                <td>
                                    <div>
                                       <span id="sub_total{{$cartItem['id']}}">{{ \App\CPU\Helpers::currency_converter(($cartItem['price']-$cartItem['discount'])*$cartItem['quantity']) }}</span> 
                                    </div>
                                </td>
                               {{-- <td>
                                    @if ( $shipping_type != 'order_wise')
                                       <span id="shipping_val{{$cartItem['id']}}"> {{ \App\CPU\Helpers::currency_converter($cartItem['shipping_cost']) }}</span>
                                    @endif
                                </td> --}}
                                <td>
                                    <button class="btn btn-link px-0 text-danger"
                                        onclick="removeFromCart('{{$cartItem['id']}}')" type="button"><i
                                        class="czi-close-circle {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}"></i>
                                </button>
                                </td>
                            </tr>

                            @if($shippingMethod=='sellerwise_shipping' && $shipping_type == 'order_wise')
                                @php($choosen_shipping=\App\Model\CartShipping::where(['cart_group_id'=>$cartItem['cart_group_id']])->first())

                                @if(isset($choosen_shipping)==false)
                                    @php($choosen_shipping['shipping_method_id']=0)
                                @endif

                                @php($shippings=\App\CPU\Helpers::get_shipping_methods($cartItem['seller_id'],$cartItem['seller_is']))
                            <tr>
                                <td colspan="4">

                                    @if($cart_key==$group->count()-1)

                                    <!-- choosen shipping method-->

                                        <div class="row">

                                            <div class="col-12">
                                                <select class="form-control"
                                                        onchange="set_shipping_id(this.value,'{{$cartItem['cart_group_id']}}')">
                                                    <option>{{\App\CPU\translate('choose_shipping_method')}}</option>
                                                    @foreach($shippings as $shipping)
                                                        <option
                                                            value="{{$shipping['id']}}" {{$choosen_shipping['shipping_method_id']==$shipping['id']?'selected':''}}>
                                                            {{$shipping['title'].' ( '.$shipping['duration'].' ) '.\App\CPU\Helpers::currency_converter($shipping['cost'])}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    @endif
                                </td>
                                <td colspan="3">
                                    @if($cart_key==$group->count()-1)
                                    <div class="row">
                                        <div class="col-12">
                                            <span>
                                                <b>{{\App\CPU\translate('shipping_cost')}} : </b>
                                            </span>
                                            {{\App\CPU\Helpers::currency_converter($choosen_shipping['shipping_method_id']!= 0?$choosen_shipping->shipping_cost:0)}}
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endif
                        </tbody>
                @endforeach
            </table>
                <div class="mt-3"></div></div>
            </div>
            @endforeach

            <!--@if($shippingMethod=='inhouse_shipping')-->
                <?php
                  //  $admin_shipping = \App\Model\ShippingType::where('seller_id',0)->first();
                  //  $shipping_type = isset($admin_shipping)==true?$admin_shipping->shipping_type:'order_wise';
                ?>
            <!--    @if ($shipping_type == 'order_wise')-->
            <!--        @php($shippings=\App\CPU\Helpers::get_shipping_methods(1,'admin'))-->
            <!--        @php($choosen_shipping=\App\Model\CartShipping::where(['cart_group_id'=>$cartItem['cart_group_id']])->first())-->

            <!--        @if(isset($choosen_shipping)==false)-->
            <!--            @php($choosen_shipping['shipping_method_id']=0)-->
            <!--        @endif-->
            <!--        <div class="row">-->
            <!--            <div class="col-12">-->
            <!--                <select class="form-control" onchange="set_shipping_id(this.value,'all_cart_group')">-->
            <!--                    <option>{{\App\CPU\translate('choose_shipping_method')}}</option>-->
            <!--                    @foreach($shippings as $shipping)-->
            <!--                        <option-->
            <!--                            value="{{$shipping['id']}}" {{$choosen_shipping['shipping_method_id']==$shipping['id']?'selected':''}}>-->
            <!--                            {{$shipping['title'].' ( '.$shipping['duration'].' ) '.\App\CPU\Helpers::currency_converter($shipping['cost'])}}-->
            <!--                        </option>-->
            <!--                    @endforeach-->
            <!--                </select>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    @endif-->
            <!--@endif-->

            @if( $cart->count() == 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="emty-cart-box">
                        <img src="{{asset('/assets/front-end/img/icon/empty.gif')}}" alt="empty cart">
                        <h3>Your Cart is Empty</h3>
                        <p>Explore our wide selections and find something you like</p>
                        <a href="{{route('home')}}" class="shop-now">Shop Now</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="cart-need">
                        <p><span class="need-color">Need help? Please visit</span> Help center <span class="need-color">or</span> Contact us</p>
                    </div>
                </div>
            </div>
             
            @endif



            <div class="row pt-2">
                @if($getCart->count() > 0)
                <div class="col-12">
                    
                    <a href="{{route('home')}}" class="btn btn--primary continue_shopping_btn">
                        <i class="fa fa-{{Session::get('direction') === "rtl" ? 'forward' : 'backward'}} px-1"></i> {{\App\CPU\translate('continue_shopping')}}
                    </a>
                    <a onclick="checkout()"
                    class="btn btn--primary pull-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                        {{\App\CPU\translate('checkout')}}
                        <i class="fa fa-{{Session::get('direction') === "rtl" ? 'backward' : 'forward'}} px-1"></i>
                    </a>
                </div>
                @endif

                <!--<div class="col-6">
                    <a onclick="checkout()"
                    class="btn btn--primary pull-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                        {{\App\CPU\translate('checkout')}}
                        <i class="fa fa-{{Session::get('direction') === "rtl" ? 'backward' : 'forward'}} px-1"></i>
                    </a>
                </div>-->
            </div>

    </section>
    
    @if($getCart->count()> 0)
    <!-- Sidebar-->
    @include('web-views.partials._order-summary')
    @endif
</div>

<style>
    .btn--primary{
        background-color: #e9611e!important;
        border-color: #e9611e!important;
        color:#fff!important;
    }
    .justify-content-between{
    padding: 7px 0px;
}

.cart_total{
    box-shadow: 0px 0px 3px #FB641B;
}
.cart-header {
    background-color: #FFFFFF;
    padding: 20px;
    margin-bottom: 15px;
    box-shadow: 0 4px 10px 0 #0000001a;
}
 .cart-header p {
    margin: 0;
}

.cart-tb-head{
    font-size: 14px;
    background-color: #F4F4F4;
    padding: 12px 20px;
}
.cart_information {
    background: white;
    border-radius: 0px;
    padding: 0px;
}
.cart_information p{
    background: #0E2F56;
    padding: 5px 10px;
    color: #fff;
}
.j-white{
    color: #fff!important;
}

.tr-border{
    border:1px solid gray;
    border-left:0px;
    border-right:0px;
}
</style>
<script>
    cartQuantityInitialize();

    function set_shipping_id(id, cart_group_id) {
        $.get({
            url: '{{url('/')}}/customer/set-shipping-method',
            dataType: 'json',
            data: {
                id: id,
                cart_group_id: cart_group_id
            },
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                location.reload();
            },
            complete: function () {
                $('#loading').hide();
            },
        });
    }
  
</script>
<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
       function updateReviewCartQuantity(minimum_order_qty, key) {
            /* var quantity = $("#cartQuantity" + key).children("option:selected").val(); */
            var quantity = $("#cartQuantity" + key).val();
            if (minimum_order_qty > quantity) {
                toastr.error('{{ \App\CPU\translate('minimum_order_quantity_cannot_be_less_than_') }}' +
                    minimum_order_qty);
                $("#cartQuantity" + key).val(minimum_order_qty);
                return false;
            } 
        $.ajax({
                type: 'POST',
                url: "{{ route('cart.updateReviewQuantity') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    key: key,
                    quantity: quantity
                },
                success: function(response) {
                var response=response.response;
                if (response.status == 1) {
                    document.getElementById("shipping_val"+response.key).innerHTML ="TK"+ response.shipping_cost;
                    document.getElementById("sub_total"+response.key).innerHTML ="TK"+ response.sub_total;
                    document.getElementById("sub_total_summary").innerHTML ="TK"+ response.summary_total;
                    document.getElementById("tax_summary").innerHTML ="TK"+ response.summary_tax;
                    document.getElementById("shipping_summary").innerHTML ="TK"+ response.summary_shipping_cost;
                    document.getElementById("total_summary").innerHTML ="TK"+ response.total_summary;
                    $("#cartQuantity" + key).val(response['qty']);
                }
                }
            });
        }
        function reviewincreaseQtycart(minimum_order_qty,key){
            var quantity =parseInt($("#cartQuantity"+key).val());
            var new_quantity=quantity+1;
            if (minimum_order_qty > quantity) {
                toastr.error('{{ \App\CPU\translate('minimum_order_quantity_cannot_be_less_than_') }}' +
                    minimum_order_qty);
                $("#cartQuantity" + key).val(minimum_order_qty);
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{{ route('cart.updateReviewQuantity') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    key: key,
                    quantity: new_quantity
                },
                success: function(response) {
                var response=response.response;
                if (response.status == 1) {
                    // document.getElementById("shipping_val"+response.key).innerHTML ="TK "+""+ response.shipping_cost.toLocaleString('en-US', {maximumFractionDigits:2});
                    // document.getElementById("sub_total"+response.key).innerHTML ="TK "+""+ response.sub_total.toLocaleString('en-US', {maximumFractionDigits:2});
                    // document.getElementById("sub_total_summary").innerHTML ="TK "+""+ response.summary_total.toLocaleString('en-US', {maximumFractionDigits:2});
                    // document.getElementById("tax_summary").innerHTML ="TK "+""+ response.summary_tax.toLocaleString('en-US', {maximumFractionDigits:2});
                    // document.getElementById("shipping_summary").innerHTML ="TK "+""+ response.summary_shipping_cost.toLocaleString('en-US', {maximumFractionDigits:2});
                    // document.getElementById("total_summary").innerHTML ="TK "+""+ response.total_summary.toLocaleString('en-US', {maximumFractionDigits:2});
                    // $("#cartQuantity" + key).val(response['qty']);
                     $("#cart_details").load(" #cart_details > *");
                     $("#cart_total").load(" #cart_total > *");
                }
                }
            });
        }
        function reviewDecreaseQtycart(minimum_order_qty,key){
            var quantity =parseInt($("#cartQuantity"+key).val());
            var new_quantity=quantity-1;
            if (minimum_order_qty > new_quantity) {
                toastr.error('{{ \App\CPU\translate('minimum_order_quantity_cannot_be_less_than_') }}' +
                    minimum_order_qty);
               var min=parseInt(minimum_order_qty)+1;
                $("#cartQuantity" + key).val(min);
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{{ route('cart.updateReviewQuantity') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    key: key,
                    quantity: new_quantity
                },
                success: function(response) {
                var response=response.response;
                if (response.status == 1) {
                    // document.getElementById("shipping_val"+response.key).innerHTML ="TK "+""+ response.shipping_cost.toLocaleString('en-US', {maximumFractionDigits:2});
                    // document.getElementById("sub_total"+response.key).innerHTML ="TK "+""+ response.sub_total.toLocaleString('en-US', {maximumFractionDigits:2});
                    // document.getElementById("sub_total_summary").innerHTML ="TK "+""+ response.summary_total.toLocaleString('en-US', {maximumFractionDigits:2});
                    // document.getElementById("tax_summary").innerHTML ="TK "+""+ response.summary_tax.toLocaleString('en-US', {maximumFractionDigits:2});
                    // document.getElementById("shipping_summary").innerHTML ="TK "+""+ response.summary_shipping_cost.toLocaleString('en-US', {maximumFractionDigits:2});
                    // document.getElementById("total_summary").innerHTML ="TK "+""+ response.total_summary.toLocaleString('en-US', {maximumFractionDigits:2});
                    // $("#cartQuantity" + key).val(response['qty']);
                    // $("#cart_total").load(" #cart_total > *");
                    $("#cart_details").load(" #cart_details > *");
                    $("#cart_total").load(" #cart_total > *");
                }
                }
            });
        }
    function checkout(){
        let order_note = $('#order_note').val();
        //console.log(order_note);
        $.post({
            url: "{{route('order_note')}}",
            data: {
                    _token: '{{csrf_token()}}',
                    order_note:order_note,

                },
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                let url = "{{ route('checkout-details') }}";
                location.href=url;

            },
            complete: function () {
                $('#loading').hide();
            },
        });
    }

</script>