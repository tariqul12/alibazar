@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Pick Up Points'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-1 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/banner.png')}}" alt="">
                {{\App\CPU\translate('Pick Up Points')}}
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
                                    {{ \App\CPU\translate('pick_up_point_table')}}
                                    <span
                                        class="badge badge-soft-dark radius-50 fz-12">{{ $pickup_points->total() }}</span>
                                </h5>
                            </div>
                            <div class="col-md-8 col-lg-6">
                                <div
                                    class="d-flex align-items-center justify-content-md-end flex-wrap flex-sm-nowrap gap-2">

                                    <div id="banner-btn">
                                        <a id="main-banner-add" class="btn btn--primary text-nowrap" href="{{ route('admin.pick_up_points.create') }}">
                                            <i class="tio-add"></i>
                                            {{ \App\CPU\translate('add_pickup_point')}}
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
                               <thead>
                                <tr>
                                    <th data-breakpoints="lg" width="10%">#</th>
                                    <th>{{('Name')}}</th>
                                    <th data-breakpoints="lg">{{('Manager')}}</th>
                                    <th data-breakpoints="lg">{{('Location')}}</th>
                                    <th data-breakpoints="lg">{{('Pickup Station Contact')}}</th>
                                    <th>{{('Status')}}</th>
                                    <th width="10%" class="text-right">{{('Options')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pickup_points as $key => $pickup_point)
                                    <tr>
                                        <td>{{ ($key+1) + ($pickup_points->currentPage() - 1)*$pickup_points->perPage() }}</td>
                                        <td>{{$pickup_point->name}}</td>
                                        @if ($pickup_point->staff != null && $pickup_point->staff->user != null)
                                            <td>{{$pickup_point->staff->user->name}}</td>
                                        @else
                                            <td><div class="badge badge-inline badge-danger">
                                                {{ ('No Manager') }}
                                            </div></td>
                                        @endif
                                        <td>{{$pickup_point->address}}</td>
                                        <td>{{$pickup_point->phone}}</td>
                                        <td>
                                            @if ($pickup_point->pick_up_status != 1)
                                                <div class="badge badge-inline badge-danger">
                                                    {{ ('Close') }}
                                                </div>
                                            @else
                                                <div class="badge badge-inline badge-success">
                                                    {{ ('Open') }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a class="btn btn-outline-info btn-sm square-btn" title="{{ \App\CPU\translate('Edit')}}"
                                                href="{{route('admin.pick_up_points.edit', ['id'=>$pickup_point->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}">
                                                <i class="tio-edit"></i>
                                                </a>
                                                <a class="btn btn-outline-danger btn-sm delete square-btn" title="{{ \App\CPU\translate('Delete')}}"
                                                href="{{ route('admin.pick_up_points.destroy', $pickup_point->id)}}" title="{{ ('Delete')  }}"">
                                                <i class="tio-delete"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-lg-end">
                            <!-- Pagination -->
                            {{$pickup_points->links()}}
                        </div>
                    </div>

                    @if(count($pickup_points)==0)
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
