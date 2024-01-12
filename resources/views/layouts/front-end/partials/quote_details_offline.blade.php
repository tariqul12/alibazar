@extends('layouts.front-end.app')
@section('title', \App\CPU\translate('Login'))
@push('css_or_js')
    <style>
        .title {
            margin-bottom: 5vh;
        }

        .card {
            margin: auto;
            max-width: 950px;
            width: 90%;
            box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 1rem;
            border: transparent;
        }

        @media(max-width:767px) {
            .card {
                margin: 3vh auto;
            }
        }

        .cart {
            background-color: #fff;
            padding: 4vh 5vh;
            border-bottom-left-radius: 1rem;
            border-top-left-radius: 1rem;
        }

        @media(max-width:767px) {
            .cart {
                padding: 4vh;
                border-bottom-left-radius: unset;
                border-top-right-radius: 1rem;
            }
        }

        .summary {
            background-color: #ddd;
            border-top-right-radius: 1rem;
            border-bottom-right-radius: 1rem;
            padding: 4vh;
            color: rgb(65, 65, 65);
        }

        @media(max-width:767px) {
            .summary {
                border-top-right-radius: unset;
                border-bottom-left-radius: 1rem;
            }
        }

        .summary .col-2 {
            padding: 0;
        }

        .summary .col-10 {
            padding: 0;
        }

        .row {
            margin: 0;
        }

        .title b {
            font-size: 1.5rem;
        }

        .main {
            margin: 0;
            padding: 2vh 0;
            width: 100%;
        }

        .col-2,
        .col {
            padding: 0 1vh;
        }

        /*a {
            padding: 0 1vh;
        }*/

        .close {
            margin-left: auto;
            font-size: 0.7rem;
        }

        .back-to-shop {
            margin-top: 4.5rem;
        }

        h5 {
            margin-top: 4vh;
        }

        hr {
            margin-top: 1.25rem;
        }

        select {
            border: 1px solid rgba(0, 0, 0, 0.137);
            padding: 1.5vh 1vh;
            margin-bottom: 4vh;
            outline: none;
            width: 100%;
            background-color: rgb(247, 247, 247);
        }

        a {
            color: black;
        }

        a:hover {
            color: black;
            text-decoration: none;
        }

        #code {
            background-image: linear-gradient(to left, rgba(255, 255, 255, 0.253), rgba(255, 255, 255, 0.185)), url("https://img.icons8.com/small/16/000000/long-arrow-right.png");
            background-repeat: no-repeat;
            background-position-x: 95%;
            background-position-y: center;
        }
    </style>
@endpush
@php
    use Illuminate\Support\Facades\DB;
    $quotation = DB::table('quote_cart')
        ->join('products', 'products.id', '=', 'quote_cart.product_id')
        ->where('reference_no',session('quote_data'))
        ->select('products.*', 'quote_cart.total_qty','quote_cart.id as quote_id', 'quote_cart.total_price', 'quote_cart.shipping_cost','quote_cart.product_id')
        ->get();
@endphp
@section('content')
    <br>
    <style>
.quotation-tab{
    color:#000!important;
}


.nav-tabs .quotation-tab.active {
    color: #f3f3f3;
    background-color: #fff;
    border-color: gray!important;
    font-size: 14px;
    margin-bottom: 1px;
}

    </style>
    
    
    
    
    
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link quotation-tab active" data-toggle="tab" href="#tabs-1" role="tab">Quotation</a>
                    </li>
                <!--    <li class="nav-item">
                        <a class="nav-link quotation-tab" data-toggle="tab" href="#tabs-2" role="tab">Save Quotation</a>
                    </li>-->
                    
                </ul><!-- Tab panes -->
                <div class="tab-content quotation-content">
                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                         <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                              <tr>
                                <th>Item</th>
                                <th style="text-align: center;">Quantity</th>
                                <th style="text-align: center;">Unit Price (Inclusive of VAT)</th>
                                <th style="text-align: center;">Total Price (Inclusive of VAT)</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_shipping = 0;
                                    $total_price = 0;
                                @endphp
                                @foreach ($quotation as $row)
                                @php
                                 if($row->discount_type=='percent')
                                    {
                                        $discount=($row->unit_price*($row->discount/100));
                                    }
                                    else{
                                        $discount=$row->discount;
                                    }
                                 @endphp
                              <tr>
                                <td width="40%">
                                    <div class="quotation-table-box">
                                        <div class="quotation-table-img">
                                            <img class="img-fluid" src="{{ \App\CPU\ProductManager::product_image_path('thumbnail') }}/{{ $row->thumbnail }}">
                                        </div>
                                        <div class="quotation-table-pro-name">
                                            <a href="{{ route('frontend.product_details', $row->slug) }}">{{ $row->name }}</a>
                                        </div>
                                        <button class="btn btn-link px-0 text-danger" onclick="removeFromQuote({{ $row->quote_id }})" type="button"><i class="czi-close-circle mr-2"></i>Remove</button>
                                    </div>
                                </td>
                                <td>
                                    <div class="quotaion-update-box">
                                    <div class="spinbutton-wrapper spinbutton-wrapper1">
                                        <div class="spinbutton" style="display: flex;">
                                            <button class="minus" type="button" onclick="updateQuoteItemDecrease('1', '{{$row->quote_id}}')">-</button>
                                            <input style="width: 75px;min-height: 26px;" class="val" type="number" name="quantity[{{ $row->quote_id }}]" id="quoteQuantity{{$row->quote_id}}"
                                            onkeyup="updateQuoteQuantity('1', '{{$row->quote_id}}')" min="1" value="{{$row->total_qty}}">
                                            <button class="plus" type="button" onclick="updateQuoteItemAdd('1', '{{$row->quote_id}}')">+</button>
                                        </div>
                                    </div>
                                    </div>
                                </td>
                                <td>
                                    {{-- <form id="add-to-cart-form-{{ $row->product_id }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $row->product_id }}"> --}}
                                    <div class="quotation-Price">
                                        <p>Tk. {{ round(($row->unit_price-$discount),2) }}</p>
                                        {{-- <input type="hidden" name="quantity" value="1">
                                        <a href="javascript:void(0)" class="quo-price-update" onclick="addToCart({{ $row->product_id }})"><i class="navbar-tool-icon czi-cart"></i> MOVE TO CART</a> --}}
                                    </div>
                                    </form>
                                </td>  
                                <td>
                                    <form id="add-to-cart-form-{{ $row->product_id }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $row->product_id }}">
                                    <div class="quotation-Price">
                                        <p id="total_price">Tk. {{ round((($row->unit_price-$discount)*$row->total_qty),2) }}</p>
                                        <input type="hidden" name="quantity" value="1">
                                        <a href="javascript:void(0)" class="quo-price-update" onclick="addToCart({{ $row->product_id }})"><i class="navbar-tool-icon czi-cart"></i> MOVE TO CART</a>
                                    </div>
                                    </form>
                                </td>  
                              </tr>
                              @php
                              $total_price += $row->total_price-($discount*$row->total_qty);
                              $total_shipping += $row->shipping_cost;
                          @endphp
                      @endforeach
                            </tbody>
                          </table>
                          <div class="quo-final-price-box">
                              <div class="row">
                                  <div class="col-md-6">
                                      {{-- <div class="quo-qupon">
                                          <div class="input-group mb-3">
                                              <input type="text" class="form-control" placeholder="Enter Coupon Code" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                              <div class="input-group-append">
                                                <button class="btn btn-outline-secondary cupon-btn" type="button">Apply</button>
                                              </div>
                                            </div>
                                            
                                      </div> --}}
                                  </div>
                                  <div class="col-md-6">
                                      <div class="quo-final-price-text">
                                          {{-- <p>Amount: Tk.{{ $total_price }}</p> --}}
                                          {{-- <p class="shipping-color">Shipping Charge: {{ $total_shipping }}</p> --}}
                                          <h4>Total Price: Tk. {{ round($total_price,2)}}</h4>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="quo-final-price-bottom">
                              <div class="row">
                                  <div class="col-md-7">
                                      <div class="row">
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="j-specification-card quo-card">
                                                <img src="https://malamal.com.bd/public/assets/front-end/img/orgIcon_new.svg" alt="icon-telephone">
                                                <div class="j-spect-cont">
                                                    <h5>100% ORIGINAL</h5>
                                                    <p>Products</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="j-specification-card quo-card">
                                                <img src="https://malamal.com.bd/public/assets/front-end/img/proIcon_new.svg" alt="icon-telephone">
                                                <div class="j-spect-cont">
                                                    <h5>SECURE</h5>
                                                    <p>Payments</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="j-specification-card quo-card">
                                                <img src="https://malamal.com.bd/public/assets/front-end/img/secureIcon_new.svg" alt="icon-telephone">
                                                <div class="j-spect-cont">
                                                    <h5>100% BUYER</h5>
                                                    <p>Protection</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="j-specification-card quo-card">
                                                <img src="https://malamal.com.bd/public/assets/front-end/img/ibreward-icon-header.webp" alt="icon-telephone">
                                                <div class="j-spect-cont">
                                                    <h5>EARN</h5>
                                                    <p>Reward Points</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-5">
                                      <div class="quotation-back-btn">
                                          <a href="{{ route('home') }}" class="continue-shop-btn">← Back to shop</a>
                                          <a href="{{ route('quote_contact') }}" class="btn btn--primary btn-shadow">Get Quotation</a>
                                      </div>
                                  </div>
                              </div>
                              
                            
                            
                          </div>
                    </div>
                    <!--<div class="tab-pane" id="tabs-2" role="tabpanel">
                        <p>Second Panel</p>
                    </div>-->
                    
                </div>
            </div>
            <div class="col-md-12">
                <div class="cart-need">
                        <p><span class="need-color">Need help? Please visit</span><a href=""> Help center</a> <span class="need-color">or</span> <a href="{{route('contacts')}}">Contact us</a></p>
                    </div>
            </div>
        </div>
    </div>
    <br>

@endsection