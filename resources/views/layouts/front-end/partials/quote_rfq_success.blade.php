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
                    <!--<h1>Thank you for submitting your RFQ .</h1>-->
                    <i class="fa-solid fa-check"></i>
                    <h2>Thank you for your interest!</h2>
                    <p>We have received your RFQ (Request for Quotation) and will provide a quotation as soon as possible via email.</p>
                    <a href="{{url('')}}" class="succs-go-btn">Go to shopping</a>
                </div>
            </div>
        </div>
    </div>
@endsection