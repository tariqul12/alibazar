
    <div class="row mt-5">
        <div class="col-md-12">
            <h5>{{\App\CPU\translate('file.Order Table')}} *</h5>
            <div class="table-responsive mt-3">
                <table id="myTable" class="table table-hover order-list">
                    <thead>
                    <tr>
                        <th>{{\App\CPU\translate('file.name')}}</th>
                        <th>{{\App\CPU\translate('file.Code')}}</th>
                        <th>{{\App\CPU\translate('file.Quantity')}}</th>
                        <th>{{\App\CPU\translate('file.Net Unit Price')}}</th>
                        <th>{{\App\CPU\translate('file.Discount')}}</th>
                        <th>{{\App\CPU\translate('file.Vat')}}</th>
                        <th>{{\App\CPU\translate('file.Subtotal')}}</th>
                        <th><i class="dripicons-trash"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $totalQty = 0;
                    $totalDiscount = 0;
                    $totalVat = 0;
                    $totalSubtotal = 0;
                    $totalItem = 0;
                    ?>
                    @if(isset($items) && ($items != null) && count($items))
                        @foreach($items as $key=>$item)
                            <?php
                                $totalQty = $totalQty+$item['qty'];
                                $totalDiscount = $totalDiscount+$item['discount'];
                                $totalVat = $totalVat+$item['vat'];
                                $totalSubtotal = $totalSubtotal+$item['subtotal'];
                                $totalItem +=1;
                                ?>
                    <tr class="quotation-tr">
                        <td>{!! $item['name'] !!}
                            <a class="btn btn-link edit_cart_product" href="javascript:editinput({!! $key !!})" data-cart-item='{!! json_encode($item) !!}'><i class="tio-edit"></i>EDIT</a>
                        </td>
                        <td>{!! $item['code'] !!}</td>
<!--                        <td><input type="number" class="form-control qty" name="qty[]" value="1" step="any" required=""></td>-->
                        <td class="qty">{!! $item['qty'] !!}</td>
                        <td class="net_unit_price">{!! $item['price'] !!}</td>
                        <td class="discount">{!! $item['discount'] !!}</td>
                        <td class="vat">{!! $item['vat'] !!}</td>
                        <td class="sub-total">{!! $item['subtotal'] ?? '' !!}</td>
<!--                        <td><button type="button" class="ibtnDel btn btn-md btn-danger" data-cart-item='{!! json_encode($item) !!}'>Delete</button></td>-->
                        <td><a  href="javascript:removeProduct({!! $key !!})" class=" btn btn-md btn-danger">DELETE</a></td>
<!--                        <input type="hidden" class="product-code" name="product_code[]" value="1">
                        <input type="hidden" name="product_id[]" value="1">
                        <input type="hidden" class="sale-unit" name="sale_unit[]" value="Piece">
                        <input type="hidden" class="net_unit_price" name="net_unit_price[]" value="2400.00">
                        <input type="hidden" class="discount-value" name="discount[]" value="0.00">
                        <input type="hidden" class="tax-rate" name="tax_rate[]" value="0.00">
                        <input type="hidden" class="tax-value" name="tax[]" value="0.00">
                        <input type="hidden" class="subtotal-value" name="subtotal[]" value="2400.00">-->
                    </tr>
                        @endforeach
                        @endif
                    </tbody>
                    <tfoot class="tfoot active">
                    <th colspan="2">{{\App\CPU\translate('file.Total')}}</th>
                    <th id="total-qty">{!! $totalQty !!}</th>
                    <th></th>
                    <th id="total-discount">{!! $totalDiscount !!}</th>
                    <th id="total-tax">{!! $totalVat !!}</th>
                    <th id="total">{!! $totalSubtotal !!}</th>
                    <th><i class="dripicons-trash"></i></th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <input type="hidden" name="total_qty" value="{!! $totalQty !!}"/>
                <input type="hidden" name="total_item" value="{!! $totalItem !!}"/>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <input type="hidden" name="total_discount" value="{!! $totalDiscount !!}"/>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <input type="hidden" name="total_vat" value="{!! $totalVat !!}"/>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <input type="hidden" name="total_price" value="{!! $totalSubtotal !!}"/>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <input type="hidden" name="item" />
                <input type="hidden" name="order_tax" />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <input type="hidden" name="grand_total" />
            </div>
        </div>
    </div>




