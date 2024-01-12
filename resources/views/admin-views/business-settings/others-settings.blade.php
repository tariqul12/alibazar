@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Web Config'))

@push('css_or_js')
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/back-end/css/custom.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/business-setup.png')}}" alt="">
                {{\App\CPU\translate('Business_Setup')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Inlile Menu -->
        @include('admin-views.business-settings.business-setup-inline-menu')
        <!-- End Inlile Menu -->
        <div class="row mt-5">
            <div class="col-md-6 mt-2 mt-md-0">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.others-settings.update-default-seo') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    @php
                                    $meta_title='';
                                    $meta_description='';
                                    $meta_image='';
                                    $seo_info=\App\Model\BusinessSetting::where('type','meta_title')->first();
                                    if($seo_info != null ) $meta_title=$seo_info->value;

                                    $seo_info=\App\Model\BusinessSetting::where('type','meta_description')->first();
                                    if($seo_info != null ) $meta_description=$seo_info->value;

                                    $seo_info=\App\Model\BusinessSetting::where('type','meta_image')->first();
                                    if($seo_info != null ) $meta_image=$seo_info->value;

                                    @endphp

                                    <div class="col-md-12 form-group">
                                        <label class="title-color">{{ \App\CPU\translate('Meta Title') }}</label>
                                        <input type="text" name="meta_title" placeholder="" value="{{$meta_title}}" class="form-control">
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label class="title-color">{{ \App\CPU\translate('Meta Description') }}</label>
                                        <textarea rows="10" type="text" name="meta_description" class="form-control">{{$meta_description}}</textarea>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <div class="">
                                            <label class="title-color">{{ \App\CPU\translate('Meta Image') }}</label>
                                        </div>
                                        <div class="border border-dashed">

                                            <div class="row" id="meta_img">
                                                <img class="w-100" height="auto"
                                                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                src="{{asset('storage/app/public/company')}}/{{$meta_image}}"  alt="Meta image">                                        

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12">
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn--primary px-4">{{\App\CPU\translate('submit')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2 mt-md-0">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.others-settings.update-default-quotation') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    @php
                                    $quotation_subject='';
                                    $quotation_note='';
                                    $quotation_remarks='';
                                    $quotation_signature='';

                                    $quotation_info=\App\Model\BusinessSetting::where('type','quotation_subject')->first();
                                    if($quotation_info != null ) $quotation_subject=$quotation_info->value;
                                    
                                    $quotation_info=\App\Model\BusinessSetting::where('type','quotation_note')->first();
                                    if($quotation_info != null ) $quotation_note=$quotation_info->value;
                                    
                                    $quotation_info=\App\Model\BusinessSetting::where('type','quotation_remarks')->first();
                                    if($quotation_info != null ) $quotation_remarks=$quotation_info->value;

                                    $quotation_info=\App\Model\BusinessSetting::where('type','quotation_remarks_1')->first();
                                    if($quotation_info != null ) $quotation_remarks_1=$quotation_info->value;
                                    
                                    $quotation_info=\App\Model\BusinessSetting::where('type','quotation_signature')->first();
                                    if($quotation_info != null ) $quotation_signature=$quotation_info->value;
                                    $quotation_info=\App\Model\BusinessSetting::where('type','quotation_vat')->first();
                                    if($quotation_info != null ) $quotation_vat=$quotation_info->value;

                                    @endphp

                                    <div class="col-md-12 form-group">
                                        <label class="title-color">{{ \App\CPU\translate('Quotation Subject') }}</label>
                                        <input type="text" name="quotation_subject" placeholder="" value="{{$quotation_subject}}" class="form-control">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="title-color">{{ \App\CPU\translate('Quotation Note') }}</label>
                                        <input type="text" name="quotation_note" placeholder="" value="{{$quotation_note}}" class="form-control">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="title-color">{{ \App\CPU\translate('Quotation Vat') }}</label>
                                        <input type="text" name="quotation_vat" placeholder="" value="{{$quotation_vat}}" class="form-control">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="title-color">{{ \App\CPU\translate('Quotation Remarks(With Vat)') }}</label>
                                        <textarea class="textarea editor-textarea" name="quotation_remarks" class="form-control">{{$quotation_remarks}}</textarea>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="title-color">{{ \App\CPU\translate('Quotation Remarks(Without Vat)') }}</label>
                                        <textarea class="textarea editor-textarea" name="quotation_remarks_1" class="form-control">{{$quotation_remarks_1}}</textarea>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label class="title-color">{{ \App\CPU\translate('Quotation Signature') }}</label>
                                        <textarea class="textarea editor-textarea" name="quotation_signature" class="form-control">{{$quotation_signature}}</textarea>
                                    </div>

                                </div>
                                <div class="col-12">
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn--primary px-4">{{\App\CPU\translate('submit')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>

        <div class="row mt-5" style="display: none;">
            <div class="col-md-6 mt-2 mt-md-0">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\translate('Digital Product')}}</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.product-settings.update-digital-product')}}"
                              method="post">
                            @csrf
                            <label class="title-color d-flex mb-3">{{\App\CPU\translate('Digital Product on/off')}}</label>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <input class="" name="digital_product" type="radio" value="1"
                                       id="defaultCheck1" {{$digital_product==1?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck1">
                                    {{\App\CPU\translate('Turn on')}}
                                </label>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <input class="" name="digital_product" type="radio" value="0"
                                       id="defaultCheck2" {{$digital_product==0?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck2">
                                    {{\App\CPU\translate('Turn off')}}
                                </label>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary">{{\App\CPU\translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2 mt-md-0">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\translate('Product_Brand')}}</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.product-settings.update-product-brand')}}"
                              method="post">
                            @csrf
                            <label class="title-color d-flex mb-3">{{\App\CPU\translate('Product Brand on/off')}}</label>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <input class="" name="product_brand" type="radio" value="1"
                                       id="defaultCheck3" {{$brand==1?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck3">
                                    {{\App\CPU\translate('Turn on')}}
                                </label>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <input class="" name="product_brand" type="radio" value="0"
                                       id="defaultCheck4" {{$brand==0?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck4">
                                    {{\App\CPU\translate('Turn off')}}
                                </label>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary">{{\App\CPU\translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')

    <script src="{{ asset('public/assets/back-end') }}/js/tags-input.min.js"></script>
    {{-- ck editor --}}
    <script src="{{ asset('/') }}vendor/ckeditor/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('/') }}vendor/ckeditor/ckeditor/adapters/jquery.js"></script>
    <script>
        function preview() {
            frame.src = URL.createObjectURL(event.target.files[0]);
        }
        function clearImage() {
            document.getElementById('formFile').value = null;
            frame.src = "";
        }
    </script>
    <script>
        $('.textarea').ckeditor({
            contentsLangDirection: '{{ Session::get('direction') }}',
        });
    </script>

    {{-- ck editor --}}

    <script src="{{ asset('public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
<script type="text/javascript">
              $(function() {
              $("#meta_img").spartanMultiImagePicker({
                fieldName: 'meta_image',
                maxCount: 1,
                rowHeight: '280px',
                groupClassName: 'col-12',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{ asset('public/assets/back-end/img/400x400/img2.jpg') }}',
                    width: '90%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error(
                    '{{ \App\CPU\translate('Please only input png or jpg type file') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function(index, file) {
                    toastr.error('{{ \App\CPU\translate('File size too big') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });

</script>
@endpush