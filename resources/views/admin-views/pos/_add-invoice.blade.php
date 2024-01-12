@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('POS'))
@section('content')
<!-- Content -->
<!--Add Invoice -->
<section class="section-content pt-5">
	<div class="container-fluid">

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <h5 class="p-3 m-0 bg-light">{{\App\CPU\translate('Product_Section')}}</h5>
            <div class="panel-body">
                <form action="" class="form-vertical" id="insert_sale" name="insert_sale" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                <div class="row">

                    <div class="col-sm-6" id="payment_from_1">
                        <div class="form-group row">
                            <label for="customer_name" class="col-sm-3 col-form-label">Customer Name/Phone <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" size="100" name="customer_name" class=" form-control"
                                    placeholder='Customer Name/Phone'
                                    id="customer_name" tabindex="1" onkeyup="customer_autocomplete()"
                                    value="" />

                                <input id="autocomplete_customer_id" class="customer_hidden_value abc" type="hidden"
                                    name="customer_id" value="">
                            </div>
                                                        <div class=" col-sm-3">
                                <a href="#" class="client-add-btn btn btn-success" aria-hidden="true"
                                    data-toggle="modal" data-target="#cust_info"><i class="ti-plus m-r-2"></i></a>
                            </div>
                                                    </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label">Date <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                                                <input class="datepicker form-control" type="text" size="50" name="invoice_date"
                                    id="date" required value="2023-01-11" tabindex="4" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6" id="bank_div">
                        <div class="form-group row">
                            <label for="bank" class="col-sm-3 col-form-label">Bank <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select name="bank_id" class="form-control bankpayment" id="bank_id">
                                    <option value="">Select Location</option>
                                                                    </select>

                            </div>

                        </div>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="normalinvoice">
                        <thead>
                            <tr>
                                <th class="text-center product_field">Item Information <i
                                        class="text-danger">*</i></th>
                                <th class="text-center">Desc</th>
                                <th class="text-center">Av. Qnty.</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Qnty <i class="text-danger">*</i>
                                </th>
                                <th class="text-center">Rate <i class="text-danger">*</i></th>

                                                                <th class="text-center invoice_fields">Discount %
                                </th>
                                                                <th class="text-center invoice_fields">Dis. Value </th>
                                <th class="text-center invoice_fields">Vat % </th>
                                <th class="text-center invoice_fields">VAT Value </th>
                                <th class="text-center invoice_fields">Total                                </th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="addinvoiceItem">
                            <tr>
                                <td class="product_field">
                                    <input type="text" required name="product_name" onkeypress="invoice_productList(1)"
                                        id="product_name_1" class="form-control productSelection"
                                        placeholder="Product Name" tabindex="5">

                                    <input type="hidden" class="autocomplete_hidden_value product_id_1"
                                        name="product_id[]" id="SchoolHiddenId" />

                                    <input type="hidden" class="baseUrl" value="https://url/" />
                                </td>
                                <td>
                                    <input type="text" name="desc[]" class="form-control text-right " tabindex="6" />
                                </td>
                                <td>
                                    <input type="text" name="available_quantity[]"
                                        class="form-control text-right available_quantity_1" value="0" readonly="" />
                                </td>
                                <td>
                                    <input name="" id="" class="form-control text-right unit_1 valid" value="None"
                                        readonly="" aria-invalid="false" type="text">
                                </td>
                                <td>
                                    <input type="text" name="product_quantity[]" required=""
                                        onkeyup="bdtask_invoice_quantity_calculate(1);"
                                        onchange="bdtask_invoice_quantity_calculate(1);"
                                        class="total_qntt_1 form-control text-right" id="total_qntt_1"
                                        placeholder="0.00" min="0" tabindex="8" value="1" />
                                </td>
                                <td class="invoice_fields">
                                    <input type="text" name="product_rate[]" id="price_item_1"
                                        class="price_item1 price_item form-control text-right" tabindex="9" required=""
                                        onkeyup="bdtask_invoice_quantity_calculate(1);"
                                        onchange="bdtask_invoice_quantity_calculate(1);" placeholder="0.00" min="0" />
                                </td>
                                <!-- Discount -->
                                <td>
                                    <input type="text" name="discount[]" onkeyup="bdtask_invoice_quantity_calculate(1);"
                                        onchange="bdtask_invoice_quantity_calculate(1);" id="discount_1"
                                        class="form-control text-right" min="0" tabindex="10" placeholder="0.00" />
                                    <input type="hidden" value="1" name="discount_type"
                                        id="discount_type_1">

                                </td>
                                <td>
                                    <input type="text" name="discountvalue[]" id="discount_value_1"
                                        class="form-control text-right" min="0" tabindex="18" placeholder="0.00"
                                        readonly />
                                </td>

                                <!-- VAT  -->
                                <td>
                                    <input type="text" name="vatpercent[]"
                                        onkeyup="bdtask_invoice_quantity_calculate(1);"
                                        onchange="bdtask_invoice_quantity_calculate(1);" id="vat_percent_1"
                                        class="form-control text-right" min="0" tabindex="19" placeholder="0.00" />

                                </td>
                                <td>
                                    <input type="text" name="vatvalue[]" id="vat_value_1"
                                        class="form-control text-right total_vatamnt" min="0" tabindex="20"
                                        placeholder="0.00" readonly />
                                </td>
                                <!-- VAT end -->

                                <td class="invoice_fields">
                                    <input class="total_price form-control text-right" type="text" name="total_price[]"
                                        id="total_price_1" value="0.00" readonly="readonly" />
                                </td>

                                <td>


                                    <!-- Discount calculate start-->
                                    <input type="hidden" id="total_discount_1" class="" />
                                    <input type="hidden" id="all_discount_1" class="total_discount dppr"
                                        name="discount_amount[]" />
                                    <!-- Discount calculate end -->

                                    <button class='btn btn-danger text-right' type='button' value='Delete'
                                        onclick='deleteRow_invoice(this)'><i class='fa fa-close'></i></button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="9" rowspan="2">
                                    <center><label for="details"
                                            class="  col-form-label text-center">Sale Details</label>
                                    </center>
                                    <textarea name="inva_details" id="details" class="form-control"
                                        placeholder="Sale Details" tabindex="12"></textarea>
                                </td>
                                <td class="text-right" colspan="1"><b>Sale Discount:</b>
                                </td>
                                <td class="text-right">
                                    <input type="text" onkeyup="bdtask_invoice_quantity_calculate(1);"
                                        onchange="bdtask_invoice_quantity_calculate(1);" id="invoice_discount"
                                        class="form-control text-right total_discount" name="invoice_discount"
                                        placeholder="0.00" tabindex="13" />
                                    <input type="hidden" id="txfieldnum">
                                </td>
                                <td><a href="javascript:void(0)" id="add_invoice_item" class="btn btn-info"
                                        name="add-invoice-item" onClick="addInputField_invoice('addinvoiceItem');"
                                        tabindex="11"><i class="fa fa-plus"></i></a></td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="1"><b>Total Discount:</b></td>
                                <td class="text-right">
                                    <input type="text" id="total_discount_ammount" class="form-control text-right"
                                        name="total_discount" value="0.00" readonly="readonly" />
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="11"><b>Total VAT:</b></td>
                                <td class="text-right">
                                    <input type="text" id="total_vat_amnt" class="form-control text-right"
                                        name="total_vat_amnt" value="0.00" readonly="readonly" />
                                </td>
                            </tr>

                            <tr>
                            <tr>
                                <td class="text-right" colspan="11"><b>Shipping Cost:</b></td>
                                <td class="text-right">
                                    <input type="text" id="shipping_cost" class="form-control text-right"
                                        name="shipping_cost" onkeyup="bdtask_invoice_quantity_calculate(1);"
                                        onchange="bdtask_invoice_quantity_calculate(1);" placeholder="0.00"
                                        tabindex="14" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="11" class="text-right"><b>Grand Total:</b></td>
                                <td class="text-right">
                                    <input type="text" id="grandTotal" class="form-control text-right grandTotalamnt"
                                        name="grand_total_price" value="0.00" readonly="readonly" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="11" class="text-right"><b>Previous:</b></td>
                                <td class="text-right">
                                    <input type="text" id="previous" class="form-control text-right" name="previous"
                                        value="0.00" readonly="readonly" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="11" class="text-right"><b>Net Total:</b></td>
                                <td class="text-right">
                                    <input type="text" id="n_total" class="form-control text-right" name="n_total"
                                        value="0" readonly="readonly" placeholder="" />
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="11"><b>Paid Amount:</b></td>
                                <td class="text-right">
                                    <input type="hidden" name="baseUrl" class="baseUrl"
                                        value="https://test.zahidul.me/" />
                                    <input type="text" id="paidAmount" onkeyup="invoice_paidamount();"
                                        class="form-control text-right" name="paid_amount" placeholder="0.00"
                                        tabindex="15" value="" />
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="11"><b>Due:</b></td>
                                <td class="text-right">
                                    <input type="text" id="dueAmmount" class="form-control text-right" name="due_amount"
                                        value="0.00" readonly="readonly" />
                                </td>
                            </tr>
                            <tr>

                                <td colspan="11" class="text-right"><b>Change:</b></td>
                                <td class="text-right">
                                    <input type="text" id="change" class="form-control text-right" name="change"
                                        value="0" readonly="readonly" placeholder="" />
                                    <input type="hidden" name="is_normal" value="1">
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <input type="hidden" name="finyear" value="1">
                    <p hidden id="old-amount">0</p>
                    <p hidden id="pay-amount"></p>
                    <p hidden id="change-amount"></p>
                    <div class="col-sm-6 table-bordered p-20">
                        <div id="adddiscount" class="display-none">
                            <div class="row no-gutters">
                                <div class="form-group col-md-6">
                                    <label for="payments"
                                        class="col-form-label pb-2">Payment Type</label>

                                    <select name="multipaytype[]"  onchange = "check_creditsale()" class="card_typesl postform resizeselect form-control ">
<option value="">Select Method</option>
<option value="0">Credit Sale</option>
<option value="1020101" selected="selected">Cash In Hand</option>
<option value="1020102">Petty Cash</option>
<option value="1020501">bKash</option>
<option value="1020502">PortWallet</option>
</select>

                                </div>
                                <div class="form-group col-md-6">
                                    <label for="4digit"
                                        class="col-form-label pb-2">Paid Amount</label>

                                    <input type="text" id="pamount_by_method" class="form-control number pay "
                                        name="pamount_by_method[]" value="" onkeyup="changedueamount()"
                                        placeholder="0" />

                                </div>
                            </div>

                            <div class="" id="add_new_payment">



                            </div>
                            <div class="form-group text-right">
                                <div class="col-sm-12 pr-0">

                                    <button type="button" id="add_new_payment_type"
                                        class="btn btn-success w-md m-b-5">Add New Payment Method</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="form-group row text-right">
                    <div class="col-sm-12 p-20">
                        <input type="submit" id="add_invoice" class="btn btn-success" name="add-invoice"
                            value="Submit" tabindex="17" />

                    </div>
                </div>
                </form>            </div>

        </div>
    </div>


</div>
</div>
</section>

	<!-- ========================= SECTION CONTENT ========================= -->
    <!-- End Content -->
    <div class="modal fade pt-5" id="quick-view" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="quick-view-modal">

            </div>
        </div>
    </div>

    @php($order=\App\Model\Order::find(session('last_order')))
    @if($order)
    @php(session(['last_order'=> false]))
    <div class="modal fade py-5" id="print-invoice" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\translate('Print Invoice')}}</h5>
                    <button id="invoice_close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12">
                        <center>
                            <input id="print_invoice" type="button" class="btn btn--primary non-printable" onclick="printDiv('printableArea')"
                                value="Proceed, If thermal printer is ready."/>
                            <a href="{{url()->previous()}}" class="btn btn-danger non-printable">{{\App\CPU\translate('Back')}}</a>
                        </center>
                        <hr class="non-printable">
                    </div>
                    <div class="row m-auto" id="printableArea">
                        @include('admin-views.pos.order.invoice')
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif


@include('admin-views.pos.modal')
@endsection

@push('script_2')
<script>

        function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
            callback.apply(context, args);
            }, ms || 0);
        };
        }

    $(document).on('ready', function () {
        $.ajax({
            url: '{{route('admin.pos.get-cart-ids')}}',
            type: 'GET',

            dataType: 'json', // added data type
            beforeSend: function () {
                $('#loading').removeClass('d-none');
                //console.log("loding");
            },
            success: function (data) {
                //console.log(data.cus);
                var output = '';
                    for(var i=0; i<data.cart_nam.length; i++) {
                        output += `<option value="${data.cart_nam[i]}" ${data.current_user==data.cart_nam[i]?'selected':''}>${data.cart_nam[i]}</option>`;
                    }
                    $('#cart_id').html(output);
                    $('#current_customer').text(data.current_customer);
                    $('#cart').empty().html(data.view);

            },
            complete: function () {
                $('#loading').addClass('d-none');
            },
        });
    });

    function form_submit(){
        Swal.fire({
            title: '{{\App\CPU\translate('Are you sure')}}?',
            type: 'warning',
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then(function (result) {
            if(result.value){
                $('#order_place').submit();
            }
        });
    }
</script>
<script>
    document.addEventListener("keydown", function(event) {
    "use strict";
    if (event.altKey && event.code === "KeyO")
    {
        $('#submit_order').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyZ")
    {
        $('#payment_close').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyS")
    {
        $('#order_complete').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyC")
    {
        emptyCart();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyA")
    {
        $('#add_new_customer').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyN")
    {
        $('#submit_new_customer').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyK")
    {
        $('#short-cut').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyP")
    {
        $('#print_invoice').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyQ")
    {
        $('#search').focus();
        $("#-pos-search-box").css("display", "none");
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyE")
    {
        $("#pos-search-box").css("display", "none");
        $('#extra_discount').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyD")
    {
        $("#pos-search-box").css("display", "none");
        $('#coupon_discount').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyB")
    {
        $('#invoice_close').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyX")
    {
        clear_cart();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyR")
    {
        new_order();
        event.preventDefault();
    }

});
</script>
<!-- JS Plugins Init. -->
<script>
    jQuery(".search-bar-input").on('keyup',function () {
        //$('#pos-search-box').removeClass('d-none');
        $(".pos-search-card").removeClass('d-none').show();
        let name = $(".search-bar-input").val();
        //console.log(name);
        if (name.length >0) {
            $('#pos-search-box').removeClass('d-none').show();
            $.get({
                url: '{{route('admin.pos.search-products')}}',
                dataType: 'json',
                data: {
                    name: name
                },
                beforeSend: function () {
                    $('#loading').removeClass('d-none');
                },
                success: function (data) {
                    //console.log(data.count);

                    $('.search-result-box').empty().html(data.result);
                    if(data.count==1)
                    {
                        $('.search-result-box').empty().hide();
                        $('#search').val('');
                        quickView(data.id);
                    }

                },
                complete: function () {
                    $('#loading').addClass('d-none');
                },
            });
        } else {
            $('.search-result-box').empty();
        }
    });
</script>
<script>
    "use strict";
    function customer_change(val) {
        //let  cart_id = $('#cart_id').val();
        $.post({
                url: '{{route('admin.pos.remove-discount')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    //cart_id:cart_id,
                    user_id:val
                },
                beforeSend: function () {
                    $('#loading').removeClass('d-none');
                },
                success: function (data) {
                    console.log(data);

                    var output = '';
                    for(var i=0; i<data.cart_nam.length; i++) {
                        output += `<option value="${data.cart_nam[i]}" ${data.current_user==data.cart_nam[i]?'selected':''}>${data.cart_nam[i]}</option>`;
                    }
                    $('#cart_id').html(output);
                    $('#current_customer').text(data.current_customer);
                    $('#cart').empty().html(data.view);
                    $('')
                },
                complete: function () {
                    $('#loading').addClass('d-none');
                }
            });
    }
</script>
<script>
    "use strict";
    function clear_cart()
    {
        let url = "{{route('admin.pos.clear-cart-ids')}}";
        document.location.href=url;
    }
</script>
<script>
    "use strict";
    function new_order()
    {
        let url = "{{route('admin.pos.new-cart-id')}}";
        document.location.href=url;
    }
</script>
<script>
    "use strict";
    function cart_change(val)
    {
        let  cart_id = val;
        let url = "{{route('admin.pos.change-cart')}}"+'/?cart_id='+val;
        document.location.href=url;
    }
</script>
<script>
    "use strict";
    function extra_discount()
    {
        //let  user_id = $('#customer').val();
        let discount = $('#dis_amount').val();
        let type = $('#type_ext_dis').val();
        //let  cart_id = $('#cart_id').val();
        if(discount > 0)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.pos.discount')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    discount:discount,
                    type:type,
                    //cart_id:cart_id
                },
                beforeSend: function () {
                    $('#loading').removeClass('d-none');
                },
                success: function (data) {
                   // console.log(data);
                    if(data.extra_discount==='success')
                    {
                        toastr.success('{{ \App\CPU\translate('extra_discount_added_successfully') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }else if(data.extra_discount==='empty')
                    {
                        toastr.warning('{{ \App\CPU\translate('your_cart_is_empty') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });

                    }else{
                        toastr.warning('{{ \App\CPU\translate('this_discount_is_not_applied_for_this_amount') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }

                    $('.modal-backdrop').addClass('d-none');
                    $('#cart').empty().html(data.view);

                    $('#search').focus();
                },
                complete: function () {
                    $('.modal-backdrop').addClass('d-none');
                    $(".footer-offset").removeClass("modal-open");
                    $('#loading').addClass('d-none');
                }
            });
        }else{
            toastr.warning('{{ \App\CPU\translate('amount_can_not_be_negative_or_zero!') }}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    }

    function calculate_vat()
    {
        //let  user_id = $('#customer').val();
        let vat_amount = $('#vat_amount').val();
        let type = $('#type_vat').val();
        if(vat_amount > 0)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.pos.vat')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    amount:vat_amount,
                    type:type,
                    //cart_id:cart_id
                },
                beforeSend: function () {
                    $('#loading').removeClass('d-none');
                },
                success: function (data) {
                    // console.log(data);
                    if(data.status==='success')
                    {
                        toastr.success('Vat added successfully', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }else if(data.vat==='empty')
                    {
                        toastr.warning('{{ \App\CPU\translate('your_cart_is_empty') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });

                    }else{
                        toastr.warning('{{ \App\CPU\translate('this_discount_is_not_applied_for_this_amount') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }

                    $('.modal-backdrop').addClass('d-none');
                    $('#cart').empty().html(data.view);

                    $('#search').focus();
                },
                complete: function () {
                    $('.modal-backdrop').addClass('d-none');
                    $(".footer-offset").removeClass("modal-open");
                    $('#loading').addClass('d-none');
                }
            });
        }else{
            toastr.warning('{{ \App\CPU\translate('amount_can_not_be_negative_or_zero!') }}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    }

    function calculate_fee() {
        let fee_title = $('#additional_fee_title').val();
        let fee_amount = $('#additional_fee_amount').val();
        if(fee_amount != 0 && fee_amount != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.pos.fee')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    amount:fee_amount,
                    title:fee_title,
                    //cart_id:cart_id
                },
                beforeSend: function () {
                    $('#loading').removeClass('d-none');
                },
                success: function (data) {
                    if(data.status==='success')
                    {
                        toastr.success('Fee added successfully', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }else if(data.fee==='empty')
                    {
                        toastr.warning('{{ \App\CPU\translate('your_cart_is_empty') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });

                    }else{
                        toastr.warning('{{ \App\CPU\translate('this_discount_is_not_applied_for_this_amount') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }

                    $('.modal-backdrop').addClass('d-none');
                    $('#cart').empty().html(data.view);

                    $('#search').focus();
                },
                complete: function () {
                    $('.modal-backdrop').addClass('d-none');
                    $(".footer-offset").removeClass("modal-open");
                    $('#loading').addClass('d-none');
                }
            });
        }else{
            toastr.warning('{{ \App\CPU\translate('amount_can_not_be_negative_or_zero!') }}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    }
    
    function calculate_pos_shipping_amount() {
    
        let fee_amount = $('#pos_shipping_amount').val();
        if(fee_amount != 0 && fee_amount != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.pos.shipping-fee')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    pos_shipping_amount:fee_amount,
                    //cart_id:cart_id
                },
                beforeSend: function () {
                    $('#loading').removeClass('d-none');
                },
                success: function (data) {
                    if(data.status==='success')
                    {
                        toastr.success('Shipping Fee added successfully', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }else if(data.fee==='empty')
                    {
                        toastr.warning('{{ \App\CPU\translate('your_cart_is_empty') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });

                    }else{
                        toastr.warning('{{ \App\CPU\translate('this_discount_is_not_applied_for_this_amount') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }

                    $('.modal-backdrop').addClass('d-none');
                    $('#cart').empty().html(data.view);

                    $('#search').focus();
                },
                complete: function () {
                    $('.modal-backdrop').addClass('d-none');
                    $(".footer-offset").removeClass("modal-open");
                    $('#loading').addClass('d-none');
                }
            });
        }else{
            toastr.warning('{{ \App\CPU\translate('amount_can_not_be_negative_or_zero!') }}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    }
</script>
<script>
    "use strict";
    function coupon_discount()
    {

        let  coupon_code = $('#coupon_code').val();

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.pos.coupon-discount')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    coupon_code:coupon_code,
                },
                beforeSend: function () {
                    $('#loading').removeClass('d-none');
                },
                success: function (data) {
                    console.log(data);
                    if(data.coupon === 'success')
                    {
                        toastr.success('{{ \App\CPU\translate('coupon_added_successfully') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }else if(data.coupon === 'amount_low')
                    {
                        toastr.warning('{{ \App\CPU\translate('this_discount_is_not_applied_for_this_amount') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }else if(data.coupon === 'cart_empty')
                    {
                        toastr.warning('{{ \App\CPU\translate('your_cart_is_empty') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                    else {
                        toastr.warning('{{ \App\CPU\translate('coupon_is_invalid') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }

                    $('#cart').empty().html(data.view);

                    $('#search').focus();
                },
                complete: function () {
                    $('.modal-backdrop').addClass('d-none');
                    $(".footer-offset").removeClass("modal-open");
                    $('#loading').addClass('d-none');
                }
            });

    }
</script>
<script>
    $(document).on('ready', function () {
        @if($order)
        $('#print-invoice').modal('show');
        @endif
    });
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        // location.reload();
    }

    function set_category_filter(id) {
        var nurl = new URL('{!!url()->full()!!}');
        nurl.searchParams.set('category_id', id);
        location.href = nurl;
    }


    $('#search-form').on('submit', function (e) {
        e.preventDefault();
        var keyword= $('#datatableSearch').val();
        var nurl = new URL('{!!url()->full()!!}');
        nurl.searchParams.set('keyword', keyword);
        location.href = nurl;
    });

    function store_key(key, value) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
        });
        $.post({
            url: '{{route('admin.pos.store-keys')}}',
            data: {
                key:key,
                value:value,
            },
            success: function (data) {
                toastr.success(key+' '+'{{\App\CPU\translate('selected')}}!', {
                    CloseButton: true,
                    ProgressBar: true
                });
            },
        });
    }

    function addon_quantity_input_toggle(e)
    {
        var cb = $(e.target);
        if(cb.is(":checked"))
        {
            cb.siblings('.addon-quantity-input').css({'visibility':'visible'});
        }
        else
        {
            cb.siblings('.addon-quantity-input').css({'visibility':'hidden'});
        }
    }
    function quickView(product_id) {
        $.ajax({
            url: '{{route('admin.pos.quick-view')}}',
            type: 'GET',
            data: {
                product_id: product_id
            },
            dataType: 'json', // added data type
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                // console.log("success...");
                // console.log(data);

                // $("#quick-view").removeClass('fade');
                // $("#quick-view").addClass('show');

                $('#quick-view').modal('show');
                $('#quick-view-modal').empty().html(data.view);
            },
            complete: function () {
                $('#loading').hide();
            },
        });
    }

    function checkAddToCartValidity() {
        return true;
        var names = {};
        $('#add-to-cart-form input:radio').each(function () { // find unique names
            names[$(this).attr('name')] = true;
        });
        var count = 0;
        $.each(names, function () { // then count them
            count++;
        });

        if (($('input:radio:checked').length - 1) == count) {
            return true;
        }
        return false;
    }

    function cartQuantityInitialize() {
        $('.btn-number').click(function (e) {
            e.preventDefault();

            var fieldName = $(this).attr('data-field');
            var type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());

            if (!isNaN(currentVal)) {
                if (type == 'minus') {

                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }

                } else if (type == 'plus') {

                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(0);
            }
        });

        $('.input-number').focusin(function () {
            $(this).data('oldValue', $(this).val());
        });

        $('.input-number').change(function () {

            minValue = parseInt($(this).attr('min'));
            maxValue = parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());

            var name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Cart',
                    text: 'Sorry, the minimum value was reached'
                });
                $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Cart',
                    text: 'Sorry, stock limit exceeded.'
                });
                $(this).val($(this).data('oldValue'));
            }
        });
        $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    }

    function getVariantPrice() {
        if ($('#add-to-cart-form input[name=quantity]').val() > 0 && checkAddToCartValidity()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{ route('admin.pos.variant_price') }}',
                data: $('#add-to-cart-form').serializeArray(),
                success: function (data) {

                    $('#add-to-cart-form #chosen_price_div').removeClass('d-none');
                    $('#add-to-cart-form #chosen_price_div #chosen_price').html(data.price);
                    $('#set-discount-amount').html(data.discount);
                }
            });
        }
    }

    function addToCart(form_id = 'add-to-cart-form') {
        if (checkAddToCartValidity()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('admin.pos.add-to-cart') }}',
                data: $('#' + form_id).serializeArray(),
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {

                    if (data.data == 1) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Cart',
                            text: '{{ \App\CPU\translate("Product already added in cart")}}'
                        });
                        return false;
                    } else if (data.data == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cart',
                            text: '{{ \App\CPU\translate("Sorry, product is out of stock.")}}'
                        });
                        return false;
                    }
                    $('.call-when-done').click();

                    toastr.success('{{ \App\CPU\translate("Item has been added in your cart!")}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    $('#cart').empty().html(data.view);
                    //updateCart();
                    $('.search-result-box').empty().hide();
                    $('#search').val('');
                },
                complete: function () {
                    $('#loading').hide();
                }
            });
        } else {
            Swal.fire({
                type: 'info',
                title: 'Cart',
                text: '{{ \App\CPU\translate("Please choose all the options")}}'
            });
        }
    }

    function removeFromCart(key) {
        //console.log(key);
        $.post('{{ route('admin.pos.remove-from-cart') }}', {_token: '{{ csrf_token() }}', key: key}, function (data) {

            $('#cart').empty().html(data.view);
            if (data.errors) {
                for (var i = 0; i < data.errors.length; i++) {
                    toastr.error(data.errors[i].message, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            } else {
                //updateCart();

                toastr.info('{{ \App\CPU\translate("Item has been removed from cart")}}', {
                    CloseButton: true,
                    ProgressBar: true
                });
            }


        });
    }

    function emptyCart() {
        Swal.fire({
            title: '{{\App\CPU\translate('Are_you_sure?')}}',
            text: '{{\App\CPU\translate('You_want_to_remove_all_items_from_cart!!')}}',
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#161853',
            cancelButtonText: '{{\App\CPU\translate("No")}}',
            confirmButtonText: '{{\App\CPU\translate("Yes")}}',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.post('{{ route('admin.pos.emptyCart') }}', {_token: '{{ csrf_token() }}'}, function (data) {
                    $('#cart').empty().html(data.view);
                    toastr.info('{{ \App\CPU\translate("Item has been removed from cart")}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                });
            }
        })
    }

    function updateCart() {
        $.post('<?php echo e(route('admin.pos.cart_items')); ?>', {_token: '<?php echo e(csrf_token()); ?>'}, function (data) {
            $('#cart').empty().html(data);
        });
    }

   $(function(){
        $(document).on('click','input[type=number]',function(){ this.select(); });
    });


    function updateQuantity(key,qty,e, variant=null){

        if(qty!==""){
            var element = $( e.target );
            var minValue = parseInt(element.attr('min'));
            // maxValue = parseInt(element.attr('max'));
            var valueCurrent = parseInt(element.val());

            //var key = element.data('key');

            $.post('{{ route('admin.pos.updateQuantity') }}', {_token: '{{ csrf_token() }}', key: key, quantity:qty, variant:variant}, function (data) {

                if(data.product_type==='physical' && data.qty<0)
                {
                    toastr.warning('{{\App\CPU\translate('product_quantity_is_not_enough!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                if(data.upQty==='zeroNegative')
                {
                    toastr.warning('{{\App\CPU\translate('Product_quantity_can_not_be_zero_or_less_than_zero_in_cart!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                if(data.qty_update==1){
                    toastr.success('{{\App\CPU\translate('Product_quantity_updated!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                $('#cart').empty().html(data.view);
            });
        }else{
            var element = $( e.target );
            var minValue = parseInt(element.attr('min'));
            var valueCurrent = parseInt(element.val());

            $.post('{{ route('admin.pos.updateQuantity') }}', {_token: '{{ csrf_token() }}', key: key, quantity:minValue, variant:variant}, function (data) {

                if(data.product_type==='physical' && data.qty<0)
                {
                    toastr.warning('{{\App\CPU\translate('product_quantity_is_not_enough!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                if(data.upQty==='zeroNegative')
                {
                    toastr.warning('{{\App\CPU\translate('Product_quantity_can_not_be_zero_or_less_than_zero_in_cart!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                if(data.qty_update==1){
                    toastr.success('{{\App\CPU\translate('Product_quantity_updated!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                $('#cart').empty().html(data.view);
            });
        }

        // Allow: backspace, delete, tab, escape, enter and .
        if(e.type == 'keydown')
        {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        }

    };


    function updateCartPrice(key,price,e, variant=null){

        if(price!==""){
            var element = $( e.target );
            var minValue = parseInt(element.attr('min'));
            // maxValue = parseInt(element.attr('max'));
            var valueCurrent = parseInt(element.val());

            //var key = element.data('key');

            $.post('{{ route('admin.pos.updatePrice') }}', {_token: '{{ csrf_token() }}', key: key, price:price, variant:variant}, function (data) {

                if(data.product_type==='physical' && data.price<0)
                {
                    toastr.warning('{{\App\CPU\translate('product_price_is_not_enough!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                if(data.upQty==='zeroNegative')
                {
                    toastr.warning('{{\App\CPU\translate('Product_price_can_not_be_zero_or_less_than_zero_in_cart!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                if(data.price_update==1){
                    toastr.success('{{\App\CPU\translate('Product_price_updated!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                $('#cart').empty().html(data.view);
            });
        }else{
            var element = $( e.target );
            var minValue = parseInt(element.attr('min'));
            var valueCurrent = parseInt(element.val());

            $.post('{{ route('admin.pos.updateQuantity') }}', {_token: '{{ csrf_token() }}', key: key, price:minValue, variant:variant}, function (data) {

                if(data.product_type==='physical' && data.price<0)
                {
                    toastr.warning('{{\App\CPU\translate('product_quantity_is_not_enough!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                if(data.upQty==='zeroNegative')
                {
                    toastr.warning('{{\App\CPU\translate('Product_quantity_can_not_be_zero_or_less_than_zero_in_cart!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                if(data.price_update==1){
                    toastr.success('{{\App\CPU\translate('Product_quantity_updated!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                $('#cart').empty().html(data.view);
            });
        }

        // Allow: backspace, delete, tab, escape, enter and .
        if(e.type == 'keydown')
        {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        }

    };

    // INITIALIZATION OF SELECT2
    // =======================================================
    // $('.js-select2-custom').each(function () {
    //     var select2 = $.HSCore.components.HSSelect2.init($(this));
    // });

    $('.js-data-example-ajax').select2({
        ajax: {
            url: '{{route('admin.pos.customers')}}',
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            __port: function (params, success, failure) {
                var $request = $.ajax(params);

                $request.then(success);
                $request.fail(failure);

                return $request;
            }
        }
    });

    $('#order_place').submit(function(eventObj) {
        if($('#customer').val())
        {
            $(this).append('<input type="hidden" name="user_id" value="'+$('#customer').val()+'" /> ');
        }
        return true;
    });

//Add Input Field Of Row
    "use strict";
function addInputField_invoice(t) {

    var row = $("#normalinvoice tbody tr").length;
    var count = row + 1;
      var  tab1 = 0;
      var  tab2 = 0;
      var  tab3 = 0;
      var  tab4 = 0;
      var  tab5 = 0;
      var  tab6 = 0;
      var  tab7 = 0;
      var  tab8 = 0;
      var  tab9 = 0;
      var  tab10 = 0;
      var  tab11 = 0;
      var  tab12 = 0;
      var  tab13 = 0;
      var  tab14 = 0;
      var  tab15 = 0;
    var limits = 500;
     var taxnumber = $("#txfieldnum").val();
    var tbfild ='';
    for(var i=0;i<taxnumber;i++){
        var taxincrefield = '<input id="total_tax'+i+'_'+count+'" class="total_tax'+i+'_'+count+'" type="hidden"><input id="all_tax'+i+'_'+count+'" class="total_tax'+i+'" type="hidden" name="tax[]">';
         tbfild +=taxincrefield;
    }
    if (count == limits)
        alert("You have reached the limit of adding " + count + " inputs");
    else {
        
        var a = "product_name_" + count,
                tabindex = count * 6,
                e = document.createElement("tr");
        tab1 = tabindex + 1;
        tab2 = tabindex + 2;
        tab3 = tabindex + 3;
        tab4 = tabindex + 4;
        tab5 = tabindex + 5;
        tab6 = tabindex + 6;
        tab7 = tabindex + 7;
        tab8 = tabindex + 8;
        tab9 = tabindex + 9;
        tab10 = tabindex + 10;
        tab11 = tabindex + 11;
        tab12 = tabindex + 12;
        tab13 = tabindex + 13;
        tab14 = tabindex + 14;
        tab15 = tabindex + 15;
       
        e.innerHTML = "<td><input type='text' name='product_name' onkeypress='invoice_productList(" + count + 
        ");' class='form-control productSelection common_product' placeholder='Product Name' id='" + a + 
        "' required tabindex='" + tab1 + "'><input type='hidden' class='common_product autocomplete_hidden_value  product_id_" + count + 
        "' name='product_id[]' id='SchoolHiddenId'/></td><td><input type='text' name='desc[]'' class='form-control text-right ' tabindex='" +
         tab2 + "'/></td><td><select class='form-control basic-single'  onchange='invoice_product_batch(" + count + ")' id='serial_no_" + count + "' name='serial_no[]' required aria-hidden='true' tabindex='" + tab3 + 
         "'><option></option></select></td> <td><input type='text' name='available_quantity[]' id='' class='form-control text-right common_avail_qnt available_quantity_" + 
         count + "' value='0' readonly='readonly' /></td><td><input class='form-control text-right common_name unit_" + count + 
         " valid' value='None' readonly='' aria-invalid='false' type='text'></td><td> <input type='text' name='product_quantity[]' value='1' required='required' onkeyup='bdtask_invoice_quantity_calculate(" + 
         count + ");' onchange='bdtask_invoice_quantity_calculate(" + count + ");' id='total_qntt_" + count + "' class='common_qnt total_qntt_" + 
         count + " form-control text-right'  placeholder='0.00' min='0' tabindex='" + tab3 + "'/></td><td><input type='text' name='product_rate[]' onkeyup='bdtask_invoice_quantity_calculate(" + 
         count + ");' onchange='bdtask_invoice_quantity_calculate(" + count + ");' id='price_item_" + count + "' class='common_rate price_item" + 
         count + " form-control text-right' required placeholder='0.00' min='0' tabindex='" + tab4 + "'/></td><td><input type='text' name='discount[]' onkeyup='bdtask_invoice_quantity_calculate(" 
         + count + ");' onchange='bdtask_invoice_quantity_calculate(" + count + ");' id='discount_" + count + "' class='form-control text-right common_discount' placeholder='0.00' min='0' tabindex='" + tab5 + 
         "' /><input type='hidden' value='' name='discount_type' id='discount_type_" + count + "'></td><td><input type='text' name='discountvalue[]'  id='discount_value_" + count + 
         "' class='form-control text-right common_discount' placeholder='0.00' min='0' tabindex='" + tab13 + "' readonly /></td><td><input type='text' name='vatpercent[]'  id='vat_percent_" + count + 
         "' onkeyup='bdtask_invoice_quantity_calculate(" + count + ");' onchange='bdtask_invoice_quantity_calculate(" + count + ");' class='form-control text-right common_discount' placeholder='0.00' min='0' tabindex='" + tab14 + 
         "'  /></td><td><input type='text' name='vatvalue[]'  id='vat_value_" + count + 
         "' class='form-control text-right common_discount total_vatamnt' placeholder='0.00' min='0' tabindex='" + tab15 + 
         "' readonly /></td><td class='text-right'><input class='common_total_price total_price form-control text-right' type='text' name='total_price[]' id='total_price_" + 
         count + "' value='0.00' readonly='readonly'/></td><td>"+tbfild+"<input type='hidden' id='all_discount_" + count 
         + "' class='total_discount dppr' name='discount_amount[]'/><button tabindex='" + tab5 + 
         "' style='text-align: right;' class='btn btn-danger' type='button' value='Delete' onclick='deleteRow_invoice(this)'><i class='fa fa-close'></i></button></td>",

                document.getElementById(t).appendChild(e),
                document.getElementById(a).focus(),
                document.getElementById("add_invoice_item").setAttribute("tabindex", tab6);
                document.getElementById("details").setAttribute("tabindex", tab7);
                document.getElementById("invoice_discount").setAttribute("tabindex", tab8);
                document.getElementById("shipping_cost").setAttribute("tabindex", tab9);    
                document.getElementById("paidAmount").setAttribute("tabindex", tab10);
                document.getElementById("add_invoice").setAttribute("tabindex", tab12);
                count++
    }
}

function addInputField_invoice_dynamic(t) {

    var row = $("#normalinvoice tbody tr").length;
    var count = row + 1;
      var  tab1 = 0;
      var  tab2 = 0;
      var  tab3 = 0;
      var  tab4 = 0;
      var  tab5 = 0;
      var  tab6 = 0;
      var  tab7 = 0;
      var  tab8 = 0;
      var  tab9 = 0;
      var  tab10 = 0;
      var  tab11 = 0;
      var  tab12 = 0;
      var  tab13 = 0;
      var  tab14 = 0;
      var  tab15 = 0;
    var limits = 500;
     var taxnumber = $("#txfieldnum").val();
    var tbfild ='';
    for(var i=0;i<taxnumber;i++){
        var taxincrefield = '<input id="total_tax'+i+'_'+count+'" class="total_tax'+i+'_'+count+'" type="hidden"><input id="all_tax'+i+'_'+count+'" class="total_tax'+i+'" type="hidden" name="tax[]">';
         tbfild +=taxincrefield;
    }
    if (count == limits)
        alert("You have reached the limit of adding " + count + " inputs");
    else {
        var a = "product_name_" + count,
                tabindex = count * 6,
                e = document.createElement("tr");
        tab1 = tabindex + 1;
        tab2 = tabindex + 2;
        tab3 = tabindex + 3;
        tab4 = tabindex + 4;
        tab5 = tabindex + 5;
        tab6 = tabindex + 6;
        tab7 = tabindex + 7;
        tab8 = tabindex + 8;
        tab9 = tabindex + 9;
        tab10 = tabindex + 10;
        tab11 = tabindex + 11;
        tab12 = tabindex + 12;
        tab13 = tabindex + 13;
        tab14 = tabindex + 14;
        tab15 = tabindex + 15;
        e.innerHTML = "<td><input type='text' name='product_name' onkeypress='invoice_productList(" + count + 
        ");' class='form-control productSelection common_product' placeholder='Product Name' id='" + a + 
        "' required tabindex='" + tab1 + "'><input type='hidden' class='common_product autocomplete_hidden_value  product_id_" + count + 
        "' name='product_id[]' id='SchoolHiddenId'/></td><td><input type='text' name='desc[]'' class='form-control text-right ' tabindex='" +
         tab2 + "'/></td><td><select class='form-control basic-single'  onchange='invoice_product_batch(" + count + ")' id='serial_no_" + count + "' name='serial_no[]' required aria-hidden='true' tabindex='" + tab3 + 
         "'><option></option></select></td> <td><input type='text' name='available_quantity[]' id='' class='form-control text-right common_avail_qnt available_quantity_" + 
         count + "' value='0' readonly='readonly' /></td><td><input class='form-control text-right common_name unit_" + count + 
         " valid' value='None' readonly='' aria-invalid='false' type='text'></td><td> <input type='text' name='product_quantity[]' value='1' required='required' onkeyup='bdtask_invoice_quantity_calculate(" + 
         count + ");' onchange='bdtask_invoice_quantity_calculate(" + count + ");' id='total_qntt_" + count + "' class='common_qnt total_qntt_" + 
         count + " form-control text-right'  placeholder='0.00' min='0' tabindex='" + tab3 + "'/></td><td><input type='text' name='product_rate[]' onkeyup='bdtask_invoice_quantity_calculate(" + 
         count + ");' onchange='bdtask_invoice_quantity_calculate(" + count + ");' id='price_item_" + count + "' class='common_rate price_item" + 
         count + " form-control text-right' required placeholder='0.00' min='0' tabindex='" + tab4 + "'/></td><td><input type='text' name='discount[]' onkeyup='bdtask_invoice_quantity_calculate(" 
         + count + ");' onchange='bdtask_invoice_quantity_calculate(" + count + ");' id='discount_" + count + "' class='form-control text-right common_discount' placeholder='0.00' min='0' tabindex='" + tab5 + 
         "' /><input type='hidden' value='' name='discount_type' id='discount_type_" + count + "'></td><td><input type='text' name='discountvalue[]'  id='discount_value_" + count + 
         "' class='form-control text-right common_discount' placeholder='0.00' min='0' tabindex='" + tab13 + "' readonly /></td><td class='text-right'><input class='common_total_price total_price form-control text-right' type='text' name='total_price[]' id='total_price_" + 
         count + "' value='0.00' readonly='readonly'/></td><td>"+tbfild+"<input type='hidden' id='all_discount_" + count 
         + "' class='total_discount dppr' name='discount_amount[]'/><button tabindex='" + tab5 + 
         "' style='text-align: right;' class='btn btn-danger' type='button' value='Delete' onclick='deleteRow_invoice(this)'><i class='fa fa-close'></i></button></td>",

                document.getElementById(t).appendChild(e),
                document.getElementById(a).focus(),
                document.getElementById("add_invoice_item").setAttribute("tabindex", tab6);
                document.getElementById("details").setAttribute("tabindex", tab7);
                document.getElementById("invoice_discount").setAttribute("tabindex", tab8);
                document.getElementById("shipping_cost").setAttribute("tabindex", tab9);    
                document.getElementById("paidAmount").setAttribute("tabindex", tab10);
                document.getElementById("add_invoice").setAttribute("tabindex", tab12);
                count++
    }
}
//Quantity calculat
    "use strict";
function bdtask_invoice_quantity_calculate(item) {
    var quantity = $("#total_qntt_" + item).val();
    var available_quantity = $(".available_quantity_" + item).val();
    var price_item = $("#price_item_" + item).val();
    var invoice_discount = $("#invoice_discount").val();
    var discount = $("#discount_" + item).val();
    var vat_percent = $("#vat_percent_" + item).val();
    var total_tax = $("#total_tax_" + item).val();
    var total_discount = $("#total_discount_" + item).val();
    var taxnumber = $("#txfieldnum").val();
    var dis_type = $("#discount_type").val();
    if (available_quantity != 0) {
        if (parseInt(quantity) > parseInt(available_quantity)) {
            var message = "You can Sale maximum " + available_quantity + " Items";
            toastr["error"](message);
            $("#total_qntt_" + item).val('');
            var quantity = 0;
            $("#total_price_" + item).val(0);
            for(var i=0;i<taxnumber;i++){
            $("#all_tax"+i+"_" + item).val(0);
               bdtask_invoice_quantity_calculate(item);
        }
        }
    }

if (quantity > 0 || discount > 0 || vat_percent > 0) {
        if (dis_type == 1) {
            var price = quantity * price_item;
            var dis = +(price * discount / 100);
            $("#discount_value_" + item).val(dis);
            $("#all_discount_" + item).val(dis);
            //Total price calculate per product
            var temp = price - dis;
            // product wise vat start
            var vat =+(temp * vat_percent / 100);
            $("#vat_value_" + item).val(vat);
            // product wise vat end
            var ttletax = 0;
            $("#total_price_" + item).val(temp);
             for(var i=0;i<taxnumber;i++){
           var tax = (temp) * $("#total_tax"+i+"_" + item).val();
           ttletax += Number(tax);
            $("#all_tax"+i+"_" + item).val(tax);
    }

          
        } else if (dis_type == 2) {
            var price = quantity * price_item;

            // Discount cal per product
            var dis = (discount * quantity);
            $("#discount_value_" + item).val(dis);
            $("#all_discount_" + item).val(dis);

            //Total price calculate per product
            var temp = price - dis;
            $("#total_price_" + item).val(temp);
            // product wise vat start
            var vat =+(temp * vat_percent / 100);
            $("#vat_value_" + item).val(vat);
            // product wise vat end

            var ttletax = 0;
             for(var i=0;i<taxnumber;i++){
           var tax = (temp) * $("#total_tax"+i+"_" + item).val();
           ttletax += Number(tax);
            $("#all_tax"+i+"_" + item).val(tax);
    }
        } else if (dis_type == 3) {
            var total_price = quantity * price_item;
             var dis =  discount;
            // Discount cal per product
            $("#discount_value_" + item).val(dis);
            $("#all_discount_" + item).val(dis);
            //Total price calculate per product
            var price = total_price - dis;
            $("#total_price_" + item).val(price);
            // product wise vat start
            var vat =+(price * vat_percent / 100);
            $("#vat_value_" + item).val(vat);
            // product wise vat end

             var ttletax = 0;
             for(var i=0;i<taxnumber;i++){
           var tax = (price) * $("#total_tax"+i+"_" + item).val();
           ttletax += Number(tax);
            $("#all_tax"+i+"_" + item).val(tax);
    }
        }
    } else {
        var n = quantity * price_item;
        var c = quantity * price_item * total_tax;
        $("#total_price_" + item).val(n),
                $("#all_tax_" + item).val(c)
    }
    invoice_calculateSum();
    var invoice_edit_page = $("#invoice_edit_page").val();
    var preload_pay_view = $("#preload_pay_view").val();
    
    $("#add_new_payment").empty();
   
    $("#pay-amount").text('0');
    $("#dueAmmount").val(0);
    if (invoice_edit_page == 1 ) {
        var base_url = $('#base_url').val();
        var is_credit_edit = $('#is_credit_edit').val();
        
        var csrf_test_name = $('[name="csrf_test_name"]').val();
        var gtotal=$(".grandTotalamnt").val();
        var url= base_url + "invoice/invoice/bdtask_showpaymentmodal";
        $.ajax({
            type: "post",
            url: url,
            data:{is_credit_edit:is_credit_edit,csrf_test_name:csrf_test_name},
            success: function(data) {
                
              
              $('#add_new_payment').append(data);
             
              $("#pamount_by_method").val(gtotal);
              $("#preload_pay_view").val('1');
              $("#add_new_payment_type").prop('disabled',false);
              var card_typesl = $('.card_typesl').val();
                if(card_typesl == 0){
                    $("#add_new_payment_type").prop('disabled',true);
                }
              
            }
          }); 
       
    }
    

}
//Calculate Sum
    "use strict";
function invoice_calculateSum() {
     var taxnumber = $("#txfieldnum").val();
      var t = 0,
            a = 0,
            e = 0,
            o = 0,
            p = 0,
            v = 0,
            f = 0,
            ad = 0,
            tx = 0,
            ds = 0,
            s_cost =  $("#shipping_cost").val();

    //Total Tax
   for(var i=0;i<taxnumber;i++){
      
var j = 0;
    $(".total_tax"+i).each(function () {
        isNaN(this.value) || 0 == this.value.length || (j += parseFloat(this.value))
    });
            $("#total_tax_ammount"+i).val(j.toFixed(2, 2));
             
    }
            //Total Discount
            $(".total_discount").each(function () {
                isNaN(this.value) || 0 == this.value.length || (p += parseFloat(this.value))
            }),
            $("#total_discount_ammount").val(p.toFixed(2, 2)),

            $(".total_vatamnt").each(function () {
                isNaN(this.value) || 0 == this.value.length || (v += parseFloat(this.value))
            }),
            $("#total_vat_amnt").val(v.toFixed(2, 2)),

             $(".totalTax").each(function () {
        isNaN(this.value) || 0 == this.value.length || (f += parseFloat(this.value))
    }),
            $("#total_tax_amount").val(f.toFixed(2, 2)),
         
            //Total Price
            $(".total_price").each(function () {
        isNaN(this.value) || 0 == this.value.length || (t += parseFloat(this.value))
    }),

 $(".dppr").each(function () {
        isNaN(this.value) || 0 == this.value.length || (ad += parseFloat(this.value))
    }),
            
            o = a.toFixed(2, 2),
            e = t.toFixed(2, 2),
            tx = f.toFixed(2, 2),
    ds = p.toFixed(2, 2);

    var test = +tx + +s_cost + +e + -ds + + ad;
    $("#grandTotal").val(test.toFixed(2, 2));


    var gt = $("#grandTotal").val();
    var invdis = $("#invoice_discount").val();
    var vatamnt = 0;
    vatamnt = $("#total_vat_amnt").val();
    
    var total_discount_ammount = $("#total_discount_ammount").val();
    var ttl_discount = +total_discount_ammount;
    $("#total_discount_ammount").val(ttl_discount.toFixed(2, 2));
    var grnt_totals = parseFloat(gt) + parseFloat(vatamnt);
   
    $("#grandTotal").val(grnt_totals.toFixed(2, 2));
    $('#paidAmount').val(grnt_totals);
    $("#pamount_by_method").val(grnt_totals);
    // invoice_paidamount();
    var  prb = parseFloat($("#previous").val(), 10);
    var pr = 0;
    var nt = 0;
    if(prb != 0){
        pr =  prb;
    }else{
        pr = 0;
    }
    var t = $("#grandTotal").val(),
    nt = parseFloat(t, 10) + pr; 
    $("#n_total").val(nt.toFixed(2, 2));    
    
}


$(document).on('click','#add_invoice',function(){
    var total = 0;
    $( ".pay" ).each( function(){
      total += parseFloat( $( this ).val() ) || 0;
    });

    var gtotal=$("#paidAmount").val();
    if (total != gtotal) {
      toastr.error('Paid Amount Should Equal To Payment Amount')

      return false;
    }
  });

// ******* new payment add start *******
$(document).on('click','#add_new_payment_type',function(){
    var base_url = $('#base_url').val();
    var csrf_test_name = $('[name="csrf_test_name"]').val();
    var gtotal=$("#paidAmount").val();
    
    var total = 0;
    $( ".pay" ).each( function(){
      total += parseFloat( $( this ).val() ) || 0;
    });
    
   
    var is_credit_edit = $('#is_credit_edit').val();
    if(total>=gtotal){
      alert("Paid amount is exceed to Total amount.");
      
      return false;
    }
      
    var url= base_url + "invoice/invoice/bdtask_showpaymentmodal";
    $.ajax({
      type: "post",
      url: url,
      data:{is_credit_edit:is_credit_edit, csrf_test_name:csrf_test_name},
      success: function(data) {
        $($('#add_new_payment').append(data)).show("slow", function(){
          });
        var length = $(".number").length;

        var total3 = 0;
        $( ".pay" ).each( function(){
          total3 += parseFloat( $( this ).val() ) || 0;
        });

        var nextamnt = gtotal -total3;


        $(".number:eq("+(length-1)+")").val(nextamnt.toFixed(2,2));
        var total2 = 0;
        $( ".number" ).each( function(){
          total2 += parseFloat( $( this ).val() ) || 0;
        });
        var dueamnt = parseFloat(gtotal) - total2
        
        
      }
    }); 
  });

  
  function changedueamount(){
    var inputval = parseFloat(0);
    var maintotalamount = $('.grandTotalamnt').val();
    
    $(".number").each(function(){
      var inputdata= parseFloat($(this).val());
      inputval = inputval+inputdata;

    });

    var restamount=(parseFloat(maintotalamount))-(parseFloat(inputval));
    var changes=restamount.toFixed(3);
    if(changes <=0){
      $("#change-amount").text(Math.abs(changes));
      $("#pay-amount").text(0);
    }
    else{
      $("#change-amount").text(0);
      $("#pay-amount").text(changes);
    }  
  }

  // ******* new payment add end *******

//Invoice Paid Amount
    "use strict";
function invoice_paidamount() {
    var  prb = parseFloat($("#previous").val(), 10);
    var pr = 0;
    var d = 0;
    var nt = 0;
    if(prb != 0){
        pr =  prb;
    }else{
        pr = 0;
    }
    var t = $("#grandTotal").val(),
    a = $("#paidAmount").val(),
    e = t - a,
    f = e + pr,
    nt = parseFloat(t, 10) + pr;
    d = a - nt;

    $("#pamount_by_method").val(a);
    $("#add_new_payment").empty();
    $("#pay-amount").text('0');
    
    $("#n_total").val(nt.toFixed(2, 2));      
    if(e > 0){
        $("#dueAmmount").val(e.toFixed(2,2));
        if(a <= f){
            $("#change").val(0);   
        }
    }else{
        if(a < f){
            $("#change").val(0);   
        }
        if(a > f){
            $("#change").val(d.toFixed(2,2))
        }
        $("#dueAmmount").val(0)   
    }

    var invoice_edit_page = $("#invoice_edit_page").val();
    var is_credit_edit = $('#is_credit_edit').val();
    if (invoice_edit_page == 1 ) {
        var base_url = $('#base_url').val();
        var csrf_test_name = $('[name="csrf_test_name"]').val();
        var gtotal=$(".grandTotalamnt").val();
        var url= base_url + "invoice/invoice/bdtask_showpaymentmodal";
        $.ajax({
            type: "post",
            url: url,
            data:{csrf_test_name:csrf_test_name,is_credit_edit:is_credit_edit},
            success: function(data) {
                $('#add_new_payment').append(data);
                $("#pamount_by_method").val(a);
                $("#add_new_payment_type").prop('disabled',false);
            }
        });
    }
}

//Stock Limit
    "use strict";
function stockLimit(t) {
    var a = $("#total_qntt_" + t).val(),
            e = $(".product_id_" + t).val(),
            o = $(".baseUrl").val();

    $.ajax({
        type: "POST",
        url: o + "Cinvoice/product_stock_check",
        data: {
            product_id: e
        },
        cache: !1,
        success: function (e) {
            alert(e);
            if (a > Number(e)) {
                var o = "You can Sale maximum " + e + " Items";
                alert(o), $("#qty_item_" + t).val("0"), $("#total_qntt_" + t).val("0"), $("#total_price_" + t).val("0")
            }
        }
    })
}

  
//Invoice full paid
    "use strict";
function invoicee_full_paid() {
    var grandTotal = $("#n_total").val();
    $("#paidAmount").val(grandTotal);
    // invoice_paidamount();
    invoice_calculateSum();
}

//Delete a row of table
    "use strict";
function deleteRow_invoice(t) {
    var a = $("#normalinvoice > tbody > tr").length;
    if (1 == a)
        alert("There only one row you can't delete.");
    else {
        var e = t.parentNode.parentNode;
        e.parentNode.removeChild(e),
                invoice_calculateSum();
        invoice_paidamount();
        var current = 1;
        $("#normalinvoice > tbody > tr td input.productSelection").each(function () {
            current++;
            $(this).attr('id', 'product_name' + current);
        });
        var common_qnt = 1;
        $("#normalinvoice > tbody > tr td input.common_qnt").each(function () {
            common_qnt++;
            $(this).attr('id', 'total_qntt_' + common_qnt);
            $(this).attr('onkeyup', 'bdtask_invoice_quantity_calculate('+common_qnt+');');
            $(this).attr('onchange', 'bdtask_invoice_quantity_calculate('+common_qnt+');');
        });
        var common_rate = 1;
        $("#normalinvoice > tbody > tr td input.common_rate").each(function () {
            common_rate++;
            $(this).attr('id', 'price_item_' + common_rate);
            $(this).attr('onkeyup', 'bdtask_invoice_quantity_calculate('+common_qnt+');');
            $(this).attr('onchange', 'bdtask_invoice_quantity_calculate('+common_qnt+');');
        });
        var common_discount = 1;
        $("#normalinvoice > tbody > tr td input.common_discount").each(function () {
            common_discount++;
            $(this).attr('id', 'discount_' + common_discount);
            $(this).attr('onkeyup', 'bdtask_invoice_quantity_calculate('+common_qnt+');');
            $(this).attr('onchange', 'bdtask_invoice_quantity_calculate('+common_qnt+');');
        });
        var common_total_price = 1;
        $("#normalinvoice > tbody > tr td input.common_total_price").each(function () {
            common_total_price++;
            $(this).attr('id', 'total_price_' + common_total_price);
        });

        var invoice_edit_page = $("#invoice_edit_page").val();
        
        $("#add_new_payment").empty();
        
        $("#pay-amount").text('0');
        var is_credit_edit = $('#is_credit_edit').val();
        if (invoice_edit_page == 1 ) {
           
            var base_url = $('#base_url').val();
            var csrf_test_name = $('[name="csrf_test_name"]').val();
            var gtotal=$(".grandTotalamnt").val();
            var url= base_url + "invoice/invoice/bdtask_showpaymentmodal";
            $.ajax({
                type: "post",
                url: url,
                data:{csrf_test_name:csrf_test_name,is_credit_edit:is_credit_edit},
                success: function(data) {
                  $('#add_new_payment').append(data);
                  $("#pamount_by_method").val(gtotal);
                  $("#add_new_payment_type").prop('disabled',false);
                }
              }); 
            
        }


    }
}
var count = 2,
        limits = 500;



    "use strict";
    function bank_info_show(payment_type)
    {
        if (payment_type.value == "1") {
            document.getElementById("bank_info_hide").style.display = "none";
        } else {
            document.getElementById("bank_info_hide").style.display = "block";
        }
    }




        window.onload = function () {
        $('body').addClass("sidebar-mini sidebar-collapse");
    }

        "use strict";
      function bank_paymet(val){
        if(val==2){
           var style = 'block'; 
           document.getElementById('bank_id').setAttribute("required", true);
        }else{
   var style ='none';
    document.getElementById('bank_id').removeAttribute("required");
        }
           
    document.getElementById('bank_div').style.display = style;
    }

    $(document ).ready(function() {
    $('#normalinvoice .toggle').on('click', function() {
    $('#normalinvoice .hideableRow').toggleClass('hiddenRow');
  })
});

     "use strict";
    function customer_due(id){
   var csrf_test_name = $('[name="csrf_test_name"]').val();
   var base_url = $("#base_url").val();
        $.ajax({
            url: base_url + 'invoice/invoice/previous',
            type: 'post',
            data: {customer_id:id,csrf_test_name:csrf_test_name}, 
            success: function (msg){
               
                $("#previous").val(msg);
            },
            error: function (xhr, desc, err){
                 alert('failed');
            }
        });        
    }



      "use strict";
    function customer_autocomplete(sl) {

    var customer_id = $('#customer_id').val();
    // Auto complete
    var options = {
        minLength: 0,
        source: function( request, response ) {
            var customer_name = $('#customer_name').val();
            var csrf_test_name = $('[name="csrf_test_name"]').val();
            var base_url = $("#base_url").val();
         
        $.ajax( {
          url: base_url + "invoice/invoice/bdtask_customer_autocomplete",
          method: 'post',
          dataType: "json",
          data: {
            term: request.term,
            customer_id:customer_name,
            csrf_test_name:csrf_test_name,
          },
          success: function( data ) {
            response( data );

          }
        });
      },
       focus: function( event, ui ) {
           $(this).val(ui.item.label);
           return false;
       },
       select: function( event, ui ) {
            $(this).parent().parent().find("#autocomplete_customer_id").val(ui.item.value); 
            var customer_id          = ui.item.value;
            customer_due(customer_id);

            $(this).unbind("change");
            return false;
       }
   }

   $('body').on('keypress.autocomplete', '#customer_name', function() {
       $(this).autocomplete(options);
   });

}

    "use strict";
function cancelprint(){
   location.reload();
}

$(document).ready(function(){

    $('#full_paid_tab').keydown(function(event) {
        if(event.keyCode == 13) {
 $('#add_invoice').trigger('click');
        }
    });
});



     $(document).ready(function() {
    "use strict";
    var frm = $("#insert_sale");
    var output = $("#output");
    frm.on('submit', function(e) {
         e.preventDefault(); 
               $.ajax({
            url : $(this).attr('action'),
            method : $(this).attr('method'),
            dataType : 'json',
            data : frm.serialize(),
            success: function(data) 
            {
                
                if (data.status == true) {
                   toastr["success"](data.message);
                               swal({
        title: "Success!",
        showCancelButton: true,
        cancelButtonText: "NO",
        confirmButtonText: "Yes",
        text: "Do You Want To Print ?",
        type: "success",
        
       
      }, function(inputValue) {
          if (inputValue===true) {
      $("#normalinvoice tbody tr").remove();
                $('#insert_sale').trigger("reset");

       printRawHtml(data.details);
  } else {
    location.reload();
  }
    
      });
                   if(data.status == true && event.keyCode == 13) {
        }
                } else {
                    toastr["error"](data.exception);
                }
            },
            error: function(xhr)
            {
                alert('failed!');
            }
        });
    });
     });

    $(document).ready(function() {
        $("#default_payment_id").empty();
    "use strict";
   var frm = $("#update_invoice");
    var output = $("#output");
    frm.on('submit', function(e) {
         e.preventDefault(); 
               $.ajax({
            url : $(this).attr('action'),
            method : $(this).attr('method'),
            dataType : 'json',
            data : frm.serialize(),
            success: function(data) 
            {
                 
                if (data.status == true) {
                   toastr["success"](data.message);
                    $("#inv_id").val(data.invoice_id);
                  $('#printconfirmodal').modal('show');
                   if(data.status == true && event.keyCode == 13) {
        }
                } else {
                    toastr["error"](data.exception);
                }
            },
            error: function(xhr)
            {
                alert('failed!');
            }
        });
    });
     });

     $("#printconfirmodal").on('keydown', function ( e ) {
    var key = e.which || e.keyCode;
    if (key == 13) {
       $('#yes').trigger('click');
    }
});


    "use strict";
     function invoice_productList(sl) {
        var priceClass = 'price_item'+sl;
        var available_quantity = 'available_quantity_'+sl;
        var unit = 'unit_'+sl;
        var tax = 'total_tax_'+sl;
        var serial_no = 'serial_no_'+sl;
        var vat_percent = 'vat_percent_'+sl;
        var discount_type = 'discount_type_'+sl;
        var csrf_test_name = $('[name="csrf_test_name"]').val();
        var base_url = $("#base_url").val();

    // Auto complete
    var options = {
        minLength: 0,
        source: function( request, response ) {
            var product_name = $('#product_name_'+sl).val();
        $.ajax( {
          url: base_url + "invoice/invoice/bdtask_autocomplete_product",
          method: 'post',
          dataType: "json",
          data: {
            term: request.term,
            product_name:product_name,
            csrf_test_name:csrf_test_name,
          },
          success: function( data ) {
            response( data );

          }
        });
      },
       focus: function( event, ui ) {
           $(this).val(ui.item.label);
           return false;
       },
       select: function( event, ui ) {
            $(this).parent().parent().find(".autocomplete_hidden_value").val(ui.item.value); 
                $(this).val(ui.item.label);
                var id=ui.item.value;
                var dataString = 'product_id='+ id;
                var base_url = $('.baseUrl').val();

                $.ajax
                   ({
                        type: "POST",
                        url: base_url+"invoice/invoice/retrieve_product_data_inv",
                        data: {product_id:id,csrf_test_name:csrf_test_name},
                        cache: false,
                        success: function(data)
                        {
                            var obj = jQuery.parseJSON(data);
                            for (var i = 0; i < (obj.txnmber); i++) {
                            var txam = obj.taxdta[i];
                            var txclass = 'total_tax'+i+'_'+sl;
                           $('.'+txclass).val(obj.taxdta[i]);
                            }
                            $('.'+priceClass).val(obj.price);
                            $('.'+unit).val(obj.unit);
                            $('.'+tax).val(obj.tax);
                            $('#txfieldnum').val(obj.txnmber);
                            $('#'+serial_no).html(obj.serial);
                            $('#'+vat_percent).val(obj.product_vat);
                           
                                   bdtask_invoice_quantity_calculate(sl);
                            
                        }
                    });

            $(this).unbind("change");
            return false;
       }
   }

   $('body').on('keypress.autocomplete', '.productSelection', function() {
       $(this).autocomplete(options);
   });

}

 $( document ).ready(function() {
        "use strict";
        var paytype = $("#editpayment_type").val();
        if(paytype == 2){
          $("#bank_div").css("display", "block");        
      }else{
       $("#bank_div").css("display", "none"); 
      }

      $(".bankpayment").css("width", "100%");
    });

    function invoice_product_batch(sl){
        var base_url = $('.baseUrl').val();
        var csrf_test_name = $('[name="csrf_test_name"]').val();
        var prod_id = $(".product_id_" + sl).val();
        var batch_no = $("#serial_no_" + sl).val();
        var taxnumber = $("#txfieldnum").val();
        var available_quantity = $(".available_quantity_" + sl).val();

        $.ajax( {
            url: base_url + "invoice/invoice/bdtask_batchwise_productprice",
            method: 'post',
            dataType: "json",
            data: {
            prod_id: prod_id,
            batch_no:batch_no,
            csrf_test_name:csrf_test_name,
            },
            success: function( data ) {
                if (parseInt(data) >= 0) {
                    $(".available_quantity_" + sl).val(data.toFixed(2,2));
                }else{
                    var message = "You can Sale maximum " + available_quantity + " Items";
                    toastr["error"](message);
                    $("#total_qntt_" + sl).val('');
                    var quantity = 0;
                    $("#total_price_" + sl).val(0);
                    for(var i=0;i<taxnumber;i++){
                        $("#all_tax"+i+"_" + sl).val(0);
                        bdtask_invoice_quantity_calculate(sl);
                    }
                }
               
            }
          });




    }

    function check_creditsale(){
        var card_typesl = $('.card_typesl').val();
        if(card_typesl == 0){
            $("#add_new_payment").empty();
            var gtotal=$(".grandTotalamnt").val();
            $("#pamount_by_method").val(gtotal);
            $("#paidAmount").val(0);
            $("#dueAmmount").val(gtotal);
            $(".number:eq(0)").val(0);
            $("#add_new_payment_type").prop('disabled',true);
            
        }else{
            $("#add_new_payment_type").prop('disabled',false);
        }
        $("#pay-amount").text('0');
        
        var invoice_edit_page = $("#invoice_edit_page").val();
        var is_credit_edit = $('#is_credit_edit').val();
        if (invoice_edit_page == 1 && card_typesl == 0) {
            $("#add_new_payment").empty();
           
            var base_url = $('#base_url').val();
            var csrf_test_name = $('[name="csrf_test_name"]').val();
            var gtotal=$(".grandTotalamnt").val
            var url= base_url + "invoice/invoice/bdtask_showpaymentmodal";
            $.ajax({
                type: "post",
                url: url,
                data:{csrf_test_name:csrf_test_name,is_credit_edit:is_credit_edit},
                success: function(data) {
                 $('#add_new_payment').append(data);
                  $("#pamount_by_method").val(gtotal);
                  $("#add_new_payment_type").prop('disabled',true);
                }
              }); 
            
        }
    }


</script>
<!-- IE Support -->
<script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="{{asset('public/assets/admin')}}/vendor/babel-polyfill/polyfill.min.js"><\/script>');
</script>



@endpush
