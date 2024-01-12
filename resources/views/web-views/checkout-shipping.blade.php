@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Shipping Address Choose'))

@push('css_or_js')
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&display=swap" rel="stylesheet">
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('public/css/payment.css') }}">

    <style>
        .btn-outline {
            border-color: {{$web_config['primary_color']}} ;
        }

        .btn-outline {
            color: #020512;
            border-color: {{$web_config['primary_color']}}    !important;
        }

        .btn-outline:hover {
            color: white;
            background: {{$web_config['primary_color']}};

        }

        .btn-outline:focus {
            border-color: {{$web_config['primary_color']}}    !important;
        }

        #location_map_canvas {
            height: 100%;
        }

        @media only screen and (max-width: 768px) {
            /* For mobile phones: */
            #location_map_canvas {
                height: 200px;
            }
        }
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
@endpush
@if(auth('customer')->check())
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
@endif
@section('content')
@php
use Illuminate\Support\Facades\DB;
$emi_check=DB::table('carts')
            ->where('customer_id',auth('customer')->id())
            ->where('is_emi',0)
            ->get();
$cart_courier=DB::table('carts')
    ->where('customer_id',auth('customer')->id())
    ->orderBy('id','DESC')
    ->first();
$user_loyalty=DB::table('users')->where('id',auth('customer')->id())->select('loyalty_point')->first();
$shipping_type=DB::table('shipping_types')->first();
$user_point_amt=0;
if(!empty($user_loyalty->loyalty_point)&&$user_loyalty->loyalty_point>0)
    {
        $user_point_amt=($user_loyalty->loyalty_point/2);
    }
@endphp
@php($billing_input_by_customer=\App\CPU\Helpers::get_business_settings('billing_input_by_customer'))
    {{-- new design --}}
    @php($default_location=\App\CPU\Helpers::get_business_settings('default_location'))
    <br>
    <div class="payment-wrapper">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-9">
              <div class="accordion" id="paymentAccordion">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="enter-phone-number">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#enter-phone-number-panel" aria-expanded="true" aria-controls="enter-phone-number-panel">
                      <span class="checkout-ok" style="display:none;" id="account-check"><i class="fa-solid fa-check"></i></span><span>1. Account Information</span><span class="checkout-change-btn" style="display:none;" id="account-change">change</span>
                    </button>
                  </h2>
                  <div id="enter-phone-number-panel" class="accordion-collapse collapse show" aria-labelledby="enter-phone-number" data-bs-parent="#paymentAccordion">
                    <div class="accordion-body">
                      @if (auth('customer')->check())
                      <div class="phone-number">
                        <!--<p>Hello {{auth('customer')->user()->f_name}}.! </p>-->
                        <div class="checkout-login-sms">
                            <span class="exclamation-icon"><i class="fa fa-circle-exclamation"></i></span><p class="checkout-login-p">You are already Logged in as {{auth('customer')->user()->f_name}}. </p>
                        </div>
                      </div>
                      <div align="right">
                        <button class="btn btn btn--primary" onclick="shipping_tab()" type="button"><span class="hidden-xs-down">{{__('Continue')}}</span></button>
                    </div>
                      @else
                      <div class="phone-number-wrapper">
                        <div class="phone-number">
                          <p>Phone Number</p>
                          <div class="input-group flex-nowrap">
                            <span class="input-group-text j-span" style="padding:20px">+88</span>
                            <input class="form-control" id="phone_no" type="text" name="phone_no" onkeypress="return validateNumber(event)"
                                placeholder="{{ \App\CPU\translate('Enter_your_phone_number') }}" required style="min-height: 50px">         
                         </div>
                          <div class="d-grid">
                            <button class="btn btn-brand" onclick="offline_otp_send()">Continue</button>
                          </div>
                        </div>
                        
                        <div class="separator">
                          <span></span>
                        </div>
                        <div class="login">
                          <button class="btn btn-brand" 
                          style="cursor: pointer" 
                          data-toggle="modal" 
                          data-target="#signInModal">
                            {{\App\CPU\translate('Login')}}</button>
                          <p>
                            By continuing you agree to Malamal’s <a href="/terms">Terms & Condition</a> and <a href="/privacy-policy">Privacy policy</a>
                          </p>
                        </div>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="delivery-address">
                    <button class="accordion-button collapsed" style="pointer-events:none;" id="shipping_bill_id" disabled type="button" data-bs-toggle="collapse" data-bs-target="#delivery-address-panel" aria-expanded="false" aria-controls="delivery-address-panel">
                      <span class="checkout-ok" style="display:none;" id="shipping-check"><i class="fa-solid fa-check"></i></span><span>2.  {{ \App\CPU\translate('Choose_Delivery_Address')}}</span><span class="checkout-change-btn" style="display:none;" id="shipping-change">change</span>
                    </button>
                  </h2>
                  <div id="delivery-address-panel" class="accordion-collapse collapse" aria-labelledby="delivery-address" data-bs-parent="#paymentAccordion">
                    <div class="accordion-body">
                      <div class="row">
                        <div class="col-12 col-lg-6">
                          <div class="address-form">
                            @php($shipping_addresses=\App\Model\ShippingAddress::where('customer_id',auth('customer')->id())->where('is_billing',0)->get())
                            <form id="address-form">
    
                                <div class="card-body" style="padding: 0!important;">
                                    <ul class="list-group">
                                        @foreach($shipping_addresses as $key=>$address)
                                            <li class="list-group-item mb-2 mt-2"
                                                style="cursor: pointer;background: rgba(245,245,245,0.51)"
                                                onclick="shipping_choose('{{$address['id']}}')">
                                                <input type="radio" name="shipping_method_id"
                                                       id="sh-{{$address['id']}}"
                                                       value="{{$address['id']}}" {{$key==0?'checked':''}}>
                                                <span class="checkmark"
                                                      style="margin-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 10px"></span>
                                                <label class="badge"
                                                       style="background: {{$web_config['primary_color']}}; color:white !important;text-transform: capitalize;">{{$address['address_type']}}</label>
                                                <small>
                                                    <i class="fa fa-phone"></i> {{$address['phone']}}
                                                </small>
                                                <hr>
                                                <span>{{ \App\CPU\translate('contact_person_name')}}: {{$address['contact_person_name']}}</span><br>
                                                <span>{{ \App\CPU\translate('address')}} : {{$address['address']}}, {{$address['city']}}, {{$address['zip']}}.</span>
                                                <span> 
                                                    <a onclick="shipping_data('{{$address['id']}}')">
                                                        <i class="fa fa-edit fa-lg"></i>
                                                    </a>
                                                </span>
                                            </li>
                                        @endforeach
                                        <li class="list-group-item mb-2 mt-2" onclick="anotherAddress()">
                                            <input type="radio" name="shipping_method_id"
                                                   id="sh-0" value="0" data-toggle="collapse"
                                                   data-target="#collapseThree" {{$shipping_addresses->count()==0?'checked':''}}>
                                            <span class="checkmark" data-toggle="collapse"
                                                    data-target="#collapseThree" style="margin-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 10px" ></span>
    
                                            <button type="button" class="btn btn-outline add-shipping-address"  > <i class="fa fa-plus"></i>{{ \App\CPU\translate('Add')}} {{ \App\CPU\translate('New_Address')}}
                                            </button>
                                        </li>
                                            <div id="accordion">
                                                <div id="collapseThree"
                                                     class="collapse {{$shipping_addresses->count()==0?'show':''}}"
                                                     aria-labelledby="headingThree"
                                                    >
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputEmail1">{{ \App\CPU\translate('Contact_Person_Name')}}
                                                                <span style="color: red">*</span></label>
                                                            <input type="text" class="form-control" id="contact_person_name"
                                                                   name="contact_person_name" {{$shipping_addresses->count()==0?'required':''}}>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">{{ \App\CPU\translate('Phone')}}
                                                                <span
                                                                    style="color: red">*</span></label>
                                                            <input type="text" class="form-control" onkeypress="return validateNumber(event)" id="phone_no"
                                                                   name="phone_no" {{$shipping_addresses->count()==0?'required':''}}>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputPassword1">{{ \App\CPU\translate('address')}} {{ \App\CPU\translate('Type')}}</label>
                                                            <select class="form-select" name="shipp_address_type" id="shipp_address_type">
                                                                <option value="home">{{ \App\CPU\translate('Home')}}</option>
                                                                <option value="office">{{ \App\CPU\translate('Office')}}</option>
                                                                <option value="factory">{{ \App\CPU\translate('Factory')}}</option>
                                                                <option value="others">{{ \App\CPU\translate('Others')}}</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputEmail1">{{ \App\CPU\translate('address')}}<span
                                                                    style="color: red">*</span></label>
                                                            <textarea class="form-control" id="address_shipp"
                                                                      type="text"
                                                                      name="address" {{$shipping_addresses->count()==0?'required':''}}></textarea>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">{{ \App\CPU\translate('City')}}<span
                                                                    style="color: red">*</span></label>
                                                            @php($shippings=\App\CPU\Helpers::get_shipping_methods(1,'admin'))
                                                            <select class="form-select" id="city" name="city" {{$shipping_addresses->count()==0?'required':''}}>
                                                                @foreach($shippings as $shipping)
                                                                    <option value="{{$shipping['title']}}" <?php if($shipping['title']=='Dhaka'){echo "selected";}?>> 
                                                                        {{ $shipping['title'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        
                                                        
                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputEmail1">{{ \App\CPU\translate('zip_code')}} {{ \App\CPU\translate('(Optional)')}}
                                                                <span
                                                                    style="color: red"></span></label>
                                                            <input type="number" class="form-control"
                                                                   name="zip" {{$shipping_addresses->count()==0?'required':''}}>
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputPassword1">{{ \App\CPU\translate('Country')}} </label>
                                                            <select class="form-select" name="shipp_country" id="shipp_country">
                                                                <option value="Bangladesh">{{ \App\CPU\translate('Bangladesh')}}</option>
                                                            </select>
                                                        </div>
                                                        {{-- <div class="form-group">
                                                            @php($courier_service=\App\CPU\Helpers::courier_service())
                                                            <label
                                                                for="exampleInputPassword1">{{ \App\CPU\translate('Preferred')}} {{ \App\CPU\translate('Courier')}} {{ \App\CPU\translate('Service')}} </label>
                                                           
                                                                <select class="form-select" name="shipp_courier" id="shipp_courier">
                                                                    <option selected>{{ \App\CPU\translate('Select')}} {{ \App\CPU\translate('Courier')}} {{ \App\CPU\translate('Service')}}</option>
                                                                    @foreach ($courier_service as $row)
                                                                     <option value="{{$row->id}}">{{$row->name}}</option>   
                                                                    @endforeach
                                                                </select>
                                                        
                                                         
                                                        </div> --}}
                                                        
                                                        {{-- <div class="form-group">
                                                            <input id="pac-input" class="controls rounded"
                                                                   style="height: 3em;width:fit-content;"
                                                                   title="{{\App\CPU\translate('search_your_location_here')}}"
                                                                   type="text"
                                                                   placeholder="{{\App\CPU\translate('search_here')}}"/>
                                                            <div style="height: 200px;" id="location_map_canvas"></div>
                                                        </div> --}}
                                                         {{-- <div class="form-check" style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1.25rem;">
                                                            <input type="checkbox" name="save_address" class="form-check-input"
                                                                   id="exampleCheck1">
                                                            <label class="form-check-label" for="exampleCheck1" style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1.09rem">
                                                                {{ \App\CPU\translate('save_this_address')}}
                                                            </label>
                                                        </div> --}}
                                                        <input type="hidden" id="latitude"
                                                               name="latitude" class="form-control d-inline"
                                                               placeholder="Ex : -94.22213"
                                                               value="{{$default_location?$default_location['lat']:0}}" required
                                                               readonly>
                                                        <input type="hidden"
                                                               name="longitude" class="form-control"
                                                               placeholder="Ex : 103.344322" id="longitude"
                                                               value="{{$default_location?$default_location['lng']:0}}" required
                                                               readonly>
    
                                                               {{-- <button class="btn btn btn--primary" type="submit"><span class="hidden-xs-down">{{__('save')}}</span></button> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- </li> --}}
                                    </ul>
                                </div>
                                <div class="form-group">
                                    @php($courier_service=\App\CPU\Helpers::courier_service())
                                    <label
                                        for="exampleInputPassword1">{{ \App\CPU\translate('Preferred')}} {{ \App\CPU\translate('Courier')}} {{ \App\CPU\translate('Service')}} <span style="color:red">*</span> </label>
                                   
                                        <select class="form-select" name="courier_id" id="courier_id" onchange="courier_add()">
                                            <option value="">{{ \App\CPU\translate('Select')}} {{ \App\CPU\translate('Courier')}} {{ \App\CPU\translate('Service')}}</option>
                                            @foreach ($courier_service as $row)
                                             <option value="{{$row->id}}" <?php if(isset($cart_courier->courier_id) && $cart_courier->courier_id==$row->id) echo "selected"?>>{{$row->name}}</option>   
                                            @endforeach
                                        </select>
                                       
                                </div>
                                <div align="right">
                                    <button class="btn btn btn--primary" onclick="shipping_address_add()" type="button"><span class="hidden-xs-down">{{__('Continue')}}</span></button>
                                </div>
                            </form>
                           
                            
                          </div>
                        </div>
                        <div class="col-12 col-lg-6">
                          <div class="instruction">
                            <h6>Why Accurate address is important?</h6>
                            <p>
                              Make sure you get your products on time. If the address is not entered correctly, your package may be returned undelivered. You will then have to place new order. Save time and avoid frustration by entering the address information in appropriate boxes and double checking for typos and other errors.
                            </p>
                            <h6>A properly filled delivery information helps us in two ways:</h6>
                            <p>
                              It helps us deliver you the product(s) on time without any delay
                              It saves a lot of time & effort spent by our delivery team to identify your address.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="billing-address">
                      <button class="accordion-button collapsed" style="pointer-events:none;" id="billing_bill_id" disabled type="button" data-bs-toggle="collapse" data-bs-target="#billing-address-panel" aria-expanded="false" aria-controls="billing-address-panel">
                        <span class="checkout-ok" style="display:none;" id="billing-check"><i class="fa-solid fa-check"></i></span><span>3.   {{ \App\CPU\translate('Choose_Billing_Address')}}</span><span class="checkout-change-btn" style="display:none;" id="billing-change">change</span>
                      </button>
                    </h2>
                    <div id="billing-address-panel" class="accordion-collapse collapse" aria-labelledby="billing-address" data-bs-parent="#paymentAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-12 col-lg-6">
                            <div class="address-form">
                                @php($billing_addresses=\App\Model\ShippingAddress::where('customer_id',auth('customer')->id())->where('is_billing',1)->get())
                                <form method="post" action="" id="billing-address-form">
                                    @if($physical_product)
                                        <div class="form-check"
                                            style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1.25rem;">
                                            <input type="checkbox" id="same_as_shipping_address" onclick="hide_billingAddress()"
                                                name="same_as_shipping_address" class="form-check-input" checked>
                                            <label class="form-check-label"
                                                style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1.09rem">
                                                {{ \App\CPU\translate('same_as_delivery_address')}}
                                            </label>
                                        </div>
                                    @endif
                                    <div id="hide_billing_address" class="card-body" style="padding: 0!important;">
                                        <ul class="list-group">
                                            @foreach($billing_addresses as $key=>$address)
        
                                                <li class="list-group-item mb-2 mt-2"
                                                    style="cursor: pointer;background: rgba(245,245,245,0.51)"
                                                    onclick="billing_choose('{{$address['id']}}')">
                                                    <input type="radio" name="billing_method_id"
                                                        id="bh-{{$address['id']}}"
                                                        value="{{$address['id']}}" {{$key==0?'checked':''}}>
                                                    <span class="checkmark"
                                                        style="margin-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 10px"></span>
                                                    <label class="badge"
                                                        style="background: {{$web_config['primary_color']}}; color:white !important;text-transform: capitalize;">{{$address['address_type']}}</label>
                                                    <small>
                                                        <i class="fa fa-phone"></i> {{$address['phone']}}
                                                    </small>
                                                    <hr>
                                                    <span>{{ \App\CPU\translate('contact_person_name')}}: {{$address['contact_person_name']}}</span><br>
                                                    <span>{{ \App\CPU\translate('address')}} : {{$address['address']}}, {{$address['city']}}, {{$address['zip']}}.</span>
                                                    <span> 
                                                        <a onclick="billing_data('{{$address['id']}}')">
                                                            <i class="fa fa-edit fa-lg"></i>
                                                        </a>
                                                    </span>
                                                </li>
                                            @endforeach
                                            <li class="list-group-item mb-2 mt-2" onclick="billingAddress()">
                                                <input type="radio" name="billing_method_id"
                                                    id="bh-0" value="0" data-toggle="collapse"
                                                    data-target="#billing_model" {{$billing_addresses->count()==0?'checked':''}}>
                                                <span class="checkmark"
                                                    style="margin-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 10px"></span>
        
                                                <button type="button" class="btn btn-outline add-shipping-address" data-toggle="collapse"
                                                        data-target="#billing_model"><i class="fa fa-plus"></i>{{ \App\CPU\translate('Add')}} {{ \App\CPU\translate('New_Address')}}
                                                </button>
                                            </li>
                                                <div id="accordion">
                                                    <div id="billing_model"
                                                        class="collapse {{$billing_addresses->count()==0?'show':''}}"
                                                        aria-labelledby="headingThree"
                                                        data-parent="#accordion">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label
                                                                    for="exampleInputEmail1">{{ \App\CPU\translate('Contact_Person_Name')}}
                                                                    <span style="color: red">*</span></label>
                                                                <input type="text" class="form-control" id="billing_contact_person_name"
                                                                    name="billing_contact_person_name" {{$billing_addresses->count()==0?'required':''}}>
                                                            </div>
                                                            <div class="form-group">
                                                                <label
                                                                    for="exampleInputEmail1">{{ \App\CPU\translate('Company_Name')}} {{ \App\CPU\translate('(Optional)')}}
                                                                    <span style="color: red"></span></label>
                                                                <input type="text" class="form-control"
                                                                    name="billing_company_name" {{$billing_addresses->count()==0?'required':''}}>
                                                            </div>
                                                            <div class="form-group">
                                                                <label
                                                                    for="exampleInputEmail1">{{ \App\CPU\translate('Company_Bin_Number')}} {{ \App\CPU\translate('(Optional)')}}
                                                                    
                                                                    <span style="color: red"></span></label>
                                                                <input type="text" class="form-control"
                                                                    name="billing_company_bin" {{$billing_addresses->count()==0?'required':''}}>
                                                            </div>
                                                            {{-- <div class="form-group">
                                                                <label
                                                                    for="exampleInputEmail1">{{ \App\CPU\translate('Purchease_Order_No')}} {{ \App\CPU\translate('(Optional)')}}
                                                                    <span style="color: red"></span></label>
                                                                <input type="text" class="form-control"
                                                                    name="billing_purchase_order" {{$billing_addresses->count()==0?'required':''}}>
                                                            </div> --}}
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">{{ \App\CPU\translate('Phone')}}
                                                                    <span
                                                                        style="color: red">*</span></label>
                                                                <input type="text" class="form-control" onkeypress="return validateNumber(event)" id="billing_phone"
                                                                    name="billing_phone" {{$billing_addresses->count()==0?'required':''}}>
                                                            </div>
                                                            <div class="form-group">
                                                                <label
                                                                    for="exampleInputPassword1">{{ \App\CPU\translate('address')}} {{ \App\CPU\translate('Type')}}</label>
                                                                <select class="form-select" name="billing_address_type" id="billing_address_type">
                                                                    <option value="home">{{ \App\CPU\translate('Home')}}</option>
                                                                    <option value="office">{{ \App\CPU\translate('Office')}}</option>
                                                                    <option value="factory">{{ \App\CPU\translate('Factory')}}</option>
                                                                    <option value="others">{{ \App\CPU\translate('Others')}}</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label
                                                                    for="exampleInputEmail1">{{ \App\CPU\translate('address')}}<span
                                                                        style="color: red">*</span></label>
                                                                <textarea class="form-control" id="billing_address"
                                                                        type="billing_text"
                                                                        name="billing_address" {{$billing_addresses->count()==0?'required':''}}></textarea>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">{{ \App\CPU\translate('City')}}<span
                                                                        style="color: red">*</span></label>
                                                                <input type="text" class="form-control" id="billing_city"
                                                                    name="billing_city" {{$billing_addresses->count()==0?'required':''}}>
                                                            </div>
        
                                                            <div class="form-group">
                                                                <label
                                                                    for="exampleInputEmail1">{{ \App\CPU\translate('zip_code')}} {{ \App\CPU\translate('(Optional)')}}
                                                                    <span
                                                                        style="color: red"></span></label>
                                                                <input type="number" class="form-control"
                                                                    name="billing_zip" {{$billing_addresses->count()==0?'required':''}}>
                                                            </div>
                                                            <div class="form-group">
                                                                <label
                                                                    for="exampleInputPassword1">{{ \App\CPU\translate('Country')}} </label>
                                                                <select class="form-select" name="billing_country" id="billing_country">
                                                                    <option
                                                                        value="Bangladesh">{{ \App\CPU\translate('Bangladesh')}}</option>
                                                                </select>
                                                            </div>
                                                            
        
                                                            {{-- <div class="form-group">
                                                                <input id="pac-input-billing" class="controls rounded"
                                                                    style="height: 3em;width:fit-content;"
                                                                    title="{{\App\CPU\translate('search_your_location_here')}}"
                                                                    type="text"
                                                                    placeholder="{{\App\CPU\translate('search_here')}}"/>
                                                                <div style="height: 200px;" id="location_map_canvas_billing"></div>
                                                            </div> --}}
                                                            {{-- <div class="form-check" style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1.25rem;">
                                                                <input type="checkbox" name="save_address_billing" class="form-check-input"
                                                                    id="save_address_billing">
                                                                <label class="form-check-label" for="save_address_billing" style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1.09rem">
                                                                    {{ \App\CPU\translate('save_this_address')}}
                                                                </label>
                                                            </div> --}}
                                                            <input type="hidden" id="billing_latitude"
                                                                name="billing_latitude" class="form-control d-inline"
                                                                placeholder="Ex : -94.22213"
                                                                value="{{$default_location?$default_location['lat']:0}}" required
                                                                readonly>
                                                            <input type="hidden"
                                                                name="billing_longitude" class="form-control"
                                                                placeholder="Ex : 103.344322" id="billing_longitude"
                                                                value="{{$default_location?$default_location['lng']:0}}" required
                                                                readonly>
        
                                                                
                                                        </div>
                                                    </div>
                                                </div>
                                            {{-- </li> --}}
                                        </ul>
                                    </div>
                                    <div align="right">
                                      <button class="btn btn btn--primary" onclick="billing_address_add()" type="button"><span class="hidden-xs-down">{{__('Continue')}}</span></button>
                                  </div>
                                </form>
                            </div>
                          </div>
                          <div class="col-12 col-lg-6">
                            <div class="instruction">
                              <h6>Why Accurate address is important?</h6>
                              <p>
                                Make sure you get your products on time. If the address is not entered correctly, your package may be returned undelivered. You will then have to place new order. Save time and avoid frustration by entering the address information in appropriate boxes and double checking for typos and other errors.
                              </p>
                              <h6>A properly filled delivery information helps us in two ways:</h6>
                              <p>
                                It helps us deliver you the product(s) on time without any delay
                                It saves a lot of time & effort spent by our delivery team to identify your address.
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="review-order">
                    <button class="accordion-button collapsed" style="pointer-events:none;" id="review_id" disabled type="button" data-bs-toggle="collapse" data-bs-target="#review-order-panel" aria-expanded="false" aria-controls="review-order-panel">
                     <span class="checkout-ok" style="display:none;" id="review-check"><i class="fa-solid fa-check"></i></span><span> 4. Review Order</span><span class="checkout-change-btn" style="display:none;" id="review-change">change</span>
                    </button>
                    
                  </h2>
                  <div id="review-order-panel" class="accordion-collapse collapse" aria-labelledby="review-order" data-bs-parent="#paymentAccordion">
                    <div class="accordion-body p-0">
                      <div class="items-in-cart">
                        @if (auth('customer')->check())
                        @include('layouts.front-end.partials.review_details')
                        @else
                        @include('layouts.front-end.partials.review_details_offline')
                        @endif
                        <div align="right" class="make-payment-btn">
                          <button class="btn btn btn--primary" onclick="make_payment_tab()" type="button"><span class="hidden-xs-down">{{__('Make Payment')}}&rightarrow;</span></button>
                      </div>
                      </div>
                    </div>
                  </div>
                 
                </div>
                <div class="accordion-item" id="payment_cart">
                  <h2 class="accordion-header" id="make-payment">
                    <button class="accordion-button collapsed" style="pointer-events:none;" id="make_pay_id" disabled type="button" data-bs-toggle="collapse" data-bs-target="#make-payment-panel" aria-expanded="false" aria-controls="make-payment-panel">
                      <span class="checkout-ok" style="display:none;" id="pay-check"><i class="fa-solid fa-check"></i></span><span>5. Make Payment</span><span class="checkout-change-btn" style="display:none;" id="pay-change">change</span>
                    </button>
                  </h2>
                  <div id="make-payment-panel" class="accordion-collapse collapse" aria-labelledby="make-payment" data-bs-parent="#paymentAccordion">
                    <div class="accordion-body p-0">
                      <div class="d-flex align-items-start">
                        <div class="nav flex-column nav-tabs me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                          
                          <button class="nav-link pay-tab active" id="v-tab-mobile" data-bs-toggle="pill" data-bs-target="#v-tab-mobile-content" type="button" role="tab" aria-controls="v-tab-mobile-content" aria-selected="false" href="javascript:">
                            <span>
                              <img src="{{ asset('public/assets/front-end/img/bkash.png') }}" alt="pg-icon">bkash
                            </span>
                          </button>
                          {{-- nagad --}}
                          <button class="nav-link pay-tab" id="v-tab-nagad" data-bs-toggle="pill" data-bs-target="#v-tab-nagad-content" type="button" role="tab" aria-controls="v-tab-nagad-content" aria-selected="false" href="javascript:">
                            <span>
                              <img src="{{ asset('public/assets/front-end/img/nagad.png') }}" alt="pg-icon">Nagad
                            </span>
                          </button>
                          <button class="nav-link pay-tab" id="v-tab-card" data-bs-toggle="pill" data-bs-target="#v-tab-card-content" type="button" role="tab" aria-controls="v-tab-card-content" aria-selected="false" href="javascript:">
                            <span>
                              <img src="{{ asset('public/assets/front-end/img/icon/cards.svg') }}" alt="pg-icon">Online Payment
                            </span>
                          </button>
                          
                          <button class="nav-link pay-tab" id="v-tab-bank" data-bs-toggle="pill" data-bs-target="#v-tab-bank-content" type="button" role="tab" aria-controls="v-tab-bank-content" aria-selected="false" href="javascript:">
                            <span>
                              <img src="{{ asset('public/assets/front-end/img/icon/bank-transfer.svg') }}" alt="pg-icon">EFT/RTGS
                            </span>
                          </button>
                          
                          <button class="nav-link pay-tab " id="v-tab-cash" data-bs-toggle="pill" data-bs-target="#v-tab-cash-content" type="button" role="tab" aria-controls="v-tab-cash-content" aria-selected="true" href="javascript:">
                            <span>
                              <img src="{{ asset('public/assets/front-end/img/icon/cod.svg') }}" alt="pg-icon">Cash on Delivery
                            </span>
                          </button>
                          <!--<button class="nav-link pay-tab" id="v-tab-bef" data-bs-toggle="pill" data-bs-target="#v-tab-bef-content" type="button" role="tab" aria-controls="v-tab-bef-content" aria-selected="false" href="javascript:">
                            <span>
                              <img src="{{ asset('public/assets/front-end/img/icon/bef.svg') }}" alt="pg-icon">FLUTTER WAVE
                            </span>
                          </button>-->
                        </div>
                        <div class="tab-content" id="v-pills-tabContent">
                          <div class="tab-pane fade" id="v-tab-card-content" role="tabpanel" aria-labelledby="v-tab-card">
                            <div class="pg-info">
                              <div class="row">
                                @php($coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0)
                                @php($amount = \App\CPU\CartManager::cart_grand_total() - $coupon_discount -$user_point_amt)
                                @php($digital_payment=\App\CPU\Helpers::get_business_settings('digital_payment'))
        
                                @if ($digital_payment['status']==1)
                                @php($config=\App\CPU\Helpers::get_business_settings('portwallet_pay'))
                                    @if($config['status'])
                                        <div class="col-md-12 mb-4" style="cursor: pointer;text-align: center;">
                                            <div class="card">
                                                <div class="card-body" style="height: 129px">
                                                    <p class="checkout-method">You can pay using a Debit or Credit Card/Mobile Wallet/NetBanking.</p>
                                                    <img src="/public/assets/frontendv2/img/icons/footer/payment-links.svg" alt="payment-links">
                                                    <p><small>Online payment secured by PortPos.</small></p>
                                                    <form action="{{ url('/portwallet-pay') }}" method="POST" class="needs-validation">
                                                        @if (count($emi_check)==0)
                                                           <input type="checkbox" id="is_emi" name="is_emi" value="1">Are You Want to Emi This Order?
                                                        @endif  
                                                        <br>
                                                        <input type="hidden" value="{{ csrf_token() }}" name="_token"/>
                                                        <button class="btn btn btn--primary pay-confirm" type="submit">
                                                            {{-- <img width="150"
                                                                src="{{asset('public/assets/front-end/img/portpos-black.svg')}}"/> --}}Pay and Confirm
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                  @endif
                              </div>
                            </div>
                          </div>
                          
                          <div class="tab-pane fade" id="v-tab-bank-content" role="tabpanel" aria-labelledby="v-tab-bank">
                            <div class="pg-info">
                              <div class="row">
                                @php($coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0)
                                @php($amount = \App\CPU\CartManager::cart_grand_total() - $coupon_discount -$user_point_amt)
                                @php($digital_payment=\App\CPU\Helpers::get_business_settings('digital_payment'))
        
                                @if ($digital_payment['status']==1)
                                @php($config=\App\CPU\Helpers::get_business_settings('portwallet_pay'))
                                    @if($config['status'])
                                        <div class="col-md-12 mb-4" style="cursor: pointer;">
                                            <div class="card">
                                                <div class="row" id="printDiv"> 
                                                    <p class="send-price-bank" >Please Transfer:{{\App\CPU\Helpers::currency_converter($amount)}}</p>
                                                    <div class="row" >
                                                        <div class="col-md-6">
                                                            <div class="bank-info">
                                                                <table class="table table-striped" style="font-size: 13px;">
                                                                  <tbody>
                                                                    <tr>
                                                                      <th>Bank Name</th>
                                                                      <td>Brac Bank</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <th>A/C Name</th>
                                                                      <td>Malamal.xyz Ltd</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <th>A/C Number:</th>
                                                                      <td>1502204753760001</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <th>A/C Type:</th>
                                                                      <td> Current Account </td>
                                                                    </tr>
                                                                    <tr>
                                                                      <th>Branch:</th>
                                                                      <td>Nawabpur Road, Dhaka</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <th>Routing number:</th>
                                                                      <td>060274726</td>
                                                                    </tr>
                                                                  </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="checkout-eft">
                                                                <input type="button" value="Print Details" class="checkout-eft-view" onclick="printDiv()">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                   
                                                    <form action="{{route('eft-checkout-complete')}}" method="get" class="needs-validation">
                                                        {{-- <input type="hidden" value="{{ csrf_token() }}" name="_token"/> --}}
                                                        <input type="hidden" name="payment_method" value="EFT">
                                                        <button class="btn btn btn--primary pay-confirm" type="submit">
                                                            {{-- <img width="150"
                                                                src="{{asset('public/assets/front-end/img/portpos-black.svg')}}"/> --}}Confirm your Order
                                                        </button>
                                                    </form>
                                            </div>
                                        </div>
                                    @endif
                                  @endif
                              </div>
                            </div>
                          </div>
                          {{-- nagad --}}
                          <div class="tab-pane fade" id="v-tab-nagad-content" role="tabpanel" aria-labelledby="v-tab-nagad-content">
                            <div class="pg-info">
                              <div class="row">
                                @php($coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0)
                                @php($amount = \App\CPU\CartManager::cart_grand_total() - $coupon_discount -$user_point_amt)
                                @php($digital_payment=\App\CPU\Helpers::get_business_settings('digital_payment'))
        
                                @if ($digital_payment['status']==1)
                                @php($config=\App\CPU\Helpers::get_business_settings('nagad'))
                                    @if($config['status']==1)
                                        <div class="col-md-12 mb-4" style="cursor: pointer;text-align: center;">
                                            <div class="card">
                                                <div class="card-body" style="height: 129px">
                                                    <form action="{{ url('/nagad/pay') }}" method="POST" class="needs-validation">
                                                        <input type="hidden" value="{{ csrf_token() }}" name="_token"/>
                                                        <input type="hidden" value="{{ $amount }}" name="nagad_amount"/>
                                                        <p>Pay with Nagad Payment Gateway.</p>
                                                        <img src="/public/assets/frontendv2/img/nogat_malamal.xyz.png" alt="payment-links" class="bKash_malama"> </br>
                                                         </br>
                                                        
                                                        <button class="btn btn btn--primary pay-confirm" type="submit">
                                                           Pay and Confirm
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                  @endif
                              </div>
                            </div>
                          </div>
                          {{-- nagad end --}}
                          <div class="tab-pane fade show active" id="v-tab-mobile-content" role="tabpanel" aria-labelledby="v-tab-mobile">
                            <div class="pg-info">
                              <div class="row">
                                @php($coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0)
                                @php($amount = \App\CPU\CartManager::cart_grand_total() - $coupon_discount -$user_point_amt)
                                @php($digital_payment=\App\CPU\Helpers::get_business_settings('digital_payment'))
                                @if ($digital_payment['status']==1)
                                @php($config=\App\CPU\Helpers::get_business_settings('bkash'))
                                @if(isset($config)  && $config['status'])
                                    <div class="col-md-12 mb-4" style="cursor: pointer;text-align: center;">
                                        <div class="card">
                                            <div class="card-body" style="height: 100px">
                                                <p>Pay with bKash Payment Gateway.</p>
                                                <img src="/public/assets/frontendv2/img/bKash_malamal.xyz.png" alt="payment-links" class="bKash_malama"> </br>
                                                </br>
                                                <button class="btn btn btn--primary pay-confirm click-if-alone" id="bKash_button"
                                                        onclick="BkashPayment()">
                                                    {{-- <img width="100" src="{{asset('public/assets/front-end/img/bkash.png')}}"/> --}}Pay and Confirm
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @endif
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="v-tab-bef-content" role="tabpanel" aria-labelledby="v-tab-bef">
                            <div class="pg-info">
                              <div class="row">
                                @php($coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0)
                                @php($amount = \App\CPU\CartManager::cart_grand_total() - $coupon_discount -$user_point_amt)
                                @php($digital_payment=\App\CPU\Helpers::get_business_settings('digital_payment'))
                                @if ($digital_payment['status']==1)
                                @php($config=\App\CPU\Helpers::get_business_settings('flutterwave'))
                                @if(isset($config) && $config['status'])
                                    <div class="col-md-12 mb-4" style="cursor: pointer;text-align: center;">
                                        <div class="card">
                                            <div class="card-body pt-2" style="height: 100px">
                                                
                                                <form method="POST" action="{{ route('flutterwave_pay') }}">
                                                    {{ csrf_field() }}
                                                    
                                                    <button class="btn btn btn--primary pay-confirm" type="submit">
                                                        {{-- <img width="200"
                                                            src="{{asset('public/assets/front-end/img/fluterwave.png')}}"/> --}}Pay and Confirm
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @endif
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="v-tab-cash-content" role="tabpanel" aria-labelledby="v-tab-cash">
                            <div class="pg-info">
                              <div class="row">
                                @php($config=\App\CPU\Helpers::get_business_settings('cash_on_delivery'))
                                @if( $config['status'])
                                    <div class="col-md-12 mb-4" id="cod-for-cart" style="cursor: pointer;text-align: center;">
                                        <div class="card">
                                            <div class="card-body" style="height: 100px">
                                                <p>Pay with cash upon delivery.</p>
                                                <form action="{{route('checkout-complete')}}" method="get" class="needs-validation">
                                                    <input type="hidden" name="payment_method" value="cash_on_delivery">
                                                    <button class="btn btn btn--primary pay-confirm" type="submit" src="{{asset('public/assets/front-end/img/cod.png')}}">
                                                        {{-- <img width="150" style="margin-top: -10px"
                                                            src="{{asset('public/assets/front-end/img/cod.png')}}"/> --}} Place Order
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-3">
              @include('web-views.partials._review-order-summary')
            
            </div>
          </div>
        </div>
        {{-- shipping address modal --}}
        <div class="modal fade rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};" id="shippingModal" tabindex="-1" role="dialog" aria-labelledby="shippingModalLabel"
                aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="box-shadow: 0px 0px 8px grey;">
                    <div class="modal-header">
                        <h5 class="modal-title">{{\App\CPU\translate('shipping_address')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: transparent!important;" onclick="closeShipping()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    <div class="modal-body">
                        <!-- Tab panes -->
                        <div class="new-ad-mobile" style="padding:20px;">
                            <div id="home" ><br>
                                    <div class="form-group row" style="margin-bottom:10px!important;">
                                        <label for="name" class="col-sm-5">{{\App\CPU\translate('contact_person_name')}}</label>
                                        <div class="col-sm-7">
                                        <input type="hidden" id="shipp_id" name="shipp_id" value="">
                                        <input class="form-control border-radius" type="text" id="ship_contact_name" name="ship_contact_name" style="height:35px;font-size: 15px;" value="">
                                        </div>
                                    </div>
                                    {{-- <div class="form-group row" style="margin-bottom:10px!important;" id="company_field">
                                        <label for="firstName" class="col-sm-5">{{\App\CPU\translate('Company Name (Optional)')}}</label>
                                        <div class="col-sm-7">
                                        <input class="form-control border-radius" type="text" id="ship_company_name" name="ship_company_name" style="height:35px;font-size: 15px;" value="">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row" style="margin-bottom:10px!important;"  id="bin_field">
                                        <label for="firstName" class="col-sm-5">{{\App\CPU\translate('Company Bin Number (Optional)')}}</label>
                                        <div class="col-sm-7">
                                        <input class="form-control border-radius" type="text" id="ship_company_bin" name="ship_company_bin" style="height:35px;font-size: 15px;" value="">
                                        </div>
                                    </div> --}}
                                
                                    <div class="form-group row" style="margin-bottom:10px!important;">
                                        <label for="firstName" class="col-sm-5">{{\App\CPU\translate('Phone')}}</label>
                                        <div class="col-sm-7">
                                        <input class="form-control border-radius" type="text" id="ship_phone" name="ship_phone" style="height:35px;font-size: 15px;" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row" style="margin-bottom:10px!important;">
                                    <label for="firstName" class="col-sm-5">{{\App\CPU\translate('Address Type')}}</label>
                                    <div class="col-sm-7">
                                        <select class="form-control border-radius" name="ship_addressAs" id="ship_addressAs">
                                            <option value="home">{{ \App\CPU\translate('Home')}}</option>
                                            <option value="office">{{ \App\CPU\translate('Office')}}</option>
                                            <option value="factory">{{ \App\CPU\translate('Factory')}}</option>
                                            <option value="others">{{ \App\CPU\translate('Others')}}</option>
                                        </select>
                                    </div>
                                    </div>
                                    <div class="form-group row" style="margin-bottom:10px!important;">
                                        <label for="address" class="col-sm-5">{{\App\CPU\translate('address')}}</label>
                                        <div class="col-sm-7">
                                        <textarea class="form-control border-radius" id="ship_address" type="text" style="height:35px;font-size: 15px;" name="ship_address" value=""></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row" style="margin-bottom:10px!important;">
                                        <label for="address-city" class="col-sm-5">{{\App\CPU\translate('City')}}</label>
                                        <div class="col-sm-7">
                                        @php($shippings=\App\CPU\Helpers::get_shipping_methods(1,'admin'))
                                        <select class="form-control border-radius" id="address-city" name="ship_city" {{$shipping_addresses->count()==0?'required':''}}>
                                            @foreach($shippings as $shipping)
                                                <option value="{{$shipping['title']}}"> 
                                                    {{ $shipping['title'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group row" style="margin-bottom:10px!important;">
                                        <label for="zip" class="col-sm-5">{{\App\CPU\translate('zip_code')}}</label>
                                        <div class="col-sm-7">
                                        <input class="form-control border-radius" type="number" id="zip" name="ship_zip" style="height:35px;font-size: 15px;" value="">
                                        </div>
                                    </div>
                                    
                            </div>
                            <div style="text-align: right;">
                                <button type="button" onclick="shipping_address_update_store()" class="btn btn--primary btn-shadow">
                                        {{ \App\CPU\translate('Update') }}
                                    </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        {{-- end shipping address modal --}}
        {{-- billing address modal --}}
        <div class="modal fade rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};" id="billingModal" tabindex="-1" role="dialog" aria-labelledby="billingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content" style="box-shadow: 0px 0px 8px grey;">
            <div class="modal-header">
                <h5 class="modal-title">{{\App\CPU\translate('billing_address')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: transparent!important;" onclick="billingClose()">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            <div class="modal-body">
                <!-- Tab panes -->
                <div class="new-ad-mobile" style="padding:20px;">
                    <div id="home" ><br>
                            <div class="form-group row" style="margin-bottom:10px!important;">
                                <label for="name" class="col-sm-5">{{\App\CPU\translate('contact_person_name')}}</label>
                                <div class="col-sm-7">
                                <input type="hidden" id="bill_id" name="bill_id" value="">
                                <input class="form-control border-radius" type="text" id="bill_contact_name" name="bill_contact_name" style="height:35px;" value="">
                                </div>
                            </div>
                            <div class="form-group row" style="margin-bottom:10px!important;" id="company_field">
                                <label for="firstName" class="col-sm-5">{{\App\CPU\translate('Company Name (Optional)')}}</label>
                                <div class="col-sm-7">
                                <input class="form-control border-radius" type="text" id="bill_company_name" name="bill_company_name" style="height:35px;" value="">
                                </div>
                            </div>
                            
                            <div class="form-group row" style="margin-bottom:10px!important;"  id="bin_field">
                                <label for="firstName" class="col-sm-5">{{\App\CPU\translate('Company Bin Number (Optional)')}}</label>
                                <div class="col-sm-7">
                                <input class="form-control border-radius" type="text" id="bill_company_bin" name="bill_company_bin" style="height:35px;" value="">
                                </div>
                            </div>
                        
                            <div class="form-group row" style="margin-bottom:10px!important;">
                                <label for="firstName" class="col-sm-5">{{\App\CPU\translate('Phone')}}</label>
                                <div class="col-sm-7">
                                <input class="form-control border-radius" type="text" id="bill_phone" name="bill_phone" style="height:35px;" value="">
                                </div>
                            </div>
                            <div class="form-group row" style="margin-bottom:10px!important;">
                            <label for="firstName" class="col-sm-5">{{\App\CPU\translate('Address Type')}}</label>
                            <div class="col-sm-7">
                                <select class="form-control border-radius" name="bill_addressAs" id="bill_addressAs">
                                    <option value="home">{{ \App\CPU\translate('Home')}}</option>
                                    <option value="office">{{ \App\CPU\translate('Office')}}</option>
                                    <option value="factory">{{ \App\CPU\translate('Factory')}}</option>
                                    <option value="others">{{ \App\CPU\translate('Others')}}</option>
                                </select>
                            </div>
                            </div>
                            <div class="form-group row" style="margin-bottom:10px!important;">
                                <label for="address" class="col-sm-5">{{\App\CPU\translate('address')}}</label>
                                <div class="col-sm-7">
                                <textarea class="form-control border-radius" id="bill_address" type="text" style="height:35px;" name="bill_address" value=""></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group row" style="margin-bottom:10px!important;">
                                <label for="address-city" class="col-sm-5">{{\App\CPU\translate('City')}}</label>
                                <div class="col-sm-7">
                                <input class="form-control border-radius" type="text" id="address-city" style="height:35px;" name="bill_city" value="">
                                </div>
                            </div>
                            <div class="form-group row" style="margin-bottom:10px!important;">
                                <label for="zip" class="col-sm-5">{{\App\CPU\translate('zip_code')}}</label>
                                <div class="col-sm-7">
                                <input class="form-control border-radius" type="number" id="zip" name="bill_zip" style="height:35px;" value="">
                                </div>
                            </div>
                            
                    </div>
                    <div style="text-align: right;">
                        <button type="button" onclick="billing_address_update_store()" class="btn btn--primary btn-shadow">
                                {{ \App\CPU\translate('Update') }}
                            </button>
                    </div>
                </div>
            </div>
        </div>

        </div>
        </div>
        {{-- end billing address --}}
      </div>

@endsection

@push('script')

@php($mode = App\CPU\Helpers::get_business_settings('bkash')['environment']??'sandbox')
    @if($mode=='live')
        <script id="myScript"
                src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script>
    @else
        <script id="myScript"
                src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script>
    @endif


    

    <script>
        function anotherAddress() {
            $('#sh-0').prop('checked', true);
            $("#collapseThree").collapse();
        }

        function billingAddress() {
            $('#bh-0').prop('checked', true);
            $("#billing_model").collapse();
        }
        function shipping_choose(id)
        {
            $("input[name=shipping_method_id]").val(id);
            $('#sh-'+id).prop( 'checked', true );$('#collapseThree').collapse('hide'); 
        }
        function billing_choose(id)
        {
            $("input[name=billing_method_id]").val(id);
            $('#bh-'+id).prop( 'checked', true );$('#billing_model').collapse('hide');
        }
       
    </script>
    <script>
	  $(document ).ready(function() {
            let check_same_as_shippping = $('#same_as_shipping_address').is(":checked");
            if (check_same_as_shippping) 
            {
                $('#hide_billing_address').hide();
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
  

    </script>
       <script>
        function printDiv() {
            var divContents = document.getElementById("printDiv").innerHTML;
            var a = window.open('', '', 'height=1000, width=1000');
            a.document.write('<html>');
            // a.document.write('<body > <h1>Div contents are <br>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{\App\CPU\Helpers::get_business_settings('map_api_key')}}&libraries=places&v=3.49"></script>
    <script>
        
        $(document).on("keydown", "input", function (e) {
            if (e.which == 13) e.preventDefault();
        });
    </script>

    <script>

        $(document).on("keydown", "input", function (e) {
            if (e.which == 13) e.preventDefault();
        });
    </script>
    <script>
        function validateNumber(e) 
        {
            const pattern = /^[0-9]$/;
            return pattern.test(e.key )
        }
        function proceed_to_next() {
            var shipping_method_id = $("input[name=shipping_method_id]").val();
            var billing_method_id = $("input[name=billing_method_id]").val();
            if(shipping_method_id==0)
            {
              toastr.error('{{\App\CPU\translate('Please fill all required fields of shipping/billing address')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
            }
            else{
            let physical_product = $('#physical_product').val();

            if(physical_product === 'yes') {
                var billing_addresss_same_shipping = $('#same_as_shipping_address').is(":checked");

                let allAreFilled = true;
                document.getElementById("address-form").querySelectorAll("[required]").forEach(function (i) {
                    if (!allAreFilled) return;
                    if (!i.value) allAreFilled = false;
                    if (i.type === "radio") {
                        let radioValueCheck = false;
                        document.getElementById("address-form").querySelectorAll(`[name=${i.name}]`).forEach(function (r) {
                            if (r.checked) radioValueCheck = true;
                        });
                        allAreFilled = radioValueCheck;
                    }
                });

                //billing address saved
                let allAreFilled_shipping = true;

                if (billing_addresss_same_shipping != true) {

                    document.getElementById("billing-address-form").querySelectorAll("[required]").forEach(function (i) {
                        if (!allAreFilled_shipping) return;
                        if (!i.value) allAreFilled_shipping = false;
                        if (i.type === "radio") {
                            let radioValueCheck = false;
                            document.getElementById("billing-address-form").querySelectorAll(`[name=${i.name}]`).forEach(function (r) {
                                if (r.checked) radioValueCheck = true;
                            });
                            allAreFilled_shipping = radioValueCheck;
                        }
                    });
                }
            }else {
                var billing_addresss_same_shipping = false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('customer.choose-shipping-address')}}',
                // dataType: 'json',
                data: {
                    physical_product: physical_product,
                    shipping: physical_product === 'yes' ? $('#address-form').serialize() : null,
                    billing: $('#billing-address-form').serialize(),
                    billing_addresss_same_shipping: billing_addresss_same_shipping
                },
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        location.href = '{{route('checkout-payment')}}';
                    }
                },
                complete: function () {
                    $('#loading').hide();
                },
                // error: function () {
                //     toastr.error('{{\App\CPU\translate('Please fill all required fields of shipping/billing address')}}', {
                //         CloseButton: true,
                //         ProgressBar: true
                //     });
                // }
            });

          }
        }
        // shipping addressh edit mode
        function shipping_data(address_id)
            {
                var _token = "{{ csrf_token() }}";   
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                 });
                $.post({
                    type: 'POST',
                    url: "{{route('shipping_address_update')}}",
                    data: {
                        address_id: address_id,
                        _token: _token
                    },
                    success: function(data) {
                        console.log(data.response);
                        if (data.response == "success") {
                            $('#shippingModal').modal('show');
                            $("input[name=ship_contact_name]").val(data.result.contact_person_name);
                            $("input[name=ship_phone]").val(data.result.phone);
                            $("input[name=ship_city]").val(data.result.city);
                            $("input[name=ship_zip]").val(data.result.zip);
                            $("#ship_address").val(data.result.address);
                            document.getElementById("ship_addressAs").value = data.result.address_type;
                            $("input[name=shipp_id]").val(data.result.id);
                        }

                    }
                });
            }
        function closeShipping()
        {
            $('#shippingModal').modal('toggle');
        }
        function billingClose()
        {
            $('#billingModal').modal('toggle');
        }
        //billing address edit mood
        function billing_data(address_id)
            {
                var _token = "{{ csrf_token() }}";   
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                 });
                $.post({
                    type: 'POST',
                    url: "{{route('billing_address_update')}}",
                    data: {
                        address_id: address_id,
                        _token: _token
                    },
                    success: function(data) {
                        console.log(data.response);
                        if (data.response == "success") {
                            $('#billingModal').modal('show');
                            $("input[name=bill_contact_name]").val(data.result.contact_person_name);
                            $("input[name=bill_phone]").val(data.result.phone);
                            $("input[name=bill_city]").val(data.result.city);
                            $("input[name=bill_zip]").val(data.result.zip);
                            $("input[name=bill_company_name]").val(data.result.company_name);
                            $("input[name=bill_company_bin]").val(data.result.company_bin);
                            $("#bill_address").val(data.result.address);
                            document.getElementById("bill_addressAs").value = data.result.address_type;
                            $("input[name=bill_id]").val(data.result.id);
                        }

                    }
                });
            }
        //shipping address update
        function shipping_address_update_store()
        {
            var ship_contact_name = $("input[name=ship_contact_name]").val();
            var ship_phone = $("input[name=ship_phone]").val();
            var ship_city = $("#address-city").val();
            var ship_zip = $("input[name=ship_zip]").val();
            var shipp_id = $("input[name=shipp_id]").val();
            var ship_address = $("#ship_address").val();
            var ship_addressAs = $("#ship_addressAs").val();
            var _token = "{{ csrf_token() }}";   
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                 });
                $.post({
                    type: 'POST',
                    url: "{{route('shipping_address_update_store')}}",
                    data: {
                        address_id: shipp_id,
                        ship_contact_name: ship_contact_name,
                        ship_phone: ship_phone,
                        ship_city: ship_city,
                        ship_zip: ship_zip,
                        ship_address: ship_address,
                        ship_addressAs: ship_addressAs,
                        _token: _token
                    },
                    success: function(data) {
                        console.log(data.response);
                        if (data.response == "success") {
                            $('#shippingModal').modal('toggle');
                            $("#delivery-address-panel").load(" #delivery-address-panel > *");
                            $("#delivery-address-panel").collapse('show');
                        }

                    }
                });
        }
        //billing address update
        function billing_address_update_store()
        {
            var bill_contact_name = $("input[name=bill_contact_name]").val();
            var bill_phone = $("input[name=bill_phone]").val();
            var bill_city = $("input[name=bill_city]").val();
            var bill_company_name = $("input[name=bill_company_name]").val();
            var bill_company_bin = $("input[name=bill_company_bin]").val();
            var bill_zip = $("input[name=bill_zip]").val();
            var bill_id = $("input[name=bill_id]").val();
            var bill_address = $("#bill_address").val();
            var bill_addressAs = $("#bill_addressAs").val();
            var _token = "{{ csrf_token() }}";   
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                 });
                $.post({
                    type: 'POST',
                    url: "{{route('billing_address_update_store')}}",
                    data: {
                        address_id: bill_id,
                        bill_contact_name: bill_contact_name,
                        bill_phone: bill_phone,
                        bill_city: bill_city,
                        bill_company_name:bill_company_name,
                        bill_company_bin:bill_company_bin,
                        bill_zip: bill_zip,
                        bill_address: bill_address,
                        bill_addressAs: bill_addressAs,
                        _token: _token
                    },
                    success: function(data) {
                        console.log(data.response);
                        if (data.response == "success") {
                            $('#billingModal').modal('toggle');
                            $("#billing-address-panel").load(" #billing-address-panel > *");
                            $("#billing-address-panel").collapse('show');
                        }

                    }
                });
        }
        function shipping_address_add() {
            var shipping_method_id = $("input[name=shipping_method_id]").val();
            var contact_person_name = $("input[name=contact_person_name]").val();
            var phone = $("input[name=phone_no]").val();
            var address_type = $("#shipp_address_type").val();
            var zip = $("input[name=zip]").val();
            var address = $("#address_shipp").val();
            var valid_name = $("#contact_person_name").val();
            var valid_phone = $("#phone_no").val();
            var valid_city = $("#city").val();
            // var shipp_courier = $("#shipp_courier").val();
            var _token = "{{ csrf_token() }}"; 
            if (document.getElementById('courier_id').value=='') 
            {
              toastr.error('{{ \App\CPU\translate('Please Select Courier Service') }}', {
                    CloseButton: true,
                    ProgressBar: true
                    });
                return false;
            }
            if (document.getElementById('sh-0').checked && (address =="" || address ==null)) 
            {
              toastr.error('{{ \App\CPU\translate('Please Input Address field') }}', {
                    CloseButton: true,
                    ProgressBar: true
                    });

            }
            else if(document.getElementById('sh-0').checked && (valid_name ==""||valid_name== null))
            {
                toastr.error('{{ \App\CPU\translate('Please Input Name field') }}', {
                    CloseButton: true,
                    ProgressBar: true
                    });
            }
            else if(document.getElementById('sh-0').checked && (valid_phone=="" || valid_phone==null))
            {
                toastr.error('{{ \App\CPU\translate('Please Input Phone field') }}', {
                    CloseButton: true,
                    ProgressBar: true
                    });
            }
            else if(document.getElementById('sh-0').checked && (valid_city ==""||valid_city== null))
            {
                toastr.error('{{ \App\CPU\translate('Please Input City field') }}', {
                    CloseButton: true,
                    ProgressBar: true
                    });
            }
            else
            {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                type: 'POST',
                url: "{{ route('customer.shipping_address_add') }}",
                data: {
                  contact_person_name: contact_person_name,
                  shipping_method_id:shipping_method_id,
                  phone:phone,
                  address_type:address_type,
                  city:valid_city,
                  zip:zip,
                  address:address,
                //   shipp_courier:shipp_courier,
                    _token: _token
                },
                success: function(data) {
                    console.log(data.response);
                    if (data.response == "success") {
                      const button = document.getElementById('billing_bill_id');
                      button.removeAttribute('disabled');
                       window.bkas_amount=data.amount;
                      $("input[name=shipping_method_id]").val(data.shipping_id);
                      $("#payment_summary").load(" #payment_summary > *");
                      $("#v-tab-bank-content").load(" #v-tab-bank-content > *");
                      $("#v-tab-card-content").load(" #v-tab-card-content > *");
                      $('#shipping-check').show();
                      $('#shipping-change').show();
                      $("#billing-address-panel").collapse('show');
                    }
                    else if(data.response == "bill")
                    {
                      const button = document.getElementById('billing_bill_id');
                      button.removeAttribute('disabled');
                       window.bkas_amount=data.amount;
                       $("#shipping_bill_id").css('pointer-events','auto');
                      let check_same_as_shippping = $('#same_as_shipping_address').is(":checked");
                      $("#payment_summary").load(" #payment_summary > *");
                      $("#v-tab-bank-content").load(" #v-tab-bank-content > *");
                      $("#v-tab-card-content").load(" #v-tab-card-content > *");
                        if (check_same_as_shippping) {
                            $('#hide_billing_address').hide();
                        } else {
                            $('#hide_billing_address').show();
                        }
                      $('#shipping-check').show();
                      $('#shipping-change').show();
                      $("#billing-address-panel").collapse('show');
                    }

                }
            });
          }
        }
        function billing_address_add() {
            var billing_method_id = $("input[name=billing_method_id]").val();
            var contact_person_name = $("input[name=billing_contact_person_name]").val();
            var billing_company_name = $("input[name=billing_company_name]").val();
            var billing_company_bin = $("input[name=billing_company_bin]").val();
            // var billing_purchase_order = $("input[name=billing_purchase_order]").val();
            var phone = $("input[name=billing_phone]").val();
            var address_type = $("#billing_address_type").val();
            var city = $("input[name=billing_city]").val();
            var zip = $("input[name=billing_zip]").val();
            var address = $("#billing_address").val();
            var bill_name = $("#billing_contact_person_name").val();
            var bill_phone = $("#billing_phone").val();
            var bill_city = $("#billing_city").val();
            var _token = "{{ csrf_token() }}"; 
            if(document.getElementById('same_as_shipping_address').checked)
            {
                      $('#billing-check').show();
                      $('#billing-change').show();
                      $("#review-order-panel").collapse('show');
            }
            else{
            if (document.getElementById('bh-0').checked && address =='') 
            {
              toastr.error('{{ \App\CPU\translate('Please Input Address field') }}', {
                    CloseButton: true,
                    ProgressBar: true
                    });

            }
            else if(document.getElementById('bh-0').checked && (bill_name ==""||bill_name== null))
            {
                toastr.error('{{ \App\CPU\translate('Please Input Name field') }}', {
                    CloseButton: true,
                    ProgressBar: true
                    });
            }
            else if(document.getElementById('bh-0').checked && (bill_phone=="" || bill_phone==null))
            {
                toastr.error('{{ \App\CPU\translate('Please Input Phone field') }}', {
                    CloseButton: true,
                    ProgressBar: true
                    });
            }
            else if(document.getElementById('bh-0').checked && (bill_city ==""||bill_city== null))
            {
                toastr.error('{{ \App\CPU\translate('Please Input City field') }}', {
                    CloseButton: true,
                    ProgressBar: true
                    });
            }
            else
            { 
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                type: 'POST',
                url: "{{ route('customer.billing_address_add') }}",
                data: {
                  contact_person_name: contact_person_name,
                  billing_method_id:billing_method_id,
                  phone:phone,
                  address_type:address_type,
                  city:city,
                  zip:zip,
                  address:address,
                  company_name:billing_company_name,
                  company_bin:billing_company_bin,
                //   purchase_order:billing_purchase_order,
                    _token: _token
                },
                success: function(data) {
                    console.log(data.response);
                    if (data.response == "success") {
                      const button = document.getElementById('review_id');
                      button.removeAttribute('disabled');
                      $('#billing-check').show();
                      $('#billing-change').show();
                      $("#review-order-panel").collapse('show');
                    }
                    else if(data.response == "review")
                    {
                      $("#billing_bill_id").css('pointer-events','auto');
                      $('#billing-check').show();
                      $('#billing-change').show();
                      $("#review-order-panel").collapse('show');
                    }

                }
            });
          }
        }
        }
        function courier_add()
        {
            var courier_id = $("#courier_id").val();
            if(courier_id=='')
            {
                toastr.error('{{ \App\CPU\translate('Please Input Courier Service') }}', {
                    CloseButton: true,
                    ProgressBar: true
                    });
            }
            var _token = "{{ csrf_token() }}";   
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                 });
                $.post({
                    type: 'POST',
                    url: "{{route('order_wise_courier')}}",
                    data: {
                        courier_id: courier_id,
                        _token: _token
                    },
                    success: function(data) {
                        console.log(data.amount);
                        if (data.response == "success") {
                            window.bkas_amount=data.amount;
                            $("#payment_summary").load(" #payment_summary > *");
                            $("#v-tab-bank-content").load(" #v-tab-bank-content > *");
                            $("#v-tab-card-content").load(" #v-tab-card-content > *");
                            $("#delivery-address-panel").collapse('show');
                        }

                    }
                });
        }
        function make_payment_tab()
        {
          const button = document.getElementById('make_pay_id');
          let order_note = $('#order_note').val();
          button.removeAttribute('disabled');
          const button_review = document.getElementById('review_id');
          button_review.removeAttribute('disabled');
          $("#review_id").css('pointer-events','auto');
          var calcOffset = 50;
          if($("#make-payment-panel").offset().top > 1010){
              calcOffset = 100;
          }
          $('html, body').animate({
              scrollTop: ($("#make-payment-panel").offset().top - calcOffset)
          }, 800);
          //order note insert
          if(order_note !='' || order_note!=null)
          {
            $.post({
            url: "{{route('order_note')}}",
            data: {
                    _token: '{{csrf_token()}}',
                    order_note:order_note,

                },
                success: function (data) {
                    $('#review-check').show();
                    $('#review-change').show();
                    $('#pay-check').show();
                    $('#pay-change').show();
                    $("#make-payment-panel").collapse('show');
                },
             });
          }
          else{
            $('#review-check').show();
            $('#review-change').show();
            $('#pay-check').show();
            $('#pay-change').show();
            $("#make-payment-panel").collapse('show');
          }
        }
        function shipping_tab()
        {
          const button = document.getElementById('shipping_bill_id');
          button.removeAttribute('disabled');
          $('#account-check').show();
          $('#account-change').show();
          $("#delivery-address-panel").collapse('show');
        }
    </script>
    <!-- JavaScript Bundle with Popper -->
<script type="text/javascript">
        
        function offline_otp_send() {
          $('#review_resend').hide();
            var timeleft = 180;
            var phone_no = $("input[name=phone_no]").val();
            var _token = "{{ csrf_token() }}";  
            //alert(phone_no);   
            $.ajax({
                type: 'POST',
                url: "{{ route('customer.auth.review-login-otp') }}",
                data: {
                    phone_no: phone_no,
                    _token: _token
                },
                success: function(data) {
                    console.log(data.response);
                    if (data.response == "success") {
                        var btnText = document.getElementById("review_otp_phone");
                        btnText.innerHTML = '+88'+phone_no; 
                        $('#ReviewOtpModal').modal('show');
                        var downloadTimer = setInterval(function(){
                        $('#review_resend').hide();
                        timeleft--;
                        console.log(timeleft);
                        document.getElementById("reviewcountdowntimer").textContent = timeleft;
                        $('#review_countdown_show').show();
                        if(timeleft <= 0)
                            clearInterval(downloadTimer);
                        },1000);
                        $('#review_resend').show();
                        $('#review_countdown_show').css('display', 'none');
                        }
                        else if(data.response == "error")
                        {
                            location.reload();
                        }
                }
            });
        }
</script>

<script type="text/javascript">
        function BkashPayment() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $('#loading').show();
            // get token
            $.ajax({
                url: "{{ route('bkash-get-token') }}",
                type: 'POST',
                contentType: 'application/json',
                success: function (data) {
                    $('#loading').hide();
                    $('pay-with-bkash-button').trigger('click');
                    if (data.hasOwnProperty('msg')) {
                        showErrorMessage(data) // unknown error
                    }
                },
                error: function (err) {
                    $('#loading').hide();
                    showErrorMessage(err);
                }
            });
        }

        let paymentID = '';
        bKash.init({
            paymentMode: 'checkout',
            paymentRequest: {},
            createRequest: function (request) {
                setTimeout(function () {
                    createPayment(request);
                }, 2000)
            },
            executeRequestOnAuthorization: function (request) {
                $.ajax({
                    url: '{{ route('bkash-execute-payment') }}',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "paymentID": paymentID
                    }),
                    success: function (data) {
                        if (data) {
                            if (data.paymentID != null) {
                                BkashSuccess(data);
                            } else {
                                showErrorMessage(data);
                                bKash.execute().onError();
                            }
                        } else {
                            $.get('{{ route('bkash-query-payment') }}', {
                                payment_info: {
                                    payment_id: paymentID
                                }
                            }, function (data) {
                                if (data.transactionStatus === 'Completed') {
                                    BkashSuccess(data);
                                } else {
                                    createPayment(request);
                                }
                            });
                        }
                    },
                    error: function (err) {
                        bKash.execute().onError();
                    }
                });
            },
            onClose: function () {
                // for error handle after close bKash Popup
            }
        });

        function createPayment(request) {
            // because of createRequest function finds amount from this request
            $('#loading').show();
            request['amount'] = window.bkas_amount.toFixed(2); // max two decimal points allowed
            $.ajax({
                url: '{{ route('bkash-create-payment') }}',
                data: JSON.stringify(request),
                type: 'POST',
                contentType: 'application/json',
                success: function (data) {
                    $('#loading').hide();
                    if (data && data.paymentID != null) {
                        paymentID = data.paymentID;
                        bKash.create().onSuccess(data);
                    } else {
                        bKash.create().onError();
                    }
                },
                error: function (err) {
                    $('#loading').hide();
                    showErrorMessage(err.responseJSON);
                    bKash.create().onError();
                }
            });
        }

        function BkashSuccess(data) {
            $.post('{{ route('bkash-success') }}', {
                payment_info: data
            }, function (res) {
                @if(session()->has('payment_mode') && session('payment_mode') == 'app')
                    location.href = '{{ route('payment-success')}}';
                @else
                    location.href = '{{route('order-placed')}}';
                @endif
            });
        }

        function showErrorMessage(response) {
            let message = 'Unknown Error';
            if (response.hasOwnProperty('errorMessage')) {
                let errorCode = parseInt(response.errorCode);
                let bkashErrorCode = [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014,
                    2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030,
                    2031, 2032, 2033, 2034, 2035, 2036, 2037, 2038, 2039, 2040, 2041, 2042, 2043, 2044, 2045, 2046,
                    2047, 2048, 2049, 2050, 2051, 2052, 2053, 2054, 2055, 2056, 2057, 2058, 2059, 2060, 2061, 2062,
                    2063, 2064, 2065, 2066, 2067, 2068, 2069, 503,
                ];
                if (bkashErrorCode.includes(errorCode)) {
                    message = response.errorMessage
                }
            }
            Swal.fire("Payment Failed!", message, "error");
        }

        function click_if_alone() {
            let total = $('.checkout_details .click-if-alone').length;
            if (Number.parseInt(total) < 2) {
                $('.click-if-alone').click()
                $('.checkout_details').html('<h1>{{\App\CPU\translate('Redirecting_to_the_payment')}}......</h1>');
            }
        }
        // click_if_alone();

    </script>
@endpush