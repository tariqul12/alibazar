@extends('layouts.front-end.app')
@section('title', \App\CPU\translate('Quotation'))
@push('css_or_js')

    <style>
.fa-check{
    font-size: 40px;
    background: green;
    padding: 20px;
    border-radius: 69px;
    color: #fff;
    font-weight: bold;
    width: 50px;
    height: 50px;
} 
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="quot-succe-box">
                    <h1>The Quotation has been mailed to you successfully.</h1>
                    <i class="fa-solid fa-check"></i>
                    <h2>Thank you for your interest!</h2>
                    <p>Please check you inbox or account dashboard. If you did not find the quotation in your inbox, </br> Please check your spam folder Or, please contact our hotline.</.br> </p>
                    <a href="{{url('')}}" class="succs-go-btn">Go to shopping</a>
                </div>
            </div>
        </div>
    </div>
@endsection