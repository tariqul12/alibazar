<style>
    .just-padding {
        padding: 15px;
        border: 1px solid #ccccccb3;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        height: 100%;
        background-color: white;
    }
   .carousel-control-prev, .carousel-control-next {
    width: 7% !important;
    height: 60px;
    z-index: 0;
    position: absolute;
    bottom: 0px;
    padding: 10px 0;
    position: absolute;
    right: 0;
    top: 49%;
    margin: 0;
    z-index: 1;
    width: 100%;
    transform: translateY(-50%);
    }
    
 
    .j-cat-icon{
    width: 26px;
        height: 19px;
        margin-right: 12px; 
    }

    .j-cat-icon img {
        width: 100%;
    }


    .carousel {
        position: relative;
    }

    .right-adds-sec{
        margin-top: 5px;
    }

    .right-adds1{
        height: 180px;
        overflow: hidden;
        margin-bottom:10px;
    }
    .right-adds1 img{
        width:100%;
    }

    .right-adds2{
        height: 172px; 
        overflow: hidden;
    }
    .right-adds2 img{
        width:100%;
    }


    .big-adds{
        margin-top:10px;
    }

    .product-card-hover-content {
    position: absolute;
    top: 100%;
    background-color: #FFFFFF;
    width: 100%;
    height: 100%;
    padding: 10px;
    }

    .product-info{
        height: 74px;

    }

    .product-card-hover-content .image-peek {
    position: relative;
    background-position: center;
    background-size: cover;
    min-height:138px;
    transition: 2s ease;
    }


    .product-card-hover-content .image-peek .fav-icon {
    display: inline-block;
    width: 20px;
    height: 20px;
    background-image: url("/public/img/icons/fav-icon.svg");
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
    position: absolute;
    right: 10px;
    top: 10px;
    }

    .product-card-hover-content .count-and-price {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 8px 0;
    }

    .product-card:hover .product-card-hover-content {
    top: 0;
    }
    .owl-item .product-card .product-card-footer{
        min-height: 82px;
        
    }

    .owl-item .product-card .product-card-body{
        min-height: 266px;
    }
    .btn-view-all {
        background: #FB641B;
        color: #fff !important;
    }

    .col-md-4{
    display: inline-block;
    margin-left:-4px;
    }
    .col-md-4 img{
    width:100%;
    height:auto;
    }
    .carousel-indicators li{
    background-color:red;
    }
    .carousel-control-prev-icon,
    .carousel-control-next-icon{
    background-color:red;
    }
    .no-padding{
    padding-left: 0;
    padding-right: 0;
    }
    .submenu-items.sub-sub-menu{
    color:#fff!important;
    }

    .left-nav ul li a.submenu .submenu-items li:hover {
        background: #fff;
        color: #000!important;
    }

    .left-nav ul li a.submenu .submenu-items .sub-sub-menu{
        color: #fff!important;
    }
    .left-nav ul li a.submenu .submenu-items .sub-sub-menu:hover{
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
@php 
use Illuminate\Support\Facades\DB;
    $blog_data=DB::table('blog_post')->orderBy('id','DESC')->paginate(6);
@endphp
<div class="row rtl">
    <div class="col-xl-3 d-none d-xl-block">
        <div class="left-nav">
            <nav>
            <ul>
                @if(count($categories))
                @foreach($categories as $cat)
                    <li>
                        <a href="javascript:void(0);" onclick="location.href='{{route('products',['id'=> $cat->id,'data_from'=>'category','page'=>1])}}'" @if ($cat->childes->count() > 0)class="submenu"  @endif>
                            <div class="j-cat-icon">
                                <img src="{{asset("storage/category/$cat->icon")}}" onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'" > 
                            </div>
                            <!--<a href="{{route('products',['id'=> $cat->id,'data_from'=>'category','page'=>1])}}">{!! $cat->name !!}</a>-->
                            <span style="cursor: pointer;" >{{ Str::limit($cat->name, 34) }}</span>
                            @if (sizeof($cat->childes) > 0)
                               <ul class="submenu-items">
                                @foreach($cat->childes as $subCategory)
                                    <li class="{{ sizeof($subCategory->childes) > 0 ? 'sub-sub-menu' : ''}}" style="cursor: pointer;" onclick="event.stopPropagation(); location.href='{{route('products',['id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}';">{{$subCategory['name']}}
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

              <!--<li><a href="{{route('categories')}}" class="more">See More Categories &gt;&gt;</a></li>-->
              <li><a style="cursor: pointer" data-toggle="modal" data-target="#allCategoriesModal" class="more">See More Categories &gt;&gt;</a></li>
            </ul>
            <?php
            $flashDeal =\App\Model\FlashDeal::where('status',1)->first();
            $getFlashId = !empty($flashDeal) ? $flashDeal->id : 1;
            ?>
            <div class="special-offers d-flex align-items-end">
              <a class="d-block w-50 text-center py-2" href="{{route('flash-deals',[$getFlashId])}}">
                <img src="{{asset('/assets/frontend/img/icons/summer-offer.svg')}}" class="d-block mx-auto" alt="summer-offer">
                <span>Summer Offers</span>
              </a>
              <a class="d-block w-50 text-center py-2" href="#">
                <img src="{{asset('/assets/front-end/img/icon/pay-later.svg')}}" class="d-block mx-auto" alt="pay-later">
                <span>EMI</span>
              </a>
            </div>
          </nav>
        </div>
    </div>
    
    <div class="col-xl-9 col-md-12" style="margin-top: 3px;{{Session::get('direction') === "rtl" ? 'padding-right:10px;' : 'padding-left:10px;'}}">
        <div class="row">
            <div class="col-xl-9 col-md-12">
                @php($main_banner=\App\Model\Banner::where('banner_type','Main Banner')->where('published',1)->orderBy('id','desc')->get())
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="margin-top:5px;">
                    <ol class="carousel-indicators">
                        @foreach($main_banner as $key=>$banner)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}"
                                class="{{$key==0?'active':''}}">
                            </li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach($main_banner as $key=>$banner)
                            <div class="carousel-item {{$key==0?'active':''}}">
                                <a href="{{$banner['url']}}">
                                    <img class="d-block w-100" style="max-height: 372px;"
                                         onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'"
                                         src="{{asset('storage/banner')}}/{{$banner['photo']}}"
                                         alt="">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="right-adds-sec">
                    <div class="right-adds1">
                    @php($banner_=\App\Model\Banner::where('banner_type','Home Slider First Ad')->where('published',1)->orderBy('id','desc')->first())
                    <a href="{{$banner_['url']}}"><img src="{{asset('storage/banner')}}/{{$banner_['photo']}}"  alt="pay-later"></a>
                    </div>
                    <div class="right-adds2">
                        @php($banner_=\App\Model\Banner::where('banner_type','Home Slider Second Ad')->where('published',1)->orderBy('id','desc')->first())
                        <a href="{{$banner_['url']}}"><img src="{{asset('storage/banner')}}/{{$banner_['photo']}}"  alt="pay-later"></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mobile-categories-sec">
        <div class="row ">
            <div class="col-md-12">
                 <div class="mobile-vew-all-categories">
                     <p>Shop By Categories</p>
                 </div>
            </div>
            @foreach(\App\CPU\CategoryManager::parents() as $key => $category)
                @if($key <= 8)
                    @if($key == 0)
                    <div class="mob_dots_category" style="display: contents;">
                    @endif
                    <div class="col-lg-2 col-md-2 col-4">
                    
                        <div class="card-header mb-2 side-category-bar categori-modal" onclick="location.href='{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}'" style="cursor: pointer;">
                            <span class="cat-span">
                            <img src="{{asset("storage/category/$category->icon")}}" onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'">
                               <p>{{$category['name']}}</p> 
                          </span>
                        </div>
                    
                  
                    </div>
                    @if($key == 8)
                    </div>
                    @endif

                    @else
                      @if($key == 9)
                        <div class="mob_more_category" style="display: none;">
                        @endif
                      <div class="col-lg-2 col-md-2 col-4">
                        
                            <div class="card-header mb-2 side-category-bar categori-modal" onclick="location.href='{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}'" style="cursor: pointer;">
                                <span class="cat-span">
                                <img src="{{asset("storage/category/$category->icon")}}" onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'">
                                {{-- <label class="ml-2 category-name-{{$key}}" style="cursor: pointer"> --}}
                                   <p>{{$category['name']}}</p> 
                                {{-- </label> --}}
                              </span>
                            </div>
                        
                      
                        </div>
                        @if($key == sizeof(\App\CPU\CategoryManager::parents())-1)
                        </div>
                        @endif
                @endif
            @endforeach
            <div class="col-md-12">
                <div class="mobile-vew-all-categories">
                     <a class="mobViewAllVatBtn" style="cursor: pointer;">View All Categories >></a>
                </div>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="big-adds">
                        @php($banner_=\App\Model\Banner::where('banner_type','Home Ad 01')->where('published',1)->orderBy('id','desc')->first())
                        <a href="{{$banner_['url']}}"><img src="{{asset('storage/banner')}}/{{$banner_['photo']}}"  alt="pay-later"></a>
                </div>
            </div>
        </div>
        
        @if(sizeof($featured_products) > 0)
        <div class="row  mt-3">
            <div class="col-xl-12">
                <div class="big-adds">
                    <div class="featured pages">
                        <h1 class="section-heading">Featured Products</h1>
                        <div class="row">
                            @foreach($featured_products  as  $key => $product)
                                <div class="col-6 col-lg-3 mb-2">
                                    @include('web-views.partials._single-product',['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
                                </div>
                            @endforeach
                            
                          
                        </div>
                      </div>
                </div>
            </div>
        </div>
        @endif
        
        <div class="row">
            <div class="col-xl-12">
                <div class="big-adds">
                        @php($banner_=\App\Model\Banner::where('banner_type','Home Ad 02')->where('published',1)->orderBy('id','desc')->first())
                        <a href="{{$banner_['url']}}"><img src="{{asset('storage/banner')}}/{{$banner_['photo']}}"  alt="pay-later"></a>
                </div>
            </div>
        </div>
        
        <!--start latest products-->
        @if(sizeof($latest_products) > 0)
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="big-adds">
                    <div class="featured pages">
                        <h3 class="section-heading">Latest Products</h3>
                        <div class="row">
                            @foreach($latest_products  as  $key => $product)
                                <div class="col-6 col-lg-3 mb-4">
                                    @include('web-views.partials._single-product',['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
                                </div>
                            @endforeach

                          
                        </div>
                      </div>
                </div>
            </div>
        </div>
        @endif
        
        @if(sizeof($bestSellProduct) > 0)
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="big-adds">
                    <div class="featured pages">
                        <div class="section-heading-with-btn" style="margin-right:2px;">
                            <h3 class="section-heading best">Best Sellings</h3>
                            <a class="btn btn-view-all btn-sm text-uppercase text-capitalize view-all-text" href="{{route('products',['data_from'=>'best-selling','page'=>1])}}">
                                View all
                                <i class="czi-arrow-right-circle ml-1 mr-n1"></i>
                            </a>
                        </div>
                        <div class="row">
                            @foreach($bestSellProduct  as  $key => $bestSell)
                                <div class="col-6 col-lg-3 mb-4">
                                    @include('web-views.partials._single-product',['product'=>$bestSell->product,'decimal_point_settings'=>$decimal_point_settings])
                                </div>
                            @endforeach

                          
                        </div>
                      </div>
                </div>
            </div>
        </div>
        @endif

        <!--start new arrivals sarzil-->       
        @if(sizeof($latest_products) > 0)
        <div class="row mt-3">
            <div class="col-xl-12">
                    <div class="section-heading-with-btn" style="margin-right:2px;">
                        <h3 class="section-heading best">New ARRIVALS</h3>
                        <a class="btn btn-view-all btn-sm text-uppercase text-capitalize view-all-text"
                            href="{{ route('products', ['data_from' => 'best-selling', 'page' => 1]) }}">
                            View all
                            <i class="czi-arrow-right-circle ml-1 mr-n1"></i>
                        </a>
                </div>
            </div>
            <div class="col-xl-9">
                <!--end latest products-->
                <div id="demo" class="carousel" data-interval="false">
                    <!-- The slideshow -->
                    <div class="container carousel-inner no-padding">
                        <div class="carousel-item active">
                            @foreach ($latest_products as $key => $product)
                                @if ($key <= 5)
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-6 mb-4">
                                        @include('web-views.partials._single-product', ['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        @if (sizeof($latest_products) > 5)
                            <div class="carousel-item">
                                @foreach ($latest_products as $key => $product)
                                    @if ($key > 5 && $key <= 11)
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-6 mb-4">
                                            @include('web-views.partials._single-product', ['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control-prev" href="#demo" data-slide="prev">
                       <!-- <i class="fa-solid fa-chevron-left"
                            style="font-size: 30px;box-shadow: 0px 0px 4px;padding: 7px; border-radius: 2px;z-index: 9999;"></i>-->
                            <i class="czi-arrow-left" style="padding:12px;border-radius:0px;margin-left: 0px;font-size: 20px;"></i>
                    </a>
                    <a class="carousel-control-next" href="#demo" data-slide="next">
                        <i class="czi-arrow-right" style="padding:12px;border-radius:0px;margin-right:10px;font-size: 20px;"></i>
                        <!--<i class="fa-solid fa-chevron-right"
                            style="font-size: 30px;box-shadow: 0px 0px 4px;padding: 7px; border-radius: 2px;z-index: 9999;"></i>-->
                    </a>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="right-big-adds">
                        @php($banner_=\App\Model\Banner::where('banner_type','New Arrivals')->where('published',1)->orderBy('id','desc')->first())
                        <a href="{{$banner_['url']}}"><img src="{{asset('storage/banner')}}/{{$banner_['photo']}}"  alt="pay-later"></a>
                </div>
            </div>
        </div>
        @endif
        <!--end new arrivals sarzil-->
        
       
        {{--start top rated sarzil --}}
        @if(sizeof($topRated) > 0)
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="section-heading-with-btn" style="margin-right:2px;">
                    <h3 class="section-heading best">TOP RATED</h3>
                    <a class="btn btn-view-all btn-sm text-uppercase text-capitalize view-all-text"
                        href="{{ route('products', ['data_from' => 'top-rated', 'page' => 1]) }}">
                        View all
                        <i class="czi-arrow-right-circle ml-1 mr-n1"></i>
                    </a>
                </div>
            </div>
            <div class="col-xl-9">
                <!--end latest products-->
                <div id="demo1" class="carousel" data-interval="false">
                    <!-- The slideshow -->
                    <div class="container carousel-inner no-padding">
                        <div class="carousel-item active">
                            @foreach ($topRated as $key => $top)
                                @if ($key <= 5)
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-6 mb-4">
                                        @include('web-views.partials._single-product', ['product'=>$top->product,'decimal_point_settings'=>$decimal_point_settings])
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        @if (sizeof($topRated) > 5)
                            <div class="carousel-item">
                                @foreach ($topRated as $key => $top)
                                    @if ($key > 5 && $key <= 11)
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-6 mb-4">
                                            @include('web-views.partials._single-product', ['product'=>$top->product,'decimal_point_settings'=>$decimal_point_settings])
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control-prev" href="#demo1" data-slide="prev">
                        <i class="czi-arrow-left" style="padding:12px;border-radius:0px;margin-left: 0px;font-size: 20px;"></i>
                    </a>
                    <a class="carousel-control-next" href="#demo1" data-slide="next">
                        <i class="czi-arrow-right" style="padding:12px;border-radius:0px;margin-right:10px;font-size: 20px;"></i>
                    </a>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="right-big-adds">
                        @php($banner_=\App\Model\Banner::where('banner_type','Top Rated')->where('published',1)->orderBy('id','desc')->first())
                        <a href="{{$banner_['url']}}"><img src="{{asset('storage/banner')}}/{{$banner_['photo']}}"  alt="pay-later"></a>
                </div>
            </div>
        </div>
        @endif
        {{--end top rated sarzil--}}

        <!--start shop by brands-->
        @if(sizeof($brands) > 0)
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="">
                    <div class="featured pages">
                        <div class="section-heading-with-btn" style="margin-right:2px;">
                            <h3 class="section-heading best">Shop By Brands</h3>
                            <a class="btn btn-view-all btn-sm text-uppercase text-capitalize view-all-text" href="{{route('brands')}}">
                                {{ \App\CPU\translate('view_all')}}
                                <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left-circle mr-1 ml-n1 mt-1 float-left' : 'right-circle ml-1 mr-n1'}}"></i>
                            </a>
                        </div>
                        
                        <div class="">
                            <div class="carousel-wrap" >
                                <div class="owl-carousel owl-theme p-2" id="shop-by-brand" style="">
                                    @foreach($brands as $brand)
                                        <!--<div class="item">-->
                                        <a href="{{route('products',['id'=> $brand['id'],'data_from'=>'brand','page'=>1])}}" class="">
                                            <img
                                                onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'"
                                                src="{{asset("storage/brand/$brand->image")}}"
                                                alt="{{$brand->name}}">
                                        </a>
                                        <!--</div>-->
                                    @endforeach

                                </div>
                            </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
        @endif
        <!--end shop by brands-->

        {{-- sarzil category wise start --}}
        @foreach($home_categories as $catKey => $category)
        @if(sizeof($category['products']) > 0)
        
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="section-heading-with-btn" style="margin-right:2px;">
                    <h3 class="section-heading best">{{ $category['name'] }}</h3>
                    <a class="btn btn-view-all btn-sm text-uppercase text-capitalize view-all-text"
                    href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}">
                        View all
                        <i class="czi-arrow-right-circle ml-1 mr-n1"></i>
                    </a>
                </div>
            </div>
            <div class="col-xl-9">
                <!--end latest products-->
                <div id="democat{{$catKey}}" class="carousel" data-interval="false">
                    <!-- The slideshow -->
                    <div class="container carousel-inner no-padding">
                        <div class="carousel-item active">
                            @foreach ($category['products'] as $key => $product)
                                @if ($key <= 5)
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-6 mb-4">
                                        @include('web-views.partials._single-product', ['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        @if (sizeof($category['products']) > 5)
                            <div class="carousel-item">
                                @foreach ($category['products'] as $key => $top)
                                    @if ($key > 5 && $key <= 11)
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-6 mb-4">
                                            @include('web-views.partials._single-product', ['product'=>$top,'decimal_point_settings'=>$decimal_point_settings])
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control-prev" href="#democat{{$catKey}}" data-slide="prev">
                        <i class="czi-arrow-left" style="padding:12px;border-radius:0px;margin-left: 0px;font-size: 20px;"></i>
                    </a>
                    <a class="carousel-control-next" href="#democat{{$catKey}}" data-slide="next">
                        <i class="czi-arrow-right" style="padding:12px;border-radius:0px;margin-right:10px;font-size: 20px;"></i>
                    </a>
                </div>
            </div>
            <div class="col-xl-3"> 
                <div class="right-big-adds">
                    @php($banner_=\App\Model\Banner::where('banner_type','Main Section Banner')->where('published',1)->where('resource_type','category')->where('resource_id',$category['id'])->orderBy('id','desc')->first())
                    @if(!empty($banner_))
                    <a href="{{$banner_['url']}}"><img src="{{asset('storage/banner')}}/{{$banner_['photo']}}"  alt="pay-later"></a>
                    @endif
                </div>
            </div>
        </div>
        @endif
        @endforeach
        {{-- sarzil category wise end --}}
    </div>
    <!-- Banner group-->
</div>


<script>
    $(".mob_more_category").hide();
    $(document).on("click", ".mobViewAllVatBtn", function () {
        var moreLessButton = $(".mob_more_category").is(':visible') ? 'View All Categories >>' : 'View Less >>';
        $(this).text(moreLessButton);
        $(".mob_more_category").toggle();
        if($(".mob_more_category").is(':visible')){
            $(".mob_more_category").css({"display": "contents"});
        } 
    });
</script>