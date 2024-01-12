@extends('layouts.front-end.app')

@section('title', ucfirst($data['data_from']) . ' products')

@push('css_or_js')
    <meta property="og:image" content="{{ asset('storage/company') }}/{{ $web_config['web_logo'] }}" />
    <meta property="og:title" content="Products of {{ $web_config['name'] }} " />
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:description" content="{!! substr($web_config['about']->value, 0, 100) !!}">

    <meta property="twitter:card" content="{{ asset('storage/company') }}/{{ $web_config['web_logo'] }}" />
    <meta property="twitter:title" content="Products of {{ $web_config['name'] }}" />
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value, 0, 100) !!}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&display=swap"
        rel="stylesheet">
    <style>
    
    .nav-tabs .nav-item {
    margin-bottom: -2px!important;
}
        /* range */
        .selector {
            position: relative;
            padding: 20px;
            width: 400px;
            color: #7e7e7e;
        }

        .selector ul {
            position: relative;
            display: block;
            overflow: auto;
            min-width: 138px;
            max-height: 200px;
            background: #fff;
            list-style: none;
            white-space: inherit;
            padding-right: 17px;
            width: calc(100% + 17px)
        }

        .selector li {
            position: relative;
            padding: 3px 20px 3px 25px;
            cursor: pointer
        }

        .selector li:before {
            position: absolute;
            top: 50%;
            left: 0;
            top: 4px;
            display: inline-block;
            margin-right: 9px;
            width: 17px;
            height: 17px;
            background-color: #f4f4f4;
            border: 1px solid #d5d5d5;
            content: ""
        }

        .selector li[data-selected="1"]:before {
            border: 1px solid #d7d7d7;
            background-color: #fff
        }

        .selector li[data-selected="1"]:after {
            position: absolute;
            top: 50%;
            left: 3px;
            top: 11px;
            display: inline-block;
            width: 4px;
            height: 10px;
            border-right: 2px solid;
            border-bottom: 2px solid;
            background: none;
            color: #39c9a9;
            content: "";
            -webkit-transform: rotate(40deg) translateY(-50%);
            transform: rotate(40deg) translateY(-50%)
        }

        .selector li:hover {
            color: #aaa
        }

        .selector li .total {
            position: absolute;
            right: 0;
            color: #d7d7d7
        }

        .selector .price-slider {
            text-align: center;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            position: relative;
            padding-top: 17px
        }

        @media (min-width: 768px) {
            .selector .price-slider {
                padding-top: 8px
            }
        }

        .selector .price-slider:before {
            position: absolute;
            top: 50%;
            left: 0;
            margin-top: 0;
            color: #39c9a9;
            content: attr(data-currency);
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%)
        }

        .selector #slider-range {
            width: 90%;
            margin-bottom: 30px;
            border: none;
            background: #e2f7f2;
            height: 3px;
            margin-left: 8px;
            margin-right: 8px
        }

        @media (min-width: 768px) {
            .selector #slider-range {
                width: 100%
            }
        }

        .selector .ui-slider-handle {
            border-radius: 50%;
            background-color: #39c9a9;
            border: none;
            top: -14px;
            width: 28px;
            height: 28px;
            outline: none
        }

        @media (min-width: 768px) {
            .selector .ui-slider-handle {
                top: -7px;
                width: 16px;
                height: 16px
            }
        }

        .selector .ui-slider-range {
            background-color: #d7d7d7
        }

        .selector .slider-price {
            position: relative;
            display: inline-block;
            padding: 5px 40px;
            width: 40%;
            background-color: #e2f7f2;
            line-height: 28px;
            text-align: center
        }

        .selector .slider-price:before {
            position: absolute;
            top: 50%;
            left: 13px;
            margin-top: 0;
            color: #39c9a9;
            content: attr(data-currency);
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%)
        }

        .selector .show-all {
            position: relative;
            padding-left: 25px;
            color: #39c9a9;
            cursor: pointer;
            line-height: 28px
        }

        .selector .show-all:after,
        .selector .show-all:before {
            content: "";
            position: absolute;
            top: 50%;
            left: 4px;
            margin-top: -1px;
            color: #39c9a9;
            width: 10px;
            border-bottom: 1px solid
        }

        .selector .show-all:after {
            -webkit-transform: rotate(90deg);
            transform: rotate(90deg)
        }

        .selector.open ul {
            max-height: none
        }

        .selector.open .show-all:after {
            display: none
        }


        * {
            -webkit-box-sizing: border-box;
            -ms-box-sizing: border-box;
            box-sizing: border-box;
        }

        /* end range */
        .headerTitle {
            font-size: 26px;
            font-weight: bolder;
            margin-top: 3rem;
        }

        .for-count-value {
            position: absolute;

            {{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}: 0.6875 rem;
            ;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;

            color: black;
            font-size: .75rem;
            font-weight: 500;
            text-align: center;
            line-height: 1.25rem;
        }

        .for-count-value {
            position: absolute;

            {{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}: 0.6875 rem;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 500;
            text-align: center;
            line-height: 1.25rem;
        }

        .for-brand-hover:hover {
            color: {{ $web_config['primary_color'] }};
        }

        .for-hover-lable:hover {
            color: {{ $web_config['primary_color'] }} !important;
        }

        .page-item.active .page-link {
            background-color: {{ $web_config['primary_color'] }} !important;
        }

        .page-item.active>.page-link {
            box-shadow: 0 0 black !important;
        }

        .for-shoting {
            font-weight: 600;
            font-size: 14px;
            padding- {{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}: 9px;
            color: #030303;
        }

        .sidepanel {
            width: 0;
            position: fixed;
            z-index: 6;
            height: 500px;
            top: 0;
            {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}: 0;
            background-color: #ffffff;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 40px;
        }

        .sidepanel a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidepanel a:hover {
            color: #f1f1f1;
        }

        .sidepanel .closebtn {
            position: absolute;
            top: 0;
            {{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}: 25 px;
            font-size: 36px;
        }

        .openbtn {
            font-size: 18px;
            cursor: pointer;
            background-color: transparent !important;
            color: #373f50;
            width: 40%;
            border: none;
        }

        .openbtn:hover {
            background-color: #444;
        }

        .for-display {
            display: block !important;
        }
        
        .getQueryActive{
            color : #e9611e !important;
        }

        @media (max-width: 360px) {
            .openbtn {
                width: 59%;
            }

            .for-shoting-mobile {
                margin- {{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}: 0% !important;
            }

            .for-mobile {

                margin- {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}: 10% !important;
            }

        }

        @media (max-width: 500px) {
            .for-mobile {

                margin- {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}: 27%;
            }

            .openbtn:hover {
                background-color: #fff;
            }

            .for-display {
                display: flex !important;
            }

            .for-tab-display {
                display: none !important;
            }

            .openbtn-tab {
                margin-top: 0 !important;
            }

        }

        @media screen and (min-width: 500px) {
            .openbtn {
                display: none !important;
            }


        }

        @media screen and (min-width: 800px) {


            .for-tab-display {
                display: none !important;
            }

        }

        @media (max-width: 768px) {
            .headerTitle {
                font-size: 23px;

            }

            .openbtn-tab {
                margin-top: 3rem;
                display: inline-block !important;
            }

            .for-tab-display {
                display: inline;
            }
            .product-card .price-with-offer {
                float: initial!important;
                width: 100%;
            }
            .product-card-hover-content .image-peek {
    position: relative;
    background-position: center;
    background-size: cover;
    min-height: 115px!important;
    transition: 2s ease;
}
        }
        
         /*range slider css start*/
        
        .slider {
          height: 5px;
          position: relative;
          background: #ddd;
          border-radius: 5px;
        }
        .slider .progress {
          height: 100%;
          left: 5%;
          right: 20%;
          position: absolute;
          border-radius: 5px;
          background: #F54702;
        }
        .range-input {
          position: relative;
        }
        .range-input input {
          position: absolute;
          width: 100%;
          height: 5px;
          top: -5px;
          background: none;
          pointer-events: none;
          -webkit-appearance: none;
          -moz-appearance: none;
        }
        input[type="range"]::-webkit-slider-thumb {
          height: 17px;
          width: 17px;
          border-radius: 50%;
          background: #F54702;
          pointer-events: auto;
          -webkit-appearance: none;
          box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
        }
        input[type="range"]::-moz-range-thumb {
          height: 17px;
          width: 17px;
          border: none;
          border-radius: 50%;
          background: #F54702;
          pointer-events: auto;
          -moz-appearance: none;
          box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
        }
        .field {
            display: flex;
            margin-top: 15px;
        }
        .input-min {
            max-width: 90px;
            padding: 3px 0px 0px 10px;
        }
        .input-max{
            max-width: 90px;
            margin-left: 6rem;
            padding: 3px 0px 0px 10px;
        }
        
        .col-lg-3{
            padding-right: 5px!important;
            padding-left: 5px!important;
        }
        
        /*range slider css ends*/
        @media screen and (max-width: 768px){
.czi-user-circle {
    margin-top: 1px!important;
}
}
        
    </style>
@endpush

@section('content')
    @php($decimal_point_settings = \App\CPU\Helpers::get_business_settings('decimal_point_settings'))

    <?php
    $category_meta_title='';
    $category_meta_description='';
    
    if(request()->get('data_from')=='category')
    {
        $category = \App\Model\Category::where('id', request()->get('id'))->first();
        if($category){
            $category_name = $category->name;
            $category_id = $category->id;
            $category_meta_title = $category->meta_title;
            $category_meta_description = $category->meta_description;
        }
    }
    ?>
    
    <main class="shop-page">
        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: '&nbsp';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <div class="row text-capitalize">
                                    <span style="font-weight: 600;font-size: 18px;">{{str_replace("_"," ",$data['data_from'])}} {{\App\CPU\translate('products')}} {{ isset($brand_name) ? '('.$brand_name.')' : ''}}</span>
                                </div>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="shop-page">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-3 shop-filter-container">
                        <div class="shop-filter">
                            <h6 class="filter-header">CATEGORIES</h6>
                            {{-- category start --}}
                            
                            <div class="card-header p-1 flex-between">
                                <div>
                                    <label class="for-hover-lable {{ $data['data_from'] == 'search' && $data['id'] == '' ? 'getQueryActive' : ''  }}" style="cursor: pointer"
                                        onclick="location.href='{{ route('products', ['name' => '','id' => '', 'data_from' => 'search', 'page' => 1]) }}'">
                                        All Categories
                                    </label>
                                </div>
                            </div>
                            @php($categories = \App\CPU\CategoryManager::parents())
                            <div class="accordion mt-n1" style="width: 100%;padding: 14px;padding-top: 25px; "
                                id="shop-categories">
                                @foreach ($categories as $category)
                                    <div>
                                        <div class="card-header p-1 flex-between">
                                            <div>
                                                <label class="for-hover-lable {{ $data['data_from'] == 'category' && $data['id'] == $category['id'] ? 'getQueryActive' : ''  }}" style="cursor: pointer"
                                                    onclick="location.href='{{ route('products', ['id' => $category['id'], 'data_from' => 'category', 'page' => 1]) }}'">
                                                    {{ $category['name'] }}
                                                </label>
                                            </div>
                                            <div>
                                                <strong class="pull-right for-brand-hover" style="cursor: pointer"
                                                    onclick="$('#collapse-{{ $category['id'] }}').toggle(400)">
                                                    {{ $category->childes->count() > 0 ? '+' : '' }}
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="card-body {{ Session::get('direction') === 'rtl' ? 'mr-2' : 'ml-2' }}"
                                            id="collapse-{{ $category['id'] }}" style="display: none">
                                            @foreach ($category->childes as $child)
                                                <div class=" for-hover-lable card-header p-1 flex-between">
                                                    <div>
                                                        <label style="cursor: pointer" class="{{ $data['data_from'] == 'category' && $data['id'] == $child['id'] ? 'getQueryActive' : ''  }}"
                                                            onclick="location.href='{{ route('products', ['id' => $child['id'], 'data_from' => 'category', 'page' => 1]) }}'">
                                                            {{ $child['name'] }}
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <strong class="pull-right" style="cursor: pointer"
                                                            onclick="$('#collapse-{{ $child['id'] }}').toggle(400)">
                                                            {{ $child->childes->count() > 0 ? '+' : '' }}
                                                        </strong>
                                                    </div>
                                                </div>
                                                <div class="card-body {{ Session::get('direction') === 'rtl' ? 'mr-2' : 'ml-2' }}"
                                                    id="collapse-{{ $child['id'] }}" style="display: none">
                                                    @foreach ($child->childes as $ch)
                                                        <div class="card-header p-1">
                                                            <label class="for-hover-lable" class="{{ $data['data_from'] == 'category' && $data['id'] == $category['id'] ? 'getQueryActive' : ''  }}" style="cursor: pointer"
                                                                onclick="location.href='{{ route('products', ['id' => $ch['id'], 'data_from' => 'category', 'page' => 1]) }}'">{{ $ch['name'] }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{-- category end --}}
                            <div class="separator"></div>
                            <h6 class="filter-header">
                                PRICE RANGE <span class="light">(TK)</span> <button class="clear-button" onclick="clearInput()">Clear</button>
                            </h6>
                            
                              <div class="slider">
                                <div class="progress"></div>
                              </div>
                              <div class="range-input">
                                <input id="min_price" type="range" class="range-min" min="1000" max="500000" value="1000" step="100" data-toggle="tooltip" title="Minimum Range">
                                <input id="max_price" type="range" class="range-max" min="5000" max="500000" value="410000" step="100" data-toggle="tooltip" title="Maximum Range">
                              </div>
                              
                              <div class="price-input">
                                    <div class="field">
                                      <input type="number" class="input-min" value="1000" data-toggle="tooltip" title="Minimum Amount" readonly>
                                      <input type="number" class="input-max" value="410000" data-toggle="tooltip" title="Maximum Amount" readonly>
                                    </div>
                              </div>
                            
                            
                            
                            <div class="separator"></div>
                            {{-- brands start --}}
                            <h6 class="filter-header">BRANDS</h6>
                            <div class="input-group-overlay input-group-sm"
                                style="width: 100%;padding: 14px;padding-top: 30px; ">
                                <input
                                    style="background: #ffffff;padding: 22px;font-size: 13px;border-radius: 5px !important;{{ Session::get('direction') === 'rtl' ? 'padding-right: 32px;' : '' }}"
                                    placeholder="Search brand"
                                    class="cz-filter-search form-control form-control-sm appended-form-control"
                                    type="text" id="search-brand">
                                <div class="input-group-append-overlay">
                                    <span style="color: #3498db;" class="input-group-text">
                                        <i class="czi-search"></i>
                                    </span>
                                </div>
                            </div>
                            <ul id="lista1" style="max-height: 12rem;width: 100%;padding: 0px 0px 14px 14px;"
                                data-simplebar data-simplebar-auto-hide="false">
                                @foreach (\App\CPU\BrandManager::get_active_brands() as $brand)
                                    <div class="brand mt-2 for-brand-hover {{ Session::get('direction') === 'rtl' ? 'mr-2' : '' }}"
                                        >
                                        <li style="cursor: pointer;padding: 2px;padding-right:15px;" class="flex-between {{ $data['data_from'] == 'brand' && $data['id'] == $brand['id'] ? 'getQueryActive' : ''  }}"
                                            onclick="location.href='{{ route('products', ['id' => $brand['id'], 'data_from' => 'brand', 'page' => 1]) }}'">
                                            <div>
                                                {{ $brand['name'] }}
                                            </div>
                                            @if ($brand['brand_products_count'] > 0)
                                                <div
                                                    style="background: #F3F5F9;
                                border-radius: 10px;padding: 2px 7px 2px;color:#212629;font-weight: 400;font-size: 12px;">
                                                    <span class="">
                                                        {{ $brand['brand_products_count'] }}
                                                    </span>
                                                </div>
                                            @endif
                                        </li>
                                    </div>
                                @endforeach
                            </ul>
                            {{-- brands end --}}
                            <div class="separator"></div>
                            <div style="display: none;">
                            
                            <h6 class="filter-header">DISCOUNT</h6>
                            <label for="discount-search">
                                <input type="text" id="discount-search" placeholder="Search by discounts">
                            </label>
                            <div class="checkbox-wrapper">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="discount-1">
                                    <label class="form-check-label" for="discount-1">
                                        Upto 10% (14)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="discount-2">
                                    <label class="form-check-label" for="discount-2">
                                        10% - 20% (9)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="discount-3">
                                    <label class="form-check-label" for="discount-3">
                                        20 % - 30% (10)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="discount-4">
                                    <label class="form-check-label" for="discount-4">
                                        30% - 40% (14)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="discount-5">
                                    <label class="form-check-label" for="discount-5">
                                        40% - 50% (8)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="discount-6">
                                    <label class="form-check-label" for="discount-6">
                                        50% - 60% (8)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="discount-7">
                                    <label class="form-check-label" for="discount-7">
                                        70% - 80% (8)
                                    </label>
                                </div>
                            </div>
                            <div class="separator"></div>
                            <h6 class="filter-header">OFFERS</h6>
                            <div class="checkbox-wrapper">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="offer-1">
                                    <label class="form-check-label" for="offer-1">
                                        Clearance Sale (1)
                                    </label>
                                </div>
                            </div>
                            <div class="separator"></div>
                            <h6 class="filter-header">AVAILABILITY</h6>
                            <div class="checkbox-wrapper">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="availability-1">
                                    <label class="form-check-label" for="availability-1">
                                        Exclude Out of Stock (369)
                                    </label>
                                </div>
                            </div>
                            <div class="separator"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-9 left-bordered-content">
                        <div class="product-list-wrapper">
                            <div class="searched-item">
                            </div>
                            <div class="minimal-filter" style="display: none;">
                                <label for="search-within-results">
                                    <input type="text" placeholder="Search within these results"
                                        id="search-within-results">
                                </label>
                                <div class="form-check-wrapper">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Clearance Sale Products
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <div class="product-list">

                            </div>
                        </div>

                        <br>
                        <section class="col-lg-12">
                            <div class="row" style="background: white;margin:0px;border-radius:5px;">
                                <div class="col-md-6 d-flex  align-items-center">
                                    <h1 class="{{ Session::get('direction') === 'rtl' ? 'mr-3' : 'ml-3' }}">
                                        <label id="price-filter-count"> {{ $products->total() }}
                                            {{ \App\CPU\translate('items found') }} </label>
                                    </h1>
                                </div>
                                <div class="col-md-6 m-2 m-md-0 d-flex  align-items-center ">

                                    <button
                                        class="openbtn text-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}"
                                        onclick="openNav()">
                                        <div>
                                            <i class="fa fa-filter"></i>
                                            {{ \App\CPU\translate('filter') }}
                                        </div>
                                    </button>

                                    <div class="" style="width: 100%">
                                        <form id="search-form" action="{{ route('products') }}" method="GET">
                                            <input hidden name="data_from" value="{{ $data['data_from'] }}">
                                            <div
                                                class=" {{ Session::get('direction') === 'rtl' ? 'ml-2 float-left' : 'mr-2 float-right' }}">
                                                <label
                                                    class=" {{ Session::get('direction') === 'rtl' ? 'ml-1' : 'mr-1' }} for-shoting"
                                                    for="sorting">
                                                    <span
                                                        class="{{ Session::get('direction') === 'rtl' ? 'ml-2' : 'mr-2' }}">{{ \App\CPU\translate('sort_by') }}</span></label>
                                                <select
                                                    style="background: white; appearance: auto;border-radius: 5px;border: 1px solid rgba(27, 127, 237, 0.5);padding:5px;"
                                                    onchange="filter(this.value)">
                                                    <option value="latest">{{ \App\CPU\translate('Latest') }}</option>
                                                    <option value="low-high">{{ \App\CPU\translate('Low_to_High') }}
                                                        {{ \App\CPU\translate('Price') }} </option>
                                                    <option value="high-low">{{ \App\CPU\translate('High_to_Low') }}
                                                        {{ \App\CPU\translate('Price') }}</option>
                                                    <option value="a-z">{{ \App\CPU\translate('A_to_Z') }}
                                                        {{ \App\CPU\translate('Order') }}</option>
                                                    <option value="z-a">{{ \App\CPU\translate('Z_to_A') }}
                                                        {{ \App\CPU\translate('Order') }}</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- </div> --}}
                            @if (count($products) > 0)
                                <div class="row mt-3" id="ajax-products">
                                    @include('web-views.products._ajax-products', [
                                        'products' => $products,
                                        'decimal_point_settings' => $decimal_point_settings,
                                    ])
                                </div>
                            @else
                                <div class="text-center pt-5">
                                    <h2>{{ \App\CPU\translate('No Product Found') }}</h2>
                                </div>
                            @endif
                        </section>
                        <div class="shop-footer">
                            <div class="row">
                                <div class="col-12">
                                    <h5>{{$category_meta_title}}
                                    </h5>
                                    <p>
                                        {{$category_meta_description}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        </div>
    </main>
@endsection

@if(auth('customer')->check())
  
@endif

@push('script')
    <script>
        function openNav() {
            document.getElementById("mySidepanel").style.width = "70%";
            document.getElementById("mySidepanel").style.height = "100vh";
        }

        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }

        function filter(value) {
            $.get({
                url: '{{ url('/') }}/products',
                data: {
                    id: '{{ $data['id'] }}',
                    name: '{{ $data['name'] }}',
                    data_from: '{{ $data['data_from'] }}',
                    min_price: '{{ $data['min_price'] }}',
                    max_price: '{{ $data['max_price'] }}',
                    sort_by: value
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(response) {
                    $('#ajax-products').html(response.view);
                },
                complete: function() {
                    $('#loading').hide();
                },
            });
        }
        function clearInput(){
            location.reload();
           }
        function searchByPrice() {
            let min = $('#min_price').val();
            let max = $('#max_price').val();
            $.get({
                url: '{{ url('/') }}/products',
                data: {
                    id: '{{ $data['id'] }}',
                    name: '{{ $data['name'] }}',
                    data_from: '{{ $data['data_from'] }}',
                    sort_by: '{{ $data['sort_by'] }}',
                    min_price: min,
                    max_price: max,
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(response) {
                    $('#ajax-products').html(response.view);
                    $('#paginator-ajax').html(response.paginator);
                    $('#price-filter-count').text(response.total_product +
                        ' {{ \App\CPU\translate('items found') }}')
                },
                complete: function() {
                    $('#loading').hide();
                },
            });
        }

        $('#searchByFilterValue, #searchByFilterValue-m').change(function() {
            var url = $(this).val();
            if (url) {
                window.location = url;
            }
            return false;
        });

        $("#search-brand").on("keyup", function() {
            var value = this.value.toLowerCase().trim();
            $("#lista1 div>li").show().filter(function() {
                return $(this).text().toLowerCase().trim().indexOf(value) == -1;
            }).hide();
        });
        
        // range slider js start
        const rangeInput = document.querySelectorAll(".range-input input"),
          priceInput = document.querySelectorAll(".price-input input"),
          range = document.querySelector(".slider .progress");
        let priceGap = 1000;
        
        priceInput.forEach((input) => {
          input.addEventListener("input", (e) => {
            let minPrice = parseInt(priceInput[0].value),
              maxPrice = parseInt(priceInput[1].value);
        
            if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
              if (e.target.className === "input-min") {
                rangeInput[0].value = minPrice;
                range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
              } else {
                rangeInput[1].value = maxPrice;
                range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
              }
            }
            
          });
        });
        
        rangeInput.forEach((input) => {
          input.addEventListener("input", (e) => {
            let minVal = parseInt(rangeInput[0].value),
              maxVal = parseInt(rangeInput[1].value);
        
            if (maxVal - minVal < priceGap) {
              if (e.target.className === "range-min") {
                rangeInput[0].value = maxVal - priceGap;
              } else {
                rangeInput[1].value = minVal + priceGap;
              }
            } else {
              priceInput[0].value = minVal;
              priceInput[1].value = maxVal;
              range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
              range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
            }
          });
          $('#min_price').on('input', searchByPrice);
            $('#max_price').on('input', searchByPrice);
        });
        // range slider js ends
        
        

      // change category dropdown values
      $('#category-dropdown').find('a').on('click', function(e) {
        e.preventDefault();
        const categoryId = $(this).data('id');
        const categoryLabel = $(this).text();
        $('#form-category').val(categoryId);
        $('#selected-dropdown-category').text(categoryLabel);
      });
      
      $('.accordion.mt-n1').animate({ scrollTop: $(".for-hover-lable.getQueryActive").offset().top - $(".for-hover-lable.getQueryActive").offsetParent().offset().top}, 800, 'swing')
      $(window).load(function(){
      
      $('.simplebar-content').animate({ scrollTop: $(".flex-between.getQueryActive").offset().top - $(".flex-between.getQueryActive").offsetParent().offset().top}, 800, 'swing')
      })
      
      
    </script>
@endpush