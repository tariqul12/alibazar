@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Dashboard'))

@push('css_or_js')
    <style>
        .widget-categories .accordion-heading > a:hover {
            color: #FFD5A4 !important;
        }

        .widget-categories .accordion-heading > a {
            color: #FFD5A4;
        }

        body {
            font-family: 'Titillium Web', sans-serif;
        }

        .card {
            border: none
        }

        .totals tr td {
            font-size: 13px
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .spandHeadO {
            color: #FFFFFF !important;
            font-weight: 600 !important;
            font-size: 14px;

        }

        .tdBorder {
            border- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 1px solid #f7f0f0;
            text-align: center;
        }

        .bodytr {
            text-align: center;
            vertical-align: middle !important;
        }

        .sidebar h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}}!important;
            transition: .2s ease-in-out;
        }

        tr td {
            padding: 10px 8px !important;
        }

        td button {
            padding: 3px 13px !important;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{$web_config['primary_color']}};
            }

            .orderDate {
                display: none;
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }
        
        .j-d-card i{
            font-size: 40px!important;
            background: red!important;
            padding: 17px 20px!important;
            border-radius: 50px!important;
            color: #fff!important;
        }
        .round{
    border: 1px solid #e9611e!important;
}


    </style>
@endpush

@section('content')

 <!--   <div class="container rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9 mt-2 sidebar_heading">
            </div>
        </div>
    </div>
-->
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            
        <!-- Content  -->
          <section class="col-lg-12 col-md-12">
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
                                <h1 class="h3 float-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} headerTitle">{{\App\CPU\translate('my_Deshboard')}}</h1>  
                            <div class="padding-top-2x mt-2 hidden-lg-up"></div>
                                <div  style="overflow: auto;padding:20px">
                                <div class="row u-d-d">
                                    <div class="col-md-4 col-6">
                                        <div class="card round j-round">
                                            <div class="card-body text-center j-dash-card">
                                                <div class="j-d-card">
                                                    <img src="https://mala.i2hostingsolution.net/public/assets/back-end/img/total-product.png" class="business-analytics__img" alt="">
                                                </div>
                                                <p class="mt-1">All Order</p>
                                                <h4><b>{{$all_order_count}}</b></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="card round j-round">
                                            <div class="card-body text-center j-dash-card">
                                                <div class="j-d-card">
                                                    <img width="30" src="https://mala.i2hostingsolution.net/public/assets/back-end/img/confirmed.png" alt="">
                                                </div>
                                                <p class="mt-1">Completed Order</p>
                                                <h4><b>{{$completed_order_count}}</b></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="card round j-round">
                                            <div class="card-body text-center j-dash-card">
                                                 <div class="j-d-card">
                                                    <img width="30" src="https://mala.i2hostingsolution.net/public/assets/back-end/img/packaging.png" alt="">
                                                </div>
                                                <p class="mt-1">Processing Order</p>
                                                <h4><b>{{$processing_order_count}}</b></h4>
                                            </div>
                                        </div>
                                    </div>
                
                
                                    <div class="col-md-4 col-6">
                                        <div class="card round j-round">
                                            <div class="card-body text-center j-dash-card">
                                                 <div class="j-d-card">
                                                    <img width="30" src="https://mala.i2hostingsolution.net/public/assets/back-end/img/canceled.png" alt="">
                                                </div>
                                                <p class="mt-1">Canceled Order</p>
                                                <h4><b>{{$canceled_order_count}}</b></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="card round j-round">
                                            <div class="card-body text-center j-dash-card">
                                                 <div class="j-d-card">
                                                    <img width="30" src="https://mala.i2hostingsolution.net/public/assets/back-end/img/pending.png" alt="">
                                                </div>
                                                <p class="mt-1">Pending Order</p>
                                                <h4><b>{{$pending_order_count}}</b></h4>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
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
    <script>
        function cancel_message() {
            toastr.info('{{\App\CPU\translate('order_can_be_canceled_only_when_pending.')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
@endpush
