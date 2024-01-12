<div class="modal fade" id="add-customer" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{\App\CPU\translate('add_new_customer')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.pos.customer-store')}}" method="post" id="product_form"
                >
                    @csrf
                    <div class="row pl-2" >
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="input-label" >{{\App\CPU\translate('first_name')}} <span
                                        class="input-label-secondary text-danger">*</span></label>
                                <input type="text" name="f_name" class="form-control" value="{{ old('f_name') }}"  placeholder="{{\App\CPU\translate('first_name')}}" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="input-label" >{{\App\CPU\translate('last_name')}} <span
                                        class="input-label-secondary text-danger">*</span></label>
                                <input type="text" name="l_name" class="form-control" value="{{ old('l_name') }}"  placeholder="{{\App\CPU\translate('last_name')}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row pl-2" >
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="input-label" >{{\App\CPU\translate('email')}}<span
                                        class="input-label-secondary text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}"  placeholder="{{\App\CPU\translate('Ex_:_ex@example.com')}}" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="input-label" >{{\App\CPU\translate('phone')}}<span
                                        class="input-label-secondary text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"  placeholder="{{\App\CPU\translate('phone')}}" required>
                            </div>
                        </div>
                    </div>
                    <!--<div class="row pl-2" >-->
                    <!--    <div class="col-12 col-lg-6">-->
                    <!--        <div class="form-group">-->
                    <!--            <label class="input-label">{{\App\CPU\translate('country')}} <span-->
                    <!--                    class="input-label-secondary text-danger">*</span></label>-->
                    <!--            <input type="text"  name="country" class="form-control" value="{{ old('country') }}"  placeholder="{{\App\CPU\translate('country')}}" required>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--    <div class="col-12 col-lg-6">-->
                    <!--        <div class="form-group">-->
                    <!--            <label class="input-label">{{\App\CPU\translate('city')}} <span-->
                    <!--                    class="input-label-secondary text-danger">*</span></label>-->
                    <!--            <input type="text"  name="city" class="form-control" value="{{ old('city') }}"  placeholder="{{\App\CPU\translate('city')}}" required>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--    <div class="col-12 col-lg-6">-->
                    <!--        <div class="form-group">-->
                    <!--            <label class="input-label">{{\App\CPU\translate('zip_code')}} <span-->
                    <!--                    class="input-label-secondary text-danger">*</span></label>-->
                    <!--            <input type="text"  name="zip_code" class="form-control" value="{{ old('zip_code') }}"  placeholder="{{\App\CPU\translate('zip_code')}}" required>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--    <div class="col-12 col-lg-6">-->
                    <!--        <div class="form-group">-->
                    <!--            <label class="input-label">{{\App\CPU\translate('address')}} <span-->
                    <!--                    class="input-label-secondary text-danger">*</span></label>-->
                    <!--            <input type="text"  name="address" class="form-control" value="{{ old('address') }}"  placeholder="{{\App\CPU\translate('address')}}" required>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->

                    <hr>
                    <button type="submit" id="submit_new_customer" class="btn btn--primary">{{\App\CPU\translate('submit')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="add-product" tabindex="-1" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <form action="{!! route('admin.product.pos_quick_store') !!}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{\App\CPU\translate('Product Add')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic"><small>The field labels marked with * are required input fields</small></p>

                    <div class="form-group">
                        <label>Name</label>
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
                            @foreach($categories as $c)
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