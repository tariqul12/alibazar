@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Blog Category'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="{{ route('admin.dashboard') }}">{{ \App\CPU\translate('Dashboard') }}</a>
                </li>
                <li class="breadcrumb-item">{{ \App\CPU\translate('Blog Edit') }}</li>
            </ol>
        </nav>
    {{-- add --}}
    <form class="user" action="{{ route('admin.blog.blog_update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h5>{{ \App\CPU\translate('Blog ADD') }}</h5>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('Title') }}<span style="color:red">*</span></label>
                            <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                name="title" placeholder="{{ \App\CPU\translate('Ex: title') }}" value={{$blog_post->title}} required>
                            <input type="hidden" name="blog_id" value="{{$blog_post->id}}">
                            </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('Category') }}<span style="color:red">*</span></label>
                            <select name="cat_id" id="" class="form-control form-control-user" required>
                                <option value="">--Select--</option>
                                @foreach ($blog_cat as $row)
                                    <option value="{{ $row->id }}" 
                                        @if($row->id==$blog_post->category_id)
                                        {
                                            {{'selected'}}
                                        }
                                        @endif>{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('post') }}<span style="color:red">*</span></label>
                            <textarea name="post" id="" class="textarea editor-textarea" placeholder="Post here..."  required>{{$blog_post->post}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ \App\CPU\translate('Post Image') }}<span style="color:red">*</span></label>
                            <i class="dripicons-question" data-toggle="tooltip"
                                title="Only jpg, jpeg, png, gif file is supported"></i>
                                <img src="{{ url($blog_post->post_img) }}" width="20%" height="10%"></td>
                            <input type="file" name="post_img" class="form-control" value="{{url($blog_post->post_img)}}"/>
                            @if ($errors->has('extension'))
                                <span>
                                    <strong>{{ $errors->first('extension') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <h5 style="color:lightblue">SEO ADD (Optinal)</h5>
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('meta_key') }}</label>
                            <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                name="meta_key" placeholder="{{ \App\CPU\translate('Ex: meta key') }}" value="{{$blog_post->meta_key}}">
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('Meta_description') }}</label>
                            <textarea name="meta_description" id="" cols="110" rows="5" class="form-control form-control-user" placeholder="Describe here...">{{$blog_post->meta_description}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end gap-10">
                    <button type="submit" class="btn btn--primary btn-user"
                        id="apply">{{ \App\CPU\translate('submit') }}</button>
                </div>
            </div>
        </div>
    </form>
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
