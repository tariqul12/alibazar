@extends('frontend.layouts.app')
@push('after-styles')

@endpush
@section('content')
    <div class="category-bar-container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="category-bar">
                        @if(count($categories))
                            @foreach($categories as $cat)
                                <div class="category">
                                    <img src="{{asset("storage/category/$cat->icon")}}" onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'" style="height: 10%; width: 10%;">
                                    <p class="category-title">{!! $cat->name !!}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container cart-page">
        <div class="row">
            <div class="col-12 col-lg-9">
                <div class="cart-view">
                    <div class="cart-header">
                        <p>Your Cart (1 item)</p>
                    </div>
                    <div class="items-in-cart">
                        <div class="header">
                            <div><span>Item</span></div>
                            <div class="quantity"><span>Quantity</span></div>
                        </div>
                        <div class="cart-item">
                            <div class="item-detail">
                                <img class="item-image" src="{!! asset('/assets/frontend/img/cart-item-image.png') !!}" alt="item-image">
                                <div class="item-info">
                                    <h5>Voltas pure magic double mount <br> air purifier</h5>
                                    <p><span>Size S</span></p>
                                    <div class="item-price">
                                        <div class="regular-price">
                                            <p>Rs 13980</p>
                                            <span>50% OFF !</span>
                                        </div>
                                        <div class="discounted-price">
                                            <p>Rs 6000</p>
                                            <span>You save Rs 6000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item-quantity">
                                <div class="spinbutton-wrapper">
                                    <div class="spinbutton">
                                        <button class="minus">-</button>
                                        <span class="val">1</span>
                                        <button class="plus">+</button>
                                    </div>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-link">SAVE</button>
                                    <button class="btn btn-sm btn-link" data-bs-toggle="modal" data-bs-target="#itemRemoveModal">REMOVE</button>
                                </div>
                            </div>
                        </div>
                        <div class="cart-action">
                            <button class="btn btn-brand">Place order</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-3">
                <div class="payment-summary">
                    <div class="heading">
                        <h5>Payment Summary</h5>
                    </div>
                    <div class="payment-breakdown">
                        <div class="item">
                            <span class="label">Item total</span>
                            <span class="amount">$499</span>
                        </div>
                        <div class="item">
                            <span class="label">Including Vat</span>
                            <span class="amount">$200</span>
                        </div>
                        <div class="item">
                            <span class="label">Shipping Charges</span>
                            <span class="amount positive">Free</span>
                        </div>
                        <div class="item total">
                            <span class="label">Total Price</span>
                            <span class="amount">$699</span>
                        </div>
                    </div>
                    <div class="footnote">
                        <p>
                            <img src="{!! asset('/assets/frontend/img/icons/shipment.svg') !!}" alt="shipment-icon"> Shipping charges applicable as per your pincode
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cart-page-footer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <p>
                            By clicking on the place order button you agree to Malmal.xyz’s <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>
                        </p>
                        <p>
                            <img src="{!! asset('/assets/frontend/img/icons/footer/payment-links.svg') !!}" alt="payment-logos">
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')

@endpush
