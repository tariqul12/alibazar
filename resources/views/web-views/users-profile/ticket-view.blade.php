@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Support Ticket'))

@push('css_or_js')
    <style>
        .headerTitle {
            font-size: 24px;
            font-weight: 600;
            margin-top: 1rem;
        }

        body {
            font-family: 'Titillium Web', sans-serif
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .font-nameA {
            font-weight: 600;
            display: inline-block;
            margin-bottom: 0;
            font-size: 17px;
            color: #030303;
        }

        .spandHeadO {
            color: #FFFFFF !important;
            font-weight: 600 !important;
            font-size: 14px !important;

        }
        
        
        .tdBorder {
            border-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 1px solid #f7f0f0;
            text-align: center;
        }

        .bodytr {
            border: 1px solid #dadada;
            text-align: center;
        }

        .sellerName {
            font-size: 15px;
            font-weight: 600;
        }

        .modal-footer {
            border-top: none;
        }

        .sidebarL h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}}                !important;
            transition: .2s ease-in-out;
        }

        .marl {
            margin-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 7px;
        }
        .badge-warning{
            color:white;
            background: {{$web_config['primary_color']}};

        }
        .badge-secondary{
            color:white;
            background: {{$web_config['secondary_color']}};
        }
        .badge-success {

        }

         .for-margin-sms{
            margin-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 56.3333333333%;
         }
         @media(max-width:475px){
            .for-margin-sms {
            margin-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 0.333333%;
           }
         }
        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{$web_config['primary_color']}}
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
    <div class="container rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9 sidebar_heading">
               
            </div>
        </div>
    </div>
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-3 rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <!-- Sidebar-->
      
        <!-- Content  -->
            <section class="col-lg-12">
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
                                  <h1 class="h3  mb-0 float-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} headerTitle">{{\App\CPU\translate('Support Ticket Answer')}}</h1>
                        <!-- Toolbar-->
                                    <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-4">
                                        <div class="d-flex text-light text-center {{Session::get('direction') === "rtl" ? 'ml-3' : 'mr-3'}}">
                                            <div class="font-size-ms px-3">
                                                <div class="font-weight-medium text-dark">{{\App\CPU\translate('Date Submitted')}}</div>
                                                <div style="color:#000!important;">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['created_at'])->format('Y-m-d')}}</div>
                                            </div>
                                            <div class="font-size-ms px-3">
                                                <div class="font-weight-medium text-dark">{{\App\CPU\translate('Last Updated')}}</div>
                                                <div style="color:#000!important;">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['updated_at'])->format('Y-m-d')}}</div>
                                            </div>
                                            <div class="font-size-ms px-3">
                                                <div class="font-weight-medium text-dark">{{\App\CPU\translate('Type')}}</div>
                                                <div style="color:#000!important;">{{$ticket['type']}}</div>
                                            </div>
                                            <div class="font-size-ms px-3">
                                                <div class="font-weight-medium text-dark" style="color:black">{{\App\CPU\translate('Priority')}}</div>
                                                <span class="badge badge-warning">{{$ticket['priority']}}</span>
                                            </div>
                                            <div class="font-size-ms px-3">
                                                <div class="font-weight-medium" style="color: black">{{\App\CPU\translate('Status')}}</div>
                                                @if($ticket['status']=='open')
                                                    <span class="badge badge-secondary">{{$ticket['status']}}</span>
                                                @else
                                                    <span class="badge badge-secondary">{{$ticket['status']}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Ticket details (visible on mobile)-->
                                    <div class="d-flex d-lg-none flex-wrap text-center rounded-lg pt-4 px-4 pb-1 mb-4">
                                        <div class="font-size-sm px-3 pb-3">
                                            <div class="font-weight-medium">{{\App\CPU\translate('Date Submitted')}}</div>
                                            <div
                                                class="text-muted">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['created_at'])->format('Y-m-d')}}</div>
                                        </div>
                                        <div class="font-size-sm px-3 pb-3">
                                            <div class="font-weight-medium">{{\App\CPU\translate('Last Updated')}}</div>
                                            <div
                                                class="text-muted">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['updated_at'])->format('Y-m-d')}}</div>
                                        </div>
                                        <div class="font-size-sm px-3 pb-3">
                                            <div class="font-weight-medium">{{\App\CPU\translate('Type')}}</div>
                                            <div class="text-muted">{{$ticket['type']}}</div>
                                        </div>
                                        <div class="font-size-sm px-3 pb-3">
                                            <div class="font-weight-medium">{{\App\CPU\translate('Priority')}}</div>
                                            <span class="badge badge-warning">{{$ticket['priority']}}</span>
                                        </div>
                                        <div class="font-size-sm px-3 pb-3">
                                            <div class="font-weight-medium">{{\App\CPU\translate('Status')}}</div>
                                            @if($ticket['status']=='open')
                                                <span class="badge btn btn-secondary">{{$ticket['status']}}</span>
                                            @else
                                                <span class="badge btn btn-secondary">{{$ticket['status']}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Comment-->
                    
                                    {{-- <div class="media pb-4" style="text-align: right;">
                    
                                    </div> --}}
                                    <div class="col-sm-6 col-lg-5" style="padding-left: 20px;display:flex;">
                                        <img class="rounded-circle" style="text-align: {{Session::get('direction') === "rtl" ? 'left' : 'right'}}; text-align: right;height:40px;width:40px;float: left;margin-right: 10px;"
                                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                             src="{{asset('storage/app/public/profile')}}/{{auth('customer')->user()->image}}"
                                             alt="{{auth('customer')->user()->f_name}}"/>
                                        <div class="media-body">
                                            <h6 class="font-size-md mb-2">{{auth('customer')->user()->f_name}}</h6>
                                            <p class="font-size-md mb-1">{{$ticket['description']}}</p>
                                            <span class="font-size-ms text-muted" style="color: #e9611e!important;font-weight: 600;">
                                                     <i class="czi-time align-middle {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}"></i>
                                                {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['created_at'])->format('Y-m-d h:i A')}}
                                            </span>
                                        </div>
                                    </div>
                                    @foreach($ticket->conversations as $conversation)
                    {{--                    {{dd($conversation)}}--}}
                                        @if($conversation['customer_message'] == null )
                                            <div class="media">
                                                <div class="media-body {{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-4'}}">
                                                    @php($admin=\App\Model\Admin::where('id',$conversation['admin_id'])->first())
                                                    <h6 class="font-size-md mb-2">{{$admin['name']}}</h6>
                                                    <p class="font-size-md mb-1">{{$conversation['admin_message']}}</p>
                                                    <span
                                                        class="font-size-ms text-muted"> {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$conversation['updated_at'])->format('Y-m-d h:i A')}}</span>
                                                </div>
                                            </div>
                                        @endif
                                        @if($conversation['admin_message'] == null)
                                            <div class="col-sm-6 col-lg-5 media pb-4 for-margin-sms" style="">
                                                <img class="rounded-circle" height="40" width="40"
                                                     onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                     src="{{asset('storage/app/public/profile')}}/{{auth('customer')->user()->image}}"
                                                     alt="{{auth('customer')->user()->f_name}}"/>
                                                <div class="media-body {{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}}">
                                                    <h6 class="font-size-md mb-2">{{auth('customer')->user()->f_name}}</h6>
                                                    <p class="font-size-md mb-1">{{$conversation['customer_message']}}</p>
                                                    <span class="font-size-ms text-muted">
                                                                 <i class="czi-time align-middle {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}"></i>
                                                        {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$conversation['created_at'])->format('Y-m-d h:i A')}}
                                                    </span>
                                                </div>
                                            </div>
                                    @endif
                                @endforeach
                                <!-- Leave message-->
                                    <div class="col-sm-12" style="padding:20px">
                                        <h3 class="h5">{{\App\CPU\translate('Leave a Message')}}</h3>
                                        <form class="needs-validation" href="{{route('support-ticket.comment',[$ticket['id']])}}"
                                              method="post" novalidate>
                                            @csrf
                                            <div class="form-group">
                                                <textarea class="form-control" name="comment" rows="4"
                                                          placeholder="{{\App\CPU\translate('Write your message here...')}}" required></textarea>
                                                <div class="invalid-tooltip">{{\App\CPU\translate('Please write the message')}}!</div>
                                            </div>
                                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                <div class="">
                                                    <a href="{{route('support-ticket.close',[$ticket['id']])}}" class="dashboard-track-order"
                                                       style="color: white">{{\App\CPU\translate('close')}}</a>
                                                </div>
                                                <button class="profile-update-btn" type="submit">{{\App\CPU\translate('Submit message')}}</button>
                                            </div>
                                        </form>
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

@endpush
