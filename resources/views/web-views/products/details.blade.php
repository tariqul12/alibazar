@extends('layouts.front-end.app')
@section('title',$single_product['name'])
@push('css_or_js')
    <meta name="description" content="{{$single_product->slug}}">
    <meta name="keywords" content="@foreach(explode(' ',$single_product['name']) as $keyword) {{$keyword.' , '}} @endforeach">
    @if($single_product->added_by=='admin')
        <meta name="author" content="{{$web_config['name']->value}}">
    @endif
    <!-- Viewport-->

    @if($single_product['meta_image']!=null)
        <meta property="og:image" content="{{asset("storage/product/meta")}}/{{$single_product->meta_image}}"/>
        <meta property="twitter:card"
              content="{{asset("storage/product/meta")}}/{{$single_product->meta_image}}"/>
    @else
        <meta property="og:image" content="{{asset("storage/product/thumbnail")}}/{{$single_product->thumbnail}}"/>
        <meta property="twitter:card"
              content="{{asset("storage/product/thumbnail/")}}/{{$single_product->thumbnail}}"/>
    @endif

    @if($single_product['meta_title']!=null)
        <meta property="og:title" content="{{$single_product->meta_title}}"/>
        <meta property="twitter:title" content="{{$single_product->meta_title}}"/>
    @else
        <meta property="og:title" content="{{$single_product->name}}"/>
        <meta property="twitter:title" content="{{$single_product->name}}"/>
    @endif
    <meta property="og:url" content="{{route('frontend.product_details',[$single_product->slug])}}">

    @if($single_product['meta_description']!=null)
        <meta property="twitter:description" content="{!! $single_product['meta_description'] !!}">
        <meta property="og:description" content="{!! $single_product['meta_description'] !!}">
    @else
        <meta property="og:description"
              content="@foreach(explode(' ',$single_product['name']) as $keyword) {{$keyword.' , '}} @endforeach">
        <meta property="twitter:description"
              content="@foreach(explode(' ',$single_product['name']) as $keyword) {{$keyword.' , '}} @endforeach">
    @endif
    <meta property="twitter:url" content="{{route('frontend.product_details',[$single_product->slug])}}">
<link rel="stylesheet" href="{!! asset('/assets/frontend/lib/jqZoom/css/jquery.jqZoom.css')!!}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('/assets/front-end/css/product-details.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/front-end')}}/css/home.css"/>
    <link rel="stylesheet" href="{{asset('/assets/front-end')}}/css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="{{asset('/assets/front-end')}}/css/owl.theme.default.min.css"/>
    {{-- video --}}
        <style>
            .bs-example {
                margin: 20px;
            }
             
            .modal-content iframe {
                margin: 0 auto;
                display: block;
            }
        </style>
        <script>
            $(document).ready(function() {
                var url = $("#Geeks3").attr('src');
                $("#Geeks2").on('hide.bs.modal', function() {
                    $("#Geeks3").attr('src', '');
                });
                $("#Geeks2").on('show.bs.modal', function() {
                    $("#Geeks3").attr('src', url);
                });
            });
        </script>
    {{-- end --}}
   <style>
        .msg-option {
            display: none;
        }

        .chatInputBox {
            width: 100%;
        }

        .go-to-chatbox {
            width: 100%;
            text-align: center;
            padding: 5px 0px;
            display: none;
        }

        .feature_header {
            display: flex;
            justify-content: center;
        }

        .btn-number:hover {
            color: {{$web_config['secondary_color']}};

        }

        .for-total-price {
            margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: -30%;
        }

        .feature_header span {
            padding- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 15px;
            font-weight: 700;
            font-size: 25px;
            background-color: #ffffff;
            text-transform: uppercase;
        }

        .flash-deals-background-image{
            background: {{$web_config['primary_color']}}10;
            border-radius:5px;
            width:125px;
            height:125px;
        }
        .owl-nav{
            top: 40%;
            position: absolute;
            display: flex;
            justify-content: space-between;
            
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

        @media (max-width: 768px) {
            .feature_header span {
                margin-bottom: -40px;
            }

            .for-total-price {
                padding- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 30%;
            }

            .product-quantity {
                padding- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 4%;
            }

            .for-margin-bnt-mobile {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 7px;
            }

            .font-for-tab {
                font-size: 11px !important;
            }

            .pro {
                font-size: 13px;
            }
        }

        @media (max-width: 375px) {
            .for-margin-bnt-mobile {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 3px;
            }

            .for-discount {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10% !important;
            }

            .for-dicount-div {
                margin-top: -5%;
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: -7%;
            }

            .product-quantity {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 4%;
            }

        }

        @media (max-width: 500px) {
            .for-dicount-div {
                margin-top: -4%;
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: -5%;
            }

            .for-total-price {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: -20%;
            }

            .view-btn-div {

                margin-top: -9%;
                float: {{Session::get('direction') === "rtl" ? 'left' : 'right'}};
            }

            .for-discount {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 7%;
            }

            .viw-btn-a {
                font-size: 10px;
                font-weight: 600;
            }

            .feature_header span {
                margin-bottom: -7px;
            }

            .for-mobile-capacity {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 7%;
            }
        }
        
        .features{
            padding-right: 15px;
        }
        .features table p{
            margin-bottom: 0px !important;
            font-size: 12px !important;
        }
        
        #buzz table, #discription table, #quicklinks table {
            width: 100% !important;
        }
        
        #buzz table td, #discription table td, #quicklinks table td {
            border: 1px solid #ddd;
        }
        
        #buzz img, #discription img, #quicklinks img {
            height: 300px !important;
            width: 300px !important;
            padding: 5px;
        }
    </style>
    <style>
        th, td {
            padding: 5px;
        }

        thead {
            background: {{$web_config['primary_color']}} !important;
            color: white;
        }
        .product-details-shipping-details{
            background: #ffffff;
            border-radius: 5px;
            font-size: 14;
            font-weight: 400;
            color: #212629;
        }
        .shipping-details-bottom-border{
            border-bottom: 1px #F9F9F9 solid;
        }
    </style>

@endpush
@section('content')
<?php
   $overallRating = \App\CPU\ProductManager::get_overall_rating($single_product->reviews);
   $rating = \App\CPU\ProductManager::get_rating($single_product->reviews);
   $decimal_point_settings = \App\CPU\Helpers::get_business_settings('decimal_point_settings');
   ?>
   
   <style>
       .product-details{
           max-width:100%!important;
       }
       
       .d-tab{
           color:#000!important;
       }
       .d-tab-cont{
    padding: 25px 15px;
}
.d-tabs{
    border: 1px solid #CDCDCD;
    background-color: #f3f1f1;
}

.tab-sec{
    border-bottom: 1px solid #E1E1E1;
}

.details-tab{
    border-bottom: 1px solid #E1E1E1;
}

.btn.btn-brand-secondary {
    background-color: #418E56;
    color: #fff!important;
    border-radius: 0;
    width: 100%;
    margin-bottom: 10px;
}

.heading {
  font-size: 25px;
  margin-right: 25px;
}

.fa {
  font-size: 25px;
}

.checked {
  color: orange;
}

/* Three column layout */
.side {
  float: left;
  width: 15%;
  margin-top:10px;
}

.middle {
  margin-top:10px;
  float: left;
  width: 70%;
}

/* Place text to the right */
.right {
  text-align: right;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* The bar container */
.bar-container {
  width: 100%;
  background-color: #f1f1f1;
  text-align: center;
  color: white;
}

/* Individual bars */
.bar-5 {width: 60%; height: 18px; background-color: #04AA6D;}
.bar-4 {width: 30%; height: 18px; background-color: #2196F3;}
.bar-3 {width: 10%; height: 18px; background-color: #00bcd4;}
.bar-2 {width: 4%; height: 18px; background-color: #ff9800;}
.bar-1 {width: 15%; height: 18px; background-color: #f44336;}

/* Responsive layout - make the columns stack on top of each other instead of next to each other */
@media (max-width: 400px) {
  .side, .middle {
    width: 100%;
  }
  .right {
    display: none;
  }
}

.d-tare{
    margin:30px 20px;
}
.d-star{
    margin:30px 20px;
}
.product-title{
    font-size:15px!important;
}

.d-tabs {
    border: none;
}

.d-tabs li{
    border: 1px solid #E1E1E1;
}
.d-tabs li:first-child{
    border-right:none;
}
.d-tabs li:nth-child(2){
    border-right:none;
}

.footer-contact .footer-contact-card {
    display: flex;
    align-items: center;
}
p.product-by {
    font-size: 16px;
    line-height: 24px;
    font-weight: 500;
    color: #676868;
}
.breadcrumb-item + .breadcrumb-item::before {
    display: inline-block;
    padding-right: 0.425rem;
    color: rgb(166, 172, 183);
    content: "";
}
.bredcum_font_arrow {
    position: relative;
    top: 3px;
    left: 8px;
    font-size: 12px;
}

.carousel-control-prev, .carousel-control-next {
    
    width: 0%!important;
}

   </style>
 <?php
  use Illuminate\Support\Facades\DB;
   $wholesalePrices=DB::table('wholesale_prices')
                        ->where('product_stock_id',$single_product->id)
                        ->get();
    $emi_banks=DB::table('banks')
                ->where('banks.status',1)
                ->get();
    $json_attr=$single_product->choice_options;
    $choice_data=json_decode($json_attr);
    $model_option=[];
    $size_option=[];
    foreach($choice_data as $row)
    {
        if($row->title=='Model')
        {
            $model_option=$row->options;
        }
        if($row->title=='Size')
        {
            $size_option=$row->options;
        }
    }
    foreach($model_option as $data)
    {
        $model_val[]=$data;
    }
    foreach($size_option as $size_data)
    {
        $size_val[]=$size_data;
    }
    $sold_out=0;
    if (($single_product->product_type== 'physical') && ($single_product->current_stock ==0)) {
                $sold_out=1;
            }
    ?>  
<div class="category-bar-container">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <div class="category-bar">
               @if(count($categories))
               @foreach($categories as $cat)
               <div class="category">
                   <div class="category-img">
                       <a href="{{route('products',['id'=> $cat->id,'data_from'=>'category','page'=>1])}}"><img src="{{asset("storage/category/$cat->icon")}}" onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'"></a>
                   </div>
                  
                  <p class="category-title">
                      <a href="{{route('products',['id'=> $cat->id,'data_from'=>'category','page'=>1])}}">
                    <?php if (strlen($cat->name) > 10) 
                            {  
                                echo substr($cat->name, 0, 10) . "...";
                            }
                            else 
                            { 
                                echo $cat->name;
                            } 
                           ?>
                    </a>
                    </p>
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
             
             <div class="j-details-sticky" style="display: none;">
                 <div class="j-details-logo">
                     
                     <img src="{{asset("storage/product/thumbnail/$single_product->thumbnail")}}"  alt="Product image" >
                     
                 </div>
                 <div class="j-details-title">
                     <h2> {!! $single_product->name !!}</h2>
                     <p class="product-by">
                          By <a href="{{route('products',['id'=> $single_product->brand_id,'data_from'=>'brand','page'=>1])}}">{!! $single_product->brand->name ?? ''  !!}</a>
                          <span class="rating">
                          @for($inc=0;$inc<$overallRating[0];$inc++)
                          <img src="{!! asset('/assets/frontend/img/icons/star.svg') !!}" alt="rating-star">
                          @endfor
                          </span>
                       </p>
                 </div>
                 <div class="j-details-decs">
                     <ul>
                         <li><a href="javascript:void(0)" onclick="activeTab('buzz')"><i class="fa-solid fa-caret-right"></i> Product Specifications</a></li>
                         <li><a href="javascript:void(0)" onclick="activeTab('discription')"><i class="fa-solid fa-caret-right"></i> Description</a></li>
                         <li><a href="javascript:void(0)" onclick="activeTab('quicklinks')"><i class="fa-solid fa-caret-right"></i> Quick Links</a></li>
                     </ul>
                 </div>
             </div>
             
            <div class="product-details-card">
                <div class="j-padding">
               <div class="breadcrumb-and-social">
                  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a><i class="fa fa-angle-right bredcum_font_arrow"></i></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('products',['id'=> $product_category_id,'data_from'=>'category','page'=>1])}}">{!! $product_category_name ?? ' ' !!}</a> <i class="fa fa-angle-right bredcum_font_arrow"></i></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($single_product->name,30)}}</li>
                     </ol>
                  </nav>
                  <ul class="social">
                      
                     <li><a target="_blank" href="{{route('frontend.product_print',$single_product->slug)}}"><img
                        src="{!! asset('/assets/frontend/img/icons/printer.svg')!!}"
                        alt="printer-icon" ></a></li>
                     <li><a href="https://facebook.com/sharer/sharer.php?u={{url()->current()}}"><img
                        src="{!! asset('/assets/frontend/img/icons/social/facebook.svg') !!}"
                        alt="facebook-icon" target="_blank"></a></li>
                     <!--<li><a href="#"><img-->
                     <!--   src="{!! asset('public/assets/frontend/img/icons/social/skype.svg') !!}"-->
                     <!--   alt="skype-icon"></a></li>-->
                     <li><a href="https://twitter.com/share?url={{url()->current()}}"><img
                        src="{!! asset('/assets/frontend/img/icons/social/twitter.svg') !!}"
                        alt="twitter-icon" target="_blank"></a></li>
                     <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{url()->current()}}"><img
                        src="{!! asset('/assets/frontend/img/icons/social/linkedin.svg') !!}"
                        alt="linkedin-icon" target="_blank"></a></li>

                     <li><a href="https://wa.me/?text={{url()->current()}}"><img
                        src="{!! asset('/assets/frontend/img/icons/social/whatsapp.svg') !!}"
                        alt="whatsapp-icon" target="_blank"></a></li>
                  </ul>
               </div>
               </div>
               <div class="product-details" id="printDiv">
                  <div class="row">
                     <div class="col-xl-6 col-12 ">
                         <div class="j-padding">
                    <div class="cz-product-gallery ">
                            <div class="cz-preview">
                                @if($single_product->images!=null)
                                    @foreach (json_decode($single_product->images) as $key => $photo)
                                        @php
                                        $getImgDetails = \App\CPU\Helpers::getImageMetaInfo($photo) ?? '';
                                        @endphp
                                        <div
                                            class="cz-preview-item d-flex align-items-center justify-content-center {{$key==0?'active':''}}"
                                            id="image{{$key}}">
                                            <img class="cz-image-zoom img-responsive" style="width:100%;max-height:443px;"
                                                onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'"
                                                src="{{asset("storage/product/$photo")}}"
                                                data-zoom="{{asset("storage/product/$photo")}}"
                                                alt="{{ $getImgDetails->img_alt_tag ?? $single_product->name  }}" title="{{ $getImgDetails->img_title ?? $single_product->name  }}" width="">
                                            <div class="cz-image-zoom-pane"></div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                      
                      
                            <div class="cz">
                                <div>
                                    <div class="row">
                                        <div class="table-responsive" data-simplebar style="max-height: 515px; padding: 1px;">
                                            <div class="d-flex" style="padding-left: 3px;">
                                                @if($single_product->images!=null)
                                                    @foreach (json_decode($single_product->images) as $key => $photo)
                                                        @php
                                                        $getImgDetails = \App\CPU\Helpers::getImageMetaInfo($photo) ?? '';
                                                        @endphp
                                                        <div class="cz-thumblist">
                                                            <a class="cz-thumblist-item  {{$key==0?'active':''}} d-flex align-items-center justify-content-center "
                                                            href="#image{{$key}}">
                                                                <img
                                                                    onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'"
                                                                    src="{{asset("storage/product/$photo")}}"
                                                                    alt="{{ $getImgDetails->img_alt_tag ?? $single_product->name  }}" title="{{ $getImgDetails->img_title ?? $single_product->name  }}">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                @if ($single_product->video_url!=null)
                                                <div class="bs-example">
                                                    <a href="#Geeks2" data-toggle="modal">
                                                       <img src="{{asset("storage/product/$photo")}}" alt="image">
                                                       <i class="fa-solid fa-play"></i>
                                                    </a>
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
                     <div class="col-xl-6 col-12">
                        <div class="product-description">
                           <h1>
                              {!! $single_product->name !!}
                           </h1>
                           <p class="product-by">
                              By <a href="{{route('products',['id'=> $single_product->brand_id,'data_from'=>'brand','page'=>1])}}">{!! $single_product->brand->name ?? ''  !!}</a>
                              <span class="rating">
                              @for($inc=0;$inc<$overallRating[0];$inc++)
                              <img src="{!! asset('/assets/frontend/img/icons/star.svg') !!}" alt="rating-star">
                              @endfor
                              </span>
                           </p>
                           <p>Product SKU #{!! $single_product->code !!}</p>
                           <div class="features">
                              @if(!empty($single_product->features))
                              <h5>Features</h5>
                              {!! $single_product->features !!}
                              @endif
                              <p class="d-more"><a href="javascript:void(0)" onclick="activeTab('buzz')"><strong>Details Specification</strong></a></p>
                              @if (!empty($size_val))
                              <div class="j-model">
                                <p>Size:</p>
                                @foreach ($size_val as $row)
                                <a href="">{{$row}}</a>
                                @endforeach
                                
                            </div>
                              @endif
                              
                              @if (!empty($model_val))
                                <div class="j-model">
                                    <p>Model:</p>
                                    <ul class="list-inline checkbox-color mb-1 flex-start ml-2" style="padding-left: 0;">
                                       @php
                                            $i=0;
                                        @endphp
                                        @foreach ($model_val as $key=>$row)
                                      <li>
                                        <input type="radio" id="model_value_{{$i}}" name="model_value" value="{{$row}}" onclick="modelValueChange('{{$i}}','{{trim($row)}}','{{$single_product->id}}')" <?php if($model_val[0]==$row){echo "checked";}?> />
                                        <label for="model_value_{{$i}}" class="model-check">{{$row}}</label>
                                       </li>
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach
                                    </ul>
                                </div>
                              @endif
                             
                              <p>
                                 <button class="btn more" onclick="addWishlist({{ $single_product->id }})">Add to Wishlist</button>
                                 <button class="compare" onclick="addToCompare({{ $single_product->id }})">Compare</button>
                              </p>
                              @if($single_product->loyalty_point > 0)
                              <div class="coupon-banner">
                                 <p class="m-0 px-2">
                                   If you purchase this product you will earn <span><i class="fa-solid fa-coins"></i> {{\App\CPU\Convert::default($single_product->loyalty_point)}} Points</span> worth of Tk. {{($single_product->loyalty_point/2)}}!</br> Which Can Be Reedem on your Next Order
                                 </p>
                                 
                              </div>
                              @endif
                              {{-- whole sale product details --}}
                            @if(count($wholesalePrices) > 0)
                                <table class="table mb-3">
                                    <thead style="background: #0e2f560d !important;text-align: center;">
                                        <tr >
                                            <th class="border-top-0">{{ \App\CPU\translate('Min Qty') }}</th>
                                            <th class="border-top-0">{{ \App\CPU\translate('Max Qty') }}</th>
                                            <th class="border-top-0">{{ \App\CPU\translate('Unit Price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center;">
                                        @foreach ($wholesalePrices as $wholesalePrice)
                                            <tr>
                                                <td>{{ $wholesalePrice->min_qty }}</td>
                                                <td>{{ $wholesalePrice->max_qty }}</td>
                                                <td>{{ $wholesalePrice->price }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               
               
                <script>
                    $(document).ready(function () {
                    
                    $("#thumbnails").find('img').on('click', function (){
                        $("#preview-image").attr('src', $(this).attr('src'));
                        $(".viewer-box img").attr('src', $(this).attr('src'))
                    })

                    })
                </script>
  
  <div class="j-specification">
        <div class="container">
            <div class="row">
                <div class="col-4 col-sm-6 col-md-2">
                    <div class="j-specification-card">
                        <img src="{{asset('/assets/front-end/img/warIcon_new.webp')}}" alt="icon-telephone">
                        <div class="j-spect-cont">
                            <h5>WARRANTY</h5>
                            <p>As per Policy</p>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-sm-6 col-md-2">
                    <div class="j-specification-card">
                        <img src="{{asset('/assets/front-end/img/orgIcon_new.webp')}}" alt="icon-telephone">
                        <div class="j-spect-cont">
                            <h5>100% ORIGINAL</h5>
                            <p>Products</p>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-sm-6 col-md-2">
                    <div class="j-specification-card">
                        <img src="{{asset('/assets/front-end/img/proIcon_new.webp')}}" alt="icon-telephone">
                        <div class="j-spect-cont">
                            <h5>SECURE</h5>
                            <p>Payments</p>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-sm-6 col-md-2">
                    <div class="j-specification-card">
                        <img src="{{asset('/assets/front-end/img/secureIcon_new.webp')}}" alt="icon-telephone">
                        <div class="j-spect-cont">
                            <h5>100% BUYER</h5>
                            <p>Protection</p>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-sm-6 col-md-2">
                    <div class="j-specification-card">
                        <img src="{{asset('/assets/front-end/img/ibreward-icon-header.webp')}}" alt="icon-telephone">
                        <div class="j-spect-cont">
                            <h5>EARN</h5>
                            <p>Reward Points</p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
  
  
               <div class="row">
                   <div class="col-xl-12">
                       <div class="details-tab" id="details_tab_section">
                           <div class="tab-sec">
                                <ul class="nav nav-tabs d-tabs" role="tablist">
                                    <li class="nav-item">
                                    <a class="d-tab active" href="#buzz" role="tab" data-toggle="tab">Specification</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="d-tab " href="#discription" role="tab" data-toggle="tab">Description</a>
                                  </li>
                                  
                                  <li class="nav-item">
                                    <a class="d-tab" href="#quicklinks" role="tab" data-toggle="tab">Quick Links</a>
                                  </li>
                                </ul>
                            </div>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active show" id="buzz">
                                  <div class="d-tab-cont">
                                    {!! $single_product->specifications !!}
                                  </div>
                              </div>
                              
                              <div role="tabpanel" class="tab-pane fade " id="discription">
                                  <div class="d-tab-cont">
                                    {!! $single_product->details !!}
                                  </div>
                              </div>
                              
                              <div role="tabpanel" class="tab-pane fade" id="quicklinks">
                                  <div class="d-tab-cont">
                                    {!! $single_product->quick_links !!}
                                  </div>
                              </div>
                            </div>
                       </div>
                   </div>
               </div>
               
               <div class="container">
                   <div class="row tab-row">
                       <div class="col-xl-12">
                          <div class="q-and-a">
                             <h4>QUESTION AND ANSWER</h4>
                             @if(!empty($product_questions))
                             @foreach($product_questions as $key => $question)
                             <h5>Q{{$key+1}}. {{$question->question}}</h5>
                             <p>
                                @if(!empty($question->answer))
                                Ans: {{$question->answer}}
                                @endif
                             </p>
                             @endforeach
                             @endif
                             
                             @if(auth('customer')->check()) 
                             <button  class="btn btn-brand" data-toggle="modal" data-target="#questionModal">
                                <b>ASK QUESTION ?</b>
                             </button>
                             @else
                             <button  class="btn btn-brand" data-toggle="modal" data-target="#signInModal">
                                <b>ASK QUESTION ?</b>
                             </button>
                             @endif
                          </div>
                       </div>
                   </div>
               </div>

               <div class="row">
                   <div class="col-xl-6">
                       <div class="d-tare">
                           <span class="heading">RATINGS AND REVIEWS</span></br>
                           <div class="star">
                               <p>{!! $overallRating[0] !!} starts out of 5.</p>
                               
                                @for($inc=0;$inc<$overallRating[0];$inc++)
                                <span class="fa fa-star checked"></span>
                                @endfor 
                                
                           </div>
                          
                       </div>
                   </div>
                   <div class="col-xl-6">
                       <div class="d-star">
                            <div class="row">
                              <div class="side">
                                <div>5 star</div>
                              </div>
                              <div class="middle">
                                <div class="bar-container">
                                  <div style="width:<?php echo $widthRating = ($rating[0] != 0) ? ($rating[0] / $overallRating[1]) * 100 : (0); ?>%; height: 18px; background-color: #0B0B45;"></div>
                                </div>
                              </div>
                              <div class="side right">
                                <div>{{$total_five_star}}</div>
                              </div>
                              <div class="side">
                                <div>4 star</div>
                              </div>
                              <div class="middle">
                                <div class="bar-container">
                                  <div style="width: <?php echo $widthRating = ($rating[1] != 0) ? ($rating[1] / $overallRating[1]) * 100 : (0); ?>%; height: 18px; background-color: #0B0B45;"></div>
                                </div>
                              </div>
                              <div class="side right">
                                <div>{{$total_four_star}}</div>
                              </div>
                              <div class="side">
                                <div>3 star</div>
                              </div>
                              <div class="middle">
                                <div class="bar-container">
                                    <div style="width: <?php echo $widthRating = ($rating[2] != 0) ? ($rating[2] / $overallRating[1]) * 100 : (0); ?>%; height: 18px; background-color: #0B0B45;"></div>
                                </div>
                              </div>
                              <div class="side right">
                                <div>{{$total_three_star}}</div>
                              </div>
                              <div class="side">
                                <div>2 star</div>
                              </div>
                              <div class="middle">
                                <div class="bar-container">
                                    <div style="width: <?php echo $widthRating = ($rating[3] != 0) ? ($rating[3] / $overallRating[1]) * 100 : (0); ?>%; height: 18px; background-color: #0B0B45;"></div>
                                </div>
                              </div>
                              <div class="side right">
                                <div>{{$total_two_star}}</div>
                              </div>
                              <div class="side">
                                <div>1 star</div>
                              </div>
                              <div class="middle">
                                <div class="bar-container">
                                    <div style="width: <?php echo $widthRating = ($rating[4] != 0) ? ($rating[4] / $overallRating[1]) * 100 : (0); ?>%; height: 18px; background-color: #0B0B45;"></div>
                                </div>
                              </div>
                              <div class="side right">
                                <div>{{$total_one_star}}</div>
                              </div>
                            </div>
                       </div>
                   </div>
               </div>
    
               <div class="container">
               <div class="row tab-row">
                   <div class="col-xl-12">
                       
                  <div class="reviews">
                     <h5>REVIEWS ({!! count($single_product->reviews) !!})</h5>
                     @if(count($single_product->reviews))
                     @foreach($single_product->reviews as $productReview)
                     <div class="review-card">
                        <div class="user-info-and-date">
                           <div class="user-info">
                              <div class="user">
                                <img style="width: 60px;height: 60px;"
                                             src="{{asset("storage/profile")}}/{{(isset($productReview->user)?$productReview->user->image:'')}}"
                                             onerror="this.src='{{asset('/assets/front-end/img/profile-image-place-holder.png')}}'"
                                             class="img-profile">
                                 
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
                              </div>
                           </div>
                           <span class="date">
                                {{date(('d-M-Y'),strtotime($productReview->created_at))}}
                           </span>
                        </div>
                        <div class="user-review">
                           <p>
                    <?php if (strlen($productReview->comment) > 120) 
                            {  
                                $comments= substr($productReview->comment, 0, 125) . "....";
                            }
                            else 
                            { 
                                $comments= $productReview->comment;
                            } 

                        ?>
                           @php
                            $review_img=json_decode($productReview->attachment);
                           @endphp
                           @if(sizeof($review_img)>0)
                           @foreach($review_img as $data)
                           <span class="dots_text">{!! $comments !!}</span>
                            <span class="more_text" style="display: none;">{!! $productReview->comment !!}</span>
                            <?php if (strlen($productReview->comment) > 120){?>
                                <a class="reviewMyBtn" style="cursor: pointer;font-weight: bold;">Read More</a>
                            <?php }?>
                             <br> <br>
                             <div style="height: 100px;width:100px;background: #e4e4e4;margin-right:30px;display: grid;place-items: center;cursor: pointer;">
                                 <img onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'"
                                 src="{{asset("storage/review")}}/{{isset($data)?$data:''}}" id="myImg">
                             </div>
                            
                            <div id="myModal" class="modal" style="position: relative;z-index: 0;width: 40%;margin-top: 30px;">
                              <span class="close">&times;</span>
                              <img class="modal-content" id="img01">
                              <div id="caption"></div>
                            </div>
                                 @endforeach
                            @endif
                           
                            
                           </p>
                        </div>
                     </div>
                     @endforeach
                     @endif
                     
                     
                  </div>
                  </div>
               </div>
               </div>
               <div class="container">
                  @if(count($relatedProducts) > 0)
                  <div class="related-products" style="overflow: hidden">
                     <h5>RECENTLY VIEWED</h5>
                     <div class="row">
                        <div class="col-12 col-lg-12 mb-2 d-p-product">
                            <div id="democat11" class="carousel" data-interval="false">
                               <!-- The slideshow -->
                               <div class="carousel-inner">
                                    <div class="carousel-item  active">
                                        <div class="row">
                                        @foreach ($product_recentview as $key => $product)
                                            @if ($key <= 3)
                                                <div class="col-xs-3 col-sm-3 col-md-3 col-6 mb-4">
                                                    @include('web-views.partials._single-product', ['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
                                                </div>
                                            @endif
                                        @endforeach
                                         </div>
                                    </div>
            
                                    @if (sizeof($product_recentview) > 5)
                                        <div class="carousel-item">
                                            <div class="row">
                                            @foreach ($product_recentview as $key => $product)
                                                @if ($key > 5 && $key <= 11)
                                                    <div class="col-xs-3 col-sm-3 col-md-3 col-6 mb-4">
                                                        @include('web-views.partials._single-product', ['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
                                                    </div>
                                                @endif
                                            @endforeach
                                            </div>
                                        </div>
                                    @endif


                               </div>
                               <!-- Left and right controls -->
                               <a class="carousel-control-prev" href="#democat11" data-slide="prev">
                               <i class="czi-arrow-left" style="padding:12px;border-radius:0px;margin-left: 0px;font-size: 20px;"></i>
                               </a>
                               <a class="carousel-control-next" href="#democat11" data-slide="next">
                               <i class="czi-arrow-right" style="padding:12px;border-radius:0px;margin-right:10px;font-size: 20px;"></i>
                               </a>
                            </div>
                        </div>
                     </div>
                  </div>
                  @endif
                    
                  @if(count($relatedProducts) > 0)
                  <div class="related-products" style="overflow: hidden">
                     <h5>RELATED PRODUCTS</h5>
                     <div class="row">
                        <div class="col-12 col-lg-12 mb-2 d-p-product">
                            <div id="democat10" class="carousel" data-interval="false">
                               <!-- The slideshow -->
                               <div class="carousel-inner">
                                    <div class="carousel-item  active">
                                        <div class="row">
                                        @foreach ($relatedProducts as $key => $product)
                                            @if ($key <= 3)
                                                <div class="col-xs-3 col-sm-3 col-md-3 col-6 mb-4">
                                                    @include('web-views.partials._single-product', ['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
                                                </div>
                                            @endif
                                        @endforeach
                                         </div>
                                    </div>
            
                                    @if (sizeof($relatedProducts) > 5)
                                        <div class="carousel-item">
                                            <div class="row">
                                            @foreach ($relatedProducts as $key => $product)
                                                @if ($key > 5 && $key <= 11)
                                                    <div class="col-xs-3 col-sm-3 col-md-3 col-6 mb-4">
                                                        @include('web-views.partials._single-product', ['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
                                                    </div>
                                                @endif
                                            @endforeach
                                            </div>
                                        </div>
                                    @endif


                               </div>
                               <!-- Left and right controls -->
                               <a class="carousel-control-prev" href="#democat10" data-slide="prev">
                               <i class="czi-arrow-left" style="padding:12px;border-radius:0px;margin-left: 0px;font-size: 20px;"></i>
                               </a>
                               <a class="carousel-control-next" href="#democat10" data-slide="next">
                               <i class="czi-arrow-right" style="padding:12px;border-radius:0px;margin-right:10px;font-size: 20px;"></i>
                               </a>
                            </div>
                        </div>
                     </div>
                  </div>
                  @endif

                  
               </div>
              </div>

         </div>
         <div class="col-12 col-xl-3 product-details-card-desktop">
             <div class="j-stiky">
            <div class="pricing-card">
               <div class="pricing-info">
                  <div class="price">
                     <h3 id="whole_price">{{\App\CPU\Helpers::currency_converter(
                            ($single_product->unit_price*$single_product->minimum_order_qty)-(\App\CPU\Helpers::get_product_discount($single_product,$single_product->unit_price))
                            )}}
                     </h3>
                     <span>(Excluding VAT)</span>
                  </div>
                  @if($single_product->is_emi==1)
                  <div class="emi-price-box">
                      <a href="" data-toggle="modal" data-target="#exampleModal">Click Here To View {{$emi_banks->count()}} Banks EMI Plans</a>
                  </div>
                  @endif
                  
                  @if($single_product->discount > 0)
                  <span class="discount-badge">
                  @if ($single_product->discount_type == 'percent')
                  {{round($single_product->discount,(!empty($decimal_point_settings) ? $decimal_point_settings: 0))}}%
                  @elseif($single_product->discount_type =='flat')
                  {{\App\CPU\Helpers::currency_converter($single_product->discount)}}
                  @endif
                  OFF
                  </span>
                  <span class="strike-price" >Tk. <strike>{{$single_product->unit_price}}</strike></span>
                  @endif
               </div>
               
               <form id="add-to-cart-form-{{ $single_product->id }}" class="mb-2">
                @csrf
                <input type="hidden" name="id" value="{{ $single_product->id }}">
                <input type="hidden" id="variant_val" name="variant_val" value="">
               <div class="quantity-info">
                  <p>Update Quantity</p>
                 <div class="spinbutton-wrapper">
                     <div class="spinbutton">
                        <input type="hidden" name="productId" value="{{ $single_product->id }}">
                        <button class="minus" type="button"  onclick="wholesale_price_minus('{{ $single_product->minimum_order_qty}}')">-</button>
                        <input type="number" class="val wholesale_quantity_area" style="width: 50px;min-height: 15px;"  onchange="wholesale_price_quantity()" value="{{ $single_product->minimum_order_qty ?? 1 }}" name="quantity" id="quantity" min="{{ $single_product->minimum_order_qty ?? 1 }}"  required>
                        <button class="plus" type="button"  onclick="wholesale_price_plus()">+</button>
                     </div>
                     <label><span class="volume-price" data-toggle="tooltip" data-placement="bottom" title="Pricing based on quantities ordered. Available only for certain types of products.">*Volume Based Pricing</span></label>
                  </div>
               </div>
               <div class="action-wrapper flex quote-btn">
                    <button type="button" onclick="addToQuote({{ $single_product->id }})">Generate Quote</button>
               </div>
               @if($sold_out==1)
                <div class="action-wrapper d-grid gap-2">
                <button class="btn btn-brand" type="button">Sold Out</button>
                </div>
            @else
                <div class="action-wrapper d-grid gap-2">
                    <button type="button" class="btn btn-brand-secondary add-to-cart" onclick="addToCart({{ $single_product->id }})">ADD TO CART</button>
                    <button class="btn btn-brand" onclick="buy_now({{ $single_product->id }})" type="button">{{\App\CPU\translate('buy_now')}}</button>
                </div>
            @endif
               </form>
            </div>
            <div class="need-help">
               <h4>Have a question for us?</h4>
               <p class="call-icon">
                   <a href="#" style="display: contents;" data-toggle="modal" data-target="#exampleModalCenter">
                       <i class="fa-solid fa-phone" style="font-size: 11px;margin-right: 10px;color:#FB641B;border: 1px solid #FB641B;padding: 3px;border-radius: 12px;"></i>
                      <span class="underline" style="text-decoration: underline;">
                      Request a call back
                      </span>
                   </a>
               </p>
               <p>
                   <a href="https://wa.me/+8801972525821"><img src="{{asset('/assets/front-end/img/icon/App.svg')}}"  alt="WhatsApp">
                   <span style="margin-top: 1px;text-decoration: underline;">Contact via Whatsapp</span>
                   </a>
               </p>
            </div>
            </div>
         </div>
      </div>
   </div>
</div>





   <script>
    // Get the modal
    var modal = document.getElementById("myModal");
    
    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById("myImg");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    img.onclick = function(){
      modal.style.display = "block";
      modalImg.src = this.src;
      captionText.innerHTML = this.alt;
    }
    
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() { 
      modal.style.display = "none";
    }
    </script>  




<!----EMI Modal----->
{{-- video modal --}}
<div id="Geeks2" class="modal fade">
    <div class="modal-dialog modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title">{{$single_product->name}}</p>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <iframe id="Geeks3" width="450" height="350"
                        src="{{$single_product->video_url}}"
                        frameborder="0" allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
</div>
{{-- video modal end --}}
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="overflow-y: auto;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">EMI PRICE CALCULATOR </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="emi-modal-sec">
            <div class="page">
               <div class="nesttabs">
                  
                        <div class="modal_tab>
                            @foreach ($emi_banks as $bank)
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="width: 100%;">
                                    <input type="hidden" id="product_price" value="{{$single_product->unit_price}}">
                                    <a class="nav-link active show" id="v-pills-home_{{$bank->id}}" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="false" onclick="bank_details('{{$bank->id}}')" >
                                       {{$bank->name}}
                                    </a>  
                                </div>
                            @endforeach
                           
                        </div>
               </div>
            </div>
        </div>
      </div>
    
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Request a call back</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body call-back" style=" padding:10px 30px!important;">
        <form action="{{ route('customer.request_call_back') }}" method="POST">
            @csrf
          <div class="form-group">
            <label for="exampleFormControlInput1">Your Name</label>
            <input type="text" class="form-control" name="name" placeholder="Your Name" required>
          </div>
          <div class="form-group">
            <label for="exampleFormControlInput1">Phone Number</label>
            <input type="text" class="form-control" name="phone_no" onkeypress="return validateNumber(event)" placeholder="Phone Number" required>
          </div>
          <input type="hidden" name="product_id" value="{{$single_product->id}}">
          <div class="form-group">
            <label for="exampleFormControlInput1">Preferred Date & Time</label>
            <div class="edit-date">
                <div class="form-row">
                    <div class="col-6">
                        <input class="form-control" id='myDate' type="date" name="preffered_dt" min="{{date('Y-m-d')}}" required />
                    </div>
                
                    <div class="col">
                
                      <select id="inputState" class="form-control" name="preffered_time" required disabled>
                        <option value="">Time</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                      </select>
                    </div>
                    <div class="col">
                      <select class="form-control" name="time_type" id="time_type" required disabled>
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                      </select>
                    </div>
                </div>
            </div>
          </div>
          
          <div class="form-group">
            <button class="btn btn-brand rewuest-call"  type="submit"  onclick="request_call_back()" style="padding: 8px 40px!important;float:right"> Submit</button>
        </div>
        </form>
      </div>
      
    </div>
  </div>
</div>

<!--question Modal -->
<div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="questionModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="questionModal">Question ?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body call-back" style=" padding:10px 30px!important;">
          <form action="{{ route('customer.ask_question') }}" method="POST">
              @csrf
            <div class="form-group">
            <label for="askQuestion">Product Name:</label>
             <p>{{$single_product->name}}</p>
            </div>
            <input type="hidden" name="product_id" value="{{$single_product->id}}">
            <div class="form-group">
                <label for="askQuestion">Question:</label>
                <div class="row">
                    <textarea name="question" class="textarea  editor-textarea" rows="3" type="text"
                    required style="width:100%" placeholder="Your Question?"></textarea>
                </div>
               
            </div>
            
            <div class="form-group">
              <button class="btn btn-brand rewuest-call"  type="submit"  onclick="request_call_back()" style="padding: 8px 40px!important;float:right"> Submit</button>
          </div>
          </form>
        </div>
        
      </div>
    </div>
  </div>

 <script src="{{asset('/assets/front-end')}}/js/owl.carousel.min.js"></script>
 
<script>

$('#recently-viewed-slider, #related-products-slider').owlCarousel({
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
        
$("#myDate").change(function(){
    
    $('#inputState, #time_type').prop("disabled", false);
    
    var selectedDate = $('#myDate').val();
    var today = new Date();
    var todayDate = today.getFullYear()+'-'+ ('0' + (today.getMonth()+1)).slice(-2) +'-'+ ('0' + (today.getDate())).slice(-2);
    
    var getHours = ('0' + (today.getHours())).slice(-2);
    var twelve_format_hours = (getHours % 12) || 12;

    if(selectedDate == todayDate){
        $("#inputState > option").each(function() {
            if(twelve_format_hours >= this.value){
                $(this).attr("disabled", true);
            }
        });
        $('#inputState').children('option:enabled').eq(0).prop('selected',true);
        
        if(getHours >= 12){
            $("#time_type > option").each(function() {
                if(this.value == 'AM'){
                    $(this).attr("disabled", true);
                }
            });
        }
        $('#time_type').children('option:enabled').eq(0).prop('selected',true);
    }
    else{
        $("#inputState > option").each(function() {
            $(this).prop("disabled", false);
        });
        $('#inputState').children('option:enabled').eq(1).prop('selected',true);
        
        $("#time_type > option").each(function() {
            $(this).prop("disabled", false);
        });
        $('#time_type').children('option:enabled').eq(0).prop('selected',true);
    }
  });

$(window).scroll(function() {
    if ($(this).scrollTop()>240)
     {
        $('header').fadeOut();
        $('.j-details-sticky').show();
     }
    else
     {
        $('header').fadeIn();
        $('.j-details-sticky').hide();
     }
 });
 function bank_details(bank_id)
    {
        var bank_id= bank_id;
        var product_price=$('#product_price').val();
        var _token = "{{ csrf_token() }}"; 
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                type: 'POST',
                url: "{{ route('customer.emi_details') }}",
                data: {
                  bank_id:bank_id,
                  _token: _token
                },
                success: function(data) {
                    if (data.response == "success") {
                        var value=data.result;
                        let text = "";
                        for (let i = 0; i < value.length; i++) {
                                text += '<tr><td>'+parseInt(value[i].tenure)+'</td><td>'+(parseInt(product_price)+parseInt(product_price*(value[i].commission/100)))+'<span style="color:orange"> ('+value[i].commission+' %) </span>'+'</td></tr>'
                        }
                        $('#bank_select').hide();
                        document.getElementById("bank_info").innerHTML = text;

                    }
                }
            });
    }     
    function activeTab(tab){
        var calcOffset = 50;
        if($("#details_tab_section").offset().top > 1010){
            calcOffset = 100;
        }
        $('html, body').animate({
            scrollTop: ($("#details_tab_section").offset().top - calcOffset)
        }, 800);
        
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    }

    function modelValueChange(key,value,product_id)
    {
        var model_type= $("#model_value_"+key).val();
        var _token = "{{ csrf_token() }}"; 
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                type: 'POST',
                url: "{{ route('customer.product_variation') }}",
                data: {
                  value: model_type,
                  product_id:product_id,
                  _token: _token
                },
                success: function(data) {
                    if (data.response == "success") {
                        console.log(data.price);
                        document.getElementById("variant_price").innerHTML ="TK "+""+ data.price.toLocaleString('en-US', {maximumFractionDigits:2});
                        document.getElementById("variant_val").setAttribute("value",model_type); 
                        
                    }
                }
            });
    }
 function wholesale_price_plus()
    {
        var product_id=$("input[name=productId]").val();
            // var qty=parseInt($("#quantity").val());
            var qty=parseInt($(".wholesale_quantity_area").val());
            
            var new_qty=qty+1;
            
            // console.log(qty, new_qty);
 	    $("#quantity").val(new_qty);
            var _token = "{{ csrf_token() }}"; 
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                type: 'POST',
                url: "{{ route('customer.product_wholesale') }}",
                data: {
                  product_id:product_id,
                  qty:new_qty,
                  _token: _token
                },
                success: function(data) {
                    if (data.response == "success") {
                        console.log(data.price);
                        if(data.price>0)
                        {
                            document.getElementById("whole_price").innerHTML ="Tk "+""+ data.price.toLocaleString('en-US', {maximumFractionDigits:2}); 
                        }
                        
                    }
                }
            });
    }
    function wholesale_price_quantity()
    {
        var product_id=$("input[name=productId]").val();
            // var new_qty=parseInt($("#quantity").val());
            var new_qty=parseInt($(".wholesale_quantity_area").val());
            var _token = "{{ csrf_token() }}"; 
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                type: 'POST',
                url: "{{ route('customer.product_wholesale') }}",
                data: {
                  product_id:product_id,
                  qty:new_qty,
                  _token: _token
                },
                success: function(data) {
                    if (data.response == "success") {
                        console.log(data.price);
                        if(data.price>0)
                        {
                            document.getElementById("whole_price").innerHTML ="Tk "+""+ data.price.toLocaleString('en-US', {maximumFractionDigits:2}); 
                        }
                        
                    }
                }
            });
    }
    function wholesale_price_minus(min)
    {
        var product_id=$("input[name=productId]").val();
            // var qty=parseInt($("#quantity").val());
            var qty=parseInt($(".wholesale_quantity_area").val());
            var new_qty=qty-1;
 	   $("#quantity").val(new_qty);
            var _token = "{{ csrf_token() }}"; 
	   console.log(qty,new_qty);
		console.log(min);
            if (min > new_qty) {
 		var min_new=parseInt(min)+1;
                 $(".wholesale_quantity_area").val(min_new);
                toastr.error('{{ \App\CPU\translate('minimum_order_quantity_cannot_be_less_than_') }}' +
                    min);
                return false;
            } 
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                type: 'POST',
                url: "{{ route('customer.product_wholesale') }}",
                data: {
                  product_id:product_id,
                  qty:new_qty,
                  _token: _token
                },
                success: function(data) {
                    if (data.response == "success") {
                        console.log(data.price);
                        if(data.price>0)
                        {
                            document.getElementById("whole_price").innerHTML ="Tk "+""+ data.price.toLocaleString('en-US', {maximumFractionDigits:2}); 
                        }
                        
                    }
                }
            });
    }

    $(".more_text").hide();
    $(document).on("click", ".reviewMyBtn", function () {
        var moreLessButton = $(".more_text").is(':visible') ? 'Read More' : 'Read Less';
        $(this).text(moreLessButton);
        $(this).closest('.user-review').find(".more_text").toggle();
        $(this).closest('.user-review').find(".dots_text").toggle();
    });
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

@endsection
@push('after-scripts')
    <!-- CSS CDN -->
  

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
    //bank emi
   })

       
</script>
@endpush