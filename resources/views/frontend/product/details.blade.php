@extends('frontend.layouts.app')
@push('after-styles')
    <link rel="stylesheet" href="{!! asset('/assets/frontend/lib/jqZoom/css/jquery.jqZoom.css')!!}" type="text/css"/>
    @endpush
@section('content')
    <?php
    $overallRating = \App\CPU\ProductManager::get_overall_rating($single_product->reviews);
    $rating = \App\CPU\ProductManager::get_rating($single_product->reviews);
    $decimal_point_settings = \App\CPU\Helpers::get_business_settings('decimal_point_settings');
    ?>
    <div class="category-bar-container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="category-bar">
                        @if(count($categories))
                            @foreach($categories as $cat)
                        <div class="category">
                            <img src="{{asset("storage/category/$cat->icon")}}" onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'" style="height: 10%; width: 10%;">
                            <p class="category-title">{!! $cat->name !!}</p>
                        </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-details-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12 col-xl-9">
                    <div class="product-details-card">
                        <div class="breadcrumb-and-social">
                            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item" aria-current="page">{!! $single_product->brand->name ?? ' ' !!}</li>
                                    <li class="breadcrumb-item active" aria-current="page">{!! $single_product->name ?? ' ' !!}</li>
                                </ol>
                            </nav>
                            <ul class="social">
                                <li><a href="#"><img
                                            src="{!! asset('/assets/frontend/img/icons/printer.svg')!!}"
                                            alt="printer-icon"></a></li>
                                <li><a href="#"><img
                                            src="{!! asset('/assets/frontend/img/icons/social/facebook.svg') !!}"
                                            alt="facebook-icon"></a></li>
                                <li><a href="#"><img
                                            src="{!! asset('/assets/frontend/img/icons/social/youtube.svg') !!}"
                                            alt="youtube-icon"></a></li>
                                <li><a href="#"><img
                                            src="{!! asset('/assets/frontend/img/icons/social/whatsapp.svg') !!}"
                                            alt="whatsapp-icon"></a></li>
                                <li><a href="#"><img
                                            src="{!! asset('/assets/frontend/img/icons/social/skype.svg') !!}"
                                            alt="skype-icon"></a></li>
                                <li><a href="#"><img
                                            src="{!! asset('/assets/frontend/img/icons/social/linkedin.svg') !!}"
                                            alt="linkedin-icon"></a></li>
                                <li><a href="#"><img
                                            src="{!! asset('/assets/frontend/img/icons/social/twitter.svg') !!}"
                                            alt="twitter-icon"></a></li>
                            </ul>
                        </div>
                        <div class="product-details">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="product-images">
                                        <div class="thumbnails" id="thumbnails">
                                            @if($single_product->images!=null)
                                                @foreach (json_decode($single_product->images) as $key => $photo)
                                            <img src="{{asset("storage/product/$photo")}}" alt="product-thumb">
                                                @endforeach
                                                @endif
                                        </div>
                                        <div class="preview zoom-box">
                                            <img id="preview-image" src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$single_product['thumbnail']}}" alt="product-image">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="product-description">
                                        <h2>
                                            {!! $single_product->name !!}
                                        </h2>
                                        <p class="product-by">
                                            By <a href="#">{!! $single_product->brand->name ?? ''  !!}</a>
                                            <span class="rating">
                                                @for($inc=0;$inc<$overallRating[0];$inc++)
                                                    <img src="{!! asset('/assets/frontend/img/icons/star.svg') !!}" alt="rating-star">
                                                @endfor
                        </span>
                                        </p>
                                        <div class="features">
                                            <h5>Features</h5>
                                            <table>
                                                <tr>
                                                    <td>Type of product :</td>
                                                    <td>Double mounted air purifier</td>
                                                </tr>
                                                <tr>
                                                    <td>Discharge range:</td>
                                                    <td>0.8lpm</td>
                                                </tr>
                                                <tr>
                                                    <td>Motor type:</td>
                                                    <td>Water filled</td>
                                                </tr>
                                                <tr>
                                                    <td>Voltage:</td>
                                                    <td>180-120 V</td>
                                                </tr>
                                                <tr>
                                                    <td>Frequency:</td>
                                                    <td>50hz</td>
                                                </tr>
                                                <tr>
                                                    <td>Type of product :</td>
                                                    <td>Purifier</td>
                                                </tr>
                                            </table>
                                            <p>
                                                <button class="btn more">More features</button>
                                                <button class="btn wish">Add to Wishlist</button>
                                            </p>
                                            <div class="coupon-banner">
                                                <p class="m-0 px-2">
                                                    Flat Rs.100 Off on Orders Above Rs.2000 <br>
                                                    only on App orders.
                                                </p>
                                                <div>
                            <span>
                              Use<br>Code:<br>
                              <span>APP100</span>
                            </span>
                                                </div>
                                            </div>
                                            <p class="py-2 text-end">
                                                <a href="#">View all Offers</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row tab-row">
                            <ul class="nav nav-tabs justify-content-start" id="product-spec-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="description" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab" aria-controls="category" aria-selected="true">Description</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="specification" data-bs-toggle="tab" data-bs-target="#spec" type="button" role="tab" aria-controls="brand" aria-selected="false">Specification</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="quick-links" data-bs-toggle="tab" data-bs-target="#q-links" type="button" role="tab" aria-controls="searched" aria-selected="false">Quick Links</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="product-spec-tab-contents">
                                <div class="tab-pane fade show active" id="desc" role="tabpanel" aria-labelledby="desc-tab">
                                    {!! $single_product->details !!}
                                </div>
                                <div class="tab-pane fade" id="spec" role="tabpanel" aria-labelledby="spec-tab">
                                    <h5>What is an Air Compressor?</h5>
                                    <p>
                                        An Air Compressor is a pneumatic device used to convert power into potential energy. It fills a large amount of air into its storage tank to pressurise it. The resultant air in the tank is called compressed air. It stays stored in the tank until someone utilises it.
                                        Fulcrum Air compressors with 3 HP Motor Power is a highly-efficient device. Compared to other brands, it is the best in the market and is available at very competitive prices. WIth 2800 RPM rotation speed and 50 Liters tank capacity, It is a top-notch product which will increase your industrial output.
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="q-links" role="tabpanel" aria-labelledby="q-links-tab">
                                    <h5>What is an Air Compressor?</h5>
                                    <p>
                                        An Air Compressor is a pneumatic device used to convert power into potential energy. It fills a large amount of air into its storage tank to pressurise it. The resultant air in the tank is called compressed air. It stays stored in the tank until someone utilises it.
                                        Fulcrum Air compressors with 3 HP Motor Power is a highly-efficient device. Compared to other brands, it is the best in the market and is available at very competitive prices. WIth 2800 RPM rotation speed and 50 Liters tank capacity, It is a top-notch product which will increase your industrial output.
                                    </p>
                                    <p>
                                        Compressors require the correct temperature to operate. Just keep an eye on the temp.
                                        Air receiver tanks should be adequately maintained as there can be draining condensation.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row tab-row">
                            <div class="q-and-a">
                                <h4>QUESTION AND ANSWER</h4>
                                <h5>Q1. Is this item durable?</h5>
                                <p>
                                    Yes, this butterfly rice milling machine from AgriPro is durable and of high quality. It has a wide range of applicability and requires minimal maintenance.
                                </p>
                                <h5>Q2. Is this rice milling machine long-lasting?</h5>
                                <p>
                                    Yes! AgriPro's Butterfly Rice Milling Machine is built robustly with a very long-lasting heavy-duty applicability.
                                </p>
                                <h5>Q3. Is it simple to use this rice milling machine?</h5>
                                <p>
                                    Yes, this product is simple and easy to use, and extremely efficient. Even a beginner without significant experience in operating Agricultural tools can make use of AgriPro 3 HP Butterfly Rice Milling Machine easily.
                                </p>
                            </div>
                        </div>
                        <div class="row tab-row">
                            <div class="rating-and-review">
                                <h5>RATINGS AND REVIEWS</h5>
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-5 text-center">
                                        <p>{!! $overallRating[0] !!} starts out of 5</p>
                                        <p class="rating-stars">
                                            @for($inc=0;$inc<$overallRating[0];$inc++)
                                                <img src="{!! asset('/assets/frontend/img/icons/star.svg') !!}" alt="rating-star">
                                            @endfor

                                        </p>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="rating-bar-wrapper">
                        <span>
                          5 stars
                        </span>
                                            <div class="rating-bar">
                                                <div class="rating" style="width: <?php echo $widthRating = ($rating[0] != 0) ? ($rating[0] / $overallRating[1]) * 100 : (0); ?>%;"></div>
                                            </div>
                                            <span>
                          <?php echo $widthRating = ($rating[0] != 0) ? ($rating[0] / $overallRating[1]) * 100 : (0); ?>%
                        </span>
                                        </div>
                                        <div class="rating-bar-wrapper">
                        <span>
                          4 stars
                        </span>
                                            <div class="rating-bar">
                                                <div class="rating" style="width: <?php echo $widthRating = ($rating[1] != 0) ? ($rating[1] / $overallRating[1]) * 100 : (0); ?>%;"></div>
                                            </div>
                                            <span>
                          <?php echo $widthRating = ($rating[1] != 0) ? ($rating[1] / $overallRating[1]) * 100 : (0); ?>%
                        </span>
                                        </div>
                                        <div class="rating-bar-wrapper">
                        <span>
                          3 stars
                        </span>
                                            <div class="rating-bar">
                                                <div class="rating" style="width: <?php echo $widthRating = ($rating[2] != 0) ? ($rating[2] / $overallRating[1]) * 100 : (0); ?>%;"></div>
                                            </div>
                                            <span>
                          <?php echo $widthRating = ($rating[2] != 0) ? ($rating[2] / $overallRating[1]) * 100 : (0); ?>%
                        </span>
                                        </div>
                                        <div class="rating-bar-wrapper">
                        <span>
                          2 stars
                        </span>
                                            <div class="rating-bar">
                                                <div class="rating" style="width: <?php echo $widthRating = ($rating[3] != 0) ? ($rating[3] / $overallRating[1]) * 100 : (0); ?>%;"></div>
                                            </div>
                                            <span>
                          <?php echo $widthRating = ($rating[3] != 0) ? ($rating[3] / $overallRating[1]) * 100 : (0); ?>%
                        </span>
                                        </div>
                                        <div class="rating-bar-wrapper">
                        <span>
                          1 stars
                        </span>
                                            <div class="rating-bar">
                                                <div class="rating" style="width: <?php echo $widthRating = ($rating[4] != 0) ? ($rating[4] / $overallRating[1]) * 100 : (0); ?>%;"></div>
                                            </div>
                                            <span>
                          <?php echo $widthRating = ($rating[4] != 0) ? ($rating[4] / $overallRating[1]) * 100 : (0); ?>%
                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row tab-row">
                            <div class="reviews">
                                <h5>REVIEWS ({!! count($single_product->reviews) !!})</h5>
                                @if(count($single_product->reviews))
                                        @foreach($single_product->reviews as $productReview)
                                    <div class="review-card">
                                    <div class="user-info-and-date">
                                        <div class="user-info">
                                            <div class="user">
                                                <img style="max-height: 64px;" width="64" onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'"
                                                      src="{{asset("storage/profile")}}/{{(isset($productReview->user)?$productReview->user->image:'')}}"
                                                      alt="{{isset($productReview->user)?$productReview->user->f_name:'not exist'}}" class="avatar" >
                                                <div class="name-and-rating">
                                                    <p>{{isset($productReview->user)?$productReview->user->f_name:'not exist'}}</p>
                                                    <div>
                                                        @for($inc=0;$inc<$productReview->rating;$inc++)
                                                            <img src="{!! asset('/assets/frontend/img/icons/star.svg') !!}" alt="rating-star">
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="user-state-review">
                                                <span class="status-badge">Verified customer</span>
                                                <span class="user-feedback">Happy with delivery</span>
                                            </div>
                                        </div>
                                        <span class="date">
                        8th june 2022
                      </span>
                                    </div>
                                    <div class="user-review">
                                        <p>
                                            {!! $productReview->comment !!}
                                        </p>
                                    </div>
                                </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="row tab-row">
                            <div class="recently-viewed">
                                <h5>RECENTLY VIEWED</h5>
                                <div class="row">
                                    @foreach($relatedProducts as $product)
                                        <div class="col-6 col-md-4 col-lg-3">
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
                            @if(count($relatedProducts) > 0)
                            <div class="related-products">
                                <h5>RELATED PRODUCTS</h5>

                                <div class="row">
                                    @foreach($relatedProducts as $product)
                                        <div class="col-6 col-md-4  col-lg-3">
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
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-3">
                    <div class="pricing-card">
                        <div class="pricing-info">
                            <div class="price">
                                <h3>{{\App\CPU\Helpers::currency_converter(
                        $single_product->unit_price-(\App\CPU\Helpers::get_product_discount($single_product,$single_product->unit_price))
                    )}}</h3> <span>(Including VAT)</span>
                            </div>
                            @if($single_product->discount > 0)

                                <span class="discount-badge">
                    @if ($single_product->discount_type == 'percent')
                                        {{round($single_product->discount,(!empty($decimal_point_settings) ? $decimal_point_settings: 0))}}%
                                    @elseif($single_product->discount_type =='flat')
                                        {{\App\CPU\Helpers::currency_converter($single_product->discount)}}
                                    @endif
                                    OFF
                    </span>
                                </span>

                            @endif

                        </div>
                        <div class="quantity-info">
                            <p>Update Quantity</p>
                            <div class="spinbutton-wrapper">
                                <div class="spinbutton">
                                    <button class="minus">-</button>
                                    <!--                    <span class="val">1</span>-->
                                    <input type="number" class="val" value="1">
                                    <button class="plus">+</button>
                                </div>
                                <label>Minimum order quantity</label>
                            </div>
                        </div>
                        <div class="action-wrapper flex">
                            <button>Generate Quote</button>
                            <button>Request a call back</button>
                        </div>
                        <div class="action-wrapper d-grid gap-2">
                            <a href="#" class="btn btn-brand-secondary">ADD TO CART</a>
                            <a href="#" class="btn btn-brand">BUY NOW</a>
                        </div>
                    </div>
                    <div class="need-help">
                        <h4>Have a question for us?</h4>
                        <p>
                            <img src="{!! asset('/assets/frontend/img/icons/call.svg') !!}" alt="call-icon">
                            <span>
                  Need help? Call on +8801972525821
                </span>
                        </p>
                        <p>
                            <img src="{!! asset('/assets/frontend/img/icons/whatsapp.svg') !!}" alt="whatsapp-icon">
                            <span>
                  Or knock us on whatsapp
                </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
<script src="{!! asset('/assets/frontend/lib/jqZoom/js/jquery.jqZoom.js') !!}"></script>
<script>
    $(document).ready(function () {
        function initZoom() {
            $("#preview-image").jqZoom({
                selectorWidth: 30,
                selectorHeight: 30,
                viewerWidth: 350,
                viewerHeight: 350
            });
        }
        initZoom();
        $("#thumbnails").find('img').on('click', function (){
            $("#preview-image").attr('src', $(this).attr('src'));
            $(".viewer-box img").attr('src', $(this).attr('src'))
        })

        // handles product plus minus spinbutton
        $('.spinbutton-wrapper').find('button').on('click', function() {
            let elem = $(this).closest('.spinbutton').find('.val')[0]
            let elemType = $(this).closest('.spinbutton').find('.val')[0].tagName
            let value = elemType === 'INPUT' ? elem.value : elem.innerText;
            if (elemType === 'INPUT') {
                $(elem).val(Number(value) + ($(this).hasClass('plus') ? 1 : Number(value) === 1 ? 0 : -1))
            }
            if (elemType === 'SPAN') {
                $(elem).text(Number(value) + ($(this).hasClass('plus') ? 1 : Number(value) === 1 ? 0 : -1))
            }
        });
    })
</script>
@endpush
