@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('My Quotation Cart'))

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="{{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="{{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">
    <link rel="stylesheet" href="{{asset('/assets/front-end')}}/css/shop-cart.css"/>
@endpush




@section('content')



    @if($quote_count > 0)
    <div class="container pb-5 mb-2 mt-3 rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};" id="cart-summary">
        @if(auth('customer')->check())
        @include('layouts.front-end.partials.quote_details')
        @else
        @include('layouts.front-end.partials.quote_details_offline')
        @endif 
    </div>
    
    @else
    <section class="emty-cart-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="emty-cart-box">
                        <img src="{{asset('/assets/front-end/img/icon/empty_quotation.svg')}}" alt="empty cart">
                        <h3>Your Quotation Cart is Empty</h3>
                        <p>Explore our wide selections and find something you like</p>
                        <a href="{{route('home')}}" class="shop-now">Shop Now</a>
                        <a href="{{ route('quote_rfq_contact') }}" class="do-want-btn btn-shadow">Do You Want to Upload RFQ?</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="cart-need">
                        <p><span class="need-color">Need help? Please visit</span> Help center <span class="need-color">or</span> <a href="{{route('contacts')}}">Contact us</a></p>
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


