<style>
    body {
        font-family: sans-serif;
        background-color: #F3F3F3;
    }

    .footer span {
        font-size: 12px
    }

    .product-qty span {
        font-size: 12px;
        color: #6A6A6A;
    }

    label {
        font-size: 16px;
    }

    .divider-role {
        border-bottom: 1px solid whitesmoke;
    }

    .sidebarL h3:hover + .divider-role {
        border-bottom: 3px solid {{$web_config['secondary_color']}}    !important;
        transition: .2s ease-in-out;
    }

    

{
    color: #e9611e!important;
}

    @media (max-width: 600px) {

        .sidebar_heading h1 {
            text-align: center;
            color: aliceblue;
            padding-bottom: 17px;
            font-size: 19px;
        }

        .sidebarR {
            padding: 24px;
        }

        
    }
    
    .avatar {
  border: 0.3rem solid rgba(#fff, 0.3);
  margin-top: -6rem;
  margin-bottom: 1rem;
  max-width: 9rem;
}


.d-note{
    float: right;
    background: #e9611e;
    padding: 2px 5px;
    border-radius: 4px;
    color:#fff;
    min-width: 20px;
    text-align: center;
}

.btn--primary {
    background-color: #2a3f64!important;
    border-color: #2a3f64!important;
    color: #fff!important;
    padding: 2px 7px!important;
    font-size: 13px!important;
}
.btn-danger, .btn-secondary {
    /*padding: 2px 7px!important;*/
    font-size: 13px!important;
}
.box-shadow-sm{
    margin-bottom:0px!important;
    
}
.widget-title{
    font-weight: initial!important;
}

 .d-card{
    background: #e9611e!important;
    color: #fff;
}
.text-muted {
    color: #fff!important;
}
.card-title{
    color: #fff!important;
}

.active-menu {
    color: #000!important;
    background: #fff!important;
    display: block!important;
    padding: 12px!important;
}

.btnF a svg{
    margin-right:10px!important;
}

.j-shadow{
    box-shadow: none!important;

}
</style>
@php 
use Illuminate\Support\Facades\DB;
$user_data=DB::table('users')->where('id',auth('customer')->id())->first();
$order_count=DB::table('orders')->where('customer_id',auth('customer')->id())->count();
$wish_count=DB::table('wishlists')->where('customer_id',auth('customer')->id())->count();
$quote_count=DB::table('quotations')->where('customer_id',auth('customer')->id())->count();
@endphp
<div class="sidebarR">
    <!--Price Sidebar-->


    <!-- <div class="box-shadow-sm">
    <!--        <div class="card d-card">-->
    <!--            <div class="card-body text-center">-->
    <!--              <img class="avatar rounded-circle" src="{{asset('storage/app/public/profile')}}/{{$user_data->image}}" alt="Bologna">-->
    <!--              <h4 class="card-title"> {{$user_data->f_name}} {{$user_data->l_name}}</h4>-->
    <!--              <h6 class="card-subtitle mb-2 text-muted">{{$user_data->phone}}</h6>-->
                 
    <!--            </div>-->
    <!--          </div>    -->
    <!--    </div> -->




    <div class="price_sidebar rounded-lg" id="shop-sidebar" style="margin-bottom: -10px;background: #EBEBEB;border-radius: 0px!important;">
        
        <div class="pb-0">
            <!-- Filter by price-->
            <div class="sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                     <a class="{{Request::is('account-dashboard*') ? 'active-menu' :''}}" href="{{route('account-dashboard') }} "><i class="fa-solid fa-gauge"></i> {{\App\CPU\translate('my_deshboard')}}</a>
                </h3>
                <!--<div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>-->
            </div>
        </div>
        <div class="pb-0">
            <!-- Filter by price-->
            <div class=" sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('user-account*')?'active-menu':''}}" href="{{route('user-account')}}">
                        <i class="fa fa-user"></i> {{\App\CPU\translate('profile_info')}}
                    </a>
                </h3>
                <!--<div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>-->
            </div>
        </div>
        <div class="pb-0">
            <!-- Filter by price-->
            <div class=" sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('account-address*')?'active-menu':''}}"
                       href="{{ route('account-address') }}"><i class="fa fa-book"></i> {{\App\CPU\translate('address')}} </a>
                </h3>
                <!--<div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>-->
            </div>
        </div>
        
        <div class="pb-0">
            <!-- Filter by price-->
            <div class="sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('account-order*') || Request::is('account-order-details*') ? 'active-menu' :''}}" href="{{route('account-oder') }} "><i class="fa-solid fa-cart-shopping"></i> {{\App\CPU\translate('my_order')}} <span class="d-note">{{$order_count}}</span></a>
                </h3>
                <!--<div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>-->
            </div>
        </div>

        
        <div class="pb-0">
            <!-- Filter by price-->
            <div class="sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('account-quotation*') ? 'active-menu' :''}}" href="{{route('account-quotation') }} "><i class="fa-solid fa-pen-to-square"></i> {{\App\CPU\translate('my_quotation')}}<span class="d-note">{{$quote_count}}</span></a>
                </h3>
                <!--<div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>-->
            </div>
        </div>
        {{--to do--}}
        @php($business_mode=\App\CPU\Helpers::get_business_settings('business_mode'))
        @if ($business_mode == 'multi')
            <div class="pb-0">
                <!-- Filter by price-->
                <div class="sidebarL">
                    <h3 class="widget-title btnF" style="font-weight: 700;">
                        <a class="{{Request::is('chat*')?'active-menu':''}}" href="{{route('chat-with-seller')}}"><i class="fa-brands fa-rocketchat"></i> {{\App\CPU\translate('chat_with_seller')}}</a>
                    </h3>
                    <!--<div class="divider-role"
                        style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                    </div>-->
                </div>
            </div>
        @endif
        
        
        
        <?php
            $wallet_status = App\CPU\Helpers::get_business_settings('wallet_status');
            $loyalty_point_status = App\CPU\Helpers::get_business_settings('loyalty_point_status');
        ?>
        
        @if ($wallet_status == 1)
            <div class="pb-0">
                <!-- Filter by price-->
                <div class="sidebarL">
                    <h3 class="widget-title btnF" style="font-weight: 700;">
                        <a class="{{Request::is('wallet')?'active-menu':''}}" href="{{route('wallet') }} "><i class="fa-solid fa-wallet"></i> {{\App\CPU\translate('my_wallet')}} </a>
                    </h3>
                    <!--<div class="divider-role"
                        style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                    </div>-->
                </div>
            </div>
        @endif
        @if ($loyalty_point_status == 1)
            <div class="pb-0">
                <!-- Filter by price-->
                <div class="sidebarL">
                    <h3 class="widget-title btnF" style="font-weight: 700;">
                        <a class="{{Request::is('loyalty')?'active-menu':''}}" href="{{route('loyalty') }} "><i class="fa fa-coins"></i> {{\App\CPU\translate('my_loyalty_point')}}</a>
                    </h3>
                    <!--<div class="divider-role"
                        style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                    </div>-->
                </div>
            </div>
        @endif
        <!--<div class="pb-0">-->
            <!-- Filter by price-->
        <!--    <div class="sidebarL">-->
        <!--        <h3 class="widget-title btnF" style="font-weight: 700;">-->
                    <!--<a class="{{Request::is('track-order*')?'active-menu':''}}" href="{{route('track-order.index') }} ">-->
                    <!--    <i class="fa-solid fa-bag-shopping"></i> {{\App\CPU\translate('track_your_order')}}</a>-->
                        
        <!--            <a class="{{Request::is('track-order*')?'active-menu':''}}" data-toggle="modal" -->
        <!--                            data-target="#trackOrder" style="cursor: pointer">-->
        <!--                <i class="fa-solid fa-bag-shopping"></i> {{\App\CPU\translate('track_your_order')}}</a>-->
        <!--        </h3>-->
                <!--<div class="divider-role"
        <!--             style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        
        <div class="pb-0">
            <!-- Filter by price-->
            <div class=" sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{(Request::is('account-ticket*') || Request::is('support-ticket*'))?'active-menu':''}}"
                       href="{{ route('account-tickets') }}"><i class="fa-solid fa-ticket"></i> {{\App\CPU\translate('support_ticket')}}</a></h3>
                <!--<div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>-->
            </div>
        </div>
        
        <div class="pb-0">
            <!-- Filter by price-->
            <div class="sidebarL">
                <h3 class="widget-title btnF " style="font-weight: 700;">
                    <a class="{{Request::is('wishlists*')?'active-menu':''}}" href="{{route('wishlists')}}"><i class="fa fa-heart"></i> {{\App\CPU\translate('wish_list')}}  <span class="d-note">{{ $wish_count }}</span></a></h3>
                <!--<div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>-->
            </div>
        </div>

        
    </div>
</div>

