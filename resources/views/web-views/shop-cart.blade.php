@extends('layouts.front-end.app')

@section('title', \App\CPU\translate('My Shopping Cart'))

@push('css_or_js')
    <meta property="og:image" content="{{ asset('storage/app/public/company') }}/{{ $web_config['web_logo']->value }}" />
    <meta property="og:title" content="{{ $web_config['name']->value }} " />
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:description" content="{!! substr($web_config['about']->value, 0, 100) !!}">

    <meta property="twitter:card" content="{{ asset('storage/app/public/company') }}/{{ $web_config['web_logo']->value }}" />
    <meta property="twitter:title" content="{{ $web_config['name']->value }}" />
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value, 0, 100) !!}">
    <link rel="stylesheet" href="{{ asset('public/assets/front-end') }}/css/shop-cart.css" />
@endpush


@php
    $customer_id = auth('customer')->id();
@endphp

@section('content')
    
    @php($getCart=\App\CPU\CartManager::get_cart())
    
    @if($getCart->count() > 0)
    <div class="container pb-5 mb-2 mt-3 rtl"
        style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};" id="cart-summary">
        @if ($customer_id)
            @include('layouts.front-end.partials.cart_details')
        @else
            @include('layouts.front-end.partials.cart_details_offline')
        @endif
    </div>
    @else
    <section class="emty-cart-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="emty-cart-box">
                        <img src="{{asset('public/assets/front-end/img/icon/empty.gif')}}" alt="empty cart">
                        <h3>Your Cart is Empty</h3>
                        <p>Explore our wide selections and find something you like</p>
                        <a href="{{route('home')}}" class="shop-now">Shop Now</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="cart-need">
                        <p><span class="need-color">Need help? Please visit</span> <a href="">Help center</a> <span class="need-color">or</span> <a href="/contacts">Contact us</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    
    @if($getCart->count() > 0)
    <section class="j-cart-sec">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="j-pay" style="margin: 30px 0px;">
                        <div class="text-center">
                            <p class="j-p">
                                By clicking on the place order button you agree to Malamal.xyz’s <a href="{{url('/terms')}}"
                                    class="j-underline">Terms &amp; Conditions</a> and <a href="{{url('/privacy-policy')}}"
                                    class="j-underline">Privacy Policy</a>
                            </p>
                            <p>
                                <img src="https://malamal.i2hostingsolution.net/public/assets/frontendv2/img/icons/footer/payment-links.svg"
                                    alt="payment-logos">
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    
@endsection

@push('script')
    <script>
        cartQuantityInitialize();
    </script>
@endpush