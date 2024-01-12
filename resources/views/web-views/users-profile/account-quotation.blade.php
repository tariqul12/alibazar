@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('my_Quotation'))

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
            color: #000 !important;
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
            border-bottom: 3px solid {{$web_config['primary_color']}}                                   !important;
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
        
        
       
    </style>
@endpush
@php
    use Illuminate\Support\Facades\DB;
    $user_data = DB::table('users')
        ->where('id', auth('customer')->id())
        ->first();
@endphp
@section('content')

  <!--  <div class="container rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9 mt-2 sidebar_heading">
                
            </div>
        </div>
    </div>-->

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <!-- Sidebar-->
        
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
                    <h1 class="h3 float-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} headerTitle">{{\App\CPU\translate('my_Quotation')}}</h1>
                    <div class="form-group" align="right">

                       <a class="upload-faq-btn" href="{{ route('quote_rfq_contact') }}"><i class="fa-solid fa-upload"></i> Upload RFQ?</a>
                    </div>
                    <div style="overflow: auto;padding:20px">
                        <table class="table mobile-table">
                            <thead>
                                <tr>
                                    <td class="tdBorder">
                                        <div class="py-2"><span
                                                class="d-block spandHeadO ">{{ \App\CPU\translate('Reference#') }}</span>
                                        </div>
                                    </td>

                                    <td class="tdBorder">
                                        <div class="py-2"><span
                                                class="d-block spandHeadO">{{ \App\CPU\translate('Date') }}</span>
                                        </div>
                                    </td>
                                    <td class="tdBorder">
                                        <div class="py-2"><span class="d-block spandHeadO">
                                                {{ \App\CPU\translate('customer') }}</span></div>
                                    </td>
                                    <td class="tdBorder">
                                        <div class="py-2"><span class="d-block spandHeadO">
                                                {{ \App\CPU\translate('grand total') }}</span></div>
                                    </td>
                                    <td class="tdBorder">
                                        <div class="py-2"><span class="d-block spandHeadO">
                                                {{ \App\CPU\translate('Status') }}</span></div>
                                    </td>
                                    <td class="tdBorder">
                                        <div class="py-2"><span class="d-block spandHeadO">
                                                {{ \App\CPU\translate('action') }}</span></div>
                                    </td>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($quotation as $quote)
                                    <tr>
                                        <td class="bodytr font-weight-bold">
                                            {{ $quote['reference_no'] }}
                                        </td>
                                        <td class="bodytr "><span
                                                class="">{{ date('d-M-Y', strtotime($quote['created_at'])) }}</span>
                                        </td>
                                        <td class="bodytr"><span class="">{{ $user_data->f_name }}</span>
                                        </td>
                                        <td class="bodytr"><span
                                                class="">{{\App\CPU\Helpers::currency_converter($quote['total_price']+$quote['total_vat'])}}</span></td>
                                        <td class="bodytr">
                                            @if ($quote['quotation_status'] == 1)
                                                <span class="badge badge-danger text-capitalize">
                                                    {{ \App\CPU\translate('pending') }}
                                                </span>
                                            @else
                                                <span class="badge badge-info text-capitalize">
                                                    {{ \App\CPU\translate('sent') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="bodytr">
                                            @if ($quote['quotation_status'] != 1)
                                                <a class="btn btn-info btn-sm" title="{{ \App\CPU\translate('view') }}"
                                                    href="{{ route('quotation-view', [$quote['id']]) }}" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                                                    <i class="tio-visible"></i>
                                                </a>
                                            
                                            {{-- <a class="btn btn-sm btn-warning" target="_blank" title="download_pdf"
                                                href="{{ route('quotation-download', [$quote['id']]) }}" data-toggle="tooltip" data-placement="top" title="Download"> <i
                                                    class="tio-download"></i></a> --}}
                                           
                                                <a class="btn btn-sm btn-warning" target="_blank" title="Quotation Download" role="button"
                                                href="{{ asset('storage/app/public/quotation/Quotation_'.$quote['id'].'.pdf') }}" data-toggle="tooltip" data-placement="top" title="Download"> 
                                                <i class="tio-download" download></i></a>
                                            @endif        
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                       

                       
                    </div>
                    @if($quotation->count()==0)
                    <div class="dashboard-emty-quotation">
                        <img src="{{asset('public/assets/front-end/img/icon/empty_quotation.svg')}}" alt="pay-later">
                        <p>You have not been able to set up any quotations till now</p>
                        <a href="{{url('/quote-cart')}}">Add new quotation</a>
                    </div>
                @endif
                <div class="card-footer">
                    {{$quotation->links()}}
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

