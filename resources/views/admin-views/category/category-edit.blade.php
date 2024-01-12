@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Category'))

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0">
                <img src="{{asset('/public/assets/back-end/img/brand-setup.png')}}" class="mb-1 mr-1" alt="">
                @if($category['position'] == 1)
                    {{\App\CPU\translate('Sub')}}
                @elseif($category['position'] == 2)
                    {{\App\CPU\translate('Sub Sub')}}
                @endif
                {{\App\CPU\translate('Category')}}
                {{\App\CPU\translate('Update')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!-- <div class="card-header">
                        {{ \App\CPU\translate('category_form')}}
                    </div> -->
                    <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        <form action="{{route('admin.category.update',[$category['id']])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @php($language=\App\Model\BusinessSetting::where('type','pnc_language')->first())
                            @php($language = $language->value ?? null)
                            @php($default_lang = 'en')

                            @php($default_lang = json_decode($language)[0])
                            <ul class="nav nav-tabs w-fit-content mb-4">
                                @foreach(json_decode($language) as $lang)
                                    <li class="nav-item text-capitalize">
                                        <a class="nav-link lang_link {{$lang == $default_lang? 'active':''}}"
                                           href="#"
                                           id="{{$lang}}-link">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="row">
                                <div class="{{ $category['parent_id']==0 ? 'col-lg-6':'col-12' }}">
                                    @foreach(json_decode($language) as $lang)
                                    <div>
                                        <?php
                                        if (count($category['translations'])) {
                                            $translate = [];
                                            foreach ($category['translations'] as $t) {
                                                if ($t->locale == $lang && $t->key == "name") {
                                                    $translate[$lang]['name'] = $t->value;
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="form-group {{$lang != $default_lang ? 'd-none':''}} lang_form"
                                            id="{{$lang}}-form">
                                            <label class="title-color">{{\App\CPU\translate('Category_Name')}}
                                                ({{strtoupper($lang)}})</label>
                                            <input type="text" name="name[]"
                                                value="{{$lang==$default_lang?$category['name']:($translate[$lang]['name']??'')}}"
                                                class="form-control"
                                                placeholder="{{\App\CPU\translate('New')}} {{\App\CPU\translate('Category')}}" {{$lang == $default_lang? 'required':''}}>
                                        </div>
                                        <input type="hidden" name="lang[]" value="{{$lang}}">
                                    </div>
                                    @endforeach

                                    <div class="form-group">
                                        <label class="title-color" for="priority">{{\App\CPU\translate('priority')}}</label>
                                        <select class="form-control" name="priority" id="" required>
                                            @for ($i = 0; $i <= 10; $i++)
                                            <option
                                            value="{{$i}}" {{$category['priority']==$i?'selected':''}}>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="title-color">{{ \App\CPU\translate('Description') }}</label>
                                        <textarea rows="10" type="text" name="description" class="form-control">{{$category['description']}}</textarea>
                                    </div>                                    
                                <!--image upload only for main category-->
                                @if($category['parent_id']==0)
                                    <div class="from_part_2">
                                        <label class="title-color">{{\App\CPU\translate('Category Logo')}}</label>
                                        <span class="text-info">({{\App\CPU\translate('ratio')}} 1:1)</span>
                                        <div class="custom-file text-left">
                                            <input type="file" name="image" id="customFileEg1"
                                                   class="custom-file-input"
                                                   accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label"
                                                   for="customFileEg1">{{\App\CPU\translate('choose')}} {{\App\CPU\translate('File')}}</label>
                                        </div>
                                    </div>
                                <div class="col-lg-6 mt-5 mt-lg-0 from_part_2">
                                    <div class="form-group">
                                        <center>
                                            <img class="upload-img-view"
                                                    id="viewer"
                                                    src="{{asset('storage/app/public/category')}}/{{$category['icon']}}"
                                                    alt=""/>
                                        </center>
                                    </div>
                                </div>
                                @endif
                                <div class="card mt-2 mb-2 rest-part">
                                    <div class="card-header">
                                        <h4 class="mb-0">{{ \App\CPU\translate('seo_section') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label class="title-color">{{ \App\CPU\translate('Meta Title') }}</label>
                                                <input type="text" name="meta_title" placeholder="" class="form-control" value="{{$category['meta_title']}}">
                                            </div>

                                            <div class="col-md-12 form-group">
                                                <label class="title-color">{{ \App\CPU\translate('Meta Description') }}</label>
                                                <textarea rows="10" type="text" name="meta_description" class="form-control">{{$category['meta_description']}}</textarea>
                                            </div>
                                            <div class="col-md-12 form-group">
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
                                                                         src="{{asset("storage/app/public/category/")}}/{{$category['meta_image']}}"
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

                                </div>

                                
                                @if($category['parent_id']!=0)
                                        <div class="d-flex justify-content-end gap-3">
                                            <button type="reset" id="reset" class="btn btn-secondary px-4">{{ \App\CPU\translate('reset')}}</button>
                                            <button type="submit" class="btn btn--primary px-4">{{ \App\CPU\translate('update')}}</button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if($category['parent_id']==0)
                                <div class="d-flex justify-content-end gap-3">
                                    <button type="reset" id="reset" class="btn btn-secondary px-4">{{ \App\CPU\translate('reset')}}</button>
                                    <button type="submit" class="btn btn--primary px-4">{{ \App\CPU\translate('update')}}</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('public/assets/back-end/js/spartan-multi-image-picker.js')}}"></script>

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
                $(".from_part_2").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });

        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
        
        $(function () {
            $("#meta_img").spartanMultiImagePicker({
                fieldName: 'meta_image',
                maxCount: 1,
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
        });
        
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>
@endpush
