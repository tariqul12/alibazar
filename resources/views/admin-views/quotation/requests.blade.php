@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Quotations'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">  <!-- Page Heading -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a></li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('Quotations')}}</li>
            </ol>
        </nav>

        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row flex-between justify-content-between align-items-center flex-grow-1">
                            <div class="col-12 mb-1 col-md-4">
                                <h5 class="flex-between">
                                    <div>Quotation Requests ({{ $pro->total() }})</div>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table id="datatable" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                   class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                   style="width: 100%">
                                <thead class="thead-light">
                                <tr>
                                    <!-- <th>{{\App\CPU\translate('SL#')}}</th> -->
                                    <th>{{\App\CPU\translate('file.customer')}}</th>
                                    <th>{{\App\CPU\translate('email')}}</th>
                                    <th>{{\App\CPU\translate('phone')}}</th>
                                    <th>{{\App\CPU\translate('Company')}}</th>
                                    <th>{{\App\CPU\translate('address')}}</th>
                                    <th>{{\App\CPU\translate('file.name')}}</th>
                                    <th> Status</th>
                                    <th>{{\App\CPU\translate('file.Date')}}</th>
                                    <th style="width: 5px" class="text-center">{{\App\CPU\translate('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pro as $k=>$p)
                                    <tr>
                                        <!-- <th scope="row">{{$pro->firstItem()+$k}}</th> -->
                                        <td>
                                            {!! $p->f_name.' '.$p->l_name !!}
                                        </td>
                                        <td>{!! $p->email !!}</td>
                                        <td>{!! $p->phone !!}</td>
                                        <td>{!! $p->company !!}</td>
                                        <td>{!! $p->address !!}</td>
                                        <td>{!! $p->file_name !!}</td>
                                        <td>{!! $p->quotation_status !!}</td>
                                        <td>{!! $p->created_at !!}</td>

                                        <td>
                                            @if(isset($p->quotation_id) && $p->quotation_id == '0')
                                            <a class="btn btn-action btn-sm" target="_blank"
                                               title="Add Quotation"
                                               href="{{route('admin.quotation.request.create',['request_id'=>$p->id])}}">
                                                <i class="tio-add-circle-outlined"></i>
                                            </a>
                                            @else
                                                <a class="btn btn-success btn-sm" target="_blank"
                                                   title="Qutotation Details"
                                                   href="{{route('admin.quotation.view',[$p->quotation_id])}}">
                                                    <i class="tio-agenda-view"></i>
                                                </a>
                                            @endif
                                            <a class="btn btn-info btn-sm" target="_blank"
                                               title="{{\App\CPU\translate('view')}}"
                                               href="{{asset("$p->rfq_file")}}">
                                                <i class="tio-visible"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{$pro->links()}}
                    </div>
                    @if(count($pro)==0)
                        <div class="text-center p-4">
                            <img class="mb-3" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">
                            <p class="mb-0">{{\App\CPU\translate('No data to show')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });


    </script>
@endpush
