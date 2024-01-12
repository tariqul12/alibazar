@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Order Edit'))
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<style>
    .form-control {
        border-radius: 0;
        box-shadow: none;
        border-color: #d2d6de
    }

    .select2-hidden-accessible {
        border: 0 !important;
        clip: rect(0 0 0 0) !important;
        height: 1px !important;
        margin: -1px !important;
        overflow: hidden !important;
        padding: 0 !important;
        position: absolute !important;
        width: 1px !important
    }

    .form-control {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s
    }

    .select2-container--default .select2-selection--single,
    .select2-selection .select2-selection--single {
        border: 1px solid #d2d6de;
        border-radius: 0;
        padding: 6px 12px;
        height: 34px
    }

    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 1px solid #aaa;
        border-radius: 4px
    }

    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 28px;
        user-select: none;
        -webkit-user-select: none
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-right: 10px
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 0;
        padding-right: 0;
        height: auto;
        margin-top: -3px
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 28px
    }

    .select2-container--default .select2-selection--single,
    .select2-selection .select2-selection--single {
        border: 1px solid #d2d6de;
        border-radius: 0 !important;
        padding: 6px 12px;
        height: 40px !important
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 26px;
        position: absolute;
        top: 6px !important;
        right: 1px;
        width: 20px
    }
</style>
@section('content')
    <!-- Content -->
    <!--Add Invoice -->
    <section class="section-content pt-5">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <h5 class="p-3 m-0 bg-light">{{ \App\CPU\translate('Order Edit') }}</h5>
                        <div class="panel-body">
                            {{-- add product --}}
                            <button  class="btn btn-primary" data-toggle="modal" data-target="#addNewOrder" style="margin-left: 10px;margin-top: 10px;">
                                <b><i class="tio-add"></i> Add New Product</b> </button> <br> <br>
                            {{-- end --}}
                            <form action="{{ route('admin.orders.order_update') }}" class="form-vertical" id="insert_sale"
                                name="insert_sale" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="normalinvoice">
                                        <thead>
                                            <tr>
                                                <th class="text-center product_field">Item Information <i
                                                        class="text-danger">*</i></th>
                                                <th class="text-center">Veriation</th>
                                                <th class="text-center">Qnty</th>
                                                <th class="text-center">Tax</th>
                                                <th class="text-center invoice_fields">Price</th>
                                                <th class="text-center invoice_fields">Total </th>
						<th class="text-center invoice_fields">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="addinvoiceItem">
                                            @php($subtotal = 0)
                                            @php($total = 0)
                                            @php($shipping = 0)
                                            @php($discount = 0)
                                            @php($tax = 0)
                                            @php($row = 0)
                                            @php($u_price=0)
                                            @php($ext_discount = 0)
                                            <?php
                                            $showDiscountStatus = isset($order['discount_status_show']) && $order['discount_status_show'] == 1 ? 1 : 0;
                                            $feeInfo = isset($order['additional_fee']) && $order['additional_fee'] != '' ? json_decode($order['additional_fee'], true) : [];
                                            $vatAmt = isset($order['vat_amount']) ? $order['vat_amount'] : 0;
                                            $feeAmt = isset($feeInfo['fee_amount']) ? $feeInfo['fee_amount'] : 0;
                                            ?>
                                            @foreach ($order->details as $key => $detail)
                                           
                                                @if ($detail->product)
                                                <?php 
                                                $json_attr=$detail->product['choice_options'];
                                                   $choice_data=json_decode($json_attr);
                                                   $model_option=[];
                                                   $size_option=[];
                                                   foreach($choice_data as $row)
                                                   {
                                                       if($row->title=='Model')
                                                       {
                                                           $model_option=$row->options;
                                                       }
                                                   }
                                                   foreach($model_option as $data)
                                                   {
                                                       $model_val[]=$data;
                                                   }
                                               ?>
                                                    <tr>
                                                        <td class="product_field" width="30%">
                                                            {{-- <input type="text" required name="product_name[]"
                                                                id="product_name_1" class="form-control productSelection"
                                                                placeholder="Product Name" tabindex="5" value="{{substr($detail->product['name'],0,30)}}"> --}}
                                                            <div class="form-group">
                                                                <select
                                                                    class="form-control select2 select2-hidden-accessible"
                                                                    style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                                    name="product_id[]">
                                                                    <option>--Select Product--</option>
                                                                    @foreach ($product_list as $row)
                                                                        <option value="{{ $row->id }}"
                                                                            <?php if ($row->id == $detail->product['id']) {
                                                                                echo 'selected';
                                                                            } ?>>
                                                                            {{ $row->name }}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                            <input type="hidden"
                                                                class="autocomplete_hidden_value product_id_1"
                                                                name="order_id" id="SchoolHiddenId"
                                                                value="{{ $order['id'] }}" />
                                                            <input type="hidden" name="discount[]"
                                                                value='{{ $detail['discount'] }}'>
                                                            <input type="hidden" name="details_id[]"
                                                                value='{{ $detail['id'] }}'>
                                                        </td>
                                                        <td>
                                                            @if (!empty($model_val))
                                                            <select
                                                                class="form-control select2 select2-hidden-accessible"
                                                                style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                                name="variant[]">
                                                                <option>--Select Variant--</option>
                                                                @foreach ($model_val as $row)
                                                                    <option value="{{ $row }}"
                                                                        <?php if ($row == $detail['variant']) {
                                                                            echo 'selected';
                                                                        } ?>>
                                                                        {{ $row}}</option>
                                                                @endforeach
                                                            </select>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <input type="text" name="product_quantity[]" required=""
                                                                class="total_qntt_1 form-control text-right"
                                                                id="total_qntt_1" placeholder="0.00" min="0"
                                                                tabindex="8" value="{{ $detail->qty }}" />
                                                        </td>


                                                        <!-- VAT  -->
                                                        <td>
                                                            <input type="text" name="tax[]" id="tax[]"
                                                                class="form-control text-right" min="0"
                                                                tabindex="19" placeholder="0.00"
                                                                value="{{ $detail['tax'] }}" />

                                                        </td>
                                                        <td>
                                                            <input type="text" name="price[]" id="price[]"
                                                                class="form-control text-right total_vatamnt" min="0"
                                                                tabindex="20" placeholder="0.00"
                                                                value="{{ $detail['price'] }}" />
                                                        </td>
                                                        <!-- VAT end -->

                                                        <td class="invoice_fields">
                                                            <input class="total_price form-control text-right"
                                                                type="text" name="total_price[]" id="total_price[]"
                                                                value="{{ ($detail['price'] + $detail['tax']) * $detail->qty }}" />
                                                        </td>
							 <td class="invoice_fields">
                                                            <a class="btn btn-outline-danger square-btn btn-sm mr-1"href="{{route('admin.orders.delete_edit_order',[$detail['id']])}}">
                                                                <i class="tio-delete"></i>
                                                        </td>
                                                    </tr>
                                                    @php($discount += $detail['discount'])
                                                    @php($tax += $detail['tax'])
                                                    @php($shipping = $order['shipping_cost'])
                                                    @php($u_price =($detail['price'] + $detail['tax']) * $detail->qty)
                                                    @php($total += $u_price)
                                                    <!-- End Media -->
                                                @endif
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-right" colspan="5"><b>Total Discount:</b></td>
                                                <td class="text-right">
                                                    <input type="text" id="total_discount_ammount"
                                                        class="form-control text-right" name="total_discount"
                                                        value="{{ $discount }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" colspan="5"><b>Total VAT:</b></td>
                                                <td class="text-right">
                                                    <input type="text" id="total_vat_amnt"
                                                        class="form-control text-right" name="total_vat_amnt"
                                                        value="{{ $tax }}" />
                                                </td>
                                            </tr>

                                            <tr>
                                            <tr>
                                                <td class="text-right" colspan="5"><b>Shipping Cost:</b></td>
                                                <td class="text-right">
                                                    <input type="text" id="shipping_cost"
                                                        class="form-control text-right" name="shipping_cost"
                                                        placeholder="0.00" tabindex="14" value="{{ $shipping }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="text-right"><b>Grand Total:</b></td>
                                                <td class="text-right">
                                                    <input type="text" id="grandTotal"
                                                        class="form-control text-right grandTotalamnt"
                                                        name="grand_total_price" value="{{ $total+$shipping-$discount }}" />
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                {{-- address --}}
                                @if(!empty($order['customer_type']))
                                <div class="row p-3" >
                                    <div class="col-6">
                                        <strong>Shipping Address:</strong>
                                        <?php 
                                            $json_address=json_decode($order['shipping_address_data']);
                                        ?>
                                        <div class="form-group col-12">
                                            <span>Contact Person:</span>
                                            <input type="text" class="form-control contact_info-input" name="shipping_person" id="account-email"
                                                                    placeholder="Contact Person"   value="<?php echo $json_address->contact_person_name;?>">
                                        </div>
                                        <div class="form-group col-12">
                                            <span>Phone:</span>
                                            <input type="text" class="form-control contact_info-input" name="shipping_phone" id="account-email"
                                                                    placeholder="Phone"   value="<?php echo $json_address->phone;?>">
                                        </div>
                                         <div class="form-group col-12">
                                            <span>City:</span>
                                            <input type="text" class="form-control contact_info-input" name="shipping_city" id="account-email"
                                                                    placeholder="City"   value="<?php echo $json_address->city;?>">
                                        </div>
                                        <div class="form-group col-12">
                                            <span>ZIP:</span>
                                            <input type="text" class="form-control contact_info-input" name="shipping_zip" id="account-email"
                                                                    placeholder="ZIP CODE"   value="<?php echo $json_address->zip;?>">
                                        </div>
                                        <div class="form-group col-12">
                                            <input type="hidden" name="shipping_json" value="{{$order['shipping_address_data']}}">
                                            <span>Address:</span>
                                            <textarea name="shipping_address" class="form-control contact_info-input" id=""value="" cols="100" rows="3"  placeholder="Address"><?php echo $json_address->address;?></textarea>
                                        </div>
                                       
                                        {{-- <ul class="list-group">
                                            @php($shipping_addresses=\App\Model\ShippingAddress::where('customer_id',$order['customer_id'])->where('is_billing',0)->get())
                                            @foreach($shipping_addresses as $key=>$address)
                                                <li class="list-group-item mb-2 mt-2"
                                                    style="cursor: pointer;background: rgba(245,245,245,0.51)"
                                                    onclick="$('#sh-{{$address['id']}}').prop( 'checked', true );$('#collapseThree').collapse('hide'); ">
                                                    <input type="radio" name="shipping_method_id"
                                                           id="sh-{{$address['id']}}"
                                                           value="{{$address['id']}}" {{$address['id']==$shipping_address->id?'checked':''}}>
                                                    <span class="checkmark"
                                                          style="margin-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 10px"></span>
                                                    <label class="badge"
                                                           style="background: {{$web_config['primary_color']}}; color:white !important;text-transform: capitalize;">{{$address['address_type']}}</label>
                                                    <small>
                                                        <i class="fa fa-phone"></i> {{$address['phone']}}
                                                    </small>
                                                    <hr>
                                                    <span>{{ \App\CPU\translate('contact_person_name')}}: {{$address['contact_person_name']}}</span><br>
                                                    <span>{{ \App\CPU\translate('address')}} : {{$address['address']}}, {{$address['city']}}, {{$address['zip']}}.</span>
                                                </li>
                                            @endforeach
                                        </ul> --}}
                                    </div>
                                    <div class="col-6">
                                        <strong>Billing Address:</strong>
                                        <?php 
                                            $json_bill_address=json_decode($order['billing_address_data']);
                                        ?>
                                        @if($json_bill_address)
                                        <div class="form-group col-12">
                                            <span>Contact Person:</span>
                                            <input type="text" class="form-control contact_info-input" name="billing_person" id="account-email"
                                                                    placeholder="Contact Person"   value="<?php echo $json_bill_address->contact_person_name;?>">
                                        </div>
 					<div class="form-group col-12">
                                            <span>Company Name:</span>
                                            <input type="text" class="form-control contact_info-input" name="billing_company" id="account-email"
                                                                    placeholder="Company Name"   value="<?php echo $json_bill_address->company_name;?>">
                                        </div>
                                        <div class="form-group col-12">
                                            <span>Company Bin:</span>
                                            <input type="text" class="form-control contact_info-input" name="billing_company_bin" id="account-email"
                                                                    placeholder="Company Bin"   value="<?php echo isset($json_bill_address->company_bin)?$json_bill_address->company_bin:'';?>">
                                        </div>
                                        <div class="form-group col-12">
                                            <span>Phone:</span>
                                            <input type="text" class="form-control contact_info-input" name="billing_phone" id="account-email"
                                                                    placeholder="Phone"   value="<?php echo $json_bill_address->phone;?>">
                                        </div>
                                         <div class="form-group col-12">
                                            <span>City:</span>
                                            <input type="text" class="form-control contact_info-input" name="billing_city" id="account-email"
                                                                    placeholder="City"   value="<?php echo $json_bill_address->city;?>">
                                        </div>
                                        <div class="form-group col-12">
                                            <span>ZIP:</span>
                                            <input type="text" class="form-control contact_info-input" name="billing_zip" id="account-email"
                                                                    placeholder="ZIP CODE"   value="<?php echo $json_bill_address->zip;?>">
                                        </div>
                                        <div class="form-group col-12">
                                            <input type="hidden" name="billing_json" value="{{$order['billing_address_data']}}">
                                            <span>Address:</span>
                                            <textarea name="billing_address" class="form-control contact_info-input" id=""value="" cols="100" rows="3"  placeholder="Address"><?php echo $json_bill_address->address;?></textarea>
                                        </div>
                                        @endif
                                        {{-- <ul class="list-group">
                                            @php($shipping_addresses=\App\Model\ShippingAddress::where('customer_id',$order['customer_id'])->where('is_billing',1)->get())
                                            @foreach($shipping_addresses as $key=>$address)
                                                <li class="list-group-item mb-2 mt-2"
                                                    style="cursor: pointer;background: rgba(245,245,245,0.51)"
                                                    onclick="$('#sh-{{$address['id']}}').prop( 'checked', true );$('#collapseThree').collapse('hide'); ">
                                                    <input type="radio" name="billing_method_id"
                                                           value="{{$address['id']}}" {{$address['id']==$billing_address->id?'checked':''}}>
                                                    <span class="checkmark"
                                                          style="margin-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 10px"></span>
                                                    <label class="badge"
                                                           style="background: {{$web_config['primary_color']}}; color:white !important;text-transform: capitalize;">{{$address['address_type']}}</label>
                                                    <small>
                                                        <i class="fa fa-phone"></i> {{$address['phone']}}
                                                    </small>
                                                    <hr>
                                                    <span>{{ \App\CPU\translate('contact_person_name')}}: {{$address['contact_person_name']}}</span><br>
                                                    <span>{{ \App\CPU\translate('address')}} : {{$address['address']}}, {{$address['city']}}, {{$address['zip']}}.</span>
                                                </li>
                                            @endforeach
                                        </ul> --}}
                                    </div>
                                </div>
                                @endif
                                {{-- address end --}}
                                <div class="form-group row text-right">
                                    <div class="col-sm-12 p-20">
                                        <input type="submit" id="add_invoice" class="btn btn-success"
                                            name="add-invoice" value="Update" tabindex="17" style="margin-right: 13px;" />

                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>


            </div>
        </div>
        {{--add modal --}}
        <div class="modal fade" id="addNewOrder" tabindex="-1" role="dialog" aria-labelledby="addNewOrder" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="position: relative;width: 460px;">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addNewOrder">Add New Product</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body call-back" style=" padding:10px 30px!important;">
                  <form>
                    <div class="form-group">
                    <label for="askQuestion">Product Name:</label>
                        <select
                            class="form-control select2 select2-hidden-accessible"
                            style="width: 100%;" tabindex="-1" aria-hidden="true"
                            name="new_product_id" id="new_product_id" required>
                            <option>--Select Product--</option>
                            @foreach ($product_list as $row)
                                <option value="{{ $row->id }}">
                                    {{ $row->name }} -<span>TK.{{$row->unit_price}}</span></option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="askQuestion">Qty:</label>
                        <div class="">
                            <input type="number" min="0"class="form-control"  value="1" name="quantity" style="border-radius: 0px;" required>
                        </div>
                       
                    </div>
                    
                    <div class="form-group">
                      <button class="btn btn-info"  type="button"  onclick="add_new_order()" style="padding: 8px 40px!important;float:right"><i class="tio-save"></i> Add</button>
                  </div>
                  </form>
                </div>
                
              </div>
            </div>
          </div>
        {{-- end modal --}}
    </section>

    <!-- ========================= SECTION CONTENT ========================= -->
    <!-- End Content -->

@endsection

@push('script_2')
<script type="text/javascript">
    //send otp
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
    function add_new_order() {
        var order_id = $("input[name=order_id]").val();
        var new_product_id = $("#new_product_id").val();
        var quantity = $("input[name=quantity]").val();
        var _token = "{{ csrf_token() }}";   
        $.ajax({
            type: 'POST',
            url: "{{ route('admin.orders.new_order_store') }}",
            data: {
                order_id: order_id,
                new_product_id:new_product_id,
                quantity:quantity,
                _token: _token
            },
            success: function(data) {
                console.log(data.response);
                if (data.response == "success") {
                   
                    $('#addNewOrder').modal('toggle');
                    location.reload();
                }

            }
        });
    }
</script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                closeOnSelect: false
            });
        });
        // INITIALIZATION OF SELECT2
        // =======================================================
        // $('.js-select2-custom').each(function () {
        //     var select2 = $.HSCore.components.HSSelect2.init($(this));
        // });

        $('.js-data-example-ajax').select2({
            ajax: {
                url: '{{ route('admin.pos.customers') }}',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });
    </script>
    <!-- IE Support -->
    <script>
        if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write(
            '<script src="{{ asset('public/assets/admin') }}/vendor/babel-polyfill/polyfill.min.js"><\/script>');
    </script>
@endpush