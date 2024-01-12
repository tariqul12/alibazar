<style>
    .just-padding {
        padding: 15px;
        border: 1px solid #ccccccb3;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        height: 100%;
        background-color: white;
    }
    .carousel-control-prev, .carousel-control-next{
        width: 7% !important;
    }
</style>



<!-- new home -->


<main>
    <div class="container intro">
      <div class="row">
        <div class="col-3 left-nav-container">
          <nav class="left-nav">
            <ul>
              <li><a href="#"><img src="{!! asset('public/assets/frontend/img/icons/card-icon.svg') !!}" alt="card-icon"> Power Tools</a></li>
                <li><a href="#"><img src="{!! asset('public/assets/frontend/img/icons/card-icon.svg') !!}" alt="card-icon"> Power Tools</a></li>
              <li>
                <a href="#" class="submenu">
                  <img src="img/icons/card-icon.svg" alt="card-icon"> Power Tools
                  <ul class="submenu-items">
                    <li>Menu One</li>
                    <li class="sub-sub-menu">
                      Menu Two Menu
                      <ul class="sub-sub-menu-items">
                        <li>Sub Menu One</li>
                        <li>
                          Sub Menu Two
                        </li>
                        <li>Sub Menu Three</li>
                      </ul>
                    </li>
                    <li>Menu Three</li>
                  </ul>
                </a>
              </li>
              <li><a href="#"><img src="{!! asset('public/assets/frontend/img/icons/card-icon.svg') !!}" alt="card-icon"> Power Tools</a></li>
                <li><a href="#"><img src="{!! asset('public/assets/frontend/img/icons/card-icon.svg') !!}" alt="card-icon"> Power Tools</a></li>
                <li><a href="#"><img src="{!! asset('public/assets/frontend/img/icons/card-icon.svg') !!}" alt="card-icon"> Power Tools</a></li>
              <li>
                <a href="#" class="submenu">
                  <img src="{!! asset('public/assets/frontend/img/icons/card-icon.svg') !!}" alt="card-icon"> Power Tools
                  <ul class="submenu-items">
                    <li>Menu One</li>
                    <li>Menu Two</li>
                    <li>Menu Three</li>
                  </ul>
                </a>
              </li>
              <li><a href="#"><img src="{!! asset('public/assets/frontend/img/icons/card-icon.svg') !!}" alt="card-icon"> Power Tools</a></li>
              <li><a href="#"><img src="{!! asset('public/assets/frontend/img/icons/card-icon.svg') !!}" alt="card-icon"> Power Tools</a></li>
              <li><a href="#"><img src="{!! asset('public/assets/frontend/img/icons/card-icon.svg') !!}" alt="card-icon"> Power Tools</a></li>
              <li><a href="#" class="more">See More Categories >></a></li>
            </ul>
            <div class="special-offers d-flex align-items-end">
                <a class="d-block w-50 text-center py-2" href="#">
                    <img src="{!! asset('public/assets/frontend/img/icons/summer-offer.svg') !!}" class="d-block mx-auto" alt="summer-offer">
                    <span>Summer Offers</span>
                </a>
                <a class="d-block w-50 text-center py-2" href="#">
                    <img src="{!! asset('public/assets/frontend/img/icons/pay-later.svg') !!}" class="d-block mx-auto" alt="pay-later">
                    <span>Buy Now Pay later</span>
                </a>
            </div>
          </nav>
        </div>
        
        
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-12 col-lg-9">
                    <div class="banner-grid">
                        <div class="col-xl-12 col-md-12">
                            @php($main_banner=\App\Model\Banner::where('banner_type','Main Banner')->where('published',1)->orderBy('id','desc')->get())
                            <!--<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @foreach($main_banner as $key=>$banner)
                                        <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}"
                                            class="{{$key==0?'active':''}}">
                                        </li>
                                    @endforeach
                                </ol>
                                <div class="carousel-inner">
                                    @foreach($main_banner as $key=>$banner)
                                    zahed hosaain
                                        <div class="carousel-item {{$key==0?'active':''}}">
                                            <a href="{{$banner['url']}}">
                                                <img class="d-block w-100" style="max-height: 372px;"
                                                     onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                     src="{{asset('storage/app/public/banner')}}/{{$banner['photo']}}"
                                                     alt="">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                   data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true" ></span>
                                    <span class="sr-only">{{\App\CPU\translate('Previous')}}</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                   data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">{{\App\CPU\translate('Next')}}</span>
                                </a>
                            </div>-->
                    
                            <div id="demo" class="carousel slide" data-bs-ride="carousel">
                    
                      <!-- Indicators/dots -->
                      <div class="carousel-indicators">
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                      </div>
                      
                      <!-- The slideshow/carousel -->
                      <div class="carousel-inner">
                        <div class="carousel-item active">
                          <img class="d-block w-100" style="max-height: 372px;"
                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                             src="{{asset('storage/app/public/banner')}}/{{$banner['photo']}}"
                             alt="">
                          
                        </div>
                        <div class="carousel-item">
                          <img class="d-block w-100" style="max-height: 372px;"
                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                             src="{{asset('storage/app/public/banner')}}/{{$banner['photo']}}"
                             alt="">
                          
                        </div>
                        <div class="carousel-item">
                          <img class="d-block w-100" style="max-height: 372px;"
                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                             src="{{asset('storage/app/public/banner')}}/{{$banner['photo']}}"
                             alt="">  
                        </div>
                      </div>
                      
                      <!-- Left and right controls/icons -->
                      <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                      </button>
                    </div>
                    
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="slider-right-adds">
                        <img src="https://malamal.xyz/wp-content/uploads/2022/03/Become-Our.jpg" class="attachment-full size-full" alt="" style="height: 168px;margin-bottom: 15px;">
                    </div>
                    <div class="slider-right-adds">
                        <img src="https://malamal.xyz/wp-content/uploads/2022/03/Become-Our.jpg" class="attachment-full size-full" alt="" style="height: 168px;">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="slide-bottom-banner">
                        <img width="100%" src="https://malamal.xyz/wp-content/uploads/2022/03/Become-Our.jpg" class="attachment-full size-full" alt=""  style="height: 150px;">
                    </div>
                </div>
            </div>
            <!--row-->
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="featured pages">
                        <h3 class="section-heading">Featured page</h3>
                        <div class="row">
                          <div class="col-6 col-lg-3">
                            <div class="product-card">
                              <div class="product-card-body">
                                <div class="product-image">
                                  <img src="img/product.png" alt="product-image">
                                </div>
                                <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                <p class="product-brand">By Voltas</p>
                              </div>
                              <div class="product-card-footer">
                                <div class="price-without-offer">
                                  <p>Rs 13980</p>
                                  <span>50% OFF !</span>
                                </div>
                                <div class="price-with-offer">
                                  <p>Rs 6000</p>
                                  <span>You save Rs 6000</span>
                                </div>
                              </div>
                              <div class="product-card-hover-content">
                                <div class="image-peek" style="background-image: url('img/product.png')">
                                  <span class="fav-icon"></span>
                                </div>
                                <div class="product-info">
                                  <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                  <p class="product-brand">By Voltas</p>
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
                                    <p>Rs 6000</p>
                                  </div>
                                </div>
                                <div class="action-wrapper d-grid gap-2">
                                  <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                  <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-6 col-lg-3">
                            <div class="product-card">
                              <div class="product-card-body">
                                <div class="product-image">
                                  <img src="img/bucket.png" alt="product-image">
                                </div>
                                <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                <p class="product-brand">By Voltas</p>
                              </div>
                              <div class="product-card-footer">
                                <div class="price-without-offer">
                                  <p>Rs 13980</p>
                                  <span>50% OFF !</span>
                                </div>
                                <div class="price-with-offer">
                                  <p>Rs 6000</p>
                                  <span>You save Rs 6000</span>
                                </div>
                              </div>
                              <div class="product-card-hover-content">
                                <div class="image-peek" style="background-image: url('img/bucket.png')">
                                  <span class="fav-icon"></span>
                                </div>
                                <div class="product-info">
                                  <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                  <p class="product-brand">By Voltas</p>
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
                                    <p>Rs 6000</p>
                                  </div>
                                </div>
                                <div class="action-wrapper d-grid gap-2">
                                  <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                  <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-6 col-lg-3">
                            <div class="product-card">
                              <div class="product-card-body">
                                <div class="product-image">
                                  <img src="img/product.png" alt="product-image">
                                </div>
                                <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                <p class="product-brand">By Voltas</p>
                              </div>
                              <div class="product-card-footer">
                                <div class="price-without-offer">
                                  <p>Rs 13980</p>
                                  <span>50% OFF !</span>
                                </div>
                                <div class="price-with-offer">
                                  <p>Rs 6000</p>
                                  <span>You save Rs 6000</span>
                                </div>
                              </div>
                              <div class="product-card-hover-content">
                                <div class="image-peek" style="background-image: url('img/product.png')">
                                  <span class="fav-icon"></span>
                                </div>
                                <div class="product-info">
                                  <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                  <p class="product-brand">By Voltas</p>
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
                                    <p>Rs 6000</p>
                                  </div>
                                </div>
                                <div class="action-wrapper d-grid gap-2">
                                  <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                  <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-6 col-lg-3">
                            <div class="product-card">
                              <div class="product-card-body">
                                <div class="product-image">
                                  <img src="img/product.png" alt="product-image">
                                </div>
                                <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                <p class="product-brand">By Voltas</p>
                              </div>
                              <div class="product-card-footer">
                                <div class="price-without-offer">
                                  <p>Rs 13980</p>
                                  <span>50% OFF !</span>
                                </div>
                                <div class="price-with-offer">
                                  <p>Rs 6000</p>
                                  <span>You save Rs 6000</span>
                                </div>
                              </div>
                              <div class="product-card-hover-content">
                                <div class="image-peek" style="background-image: url('img/product.png')">
                                  <span class="fav-icon"></span>
                                </div>
                                <div class="product-info">
                                  <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                  <p class="product-brand">By Voltas</p>
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
                                    <p>Rs 6000</p>
                                  </div>
                                </div>
                                <div class="action-wrapper d-grid gap-2">
                                  <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                  <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div><!-----row--->
            <div class="row">
                <div class="col-lg-12">
                    <div class="featured categories">
                        <h3 class="section-heading">Featured Categories</h3>
                        <p class="section-subheading">Get your desired product from the featured categories</p>
                        <div class="row">
                          <div class="col-6 col-md-2">
                            <div class="featured-card">
                              <img src="img/bucket.png" alt="category-thumbnail" class="category-thumb">
                              <p class="category-title">Cleaning Buckets and tubs bath</p>
                            </div>
                          </div>
                          <div class="col-6 col-md-2">
                            <div class="featured-card">
                              <img src="img/bucket.png" alt="category-thumbnail" class="category-thumb">
                              <p class="category-title">Cleaning Buckets and tubs bath</p>
                            </div>
                          </div>
                          <div class="col-6 col-md-2">
                            <div class="featured-card">
                              <img src="img/bucket.png" alt="category-thumbnail" class="category-thumb">
                              <p class="category-title">Cleaning Buckets and tubs bath</p>
                            </div>
                          </div>
                          <div class="col-6 col-md-2">
                            <div class="featured-card">
                              <img src="img/bucket.png" alt="category-thumbnail" class="category-thumb">
                              <p class="category-title">Cleaning Buckets and tubs bath</p>
                            </div>
                          </div>
                          <div class="col-6 col-md-2">
                            <div class="featured-card">
                              <img src="img/bucket.png" alt="category-thumbnail" class="category-thumb">
                              <p class="category-title">Cleaning Buckets and tubs bath</p>
                            </div>
                          </div>
                          <div class="col-6 col-md-2">
                            <div class="featured-card">
                              <img src="img/bucket.png" alt="category-thumbnail" class="category-thumb">
                              <p class="category-title">Cleaning Buckets and tubs bath</p>
                            </div>
                          </div>
                          <div class="col-6 col-md-2">
                            <div class="featured-card">
                              <img src="img/bucket.png" alt="category-thumbnail" class="category-thumb">
                              <p class="category-title">Cleaning Buckets and tubs bath</p>
                            </div>
                          </div>
                          <div class="col-6 col-md-2">
                            <div class="featured-card">
                              <img src="img/bucket.png" alt="category-thumbnail" class="category-thumb">
                              <p class="category-title">Cleaning Buckets and tubs bath</p>
                            </div>
                          </div>
                          <div class="col-6 col-md-2">
                            <div class="featured-card">
                              <img src="img/bucket.png" alt="category-thumbnail" class="category-thumb">
                              <p class="category-title">Cleaning Buckets and tubs bath</p>
                            </div>
                          </div>
                          <div class="col-6 col-md-2">
                            <div class="featured-card">
                              <img src="img/bucket.png" alt="category-thumbnail" class="category-thumb">
                              <p class="category-title">Cleaning Buckets and tubs bath</p>
                            </div>
                          </div>
                          <div class="col-6 col-md-2">
                            <div class="featured-card">
                              <img src="img/bucket.png" alt="category-thumbnail" class="category-thumb">
                              <p class="category-title">Cleaning Buckets and tubs bath</p>
                            </div>
                          </div>
                          <div class="col-6 col-md-2">
                            <div class="featured-card">
                              <img src="img/bucket.png" alt="category-thumbnail" class="category-thumb">
                              <p class="category-title">Cleaning Buckets and tubs bath</p>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div><!------row----->
            <div class="row">
                <div clas"col-lg-12">
                    <div class="wide-banner">
                        <img src="img/ultra-wide-banner.png" alt="wide-banner" class="img-fluid">
                     </div>
                </div>
            </div><!--row-->
            <div class="row">
                <div clas"col-lg-12">
                    <div class="featured categories">
                        <div class="section-heading-with-btn">
                          <h3>Cleaning</h3>
                          <button class="btn btn-brand btn-sm text-uppercase">View all</button>
                        </div>
                        <div class="row">
                          <div class="col-12 col-lg-9">
                            <div class="row">
                              <div class="col-6 col-lg-4">
                                <div class="product-card">
                                  <div class="product-card-body">
                                    <div class="product-image">
                                  <img src="img/product.png" alt="product-image">
                                </div>
                                    <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                    <p class="product-brand">By Voltas</p>
                                  </div>
                                  <div class="product-card-footer">
                                    <div class="price-without-offer">
                                      <p>Rs 13980</p>
                                      <span>50% OFF !</span>
                                    </div>
                                    <div class="price-with-offer">
                                      <p>Rs 6000</p>
                                      <span>You save Rs 6000</span>
                                    </div>
                                  </div>
                                  <div class="product-card-hover-content">
                                    <div class="image-peek" style="background-image: url('img/product.png')">
                                      <span class="fav-icon"></span>
                                    </div>
                                    <div class="product-info">
                                      <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                      <p class="product-brand">By Voltas</p>
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
                                        <p>Rs 6000</p>
                                      </div>
                                    </div>
                                    <div class="action-wrapper d-grid gap-2">
                                      <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                      <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6 col-lg-4">
                                <div class="product-card">
                                  <div class="product-card-body">
                                    <div class="product-image">
                                  <img src="img/product.png" alt="product-image">
                                </div>
                                    <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                    <p class="product-brand">By Voltas</p>
                                  </div>
                                  <div class="product-card-footer">
                                    <div class="price-without-offer">
                                      <p>Rs 13980</p>
                                      <span>50% OFF !</span>
                                    </div>
                                    <div class="price-with-offer">
                                      <p>Rs 6000</p>
                                      <span>You save Rs 6000</span>
                                    </div>
                                  </div>
                                  <div class="product-card-hover-content">
                                    <div class="image-peek" style="background-image: url('img/product.png')">
                                      <span class="fav-icon"></span>
                                    </div>
                                    <div class="product-info">
                                      <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                      <p class="product-brand">By Voltas</p>
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
                                        <p>Rs 6000</p>
                                      </div>
                                    </div>
                                    <div class="action-wrapper d-grid gap-2">
                                      <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                      <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6 col-lg-4">
                                <div class="product-card">
                                  <div class="product-card-body">
                                    <div class="product-image">
                                  <img src="img/product.png" alt="product-image">
                                </div>
                                    <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                    <p class="product-brand">By Voltas</p>
                                  </div>
                                  <div class="product-card-footer">
                                    <div class="price-without-offer">
                                      <p>Rs 13980</p>
                                      <span>50% OFF !</span>
                                    </div>
                                    <div class="price-with-offer">
                                      <p>Rs 6000</p>
                                      <span>You save Rs 6000</span>
                                    </div>
                                  </div>
                                  <div class="product-card-hover-content">
                                    <div class="image-peek" style="background-image: url('img/product.png')">
                                      <span class="fav-icon"></span>
                                    </div>
                                    <div class="product-info">
                                      <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                      <p class="product-brand">By Voltas</p>
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
                                        <p>Rs 6000</p>
                                      </div>
                                    </div>
                                    <div class="action-wrapper d-grid gap-2">
                                      <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                      <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6 col-lg-4">
                                <div class="product-card">
                                  <div class="product-card-body">
                                    <div class="product-image">
                                  <img src="img/product.png" alt="product-image">
                                </div>
                                    <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                    <p class="product-brand">By Voltas</p>
                                  </div>
                                  <div class="product-card-footer">
                                    <div class="price-without-offer">
                                      <p>Rs 13980</p>
                                      <span>50% OFF !</span>
                                    </div>
                                    <div class="price-with-offer">
                                      <p>Rs 6000</p>
                                      <span>You save Rs 6000</span>
                                    </div>
                                  </div>
                                  <div class="product-card-hover-content">
                                    <div class="image-peek" style="background-image: url('img/product.png')">
                                      <span class="fav-icon"></span>
                                    </div>
                                    <div class="product-info">
                                      <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                      <p class="product-brand">By Voltas</p>
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
                                        <p>Rs 6000</p>
                                      </div>
                                    </div>
                                    <div class="action-wrapper d-grid gap-2">
                                      <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                      <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6 col-lg-4">
                                <div class="product-card">
                                  <div class="product-card-body">
                                    <div class="product-image">
                                  <img src="img/product.png" alt="product-image">
                                </div>
                                    <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                    <p class="product-brand">By Voltas</p>
                                  </div>
                                  <div class="product-card-footer">
                                    <div class="price-without-offer">
                                      <p>Rs 13980</p>
                                      <span>50% OFF !</span>
                                    </div>
                                    <div class="price-with-offer">
                                      <p>Rs 6000</p>
                                      <span>You save Rs 6000</span>
                                    </div>
                                  </div>
                                  <div class="product-card-hover-content">
                                    <div class="image-peek" style="background-image: url('img/product.png')">
                                      <span class="fav-icon"></span>
                                    </div>
                                    <div class="product-info">
                                      <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                      <p class="product-brand">By Voltas</p>
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
                                        <p>Rs 6000</p>
                                      </div>
                                    </div>
                                    <div class="action-wrapper d-grid gap-2">
                                      <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                      <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6 col-lg-4">
                                <div class="product-card">
                                  <div class="product-card-body">
                                    <div class="product-image">
                                  <img src="img/product.png" alt="product-image">
                                </div>
                                    <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                    <p class="product-brand">By Voltas</p>
                                  </div>
                                  <div class="product-card-footer">
                                    <div class="price-without-offer">
                                      <p>Rs 13980</p>
                                      <span>50% OFF !</span>
                                    </div>
                                    <div class="price-with-offer">
                                      <p>Rs 6000</p>
                                      <span>You save Rs 6000</span>
                                    </div>
                                  </div>
                                  <div class="product-card-hover-content">
                                    <div class="image-peek" style="background-image: url('img/product.png')">
                                      <span class="fav-icon"></span>
                                    </div>
                                    <div class="product-info">
                                      <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                      <p class="product-brand">By Voltas</p>
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
                                        <p>Rs 6000</p>
                                      </div>
                                    </div>
                                    <div class="action-wrapper d-grid gap-2">
                                      <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                      <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-md-3 vertical-banner">
                            <img src="img/vertical-banner.png" alt="vertical-banner" class="img-fluid">
                          </div>
                        </div>
                      </div>
                </div>
            </div><!--row-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="featured categories">
                        <div class="section-heading-with-btn">
                          <h3>Cleaning</h3>
                          <button class="btn btn-brand btn-sm text-uppercase">View all</button>
                        </div>
                        <div class="row">
                          <div class="col-12 col-lg-9">
                            <div class="row">
                              <div class="col-6 col-lg-4">
                                <div class="product-card">
                                  <div class="product-card-body">
                                    <div class="product-image">
                                  <img src="img/product.png" alt="product-image">
                                </div>
                                    <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                    <p class="product-brand">By Voltas</p>
                                  </div>
                                  <div class="product-card-footer">
                                    <div class="price-without-offer">
                                      <p>Rs 13980</p>
                                      <span>50% OFF !</span>
                                    </div>
                                    <div class="price-with-offer">
                                      <p>Rs 6000</p>
                                      <span>You save Rs 6000</span>
                                    </div>
                                  </div>
                                  <div class="product-card-hover-content">
                                    <div class="image-peek" style="background-image: url('img/product.png')">
                                      <span class="fav-icon"></span>
                                    </div>
                                    <div class="product-info">
                                      <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                      <p class="product-brand">By Voltas</p>
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
                                        <p>Rs 6000</p>
                                      </div>
                                    </div>
                                    <div class="action-wrapper d-grid gap-2">
                                      <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                      <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6 col-lg-4">
                                <div class="product-card">
                                  <div class="product-card-body">
                                    <div class="product-image">
                                  <img src="img/product.png" alt="product-image">
                                </div>
                                    <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                    <p class="product-brand">By Voltas</p>
                                  </div>
                                  <div class="product-card-footer">
                                    <div class="price-without-offer">
                                      <p>Rs 13980</p>
                                      <span>50% OFF !</span>
                                    </div>
                                    <div class="price-with-offer">
                                      <p>Rs 6000</p>
                                      <span>You save Rs 6000</span>
                                    </div>
                                  </div>
                                  <div class="product-card-hover-content">
                                    <div class="image-peek" style="background-image: url('img/product.png')">
                                      <span class="fav-icon"></span>
                                    </div>
                                    <div class="product-info">
                                      <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                      <p class="product-brand">By Voltas</p>
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
                                        <p>Rs 6000</p>
                                      </div>
                                    </div>
                                    <div class="action-wrapper d-grid gap-2">
                                      <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                      <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6 col-lg-4">
                                <div class="product-card">
                                  <div class="product-card-body">
                                    <div class="product-image">
                                  <img src="img/product.png" alt="product-image">
                                </div>
                                    <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                    <p class="product-brand">By Voltas</p>
                                  </div>
                                  <div class="product-card-footer">
                                    <div class="price-without-offer">
                                      <p>Rs 13980</p>
                                      <span>50% OFF !</span>
                                    </div>
                                    <div class="price-with-offer">
                                      <p>Rs 6000</p>
                                      <span>You save Rs 6000</span>
                                    </div>
                                  </div>
                                  <div class="product-card-hover-content">
                                    <div class="image-peek" style="background-image: url('img/product.png')">
                                      <span class="fav-icon"></span>
                                    </div>
                                    <div class="product-info">
                                      <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                      <p class="product-brand">By Voltas</p>
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
                                        <p>Rs 6000</p>
                                      </div>
                                    </div>
                                    <div class="action-wrapper d-grid gap-2">
                                      <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                      <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6 col-lg-4">
                                <div class="product-card">
                                  <div class="product-card-body">
                                    <div class="product-image">
                                  <img src="img/product.png" alt="product-image">
                                </div>
                                    <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                    <p class="product-brand">By Voltas</p>
                                  </div>
                                  <div class="product-card-footer">
                                    <div class="price-without-offer">
                                      <p>Rs 13980</p>
                                      <span>50% OFF !</span>
                                    </div>
                                    <div class="price-with-offer">
                                      <p>Rs 6000</p>
                                      <span>You save Rs 6000</span>
                                    </div>
                                  </div>
                                  <div class="product-card-hover-content">
                                    <div class="image-peek" style="background-image: url('img/product.png')">
                                      <span class="fav-icon"></span>
                                    </div>
                                    <div class="product-info">
                                      <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                      <p class="product-brand">By Voltas</p>
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
                                        <p>Rs 6000</p>
                                      </div>
                                    </div>
                                    <div class="action-wrapper d-grid gap-2">
                                      <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                      <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6 col-lg-4">
                                <div class="product-card">
                                  <div class="product-card-body">
                                    <div class="product-image">
                                  <img src="img/product.png" alt="product-image">
                                </div>
                                    <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                    <p class="product-brand">By Voltas</p>
                                  </div>
                                  <div class="product-card-footer">
                                    <div class="price-without-offer">
                                      <p>Rs 13980</p>
                                      <span>50% OFF !</span>
                                    </div>
                                    <div class="price-with-offer">
                                      <p>Rs 6000</p>
                                      <span>You save Rs 6000</span>
                                    </div>
                                  </div>
                                  <div class="product-card-hover-content">
                                    <div class="image-peek" style="background-image: url('img/product.png')">
                                      <span class="fav-icon"></span>
                                    </div>
                                    <div class="product-info">
                                      <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                      <p class="product-brand">By Voltas</p>
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
                                        <p>Rs 6000</p>
                                      </div>
                                    </div>
                                    <div class="action-wrapper d-grid gap-2">
                                      <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                      <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6 col-lg-4">
                                <div class="product-card">
                                  <div class="product-card-body">
                                    <div class="product-image">
                                  <img src="img/product.png" alt="product-image">
                                </div>
                                    <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                    <p class="product-brand">By Voltas</p>
                                  </div>
                                  <div class="product-card-footer">
                                    <div class="price-without-offer">
                                      <p>Rs 13980</p>
                                      <span>50% OFF !</span>
                                    </div>
                                    <div class="price-with-offer">
                                      <p>Rs 6000</p>
                                      <span>You save Rs 6000</span>
                                    </div>
                                  </div>
                                  <div class="product-card-hover-content">
                                    <div class="image-peek" style="background-image: url('img/product.png')">
                                      <span class="fav-icon"></span>
                                    </div>
                                    <div class="product-info">
                                      <h5 class="product-title">Voltas pure magic double of mount air purifier</h5>
                                      <p class="product-brand">By Voltas</p>
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
                                        <p>Rs 6000</p>
                                      </div>
                                    </div>
                                    <div class="action-wrapper d-grid gap-2">
                                      <button class="btn btn-brand-secondary add-to-cart">ADD TO CART</button>
                                      <a href="payment.html" class="btn btn-brand">BUY NOW</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-md-3 vertical-banner">
                            <img src="img/vertical-banner.png" alt="vertical-banner" class="img-fluid">
                          </div>
                        </div>
                      </div>
                </div>
            </div><!-----row----->
            <div class="row">
                <div class="col-lg-12">
                    @if($brand_setting)
                        <section class="container rtl mt-3">
                            <!-- Heading-->
                            <div class="section-header">
                                <div style="color: black;font-weight: 700;
                                font-size: 22px;">
                                    <span> {{\App\CPU\translate('brands')}}</span>
                                </div>
                                <div style="margin-right:2px;">
                                    <a class="text-capitalize view-all-text" href="{{route('brands')}}">
                                        {{ \App\CPU\translate('view_all')}}
                                        <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left-circle mr-1 ml-n1 mt-1 float-left' : 'right-circle ml-1 mr-n1'}}"></i>
                                    </a>
                                </div>
                            </div>
                        {{--<hr class="view_border">--}}
                        <!-- Grid-->
                    
                            <div class="mt-3 mb-3 brand-slider">
                                <div class="owl-carousel owl-theme p-2" id="brands-slider">
                                    @foreach($brands as $brand)
                                        <div class="text-center">
                                            <a href="{{route('products',['id'=> $brand['id'],'data_from'=>'brand','page'=>1])}}">
                                                <div class="d-flex align-items-center justify-content-center"
                                                     style="height:100px;margin:5px;">
                                                    <img style="border-radius: 50%;"
                                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                        src="{{asset("storage/app/public/brand/$brand->image")}}" alt="{{$brand->name}}">
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @endif
                </div>
            </div><!-----row----->
        </div>
      </div>
    </div>
  </main>


<!-- new home ends-->



<script>
    $(function () {
        $('.list-group-item').on('click', function () {
            $('.glyphicon', this)
                .toggleClass('glyphicon-chevron-right')
                .toggleClass('glyphicon-chevron-down');
        });
    });
</script>
