@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('All Category Page'))

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Categories of {{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Categories of {{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

   
@endpush

@section('content')
    <!-- Page Content-->
    
    
    
    <div class="container">
      <div class="row justify-content-md-center">
          <div class="col-md-11">
              <div class="categories-page-sec">
                  <h1>All Categories</h1>
                <div id="carousel" class="carousel slide" data-ride="carousel">
                
                  <div class="carousel-inner categories-inner">
                    <div class="carousel-item active">
                      <div class="d-none d-lg-block">
                        <div class="slide-box">
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/category/2022-12-14-6398c144c58f7.png" onerror="this.src='/assets/front-end/img/image-place-holder.png'">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/category/2022-12-14-6398c144c58f7.png" onerror="this.src='/assets/front-end/img/image-place-holder.png'">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="storage/category/2022-12-14-6398c144c58f7.png" onerror="this.src='/assets/front-end/img/image-place-holder.png'">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/category/2022-12-14-6398c144c58f7.png" onerror="this.src='/assets/front-end/img/image-place-holder.png'">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/category/2022-12-14-6398c144c58f7.png" onerror="this.src='/assets/front-end/img/image-place-holder.png'">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/category/2022-12-14-6398c144c58f7.png" onerror="this.src='/assets/front-end/img/image-place-holder.png'">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="slide-box">
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/category/2022-12-14-6398c144c58f7.png" onerror="this.src='/assets/front-end/img/image-place-holder.png'">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/category/2022-12-14-6398c144c58f7.png" onerror="this.src='/assets/front-end/img/image-place-holder.png'">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/category/2022-12-14-6398c144c58f7.png" onerror="this.src='/assets/front-end/img/image-place-holder.png'">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/category/2022-12-14-6398c144c58f7.png" onerror="this.src='/assets/front-end/img/image-place-holder.png'">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/category/2022-12-14-6398c144c58f7.png" onerror="this.src='/assets/front-end/img/image-place-holder.png'">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/category/2022-12-14-6398c144c58f7.png" onerror="this.src='/assets/front-end/img/image-place-holder.png'">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        
                      </div>
                      
                      <!-------------mobile----------->
                      <div class="d-block d-sm-none">
                        <div class="slide-box">
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                      </div>
                      <!--end-mobile----->
                    </div>
                    
                    <div class="carousel-item">
                      <div class="d-none d-lg-block">
                        <div class="slide-box">
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="slide-box">
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and </p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                      </div>
                        <!---------------Mobile------------->
                      <div class="d-block d-sm-none">
                            <div class="slide-box">
                                <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide-box-item">
                                <a href="">
                                    <div class="slide-box-item1">
                                        <img src="/storage/app/public/category/2022-12-14-6398c29fd7915.png">
                                    </div>
                                    <div class="slide-box-item2">
                                        <p>Material Handling and Packaging</p>
                                    </div>
                                </a>
                            </div>
                            
                            </div>
                      </div>
                      <!-------end mobile------>
                    </div>
                  </div>
                  <a class="carousel-control-prev cat-slide" href="#carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next cat-slide" href="#carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
                
                <!---->
                <div class="sub-categories-sec">
                    <div class="sub-categories-item">
                        <a href="" class="cat-main-heading">Material Handling</a>
                        <div class="sub-categories-box">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="main-categories-box-list">
                                        <a href="" class="categories-main-cat">Material Handling</a>
                                        <div class="sub-cat-list-box-list">
                                            <ul>
                                                <li><a href="">Material Handling and Packaging</a></li>
                                                <li><a href="">Material Handling and Packaging</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling and Packaging</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="main-categories-box-list">
                                        <a href="" class="categories-main-cat">Material Handling</a>
                                        <div class="sub-cat-list-box-list">
                                            <ul>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="main-categories-box-list">
                                        <a href="" class="categories-main-cat">Material Handling</a>
                                        <div class="sub-cat-list-box-list">
                                            <ul>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="main-categories-box-list">
                                        <a href="" class="categories-main-cat">Material Handling</a>
                                        <div class="sub-cat-list-box-list">
                                            <ul>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="main-categories-box-list">
                                        <a href="" class="categories-main-cat">Material Handling</a>
                                        <div class="sub-cat-list-box-list">
                                            <ul>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <!----->
                    <div class="sub-categories-item">
                        <a href="" class="cat-main-heading">Material Handling</a>
                        <div class="sub-categories-box">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="main-categories-box-list">
                                        <a href="" class="categories-main-cat">Material Handling</a>
                                        <div class="sub-cat-list-box-list">
                                            <ul>
                                                <li><a href="">Material Handling and Packaging</a></li>
                                                <li><a href="">Material Handling and Packaging</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling and Packaging</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="main-categories-box-list">
                                        <a href="" class="categories-main-cat">Material Handling</a>
                                        <div class="sub-cat-list-box-list">
                                            <ul>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="main-categories-box-list">
                                        <a href="" class="categories-main-cat">Material Handling</a>
                                        <div class="sub-cat-list-box-list">
                                            <ul>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="main-categories-box-list">
                                        <a href="" class="categories-main-cat">Material Handling</a>
                                        <div class="sub-cat-list-box-list">
                                            <ul>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="main-categories-box-list">
                                        <a href="" class="categories-main-cat">Material Handling</a>
                                        <div class="sub-cat-list-box-list">
                                            <ul>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                                <li><a href="">Material Handling</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <!----->
                </div>
            </div>
        </div>
      </div>
    </div>



    <div class="container p-3 rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9">
                
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-md-9">
                <div class="categories-page-title">
                    <h1>{{\App\CPU\translate('category')}}</h1>
                </div>
                <div class="row">
            <!-- Sidebar-->
             @foreach(\App\CPU\CategoryManager::parents() as $category)
            <div class="col-lg-2 col-md-2 col-6">
               
                    <div class="card-header mb-2 p-2 side-category-bar" onclick="get_categories('{{route('category-ajax',[$category['id']])}}')">
                        <img src="{{asset("storage/category/$category->icon")}}" onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'" style="width: 40px; height: 40px;">
                            <p>{{$category['name']}}</p>
                    </div>
                
            </div>
            @endforeach
            </div>
            </div>
            <!-- Content  -->
            <div class="col-lg-9 col-md-8">
                <!-- Products grid-->
                <hr>
                <div class="row" id="ajax-categories">
                    <label class="col-md-12 text-center mt-5">{{\App\CPU\translate('Select your desire category')}}.</label>
                </div>
                <!-- Pagination-->
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('.card-header').click(function() {
                $('.card-header').removeClass('active');
                $(this).addClass('active');
            });

        });
        function get_categories(route) {
            $.get({
                url: route,
                dataType: 'json',
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    $('html,body').animate({scrollTop: $("#ajax-categories").offset().top}, 'slow');
                    $('#ajax-categories').html(response.view);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }
    </script>
@endpush