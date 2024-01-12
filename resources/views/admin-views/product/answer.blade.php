@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Answer'))

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="{{ route('admin.dashboard') }}">{{ \App\CPU\translate('Dashboard') }}</a>
                </li>
                <li class="breadcrumb-item">{{ \App\CPU\translate('Answer') }}</li>
            </ol>
        </nav>
    </div>
    <form class="user" action="{{ route('admin.product.answer_submit') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h5>{{ \App\CPU\translate('Answer') }}</h5>
                </div>
                <div class="row align-items-center">

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Product Name:</label>
                            <p>{{ $ans_question->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Question ?:</label>
                            <p>{{ $ans_question->question }}</p>
                            <input type="hidden" name="question_id" value="{{ $ans_question->question_id }}">
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('Answer') }}<span
                                    style="color:red">*</span></label>
                            <textarea name="answer" id="" cols="110" rows="4" class="form-control form-control-user"
                                placeholder="Answer here..." required></textarea>
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
@endsection

@push('script')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"
        integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
    @endpush
