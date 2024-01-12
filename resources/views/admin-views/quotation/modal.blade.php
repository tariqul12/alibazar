<div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modal_header" class="modal-title"></h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="tio-delete"></i></span></button>
            </div>
            <div class="modal-body">
                <form id="cartForm"  >
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="edit_description" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label>{{\App\CPU\translate('file.Quantity')}}</label>
                        <input type="number" name="edit_qty" class="form-control" step="any">
                    </div>
                    <!--<div class="form-group">-->
                    <!--    <label>{{\App\CPU\translate('file.Unit Discount')}}</label>-->
                    <!--    <input type="number" name="edit_discount" class="form-control" step="any">-->
                    <!--</div>-->
                    <div class="form-group">
                        <label>{{\App\CPU\translate('file.Unit Price')}}</label>
                        <input type="number" name="edit_unit_price" class="form-control" step="any">
                    </div>
                    <!--<div class="form-group">-->
                    <!--    <label>Vat Rate ( in percentage)</label>-->
                    <!--    <input type="number" name="vat_rate" class="form-control">-->
                    <!--</div>-->
                    <input type="hidden" name="product_id" >
<!--                    <div class="form-group">
                        <label>Vat Amount</label>
                        <input type="number" name="vat_amount" class="form-control" readonly>
                    </div>-->
<!--                    <input class="btn btn-primary" type="submit" value="Submit">-->
<!--                    <button type="submit" class="btn btn-primary cart-form-submission">Submit</button>-->
                    <a href="javascript:singleSubmit()" class="btn btn-primary"> Submit</a>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <form action="{!! route('admin.customer.store') !!}" method="post">
                @csrf
                @if(isset($edit_mode) && $edit_mode == true)
                    <input type="hidden" name="edit_mode" value="1">
                    <input type="hidden" name="quotation_no" value="{!! $quotation->id !!}">
                @endif
                <input class="quotation_subject" type="hidden" name="subject_name" value="{!!   request()->get('subject_line') !!}">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{\App\CPU\translate('file.Add Customer')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="tio-delete"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic"><small>{{\App\CPU\translate('file.The field labels marked with * are required input fields')}}.</small></p>

                    <div class="form-group">
                        <label>{{\App\CPU\translate('file.name')}}*</label>
                        <input type="text" name="name" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{\App\CPU\translate('file.Email')}}</label>
                        <input type="email" name="email" placeholder="example@example.com" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{\App\CPU\translate('file.Phone Number')}} *</label>
                        <input type="text" name="phone_number" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{\App\CPU\translate('file.Designation')}} </label>
                        <input type="text" name="designation"  class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{\App\CPU\translate('file.Address')}} *</label>
                        <input type="text" name="address" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" name="company_name"  class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="quotation" value="1">
                        <input type="submit" value="{{\App\CPU\translate('file.submit')}}" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="addProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <form action="{!! route('admin.product.quick_store') !!}" method="post">
                @csrf
                @if(isset($edit_mode) && $edit_mode == true)
                    <input type="hidden" name="edit_mode" value="1">
                    <input type="hidden" name="quotation_no" value="{!! $quotation->id !!}">
                @endif
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{\App\CPU\translate('Product Add')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="tio-delete"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic"><small>{{\App\CPU\translate('file.The field labels marked with * are required input fields')}}.</small></p>
                    <input class="quotation_subject" type="hidden" name="subject_name" value="{!!   request()->get('subject_line') !!}">
                    <input class="quotation_customer" type="hidden" name="customer_name" value="{!!   request()->get('customer_id') !!}">
                    <div class="form-group">
                        <label>{{\App\CPU\translate('file.name')}}</label>
                        <input type="text" name="name" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="input-label"
                               for="description">{{\App\CPU\translate('description')}}
                            </label>
                        <textarea name="description" class=" form-control"  required>{{old('details')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label
                            class="control-label">{{\App\CPU\translate('Unit price')}}</label>
                        <input type="number" min="0" step="0.01"
                               placeholder="{{\App\CPU\translate('Unit price')}}"
                               value="{{old('unit_price')}}"
                               name="unit_price" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="name">{{\App\CPU\translate('Category')}}</label>
                        <select
                            class="js-example-basic-multiple form-control"
                            name="category_id"
                            required>
                            <option value="{{old('category_id')}}" selected disabled>---Select---</option>
                            @foreach($cat as $c)
                                <option value="{{$c['id']}}" {{old('name')==$c['id']? 'selected': ''}}>
                                    {{$c['name']}}
                                </option>
                            @endforeach
                        </select>
                    </div>



                    <div class="form-group">
                        <input type="hidden" name="quotation" value="1">
                        <input type="submit" value="{{\App\CPU\translate('file.submit')}}" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- quote address --}}
<div id="qoute_address" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <form action="{!! route('admin.customer.quotation_customer_contact') !!}" method="post">
                @csrf
                <input type="hidden" name="quotation_edit_id" id="quotation_edit_id" value="">
                <input type="hidden" name="quotation_cust_id" id="quotation_cust_id" value="">
                <input type="hidden" name="quotation_no" value="{!! isset($quotation->id)?$quotation->id:'' !!}">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{\App\CPU\translate('Address_update')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="tio-delete"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic"><small>{{\App\CPU\translate('file.The field labels marked with * are required input fields')}}.</small></p>
                    <div class="form-group">
                        <label>{{\App\CPU\translate('file.Email')}} *</label>
                        <input type="email" name="quote_email" id="quote_email" placeholder="example@example.com" required value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{\App\CPU\translate('file.Phone Number')}} *</label>
                        <input type="text" name="quote_phone" id="quote_phone" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{\App\CPU\translate('file.Address')}} *</label>
                        <input type="text" name="quote_company_address" id="quote_company_address" required value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Company Name *</label>
                        <input type="text" name="quote_company" id="quote_company" required value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="{{\App\CPU\translate('file.submit')}}" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="edit_qoute_address" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <form action="{!! route('admin.customer.quotation_customer_contact_update') !!}" method="post">
                @csrf
                <input type="hidden" name="edit_quotation_id" id="edit_quotation_id" value="{{isset($quotation->id)?$quotation->id:''}}">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{\App\CPU\translate('Address_update')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="tio-delete"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic"><small>{{\App\CPU\translate('file.The field labels marked with * are required input fields')}}.</small></p>
                    <div class="form-group">
                        <label>{{\App\CPU\translate('file.Email')}} *</label>
                        <input type="email" name="edit_quote_email" id="edit_quote_email" placeholder="example@example.com" required value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{\App\CPU\translate('file.Phone Number')}} *</label>
                        <input type="text" name="edit_quote_phone" id="edit_quote_phone" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{\App\CPU\translate('file.Address')}} *</label>
                        <input type="text" name="edit_quote_company_address" id="edit_quote_company_address" required value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Company Name *</label>
                        <input type="text" name="edit_quote_company" id="edit_quote_company" required value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="{{\App\CPU\translate('file.submit')}}" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>