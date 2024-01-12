@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('file.Add Quotation'))

@push('css_or_js')
    <link href="{{asset('public/assets/back-end/css/tags-input.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/fontawesome.min.css" integrity="sha512-RvQxwf+3zJuNwl4e0sZjQeX7kUa3o82bDETpgVCH2RiwYSZVDdFJ7N/woNigN/ldyOOoKw8584jM4plQdt8bhA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page"><a
                        href="{{route('admin.quotation.list')}}">{{\App\CPU\translate('Quotations')}}</a>
                </li>
                <li class="breadcrumb-item">{{\App\CPU\translate('Add')}} {{\App\CPU\translate('New')}} </li>
            </ol>
        </nav>

        <!-- Content Row -->
        <div class="card row">
            <div class="col-md-12">
                <div class="card-body">
                    <p class="italic"><small>{{\App\CPU\translate('file.The field labels marked with * are required input fields')}}.</small></p>
                    <form class="product-form" action="{{route('admin.quotation.store')}}" method="POST"
                          enctype="multipart/form-data"
                          id="quotation-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>{{\App\CPU\translate('file.customer')}} *</label>
                                            <div class="input-group">
                                                <select required name="customer_id" id="customer_id" class="customer_select selectpicker form-control" data-live-search="true" title="Select customer..." style="width: 100px">
                                                    @foreach($lims_customer_list as $customer)
                                                        <option value="{{$customer->id}}" <?php if($customer->id == session('customer_id')) {echo "selected";} ?>>{{$customer->f_name . ' ( ' . $customer->phone . ' | ' . $customer->email  . ' )'}}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCustomer"><i class="fa-solid fa-plus"></i></button>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Subject Line</label>
                                            <div class="input-group">
                                                <input type="text" name="subject" required class="form-control subject_input" placeholder="Write your subject line" value="{!!  session('subject_line') !!}">
                                                <input type="hidden" name="request_id"  value="{!!   request()->get('request_id') !!}">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="pl-3" id="customer_info" style="display:none">
                                        <strong>Company Name:</strong><span id="quote_company_name"></span>
                                        <strong>Address:  </strong><span id="quote_address"></span>
                                        <strong>Email:  </strong><span id="quote_cust_email"></span>
                                        <strong>Phone:  </strong><span id="quote_cust_phone"></span>
                                        <button type="button" class="btn btn-link edit_cart_product" data-toggle="modal" data-target="#qoute_address"><i class="tio-edit"></i>Edit</button>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label>{{\App\CPU\translate('file.Select Product')}}</label>
                                        <div class="search-box input-group">
                                            <button class="btn btn-secondary tio-barcode-btn" style="pointer-events: none;"><i class="tio-barcode"></i></button>
                                            <input type="text" name="product_code_name" id="lims_productcodeSearch" placeholder="Please type product code and select..." class="form-control" />
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addProduct"><i class="fa-solid fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="quotation_session">
                                    @include('admin-views.quotation.order')
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{\App\CPU\translate('Vat')}}</label>
                                            <select class="form-control" name="quotation_vat_status" id="quotation_vat_status" onchange="vat_status_change()">
                                                <option value="0">{{\App\CPU\translate('Without_Vat')}}</option>
                                                <option value="1">{{\App\CPU\translate('With_Vat')}}</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-4" style="display: none" id="quotation_vat_id">
                                        <div class="form-group">
                                            <label>Quotation Vat</label>
                                            <input type="text" name="quote_vat" class="form-control" value="{{$quotation_default_vat}}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-12">
                                        <h5>Shipping Information</h5>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Shipping Description</label>
                                            <textarea rows="5" name="shipping_description" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Shipping Cost</label>
                                            <input type="number" name="shipping_cost" class="form-control shipping_cost" value="0"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="display: none" id="shipping_vat_id">
                                        <div class="form-group">
                                            <label>Shipping Vat ( in percentage)</label>
                                            <input type="text" name="shipping_vat" class="form-control shipping_vat" value="0"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Shipping Amount</label>
                                            <input type="number" name="shipping_amount" class="form-control shipping_amt" value="0" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{\App\CPU\translate('file.Status')}}</label>
                                            <select class="form-control" name="quotation_status">
                                                <option value="1">{{\App\CPU\translate('file.Pending')}}</option>
                                       {{-- <option value="2">{{\App\CPU\translate('file.Sent')}}</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{\App\CPU\translate('file.Attach Document')}}</label>
                                            <i class="dripicons-question" data-toggle="tooltip" title="Only jpg, jpeg, png, gif, pdf, csv, docx, xlsx and txt file is supported"></i>
                                            <input type="file" name="document" class="form-control" />
                                            @if($errors->has('extension'))
                                                <span>
                                                   <strong>{{ $errors->first('extension') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{\App\CPU\translate('file.Note')}}</label>
                                            <textarea rows="5" name="note" class="textarea editor-textarea"><p>1. This is a real-time Quotation generated automatically and only shows the product price.</p>
                                                <p>2. Quotation is valid for the next 5 days.</p>
                                                <p>3. Delivery charges, VAT & AIT to be added separately.</p>
                                                <p>4. For customized Quotation as per your need, Please mail us at "sales@malamal.com.bd".</p>
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="{{\App\CPU\translate('file.submit')}}" class="btn btn-primary" id="submit-button">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


<!--                <table class="table table-bordered table-condensed totals">
                        <td><strong>{{\App\CPU\translate('file.Items')}}</strong>
                            <span class="pull-right" id="item">0.00</span>
                        </td>
                        <td><strong>{{\App\CPU\translate('file.Total')}}</strong>
                            <span class="pull-right" id="subtotal">0.00</span>
                        </td>
                        <td><strong>{{\App\CPU\translate('file.Order Vat')}}</strong>
                            <span class="pull-right" id="order_tax">0.00</span>
                        </td>
                        <td><strong>{{\App\CPU\translate('file.Order Discount')}}</strong>
                            <span class="pull-right" id="order_discount">0.00</span>
                        </td>
                        <td><strong>{{\App\CPU\translate('file.Shipping Cost')}}</strong>
                            <span class="pull-right" id="shipping_cost">0.00</span>
                        </td>
                    <td><strong>{{\App\CPU\translate('file.excluding_grand_total')}}</strong>
                        <span class="pull-right" id="excluding_grand_total">0.00</span>
                    </td>
                        <td><strong>{{\App\CPU\translate('file.including_grand_total')}}</strong>
                            <span class="pull-right" id="grand_total">0.00</span>
                        </td>
                    </table>-->

               @include('admin-views.quotation.modal')
            </div>
        </div>
    </div>


@endsection

@push('script')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js" integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">

var lims_product_array = [];
var product_code = [];
var product_name = [];
var product_qty = [];
var product_type = [];
var product_id = [];
var product_list = [];
var qty_list = [];

// array data with selection
var product_price = [];
var product_discount = [];
var tax_rate = [];
var tax_name = [];
var tax_method = [];
var unit_name = [];
var unit_operator = [];
var unit_operation_value = [];

// temporary array
var temp_unit_name = [];
var temp_unit_operator = [];
var temp_unit_operation_value = [];

var rowindex;
var customer_group_rate=0;
var row_product_price;
var pos;
var cartData = '{!! $cartData; !!}';


$('[data-toggle="tooltip"]').tooltip();

	$.get('getProducts', function(data) {
	        lims_product_array = [];
	        product_code = data[0];
	        product_name = data[1];
	        product_qty = data[2];
            product_type = data[3];
            product_id = data[4];
            product_list = data[5];
            qty_list = data[6];
	        $.each(product_code, function(index) {
	            lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
	        });
	    });

	$('#lims_productcodeSearch').on('input', function(){
	    var customer_id = $('#customer_id').val();
	    temp_data = $('#lims_productcodeSearch').val();
	    if(!customer_id){
	        $('#lims_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
	        alert('Please select Customer!');
	    }
	});

	var lims_productcodeSearch = $('#lims_productcodeSearch');

	lims_productcodeSearch.autocomplete({
	    source: function(request, response) {
	        var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
	        response($.grep(lims_product_array, function(item) {
	            return matcher.test(item);
	        }));
	    },
        response: function(event, ui) {
           /* if (ui.content.length == 1) {
                var data = ui.content[0].value;
                $(this).autocomplete( "close" );
                productSearch(data);
            };*/
        },
	    select: function(event, ui) {
	        var data = ui.item.value;
           // productSearch(data);
            addNewProduct(data);
	    }
	});

	//Change quantity


    function removeProduct(key) {
        console.log('data');

        var id = key;
        $.ajax({
            type: 'GET',
            url: 'quotation_session_remove',
            data: {
                id: id
            },
            success: function(data) {
                if(data.status == 'success') {
                    $(".quotation_session").empty().html(data.view);
                    $("input[name='product_code_name']").val('');
                    cartData = data.cartItem;
                    alert("quotation remove successfully");
                } else {
                    var errorMessage = data.error;
                    console.log(errorMessage);
                    alert(errorMessage);
                    $("input[name='product_code_name']").val('');
                }
            }
        });

    }

$(window).keydown(function(e){
    if (e.which == 13) {
        var $targ = $(e.target);
        if (!$targ.is("textarea") && !$targ.is(":button,:submit")) {
            var focusNext = false;
            $(this).find(":input:visible:not([disabled],[readonly]), a").each(function(){
                if (this === e.target) {
                    focusNext = true;
                }
                else if (focusNext){
                    $(this).focus();
                    return false;
                }
            });
            return false;
        }
    }
});

$('#quotation-form').on('submit',function(e){
    var rownumber = $('table.order-list tbody tr:last').index();
    if (rownumber < 0) {
        alert("Please insert product to order table!")
        e.preventDefault();
    }
});

function productSearch(data){
    $.ajax({
        type: 'GET',
        url: 'product_search',
        data: {
            data: data
        },
        success: function(data) {
            var flag = 1;
            $(".product-code").each(function(i) {
                if ($(this).val() == data[1]) {
                    rowindex = i;
                    var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val()) + 1;
                    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
                    checkQuantity(String(qty), true);
                    flag = 0;
                }
            });
            $("input[name='product_code_name']").val('');
            if(flag){
                var newRow = $("<tr>");
                var cols = '';
                temp_unit_name = (data[6]).split(',');
                cols += '<td>' + data[0] + '<button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"> <i class="tio-edit"></i></button></td>';
                cols += '<td>' + data[1] + '</td>';
                cols += '<td><input type="number" class="form-control qty" name="qty[]" value="1" step="any" required/></td>';
                cols += '<td class="net_unit_price"></td>';
                cols += '<td class="discount">0.00</td>';
                cols += '<td class="tax"></td>';
                cols += '<td class="sub-total"></td>';
                cols += '<td><button type="button" class="ibtnDel btn btn-md btn-danger">{{\App\CPU\translate("file.delete")}}</button></td>';
                cols += '<input type="hidden" class="product-code" name="product_code[]" value="' + data[1] + '"/>';
                cols += '<input type="hidden" name="product_id[]" value="' + data[9] + '"/>';
                cols += '<input type="hidden" class="sale-unit" name="sale_unit[]" value="' + temp_unit_name[0] + '"/>';
                cols += '<input type="hidden" class="net_unit_price" name="net_unit_price[]" />';
                cols += '<input type="hidden" class="discount-value" name="discount[]" />';
                cols += '<input type="hidden" class="tax-rate" name="tax_rate[]" value="' + data[3] + '"/>';
                cols += '<input type="hidden" class="tax-value" name="tax[]" />';
                cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';

                newRow.append(cols);
                $("table.order-list tbody").append(newRow);

                product_price.push(parseFloat(data[2]) + parseFloat(data[2] * customer_group_rate));
                product_discount.push('0.00');
                tax_rate.push(parseFloat(data[3]));
                tax_name.push(data[4]);
                tax_method.push(data[5]);
                unit_name.push(data[6]);
                unit_operator.push(data[7]);
                unit_operation_value.push(data[8]);
                rowindex = newRow.index();
                checkQuantity(1, true);
            }
        }
    });
}

function addNewProduct(data){
    $.ajax({
        type: 'GET',
        url: 'quotation_session_insert',
        data: {
            data: data
        },
        success: function(data) {
            if(data.status == 'success') {
                $(".quotation_session").empty().html(data.view);
                cartData = data.cartItem;
                $("input[name='product_code_name']").val('');
            } else {
                var errorMessage = data.error;
                console.log(errorMessage);
                alert(errorMessage);
                $("input[name='product_code_name']").val('');
            }
        }
    });
}




function editinput(key) {
    // console.log(key);
    // console.log(cartData);
    var cartDataObject = JSON.parse(cartData);
    var singleCartData = cartDataObject[key];

    $("#editModal").modal('hide');
    $("#editModal").modal('show');

    var row_product_name = singleCartData.name;
    var row_product_code = singleCartData.code;
    if(row_product_code != null){
        $('#modal_header').text(row_product_name + '(' + row_product_code + ')');
    }else{
        $('#modal_header').text(row_product_name);
    }
    
    $('input[name="edit_qty"]').val(singleCartData.qty);
    // $('input[name="edit_discount"]').val(parseFloat(singleCartData.discount).toFixed(2));
    $('input[name="edit_unit_price"]').val(singleCartData.price);
    // $('input[name="vat_rate"]').val(singleCartData.vat_rate);
    $('input[name="product_id"]').val(singleCartData.id);
    $('input[name="edit_description"]').val(singleCartData.description);
// console.log(singleCartData);
}


function singleSubmit() {
    var formData=$('#cartForm').serialize();
    $.ajax({
        type: 'GET',
        url: 'quotation_session_update',
        data: formData,
        success: function(data) {
            if(data.status == 'success') {
                $(".quotation_session").empty().html(data.view);
                $("input[name='product_code_name']").val('');
                cartData = data.cartItem;
                $("#editModal").modal('hide');
                // alert("quotation update successfully");
                toastr.success("quotation updated successfully", {
                                CloseButton: true,
                                ProgressBar: true
                            });
            } else {
                var errorMessage = data.error;
                // console.log(errorMessage);
                alert(errorMessage);
                $("input[name='product_code_name']").val('');
            }
        }
    });
}


$('.shipping_cost').on('change', function (){
  calculateShippingCharge();
});

$('.shipping_vat').on('change', function (){
   calculateShippingCharge();
});

function calculateShippingCharge() {
    var shippingCost = $('.shipping_cost').val();
    var shippingVatInPer = $('.shipping_vat').val();
    var shippingVat = (shippingCost*shippingVatInPer) / 100;
    var shippingAmt = parseFloat(shippingCost,2)+parseFloat(shippingVat,2);
    $('.shipping_amt').val(shippingAmt);
}

$('.subject_input').on('change', function (){
    var subjectData = $(this).val();
    $('.quotation_subject').val(subjectData);
})

// $('.customer_select').on('change', function (){
//     var customer_id = $(this).val();
//     $('.quotation_customer').val(customer_id);
// })
$('.customer_select').on('change', function (){
    var customer_id = $(this).val();
    $('#quotation_customer').val(customer_id);
    $('#quotation_cust_id').val(customer_id);
    // customer data
    var _token = "{{ csrf_token() }}";
            //alert(identity);      
    $.ajax({
        type: 'POST',
        url: "{{ route('admin.customer.get_quotation_customer') }}",
        data: {
            customer_id: customer_id,
            _token: _token
        },
        success: function(data) {
            if (data.response == "success") {
              $('#customer_info').css('display','block');
               var quote_contact=data.quotation_contact;
               if(quote_contact)
               {
                $('#quote_company_name').html(quote_contact.company);
                $('#quote_address').html(quote_contact.address);
                $('#quote_cust_email').html(quote_contact.email);
                $('#quote_cust_phone').html(quote_contact.phone);
                $('#quotation_edit_id').val(quote_contact.id);
                $('#quote_company').val(quote_contact.company);
                $('#quote_company_address').val(quote_contact.address);
                $('#quote_email').val(quote_contact.email);
                $('#quote_phone').val(quote_contact.phone);
                $('#quotation_cust_id').val(customer_id);
               }
               else{
                $("#customer_info").load(" #customer_info > *");
                $('#quote_company_name').html();
                $('#quote_address').html();
                $('#quote_cust_email').html();
                $('#quote_cust_phone').html();
                $('#quotation_edit_id').val();
                $('#quote_company').val();
                $('#quote_company_address').val();
                $('#quote_email').val();
                $('#quote_phone').val();
                $('#quotation_cust_id').val(customer_id);
               }
    
            }

        }
    });
})
$('.tio-barcode-btn').on('click', function ($e){
    $e.preventDefault();
});
</script>
<script>
    function vat_status_change()
    {
        var quotation_vat_status=$('#quotation_vat_status').val();
        if(quotation_vat_status==1)
        {
            $('#quotation_vat_id').css('display','block');
            $('#shipping_vat_id').css('display','block');
        }
        else{
            $('#quotation_vat_id').css('display','none');
            $('#shipping_vat_id').css('display','none');
        }
    }
</script>
       {{-- ck editor --}}
       <script src="{{ asset('/') }}vendor/ckeditor/ckeditor/ckeditor.js"></script>
       <script src="{{ asset('/') }}vendor/ckeditor/ckeditor/adapters/jquery.js"></script>
       <script>
           $('.textarea').ckeditor({
               contentsLangDirection: '{{ Session::get('direction') }}',
           });
       </script>
   
       {{-- ck editor --}}
@endpush