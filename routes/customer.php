<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

/*Auth::routes();*/

Route::get('authentication-failed', function () {
    $errors = [];
    array_push($errors, ['code' => 'auth-001', 'message' => 'Unauthorized.']);
    return response()->json([
        'errors' => $errors
    ], 401);
})->name('authentication-failed');

Route::group(['namespace' => 'Customer', 'prefix' => 'customer', 'as' => 'customer.'], function () {

    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('/code/captcha/{tmp}', 'LoginController@captcha')->name('default-captcha');
        Route::get('login', 'LoginController@login')->name('login');
        Route::post('login', 'LoginController@submit');
        Route::post('login-otp', 'LoginController@login_otp_send')->name('login-otp');
        Route::post('review-login-otp', 'LoginController@review_login_otp_send')->name('review-login-otp');
        Route::post('review-login-submit', 'LoginController@review_login_submit')->name('review_login_submit');
        Route::post('login-submit', 'LoginController@login_with_otp')->name('login_with_otp');
        Route::post('login-signup-submit', 'LoginController@login_for_signup_otp')->name('login_for_signup_otp');
        Route::get('logout', 'LoginController@logout')->name('logout');
        Route::post('resend-otp', 'LoginController@resend_otp')->name('resend_otp');
        Route::get('sign-up', 'RegisterController@register')->name('sign-up');
        Route::post('sign-up', 'RegisterController@submit');
        Route::post('email-verify', 'LoginController@email_verify')->name('email-verify');
        Route::get('check/{id}', 'RegisterController@check')->name('check');

        Route::post('verify', 'RegisterController@verify')->name('verify');

        Route::get('update-phone/{id}', 'SocialAuthController@editPhone')->name('update-phone');
        Route::post('update-phone/{id}', 'SocialAuthController@updatePhone');

        Route::get('login/{service}', 'SocialAuthController@redirectToProvider')->name('service-login');
        Route::get('login/{service}/callback', 'SocialAuthController@handleProviderCallback')->name('service-callback');

        Route::get('recover-password', 'ForgotPasswordController@reset_password')->name('recover-password');
        Route::post('forgot-password', 'ForgotPasswordController@reset_password_request')->name('forgot-password');
        Route::get('otp-verification', 'ForgotPasswordController@otp_verification')->name('otp-verification');
        Route::post('otp-verification', 'ForgotPasswordController@otp_verification_submit');
        Route::get('reset-password', 'ForgotPasswordController@reset_password_index')->name('reset-password');
        Route::post('reset-password', 'ForgotPasswordController@reset_password_submit');
    });

    Route::group(['prefix' => 'payment-mobile'], function () {
        Route::get('/', 'PaymentController@payment')->name('payment-mobile');
    });
    Route::get('/quotation_success', 'QuotationController@successQuote')->name('quotation_success');
    Route::get('/quotation_rfq_success', 'QuotationController@successRfqQuote')->name('quotation_rfq_success');
    Route::post('quote_store', 'QuotationController@quote_store')->name('quote_store');
    Route::post('quote_upload', 'QuotationController@quotation_upload')->name('quote_upload');
    Route::post('quote_rfq_upload', 'QuotationController@quotation_rfq_upload')->name('quote_rfq_upload');
    Route::post('quote_remove', 'QuotationController@removeFromQuote')->name('quote_remove');
    Route::post('updateQuantity', 'QuotationController@updateQuantity')->name('updateQuantity');
    Route::post('product_variation', 'QuotationController@product_variation')->name('product_variation');
    Route::post('product_wholesale', 'QuotationController@product_wholesale')->name('product_wholesale');

    Route::post('request_call_back', 'QuotationController@request_call_back')->name('request_call_back');
    Route::post('ask_question', 'QuotationController@ask_question')->name('ask_question');
    Route::post('shipping_address_add', 'SystemController@shipping_address_add')->name('shipping_address_add');
    Route::post('billing_address_add', 'SystemController@billing_address_add')->name('billing_address_add');
    Route::group([], function () {
        Route::get('set-payment-method/{name}', 'SystemController@set_payment_method')->name('set-payment-method');
        Route::get('set-shipping-method', 'SystemController@set_shipping_method')->name('set-shipping-method');
        Route::post('choose-shipping-address', 'SystemController@choose_shipping_address')->name('choose-shipping-address');
        Route::post('choose-billing-address', 'SystemController@choose_billing_address')->name('choose-billing-address');
        Route::post('emi_details', 'SystemController@emi_details')->name('emi_details');
        Route::group(['prefix' => 'reward-points', 'as' => 'reward-points.', 'middleware' => ['auth:customer']], function () {
            Route::get('convert', 'RewardPointController@convert')->name('convert');
        });
    });
});
