<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('clear-all',function(){
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('config:cache');
        \Illuminate\Support\Facades\Artisan::call('clear-compiled');
        \Illuminate\Support\Facades\Artisan::call('route:clear');

        dd("Project Cache Clear");
    });

    Route::get('test-areas', function (){
        $redexService = new \App\Services\parcels\RedxService();
        $redexData = $redexService->trackParcel("20A316MOG0DI");
        dd($redexData);
    });
    Route::get('/', function (){
        return redirect()->route('admin.auth.login');
    });

    /*authentication*/
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('/code/captcha/{tmp}', 'LoginController@captcha')->name('default-captcha');
        Route::get('login', 'LoginController@login')->name('login');
        Route::post('login', 'LoginController@submit')->middleware('actch');
        Route::get('logout', 'LoginController@logout')->name('logout');
    });

    /*authenticated*/
    Route::group(['middleware' => ['admin']], function () {

        //dashboard routes
        Route::get('/', 'DashboardController@dashboard')->name('dashboard');//previous dashboard route
        Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
            Route::get('/', 'DashboardController@dashboard')->name('index');
            Route::post('order-stats', 'DashboardController@order_stats')->name('order-stats');
            Route::post('business-overview', 'DashboardController@business_overview')->name('business-overview');
            Route::get('earning-statistics', 'DashboardController@get_earning_statitics')->name('earning-statistics');
        });
        //system routes
        Route::get('import-search-function-data', 'SystemController@importSearchFunctionData')->name('import-search-function-data');
        Route::get('search-function', 'SystemController@search_function')->name('search-function');
        Route::get('maintenance-mode', 'SystemController@maintenance_mode')->name('maintenance-mode');
        Route::get('/get-order-data', 'SystemController@order_data')->name('get-order-data');

        Route::group(['prefix' => 'custom-role', 'as' => 'custom-role.','middleware'=>['module:user_section']], function () {
            Route::get('create', 'CustomRoleController@create')->name('create');
            Route::post('create', 'CustomRoleController@store')->name('store');
            Route::get('update/{id}', 'CustomRoleController@edit')->name('update');
            Route::post('update/{id}', 'CustomRoleController@update');
            Route::post('employee-role-status','CustomRoleController@employee_role_status_update')->name('employee-role-status');
            Route::get('export', 'CustomRoleController@export')->name('export');
            Route::post('delete', 'CustomRoleController@delete')->name('delete');
        });

        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
            Route::get('view', 'ProfileController@view')->name('view');
            Route::get('update/{id}', 'ProfileController@edit')->name('update');
            Route::post('update/{id}', 'ProfileController@update');
            Route::post('settings-password', 'ProfileController@settings_password_update')->name('settings-password');
        });

        Route::group(['prefix' => 'withdraw', 'as' => 'withdraw.','middleware'=>['module:user_section']], function () {
            Route::post('update/{id}', 'WithdrawController@update')->name('update');
            Route::post('request', 'WithdrawController@w_request')->name('request');
            Route::post('status-filter', 'WithdrawController@status_filter')->name('status-filter');
        });

        Route::group(['prefix' => 'deal', 'as' => 'deal.','middleware'=>['module:promotion_management']], function () {
            Route::get('flash', 'DealController@flash_index')->name('flash');
            Route::post('flash', 'DealController@flash_submit');

            // feature deal
            Route::get('feature', 'DealController@feature_index')->name('feature');

            Route::get('day', 'DealController@deal_of_day')->name('day');
            Route::post('day', 'DealController@deal_of_day_submit');
            Route::post('day-status-update', 'DealController@day_status_update')->name('day-status-update');

            Route::get('day-update/{id}', 'DealController@day_edit')->name('day-update');
            Route::post('day-update/{id}', 'DealController@day_update');
            Route::post('day-delete', 'DealController@day_delete')->name('day-delete');

            Route::get('update/{id}', 'DealController@edit')->name('update');
            Route::get('edit/{id}', 'DealController@feature_edit')->name('edit');

            Route::post('update/{id}', 'DealController@update')->name('update');
            Route::post('status-update', 'DealController@status_update')->name('status-update');
            Route::post('feature-status', 'DealController@feature_status')->name('feature-status');

            Route::post('featured-update', 'DealController@featured_update')->name('featured-update');
            Route::get('add-product/{deal_id}', 'DealController@add_product')->name('add-product');
            Route::post('add-product/{deal_id}', 'DealController@add_product_submit');
            Route::post('delete-product', 'DealController@delete_product')->name('delete-product');
        });

        Route::group(['prefix' => 'employee', 'as' => 'employee.','middleware'=>['module:user_section']], function () {
            Route::get('add-new', 'EmployeeController@add_new')->name('add-new');
            Route::post('add-new', 'EmployeeController@store');
            Route::get('list', 'EmployeeController@list')->name('list');
            Route::get('update/{id}', 'EmployeeController@edit')->name('update');
            Route::post('update/{id}', 'EmployeeController@update');
            Route::post('status', 'EmployeeController@status')->name('status');
        });

        Route::group(['prefix' => 'category', 'as' => 'category.','middleware'=>['module:product_management']], function () {
            Route::get('view', 'CategoryController@index')->name('view');
            Route::get('fetch', 'CategoryController@fetch')->name('fetch');
            Route::post('store', 'CategoryController@store')->name('store');
            Route::get('edit/{id}', 'CategoryController@edit')->name('edit');
            Route::post('update/{id}', 'CategoryController@update')->name('update');
            Route::post('delete', 'CategoryController@delete')->name('delete');
            Route::post('status', 'CategoryController@status')->name('status');
        });

        Route::group(['prefix' => 'sub-category', 'as' => 'sub-category.','middleware'=>['module:product_management']], function () {
            Route::get('view', 'SubCategoryController@index')->name('view');
            Route::get('fetch', 'SubCategoryController@fetch')->name('fetch');
            Route::post('store', 'SubCategoryController@store')->name('store');
            Route::post('edit', 'SubCategoryController@edit')->name('edit');
            Route::post('update', 'SubCategoryController@update')->name('update');
            Route::post('delete', 'SubCategoryController@delete')->name('delete');
        });

        Route::group(['prefix' => 'sub-sub-category', 'as' => 'sub-sub-category.','middleware'=>['module:product_management']], function () {
            Route::get('view', 'SubSubCategoryController@index')->name('view');
            Route::get('fetch', 'SubSubCategoryController@fetch')->name('fetch');
            Route::post('store', 'SubSubCategoryController@store')->name('store');
            Route::post('edit', 'SubSubCategoryController@edit')->name('edit');
            Route::post('update', 'SubSubCategoryController@update')->name('update');
            Route::post('delete', 'SubSubCategoryController@delete')->name('delete');
            Route::post('get-sub-category', 'SubSubCategoryController@getSubCategory')->name('getSubCategory');
            Route::post('get-category-id', 'SubSubCategoryController@getCategoryId')->name('getCategoryId');
        });

        Route::group(['prefix' => 'brand', 'as' => 'brand.','middleware'=>['module:product_management']], function () {
            Route::get('add-new', 'BrandController@add_new')->name('add-new');
            Route::post('add-new', 'BrandController@store');
            Route::get('list', 'BrandController@list')->name('list');
            Route::get('update/{id}', 'BrandController@edit')->name('update');
            Route::post('update/{id}', 'BrandController@update');
            Route::post('delete', 'BrandController@delete')->name('delete');
            Route::get('export', 'BrandController@export')->name('export');
            Route::post('status-update', 'BrandController@status_update')->name('status-update');
        });

        Route::group(['prefix' => 'banner', 'as' => 'banner.','middleware'=>['module:promotion_management']], function () {
            Route::post('add-new', 'BannerController@store')->name('store');
            Route::get('list', 'BannerController@list')->name('list');
            Route::post('delete', 'BannerController@delete')->name('delete');
            Route::post('status', 'BannerController@status')->name('status');
            Route::get('edit/{id}', 'BannerController@edit')->name('edit');
            Route::put('update/{id}', 'BannerController@update')->name('update');
        });

        Route::group(['prefix' => 'attribute', 'as' => 'attribute.','middleware'=>['module:product_management']], function () {
            Route::get('view', 'AttributeController@index')->name('view');
            Route::get('fetch', 'AttributeController@fetch')->name('fetch');
            Route::post('store', 'AttributeController@store')->name('store');
            Route::get('edit/{id}', 'AttributeController@edit')->name('edit');
            Route::post('update/{id}', 'AttributeController@update')->name('update');
            Route::post('delete', 'AttributeController@delete')->name('delete');
        });

        Route::group(['prefix' => 'coupon', 'as' => 'coupon.','middleware'=>['module:promotion_management']], function () {
            Route::get('add-new', 'CouponController@add_new')->name('add-new')->middleware('actch');;
            Route::post('store-coupon', 'CouponController@store')->name('store-coupon');
            Route::get('update/{id}', 'CouponController@edit')->name('update')->middleware('actch');;
            Route::post('update/{id}', 'CouponController@update');
            Route::get('status/{id}/{status}', 'CouponController@status')->name('status');
            Route::delete('delete/{id}', 'CouponController@delete')->name('delete');

        });

        Route::group(['prefix' => 'shiprocket', 'as' => 'shiprocket.'], function () {
            Route::post('login', 'ShipRocketController@login')->name('login');
            Route::get('dashboard', 'ShipRocketController@index')->name('index');
        });

        Route::group(['prefix' => 'social-login', 'as' => 'social-login.','middleware'=>['module:system_settings']], function () {
            Route::get('view', 'BusinessSettingsController@viewSocialLogin')->name('view');
            Route::post('update/{service}', 'BusinessSettingsController@updateSocialLogin')->name('update');
        });

        Route::group(['prefix' => 'product-settings', 'as' => 'product-settings.','middleware'=>['module:system_settings']], function () {
            Route::get('/', 'BusinessSettingsController@productSettings')->name('index');
            Route::get('inhouse-shop', 'InhouseShopController@edit')->name('inhouse-shop');
            Route::post('inhouse-shop', 'InhouseShopController@update');
            Route::post('stock-limit-warning', 'BusinessSettingsController@stock_limit_warning')->name('stock-limit-warning');
            Route::post('update-digital-product', 'BusinessSettingsController@updateDigitalProduct')->name('update-digital-product');
            Route::post('update-product-brand', 'BusinessSettingsController@updateProductBrand')->name('update-product-brand');
        });

        //update zahed
        Route::group(['prefix' => 'others-settings', 'as' => 'others-settings.','middleware'=>['module:system_settings']], function () {
            Route::get('/', 'BusinessSettingsController@othersSettings')->name('index');
            Route::post('update-default-seo', 'BusinessSettingsController@updateDefaultSeo')->name('update-default-seo');
            Route::post('update-default-quotation', 'BusinessSettingsController@updateDefaultQuotation')->name('update-default-quotation');

        });
        //end zahed

        Route::group(['prefix' => 'currency', 'as' => 'currency.','middleware'=>['module:system_settings']], function () {
            Route::get('view', 'CurrencyController@index')->name('view')->middleware('actch');;
            Route::get('fetch', 'CurrencyController@fetch')->name('fetch');
            Route::post('store', 'CurrencyController@store')->name('store');
            Route::get('edit/{id}', 'CurrencyController@edit')->name('edit');
            Route::post('update/{id}', 'CurrencyController@update')->name('update');
            Route::post('delete', 'CurrencyController@delete')->name('delete');
            Route::post('status', 'CurrencyController@status')->name('status');
            Route::post('system-currency-update', 'CurrencyController@systemCurrencyUpdate')->name('system-currency-update');
        });

        Route::group(['prefix' => 'support-ticket', 'as' => 'support-ticket.','middleware'=>['module:support_section']], function () {
            Route::get('view', 'SupportTicketController@index')->name('view');
            Route::post('status', 'SupportTicketController@status')->name('status');
            Route::get('single-ticket/{id}', 'SupportTicketController@single_ticket')->name('singleTicket');
            Route::post('single-ticket/{id}', 'SupportTicketController@replay_submit')->name('replay');
        });
        Route::group(['prefix' => 'notification', 'as' => 'notification.','middleware'=>['module:promotion_management']], function () {
            Route::get('add-new', 'NotificationController@index')->name('add-new');
            Route::post('store', 'NotificationController@store')->name('store');
            Route::get('edit/{id}', 'NotificationController@edit')->name('edit');
            Route::post('update/{id}', 'NotificationController@update')->name('update');
            Route::post('status', 'NotificationController@status')->name('status');
            Route::post('resend-notification', 'NotificationController@resendNotification')->name('resend-notification');
            Route::post('delete', 'NotificationController@delete')->name('delete');
        });
        Route::group(['prefix' => 'reviews', 'as' => 'reviews.','middleware'=>['module:user_section']], function () {
            Route::get('list', 'ReviewsController@list')->name('list')->middleware('actch');
            Route::get('export', 'ReviewsController@export')->name('export')->middleware('actch');
            //Route::get('export', 'ReviewsController@export')->name('export')->middleware('actch');
            Route::get('status/{id}/{status}', 'ReviewsController@status')->name('status');
        });

        Route::group(['prefix' => 'customer', 'as' => 'customer.','middleware'=>['module:user_section']], function () {
            Route::get('list', 'CustomerController@customer_list')->name('list');
            Route::post('status-update', 'CustomerController@status_update')->name('status-update');
            Route::get('view/{user_id}', 'CustomerController@view')->name('view');
            Route::delete('delete/{id}','CustomerController@delete')->name('delete');
            Route::get('subscriber-list', 'CustomerController@subscriber_list')->name('subscriber-list');
            Route::get('subscriber-list-export', 'CustomerController@export_subscriber_list')->name('export-subscriber');
            Route::get('customer-settings','CustomerController@customer_settings')->name('customer-settings');
            Route::post('customer-settings-update','CustomerController@customer_update_settings')->name('customer-settings-update');
            Route::get('customer-list-search','CustomerController@get_customers')->name('customer-list-search');
            Route::get('request_call_back','CustomerController@request_call_back')->name('request_call_back');
            Route::get('request_call_back/update/{request_call_back_id}/{status}','CustomerController@update_request_call_back')->name('update_request_call_back');
            Route::get('export', 'CustomerController@export')->name('export');

            Route::group(['prefix' => 'wallet', 'as' => 'wallet.'], function () {
                Route::post('add-fund', 'CustomerWalletController@add_fund')->name('add-fund');
                Route::get('report', 'CustomerWalletController@report')->name('report');
            });
            Route::group(['prefix' => 'loyalty', 'as' => 'loyalty.'], function () {
                Route::get('report', 'CustomerLoyaltyController@report')->name('report');
            });
            Route::post('store', 'CustomerController@store')->name('store');
            Route::post('get_quotation_customer', 'CustomerController@get_quotation_customer')->name('get_quotation_customer');
            Route::post('quotation_customer_contact', 'CustomerController@quotation_customer_contact')->name('quotation_customer_contact');
            Route::post('quotation_customer_contact_update', 'CustomerController@quotation_customer_contact_update')->name('quotation_customer_contact_update');

        });


        ///Report
        Route::group(['prefix' => 'report', 'as' => 'report.' ,'middleware'=>['module:report']], function () {
            Route::get('order', 'ReportController@order_index')->name('order');
            Route::get('earning', 'ReportController@earning_index')->name('earning');
            Route::any('set-date', 'ReportController@set_date')->name('set-date');
            //sale report inhouse
            Route::get('inhoue-product-sale', 'InhouseProductSaleController@index')->name('inhoue-product-sale');
            Route::get('seller-product-sale', 'SellerProductSaleReportController@index')->name('seller-product-sale');
        });
        Route::group(['prefix' => 'stock', 'as' => 'stock.' ,'middleware'=>['module:report']], function () {
            //product stock report
            Route::get('product-stock', 'ProductStockReportController@index')->name('product-stock');
            Route::get('product-stock-export', 'ProductStockReportController@export')->name('product-stock-export');
            Route::post('ps-filter', 'ProductStockReportController@filter')->name('ps-filter');
            //product in wishlist report
            Route::get('product-in-wishlist', 'ProductWishlistReportController@index')->name('product-in-wishlist');
            Route::get('wishlist-product-export', 'ProductWishlistReportController@export')->name('wishlist-product-export');
        });
        Route::group(['prefix' => 'sellers', 'as' => 'sellers.','middleware'=>['module:user_section']], function () {
            Route::get('seller-add', 'SellerController@add_seller')->name('seller-add');
            Route::get('seller-list', 'SellerController@index')->name('seller-list');
            Route::get('order-list/{seller_id}', 'SellerController@order_list')->name('order-list');
            Route::get('product-list/{seller_id}', 'SellerController@product_list')->name('product-list');

            Route::get('order-details/{order_id}/{seller_id}', 'SellerController@order_details')->name('order-details');
            Route::get('verification/{id}', 'SellerController@view')->name('verification');
            Route::get('view/{id}/{tab?}', 'SellerController@view')->name('view');
            Route::post('update-status', 'SellerController@updateStatus')->name('updateStatus');
            Route::post('withdraw-status/{id}', 'SellerController@withdrawStatus')->name('withdraw_status');
            Route::get('withdraw_list', 'SellerController@withdraw')->name('withdraw_list');
            Route::get('withdraw-view/{withdraw_id}/{seller_id}', 'SellerController@withdraw_view')->name('withdraw_view');

            Route::post('sales-commission-update/{id}', 'SellerController@sales_commission_update')->name('sales-commission-update');
        });
        Route::group(['prefix' => 'product', 'as' => 'product.','middleware'=>['module:product_management']], function () {
            Route::get('add-new', 'ProductController@add_new')->name('add-new');
            Route::post('store', 'ProductController@store')->name('store');
            // add for malamal
            Route::post('quick-store', 'ProductController@quickStore')->name('quick_store');
            Route::post('pos-quick-store', 'ProductController@pos_quickStore')->name('pos_quick_store');
            //end
            Route::get('remove-image', 'ProductController@remove_image')->name('remove-image');
            Route::post('status-update', 'ProductController@status_update')->name('status-update');
            Route::get('list/{type}', 'ProductController@list')->name('list');
            Route::get('export-excel/{type}', 'ProductController@export_excel')->name('export-excel');
            Route::get('stock-limit-list/{type}', 'ProductController@stock_limit_list')->name('stock-limit-list');
            Route::get('get-variations', 'ProductController@get_variations')->name('get-variations');
            Route::post('update-quantity', 'ProductController@update_quantity')->name('update-quantity');
            Route::get('edit/{id}', 'ProductController@edit')->name('edit');
            Route::post('update/{id}', 'ProductController@update')->name('update');
            Route::post('featured-status', 'ProductController@featured_status')->name('featured-status');
            Route::get('approve-status', 'ProductController@approve_status')->name('approve-status');
            Route::post('deny', 'ProductController@deny')->name('deny');
            Route::post('sku-combination', 'ProductController@sku_combination')->name('sku-combination');
            Route::get('get-categories', 'ProductController@get_categories')->name('get-categories');
            Route::delete('delete/{id}', 'ProductController@delete')->name('delete');
            Route::get('updated-product-list','ProductController@updated_product_list')->name('updated-product-list');
            Route::post('updated-shipping','ProductController@updated_shipping')->name('updated-shipping');
            Route::get('questions', 'ProductController@questions')->name('questions');
            Route::get('answer/{id}', 'ProductController@questions_answer')->name('questions_answer');
            Route::post('answer_submit', 'ProductController@answer_submit')->name('answer_submit');

            Route::get('view/{id}', 'ProductController@view')->name('view');
            Route::get('bulk-import', 'ProductController@bulk_import_index')->name('bulk-import');
            Route::post('bulk-import', 'ProductController@bulk_import_data');
            Route::get('bulk-update', 'ProductController@bulk_update_index')->name('bulk-update');
            Route::post('bulk-update', 'ProductController@bulk_update_data');
            Route::get('bulk-export', 'ProductController@bulk_export_data')->name('bulk-export');
            Route::get('barcode/{id}', 'ProductController@barcode')->name('barcode');
            Route::get('barcode/generate', 'ProductController@barcode_generate')->name('barcode.generate');
        });

        Route::group(['prefix' => 'transaction', 'as' => 'transaction.' ,'middleware'=>['module:report']], function () {
            Route::get('list', 'TransactionController@list')->name('list');
            Route::get('transaction-export', 'TransactionController@export')->name('transaction-export');
        });

        Route::group(['prefix' => 'refund-section', 'as' => 'refund-section.' ,'middleware'=>['module:report']], function () {
            Route::get('refund-list', 'RefundTransactionController@list')->name('refund-list');

            //refund request
            Route::group(['prefix' => 'refund', 'as' => 'refund.'], function () {
                Route::get('list/{status}', 'RefundController@list')->name('list');
                Route::get('details/{id}', 'RefundController@details')->name('details');
                Route::get('inhouse-order-filter', 'RefundController@inhouse_order_filter')->name('inhouse-order-filter');
                Route::post('refund-status-update', 'RefundController@refund_status_update')->name('refund-status-update');

            });

            Route::get('refund-index','RefundController@index')->name('refund-index');
            Route::post('refund-update','RefundController@update')->name('refund-update');
        });


        Route::group(['prefix' => 'business-settings', 'as' => 'business-settings.'], function () {
            Route::group(['middleware'=>['module:system_settings']],function (){
                Route::get('sms-module', 'SMSModuleController@sms_index')->name('sms-module');
                Route::post('sms-module-update/{sms_module}', 'SMSModuleController@sms_update')->name('sms-module-update');
            });


            Route::group(['prefix' => 'shipping-method', 'as' => 'shipping-method.','middleware'=>['module:system_settings']], function () {
                Route::get('by/admin', 'ShippingMethodController@index_admin')->name('by.admin');
                //Route::get('by/seller', 'ShippingMethodController@index_seller')->name('by.seller');
                Route::post('add', 'ShippingMethodController@store')->name('add');
                Route::get('edit/{id}', 'ShippingMethodController@edit')->name('edit');
                Route::put('update/{id}', 'ShippingMethodController@update')->name('update');
                Route::post('delete', 'ShippingMethodController@delete')->name('delete');
                Route::post('status-update', 'ShippingMethodController@status_update')->name('status-update');
                Route::get('setting', 'ShippingMethodController@setting')->name('setting');
                Route::post('shipping-store','ShippingMethodController@shippingStore')->name('shipping-store');
            });

            Route::group(['prefix' => 'shipping-type', 'as' => 'shipping-type.','middleware'=>['module:system_settings']], function () {
                Route::post('store', 'ShippingTypeController@store')->name('store');
            });

            Route::group(['prefix' => 'category-shipping-cost', 'as' => 'category-shipping-cost.','middleware'=>['module:system_settings']], function () {
                Route::post('store', 'CategoryShippingCostController@store')->name('store');
            });

            Route::group(['prefix' => 'language', 'as' => 'language.','middleware'=>['module:system_settings']], function () {
                Route::get('', 'LanguageController@index')->name('index');
//                Route::get('app', 'LanguageController@index_app')->name('index-app');
                Route::post('add-new', 'LanguageController@store')->name('add-new');
                Route::get('update-status', 'LanguageController@update_status')->name('update-status');
                Route::get('update-default-status', 'LanguageController@update_default_status')->name('update-default-status');
                Route::post('update', 'LanguageController@update')->name('update');
                Route::get('translate/{lang}', 'LanguageController@translate')->name('translate');
                Route::post('translate-submit/{lang}', 'LanguageController@translate_submit')->name('translate-submit');
                Route::post('remove-key/{lang}', 'LanguageController@translate_key_remove')->name('remove-key');
                Route::get('delete/{lang}', 'LanguageController@delete')->name('delete');
            });

            Route::group(['prefix' => 'mail', 'as' => 'mail.','middleware'=>['module:system_settings']], function () {
                Route::get('/', 'MailController@index')->name('index');
                Route::post('update', 'MailController@update')->name('update');
                Route::post('update-sendgrid', 'MailController@update_sendgrid')->name('update-sendgrid');
                Route::post('send', 'MailController@send')->name('send');
            });

            Route::group(['prefix' => 'web-config', 'as' => 'web-config.','middleware'=>['module:system_settings']], function () {
                Route::get('/', 'BusinessSettingsController@companyInfo')->name('index')->middleware('actch');
                Route::post('update-colors', 'BusinessSettingsController@update_colors')->name('update-colors');
                Route::post('update-language', 'BusinessSettingsController@update_language')->name('update-language');
                Route::post('update-company', 'BusinessSettingsController@updateCompany')->name('company-update');
                Route::post('update-company-email', 'BusinessSettingsController@updateCompanyEmail')->name('company-email-update');
                Route::post('update-company-phone', 'BusinessSettingsController@updateCompanyPhone')->name('company-phone-update');
                Route::post('upload-web-logo', 'BusinessSettingsController@uploadWebLogo')->name('company-web-logo-upload');
                Route::post('upload-mobile-logo', 'BusinessSettingsController@uploadMobileLogo')->name('company-mobile-logo-upload');
                Route::post('upload-footer-log', 'BusinessSettingsController@uploadFooterLog')->name('company-footer-logo-upload');
                Route::post('upload-fav-icon', 'BusinessSettingsController@uploadFavIcon')->name('company-fav-icon');
                Route::post('update-company-copyRight-text', 'BusinessSettingsController@updateCompanyCopyRight')->name('company-copy-right-update');
                Route::post('app-store/{name}', 'BusinessSettingsController@update')->name('app-store-update');
                Route::get('currency-symbol-position/{side}', 'BusinessSettingsController@currency_symbol_position')->name('currency-symbol-position');
                Route::post('shop-banner', 'BusinessSettingsController@shop_banner')->name('shop-banner');

                Route::get('db-index', 'DatabaseSettingController@db_index')->name('db-index');
                Route::post('db-clean', 'DatabaseSettingController@clean_db')->name('clean-db');

                Route::get('environment-setup', 'EnvironmentSettingsController@environment_index')->name('environment-setup');
                Route::post('update-environment', 'EnvironmentSettingsController@environment_setup')->name('update-environment');

                //sitemap generate
                Route::get('mysitemap','SiteMapController@index')->name('mysitemap');
                Route::get('mysitemap-download','SiteMapController@download')->name('mysitemap-download');

            });

            Route::group(['prefix' => 'order-settings', 'as' => 'order-settings.','middleware'=>['module:system_settings']], function () {
                Route::get('index', 'OrderSettingsController@order_settings')->name('index');
                Route::post('update-order-settings','OrderSettingsController@update_order_settings')->name('update-order-settings');
            });

            Route::group(['prefix' => 'seller-settings', 'as' => 'seller-settings.','middleware'=>['module:system_settings']], function () {
                Route::get('/', 'BusinessSettingsController@seller_settings')->name('index')->middleware('actch');;
                Route::post('update-seller-settings', 'BusinessSettingsController@sales_commission')->name('update-seller-settings');
                Route::post('update-seller-registration', 'BusinessSettingsController@seller_registration')->name('update-seller-registration');
                Route::post('seller-pos-settings', 'BusinessSettingsController@seller_pos_settings')->name('seller-pos-settings');
                Route::get('business-mode-settings/{mode}', 'BusinessSettingsController@business_mode_settings')->name('business-mode-settings');
                Route::post('product-approval', 'BusinessSettingsController@product_approval')->name('product-approval');
            });

            Route::group(['prefix' => 'payment-method', 'as' => 'payment-method.','middleware'=>['module:system_settings']], function () {
                Route::get('/', 'PaymentMethodController@index')->name('index')->middleware('actch');;
                Route::post('{name}', 'PaymentMethodController@update')->name('update');
            });

            Route::group(['prefix' => 'logistic-module', 'as' => 'logistic-module.','middleware'=>['module:system_settings']], function () {
                Route::get('/', 'LogisticModuleController@index')->name('index')->middleware('actch');
                Route::post('{name}', 'LogisticModuleController@update')->name('update');
            });

            Route::group(['middleware'=>['module:system_settings']],function(){
                Route::get('general-settings', 'BusinessSettingsController@index')->name('general-settings')->middleware('actch');;
                Route::get('update-language', 'BusinessSettingsController@update_language')->name('update-language');
                Route::get('about-us', 'BusinessSettingsController@about_us')->name('about-us');
                Route::post('about-us', 'BusinessSettingsController@about_usUpdate')->name('about-update');
                Route::post('update-info','BusinessSettingsController@updateInfo')->name('update-info');
                Route::get('announcement','BusinessSettingsController@announcement')->name('announcement');
                Route::post('update-announcement','BusinessSettingsController@updateAnnouncement')->name('update-announcement');
                //Social Icon
                Route::get('social-media', 'BusinessSettingsController@social_media')->name('social-media');
                Route::get('fetch', 'BusinessSettingsController@fetch')->name('fetch');
                Route::post('social-media-store', 'BusinessSettingsController@social_media_store')->name('social-media-store');
                Route::post('social-media-edit', 'BusinessSettingsController@social_media_edit')->name('social-media-edit');
                Route::post('social-media-update', 'BusinessSettingsController@social_media_update')->name('social-media-update');
                Route::post('social-media-delete', 'BusinessSettingsController@social_media_delete')->name('social-media-delete');
                Route::post('social-media-status-update', 'BusinessSettingsController@social_media_status_update')->name('social-media-status-update');

                Route::get('terms-condition', 'BusinessSettingsController@terms_condition')->name('terms-condition');
                Route::post('terms-condition', 'BusinessSettingsController@updateTermsCondition')->name('update-terms');
                Route::get('privacy-policy', 'BusinessSettingsController@privacy_policy')->name('privacy-policy');
                Route::post('privacy-policy', 'BusinessSettingsController@privacy_policy_update')->name('privacy-policy');

                Route::get('fcm-index', 'BusinessSettingsController@fcm_index')->name('fcm-index');
                Route::post('update-fcm', 'BusinessSettingsController@update_fcm')->name('update-fcm');

                //captcha
                Route::get('captcha', 'BusinessSettingsController@recaptcha_index')->name('captcha');
                Route::post('recaptcha-update', 'BusinessSettingsController@recaptcha_update')->name('recaptcha_update');
                //google map api
                Route::get('map-api', 'BusinessSettingsController@map_api')->name('map-api');
                Route::post('map-api-update', 'BusinessSettingsController@map_api_update')->name('map-api-update');

                Route::post('update-fcm-messages', 'BusinessSettingsController@update_fcm_messages')->name('update-fcm-messages');


                //analytics
                Route::get('analytics-index', 'BusinessSettingsController@analytics_index')->name('analytics-index');
                Route::post('analytics-update', 'BusinessSettingsController@analytics_update')->name('analytics-update');
                Route::post('analytics-update-google-tag', 'BusinessSettingsController@google_tag_analytics_update')->name('analytics-update-google-tag');


            });

        });
        //order management
        Route::group(['prefix' => 'orders', 'as' => 'orders.','middleware'=>['module:order_management']], function () {
            Route::get('list/{status}', 'OrderController@list')->name('list');
            Route::get('details/{id}', 'OrderController@details')->name('details');
            Route::get('edit_order/{id}', 'OrderController@edit_order')->name('edit_order');
 	    Route::get('delete_edit_order/{id}', 'OrderController@delete_edit_order')->name('delete_edit_order');
            Route::post('order_update', 'OrderController@order_update')->name('order_update');
            Route::post('new_order_store', 'OrderController@new_order_store')->name('new_order_store');
            Route::post('status', 'OrderController@status')->name('status');
            Route::post('payment-status', 'OrderController@payment_status')->name('payment-status');
            Route::post('productStatus', 'OrderController@productStatus')->name('productStatus');
            Route::get('generate-invoice/{id}', 'OrderController@generate_invoice')->name('generate-invoice')->withoutMiddleware(['module:order_management']);
            Route::get('generate-mushok/{id}', 'OrderController@generate_mushok')->name('generate-mushok')->withoutMiddleware(['module:order_management']);
            Route::get('generate-chalan/{id}', 'OrderController@generate_chalan')->name('generate-chalan')->withoutMiddleware(['module:order_management']);
            Route::get('inhouse-order-filter', 'OrderController@inhouse_order_filter')->name('inhouse-order-filter');
            Route::post('digital-file-upload-after-sell', 'OrderController@digital_file_upload_after_sell')->name('digital-file-upload-after-sell');

            Route::post('update-deliver-info','OrderController@update_deliver_info')->name('update-deliver-info');
            Route::get('add-delivery-man/{order_id}/{d_man_id}', 'OrderController@add_delivery_man')->name('add-delivery-man');

            Route::get('export-order-data/{status}', 'OrderController@bulk_export_data')->name('order-bulk-export');
            Route::get('sms-templates', 'OrderController@sms_templates')->name('sms_templates');
            Route::post('sms-templates-update', 'OrderController@sms_templates_update')->name('sms_templates_update');
            Route::post('challan_no_add', 'OrderController@challan_no_add')->name('challan_no_add');
        });

        //pos management
        Route::group(['prefix' => 'pos', 'as' => 'pos.','middleware'=>['module:pos_management']], function () {
            Route::get('/', 'POSController@index')->name('index');
            Route::get('quick-view', 'POSController@quick_view')->name('quick-view');
            Route::post('variant_price', 'POSController@variant_price')->name('variant_price');
            Route::post('add-to-cart', 'POSController@addToCart')->name('add-to-cart');
            Route::post('remove-from-cart', 'POSController@removeFromCart')->name('remove-from-cart');
            Route::post('cart-items', 'POSController@cart_items')->name('cart_items');
            Route::post('update-quantity', 'POSController@updateQuantity')->name('updateQuantity');
            Route::post('update-price', 'POSController@updatePrice')->name('updatePrice');
            Route::post('empty-cart', 'POSController@emptyCart')->name('emptyCart');
            Route::post('tax', 'POSController@update_tax')->name('tax');
            Route::post('vat', 'POSController@update_vat')->name('vat');
            Route::post('fee', 'POSController@update_fee')->name('fee');
            Route::post('shipping-fee', 'POSController@update_pos_shipping_fee')->name('shipping-fee');
            Route::post('discount', 'POSController@update_discount')->name('discount');
            Route::post('tax', 'POSController@update_tax')->name('tax');
            Route::get('customers', 'POSController@get_customers')->name('customers');
            Route::post('order', 'POSController@place_order')->name('order');
            Route::get('orders', 'POSController@order_list')->name('orders');
            Route::get('order-details/{id}', 'POSController@order_details')->name('order-details');
            Route::post('digital-file-upload-after-sell', 'POSController@digital_file_upload_after_sell')->name('digital-file-upload-after-sell');
            Route::get('invoice/{id}', 'POSController@generate_invoice');
            Route::any('store-keys', 'POSController@store_keys')->name('store-keys');
            Route::get('search-products','POSController@search_product')->name('search-products');
            Route::get('order-bulk-export','POSController@bulk_export_data')->name('order-bulk-export');


            Route::post('coupon-discount', 'POSController@coupon_discount')->name('coupon-discount');
            Route::post('pos-shipping-fee', 'POSController@shipping_fee')->name('pos_shipping_fee');
            Route::get('change-cart','POSController@change_cart')->name('change-cart');
            Route::get('new-cart-id','POSController@new_cart_id')->name('new-cart-id');
            Route::post('remove-discount','POSController@remove_discount')->name('remove-discount');
            Route::get('clear-cart-ids','POSController@clear_cart_ids')->name('clear-cart-ids');
            Route::get('get-cart-ids','POSController@get_cart_ids')->name('get-cart-ids');

            Route::post('customer-store', 'POSController@customer_store')->name('customer-store');

            Route::get('add-invoice','POSController@addInvoice')->name('add-invoice');

        });

        Route::group(['prefix' => 'helpTopic', 'as' => 'helpTopic.','middleware'=>['module:system_settings']], function () {
            Route::get('list', 'HelpTopicController@list')->name('list');
            Route::post('add-new', 'HelpTopicController@store')->name('add-new');
            Route::get('status/{id}', 'HelpTopicController@status');
            Route::get('edit/{id}', 'HelpTopicController@edit');
            Route::post('update/{id}', 'HelpTopicController@update');
            Route::post('delete', 'HelpTopicController@destroy')->name('delete');
        });

        Route::group(['prefix' => 'contact', 'as' => 'contact.','middleware'=>['module:support_section']], function () {
            Route::post('contact-store', 'ContactController@store')->name('store');
            Route::get('list', 'ContactController@list')->name('list');
            Route::post('delete', 'ContactController@destroy')->name('delete');
            Route::get('view/{id}', 'ContactController@view')->name('view');
            Route::post('update/{id}', 'ContactController@update')->name('update');
            Route::post('send-mail/{id}', 'ContactController@send_mail')->name('send-mail');
        });

        Route::group(['prefix' => 'delivery-man', 'as' => 'delivery-man.', 'middleware'=>['module:user_section']], function () {
            Route::get('add', 'DeliveryManController@index')->name('add');
            Route::post('store', 'DeliveryManController@store')->name('store');
            Route::get('list', 'DeliveryManController@list')->name('list');
            Route::get('preview/{id}', 'DeliveryManController@preview')->name('preview');
            Route::get('edit/{id}', 'DeliveryManController@edit')->name('edit');
            Route::post('update/{id}', 'DeliveryManController@update')->name('update');
            Route::delete('delete/{id}', 'DeliveryManController@delete')->name('delete');
            Route::post('search', 'DeliveryManController@search')->name('search');
            Route::post('status-update', 'DeliveryManController@status')->name('status-update');
        });

        Route::group(['prefix' => 'file-manager', 'as' => 'file-manager.','middleware'=>['module:system_settings']], function () {
            Route::get('/download/{file_name}', 'FileManagerController@download')->name('download');
            Route::post('/file_details', 'FileManagerController@file_details')->name('file_details');
            Route::post('/file_details_update', 'FileManagerController@file_details_update')->name('file_details_update');
            Route::get('/index/{folder_path?}', 'FileManagerController@index')->name('index');
            Route::post('/image-upload', 'FileManagerController@upload')->name('image-upload');
            Route::delete('/delete/{file_path}', 'FileManagerController@destroy')->name('destroy');
        });
            // website setting
        Route::group(['prefix' => 'website'], function() {
            Route::get('/header', 'WebsiteController@header')->name('website.header');
            Route::get('/footer', 'WebsiteController@footer')->name('website.footer');
            Route::post('/footer-widget-one', 'WebsiteController@footer_widget_one')->name('website.footer.one');
            Route::post('/footer-widget-one/store', 'WebsiteController@footer_widget_one_store')->name('website.footer.one.store');
            Route::get('/footer-widget-one/destroy/{id}', 'WebsiteController@footer_widget_one_destroy')->name('website.footer.one.destroy');
            Route::post('/footer-widget-two', 'WebsiteController@footer_widget_two')->name('website.footer.two');
            Route::post('/footer-widget-two/store', 'WebsiteController@footer_widget_two_store')->name('website.footer.two.store');
            Route::get('/footer-widget-two/destroy/{id}', 'WebsiteController@footer_widget_two_destroy')->name('website.footer.two.destroy');

            Route::get('/appearance', 'WebsiteController@appearance')->name('website.appearance');
            Route::get('/pages', 'WebsiteController@pages')->name('website.pages');
            Route::resource('custom-pages', 'PageController');
            Route::get('/custom-pages/edit/{id}', 'PageController@edit')->name('custom-pages.edit');
            Route::get('/custom-pages/destroy/{id}', 'PageController@destroy')->name('custom-pages.destroy');
        });

        //Pickup_Points
            Route::resource('pick_up_points', 'PickupPointController');
            Route::get('/pick_up_points/edit/{id}', 'PickupPointController@edit')->name('pick_up_points.edit');
            Route::get('/pick_up_points/destroy/{id}', 'PickupPointController@destroy')->name('pick_up_points.destroy');


    });
// change for malamal
        /*Quotation Management*/

        Route::group(['prefix'=>'quotations','as'=>'quotation.'], function (){
            Route::get('list','QuotationManagementController@index')->name('list');
            Route::get('requests','QuotationManagementController@changeRequest')->name('request');
            Route::get('request-view/{id}','QuotationManagementController@quotation_request_View')->name('request_view');
            Route::get('request/add-new','QuotationManagementController@quotation_request_store')->name('request.create');
            Route::get('add-new','QuotationManagementController@create')->name('add-new');
            Route::post('store','QuotationManagementController@store')->name('store');
            Route::get('product_search', 'QuotationManagementController@productSearch')->name('product.search');
            Route::get('quotation_session_insert', 'QuotationManagementController@quotationSessionInsert')->name('product.quotation_session_insert');
            Route::get('quotation_session_remove', 'QuotationManagementController@quotationSessionRemove')->name('product.quotation_session_remove');
            Route::get('quotation_session_update', 'QuotationManagementController@quotationSessionUpdate')->name('product.quotation_session_update');
            Route::get('getProducts', 'QuotationManagementController@getProductData')->name('product.getProductData');
            Route::get('view/{id}', 'QuotationManagementController@show')->name('view');
            Route::get('send_mail/{id}', 'QuotationManagementController@qoutation_send_mail')->name('send_mail');
            Route::post('update/{id}', 'QuotationManagementController@update')->name('update');
            Route::get('edit/{id}', 'QuotationManagementController@edit')->name('edit');
            Route::get('download/{id}', 'QuotationManagementController@quotationDownload')->name('download');
        });


//end
        // blog management
        Route::group(['prefix'=>'blog','as'=>'blog.'], function (){
            Route::get('blog_category','BlogController@index')->name('category_list');
            Route::get('blog_category_edit/{id}', 'BlogController@edit')->name('edit');
            Route::post('store','BlogController@store')->name('store');
            Route::post('update','BlogController@update')->name('update');
            Route::get('category_delete/{id}', 'BlogController@category_delete')->name('category_delete');
            Route::get('blog_list','BlogController@blog_list')->name('blog_list');
            Route::get('blog_add','BlogController@blog_add')->name('blog_add');
            Route::post('blog_store','BlogController@blog_store')->name('blog_store');
            Route::get('blog_edit/{id}', 'BlogController@blog_edit')->name('blog_edit');
            Route::post('blog_update','BlogController@blog_update')->name('blog_update');
            Route::get('blog_delete/{id}', 'BlogController@blog_delete')->name('blog_delete');
        });
        Route::group(['prefix'=>'accounts','as'=>'account.'], function (){
            //accounts
            Route::get('account_list','AccountController@account_list')->name('account_list');
            Route::get('account_add','AccountController@account_add')->name('account_add');
            Route::post('account_store','AccountController@account_store')->name('account_store');
            Route::get('account/{id}', 'AccountController@account_edit')->name('account_edit');
            Route::post('account_update','AccountController@account_update')->name('account_update');
            Route::get('account_delete/{id}', 'AccountController@account_delete')->name('account_delete');
            //transaction
            Route::get('transaction_list','AccountController@transaction_list')->name('transaction_list');
            Route::get('transaction_add','AccountController@transaction_add')->name('transaction_add');
            Route::post('transaction_store','AccountController@transaction_store')->name('transaction_store');
            Route::get('transaction/{id}', 'AccountController@transaction_edit')->name('transaction_edit');
            Route::post('transaction_update','AccountController@transaction_update')->name('transaction_update');
            Route::get('transaction_delete/{id}', 'AccountController@transaction_delete')->name('transaction_delete');
            // transfer
            Route::get('transfer_list','AccountController@transfer_list')->name('transfer_list');
            Route::get('transfer_add','AccountController@transfer_add')->name('transfer_add');
            Route::post('transfer_store','AccountController@transfer_store')->name('transfer_store');
            Route::get('transfer/{id}', 'AccountController@transfer_edit')->name('transfer_edit');
            Route::post('transfer_update','AccountController@transfer_update')->name('transfer_update');
            Route::get('transfer_delete/{id}', 'AccountController@transfer_delete')->name('transfer_delete');
        });
    //for test

    /*Route::get('login', 'testController@login')->name('login');*/


    /*parcel management*/
    Route::group(['prefix'=>'parcels','as'=>'parcel.'], function (){
        Route::get('parcel_list','ParcelManagementController@index')->name('parcel_list');
        Route::get('parcel_add','ParcelManagementController@create')->name('create');
        Route::post('parcel_store','ParcelManagementController@store')->name('store');
        Route::get('parcel_tracking','ParcelManagementController@tracking')->name('parcel_tracking');
    });
});