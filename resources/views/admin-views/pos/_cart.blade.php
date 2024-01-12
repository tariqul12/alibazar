<div class="table-responsive pos-cart-table border">
    <table class="table table-align-middle">
        <thead class="text-capitalize bg-light">
        <tr>
            <th class="border-0 min-w-120">{{\App\CPU\translate('item')}}</th>
            <th class="border-0">{{\App\CPU\translate('qty')}}</th>
            <th class="border-0">Net Unit Price</th>
            <th class="border-0">Discount</th>
            <th class="border-0">{{\App\CPU\translate('price')}}</th>
            <th class="border-0 text-center">{{\App\CPU\translate('delete')}}</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $subtotal = 0;
        $addon_price = 0;
        $tax = 0;
        $discount = 0;
        $discount_type = 'amount';
        $discount_on_product = 0;
        $total_tax = 0;
        $ext_discount = 0;
        $ext_discount_type = 'amount';
        $coupon_discount =0;
        $shipping_fee =0;
        $tax_type = '';
        $net_unit_price = 0;
        $total_vat = 0;
        $total_vat_amount = 0;
        $total_fee_amount = 0;
        $total_shipping_amount = 0;
        $vat_type = '';
        $vat = 0;
        ?>
        @if(session()->has($cart_id) && count( session()->get($cart_id)) > 0)
                <?php
                $cart = session()->get($cart_id);
                if(isset($cart['tax']))
                {
                    $tax_type = isset($cart['tax_type']) ? $cart['tax_type'] : '';
                    $tax = $cart['tax'];
                }

                if(isset($cart['vat']))
                {
                    $vat_type = isset($cart['vat_type']) ? $cart['vat_type'] : '';
                    $vat = $cart['vat'];
                }
                if(isset($cart['fee_amount'])) {
                    $total_fee_amount = $cart['fee_amount'];
                }
                if(isset($cart['discount']))
                {
                    $discount = $cart['discount'];
                    $discount_type = $cart['discount_type'];
                }
                if (isset($cart['ext_discount'])) {
                    $ext_discount = $cart['ext_discount'];
                    $ext_discount_type = $cart['ext_discount_type'];
                }
                if(isset($cart['shipping_fee_amount'])) {
                    $total_shipping_amount = $cart['shipping_fee_amount'];
                }
                if(isset($cart['coupon_discount']))
                {
                    $coupon_discount = $cart['coupon_discount'];
                }
                if(isset($cart['pos_shipping_amount']))
                {
                    $shipping_fee = $cart['pos_shipping_amount'];
                }
                ?>
            @foreach(session()->get($cart_id) as $key => $cartItem)
                @if(is_array($cartItem))
                        <?php
                        $net_unit_price = $cartItem['net_unit_price'];
                        $product_subtotal = ($cartItem['price'])*$cartItem['quantity'];
                        $product_discount = $cartItem['discount']*$cartItem['quantity'];
                        $discount_on_product += ($cartItem['discount']*$cartItem['quantity']);
                        $subtotal += $product_subtotal;

                        //tax calculation
                        $product = \App\Model\Product::find($cartItem['id']);
                        $total_tax += \App\CPU\Helpers::tax_calculation($cartItem['price'], $product['tax'], $product['tax_type'])*$cartItem['quantity'];

                        ?>

                    <tr>
                        <td>
                            <div class="media align-items-center gap-10">
                                <img class="avatar avatar-sm" src="{{asset('storage/app/public/product/thumbnail')}}/{{$cartItem['image']}}"
                                     onerror="this.src='{{asset('public/assets/back-end/img/160x160/img2.jpg')}}'" alt="{{$cartItem['name']}} image">
                                <div class="media-body">
                                    <h5 class="text-hover-primary mb-0">{{Str::limit($cartItem['name'], 12)}}</h5>
                                    <small>{{Str::limit($cartItem['variant'], 20)}}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="number" data-key="{{$key}}" class="form-control qty" value="{{$cartItem['quantity']}}" min="1" onkeyup="updateQuantity('{{$cartItem['id']}}',this.value,event,'{{$cartItem['variant']}}')">
                        </td>
                        <td>
                            <input type="number" data-key="{{$key}}" class="form-control pos_product_item_price" style="width: 100px" value="{{$cartItem['price']}}" onchange="updateCartPrice('{{$cartItem['id']}}',this.value,event,'{{$cartItem['variant']}}')">
                        </td>
                        <td>
                            <div>
                                {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($product_discount))}}
                            </div> <!-- price-wrap .// -->
                        </td>
                        <td>
                            <div>
                                {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($product_subtotal))}}
                            </div> <!-- price-wrap .// -->
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="javascript:removeFromCart({{$key}})" class="btn btn-sm btn-outline-danger square-btn"> <i class="tio-delete"></i></a>
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
        @endif
        </tbody>
    </table>
</div>

<?php
$total = $subtotal;

$discount_amount = $discount_on_product;
$discount_amount = 0;
$total -= $discount_amount;

$extra_discount = $ext_discount;
$extra_discount_type = $ext_discount_type;
#updated tax portion
/* $total_tax = $tax;
if($tax_type == 'percent' &&  $tax > 0){
    $total_tax = (($subtotal)*$tax) / 100;
}
if($total_tax) {
    $total += $total_tax;
} */
if($extra_discount_type == 'percent' && $extra_discount > 0){
    $extra_discount =  (($subtotal)*$extra_discount) / 100;
}
if($extra_discount) {
    $total -= $extra_discount;
}

$total_tax_amount= $total_tax;

#updated Vat portion
$total_vat = $vat;
if($vat_type == 'percent' &&  $vat > 0){
    $total_vat = (($subtotal)*$vat) / 100;
}
if($total_vat) {
    $total += $total_vat;
}

$total_vat_amount = $total_vat;
?>
<div class="pt-4">
    <dl>
        <div class="d-flex gap-2 justify-content-between">
            <dt class="title-color text-capitalize font-weight-normal">{{\App\CPU\translate('sub_total')}} : </dt>
            <dd>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($subtotal))}}</dd>
        </div>



        <div class="d-flex gap-2 justify-content-between">
            <dt class="title-color text-capitalize font-weight-normal">{{\App\CPU\translate('extra')}} {{\App\CPU\translate('discount')}} :</dt>
            <dd>
                <button id="extra_discount" class="btn btn-sm" type="button" data-toggle="modal" data-target="#add-discount">
                    <i class="tio-edit"></i></button>
                {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($extra_discount))}}
            </dd>
        </div>

        <div class="d-flex justify-content-between">
            <dt class="title-color gap-2 text-capitalize font-weight-normal">{{\App\CPU\translate('coupon')}} {{\App\CPU\translate('discount')}} :</dt>
            <dd>
                <button id="coupon_discount" class="btn btn-sm" type="button" data-toggle="modal" data-target="#add-coupon-discount">
                    <i class="tio-edit"></i>
                </button>
                {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($coupon_discount))}}
            </dd>
        </div>

        <div class="d-flex gap-2 justify-content-between">
            <dt class="title-color text-capitalize font-weight-normal">Additional Fee : </dt>
            <dd>
                <button id="update_fee" class="btn btn-sm" type="button" data-toggle="modal" data-target="#update-fee">
                    <i class="tio-edit"></i></button>
                {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(round($total_fee_amount,2)))}}
            </dd>
        </div>
         <div class="d-flex gap-2 justify-content-between">
            <dt class="title-color text-capitalize font-weight-normal">Shipping Fee : </dt>
            <dd>
                <button id="shipping_fee" class="btn btn-sm" type="button" data-toggle="modal" data-target="#shipping-fee">
                    <i class="tio-edit"></i></button>
                {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(round($total_shipping_amount,2)))}}
            </dd>
        </div>
        <div class="d-flex gap-2 justify-content-between">
            <dt class="title-color text-capitalize font-weight-normal">Vat : </dt>
            <dd>
                <button id="update_vat" class="btn btn-sm" type="button" data-toggle="modal" data-target="#add-vat">
                    <i class="tio-edit"></i></button>
                {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(round($total_vat_amount,2)))}}
            </dd>
        </div>
        <!--<div class="d-flex justify-content-between">-->
        <!--    <dt class="title-color gap-2 text-capitalize font-weight-normal">Shipping Fee :</dt>-->
        <!--    <dd>-->
        <!--        <button id="shipping_fee" class="btn btn-sm" type="button" data-toggle="modal" data-target="#add-shipping-fee">-->
        <!--            <i class="tio-edit"></i>-->
        <!--        </button>-->
        <!--        {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($shipping_fee))}}-->
        <!--    </dd>-->
        <!--</div>-->
        <!--        <div class="d-flex gap-2 justify-content-between">
            <dt class="title-color text-capitalize font-weight-normal">{{\App\CPU\translate('tax')}} : </dt>
            <dd>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(round($total_tax_amount,2)))}}</dd>
        </div>-->


        <div class="d-flex gap-2 border-top justify-content-between pt-2">
            <dt class="title-color text-capitalize font-weight-bold title-color">{{\App\CPU\translate('total')}} : </dt>
            <dd class="font-weight-bold title-color">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(round($total+$total_shipping_amount+$total_fee_amount-$coupon_discount, 2)))}}</dd>
        </div>
    </dl>
    <form action="{{route('admin.pos.order')}}" id='order_place' method="post" >
        @csrf
        <div class="form-group col-12">
            <input type="hidden" class="form-control" name="amount" min="0" step="0.01"
                   value="{{\App\CPU\BackEndHelper::usd_to_currency($total+$total_shipping_amount+$total_fee_amount-$coupon_discount)}}"
                   readonly>
        </div>
        <div class="form-check" style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1.25rem;">
            <input type="checkbox" name="hide_product_discount" class="form-check-input"
                   id="show_product_discount" value="1">
            <label class="form-check-label" for="hide_product_discount" style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1.09rem">
                Hide Product Discount
            </label>
        </div>
        <div class="pt-4 mb-4">
            <div class="title-color d-flex mb-2">Payment Status:</div>
            <select name="payment_status"  class="form-control js-select2-custom w-100" title="select">
                <option value="unpaid">Unpaid</option>
                <option value="paid">Paid</option>
            </select>
        </div>
        <div class="pt-4 mb-4">
            <div class="title-color d-flex mb-2">Order Status:</div>
            <select name="delivery_status"  class="form-control js-select2-custom w-100" title="select">
                <option value="confirmed">Confirmed</option>
                <option value="processing">Packaging</option>
                <option value="out_for_delivery">Out For Delivery</option>
                <option value="delivered">Delivered</option>
            </select>
        </div>
        <div class="pt-4 mb-4">
            <div class="title-color d-flex mb-2">Purchase Order No:</div>
            <input type="text" name="purchase_order_no" class="form-control">
        </div>
        <div class="pt-4 mb-4">
            <div class="title-color d-flex mb-2">{{\App\CPU\translate('Payment Method')}}:</div>
            <!--<ul class="list-unstyled option-buttons">-->
            <!--    <li>-->
            <!--        <input type="radio" id="cash" value="cash" name="type" hidden checked>-->
            <!--        <label for="cash" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\translate('cash')}}</label>-->
            <!--    </li>-->
            <!--    <li>-->
            <!--        <input type="radio" id="bkash" value="bkash" name="type" hidden >-->
            <!--        <label for="bkash" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\translate('bkash')}}</label>-->
            <!--    </li>-->
            <!--    <li>-->
            <!--        <input type="radio" value="card" id="card" name="type" hidden>-->
            <!--        <label for="card" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\translate('Card')}}</label>-->
            <!--    </li>-->
            <!--</ul>-->
            <select name="type" class="form-control js-select2-custom w-100 paid_by_rel" title="select">
                <option value="cash_on_delivery">{{\App\CPU\translate('Cash_On_Delivery')}}</option>
                <option value="bkash">{{\App\CPU\translate('bkash')}}</option>
                <option value="nagad">{{\App\CPU\translate('Nagad')}}</option>
                <option value="EFT">{{\App\CPU\translate('EFT/RTGS')}}</option>
                <option value="card">{{\App\CPU\translate('Card')}}</option>
            </select>
        </div>

        <div class="pt-4 mb-4 paid_by_dependant" style="display: none;">
            <div class="title-color d-flex mb-2">Payment Reference No:</div>
            <input type="text" name="trans_reference_id" class="form-control">
        </div>
        @php($customer = isset($current_customer) ? $current_customer : [])
        @php($shipping_addresses = isset($shipping_addresses) ? $shipping_addresses : [])
        @php($billing_addresses = isset($billing_addresses) ? $billing_addresses : [])
        <div class="pt-4 mb-4">
            <div class="title-color d-flex mb-2">Billing Address:</div>
            <button class="btn btn-sm  btn-primary" type="button" data-toggle="modal" data-target="#cart-billing-address">
                <i class="tio-agenda-view"></i></button>
                  <ul class="list-group">
                    @foreach($billing_addresses as $key=>$address)
                        @if($key==0)
                        <li class="list-group-item mb-2 mt-2"
                            style="cursor: pointer;background: rgba(245,245,245,0.51)">
                            <label class="badge"
                                   style="background: {{$web_config['primary_color']}}; color:white !important;">{{$address['address_type']}}</label>
                            <small>
                                <i class="fa fa-phone"></i> {{$address['phone']}}
                            </small>
                            <hr>
                            <span>{{ \App\CPU\translate('contact_person_name')}}: {{$address['contact_person_name']}}</span><br>
                            <span>{{ \App\CPU\translate('address')}} : {{$address['address']}}, {{$address['city']}}, {{$address['zip']}}.</span>
                        </li>
                       @endif
                    @endforeach
                </ul>
            <div class="modal fade" id="cart-billing-address" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Billing Address</h5>
                        </div>
                        <div class="modal-body">

                            <div  class="card-body" style="padding: 0!important;">

<!--                                <div class="form-check"
                                     style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1.25rem;">
                                    <input type="checkbox" id="same_as_shipping_address" onclick="hide_billingAddress()"
                                           name="same_as_shipping_address" class="form-check-input" >
                                    <label class="form-check-label"
                                           style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1.09rem">
                                        {{ \App\CPU\translate('same_as_shipping_address')}}
                                    </label>
                                </div>-->
                                <div id="hide_billing_address" class="card-body" style="padding: 0!important;">
                                    <ul class="list-group">
                                        @foreach($billing_addresses as $key=>$address)

                                            <li class="list-group-item mb-2 mt-2"
                                                style="cursor: pointer;background: rgba(245,245,245,0.51)"
                                                onclick="$('#bh-{{$address['id']}}').prop( 'checked', true )">
                                                <input type="radio" name="billing_method_id"
                                                       id="bh-{{$address['id']}}"
                                                       value="{{$address['id']}}" {{$key==0?'checked':''}}>
                                                <span class="checkmark"
                                                      style="margin-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 10px"></span>
                                                <label class="badge"
                                                       style="background: {{$web_config['primary_color']}}; color:white !important;">{{$address['address_type']}}</label>
                                                <small>
                                                    <i class="fa fa-phone"></i> {{$address['phone']}}
                                                </small>
                                                <hr>
                                                <span>{{ \App\CPU\translate('contact_person_name')}}: {{$address['contact_person_name']}}</span><br>
                                                <span>{{ \App\CPU\translate('address')}} : {{$address['address']}}, {{$address['city']}}, {{$address['zip']}}.</span>
                                            </li>
                                        @endforeach
                                        <li  class="list-group-item mb-2 mt-2" onclick="billingAddress()">
                                            <input type="radio" name="billing_method_id"
                                                   id="bh-0" value="0" data-toggle="collapse"
                                                   data-target="#billing_model" {{count($billing_addresses)==0?'checked':''}}>
                                            <span class="checkmark"
                                                  style="margin-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 10px"></span>

                                            <button type="button" class="btn btn-outline" data-toggle="collapse"
                                                    data-target="#billing_model">{{ \App\CPU\translate('Another')}} {{ \App\CPU\translate('address')}}
                                            </button>
                                            <div id="accordion">
                                                <div id="billing_model"
                                                     class="collapse {{count($billing_addresses)==0?'show':''}}"
                                                     aria-labelledby="headingThree"
                                                     data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputEmail1">{{ \App\CPU\translate('contact_person_name')}}
                                                                <span style="color: red">*</span></label>
                                                            <input type="text" class="form-control"
                                                                   name="billing[contact_person_name]" >
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">{{ \App\CPU\translate('Phone')}}
                                                                <span
                                                                    style="color: red">*</span></label>
                                                            <input type="text" class="form-control"
                                                                   name="billing[phone]" >
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Company Name
                                                                <span
                                                                    style="color: red">*</span></label>
                                                            <input type="text" class="form-control"
                                                                   name="billing[company_name]" >
                                                        </div>
                                                         <div class="form-group">
                                                            <label for="exampleInputEmail1">Company BIN
                                                                <span
                                                                    style="color: red">*</span></label>
                                                            <input type="text" class="form-control"
                                                                   name="billing[company_bin]" >
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputPassword1">{{ \App\CPU\translate('address')}} {{ \App\CPU\translate('Type')}}</label>
                                                            <select class="form-control" name="billing[address_type]">
                                                                <option
                                                                    value="permanent">{{ \App\CPU\translate('Permanent')}}</option>
                                                                <option value="home">{{ \App\CPU\translate('Home')}}</option>
                                                                <option
                                                                    value="others">{{ \App\CPU\translate('Others')}}</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">{{ \App\CPU\translate('City')}}<span
                                                                    style="color: red">*</span></label>
                                                            <input type="text" class="form-control"
                                                                   name="billing[city]" >
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputEmail1">{{ \App\CPU\translate('zip_code')}}
                                                                <span
                                                                    style="color: red">*</span></label>
                                                            <input type="number" class="form-control"
                                                                   name="billing[zip]" >
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputEmail1">{{ \App\CPU\translate('address')}}<span
                                                                    style="color: red">*</span></label>
                                                            <textarea class="form-control" id="address"
                                                                      type="text"
                                                                      name="billing[address]" ></textarea>
                                                        </div>
                                                        <input type="hidden" id="billing_latitude"
                                                               name="billing[latitude]" class="form-control d-inline"
                                                               placeholder="Ex : -94.22213"
                                                               value="0"
                                                               readonly>
                                                        <input type="hidden"
                                                               name="billing[longitude]" class="form-control"
                                                               placeholder="Ex : 103.344322" id="billing_longitude"
                                                               value="0"
                                                               readonly>

                                                        <div class="form-check" style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1.25rem;">
                                                            <input type="checkbox" name="save_address_billing" class="form-check-input"
                                                                   id="save_address_billing">
                                                            <label class="form-check-label" for="save_address_billing" style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1.09rem">
                                                                {{ \App\CPU\translate('save_this_address')}}
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    Okay
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="pt-4 mb-4">


            <div class="title-color d-flex mb-2">Shipping Address:</div>
            <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#cart-shopping-address">
                <i class="tio-agenda-view"></i></button>
                <ul class="list-group">
                    @foreach($shipping_addresses as $key=>$address)
                        @if($key==0)
                        <li class="list-group-item mb-2 mt-2"
                            style="cursor: pointer;background: rgba(245,245,245,0.51)">
                            <label class="badge"
                                   style="background: {{$web_config['primary_color']}}; color:white !important;">{{$address['address_type']}}</label>
                            <small>
                                <i class="fa fa-phone"></i> {{$address['phone']}}
                            </small>
                            <hr>
                            <span>{{ \App\CPU\translate('contact_person_name')}}: {{$address['contact_person_name']}}</span><br>
                            <span>{{ \App\CPU\translate('address')}} : {{$address['address']}}, {{$address['city']}}, {{$address['zip']}}.</span>
                        </li>
                       @endif
                    @endforeach
                </ul>
            <div class="modal fade" id="cart-shopping-address" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Shipping Address</h5>
                        </div>
                        <div class="modal-body">

                            <div class="card-body" style="padding: 0!important;">
                                <div class="form-check"
                                     style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1.25rem;">
                                    <input type="checkbox" id="same_as_billing_address" onclick="hide_shippingAddress()"
                                           name="same_as_billing_address" class="form-check-input" >
                                    <label class="form-check-label"
                                           style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1.09rem">
                                        Same as Billing Address
                                    </label>
                                </div>


                                <div  id="hide_shipping_address" class="card-body" style="padding: 0!important;">
                                    <ul class="list-group">
                                        @foreach($shipping_addresses as $key=>$address)
                                            <li class="list-group-item mb-2 mt-2"
                                                style="cursor: pointer;background: rgba(245,245,245,0.51)"
                                                onclick="$('#sh-{{$address['id']}}').prop( 'checked', true )">
                                                <input type="radio" name="shipping_method_id"
                                                       id="sh-{{$address['id']}}"
                                                       value="{{$address['id']}}" {{$key==0?'checked':''}}>
                                                <span class="checkmark"
                                                      style="margin-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 10px"></span>
                                                <label class="badge"
                                                       style="background: {{$web_config['primary_color']}}; color:white !important;">{{$address['address_type']}}</label>
                                                <small>
                                                    <i class="fa fa-phone"></i> {{$address['phone']}}
                                                </small>
                                                <hr>
                                                <span>{{ \App\CPU\translate('contact_person_name')}}: {{$address['contact_person_name']}}</span><br>
                                                <span>{{ \App\CPU\translate('address')}} : {{$address['address']}}, {{$address['city']}}, {{$address['zip']}}.</span>
                                            </li>
                                        @endforeach
                                        <li class="list-group-item mb-2 mt-2" onclick="anotherAddress()">
                                            <input type="radio" name="shipping_method_id"
                                                   id="sh-0" value="0" data-toggle="collapse"
                                                   data-target="#collapseThree" {{count($shipping_addresses)==0?'checked':''}}>
                                            <span class="checkmark"
                                                  style="margin-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 10px"></span>

                                            <button type="button" class="btn btn-outline" data-toggle="collapse"
                                                    data-target="#collapseThree">{{ \App\CPU\translate('Another')}} {{ \App\CPU\translate('address')}}
                                            </button>
                                            <div id="accordion">
                                                <div id="collapseThree"
                                                     class="collapse {{count($shipping_addresses)==0?'show':''}}"
                                                     aria-labelledby="headingThree"
                                                     data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputEmail1">{{ \App\CPU\translate('contact_person_name')}}
                                                                <span style="color: red">*</span></label>
                                                            <input type="text" class="form-control"
                                                                   name="shipping[contact_person_name]" >
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">{{ \App\CPU\translate('Phone')}}
                                                                <span
                                                                    style="color: red">*</span></label>
                                                            <input type="text" class="form-control"
                                                                   name="shipping[phone]" >
                                                        </div>
                                                        <div class="form-group" style="display:none">
                                                            <label for="exampleInputEmail1">Company Name
                                                                <span
                                                                    style="color: red">*</span></label>
                                                            <input type="text" class="form-control"
                                                                   name="shipping[company_name]" >
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputPassword1">{{ \App\CPU\translate('address')}} {{ \App\CPU\translate('Type')}}</label>
                                                            <select class="form-control" name="shipping[address_type]">
                                                                <option
                                                                    value="permanent">{{ \App\CPU\translate('Permanent')}}</option>
                                                                <option value="home">{{ \App\CPU\translate('Home')}}</option>
                                                                <option
                                                                    value="others">{{ \App\CPU\translate('Others')}}</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">{{ \App\CPU\translate('City')}}<span
                                                                    style="color: red">*</span></label>
                                                            <input type="text" class="form-control"
                                                                   name="shipping[city]" >
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputEmail1">{{ \App\CPU\translate('zip_code')}}
                                                                <span
                                                                    style="color: red">*</span></label>
                                                            <input type="number" class="form-control"
                                                                   name="shipping[zip]" >
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputEmail1">{{ \App\CPU\translate('address')}}<span
                                                                    style="color: red">*</span></label>
                                                            <textarea class="form-control" id="address"
                                                                      type="text"
                                                                      name="shipping[address]" ></textarea>
                                                        </div>
                                                        <input type="hidden" id="billing_latitude"
                                                               name="shipping[latitude]" class="form-control d-inline"
                                                               placeholder="Ex : -94.22213"
                                                               value="0"
                                                               readonly>
                                                        <input type="hidden"
                                                               name="shipping[longitude]" class="form-control"
                                                               placeholder="Ex : 103.344322" id="billing_longitude"
                                                               value="0"
                                                               readonly>
                                                        <div class="form-check" style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1.25rem;">
                                                            <input type="checkbox" name="save_address_shipping" class="form-check-input"
                                                                   id="save_address_shipping">
                                                            <label class="form-check-label" for="save_address_shipping" style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1.09rem">
                                                                {{ \App\CPU\translate('save_this_address')}}
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    Okay
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="d-flex gap-2 justify-content-between align-items-center pt-3">
            <a href="#" class="btn btn-danger btn-block" onclick="emptyCart()">
                <i class="fa fa-times-circle"></i>
                {{\App\CPU\translate('Cancel_Order')}}
            </a>
            <button id="submit_order" type="button" onclick="form_submit()"  class="btn btn-success btn-block m-0" data-toggle="modal" data-target="#paymentModal">
                <i class="fa fa-shopping-bag"></i>
                {{\App\CPU\translate('Place_Order')}}
            </button>

        </div>
    </form>
</div>

<div class="modal fade" id="add-vat" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update vat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="title-color">{{\App\CPU\translate('type')}}</label>
                    <select name="type" id="type_vat" class="form-control">
                        <!--<option value="percent" {{$discount_type=='percent'?'selected':''}}>{{\App\CPU\translate('percent')}}(%)</option>-->
                        <!--<option value="amount" {{$discount_type=='amount'?'selected':''}}>{{\App\CPU\translate('amount')}}</option>-->
                        <option value="percent">{{\App\CPU\translate('percent')}}(%)</option>
                        <option value="amount">{{\App\CPU\translate('amount')}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="title-color">Vat</label>
                    @php($vat_value=\App\Model\BusinessSetting::where('type','vat_settings')->first())
                    <input type="number" id="vat_amount" class="form-control" name="vat_amount" value="{{$vat_value->value ?? ''}}" placeholder="Ex: 500">
                </div>
                <div class="form-group">
                    <button class="btn btn--primary" onclick="calculate_vat();" type="submit">{{\App\CPU\translate('submit')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-discount" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{\App\CPU\translate('update_discount')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="title-color">{{\App\CPU\translate('type')}}</label>
                    <select name="type" id="type_ext_dis" class="form-control">
                        <option value="amount" {{$discount_type=='amount'?'selected':''}}>{{\App\CPU\translate('amount')}}</option>
                        <option value="percent" {{$discount_type=='percent'?'selected':''}}>{{\App\CPU\translate('percent')}}(%)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="title-color">{{\App\CPU\translate('discount')}}</label>
                    <input type="number" id="dis_amount" class="form-control" name="discount" placeholder="Ex: 500">
                </div>
                <div class="form-group">
                    <button class="btn btn--primary" onclick="extra_discount();" type="submit">{{\App\CPU\translate('submit')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-coupon-discount" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{\App\CPU\translate('coupon_discount')}}</h5>
                <button id="coupon_close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="title-color">{{\App\CPU\translate('coupon_code')}}</label>
                    <input type="text" id="coupon_code" class="form-control" name="coupon_code" placeholder="SULTAN200">
                    {{-- <input type="hidden" id="user_id" name="user_id" > --}}
                </div>

                <div class="form-group">
                    <button class="btn btn--primary" type="submit" onclick="coupon_discount();">{{\App\CPU\translate('submit')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="update-fee" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Fee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="title-color">Fee Details</label>
                    <input type="text" id="additional_fee_title" class="form-control" name="additional_fee_title" placeholder="Ex: Shipping">
                </div>
                <div class="form-group">
                    <label class="title-color">Fee Amount</label>
                    <input type="number" id="additional_fee_amount" class="form-control" name="additional_fee_amount" placeholder="Ex: 500">
                </div>
                <div class="form-group">
                    <button class="btn btn--primary" onclick="calculate_fee();" type="submit">{{\App\CPU\translate('submit')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="shipping-fee" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Shipping Fee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="title-color">Fee Amount</label>
                    <input type="number" id="shipping_fee_amount" class="form-control" name="additional_fee_amount" min='0' value='0' placeholder="Ex: 500">
                </div>
                <div class="form-group">
                    <button class="btn btn--primary" onclick="shipping_fee();" type="submit">{{\App\CPU\translate('submit')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add-shipping-fee" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Shipping Fee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="title-color">Shipping Fee</label>
                    <input type="number" id="pos_shipping_amount" class="form-control" name="pos_shipping_amount" placeholder="Ex: 100">
                </div>
                <div class="form-group">
                    <button class="btn btn--primary" onclick="calculate_pos_shipping_amount();" type="submit">{{\App\CPU\translate('submit')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="short-cut-keys" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{\App\CPU\translate('short_cut_keys')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>{{\App\CPU\translate('to_click_order')}} : alt + O</span><br>
                <span>{{\App\CPU\translate('to_click_payment_submit')}} : alt + S</span><br>
                <span>{{\App\CPU\translate('to_close_payment_submit')}} : alt + Z</span><br>
                <span>{{\App\CPU\translate('to_click_cancel_cart_item_all')}} : alt + C</span><br>
                <span>{{\App\CPU\translate('to_click_add_new_customer')}} : alt + A</span> <br>
                <span>{{\App\CPU\translate('to_submit_add_new_customer_form')}} : alt + N</span><br>
                <span>{{\App\CPU\translate('to_click_short_cut_keys')}} : alt + K</span><br>
                <span>{{\App\CPU\translate('to_print_invoice')}} : alt + P</span> <br>
                <span>{{\App\CPU\translate('to_cancel_invoice')}} : alt + B</span> <br>
                <span>{{\App\CPU\translate('to_focus_search_input')}} : alt + Q</span> <br>
                <span>{{\App\CPU\translate('to_click_extra_discount')}} : alt + E</span> <br>
                <span>{{\App\CPU\translate('to_click_coupon_discount')}} : alt + D</span> <br>
                <span>{{\App\CPU\translate('to_click_clear_cart')}} : alt + X</span> <br>
                <span>{{\App\CPU\translate('to_click_new_order')}} : alt + R</span> <br>
            </div>
        </div>
    </div>
</div>





<script>
    $('#type_ext_dis').on('change', function (){
        let type = $('#type_ext_dis').val();
        if(type === 'amount'){
            $('#dis_amount').attr('placeholder', 'Ex: 500');
        }else if(type === 'percent'){
            $('#dis_amount').attr('placeholder', 'Ex: 10%');
        }
    });
    
    $('.paid_by_rel').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        if(valueSelected == 'cash_on_delivery'){
            $('.paid_by_dependant').val('');
            $('.paid_by_dependant').hide();
        }else{
            $('.paid_by_dependant').show();
        }
    });

    function hide_billingAddress() {
        let check_same_as_shippping = $('#same_as_shipping_address').is(":checked");
        console.log(check_same_as_shippping);
        if (check_same_as_shippping) {
            $('#hide_billing_address').hide();
        } else {
            $('#hide_billing_address').show();
        }
    }

    function hide_shippingAddress() {
        let check_same_as_billing = $('#same_as_billing_address').is(":checked");

        if (check_same_as_billing) {
            $('#hide_shipping_address').hide();
        } else {
            $('#hide_shipping_address').show();
        }
    }
</script>
<script>
    function shipping_fee() {

        let shipping_fee_amount = $('#shipping_fee_amount').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.post({
            url: '{{ route('admin.pos.pos_shipping_fee') }}',
            data: {
                _token: '{{ csrf_token() }}',
                shipping_fee_amount: shipping_fee_amount,
            },
            beforeSend: function() {
                $('#loading').removeClass('d-none');
            },
            success: function(data) {
                console.log(data);
                if (data.status== 'success') {
                    toastr.success('{{ \App\CPU\translate('shipping_added_successfully') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                } else if (data.status == 'amount_low') {
                    toastr.warning(
                        '{{ \App\CPU\translate('this_discount_is_not_applied_for_this_amount') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                } else if (data.coupon === 'empty') {
                    toastr.warning('{{ \App\CPU\translate('your_cart_is_empty') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                } 
                $('#cart').empty().html(data.view);
                $('#search').focus();
            },
            complete: function() {
                $('.modal-backdrop').addClass('d-none');
                $(".footer-offset").removeClass("modal-open");
                $('#loading').addClass('d-none');
            }
        });

    }
</script>