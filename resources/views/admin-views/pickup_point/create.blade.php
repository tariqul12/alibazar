@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Pick Up Point Add'))

@push('css_or_js')
    <link href="{{asset('public/assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" src="{{asset('/public/assets/back-end/img/brand.png')}}" alt="">
            {{\App\CPU\translate('Pick Up Point')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form class="g-3" action="{{route('admin.pick_up_points.store')}}" method="post">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="pickname" class="form-label">Name</label>
                            <input type="text" class="form-control" id="pickname" placeholder="Enter your name" name="name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="pickphone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="pickphone" placeholder="Enter your phone" name="phone">
                                </div>
                            </div>
                        </div>
                    
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <label for="plocation" class="form-label">Location</label>
                            <textarea class="form-control" id="plocation" rows="3" name="address"></textarea>
                                </div>
                          
                                <div class="col-lg-6">
                                    <label for="pstatus" class="form-label">Status</label>
                                    <div class="form-group">
                                    <label for="pstatus"></label>
                                    <select class="form-control" name="pick_up_status" id="pstatus">
                                        <option value="0" class="d-none" selected>Select Any One</option>
                                        <option value="1">Published</option>
                                        <option value="2">Draft</option>
                                    </select>
                                    </div>
                                </div>
                                </div>
                        </div>
        
                        <div class="d-flex align-items-center justify-content-end gap-10 m-3">
                            <button type="submit" class="btn btn--primary btn-user"
                                id="apply">{{ \App\CPU\translate('Add Pickup Point') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
