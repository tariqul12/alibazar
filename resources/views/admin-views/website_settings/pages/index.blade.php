@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Website pages'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="mb-3">
        <h2 class="h1 mb-1 text-capitalize d-flex align-items-center gap-2">
            <img width="20" src="{{asset('/public/assets/back-end/img/banner.png')}}" alt="">
            {{\App\CPU\translate('Website pages')}}
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
                                {{ \App\CPU\translate('Pages Table')}}
                                <span
                                    class="badge badge-soft-dark radius-50 fz-12"></span>
                            </h5>
                        </div>
                        <div class="col-md-8 col-lg-6">
                            <div
                                class="d-flex align-items-center justify-content-md-end flex-wrap flex-sm-nowrap gap-2">


                                <div id="banner-btn">
                                    <a id="main-pages-add" class="btn btn--primary text-nowrap" href="{{ route('admin.custom-pages.create') }}">
                                        <i class="tio-add"></i>
                                        {{ \App\CPU\translate('add_pages')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="columnSearchDatatable"
                           style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                           class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                        <thead class="thead-light thead-50 text-capitalize">
                        <tr>
                            <th class="pl-xl-5">{{\App\CPU\translate('SL')}}</th>
                            <th>{{\App\CPU\translate('Name')}}</th>
                            <th>{{\App\CPU\translate('URL')}}</th>
                            <th class="text-center">{{\App\CPU\translate('action')}}</th>
                        </tr>
                        </thead>
                        @foreach ($pages as $key => $page)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                
                                @if($page->type == 'home_page')
                                    <td><a  class="text-reset">{{ $page->title}}</a></td>
                                    <td>{{ route('home') }}</td>
                                @else
                                    <td><a class="text-reset">{{ $page->title}}</a></td>
                                    <td>{{ route('home') }}/{{ $page->slug }}</td>
                                @endif
                                
                                <td class="text-right">
                                    @if($page->type == 'home_page')
                                        <a href="{{route('admin.custom-pages.edit', [$page->slug, 'lang'=>env('DEFAULT_LANGUAGE'), 'page'=>'home'] )}}" class="btn btn-icon btn-circle btn-sm btn-soft-primary" title="Edit">
                                            <i class="tio-edit"></i>
                                        </a>
                                    @else
                                        <a href="{{route('admin.custom-pages.edit', [$page->slug, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" class="btn btn-icon btn-circle btn-sm btn-soft-primary" title="Edit">
                                            <i class="tio-edit"></i>
                                        </a>
                                    @endif
                                    @if($page->type == 'custom_page')
                                        <a  class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" href="{{ route('admin.custom-pages.destroy', $page->id)}} " title="{{  ('Delete') }}">
                                            <i class="tio-delete"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
        	        @endforeach
                    </table>
                </div>

                <div class="table-responsive mt-4">
                    <div class="px-4 d-flex justify-content-lg-end">
                        <!-- Pagination -->
                        {{$pages->links()}}
                    </div>
                </div>

                @if(count($pages)==0)
                    <div class="text-center p-4">
                        <img class="mb-3 w-160"
                             src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                             alt="Image Description">
                        <p class="mb-0">{{ \App\CPU\translate('No_data_to_show')}}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


{{-- @section('modal')
    @include('modals.delete_modal')
@endsection --}}
