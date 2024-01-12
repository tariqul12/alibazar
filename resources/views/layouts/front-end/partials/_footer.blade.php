


<footer>
 
    <section id="tabs">
   <div class="container">
       <div class="row">
           <div class="col-md-12 ">
               <nav style="text-align:center;border-bottom: 1px solid #fff;">
                   <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                       <a class="nav-item nav-link active" id="nav-home-tab2" data-toggle="tab" href="#nav-home1" role="tab" aria-controls="#nav-home1" aria-selected="true">Shop All Categories</a>
                       <a class="nav-item nav-link" id="nav-profile-tab2" data-toggle="tab" href="#nav-profile1" role="tab" aria-controls="#nav-profile1" aria-selected="false">Shop All Brands</a>
                       <a class="nav-item nav-link" id="nav-contact-tab2" data-toggle="tab" href="#nav-contact1" role="tab" aria-controls="#nav-contact1" aria-selected="false">Popular Searched</a>
                   </div>
               </nav>
               <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                   <div class="tab-pane fade show active" id="nav-home1" role="tabpanel" aria-labelledby="nav-home-tab2">
                       <div class="row">
                           @php($getFooterCategories = \App\CPU\Helpers::footer_categories())
                       
                           @foreach($getFooterCategories as $fcat)
                           <div class="col-6 col-sm-6 col-md-2">
                               <ul class="footer-link-list">
                                   @foreach($fcat as $cat)
                                   <li><a href="{{route('products',['id'=> $cat['id'],'data_from'=>'category','page'=>1])}}">{{$cat['name']}}</a></li>
                                   @endforeach
                               </ul>
                           </div>
                           @endforeach
                       </div>
                       <div class="row">
                           <div class="col-md-12">
                               <div class="footer-all-categories">
                                   <a style="cursor: pointer" data-toggle="modal" data-target="#allCategoriesModal" class="more footer-alllcatrgories-btn">See All Categories &gt;&gt;</a>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="tab-pane fade" id="nav-profile1" role="tabpanel" aria-labelledby="nav-profile-tab2">
                       <div class="row">
                           @php($getFooterBrands = \App\CPU\Helpers::footer_brands())
                           
                           @foreach($getFooterBrands as $fbrand)
                           <div class="col-4 col-sm-6 col-md-2">
                               <ul class="footer-link-list">
                                   @foreach($fbrand as $br)
                                   <li><a href="{{route('products',['id'=> $br['id'],'data_from'=>'brand','page'=>1])}}">{{$br['name']}}</a></li>
                                   @endforeach
                               </ul>
                           </div>
                           @endforeach
                       </div>
                       <div class="row">
                           <div class="col-md-12">
                               <div class="footer-all-categories">
                                   <a style="cursor: pointer" href="{{route('brands')}}" class="more">See All Brands &gt;&gt;</a>
                               </div>
                           </div>
                       </div>

                   </div>
                   <div class="tab-pane fade" id="nav-contact1" role="tabpanel" aria-labelledby="nav-contact-tab2">
                       <div class="row">
                           @php($getFooterSearch = \App\CPU\Helpers::footer_popular_search())
                           
                           @foreach($getFooterSearch as $fsearch)
                           <div class="col-4 col-sm-6 col-md-2">
                               <ul class="footer-link-list">
                                   @foreach($fsearch as $fr)
                                   <li><a href="{{route('products',['name'=> $fr['query'],'data_from'=>'search','page'=>1])}}">{{$fr['query']}}</a></li>
                                   @endforeach
                               </ul>
                           </div>
                           @endforeach
                       </div>
                   </div>
                   
               </div>
           
           </div>
       </div>
   </div>
</section>

   <div class="footer-featured">
       <div class="container">
           <div class="row">
               <div class="col-6 col-sm-6 col-md-3">
                   <div class="footer-featured-card">
                       <img src="{!! asset('/assets/frontendv2/img/icons/footer/fast.svg') !!}" alt="icon-fast">
                       <h5>Fastest Delivery <br>Possible</h5>
                   </div>
               </div>
               <div class="col-6 col-sm-6 col-md-3">
                   <div class="footer-featured-card">
                       <img src="{!! asset('/assets/frontendv2/img/icons/footer/secure.svg') !!}" alt="icon-secure">
                       <h5>Secure Payment <br>System</h5>
                   </div>
               </div>
               <div class="col-6 col-sm-6 col-md-3">
                   <div class="footer-featured-card">
                       <img src="{!! asset('/assets/frontendv2/img/icons/footer/cash.svg') !!}" alt="icon-cash">
                       <h5>Cash On Delivery <br>at Your Doors</h5>
                   </div>
               </div>
               <div class="col-6 col-sm-6 col-md-3">
                   <div class="footer-featured-card">
                       <img src="{!! asset('/assets/frontendv2/img/icons/footer/authentic.svg') !!}" alt="icon-authentic">
                       <h5>Authenticity <br>100% Guaranteed</h5>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <div class="footer-contact">
       <div class="container">
           <div class="row">
               <div class="col-12 col-sm-6 col-md-3">
                   <div class="footer-contact-card">
                       <img src="{!! asset('/assets/frontendv2/img/icons/footer/phone.svg') !!}" alt="icon-telephone">
                       <p>
                           <strong>Hotline & WhatsApp:</strong> <br>
                           <a href="tel:+8809638212121"> +8809638212121 </a> (10am to 7pm)<br>
                           <a href="tel:+8801972525828"> +8801972525821 </a> <a href="https://wa.me/+8801972525821"> (WhatsApp) </a>
                       </p>
                   </div>
               </div>
               <div class="col-12 col-sm-6 col-md-3">
                   <div class="footer-contact-card">
                       <img src="{!! asset('/assets/frontendv2/img/icons/footer/marker.svg') !!}" alt="icon-marker">
                       <p>
                          <strong> Registered Office:</strong> <br>
                           Level 11 & 12, Medona Tower, 28, <br>
                           Mohakhali C/A, Dhaka-1212
                       </p>
                   </div>
               </div>
               <div class="col-12 col-sm-6 col-md-3">
                   <div class="footer-contact-card">
                       <img src="{!! asset('/assets/frontendv2/img/icons/footer/marker.svg') !!}" alt="icon-marker">
                       <p>
                           <strong>Operational Office:</strong> <br>
                           100-103, Hazi Samsul Islam Tower, <br>
                           2nd Floor, Nawabpur Road, Dhaka - 1100
                       </p>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <div class="footer-newsletter">
       <div class="container">
           <div class="row">
               <div class="col-6 col-sm-6 col-md-3">
                   <h5>Customer Service</h5>
                   <ul class="footer-link-list">
                       @php($getFooterCustomerService = \App\CPU\Helpers::getFooter1Data())
                       @foreach ($getFooterCustomerService as $item)
                           <li><a href="{{ $item->value }}">{{ $item->type }}</a></li>
                       @endforeach
                   </ul>
               </div>
               <div class="col-6 col-sm-6 col-md-3">
                   <h5>Corporate Info</h5>
                   <ul class="footer-link-list">
                       @php($getFooterCorporateInfo = \App\CPU\Helpers::getFooter2Data())
                       @foreach ($getFooterCorporateInfo as $item)
                           <li><a href="{{ $item->value }}">{{ $item->type }}</a></li>
                       @endforeach
                   </ul>
               </div>
               <div class="col-6 col-sm-6 col-md-3">
                   <h5>Account Info</h5>
                   <ul class="footer-link-list">
                       <li><a href="{{route('user-account')}}">My Account</a></li>
                       <li><a href="{{route('wishlists')}}">My Wishlist</a></li>
                       <li><a data-toggle="modal" data-target="#trackOrder" style="cursor: pointer">Order Tracking</a></li>
                       <li><a href="{{route('account-quotation')}}">Quotation</a></li>
                       <li><a href="{{route('blog_page')}}">Blog</a></li>
                       
                   </ul>
               </div>
               <div class="col-6 col-sm-6 col-md-3">
                   <h5 class="multiple">Download Our App</h5>
                   <a class="app-link" href="#">
                       <img src="{!! asset('/assets/frontendv2/img/icons/footer/play-store.svg') !!}" alt="playstore-icon" style="border-radius: 5px!important;">
                   </a>
                   <a class="app-link" href="#">
                       <img src="{!! asset('/assets/frontendv2/img/icons/footer/app-store.svg') !!}" alt="appstore-icon">
                   </a>
                   <h5 class="multiple">Newsletter</h5>
                   <form action="{{ route('subscription') }}" method="post">
                       @csrf
                         <div class="input-group mb-4">
                             <input type="email" class="form-control" name="subscription_email" placeholder="Enter your email address" aria-label="Enter your email address" aria-describedby="button-addon2" required>
                             <button class="btn btn-brand" type="submit" id="button-addon2"><span class="md-none">{{\App\CPU\translate('subscribe')}}</span><img src="{!! asset('/assets/frontendv2/img/icons/footer/send.png') !!}" class="dd-none"></button>
                         </div>
                   </form>
                   <h5 class="multiple">Payment Options</h5>
                   <img src="{!! asset('/assets/frontendv2/img/icons/footer/payment-links.svg') !!}" alt="payment-links">
               </div>
           </div>
       </div>
   </div>
   <div class="footer-copyright">
       <div class="container">
           <div class="row">
               <div class="col-12 text-center">
                   <p class="m-0">Copyright © {{date('Y')}}  <span></span>. All Right Reserved.</p>
               </div>
           </div>
       </div>
   </div>
</footer>