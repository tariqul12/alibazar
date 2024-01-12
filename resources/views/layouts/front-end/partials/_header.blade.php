<style>
    .card-body.search-result-box {
        overflow: scroll;
        height: 400px;
        overflow-x: hidden;
    }

    .active .seller {
        font-weight: 700;
    }

    .for-count-value {
        position: absolute;

        right: 0.6875rem;;
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        /*color: {{$web_config['primary_color']}};*/

        font-size: .75rem;
        font-weight: 500;
        text-align: center;
        line-height: 1.25rem;
    }

    .count-value {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        /*color: {{$web_config['primary_color']}};*/

        font-size: .75rem;
        font-weight: 500;
        text-align: center;
        line-height: 1.25rem;
    }

    .dropdown-menu.dropdown-menu-left{
        min-width: 140px !important;
    }
    
    .dropdown-menu.show {
        display: block;
    }


    .dropdown-menu.dropdown-menu-header{
        margin-left: 0 !important;
    }
    .owl-theme .owl-nav{
        height: 0;
    }

    @media (min-width: 992px) {
        .navbar-sticky.navbar-stuck .navbar-stuck-menu.show {
            display: block;
            height: 55px !important;
        }
    }

    @media (min-width: 768px) {
        .navbar-stuck-menu {
            background-color: {{$web_config['primary_color']}};
            line-height: 15px;
            padding-bottom: 6px;
        }

    }

    @media (max-width: 767px) {
        .search_button {
            background-color: transparent !important;
        }

        .search_button .input-group-text i {
            color: {{$web_config['primary_color']}}                              !important;
        }

        .navbar-expand-md .dropdown-menu > .dropdown > .dropdown-toggle {
            position: relative;
            padding- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 1.95rem;
        }

        .mega-nav1 {
            background: white;
            color: {{$web_config['primary_color']}}                              !important;
            border-radius: 3px;
        }

        .mega-nav1 .nav-link {
            color: {{$web_config['primary_color']}}                              !important;
        }
    }

    @media (max-width: 768px) {
        .tab-logo {
            width: 10rem;
        }
    }

    @media (max-width: 360px) {
        .mobile-head {
            padding: 3px;
        }
    }

    @media (max-width: 471px) {
        .navbar-brand img {

        }

        .mega-nav1 {
            background: white;
            color: {{$web_config['primary_color']}}                              !important;
            border-radius: 3px;
        }

        .mega-nav1 .nav-link {
            color: {{$web_config['primary_color']}} !important;
        }
    }
    #anouncement {
        width: 100%;
        padding: 2px 0;
        text-align: center;
        color:white;
    }

    .text-end {
        text-align: right!important;
    }
    .social li a{
        color: #fff!important;
    }
    .btn--primary {
        background-color: #e9611e!important;
        border-color: #e9611e!important;
        color: #fff!important;
    }

    /*--------------modal----login----*/
    .auth-content-wrapper {
        display: flex;
    }

    .auth-content-wrapper .intro ul {
        padding: 0;
        margin: 60px 0 120px;
        list-style: none;
    }


    .auth-content-wrapper .intro ul li {
        color: #FFFFFF;
        background-color: #3B5998;
        padding: 12px 60px;
        border-radius: 40px;
        margin-bottom: 15px;
        width: 100%;
        max-width: 390px;
    }

    .auth-content-wrapper .auth-form {
        width: 50%;
    }


    .auth-content-wrapper .auth-form .form-header {
        border-bottom: 1px solid #CECECE;
        display: flex;
        justify-content: space-between;
        padding: 15px 15px 15px 50px;
    }

    .auth-content-wrapper .auth-form .form-header span {
        font-size: 18px;
        font-weight: 500;
    }


    .btn-close {
        box-sizing: content-box;
        width: 1em;
        height: 1em;
        padding: 0.25em 0.25em;
        color: #000;
        background: transparent url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e) center/1em auto no-repeat;
        border: 0;
        border-radius: 0.375rem;
        opacity: .5;
    }


    .auth-content-wrapper .auth-form .form-content {
        padding: 15px 50px;
    }


    .vector {
        display: block;
        margin: 30px auto;
    }


    .auth-content-wrapper .auth-form .form-content .input-group {
        margin-bottom: 18px;
    }

    .auth-content-wrapper .auth-form .form-content .input-group-text{
        padding: 7px 16px;
        color: #6C6C6C;
        font-size: 14px;
        font-weight: 500;
        border-color: #6C6C6C;
    }

    .input-group>:not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
        margin-left: -1px;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .d-grid {
        display: grid!important;
    }


    .auth-content-wrapper .auth-form .form-content .btn {
        border-radius: 0;
        padding: 12px 16px;
        font-size: 14px;
        font-weight: 500;
    }


    .btn-brand {
        background-color: #FB641B;
        color: #fff;
        border-radius: 0;
        margin-bottom:15px;
    }


    .auth-content-wrapper .auth-form .form-content .separator {
        color: #595757;
        font-size: 12px;
        font-weight: 500;
    }


    .auth-content-wrapper .auth-form .form-content .btn-google {
        color: #6C6C6C;
        border: 1px solid #4D4848;
    }
    .auth-content-wrapper .auth-form .form-content .btn img {
        margin-right: 8px;
    }

    .auth-content-wrapper .auth-form .form-content p {
        font-size: 12px;
        font-weight: 500;
        color: #6C6C6C;
        margin: 15px 0 30px;
    }

    .auth-content-wrapper .auth-form .form-content p a {
        color: #0E2F56;
        text-decoration: none;
    }

    .separator {
        margin-bottom:15px;
    }

    .btn-facebook {
        background-color: #3B5998;
        color: #FFFFFF;
        border-radius: 0;
        padding: 12px 16px;
        font-size: 14px;
        font-weight: 500;
        margin-bottom:15px;
    }

    .btn-email {
        border-color: #EB7F11;
            border-radius: 0;
        padding: 12px 16px;
        font-size: 14px;
        font-weight: 500;
    }

    .btn-google {
        color: #6C6C6C;
        border: 1px solid #4D4848;
        border-radius: 0;
        padding: 12px 16px;
        font-size: 14px;
        font-weight: 500;
        margin-bottom:15px;
    }


    .j-log {
        padding: 12px 16px;
        color: #6C6C6C;
        font-size: 14px;
        font-weight: 500;
        border-color: #6C6C6C;
        border-radius: 0px;
    }
    .input-group-text{
        padding: 7px 16px!important;
        color: #6C6C6C;
        font-size: 14px;
        font-weight: 500;
        border-color: #6C6C6C;
        border-radius: 0px;
    }

    .intro {
        background-color: #0E2F56;
        background-image: url(/public/img/artwork-city.svg);
        background-position: center bottom;
        background-size: contain;
        background-repeat: no-repeat;
        width: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content{
        border:0px!important;

    }

    .modal-body{
        padding:0px!important;
    }

    .appended-form-control{
        border-top-left-radius: 5px!important;
        border-bottom-left-radius: 5px!important;
    }
    .appended-form-control:focus{
        border:1px solid #fff;
    }

    .search-card{
        position: absolute;
        /* background: white; */
        z-index: 999;
        width: 90%;
        display: block;
        left: 127px;
        top: 34px;
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }

    .search-result-box{
        padding:10px!important;
    }

    .list-group-flush li{
        padding: 6px 0px!important;
    }
    .list-group-flush li:hover{
        background:#dee1e6;
    }

    .jz-svg{
        float: left;
        padding-top: 12px;
        margin-right: 2px;
    }
    .jz-svg img{
        width: 17px!important;
    }
    .jjj{
    float: left;
        padding-top: 12px;
        margin-right: 2px;
        display: none;
    }
    .jjj img{
        width: 17px!important;
    }
    .jz:hover .jz-svg{
        display:none;
    }
    .jz:hover .jjj{
        display:block!important;
    }

    .left-nav ul li a.submenu .submenu-items .sub-sub-menu{
        color: #fff!important;
    }
    .left-nav ul li a.submenu .submenu-items .sub-sub-menu:hover{
        background:#fff;
        color:#000!important;
    }
    .left-nav ul li a.submenu .submenu-items li:hover{
        background:#fff;
        color:#000!important;
    }

    .left-nav ul li a.submenu .submenu-items .sub-sub-menu.sub-sub-menu-items{
        width: 200px;
    }

    .left-nav ul li a.submenu:after, .left-nav ul li .sub-sub-menu:after {
        content: '';
        width: 0;
        height: 0;
        border: 6px solid transparent;
        border-left-color: #a0a0a0;
        position: absolute;
        right: 6px;
        /* top: calc(50% - 6px); */
        top: 10px;
    }

</style>
@php($announcement=\App\CPU\Helpers::get_business_settings('announcement'))
@if (isset($announcement) && $announcement['status']==1)
    <div class="d-flex align-items-center" id="anouncement" style="background-color: {{ $announcement['color'] }};color:{{$announcement['text_color']}};justify-content: space-between !important;">
        <span></span>
        <span style="text-align:center; font-size: 15px;">{{ $announcement['announcement'] }} </span>
        <span class="ml-3 mr-3" style="font-size: 12px;cursor: pointer;color: darkred"  onclick="myFunction()">X</span>
    </div>
@endif


<header class="box-shadow-sm rtl">
    <!-- Topbar-->
    <div class="j-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="j-sec-cont">
                        <div class="j-social-menu">
                            <ul class="j-social">
                            @php($social_media = \App\Model\SocialMedia::where('active_status', 1)->get())
                            @if(isset($social_media))
                                @foreach ($social_media as $item)
                                <li><a target="_blank" href="{{$item->link}}" >
                                    <i class="{{$item->icon}}" aria-hidden="true"></i></a>
                                </li>
                                @endforeach
                            @endif
                            </ul>
                            <p class="j-query">
                              <span>For any query, email us at <a href="mailto:{{\App\CPU\Helpers::get_business_settings('company_email')}}" class="j-color">{{\App\CPU\Helpers::get_business_settings('company_email')}}</a> or</span>
                              Call us on <a href="tel:{{\App\CPU\Helpers::get_business_settings('company_phone')}} " class="j-color">{{\App\CPU\Helpers::get_business_settings('company_phone')}} </a>
                            </p>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="navbar-sticky bg-light mobile-head">
        <div class="navbar navbar-expand-md navbar-light">
            <div class="container">
                @if (!request()->is('/'))
                <div class="dropdown desk-category">

                    <div class="single-page-cat" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="single-page-cat-text">
                            Shop by Category
                        </div>
                        <span><img src="{!! asset('/assets/front-end/img/icon/hamburger-icon.png') !!}"> </span>

                    </div>

                    <div class="dropdown-menu single-cat" aria-labelledby="dropdownMenuButton">
                        <div class="left-nav single-nav">
                            <nav>
                            <ul>
                                @php($categories = \App\Model\Category::where('position', 0)->priority()->take(13)->get())
                                @if(count($categories) > 0)
                                @foreach($categories as $cat)
                                    <li>
                                        <a href="#" @if ($cat->childes->count() > 0)class="submenu"  @endif>
                                            <div class="j-cat-icon">
                                                <img src="{{asset("storage/category/$cat->icon")}}" onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'" >
                                            </div>
                                            <span style="cursor: pointer" onclick="location.href='{{route('products',['id'=> $cat->id,'data_from'=>'category','page'=>1])}}'">{{ Str::limit($cat->name, 34) }}</span>
                                            @if ($cat->childes->count() > 0)
                                                <ul class="submenu-items">
                                                    @foreach($cat['childes'] as $subCategory)
                                                        <li style="cursor: pointer" class="{{$subCategory->childes->count() > 0 ? 'sub-sub-menu' : ''}}" onclick="location.href='{{route('products',['id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}'">{{$subCategory['name']}}

                                                            @if($subCategory->childes->count() > 0)
                                                            <ul class="sub-sub-menu-items">
                                                                @foreach($subCategory->childes as $subSubCategory)
                                                                    <li onclick="event.stopPropagation(); location.href='{{route('products',['id'=> $subSubCategory['id'],'data_from'=>'category','page'=>1])}}';" style="color:#000;">{{$subSubCategory['name']}}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                        </li>
                                                    @endforeach

                                                </ul>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                                @endif

                              <li><a style="cursor: pointer" data-toggle="modal" data-target="#allCategoriesModal" class="more">See More Categories &gt;&gt;</a></li>
                            </ul>

                          </nav>
                        </div>
                    </div>

                </div>
                @endif
                <!-----------------end----------->
                <main>
                    <button class="btn01 navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </main>
                <nav class="side-slide">
                    <h3 class="nav01"><i class="fa-solid fa-arrow-left"></i></h3>
                    <div class=canvas-body>
                        <div class="canvas-header">
                            @if(!auth('customer')->check())
                            <div class="canvas-img">
                                <a class="navbar-tool-icon-box dropdown-toggle" style="cursor: pointer" data-toggle="modal" data-target="#signInModal">
                                <i class="navbar-tool-icon czi-user-circle" style="font-size: 40px;padding: 4px 0 4px 0px;"></i></a>
                            </div>
                            
                            <a href="javascript:void(0);" style="cursor: pointer" data-toggle="modal" data-target="#signInModal">Login/Register</a>
                            @else
                                <div class="canvas-img">
                                    <a class="navbar-tool-icon-box dropdown-toggle" style="cursor: pointer" href="{{route('account-dashboard')}}">
                                    <img style="width: 40px;height: 40px;margin-top: 6px;"
                                                        src="{{asset('storage/profile/'.auth('customer')->user()->image)}}"
                                                        onerror="this.src='{{asset('/assets/front-end/img/profile-image-place-holder.png')}}'"
                                                        class="img-profile rounded-circle">
                                    </a>
                                </div>
                            
                                <a href="{{route('customer.auth.logout')}}">{{ \App\CPU\translate('logout')}}</a>
                            @endif
                        </div>
                        <div class="canvas-cont">
                            <p>All Category</p>
                            <div class="tab-content px-sm-0" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="row" id="body-row">
                                        <div id="sidebar-container" class="sidebar-expanded d-md-block">
                                            @php($categories = \App\CPU\CategoryManager::parents())
                                        <div class="accordion mt-n1 mobile-mt-n1" style="width: 100%;padding: 14px;padding-top: 25px; "
                                            id="shop-categories">
                                            @foreach ($categories as $category)
                                                <div>
                                                    <div class="card-header p-1 flex-between">
                                                        <div>
                                                            <label class="for-hover-lable" style="cursor: pointer"
                                                                onclick="location.href='{{ route('products', ['id' => $category['id'], 'data_from' => 'category', 'page' => 1]) }}'">
                                                                {{ $category['name'] }}
                                                            </label>
                                                        </div>
                                                        <div>
                                                            <strong class="pull-right for-brand-hover" style="cursor: pointer"
                                                                onclick="$('#collapse1-{{ $category['id'] }}').toggle(400)">
                                                                {{ $category->childes->count() > 0 ? '+' : '' }}
                                                            </strong>
                                                        </div>
                                                    </div>
                                                    <div class="card-body {{ Session::get('direction') === 'rtl' ? 'mr-2' : 'ml-2' }}"
                                                        id="collapse1-{{ $category['id'] }}" style="display: none">
                                                        @foreach ($category->childes as $child)
                                                            <div class=" for-hover-lable card-header p-1 flex-between">
                                                                <div>
                                                                    <label style="cursor: pointer" class=""
                                                                        onclick="location.href='{{ route('products', ['id' => $child['id'], 'data_from' => 'category', 'page' => 1]) }}'">
                                                                        {{ $child['name'] }}
                                                                    </label>
                                                                </div>
                                                                <div>
                                                                    <strong class="pull-right" style="cursor: pointer"
                                                                        onclick="$('#collapse1-{{ $child['id'] }}').toggle(400)">
                                                                        {{ $child->childes->count() > 0 ? '+' : '' }}
                                                                    </strong>
                                                                </div>
                                                            </div>
                                                            <div class="card-body {{ Session::get('direction') === 'rtl' ? 'mr-2' : 'ml-2' }}"
                                                                id="collapse1-{{ $child['id'] }}" style="display: none">
                                                                @foreach ($child->childes as $ch)
                                                                    <div class="card-header p-1">
                                                                        <label class="for-hover-lable" class="" style="cursor: pointer"
                                                                            onclick="location.href='{{ route('products', ['id' => $ch['id'], 'data_from' => 'category', 'page' => 1]) }}'">{{ $ch['name'] }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="row" id="body-row">
                                        <!-- Sidebar -->
                                        <div id="sidebar-container" class="sidebar-expanded d-md-block">
                                            <ul class="list-group">
                                                <a href="#submenu1" data-toggle="collapse" aria-expanded="false" class=" list-group-item list-group-item-action flex-column align-items-start">
                                                    <div class="d-flex w-100 justify-content-start align-items-center">
                                                        <span class="fa fa-dashboard fa-fw mr-3"></span>
                                                        <span class="menu-collapsed">Dashboard</span>
                                                    </div>
                                                </a>
                                                <a href="#submenu2" data-toggle="collapse" aria-expanded="false" class=" list-group-item list-group-item-action flex-column align-items-start">
                                                    <div class="d-flex w-100 justify-content-start align-items-center">
                                                        <span class="fa fa-user fa-fw mr-3"></span>
                                                        <span class="menu-collapsed">Profile</span>
                                                    </div>
                                                </a>
                                                <a href="#submenu3" data-toggle="collapse" aria-expanded="false" class=" list-group-item list-group-item-action flex-column align-items-start">
                                                    <div class="d-flex w-100 justify-content-start align-items-center">
                                                        <span class="fa fa-user fa-fw mr-3"></span>
                                                        <span class="menu-collapsed">Profile</span>
                                                    </div>
                                                </a>
                                                <a href="#submenu2" data-toggle="collapse" aria-expanded="false" class=" list-group-item list-group-item-action flex-column align-items-start">
                                                    <div class="d-flex w-100 justify-content-start align-items-center">
                                                        <span class="fa fa-user fa-fw mr-3"></span>
                                                        <span class="menu-collapsed">Profile</span>
                                                    </div>
                                                </a>
                                                <a href="#submenu3" data-toggle="collapse" aria-expanded="false" class=" list-group-item list-group-item-action flex-column align-items-start">
                                                    <div class="d-flex w-100 justify-content-start align-items-center">
                                                        <span class="fa fa-user fa-fw mr-3"></span>
                                                        <span class="menu-collapsed">Profile</span>
                                                    </div>
                                                </a>
                                                <a href="#submenu2" data-toggle="collapse" aria-expanded="false" class=" list-group-item list-group-item-action flex-column align-items-start">
                                                    <div class="d-flex w-100 justify-content-start align-items-center">
                                                        <span class="fa fa-user fa-fw mr-3"></span>
                                                        <span class="menu-collapsed">Profile</span>
                                                    </div>
                                                </a>
                                                <a href="#submenu3" data-toggle="collapse" aria-expanded="false" class=" list-group-item list-group-item-action flex-column align-items-start">
                                                    <div class="d-flex w-100 justify-content-start align-items-center">
                                                        <span class="fa fa-user fa-fw mr-3"></span>
                                                        <span class="menu-collapsed">Profile</span>
                                                    </div>
                                                </a>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>



                <script>
                    // --- Nav |  01  |  Side-Slide
                $('.btn01').click(function() {
                    $('.side-slide').animate({left: "0px"}, 200);
                });

                $('h3.nav01').click(function() {
                    $('.side-slide').animate({left: "-285px"}, 200);
                });


                // --- Nav |  02  |  drop-down
                $('.btn02').click(function() {
                    $('.drop-down').animate({top: "0px"}, 200);
                });

                $('h3.nav02').click(function() {
                    $('.drop-down').animate({top: "-100vh"}, 200);
                });
                </script>

                <a class="navbar-brand d-sm-block {{Session::get('direction') === "rtl" ? '' : ''}} flex-shrink-0"
                   href="{{route('home')}}"
                   style="min-width: 7rem;">
                    <img style="height: 40px!important; width:auto;"
                         src="{{asset("storage/company")."/".$web_config['web_logo']->value}}"
                         onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'"
                         alt="{{$web_config['name']->value}}"/>
                </a>
                
                  <!------------------juvaer for mobile------------>
                @if(!auth('customer')->check())
                 <a class="navbar-brand d-sm-none ">
                    <div class="navbar-tool dropdown  mobile-sign">
                        <a class="navbar-tool-icon-box dropdown-toggle" style="cursor: pointer" data-toggle="modal" data-target="#signInModal">
                        <i class="navbar-tool-icon czi-user-circle"></i></a>

                    </div>
                </a>
                @else
                <a class="navbar-brand d-sm-none ">
                    <div class="navbar-tool dropdown  mobile-sign">
                        <a class="navbar-tool-icon-box dropdown-toggle" style="cursor: pointer" href="{{route('account-dashboard')}}">
                        <img style="width: 20px;height: 20px"
                                             src="{{asset('storage/profile/'.auth('customer')->user()->image)}}"
                                             onerror="this.src='{{asset('/assets/front-end/img/profile-image-place-holder.png')}}'"
                                             class="img-profile rounded-circle">
                        </a>

                    </div>
                </a>
                @endif
                <a class="navbar-tool-icon-box dropdown-toggle mobile-sign" href="{{route('shop-cart')}}">
                    <span class="navbar-tool-label mobile-cart-count">
                        @php($cart=\App\CPU\CartManager::get_cart())
                        {{$cart->count()}}
                    </span>
                    <i class="navbar-tool-icon czi-cart"></i>
                </a>
                <a class="navbar-brand d-sm-none dropdown-link" action="{{route('products')}}" type="submit" class="search_form">
                    <i class="czi-search text-white mobile_search"></i>
                </a>
                
                <a class="navbar-brand d-sm-none dropdown-link" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-ellipsis-vertical"></i>
                </a>
                <div class="dropdown-file">
                    <div class="dropdown-menu dropdown-menu-right" style="min-width: 200px!important;">
                        <a href="{{route('quote-cart')}}" class="dropdown-item">
                            <span>Quotation</span>
                        </a>
                        <a href="" class="dropdown-item" data-toggle="modal" data-target="#trackOrder">
                            <span>Track Order</span>
                        </a>
                    </div>
                </div>           
                <!------------------juvaer end for mobile------------>              
                            
                <!-- Search-->
                <div class="input-group-overlay d-md-block"
                     style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};width: 42%;margin-left: 70px;">

                    <div class="dropdown j-categories">
                      <button class="btn btn-cat-search dropdown-toggle" id="search-dropdown-button" type="button" data-toggle="dropdown" aria-expanded="false" style="width: 130px;">
                        All Categories
                      </button>
                      
                      <div class="dropdown-menu dropdown-menu-header" id="search-category-dropdown">
                        @php($categories = \App\Model\Category::where('position', 0)->priority()->orderBy('name', 'asc')->take(13)->get())
                        @foreach($categories as $cat)
                        <a class="dropdown-item" href="#" data-id="{{$cat->id}}">{!! $cat->name !!}</a>
                        @endforeach
                      </div>
                    </div>

                    <form action="{{route('products')}}" type="submit" class="search_form search-area-mobile jb-search" >
                        <input class="form-control appended-form-control search-bar-input" type="text"
                               autocomplete="off"
                               placeholder="{{\App\CPU\translate('search_for_your_product_here')}}"
                               name="name">
                        <button class="input-group-append-overlay search_button" type="submit"
                                style="border-radius: {{Session::get('direction') === "rtl" ? '7px 0px 0px 7px; right: unset; left: 0' : '0px 5px 5px 0px; left: unset; right: 0'}};top:0;background: none!important;">
                                <span class="input-group-text" style="font-size: 17px;">
                                    <i class="czi-search text-white"></i>
                                </span>
                        </button>
                        <input name="data_from" value="search" hidden>
                        <input name="page" value="1" hidden>
                        <input type="hidden" name="search_cat_id" id="search_cat_id" value="">
                        <div class="card search-card exculsive-search-area" style="box-shadow: 0px 0px 4px #a6a6a6;position: absolute;background: white;z-index: 999;width: 750px;display: none;top: 33px;left: 0;">
                            <div class="card-body search-result-box" style="height:400px;overflow-x: hidden;width: 100%;float: left;border-right: 1px solid #ccc;">
                            </div>
                        </div>

                        <div class="card search-card trending-search-area" style="box-shadow: 0px 0px 4px #a6a6a6;position: absolute;background: white;z-index: 999;max-width: 408px;display: none;top: 33px;left: 133px;">
                            <div class="j-mobile-search">
                                
                            </div>
                            <div class="card-body search-result-box" style="max-height:318px;overflow-x: hidden;width: 100%;float: left;border-right: 1px solid #ccc;">
                                <div class="search-result-box-brand">
                                    @php($trend_searches=\App\Model\ProSearch::orderBy('count','desc')->get()->take(10))
                                    <h5>Trending Searches</h5>
                                    <ul>
                                        @foreach($trend_searches as $search)
                                            <li><a href="javascript:void(0);" onclick="location.href='{{route('products',['name'=> $search->query,'data_from'=>'search','page'=>1])}}'">{{$search->query}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Toolbar-->
                <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center" >
                    <div class="navbar-tool dropdown {{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">
                    </div>
                    <div class="navbar-tool dropdown {{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}"  id="quote_items">
                        <a class="navbar-tool-icon-box dropdown-toggle" href="{{route('quote-cart')}}">
                            <i class="navbar-tool-icon czi-dollar-circle"></i>Quotation
                        </a>
                    </div>

                    <!---->

                    @if(!auth('customer')->check())
                    <div class="navbar-tool dropdown {{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">
                        <a class="navbar-tool-icon-box dropdown-toggle"
                                style="cursor: pointer"
                                data-toggle="modal"
                                data-target="#signInModal">
                        <i class="navbar-tool-icon czi-user-circle"></i> {{\App\CPU\translate('sign_in')}}</a>

                    </div>
                    @endif
                    @if(auth('customer')->check())
                    <div class="dropdown">
                        <a class="navbar-tool ml-2 mr-2 " type="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <div class="navbar-tool-icon-box">
                                <div class="navbar-tool-icon-box">
                                    <img style="width: 20px;height: 20px"
                                            src="{{asset('storage/profile/'.auth('customer')->user()->image)}}"
                                            onerror="this.src='{{asset('/assets/front-end/img/profile-image-place-holder.png')}}'"
                                            class="img-profile rounded-circle">
                                            <span>{{auth('customer')->user()->f_name}}</span>
                                </div>
                            </div>
                            <div class="navbar-tool-text">
                                <small>{{\App\CPU\translate('hello')}}, {{auth('customer')->user()->f_name}}</small>
                                {{\App\CPU\translate('dashboard')}}
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item"
                                href="{{route('account-oder')}}"> {{ \App\CPU\translate('my_Order')}} </a>
                                <a class="dropdown-item"
                                href="{{route('account-quotation')}}"> {{ \App\CPU\translate('my_Quotation')}} </a>
                                <a class="dropdown-item"
                                href="{{route('user-account')}}"> {{ \App\CPU\translate('my_Profile')}}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item"
                                href="{{route('customer.auth.logout')}}">{{ \App\CPU\translate('logout')}}</a>
                        </div>
                    </div>
                    @endif

                    <div class="navbar-tool dropdown {{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">
                        <a class="navbar-tool-icon-box dropdown-toggle jz" style="cursor: pointer"
                                    data-toggle="modal"
                                    data-target="#trackOrder">
                            <span class="jz-svg"> <img src="{{asset('/assets/front-end/img/icon/track-w.svg')}}" class="d-block mx-auto" alt="pay-later"></span>
                            <span class="jjj"> <img src="{{asset('/assets/front-end/img/icon/track.svg')}}" class="d-block mx-auto" alt="pay-later"></span>
                            Track Order
                        </a>
                    </div>

                    <div id="cart_items">
                        @include('layouts.front-end.partials.cart')
                    </div>
                </div>
            </div>
        </div>
        <!----------------search---------->

        <div class="navbar navbar-expand-md navbar-stuck-menu"  style="display:none">
            <div class="container" style="padding-left: 10px;padding-right: 10px;">
                <div class="collapse navbar-collapse" id="navbarCollapse"
                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}}; ">

                    <!-- Search-->
                    <div class="input-group-overlay d-md-none my-3">
                        <form action="{{route('products')}}" type="submit" class="search_form">
                            <input class="form-control appended-form-control search-bar-input-mobile" type="text"
                                   autocomplete="off"
                                   placeholder="{{\App\CPU\translate('search')}}" name="name">
                            <input name="data_from" value="search" hidden>
                            <input name="page" value="1" hidden>
                            <button class="input-group-append-overlay search_button" type="submit"
                                    style="border-radius: {{Session::get('direction') === "rtl" ? '7px 0px 0px 7px; right: unset; left: 0' : '0px 7px 7px 0px; left: unset; right: 0'}};">
                            <span class="input-group-text" style="font-size: 20px; padding: 7px 16px!important;">
                                <i class="czi-search text-white"></i>
                            </span>
                            </button>
                            <diV class="card search-card"
                                 style="position:absolute;background:white;z-index:999;width:90%;display:none;left: 127px;">
                                <div class="card-body search-result-box" id=""
                                     style="overflow:scroll; height:400px;overflow-x: hidden"></div>
                            </diV>
                        </form>
                    </div>

                    @php($categories=\App\Model\Category::with(['childes.childes'])->where('position', 0)->priority()->paginate(11))
                    <ul class="navbar-nav mega-nav pr-2 pl-2 {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}} d-none d-xl-block ">
                        <!--web-->
                        <li class="nav-item {{!request()->is('/')?'dropdown':''}}">
                            <a class="nav-link dropdown-toggle {{Session::get('direction') === "rtl" ? 'pr-0' : 'pl-0'}}"
                               href="#" data-toggle="dropdown" style="{{request()->is('/')?'pointer-events: none':''}}">
                                <i class="czi-menu align-middle mt-n1 {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}"></i>
                                <span
                                    style="margin-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 40px !important;margin-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 50px">
                                    {{ \App\CPU\translate('categories')}}
                                </span>
                            </a>
                            @if(request()->is('/'))
                                <ul class="dropdown-menu" style="right: 0%; display: block!important;
                                    margin-top: 8px; margin-right: 11px;border: 1px solid #ccccccb3;
                                    border-bottom-left-radius: 5px;
                                    border-bottom-right-radius: 5px; box-shadow: none;min-width: 303px !important;{{Session::get('direction') === "rtl" ? 'margin-right: 1px!important;text-align: right;' : 'margin-left: 1px!important;text-align: left;'}}padding-bottom: 0px!important;">
                                    @foreach($categories as $key=>$category)
                                        @if($key<8)
                                            <li class="dropdown">
                                                <a class="dropdown-item flex-between"
                                                   <?php if ($category->childes->count() > 0) echo "data-toggle='dropdown'"?> href="javascript:"
                                                   onclick="location.href='{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}'">
                                                    <div>
                                                        <img
                                                            src="{{asset("storage/category/$category->icon")}}"
                                                            onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'"
                                                            style="width: 18px; height: 18px; ">
                                                        <span
                                                            class="{{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}}">{{$category['name']}}</span>
                                                    </div>
                                                    @if ($category->childes->count() > 0)
                                                        <div>
                                                            <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}" style="font-size: 8px !important;background:none !important;color:#4B5864;"></i>
                                                        </div>
                                                    @endif
                                                </a>
                                                @if($category->childes->count()>0)
                                                    <ul class="dropdown-menu"
                                                        style="right: 100%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                                        @foreach($category['childes'] as $subCategory)
                                                            <li class="dropdown">
                                                                <a class="dropdown-item flex-between"
                                                                   <?php if ($subCategory->childes->count() > 0) echo "data-toggle='dropdown'"?> href="javascript:"
                                                                   onclick="location.href='{{route('products',['id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}'">
                                                                    <div>
                                                                        <span
                                                                            class="{{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}}">{{$subCategory['name']}}</span>
                                                                    </div>
                                                                    @if ($subCategory->childes->count() > 0)
                                                                        <div>
                                                                            <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}" style="font-size: 8px !important;background:none !important;color:#4B5864;"></i>
                                                                        </div>
                                                                    @endif
                                                                </a>
                                                                @if($subCategory->childes->count()>0)
                                                                    <ul class="dropdown-menu"
                                                                        style="right: 100%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                                                        @foreach($subCategory['childes'] as $subSubCategory)
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                   href="{{route('products',['id'=> $subSubCategory['id'],'data_from'=>'category','page'=>1])}}">{{$subSubCategory['name']}}</a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                    <a class="dropdown-item text-capitalize" href="{{route('categories')}}"
                                       style="color: {{$web_config['primary_color']}} !important;{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 29%">
                                        {{\App\CPU\translate('view_more')}}

                                        <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}" style="font-size: 8px !important;background:none !important;color:#4B5864;"></i>
                                    </a>

                                </ul>
                            @else
                                <ul class="dropdown-menu"
                                    style="right: 0; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                    @foreach($categories as $category)
                                        <li class="dropdown">
                                            <a class="dropdown-item flex-between <?php if ($category->childes->count() > 0) echo "data-toggle='dropdown"?> "
                                               <?php if ($category->childes->count() > 0) echo "data-toggle='dropdown'"?> href="javascript:"
                                               onclick="location.href='{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}'">
                                                <div>
                                                    <img src="{{asset("storage/category/$category->icon")}}"
                                                         onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'"
                                                         style="width: 18px; height: 18px; ">
                                                    <span
                                                        class="{{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}}">{{$category['name']}}</span>
                                                </div>
                                                @if ($category->childes->count() > 0)
                                                    <div>
                                                        <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}" style="font-size: 8px !important;background:none !important;color:#4B5864;"></i>
                                                    </div>
                                                @endif
                                            </a>
                                            @if($category->childes->count()>0)
                                                <ul class="dropdown-menu"
                                                    style="right: 100%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                                    @foreach($category['childes'] as $subCategory)
                                                        <li class="dropdown">
                                                            <a class="dropdown-item flex-between <?php if ($subCategory->childes->count() > 0) echo "data-toggle='dropdown"?> "
                                                               <?php if ($subCategory->childes->count() > 0) echo "data-toggle='dropdown'"?> href="javascript:"
                                                               onclick="location.href='{{route('products',['id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}'">
                                                                <div>
                                                                    <span
                                                                        class="{{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}}">{{$subCategory['name']}}</span>
                                                                </div>
                                                                @if ($subCategory->childes->count() > 0)
                                                                    <div>
                                                                        <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}" style="font-size: 8px !important;background:none !important;color:#4B5864;"></i>
                                                                    </div>
                                                                @endif
                                                            </a>
                                                            @if($subCategory->childes->count()>0)
                                                                <ul class="dropdown-menu"
                                                                    style="right: 100%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                                                    @foreach($subCategory['childes'] as $subSubCategory)
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                               href="{{route('products',['id'=> $subSubCategory['id'],'data_from'=>'category','page'=>1])}}">{{$subSubCategory['name']}}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                    <a class="dropdown-item" href="{{route('categories')}}"
                                       style="color: {{$web_config['primary_color']}} !important;{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 29%">
                                        {{\App\CPU\translate('view_more')}}

                                        <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}" style="font-size: 8px !important;background:none !important;color:{{$web_config['primary_color']}} !important;"></i>
                                    </a>
                                </ul>
                            @endif
                        </li>
                    </ul>

                    <ul class="navbar-nav mega-nav1 pr-2 pl-2 d-block d-xl-none"><!--mobile-->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{Session::get('direction') === "rtl" ? 'pr-0' : 'pl-0'}}"
                               href="#" data-toggle="dropdown">
                                <i class="czi-menu align-middle mt-n1 {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}"></i>
                                <span
                                    style="margin-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 20px !important;">{{ \App\CPU\translate('categories')}}</span>
                            </a>
                            <ul class="dropdown-menu"
                                style="right: 0%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                @foreach($categories as $category)
                                    <li class="dropdown">

                                            <a style="font-family:  sans-serif !important;font-size: 1rem;
                                            font-weight: 300;line-height: 1.5;"
                                           <?php if ($category->childes->count() > 0) echo ""?>
                                            href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}">
                                            <img src="{{asset("storage/category/$category->icon")}}"
                                                 onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'"
                                                 style="width: 18px; height: 18px; ">
                                            <span
                                                class="{{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}}">{{$category['name']}}</span>

                                        </a>
                                        @if ($category->childes->count() > 0)
                                            <a  data-toggle='dropdown' style="margin-left:50px;">
                                                <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"
                                                style="font-size: 10px !important;background:none !important;color:#4B5864;font:bold;"></i>
                                            </a>
                                        @endif

                                        @if($category->childes->count()>0)
                                            <ul class="dropdown-menu"
                                                style="right: 10%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                                @foreach($category['childes'] as $subCategory)
                                                    <li class="dropdown">
                                                        <a  href="{{route('products',['id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}">
                                                            <span
                                                                class="{{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}}">{{$subCategory['name']}}</span>
                                                        </a>

                                                        @if($subCategory->childes->count()>0)
                                                        <a style="font-family:  sans-serif !important;font-size: 1rem;
                                                            font-weight: 300;line-height: 1.5;margin-left:50px;" data-toggle='dropdown'>
                                                                <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"
                                                                style="font-size: 10px !important;background:none !important;color:#4B5864;font:bold;"></i>
                                                            </a>
                                                            <ul class="dropdown-menu"
                                                                style="right: 100%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                                                @foreach($subCategory['childes'] as $subSubCategory)
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                           href="{{route('products',['id'=> $subSubCategory['id'],'data_from'=>'category','page'=>1])}}">{{$subSubCategory['name']}}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                    <!-- Primary menu-->
                    <ul class="navbar-nav" style="{{Session::get('direction') === "rtl" ? 'padding-right: 0px' : ''}}">
                        <li class="nav-item dropdown {{request()->is('/')?'active':''}}">
                            <a class="nav-link" href="{{route('home')}}">{{ \App\CPU\translate('Home')}}</a>
                        </li>

                        @if(\App\Model\BusinessSetting::where(['type'=>'product_brand'])->first()->value)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#"
                               data-toggle="dropdown">{{ \App\CPU\translate('brand') }}</a>
                            <ul class="dropdown-menu dropdown-menu-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} scroll-bar"
                                style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                @foreach(\App\CPU\BrandManager::get_active_brands() as $brand)
                                    <li style="border-bottom: 1px solid #e3e9ef; display:flex; justify-content:space-between; ">
                                        <div>
                                            <a class="dropdown-item"
                                               href="{{route('products',['id'=> $brand['id'],'data_from'=>'brand','page'=>1])}}">
                                                {{$brand['name']}}
                                            </a>
                                        </div>
                                        <div class="align-baseline">
                                            @if($brand['brand_products_count'] > 0 )
                                                <span class="count-value px-2">( {{ $brand['brand_products_count'] }} )</span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                                <li style="border-bottom: 1px solid #e3e9ef; display:flex; justify-content:center;">
                                    <div>
                                        <a class="dropdown-item" href="{{route('brands')}}"
                                        style="color: {{$web_config['primary_color']}} !important;">
                                            {{ \App\CPU\translate('View_more') }}
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @php($discount_product = App\Model\Product::with(['reviews'])->active()->where('discount', '!=', 0)->count())
                        @if ($discount_product>0)
                            <li class="nav-item dropdown {{request()->is('/')?'active':''}}">
                                <a class="nav-link text-capitalize" href="{{route('products',['data_from'=>'discounted','page'=>1])}}">{{ \App\CPU\translate('discounted_products')}}</a>
                            </li>
                        @endif

                        @php($business_mode=\App\CPU\Helpers::get_business_settings('business_mode'))
                        @if ($business_mode == 'multi')
                            <li class="nav-item dropdown {{request()->is('/')?'active':''}}">
                                <a class="nav-link" href="{{route('sellers')}}">{{ \App\CPU\translate('Sellers')}}</a>
                            </li>

                            @php($seller_registration=\App\Model\BusinessSetting::where(['type'=>'seller_registration'])->first()->value)
                            @if($seller_registration)
                                <li class="nav-item">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                style="color: white;margin-top: 5px; padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 0">
                                            {{ \App\CPU\translate('Seller')}}  {{ \App\CPU\translate('zone')}}
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                            style="min-width: 165px !important; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                            <a class="dropdown-item" href="{{route('shop.apply')}}">
                                                {{ \App\CPU\translate('Become a')}} {{ \App\CPU\translate('Seller')}}
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{route('seller.auth.login')}}">
                                                {{ \App\CPU\translate('Seller')}}  {{ \App\CPU\translate('login')}}
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    function myFunction() {
    $('#anouncement').addClass('d-none').removeClass('d-flex')
    }

    $(document).on("click", ".mobile_search", function () {
        $('.search-area-mobile').toggle();
        $(".search-area-mobile").find('.search-bar-input').trigger("click");
    });

    // change category dropdown values om search
  $('#search-category-dropdown').find('a').on('click', function(e) {
    e.preventDefault();
    const categoryId = $(this).data('id');
    const categoryLabel = $(this).text();
    // console.log(categoryId, categoryLabel);
    var count = 13;
    var slicedText = categoryLabel.slice(0, count) + (categoryLabel.length > count ? ".." : "");

    $('#search_cat_id').val(categoryId);
    $('#search-dropdown-button').text(slicedText);
  });
</script>