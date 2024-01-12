@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Blog List'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
    <!-- Page Title -->
    <div class="mb-3">
        <h2 class="h1 mb-1 text-capitalize d-flex align-items-center gap-2">
            <img width="20" src="{{asset('/public/assets/back-end/img/banner.png')}}" alt="">
            {{\App\CPU\translate('Blog')}}
        </h2>
    </div>
    <!-- End Page Title -->
    <div class="row" id="banner-table">
        <div class="col-md-12">
            <div class="card">
                    <div class="px-3 py-4">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-lg-6 mb-2 mb-md-0">
                                <h5 class="mb-0 text-capitalize d-flex gap-2">
                                    {{ \App\CPU\translate('Blog Management')}}
                                    <span
                                        class="badge badge-soft-dark radius-50 fz-12"></span>
                                </h5>
                            </div>
                            <div class="col-md-8 col-lg-6">
                                <div
                                    class="d-flex align-items-center justify-content-md-end flex-wrap flex-sm-nowrap gap-2">
    
    
                                    <div id="banner-btn">
                                        <a id="main-pages-add" class="btn btn--primary text-nowrap" href="{{ route('admin.blog.blog_add') }}">
                                            <i class="tio-add"></i>
                                            {{ \App\CPU\translate('add_new_blog')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ \App\CPU\translate('SL#') }}</th>
                                    <th>{{ \App\CPU\translate('image') }}</th>
                                    <th>{{ \App\CPU\translate('title') }}</th>
                                    <th>{{ \App\CPU\translate('post') }}</th>
                                    <th>{{ \App\CPU\translate('category') }}</th>
                                    <th style="width: 30px">{{ \App\CPU\translate('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($blog_post as $k => $blog)
                                <tr>
                                    <th scope="row">{{$i}}</th>
                                    <td>
                                        <img src="{{ url($blog->post_img) }}" width="50%" height="50%"></td>
                                    <td>{{$blog->title}}</td>
                                    <td>{{$blog->post}}</td>
                                    <td>{{$blog->cat_name}}</td>
                                    <td>
                                        <a class="btn btn-success text-white" href="{{ route('admin.blog.blog_edit', $blog->id) }}"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-danger text-white" href="{{ route('admin.blog.blog_delete', $blog->id) }}"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <!-- Pagination -->
                    <div class="row justify-content-center justify-content-sm-between align-items-sm-center">


                        <div class="col-sm-auto">
                            <div class="d-flex justify-content-center justify-content-sm-end">
                                {!! $blog_post->links() !!}
                            </div>
                        </div>
                    </div>
                    <!-- End Pagination -->
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('script')
@endpush
