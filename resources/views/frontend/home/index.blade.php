@extends('frontend.layouts.app')
@section('content')
    <div class="container intro">
        <div class="row">
            <div class="col-3 left-nav-container">
                <nav class="left-nav">
                    <ul>
                        @if(count($categories))
                            @foreach($categories as $cat)
                                <li>
                                    <a href="#" @if ($cat->childes->count() > 0)class="submenu"  @endif>
                                        <img src="{{asset("storage/category/$cat->icon")}}" onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'" style="width: 18px; height: 18px; "> {!! $cat->name !!}
                                        @if ($cat->childes->count() > 0)
                                            <ul class="submenu-items">
                                                @foreach($cat['childes'] as $subCategory)
                                                    <li>{{$subCategory['name']}}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        @endif
                        <li><a href="#" class="more">See More Categories >></a></li>
                    </ul>
                    <div class="special-offers d-flex align-items-end">
                        <a class="d-block w-50 text-center py-2" href="#">
                            <img src="{!! asset('/assets/frontend/img/icons/summer-offer.svg') !!}" class="d-block mx-auto" alt="summer-offer">
                            <span>Summer Offers</span>
                        </a>
                        <a class="d-block w-50 text-center py-2" href="#">
                            <img src="{!! asset('/assets/frontend/img/icons/pay-later.svg') !!}" class="d-block mx-auto" alt="pay-later">
                            <span>Buy Now Pay later</span>
                        </a>
                    </div>
                </nav>
            </div>
            <div class="col-12 col-lg-9">
                <div class="banner-grid">
                    @if(count($banners))
                        <div class="main-banner owl-carousel">
                            @foreach($banners as $key=>$m_banner)
                                <div class="item item-{!! $key+1 !!}" style="background-image: url('{{asset('storage/banner')}}/{{$m_banner['photo']}}');"></div>
                            @endforeach
                        </div>
                    @endif
                    @if(count($sideBanners))
                        @foreach($sideBanners as $key=>$s_banner)
                            <div class="side-banner-one" style="background-image: url('{{asset('storage/banner')}}/{{$s_banner['photo']}}');"></div>
                        @endforeach
                    @endif
                    @isset($bottom_banner['photo'])
                        <div class="bottom-banner" style="background-image: url('{{asset('storage/banner')}}/{{$bottom_banner['photo']}}');"></div>
                    @endif

                </div>
                <p>Hello</p>
                @if(count($featured_products))
                    <div class="featured pages">
                        <h3 class="section-heading">Featured page</h3>
                        <div class="row">
                            @foreach($featured_products  as $product)
                                <div class="col-6 col-lg-3">
                                    <div class="product-card">
                                        <div class="product-card-body">
                                            <img src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}"
                                                 onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'" alt="product-image" class="product-image" >
                                            <h5 class="product-title">{{ Str::limit($product['name'], 23) }}</h5>
                                            <p class="product-brand">By {!! $product->brand->name ?? ''  !!}</p>
                                        </div>
                                        <div class="product-card-footer">
                                            <div class="price-without-offer">
                                                <p> @if($product->discount > 0)
                                                        <strike style="font-size: 12px!important;color: #E96A6A!important;">
                                                            {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                                                        </strike>
                                                    @endif
                                                </p>
                                                @if($product->discount > 0)

                                                    <span>
                    @if ($product->discount_type == 'percent')
                                                            {{round($product->discount,(!empty($decimal_point_settings) ? $decimal_point_settings: 0))}}%
                                                        @elseif($product->discount_type =='flat')
                                                            {{\App\CPU\Helpers::currency_converter($product->discount)}}
                                                        @endif
                                                        {{\App\CPU\translate('off')}}
                    </span>
                                                    </span>

                                                @endif

                                            </div>
                                            <div class="price-with-offer">
                                                <p> {{\App\CPU\Helpers::currency_converter(
                        $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                    )}}</p>
                                                @php
                                                    $discountPrice = $product->unit_price - \App\CPU\Helpers::get_product_discount($product,$product->unit_price);
                                                $savePrice = $product->unit_price - $discountPrice;
                                                @endphp
                                                <span>
                                                    You save {!!  \App\CPU\Helpers::currency_converter($savePrice) !!}

                                                </span>
                                            </div>
                                        </div>
                                        <div class="product-card-hover-content">
                                            <div class="image-peek" style="background-image: url('{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}')">
                                                <span class="fav-icon"></span>
                                            </div>
                                            <div class="product-info">
                                                <a href="{{route('frontend.product_details',$product->slug)}}"> <h5 class="product-title"> {{ Str::limit($product['name'], 23) }}</h5></a>
                                                <p class="product-brand">By {!! $product->brand->name ?? ''  !!}</p>
                                            </div>
                                            <div class="count-and-price">
                                                <div class="spinbutton-wrapper">
                                                    <div class="spinbutton">
                                                        <button class="minus">-</button>
                                                        <span class="val">1</span>
                                                        <!--<input type="number" class="val" value="1">-->
                                                        <button class="plus">+</button>
                                                    </div>
                                                </div>
                                                <div class="price-with-offer">
                                                    <p> {{\App\CPU\Helpers::currency_converter(
                        $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                    )}}</p>
                                                </div>
                                            </div>
                                            <div class="action-wrapper d-grid gap-2">
                                                <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                                <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endif
                <div class="featured categories">
                    <h3 class="section-heading">Featured Categories</h3>
                    <p class="section-subheading">Get your desired product from the featured categories</p>
                    @if(count($home_categories))
                        <div class="row">
                            @foreach($home_categories as $category)
                                <div class="col-6 col-md-2">
                                    <div class="featured-card">
                                        <img src="{{asset("storage/category/$category->icon")}}" alt="category-thumbnail" class="category-thumb">
                                        <p class="category-title">{!! $category->name !!}</p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @endif
                </div>
                @isset($section_banner['photo'])
                    <div class="wide-banner">
                        <img src="{{asset('storage/banner')}}/{{$section_banner['photo']}}" alt="wide-banner" class="img-fluid">
                    </div>
                @endif
                @foreach($home_categories as $category)
                    <div class="featured categories">
                        <div class="section-heading-with-btn">
                            <h3>{!! $category->name ?? ' ' !!}</h3>
                            <button class="btn btn-brand btn-sm text-uppercase">View all</button>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-9">
                                @if(count($category['products']))
                                    <div class="row">
                                        @foreach($category['products']  as $product)
                                            <div class="col-6 col-lg-4">
                                                <div class="product-card">
                                                    <div class="product-card-body">
                                                        <img src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}"
                                                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'" alt="product-image" class="product-image" >
                                                        <h5 class="product-title">{{ Str::limit($product['name'], 23) }}</h5>
                                                        <p class="product-brand">By {!! $product->brand->name ?? ''  !!}</p>
                                                    </div>
                                                    <div class="product-card-footer">
                                                        <div class="price-without-offer">
                                                            <p> @if($product->discount > 0)
                                                                    <strike style="font-size: 12px!important;color: #E96A6A!important;">
                                                                        {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                                                                    </strike>
                                                                @endif
                                                            </p>
                                                            @if($product->discount > 0)

                                                                <span>
                    @if ($product->discount_type == 'percent')
                                                                        {{round($product->discount,(!empty($decimal_point_settings) ? $decimal_point_settings: 0))}}%
                                                                    @elseif($product->discount_type =='flat')
                                                                        {{\App\CPU\Helpers::currency_converter($product->discount)}}
                                                                    @endif
                                                                    {{\App\CPU\translate('off')}}
                    </span>
                                                                </span>

                                                            @endif

                                                        </div>
                                                        <div class="price-with-offer">
                                                            <p> {{\App\CPU\Helpers::currency_converter(
                        $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                    )}}</p>
                                                            @php
                                                                $discountPrice = $product->unit_price - \App\CPU\Helpers::get_product_discount($product,$product->unit_price);
                                                            $savePrice = $product->unit_price - $discountPrice;
                                                            @endphp
                                                            <span>
                                                    You save {!!  \App\CPU\Helpers::currency_converter($savePrice) !!}

                                                </span>
                                                        </div>
                                                    </div>
                                                    <div class="product-card-hover-content">
                                                        <div class="image-peek" style="background-image: url('{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}')">
                                                            <span class="fav-icon"></span>
                                                        </div>
                                                        <div class="product-info">
                                                            <a href="{{route('frontend.product_details',$product->slug)}}"> <h5 class="product-title"> {{ Str::limit($product['name'], 23) }}</h5></a>
                                                            <p class="product-brand">By {!! $product->brand->name ?? ''  !!}</p>
                                                        </div>
                                                        <div class="count-and-price">
                                                            <div class="spinbutton-wrapper">
                                                                <div class="spinbutton">
                                                                    <button class="minus">-</button>
                                                                    <span class="val">1</span>
                                                                    <!--<input type="number" class="val" value="1">-->
                                                                    <button class="plus">+</button>
                                                                </div>
                                                            </div>
                                                            <div class="price-with-offer">
                                                                <p> {{\App\CPU\Helpers::currency_converter(
                        $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                    )}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="action-wrapper d-grid gap-2">
                                                            <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                                            <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            @isset($vertical_banner['photo'])
                                <div class="col-12 col-md-3 vertical-banner">
                                    <img src="{{asset('storage/banner')}}/{{$vertical_banner['photo']}}" alt="vertical-banner" class="img-fluid">
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <div class="container featured brands">
        <div class="row justify-content-end">
            <div class="col-12 col-lg-9">
                <h3 class="section-heading text-uppercase">Shop by brands</h3>
            </div>
            @if(count($brands) > 0)
                <div class="col-12 col-lg-9">
                    <div class="carousel-container">
                        <div class="brand-carousel owl-carousel">
                            @foreach($brands as $brand)
                                <div class="item">
                                    <img
                                        onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{asset("storage/brand/$brand->image")}}"
                                        alt="{{$brand->name}}">
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection