@extends('layouts.front-end.app')
@php
$meta_title='';
$meta_description='';
$meta_image='';
$seo_info=\App\Model\BusinessSetting::where('type','meta_title')->first();
if($seo_info != null ) $meta_title=$seo_info->value;

$seo_info=\App\Model\BusinessSetting::where('type','meta_description')->first();
if($seo_info != null ) $meta_description=$seo_info->value;

$seo_info=\App\Model\BusinessSetting::where('type','meta_image')->first();
if($seo_info != null ) $meta_image=$seo_info->value;

@endphp
@section('title', $meta_title)

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/company')}}/{{$meta_image}}"/>
    <meta property="og:title" content="{{$meta_title}}"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! $meta_description !!}">

    <meta property="twitter:card" content="{{asset('storage/company')}}/{{$meta_image}}"/>
    <meta property="twitter:title" content=" {{$meta_title}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! $meta_description !!}">

    <link rel="stylesheet" href="{{asset('/assets/front-end')}}/css/home.css"/>
    <style>
        .media {
            background: white;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
        }

        .cz-countdown-days {
            color: white !important;
            background-color: #ffffff30;
            border: .5px solid{{$web_config['primary_color']}};
            padding: 0px 6px;
            border-radius: 3px;
            margin-right: 0px !important;
            display: flex;
            flex-direction: column;
            -ms-flex: .4;  /* IE 10 */
            flex: 1;

        }

        .cz-countdown-hours {
            color: white !important;
            background-color: #ffffff30;
            border: .5px solid{{$web_config['primary_color']}};
            padding: 0px 6px;
            border-radius: 3px;
            margin-right: 0px !important;
            display: flex;
            flex-direction: column;
            -ms-flex: .4;  /* IE 10 */
            flex: 1;
        }

        .cz-countdown-minutes {
            color: white !important;
            background-color: #ffffff30;
            border: .5px solid{{$web_config['primary_color']}};
            padding: 0px 6px;
            border-radius: 3px;
            margin-right: 0px !important;
            display: flex;
            flex-direction: column;
            -ms-flex: .4;  /* IE 10 */
            flex: 1;
        }

        .cz-countdown-seconds {
            color: white !important;
            background-color: #ffffff30;
            border: .5px solid{{$web_config['primary_color']}};
            padding: 0px 6px;
            border-radius: 3px;
            display: flex;
            flex-direction: column;
            -ms-flex: .4;  /* IE 10 */
            flex: 1;
        }

        .flash_deal_product_details .flash-product-price {
            font-weight: 700;
            font-size: 18px;
            color: {{$web_config['primary_color']}};
        }

        .featured_deal_left {
            height: 130px;
            background: {{$web_config['primary_color']}} 0% 0% no-repeat padding-box;
            padding: 10px 13px;
            text-align: center;
        }

        .category_div:hover {
            color: {{$web_config['secondary_color']}};
        }

        .deal_of_the_day {
            background: {{$web_config['secondary_color']}};
            border-radius: 3px;
        }

        .deal-title {
            font-size: 12px;

        }

        .for-flash-deal-img img {
            max-width: none;
        }
        .best-selleing-image {
            background:{{$web_config['primary_color']}}10;
            width:30%;
            display:flex;
            align-items:center;
            border-radius: 5px;
        }
        .best-selling-details {
            padding:10px;
            width:50%;
        }
        .top-rated-image{
            background:{{$web_config['primary_color']}}10;
            width:30%;
            display:flex;
            align-items:center;
            border-radius: 5px;
        }
        .top-rated-details {
            padding:10px;width:70%;
        }

        @media (max-width: 375px) {
            .cz-countdown {
                display: flex !important;

            }

            .cz-countdown .cz-countdown-seconds {

                margin-top: -5px !important;
            }

            .for-feature-title {
                font-size: 20px !important;
            }
        }

        @media (max-width: 600px) {
            .flash_deal_title {
                font-weight: 700;
                font-size: 25px;
                text-transform: uppercase;
            }

            .cz-countdown .cz-countdown-value {
                font-size: 11px !important;
                font-weight: 700 !important;

            }

            .featured_deal {
                opacity: 1 !important;
            }

            .cz-countdown {
                display: inline-block;
                flex-wrap: wrap;
                font-weight: normal;
                margin-top: 4px;
                font-size: smaller;
            }

            .view-btn-div-f {

                margin-top: 6px;
                float: right;
            }

            .view-btn-div {
                float: right;
            }

            .viw-btn-a {
                font-size: 10px;
                font-weight: 600;
            }


            .for-mobile {
                display: none;
            }

            .featured_for_mobile {
                max-width: 100%;
                margin-top: 20px;
                margin-bottom: 20px;
            }
            .best-selleing-image {
                width: 50%;
                border-radius: 5px;
            }
            .best-selling-details {
                width:50%;
            }
            .top-rated-image {
                width: 50%;
            }
            .top-rated-details {
            width:50%;
        }
        }


        @media (max-width: 360px) {
            .featured_for_mobile {
                max-width: 100%;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .featured_deal {
                opacity: 1 !important;
            }
        }

        @media (max-width: 375px) {
            .featured_for_mobile {
                max-width: 100%;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .featured_deal {
                opacity: 1 !important;
            }

        }

        @media (min-width: 768px) {
            .displayTab {
                display: block !important;
            }

        }

        @media (max-width: 800px) {

            .latest-product-margin {
                margin-left: 0px !important;
                }
            .for-tab-view-img {
                width: 40%;
            }

            .for-tab-view-img {
                width: 105px;
            }

            .widget-title {
                font-size: 19px !important;
            }
            .flash-deal-view-all-web {
                display: none !important;
            }
            .categories-view-all {
                {{session('direction') === "rtl" ? 'margin-left: 10px;' : 'margin-right: 6px;'}}
            }
            .categories-title {
                {{Session::get('direction') === "rtl" ? 'margin-right: 0px;' : 'margin-left: 6px;'}}
            }
            .seller-list-title{
                {{Session::get('direction') === "rtl" ? 'margin-right: 0px;' : 'margin-left: 10px;'}}
            }
            .seller-list-view-all {
                {{Session::get('direction') === "rtl" ? 'margin-left: 20px;' : 'margin-right: 10px;'}}
            }
            .seller-card {
                padding-left: 0px !important;
            }
            .category-product-view-title {
                {{Session::get('direction') === "rtl" ? 'margin-right: 16px;' : 'margin-left: -8px;'}}
            }
            .category-product-view-all {
                {{Session::get('direction') === "rtl" ? 'margin-left: -7px;' : 'margin-right: 5px;'}}
            }
            .recomanded-product-card {
                background: #F8FBFD;margin:20px;height: 535px; border-radius: 5px;
            }
            .recomanded-buy-button {
                text-align: center;
                margin-top: 30px;
            }
        }
        @media(min-width:801px){
            .flash-deal-view-all-mobile{
                display: none !important;
            }
            .categories-view-all {
                {{session('direction') === "rtl" ? 'margin-left: 30px;' : 'margin-right: 27px;'}}
            }
            .categories-title {
                {{Session::get('direction') === "rtl" ? 'margin-right: 25px;' : 'margin-left: 25px;'}}
            }
            .seller-list-title{
                {{Session::get('direction') === "rtl" ? 'margin-right: 6px;' : 'margin-left: 10px;'}}
            }
            .seller-list-view-all {
                {{Session::get('direction') === "rtl" ? 'margin-left: 12px;' : 'margin-right: 10px;'}}
            }
            .seller-card {
                {{Session::get('direction') === "rtl" ? 'padding-left:0px !important;' : 'padding-right:0px !important;'}}
            }
            .category-product-view-title {
                {{Session::get('direction') === "rtl" ? 'margin-right: 10px;' : 'margin-left: -12px;'}}
            }
            .category-product-view-all {
                {{Session::get('direction') === "rtl" ? 'margin-left: -20px;' : 'margin-right: 0px;'}}
            }
            .recomanded-product-card {
                background: #F8FBFD;margin:20px;height: 475px; border-radius: 5px;
            }
            .recomanded-buy-button {
                text-align: center;
                margin-top: 63px;
            }

        }

        .featured_deal_carosel .carousel-inner {
            width: 100% !important;
        }

        .badge-style2 {
            color: black !important;
            background: transparent !important;
            font-size: 11px;
        }
        .countdown-card{
            background:{{$web_config['primary_color']}}10;
            height: 150px!important;
            border-radius:5px;

        }
        .flash-deal-text{
            color: {{$web_config['primary_color']}};
            text-transform: uppercase;
            text-align:center;
            font-weight:700;
            font-size:20px;
            border-radius:5px;
            margin-top:25px;
        }
        .countdown-background{
            background: {{$web_config['primary_color']}};
            padding: 5px 5px;
            border-radius:5px;
            margin-top:15px;
        }
        .carousel-wrap{
            position: relative;
        }
        .owl-nav{
            top: 40%;
            position: absolute;
            display: flex;
            justify-content: space-between;
            width: 100%;
        }
        .owl-prev{
            float: left;

        }
        .owl-next{
            float: right;
        }
        .czi-arrow-left{
            color: {{$web_config['primary_color']}};
            background: {{$web_config['primary_color']}}10;
            padding: 5px;
            border-radius: 50%;
            margin-left: -26px;
            font-weight: bold;
            font-size: 12px;
        }
        .czi-arrow-right{
            color: {{$web_config['primary_color']}};
            background: {{$web_config['primary_color']}}10;
            padding: 5px;
            border-radius: 50%;
            margin-right: -8px;
            font-weight: bold;
            font-size: 12px;
        }
        .owl-carousel .nav-btn .czi-arrow-left{
        height: 47px;
        position: absolute;
        width: 26px;
        cursor: pointer;
        top: 100px !important;
        }
        .flash-deals-background-image{
            background: {{$web_config['primary_color']}}10;
            border-radius:5px;
            width:125px;
            height:125px;
        }
        .view-all-text{
            color:{{$web_config['secondary_color']}} !important;
            font-size:14px;
        }
        .feature-product-title {
            text-align: center;
            font-size: 22px;
            margin-top: 15px;
            font-style: normal;
            font-weight: 700;
        }
        .feature-product .czi-arrow-left{
            color: {{$web_config['primary_color']}};
            background: {{$web_config['primary_color']}}10;
            padding: 5px;
            border-radius: 50%;
            margin-left: -80px;
            font-weight: bold;
            font-size: 12px;
        }

        .feature-product .owl-nav{
            top: 40%;
            position: absolute;
            display: flex;
            justify-content: space-between;
            /* width: 100%; */
            z-index: -999;
        }
        .feature-product .czi-arrow-right{
            color: {{$web_config['primary_color']}};
            background: {{$web_config['primary_color']}}10;
            padding: 5px;
            border-radius: 50%;
            margin-right: -80px;
            font-weight: bold;
            font-size: 12px;
        }
        .shipping-policy-web{
            background: #ffffff;width:100%; border-radius:5px;
        }
        .shipping-method-system{
            height: 130px;width: 70%;margin-top: 15px;
        }

        .flex-between {
            display: flex;
            justify-content: space-between;
        }
        .new_arrival_product .czi-arrow-left{
            margin-left: -28px;
        }
        .new_arrival_product .owl-nav{
            z-index: -999;
        }
        .btn--primary {
            background-color: #e9611e!important;
            border-color: #e9611e!important;
            color: #fff!important;
        }
    </style>

    <link rel="stylesheet" href="{{asset('/assets/front-end')}}/css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="{{asset('/assets/front-end')}}/css/owl.theme.default.min.css"/>
@endpush

@section('content')

@php($decimal_point_settings = !empty(\App\CPU\Helpers::get_business_settings('decimal_point_settings')) ? \App\CPU\Helpers::get_business_settings('decimal_point_settings') : 0)
    <!-- Hero (Banners + Slider)-->
    <section class="bg-transparent">
        <div class="container">
            <div class="row ">
                <div class="col-12">
                    @include('web-views.partials._home-top-slider')

                </div>

        </div>
    </section>

@endsection



@push('script')
    {{-- Owl Carousel --}}
    <script src="{{asset('/assets/front-end')}}/js/owl.carousel.min.js"></script>

    <script>
        $('#flash-deal-slider').owlCarousel({
            loop: false,
            autoplay: false,
            margin: 5,
            nav: true,
            navText: ["<i class='czi-arrow-left'></i>", "<i class='czi-arrow-right'></i>"],
            dots: false,
            autoplayHoverPause: true,
            '{{session('direction')}}': false,
            // center: true,
            responsive: {
                //X-Small
                0: {
                    items: 1
                },
                360: {
                    items: 1
                },
                375: {
                    items: 1
                },
                540: {
                    items: 2
                },
                //Small
                576: {
                    items: 2
                },
                //Medium
                768: {
                    items: 2
                },
                //Large
                992: {
                    items: 2
                },
                //Extra large
                1200: {
                    items: 2
                },
                //Extra extra large
                1400: {
                    items: 3
                }
            }
        })

        $('#web-feature-deal-slider').owlCarousel({
            loop: false,
            autoplay: false,
            margin: 5,
            nav: false,
            //navText: ["<i class='czi-arrow-left'></i>", "<i class='czi-arrow-right'></i>"],
            dots: false,
            autoplayHoverPause: true,
            '{{session('direction')}}': true,
            // center: true,
            responsive: {
                //X-Small
                0: {
                    items: 1
                },
                360: {
                    items: 1
                },
                375: {
                    items: 1
                },
                540: {
                    items: 2
                },
                //Small
                576: {
                    items: 2
                },
                //Medium
                768: {
                    items: 2
                },
                //Large
                992: {
                    items: 2
                },
                //Extra large
                1200: {
                    items: 2
                },
                //Extra extra large
                1400: {
                    items: 2
                }
            }
        })

        $('#new-arrivals-product, #shop-by-brand').owlCarousel({
            loop: true,
            autoplay: true,
            margin: 5,
            nav: true,
            navText: ["<i class='czi-arrow-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}'></i>", "<i class='czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}'></i>"],
            dots: false,
            autoplayHoverPause: true,
            '{{session('direction')}}': true,
            // center: true,
            responsive: {
                //X-Small
                0: {
                    items: 1
                },
                360: {
                    items: 1
                },
                375: {
                    items: 1
                },
                540: {
                    items: 2
                },
                //Small
                576: {
                    items: 2
                },
                //Medium
                768: {
                    items: 2
                },
                //Large
                992: {
                    items: 2
                },
                //Extra large
                1200: {
                    items: 4
                },
                //Extra extra large
                1400: {
                    items: 4
                }
            }
        })
    </script>
    <script>
        $('#featured_products_list').owlCarousel({
            loop: true,
                autoplay: false,
                margin: 5,
                nav: true,
                navText: ["<i class='czi-arrow-left'></i>", "<i class='czi-arrow-right'></i>"],
                dots: false,
                autoplayHoverPause: true,
                '{{session('direction')}}': false,
                // center: true,
                responsive: {
                    //X-Small
                    0: {
                        items: 1
                    },
                    360: {
                        items: 1
                    },
                    375: {
                        items: 1
                    },
                    540: {
                        items: 2
                    },
                    //Small
                    576: {
                        items: 2
                    },
                    //Medium
                    768: {
                        items: 3
                    },
                    //Large
                    992: {
                        items: 4
                    },
                    //Extra large
                    1200: {
                        items: 5
                    },
                    //Extra extra large
                    1400: {
                        items: 5
                    }
                }
            });
    </script>
    <script>
        $('#brands-slider').owlCarousel({
            loop: false,
            autoplay: false,
            margin: 10,
            nav: false,
            '{{session('direction')}}': true,
            //navText: ["<i class='czi-arrow-left'></i>","<i class='czi-arrow-right'></i>"],
            dots: true,
            autoplayHoverPause: true,
            // center: true,
            responsive: {
                //X-Small
                0: {
                    items: 2
                },
                360: {
                    items: 3
                },
                375: {
                    items: 3
                },
                540: {
                    items: 4
                },
                //Small
                576: {
                    items: 5
                },
                //Medium
                768: {
                    items: 7
                },
                //Large
                992: {
                    items: 9
                },
                //Extra large
                1200: {
                    items: 11
                },
                //Extra extra large
                1400: {
                    items: 12
                }
            }
        })
    </script>

    <script>
        $('#category-slider, #top-seller-slider').owlCarousel({
            loop: false,
            autoplay: false,
            margin: 5,
            nav: false,
            // navText: ["<i class='czi-arrow-left'></i>","<i class='czi-arrow-right'></i>"],
            dots: true,
            autoplayHoverPause: true,
            '{{session('direction')}}': true,
            // center: true,
            responsive: {
                //X-Small
                0: {
                    items: 2
                },
                360: {
                    items: 3
                },
                375: {
                    items: 3
                },
                540: {
                    items: 4
                },
                //Small
                576: {
                    items: 5
                },
                //Medium
                768: {
                    items: 6
                },
                //Large
                992: {
                    items: 8
                },
                //Extra large
                1200: {
                    items: 10
                },
                //Extra extra large
                1400: {
                    items: 11
                }
            }
        })
    </script>
@endpush