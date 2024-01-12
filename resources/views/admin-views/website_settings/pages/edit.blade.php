@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Page Edit'))

@push('css_or_js')
    <link href="{{ asset('public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img src="{{asset('/public/assets/back-end/img/inhouse-product-list.png')}}" alt="">
                {{\App\CPU\translate('Add')}} {{\App\CPU\translate('New')}} {{\App\CPU\translate('Page')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <form class="page-form" action="{{ route('admin.custom-pages.update',$page->id) }}" method="POST" style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};" enctype="multipart/form-data">
                    @csrf
					@method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12 form-group">
                                <label class="title-color">{{ \App\CPU\translate('Title') }}</label>
                                <input type="text" name="title" placeholder="" class="form-control" required="" value="{{ $page->title }}">
                            </div>

                            <div class="col-md-12 form-group">
                                <label class="title-color">{{ \App\CPU\translate('Link') }}</label>
                                <div class="input-group d-block d-md-flex">
                                    <div class="input-group-prepend "><span class="input-group-text flex-grow-1">{{ route('home') }}</span></div>
                                    <input type="text" class="form-control w-100 w-md-auto" placeholder="Slug" name="slug" required="" value="{{ $page->slug }}">
                                </div>
                            </div>
                            <div class="col-md-12 form-group pt-1">
                                <label class="title-color pt-4">{{ \App\CPU\translate('Content') }}</label>
                                <!--<textarea rows="5" type="text" name="specifications" class="form-control pt-4"></textarea>-->
                                <textarea name="content" class="textarea editor-textarea">{{ $page->content }}</textarea>
                            </div>
                       </div>                  
				
                    </div>

                    <div class="card mt-2 rest-part">
                        <div class="card-header">
                            <h4 class="mb-0">{{ \App\CPU\translate('seo_section') }}</h4>
                        </div>
                        <div class="card-body">
                
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="title-color">{{ \App\CPU\translate('Meta Title') }}</label>
                                        <input type="text" name="meta_title" placeholder="" class="form-control" value="{{ $page->meta_title }}">
                                    </div>

                                    <div class="form-group">
                                        <label class="title-color">{{ \App\CPU\translate('Meta Description') }}</label>
                                        <textarea rows="10" type="text" name="meta_description" class="form-control">{{ $page->meta_description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="title-color" for="name">{{('Keywords')}}</label>
                                      
                                            <textarea class="resize-off form-control" placeholder="{{('Keyword, Keyword')}}" name="keywords">{{ $page->keywords  }}</textarea>
                                            <small class="text-muted">{{ ('Separate with coma') }}</small>
                                    
                                    </div>
                                 </div>
                               
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="formFile"  onchange="preview()" name="meta_image">
                                                <label class="custom-file-label" for="formFile" aria-describedby="inputGroupFileAddon02">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button type="button" class="input-group-text" id="formFileclear" onclick="clearImage()">Clear</button>
                                            </div>                                           
                                        </div>
                                        <img id="frame" src="{{ asset('public'.$page->meta_image)}}" class="img-fluid" />
                                    </div>
                                    
                                </div>

						    </div>
                        </div>
					</div>
                    <div class="row justify-content-end gap-3 mt-3">
                        <button type="submit" class="btn btn--primary">{{ \App\CPU\translate('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('public/assets/back-end') }}/js/tags-input.min.js"></script>
    <script src="{{ asset('public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
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
@endpush
