@extends('layouts.front-end.app')
@section('content')

<div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-10">
                    <div class="">
                    <div class="box-shadow-sm dash-right-side">
                        <div class="card-header">
                            
                             <form class="mt-3" action="{{route('customer.quote_store')}}" method="post" enctype="multipart/form-data">
                                <div class="row photoHeader">
                                    @csrf
                                    <div class="card-body mt-md-3" style="padding: 0px;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="contact_information_box">
                                                    <h3 class="font-nameA contact_info">{{\App\CPU\translate('contact_information')}} </h3>
                                                    <p class="contact_info-p">Enter your contact information and we will mail you the quotation on the email-id provided by you.
                                                    You can also provide email-id of the approver to whom you want to mail this quotation for approval.</p>
                                                    <a href="{{route('quote-cart')}}" class="back-quotation">← Back to Quotation</a>
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
                                                                    <input type="text" class="form-control contact_info-input" id="f_name" name="f_name" placeholder="First Name" value="{{  auth('customer')->user()->f_name ?? '' }}" required>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <!--<label for="lastName"> {{\App\CPU\translate('last_name')}} </label>-->
                                                                    <input type="text" class="form-control contact_info-input" id="l_name" name="l_name" value="{{  auth('customer')->user()->l_name ?? '' }}" placeholder="Last Name"
                                                                          >
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <!--<label for="inputEmail4">{{\App\CPU\translate('Email')}} </label>-->
                                                                    <input type="email" class="form-control contact_info-input" name="email" id="account-email" placeholder="Email" value="{{  auth('customer')->user()->email ?? '' }}"  required>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <!--<label for="phone">{{\App\CPU\translate('phone_number')}} </label>-->
                                                                    <input type="number" class="form-control contact_info-input" type="text" id="phone"
                                                                           name="phone" placeholder="Phone" value="{{  auth('customer')->user()->phone ?? '' }}"  required>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <!--<label for="inputEmail4">{{\App\CPU\translate('Company')}} </label>-->
                                                                    <input type="text" class="form-control contact_info-input" name="company" id="account-email"
                                                                    placeholder="Company"   required>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <!--<label for="phone">{{\App\CPU\translate('State')}} </label>-->
                                                                    
                                                                    <textarea name="address" class="form-control contact_info-input-address" id="" cols="100" rows="3" required placeholder="Address"></textarea>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <!--<label for="inputEmail4">{{\App\CPU\translate('Industry Type')}} </label>-->
                                                                    <input type="text" class="form-control contact_info-input" name="industry" id="account-email"
                                                                    placeholder="Industry"   required>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <!--<label for="phone">{{\App\CPU\translate('City')}} </label>
                                                                    </label>-->
                                                                    <input type="text" class="form-control contact_info-input" name="city" id="account-email" placeholder="City" required>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12">
                                                                    <!--<label for="inputEmail4">{{\App\CPU\translate('Industry Type')}} </label>-->
                                                                    <input type="text" class="form-control contact_info-input" name="send_mail" id="account-email"
                                                                    placeholder="Email to whom you want to send the quotation(Optional)">
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                <!--<label for="inputEmail4">{{\App\CPU\translate('Comments')}} </label>-->
                                                                 <textarea name="comments" class="form-control contact_info-input" id="" cols="100" placeholder="Comments (Optional)" rows="3"></textarea>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <select class="form-control border-radius" name="vat_app" id="vat_app">
                                                                        <option value="0">{{ \App\CPU\translate('Without_Vat')}}</option>
                                                                        <option value="1">{{ \App\CPU\translate('With_Vat')}}</option>
                                                                       
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn--primary float-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">{{\App\CPU\translate('Generate Quotation')}} </button>
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

   <!-- <section class="col-lg-12 col-md-12">
        <div class="j-dashborder-border">
        <div class="card box-shadow-sm dash-right-side">
            <div class="card-header">
                
                <form class="mt-3" action="{{route('customer.quote_store')}}" method="post"
                      enctype="multipart/form-data">
                    <div class="row photoHeader">
                        @csrf
                        <div class="card-body mt-md-3" style="padding: 0px;">
                            <h3 class="font-nameA">{{\App\CPU\translate('contact_information')}} </h3>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="firstName">{{\App\CPU\translate('first_name')}} </label>
                                    <input type="text" class="form-control" id="f_name" name="f_name" placeholder="First Name" value="{{  auth('customer')->user()->f_name ?? '' }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lastName"> {{\App\CPU\translate('last_name')}} </label>
                                    <input type="text" class="form-control" id="l_name" name="l_name" value="{{  auth('customer')->user()->l_name ?? '' }}" placeholder="Last Name"
                                          >
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">{{\App\CPU\translate('Email')}} </label>
                                    <input type="email" class="form-control" name="email" id="account-email" placeholder="Email" value="{{  auth('customer')->user()->email ?? '' }}"  required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone">{{\App\CPU\translate('phone_number')}} </label>
                                    <input type="number" class="form-control" type="text" id="phone"
                                           name="phone" placeholder="Phone" value="{{  auth('customer')->user()->phone ?? '' }}"  required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">{{\App\CPU\translate('Company')}} </label>
                                    <input type="text" class="form-control" name="company" id="account-email"
                                    placeholder="Company"   required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone">{{\App\CPU\translate('State')}} </label>
                                    </label>
                                    <input type="text" class="form-control" name="state" id="account-email" placeholder="state" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">{{\App\CPU\translate('Industry Type')}} </label>
                                    <input type="text" class="form-control" name="industry" id="account-email"
                                    placeholder="Industry"   required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone">{{\App\CPU\translate('City')}} </label>
                                    </label>
                                    <input type="text" class="form-control" name="city" id="account-email" placeholder="City" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                <label for="inputEmail4">{{\App\CPU\translate('Comments')}} </label>
                                 <textarea name="comments" class="form-control" id="" cols="100" rows="3"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn--primary float-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">{{\App\CPU\translate('Generate Quotation')}} </button>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </section>-->

@endsection