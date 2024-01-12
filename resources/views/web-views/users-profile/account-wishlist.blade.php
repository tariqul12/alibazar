@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('My Wishlist'))

@push('css_or_js')
    <style>
        .headerTitle {
            font-size: 24px;
            font-weight: 600;
            margin-top: 1rem;
        }

        body {
            font-family: sans-serif !important;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{$web_config['primary_color']}};
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Page Title-->
    <!--<div class="container rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9 sidebar_heading">
                <h1 class="h3  mb-0 float-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} headerTitle">{{\App\CPU\translate('WISHLIST')}}</h1>
            </div>
        </div>
    </div>-->
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            
        <!-- Content  -->
            <section class="col-lg-12 col-md-12" id="set-wish-list">
                <div class="j-dashborder-border">
                    <h2 class="desk-account">My Account</h2>
                  <div id="navbar-wrapper">
                    <nav class="navbar navbar-inverse">
                        <div class="navbar-header">
                          <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
                        </div>
                    </nav>
                    <h2 class="mobile-account">My Account</h2>
                  </div>
                <div class="j-flex">

                      <aside id="wrapper">
                         @include('web-views.partials._profile-aside')
                      </aside>
                    
                      
                
                        <section id="content-wrapper">
                            <div class="row">
                                <div class="col-lg-12">
                                <div class="card box-shadow-sm dash-right-side">
                                    <h1 class="h3  mb-0 float-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} headerTitle">{{\App\CPU\translate('Wishlist')}}</h1>
                                @include('web-views.partials._wish-list-data',['wishlists'=>$wishlists, 'brand_setting'=>$brand_setting])
                                </div>
                            
                             </div>
                          </div>
                      </section>
                    
                    </div>
                </div>
            </section>
        </div>
    </div>
    
<script>
    const $button  = document.querySelector('#sidebar-toggle');
    const $wrapper = document.querySelector('#wrapper');
    
    $button.addEventListener('click', (e) => {
      e.preventDefault();
      $wrapper.classList.toggle('toggled');
    });
</script>

@endsection

@push('script')

@endpush
