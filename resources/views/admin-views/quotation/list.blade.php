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
                                    <div>{{\App\CPU\translate('quotation_table')}} ({{ $pro->total() }})</div>
                                </h5>
                            </div>

                            <div class="col-12 col-md-3">
                                <a href="{{route('admin.quotation.add-new')}}" class="btn btn-primary  float-right">
                                    <i class="tio-add-circle"></i>
                                    <span class="text">{{\App\CPU\translate('add_new_quotation')}}</span>
                                </a>
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
                                    <th>{{\App\CPU\translate('SL#')}}</th>
                                    <th>{{\App\CPU\translate('file.Date')}}</th>
                                    <th>{{\App\CPU\translate('file.reference')}}</th>
                                    <th>{{\App\CPU\translate('file.customer')}}</th>
                                    <th>{{\App\CPU\translate('file.grand total')}}</th>
                                    <th>{{\App\CPU\translate('file.Quotation Status')}}</th>
                                    <th style="width: 5px" class="text-center">{{\App\CPU\translate('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pro as $k=>$p)
                                    <tr>
                                        <th scope="row">{{$pro->firstItem()+$k}}</th>
                                        <td>
                                            {!! $p->created_at !!}
                                        </td>

                                        <td>
                                            <a href="{{route('admin.quotation.view',[$p['id']])}}">
                                                {!! $p->reference_no !!}
                                            </a>
                                        </td>
                                       <td>
                                           {!! isset($p->customer->f_name)?$p->customer->f_name:'' !!}
                                       </td>
                                        <td>
                                            {!! round($p->grand_total,2) !!}
                                        </td>
                                            <?php
                                            if($p->quotation_status == 1)
                                                $status = \App\CPU\translate('file.Pending');
                                            else
                                                $status = \App\CPU\translate('file.Sent');
                                            ?>
                                        @if($p->quotation_status == 1)
                                            <td><div class="badge badge-danger">{{$status}}</div></td>
                                        @else
                                            <td><div class="badge badge-success">{{$status}}</div></td>
                                        @endif


                                        <td>
                                            @if($p->quotation_status == 1)
                                            <a class="btn btn-dark btn-sm"
                                                title="{{\App\CPU\translate('send_mail')}}"
                                                href="{{route('admin.quotation.send_mail',[$p['id']])}}">
                                                <i class="tio-send"></i>
                                            </a> |
                                            <a class="btn btn-primary btn-sm"
                                            title="{{\App\CPU\translate('edit')}}"
                                            href="{{route('admin.quotation.edit',[$p['id']])}}">
                                             <i class="tio-edit"></i>
                                            </a> |
                                            @endif
                                            <a class="btn btn-info btn-sm"
                                               title="{{\App\CPU\translate('view')}}"
                                               href="{{route('admin.quotation.view',[$p['id']])}}">
                                                <i class="tio-visible"></i>
                                            </a> 
                                            <!--@if($p->quotation_status == 2)-->
                                            |<a class="btn btn-sm btn-warning" target="_blank" title="download_pdf" href="{{route('admin.quotation.download',[$p['id']])}}"> <i class="tio-download"></i></a>
                                            <!--@endif-->
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