@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Request a call back'))

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
                <li class="breadcrumb-item">{{ \App\CPU\translate('Request a call back') }}</li>
            </ol>
        </nav>
    
        {{-- list --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ \App\CPU\translate('Request_a_call_back') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" >
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ \App\CPU\translate('SL#') }}</th>
                                        <th>{{ \App\CPU\translate('Product') }}</th>
                                        <th>{{ \App\CPU\translate('Name') }}</th>
                                        <th>{{ \App\CPU\translate('Phone') }}</th>
                                        <th>{{ \App\CPU\translate('preferred_date') }}</th>
                                        <th class="text-center">{{\App\CPU\translate('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach ($call_back as $k => $row)
                                    <tr>
                                        <th scope="row">{{$i}}</th>
                                        <td style="max-width: 350px;"><a href="{{route('frontend.product_details',$row->slug)}}" target="_blank">{{$row->product_name}}</a></td>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->phone}}</td>
                                        <td>{{date(('d M, Y'),strtotime($row->preferred_dt))}} - {{$row->preffered_time}} </td>
                                        <td class="text-center">
                                            
                                            
                                            @if($row->status == 0)
                                            <div class="d-flex justify-content-center gap-2">
                                                <a title="{{\App\CPU\translate('Mark as Read')}}"
                                                   class="btn btn-outline-info btn-sm square-btn" style="width: 95px;"
                                                   onclick="route_alert('{{route('admin.customer.update_request_call_back',[$row->id, 1])}}','Change status to Mark as Done ?')"
                                                        href="javascript:">
                                                    Mark as Done
                                                </a>
                                                <a title="{{\App\CPU\translate('Reject')}}"
                                                   class="btn btn-outline-danger btn-sm square-btn" style="width: 60px;"
                                                   onclick="route_alert('{{route('admin.customer.update_request_call_back',[$row->id, 2])}}','Change status to Rejected ?')"
                                                    href="javascript:">
                                                    Reject
                                                </a>
                                                
                                            </div>
                                            @else
                                                <b>{{ $row->status == 1 ? 'Done' : 'Rejected'}}</b>
                                            @endif
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
                                    {!!$call_back->links() !!}
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
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"
        integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
    @endpush
