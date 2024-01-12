@extends('layouts.front-end.app')
@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-10">
                    <div class="">
                    <div class="box-shadow-sm dash-right-side">
                        <div class="card-header">
                            
                            <form class="mt-3" action="{{ route('customer.quote_rfq_upload') }}" method="post"
                                  enctype="multipart/form-data">
                                <div class="row photoHeader">
                                    @csrf
                                    <div class="card-body mt-md-3" style="padding: 0px;">
                                        <h3 class="font-nameA upload-request">{{\App\CPU\translate('Request For Quotation')}} </h3>
                                        <div class="row">
                                            
                                            <div class="form-group col-md-4">
                                                <div class="form-group account-info-up">
                                                    <label>{{ \App\CPU\translate('RFQ File') }}</label>
                                                    <i class="dripicons-question" data-toggle="tooltip"
                                                        title="Onl pdf file is supported"></i>
                                                    <input type="file" name="document" class="form-control qotation-file" accept="application/pdf" required/>
                                                    @if ($errors->has('extension'))
                                                        <span>
                                                            <strong>{{ $errors->first('extension') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="j-quotation-bottom">
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <!--<label for="firstName">{{\App\CPU\translate('first_name')}} </label>-->
                                                                    <input type="text" class="form-control quotation_rfq-input" id="f_name" name="f_name" placeholder="First Name" value="{{  auth('customer')->user()->f_name ?? '' }}" required>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                   <!-- <label for="lastName"> {{\App\CPU\translate('last_name')}} </label>-->
                                                                    <input type="text" class="form-control quotation_rfq-input" id="l_name" name="l_name" value="{{  auth('customer')->user()->l_name ?? '' }}" placeholder="Last Name"
                                                                          >
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <!--<label for="inputEmail4">{{\App\CPU\translate('Email')}} </label>-->
                                                                    <input type="email" class="form-control quotation_rfq-input" name="email" id="account-email" placeholder="Email" value="{{  auth('customer')->user()->email ?? '' }}"  required>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <!--<label for="phone">{{\App\CPU\translate('phone_number')}} </label>-->
                                                                    <input type="number" class="form-control quotation_rfq-input" type="text" id="phone"
                                                                           name="phone" placeholder="Phone" value="{{  auth('customer')->user()->phone ?? '' }}"  required>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <!--<label for="inputEmail4">{{\App\CPU\translate('Company')}} </label>-->
                                                                    <input type="text" class="form-control quotation_rfq-input" name="company" id="account-email"
                                                                    placeholder="Company"   required>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                 
                                                                    <textarea name="address" class="form-control contact_info-input" id="" cols="100" rows="3" required placeholder="Address"></textarea>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                   <!-- <label for="inputEmail4">{{\App\CPU\translate('Industry Type')}} </label>-->
                                                                    <input type="text" class="form-control quotation_rfq-input" name="industry" id="account-email"
                                                                    placeholder="Industry"   required>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <!--<label for="phone">{{\App\CPU\translate('City')}} </label>
                                                                    </label>-->
                                                                    <input type="text" class="form-control quotation_rfq-input" name="city" id="account-email" placeholder="City" required>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12">
                                                                <!--<label for="inputEmail4">{{\App\CPU\translate('Comments')}} </label>-->
                                                                 <textarea name="comments" class="form-control" id="" cols="100" rows="3" placeholder="Comments (Optional)"></textarea>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn--primary q-submit float-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">{{\App\CPU\translate('Submit')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="j-qotation-footer-text">
                                                    <p>Need Help? We are here to help you!</p>
                                                    <ul>
                                                        <li><img src="/public/assets/frontendv2/img/icons/footer/phone.svg" alt="icon-telephone"> Helpline Number <a href="tel:+8801972525821">+8801972525821</a> (10AM - 7PM)</li>
                                                        <li><img src="/public/assets/frontendv2/img/icons/footer/email.svg" alt="icon-email"><a href="mailto:sales@malamal.com.bd"> sales@malamal.com.bd</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
               
            </div>
            
        </div>
    </div>
    
    

@endsection

