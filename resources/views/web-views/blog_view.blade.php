@extends('layouts.front-end.app')

@push('css_or_js')
@endpush

@section('content')
    
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
               <div class="blog-details-title">
                    <h1>BLOG POST</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <a class="" href="{{ route('home') }}">
                    <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'right ml-2' : 'left mr-2'}}"></i>Back
                </a>
            </div>
        </div>
    </div>
    <div class="content container">
        <div class="row" id="printableArea">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="blog-details-card">
                    <div class="bg-image hover-overlay ripple blog-view" data-mdb-ripple-color="light">
                        <img src="{{ asset("$blog_data->post_img") }}" class="img-fluid" style="height: 300px;width:100%" />
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                    </div>
                    <div class="">
                        <h5 class="card-title-details">{{ $blog_data->title }}</h5>
                        <span class="blog-date"><i class="fa-solid fa-calendar-days"></i> {{ date('d-M-Y H:i',strtotime($blog_data->created_at)) }}</span>
                        
                        <p class="card-text">
                            {{ $blog_data->post }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Card -->
                
                <div class="right-card">
                    <h5 class="mt-3">Latest Post</h5>
                    @foreach ($blog_latest as $row)
                    <div class="row p-3">
                        <a href="{{route('blog_view', $row->id)}}" ><u>{{$row->title}}</u></a>
                    </div>
                    @endforeach
                    
                </div>
                <br>
                <div class="right-card">
                    <h5 class="mt-3">Popular Post</h5>
                    @foreach ($blog_popular as $row)
                    <div class="row p-3">
                        <a href="{{route('blog_view', $row->id)}}" ><u>{{$row->title}}</u></a>
                    </div>
                    @endforeach
                    
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->
    </div>
    <br>
@endsection

@push('script_2')
@endpush
