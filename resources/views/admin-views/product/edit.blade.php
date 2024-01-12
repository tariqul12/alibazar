@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Product Edit'))

@push('css_or_js')
    <link href="{{asset('assets/back-end/css/tags-input.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
@php
    $check=DB::table("product_wise_courier")
                ->where('product_wise_courier.product_id',$product->id)
                ->first();
    if(!empty($check))
    {
    $courier=DB::table("courier_service")
            ->join('product_wise_courier','product_wise_courier.courier_id','courier_service.id')
            ->where('courier_service.status',1)
            ->where('product_wise_courier.product_id',$product->id)
            ->select('product_wise_courier.*','courier_service.name','courier_service.id as courier_id','courier_service.code')
            ->get();
    }
    else{
        $courier=DB::table("courier_service")
                    ->where('courier_service.status',1)
                    ->get();
    }
    $whole_check=DB::table("wholesale_prices")
                ->where('product_stock_id',$product->id)
                ->first();
                if(!empty($check))
    {
    $wholesalePrices=DB::table("wholesale_prices")
            ->where('product_stock_id',$product->id)
            ->get();
    }

@endphp
    <!-- Page Heading -->
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img src="{{asset('/assets/back-end/img/inhouse-product-list.png')}}" alt="">
                {{\App\CPU\translate('Product')}} {{\App\CPU\translate('Edit')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <form class="product-form" action="{{route('admin.product.update',$product->id)}}" method="post"
                      style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                      enctype="multipart/form-data"
                      id="product_form">
                    @csrf

                    <div class="card">
                        <div class="px-4 pt-3">
                            @php($language=\App\Model\BusinessSetting::where('type','pnc_language')->first())
                            @php($language = $language->value ?? null)
                            @php($default_lang = 'en')

                            @php($default_lang = json_decode($language)[0])
                            <ul class="nav nav-tabs w-fit-content mb-4">
                                @foreach(json_decode($language) as $lang)
                                    <li class="nav-item text-capitalize">
                                        <a class="nav-link lang_link {{$lang == $default_lang? 'active':''}}" href="#"
                                           id="{{$lang}}-link">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="card-body">
                            @foreach(json_decode($language) as $lang)
                                <?php
                                if (count($product['translations'])) {
                                    $translate = [];
                                    foreach ($product['translations'] as $t) {

                                        if ($t->locale == $lang && $t->key == "name") {
                                            $translate[$lang]['name'] = $t->value;
                                        }
                                        if ($t->locale == $lang && $t->key == "description") {
                                            $translate[$lang]['description'] = $t->value;
                                        }

                                    }
                                }
                                ?>
                                <div class="{{$lang != 'en'? 'd-none':''}} lang_form" id="{{$lang}}-form">
                                    <div class="form-group">
                                        <label class="title-color" for="{{$lang}}_name">{{\App\CPU\translate('name')}}<span class="text-danger">*</span>
                                            ({{strtoupper($lang)}})</label>
                                        <input type="text" {{$lang == 'en'? 'required':''}} name="name[]"
                                               id="{{$lang}}_name"
                                               value="{{$translate[$lang]['name']??$product['name']}}"
                                               class="form-control" placeholder="{{\App\CPU\translate('New Product')}}" required>
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{$lang}}">
                                    <div class="form-group pt-4">
                                        <label class="title-color">{{\App\CPU\translate('description')}}
                                            ({{strtoupper($lang)}})</label>
                                        <textarea name="description[]" class="textarea editor-textarea"
                                                  >{!! $translate[$lang]['description']??$product['details'] !!}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="{{ $lang != $default_lang ? 'd-none' : '' }} lang_form">
                            <div class="col-md-12 form-group pt-1">
                                <label class="title-color pt-4">{{ \App\CPU\translate('specifications') }}</label>
                                <!--<textarea rows="5" type="text" name="specifications" class="form-control pt-4">{!! $translate[$lang]['specifications']??$product['specifications'] !!}</textarea>-->
                                <textarea name="specifications" class="textarea editor-textarea">{!! $translate[$lang]['specifications']??$product['specifications'] !!}</textarea>
                            </div>
                        </div>
                        <div class="{{ $lang != $default_lang ? 'd-none' : '' }} lang_form">
                            <div class="col-md-12 form-group pt-1">
                                <label class="title-color pt-4">{{ \App\CPU\translate('quick_links') }}</label>
                                <!--<textarea rows="5" type="text" name="quick_links" class="form-control pt-4">{!! $translate[$lang]['quick_links']??$product['quick_links'] !!}</textarea>-->
                                <textarea name="quick_links" class="textarea editor-textarea">{!! $translate[$lang]['quick_links']??$product['quick_links'] !!}</textarea>
                            </div>
                        </div>
                        <div class="{{ $lang != $default_lang ? 'd-none' : '' }} lang_form">
                            <div class="col-md-12 form-group pt-1">
                                <label class="title-color pt-4">{{ \App\CPU\translate('Features') }}</label>
                                <textarea name="features" class="textarea editor-textarea">{!! $translate[$lang]['features']??$product['features'] !!}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2 rest-part">
                        <div class="card-header">
                            <h4 class="mb-0">{{\App\CPU\translate('General Info')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="name" class="title-color">{{ \App\CPU\translate('product_type') }}</label>
                                    <select name="product_type" id="product_type" class="form-control" required>
                                        <option value="physical" {{ $product->product_type=='physical' ? 'selected' : ''}}>{{ \App\CPU\translate('physical') }}</option>
                                        @if($digital_product_setting)
                                        <option value="digital" {{ $product->product_type=='digital' ? 'selected' : ''}}>{{ \App\CPU\translate('digital') }}</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-4" id="digital_product_type_show">
                                    <label for="digital_product_type" class="title-color">{{ \App\CPU\translate("digital_product_type") }}</label>
                                    <select name="digital_product_type" id="digital_product_type" class="form-control" required>
                                        <option value="{{ old('category_id') }}" {{ !$product->digital_product_type ? 'selected' : ''}} disabled>---Select---</option>
                                        <option value="ready_after_sell" {{ $product->digital_product_type=='ready_after_sell' ? 'selected' : ''}}>{{ \App\CPU\translate("Ready After Sell") }}</option>
                                        <option value="ready_product" {{ $product->digital_product_type=='ready_product' ? 'selected' : ''}}>{{ \App\CPU\translate("Ready Product") }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4" id="digital_file_ready_show">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="digital_file_ready" class="title-color">{{ \App\CPU\translate("ready_product_upload") }}</label>
                                            <input type="file" name="digital_file_ready" id="digital_file_ready" class="form-control">
                                            <div class="mt-1 text-info">File type: jpg, jpeg, png, gif, zip, pdf</div>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="h-100 mt-5">
                                                <a href="{{asset("storage/product/digital-product/$product->digital_file_ready")}}" target="_blank">{{ $product->digital_file_ready }}</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="name" class="title-color">{{\App\CPU\translate('Category')}}</label>
                                    <select
                                        class="js-example-basic-multiple js-states js-example-responsive form-control"
                                        name="category_id"
                                        id="category_id"
                                        onchange="getRequest('{{url('/')}}/admin/product/get-categories?parent_id='+this.value,'sub-category-select','select')">
                                        <option value="0" selected disabled>---{{\App\CPU\translate('Select')}}---</option>
                                        @foreach($categories as $category)
                                            <option
                                                value="{{$category['id']}}" {{ $category->id==$product_category[0]->id ? 'selected' : ''}} >{{$category['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="name" class="title-color">{{\App\CPU\translate('Sub Category')}}</label>
                                    <select
                                        class="js-example-basic-multiple js-states js-example-responsive form-control"
                                        name="sub_category_id" id="sub-category-select"
                                        data-id="{{count($product_category)>=2?$product_category[1]->id:''}}"
                                        onchange="getRequest('{{url('/')}}/admin/product/get-categories?parent_id='+this.value,'sub-sub-category-select','select')">
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="name" class="title-color">{{\App\CPU\translate('Sub Sub Category')}}</label>

                                    <select
                                        class="js-example-basic-multiple js-states js-example-responsive form-control"
                                        data-id="{{count($product_category)>=3?$product_category[2]->id:''}}"
                                        name="sub_sub_category_id" id="sub-sub-category-select">

                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="title-color"
                                               for="exampleFormControlInput1">{{ \App\CPU\translate('product_code_sku') }}
                                            <span class="text-danger">*</span>
                                            <a class="style-one-pro" style="cursor: pointer;"
                                               onclick="document.getElementById('generate_number').value = getRndInteger()">{{ \App\CPU\translate('generate') }}
                                                {{ \App\CPU\translate('code') }}</a></label>
                                        <input type="text" id="generate_number" name="code"
                                               class="form-control"  value="{{ $product->code  }}" required>
                                    </div>
                                </div>
                                @if($brand_setting)
                                    <div class="col-md-4">
                                        <label for="name" class="title-color">{{\App\CPU\translate('Brand')}}</label>
                                        <select
                                            class="js-example-basic-multiple js-states js-example-responsive form-control"
                                            name="brand_id">
                                            <option value="{{null}}" selected disabled>---{{\App\CPU\translate('Select')}}---</option>
                                            @foreach($br as $b)
                                                <option
                                                    value="{{$b['id']}}" {{ $b->id==$product->brand_id ? 'selected' : ''}} >{{$b['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div class="col-md-4 physical_product_show">
                                    <div class="form-group">
                                        <label for="name" class="title-color">{{\App\CPU\translate('Unit')}}</label>
                                        <select
                                            class="js-example-basic-multiple js-states js-example-responsive form-control"
                                            name="unit">
                                            @foreach(\App\CPU\Helpers::units() as $x)
                                                <option
                                                    value={{$x}} {{ $product->unit==$x ? 'selected' : ''}}>{{$x}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" id="digital_product_type_show">
                                    <label for="digital_product_type" class="title-color">{{ \App\CPU\translate("Is_EMI_Product") }}?</label>
                                    <select name="is_emi" id="is_emi" class="form-control" required>
                                        <option value="" >--Select--</option>
                                        <option value="1" {{ $product->is_emi==1 ? 'selected' : ''}}>{{ \App\CPU\translate("Yes") }}</option>
                                        <option value="0" {{ $product->is_emi==0 ? 'selected' : ''}}>{{ \App\CPU\translate("No") }}</option>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2 rest-part physical_product_show">
                        <div class="card-header">
                            <h4 class="mb-0">{{\App\CPU\translate('Variation')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-end">
                                <div class="col-md-6">
                                    <div class="mb-3 d-flex align-items-center gap-2">
                                        <label class="mb-0 title-color" for="switcher">
                                            {{\App\CPU\translate('Colors')}} :
                                        </label>
                                        <label class="switcher title-color">
                                            <input type="checkbox" class="switcher_input"
                                                name="colors_active" {{count($product['colors'])>0?'checked':''}}>
                                            <span class="switcher_control"></span>
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <select
                                            class="js-example-basic-multiple js-states js-example-responsive form-control color-var-select"
                                            name="colors[]" multiple="multiple"
                                            id="colors-selector" {{count($product['colors'])>0?'':'disabled'}}>
                                            @foreach (\App\Model\Color::orderBy('name', 'asc')->get() as $key => $color)
                                                <option
                                                    value={{ $color->code }} {{in_array($color->code,$product['colors'])?'selected':''}}>
                                                    {{$color['name']}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="attributes" class="pb-1 title-color">
                                        {{\App\CPU\translate('Attributes')}} :
                                    </label>
                                    <select
                                        class="js-example-basic-multiple js-states js-example-responsive form-control"
                                        name="choice_attributes[]" id="choice_attributes" multiple="multiple">
                                        <?php
                                        //\App\Model\Color  Attribute
                                        $getAttributes = \App\Model\Attribute::orderBy('name', 'asc')->get();
                                        
                                        ?>
                                        @if(sizeof($getAttributes) > 0)
                                        @foreach ($getAttributes as $key => $a)
                                            @if(($product['attributes']!='null') && !empty($a->id))
                                            <?php
                                            $decodeAttr = json_decode($product['attributes'],true);
                                            if(empty($decodeAttr)){
                                                continue;
                                            }
                                            ?>
                                                <option
                                                    value="{{ $a['id']}}" {{in_array($a->id,json_decode($product['attributes'],true))?'selected':''}}>
                                                    {{$a['name']}}
                                                </option>
                                            @else
                                                <option value="{{ $a['id']}}">{{$a['name']}}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-12 mt-2 mb-2">
                                    <div class="customer_choice_options" id="customer_choice_options">
                                        @include('admin-views.product.partials._choices',['choice_no'=>json_decode($product['attributes']),'choice_options'=>json_decode($product['choice_options'],true)])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- courier serivce --}}
                    <div class="card mt-2 rest-part physical_product_show">
                        <div class="card-header">
                            <h4 class="mb-0">{{ \App\CPU\translate('Courier_Service') }}</h4>
                        </div>
                        <div class="card-body">
                           @if ($check)
                           @foreach ($courier as $item)
                                <div class="row align-items-end">
                                    <div class="col-md-6">
                                        <strong>{{$item->name}} ({{$item->code}})</strong>
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <input type="text" name="courier_amount[{{$item->courier_id}}]" class="form-control" placeholder="Courier Service Amount" value="{{$item->amount}}" required>
                                    </div>
                                </div>
                            @endforeach
                            @else
                            @foreach ($courier as $item)
                                <div class="row align-items-end">
                                    <div class="col-md-6">
                                        <strong>{{$item->name}} ({{$item->code}})</strong>
                                    </div>

                                    <div class="col-md-6 mt-2">
                                      <input type="text" name="courier_amount[{{$item->id}}]" class="form-control" placeholder="Courier Service Amount" value="0" required >
                                    </div>
                                </div>
                            @endforeach
                           @endif
                           
                           
                        </div>
                    </div>

                    {{-- end courier service --}}

                    <div class="card mt-2 rest-part">
                        <div class="card-header">
                            <h4 class="mb-0">{{\App\CPU\translate('Product price & stock')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-end">
                                <div class="col-md-4 form-group">
                                    <label class="title-color">{{\App\CPU\translate('Unit price')}}</label>
                                    <input type="number" min="0" step="0.01"
                                            placeholder="{{\App\CPU\translate('Unit price') }}"
                                            name="unit_price" class="form-control"
                                            value={{\App\CPU\Convert::default($product->unit_price)}} required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="title-color">{{\App\CPU\translate('Purchese price')}}</label>
                                    <input type="number" min="0" step="0.01"
                                            placeholder="{{\App\CPU\translate('Purchase price') }}"
                                            name="purchase_price" class="form-control"
                                            value={{ \App\CPU\Convert::default($product->purchase_price) }} required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="title-color">{{ \App\CPU\translate('loyalty_point') }}</label>
                                    <input type="number" min="0"
                                        placeholder="{{ \App\CPU\translate('loyalty_point') }}"
                                        value="{{ \App\CPU\Convert::default($product->loyalty_point) }}" name="loyalty_point" class="form-control">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="title-color">{{\App\CPU\translate('Tax')}}</label>
                                    <label class="text-info title-color">{{\App\CPU\translate('Percent')}} ( % )</label>
                                    <input type="number" min="0" value={{ $product->tax }} step="0.01"
                                            placeholder="{{\App\CPU\translate('Tax') }}" name="tax"
                                            class="form-control" required>
                                    <input name="tax_type" value="percent" class="d-none">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label class="title-color">{{\App\CPU\translate('Discount')}}</label>
                                    <input type="number" min="0"
                                            value={{ $product->discount_type=='flat'?\App\CPU\Convert::default($product->discount): $product->discount}} step="0.01"
                                            placeholder="{{\App\CPU\translate('Discount') }}" name="discount"
                                            class="form-control" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="title-color">{{\App\CPU\translate('discount_type')}} </label>
                                    <select
                                        class="js-example-basic-multiple js-states js-example-responsive demo-select2 w-100"
                                        name="discount_type">
                                        <option
                                            value="percent" {{$product['discount_type']=='percent'?'selected':''}}>{{\App\CPU\translate('Percent')}}</option>
                                        <option
                                            value="flat" {{$product['discount_type']=='flat'?'selected':''}}>{{\App\CPU\translate('Flat')}}</option>

                                    </select>
                                </div>
                                <div class="col-12 sku_combination table-responsive form-group" id="sku_combination">
                                    @include('admin-views.product.partials._edit_sku_combinations',['combinations'=>json_decode($product['variation'],true)])
                                </div>
                                <div class="col-md-3 form-group physical_product_show" id="quantity">
                                    <label class="title-color">{{\App\CPU\translate('total')}} {{\App\CPU\translate('Quantity')}}</label>
                                    <input type="number" min="0" value={{ $product->current_stock }} step="1"
                                            placeholder="{{\App\CPU\translate('Quantity') }}"
                                            name="current_stock" class="form-control" required>
                                </div>
                                <div class="col-md-3 form-group" id="minimum_order_qty">
                                    <label class="title-color">{{\App\CPU\translate('minimum_order_quantity')}}</label>
                                    <input type="number" min="1" value={{ $product->minimum_order_qty }} step="1"
                                            placeholder="{{\App\CPU\translate('minimum_order_quantity') }}"
                                            name="minimum_order_qty" class="form-control" required>
                                </div>
                                <div class="col-md-3 form-group physical_product_show" id="shipping_cost">
                                    <label class="title-color">{{\App\CPU\translate('shipping_cost')}} </label>
                                    <input type="number" min="0" value="{{\App\CPU\Convert::default($product->shipping_cost)}}" step="1"
                                            placeholder="{{\App\CPU\translate('shipping_cost')}}"
                                            name="shipping_cost" class="form-control" required>
                                </div>
                                <div class="col-md-3 form-group physical_product_show" id="shipping_cost">
                                    <label class="title-color">{{\App\CPU\translate('shipping_cost_multiply_with_quantity')}} </label>
                                    <label class="switcher title-color">
                                        <input class="switcher_input" type="checkbox" name="multiplyQTY"
                                               id="" {{$product->multiply_qty == 1?'checked':''}}>
                                        <span class="switcher_control"></span>
                                    </label>
                                </div>
                            </div>
                            {{-- whole sale --}}
                            <div class="form-group row">
                                <label class="col-md-12 col-from-label">
                                    {{\App\CPU\translate('Wholesale Prices')}}
                                </label>
                                <div class="col-md-10 wholesale-content-holder">
                                    @if(isset($wholesalePrices))
                                    @foreach ($wholesalePrices as $wholesalePrice)
                                    <div class="qunatity-price wholesale-content">
                                        <div class="row gutters-5">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="{{\App\CPU\translate('Min QTY')}}" name="wholesale_min_qty[]" value="{{ $wholesalePrice->min_qty }}" required>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="{{ \App\CPU\translate('Max QTY') }}" name="wholesale_max_qty[]" value="{{ $wholesalePrice->max_qty }}" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="{{ \App\CPU\translate('Price per piece') }}" name="wholesale_price[]" value="{{ $wholesalePrice->price }}" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger remove-wholesale">
                                                    <i class="tio-delete"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                    
                                </div>
                                <div class="col-md-10">
                                    <button type="button" class="btn btn-info btn-sm add-more-wholesale">
                                        {{  \App\CPU\translate('Add More') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2 mb-2 rest-part">
                        <div class="card-header">
                            <h4 class="mb-0">{{\App\CPU\translate('seo_section')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="title-color">{{\App\CPU\translate('Meta Title')}}</label>
                                    <input type="text" name="pmeta_title" value="{{$product['meta_title']}}" placeholder="" class="form-control">
                                </div>

                                <div class="col-md-8 form-group">
                                    <label class="title-color">{{\App\CPU\translate('Meta Description')}}</label>
                                    <textarea rows="10" type="text" name="meta_description" class="form-control">{{$product['meta_description']}}</textarea>
                                </div>

                                <div class="col-md-4 form-group">
                                    <div class="">
                                        <label class="title-color">{{\App\CPU\translate('Meta Image')}}</label>
                                    </div>
                                    <div class="border-dashed">
                                        <div class="row" id="meta_img">
                                            <div class="col-sm-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <img class="w-100" height="auto"
                                                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                             src="{{asset("storage/product/meta")}}/{{$product['meta_image']}}"
                                                             alt="Meta image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2 rest-part">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="mb-2">
                                        <label class="title-color mb-0">{{\App\CPU\translate('Youtube video link')}}</label>
                                        <span class="text-info"> ( {{\App\CPU\translate('optional, please provide embed link not direct link')}}. )</span>
                                    </div>
                                    <input type="text" value="{{$product['video_url']}}" name="video_link"
                                           placeholder="{{\App\CPU\translate('EX')}} : https://www.youtube.com/embed/5R06LRdUCSE"
                                           class="form-control" >
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="title-color">{{\App\CPU\translate('Upload product images')}}</label>
                                        <span class="text-info"><span class="text-danger">*</span> ( {{\App\CPU\translate('ratio')}} 1:1 )</span>
                                    </div>
                                    <div class="p-2 border border-dashed">
                                        <div class="row gy-3" id="coba">
                                            @foreach (json_decode($product->images) as $key => $photo)
                                                <div class="col-sm-6 img_hold_area">
                                                    <div class="card">
                                                        <div class="card-body">

                                                                  {{-- seo --}}
                                                                    <button class="btn p-0 w-100" data-toggle="modal"
                                                                        data-target="#detailsInfo{{$key}}" title="{{$photo}}">
                                                                    <div class="gallary-card">
                                                                        
                                                                        
                                                                        <!-------------------------------->
                                                                        <div class="dropdown-file">
                                                                            <a class="dropdown-link" data-toggle="dropdown">
                                                                                <i class="tio-chevron-down"></i>
                                                                            </a>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <a class="dropdown-item"  id="btn1" onclick="file_details('{{$photo}}','{{$key}}')">
                                                                                    <i class="tio-edit"></i>
                                                                                    <span>Details Info</span>
                                                                                </a>
                                                                            
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <!--------------------->
                                                                        <img class="w-100" height="auto"
                                                                        onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                                                                        src="{{asset("storage/product/$photo")}}"
                                                                        alt="Product image">
                                                                    </div>
                                                                </button>
                                                                {{-- seo end --}}
                                                            <!--<a href="{{route('admin.product.remove-image',['id'=>$product['id'],'name'=>$photo])}}"-->
                                                            <!--   class="btn btn-danger btn-block">{{\App\CPU\translate('Remove')}}</a>-->
                                                            <button type="button" class="btn btn-danger btn-block" onclick="removeProductImage('{{route('admin.product.remove-image',['id'=>$product['id'],'name'=>$photo])}}', this)">{{\App\CPU\translate('Remove')}}</button>
                                                           

                                                        </div>
                                                    </div>
                                                </div>
	              {{-- modal details info --}}
                      <div class="modal fade" id="detailsInfo{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-right" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalScrollableTitle">File Info</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            
                            <div class="modal-body">
                            <div>
                                <form action="{{route('admin.file-manager.file_details_update')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>File Name</label>
                                        <input type="text" class="form-control" name="file_name" value="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Image Title</label>
                                        <input type="text" class="form-control" name="img_title" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Image Alt Tag</label>
                                        <input type="text" class="form-control" name="img_alt_tag" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Meta Title</label>
                                        <input type="text" class="form-control" name="meta_title" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <input type="text" class="form-control" name="meta_discription" value="" required>
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-secondary">Update</button>
                                    </div>
                                </form>
                                   
                                </div>
                            </div>
                            <!--<div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Schliessen</button>         
                            </div>-->
                        </div>
                        </div>
                    </div>
                    {{-- end --}}
          	
                                            @endforeach
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="name" class="title-color">{{\App\CPU\translate('Upload thumbnail')}}</label>
                                        <span class="text-info"><span class="text-danger">*</span> ( {{\App\CPU\translate('ratio')}} 1:1 )</span>
                                    </div>

                                    <div class="row gy-3" id="thumbnail">
                                        <div class="col-sm-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <img class="w-100" height="auto"
                                                         onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                                                         src="{{asset("storage/product/thumbnail")}}/{{$product['thumbnail']}}"
                                                         alt="Product image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end pt-3">
                                @if($product->request_status == 2)
                                    <button type="button" onclick="check()" class="btn btn--primary">{{\App\CPU\translate('Update & Publish')}}</button>
                                @else
                                    <button type="button" onclick="check()" class="btn btn--primary">{{\App\CPU\translate('Update')}}</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script_2')
    <script src="{{asset('assets/back-end')}}/js/tags-input.min.js"></script>
    <script src="{{asset('assets/back-end/js/spartan-multi-image-picker.js')}}"></script>
    <script>
        var imageCount = {{10-count(json_decode($product->images))}};
        var thumbnail = '{{\App\CPU\ProductManager::product_image_path('thumbnail').'/'.$product->thumbnail??asset('public/assets/back-end/img/400x400/img2.jpg')}}';
        $(function () {
            if (imageCount > 0) {
                $("#coba").spartanMultiImagePicker({
                    fieldName: 'images[]',
                    maxCount: imageCount,
                    rowHeight: 'auto',
                    groupClassName: 'col-6',
                    maxFileSize: '',
                    placeholderImage: {
                        image: '{{asset('public/assets/back-end/img/400x400/img2.jpg')}}',
                        width: '100%',
                    },
                    dropFileLabel: "Drop Here",
                    onAddRow: function (index, file) {

                    },
                    onRenderedPreview: function (index) {

                    },
                    onRemoveRow: function (index) {

                    },
                    onExtensionErr: function (index, file) {
                        toastr.error('{{\App\CPU\translate('Please only input png or jpg type file')}}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    },
                    onSizeErr: function (index, file) {
                        toastr.error('{{\App\CPU\translate('File size too big')}}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                });
            }

            $("#thumbnail").spartanMultiImagePicker({
                fieldName: 'image',
                maxCount: 1,
                rowHeight: 'auto',
                groupClassName: 'col-6',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('assets/back-end/img/400x400/img2.jpg')}}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('{{\App\CPU\translate('Please only input png or jpg type file')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('{{\App\CPU\translate('File size too big')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });

            $("#meta_img").spartanMultiImagePicker({
                fieldName: 'meta_image',
                maxCount: 1,
                rowHeight: 'auto',
                groupClassName: 'col-6',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('assets/back-end/img/400x400/img2.jpg')}}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('{{\App\CPU\translate('Please only input png or jpg type file')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('{{\App\CPU\translate('File size too big')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        function file_details(file_name,key)
        {
            var _token = "{{ csrf_token() }}";   
            $.ajax({
            type: 'POST',
            url: "{{ route('admin.file-manager.file_details') }}",
            data: {
                file_name: file_name,
                _token: _token
            },
            success: function(data) {
                console.log(data['file_name']);
                console.log(key);
                if (data) {
                    $('input[name="file_name"]').val(data['file_name']);
                    $('input[name="img_title"]').val(data['img_title']);
                    $('input[name="img_alt_tag"]').val(data['img_alt_tag']);
                    $('input[name="meta_title"]').val(data['meta_title']);
                    $('input[name="meta_discription"]').val(data['meta_description']);
                    $('#detailsInfo'+key).modal('show');
                    
                }

            }
        });
        }
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function () {
            readURL(this);
        });

        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>

    <script>
        function getRequest(route, id, type) {
            $.get({
                url: route,
                dataType: 'json',
                success: function (data) {
                    if (type == 'select') {
                        $('#' + id).empty().append(data.select_tag);
                    }
                },
            });
        }
        
        function removeProductImage(route, el) {
            // console.log(route);
            // return false;
            $.get({
                url: route,
                dataType: 'json',
                success: function (data) {
                    // console.log(data.status);
                    if(data.status == 'success'){
                        $(el).closest('.img_hold_area').remove();
                        toastr.success('Product image removed successfully!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                },
            });
        }

        $('input[name="colors_active"]').on('change', function () {
            if (!$('input[name="colors_active"]').is(':checked')) {
                $('#colors-selector').prop('disabled', true);
            } else {
                $('#colors-selector').prop('disabled', false);
            }
        });

        $('#choice_attributes').on('change', function () {
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function () {
                //console.log($(this).val());
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name.split(' ').join('');
            $('#customer_choice_options').append('<div class="row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control" name="choice[]" value="' + n + '" placeholder="{{\App\CPU\translate('Choice Title') }}" readonly></div><div class="col-lg-9"><input type="text" class="form-control" name="choice_options_' + i + '[]" placeholder="{{\App\CPU\translate('Enter choice values') }}" data-role="tagsinput" onchange="update_sku()"></div></div>');
            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }

        setTimeout(function () {
            $('.call-update-sku').on('change', function () {
                update_sku();
            });
        }, 2000)

        $('#colors-selector').on('change', function () {
            update_sku();
        });

        $('input[name="unit_price"]').on('keyup', function () {
            let product_type = $('#product_type').val();
            if(product_type === 'physical') {
                update_sku();
            }
        });

        function update_sku() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: '{{route('admin.product.sku-combination')}}',
                data: $('#product_form').serialize(),
                success: function (data) {
                    $('#sku_combination').html(data.view);
                    update_qty();
                    if (data.length > 1) {
                        $('#quantity').hide();
                    } else {
                        $('#quantity').show();
                    }
                }
            });
        }

        $(document).ready(function () {
            setTimeout(function () {
                let category = $("#category_id").val();
                let sub_category = $("#sub-category-select").attr("data-id");
                let sub_sub_category = $("#sub-sub-category-select").attr("data-id");
                getRequest('{{url('/')}}/admin/product/get-categories?parent_id=' + category + '&sub_category=' + sub_category, 'sub-category-select', 'select');
                getRequest('{{url('/')}}/admin/product/get-categories?parent_id=' + sub_category + '&sub_category=' + sub_sub_category, 'sub-sub-category-select', 'select');
            }, 100)
            // color select select2
            $('.color-var-select').select2({
                templateResult: colorCodeSelect,
                templateSelection: colorCodeSelect,
                escapeMarkup: function (m) {
                    return m;
                }
            });

            function colorCodeSelect(state) {
                var colorCode = $(state.element).val();
                if (!colorCode) return state.text;
                return "<span class='color-preview' style='background-color:" + colorCode + ";'></span>" + state.text;
            }
        });
    </script>

    <script>
        function check() {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            var formData = new FormData(document.getElementById('product_form'));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.product.update',$product->id)}}',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('product updated successfully!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('#product_form').submit();
                    }
                }
            });
        };
    </script>

    <script>
        update_qty();

        function update_qty() {
            var total_qty = 0;
            var qty_elements = $('input[name^="qty_"]');
            for (var i = 0; i < qty_elements.length; i++) {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            if (qty_elements.length > 0) {

                $('input[name="current_stock"]').attr("readonly", true);
                $('input[name="current_stock"]').val(total_qty);
            } else {
                $('input[name="current_stock"]').attr("readonly", false);
            }
        }

        $('input[name^="qty_"]').on('keyup', function () {
            var total_qty = 0;
            var qty_elements = $('input[name^="qty_"]');
            for (var i = 0; i < qty_elements.length; i++) {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            $('input[name="current_stock"]').val(total_qty);
        });
    </script>

    <script>
        $(".lang_link").click(function (e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $("#" + lang + "-form").removeClass('d-none');
            if (lang == '{{$default_lang}}') {
                $(".rest-part").removeClass('d-none');
            } else {
                $(".rest-part").addClass('d-none');
            }
        })

        $(document).ready(function(){
            product_type();
            digital_product_type();

            $('#product_type').change(function(){
                product_type();
            });

            $('#digital_product_type').change(function(){
                digital_product_type();
            });
        });

        function product_type(){
            let product_type = $('#product_type').val();

            if(product_type === 'physical'){
                $('#digital_product_type_show').hide();
                $('#digital_file_ready_show').hide();
                $('.physical_product_show').show();
                $("#digital_product_type").val($("#digital_product_type option:first").val());
                $("#digital_file_ready").val('');
            }else if(product_type === 'digital'){
                $('#digital_product_type_show').show();
                $('.physical_product_show').hide();

            }
        }

        function digital_product_type(){
            let digital_product_type = $('#digital_product_type').val();
            if (digital_product_type === 'ready_product') {
                $('#digital_file_ready_show').show();
            } else if (digital_product_type === 'ready_after_sell') {
                $('#digital_file_ready_show').hide();
                $("#digital_file_ready").val('');
            }
        }

        // add and remove wholesale functionality
        var removeWholeSaleBox = function(ev){
            ev.stopPropagation();
            ev.preventDefault();
            $(this).closest('.wholesale-content').remove();
        };
        
        $('.add-more-wholesale').on('click', function() {
            const sampleWholeSaleBox = `<div class="qunatity-price wholesale-content">
                                <div class="row gutters-5">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="{{ \App\CPU\translate('Min QTY')}}" name="wholesale_min_qty[]" required>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="{{  \App\CPU\translate('Max QTY') }}" name="wholesale_max_qty[]" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="{{  \App\CPU\translate('Price per piece') }}" name="wholesale_price[]" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger remove-wholesale">
                                            <i class="tio-delete"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>`;
    
            $('.wholesale-content-holder').append(sampleWholeSaleBox);
            $('.wholesale-content-holder .remove-wholesale').on('click', removeWholeSaleBox);
        });
        $('.remove-wholesale').on('click', removeWholeSaleBox);
        // add and remove wholesale functionality ends
        
    </script>

    {{--ck editor--}}
    <script src="{{asset('/')}}ckeditor/ckeditor/ckeditor.js"></script>
    <script src="{{asset('/')}}ckeditor/ckeditor/adapters/jquery.js"></script>
    <script>
        $('.textarea').ckeditor({
            contentsLangDirection : '{{Session::get('direction')}}',
        });
    </script>
    {{--ck editor--}}
@endpush