@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Blog Category'))

@push('css_or_js')
    <link href="{{ asset('public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/select2/css/select2.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/fontawesome.min.css"
        integrity="sha512-RvQxwf+3zJuNwl4e0sZjQeX7kUa3o82bDETpgVCH2RiwYSZVDdFJ7N/woNigN/ldyOOoKw8584jM4plQdt8bhA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css"
        integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="{{ route('admin.dashboard') }}">{{ \App\CPU\translate('Dashboard') }}</a>
                </li>
                <li class="breadcrumb-item">{{ \App\CPU\translate('Catgory edit') }}</li>
            </ol>
        </nav>
    </div>
    {{-- add --}}
    <form class="user" action="{{ route('admin.blog.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h5>{{ \App\CPU\translate('Category Edit') }}</h5>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('category_name') }}</label>
                            <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                name="cat_name" placeholder="{{ \App\CPU\translate('Ex: Entertainment') }}" value="{{$blog_cat->name}}" required>
                            <input type="hidden" value="{{$blog_cat->id}}" name="cat_id">
                            </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('slug') }}</label>
                            <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                name="slug" placeholder="{{ \App\CPU\translate('Ex: entertainment') }}" value="{{$blog_cat->slug}}" required>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end gap-10">
                    <button type="submit" class="btn btn--primary btn-user"
                        id="apply">{{ \App\CPU\translate('update') }}</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"
        integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
    @endpush
