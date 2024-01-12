@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Account List'))

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
                <li class="breadcrumb-item">{{ \App\CPU\translate('Account List') }}</li>
            </ol>
        </nav>
    </div>
    {{-- list --}}
    <div class="col-sm-4 col-md-6 col-lg-12 mb-2 mb-sm-0">
        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.account.account_add') }}" type="button" class="btn btn--primary text-nowrap">
                <i class="tio-add"></i>
                {{ \App\CPU\translate('add_new') }}
            </a>
        </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ \App\CPU\translate('Accounts Table') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ \App\CPU\translate('SL#') }}</th>
                                    <th>{{ \App\CPU\translate('Account_no') }}</th>
                                    <th>{{ \App\CPU\translate('Name') }}</th>
                                    <th>{{ \App\CPU\translate('Balance') }}</th>
                                    <th style="width: 30px">{{ \App\CPU\translate('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($accounts as $k => $row)
                                    <tr>
                                        <th scope="row">{{ $i }}</th>
                                        <td>{{ $row->account_no }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->balance }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a class="btn btn-success text-white"
                                                    href="{{ route('admin.account.account_edit', $row->id) }}"><i
                                                        class="fa fa-edit"></i></a>
                                                <a class="btn btn-danger text-white"
                                                    href="{{ route('admin.account.account_delete', $row->id) }}"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
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
                                {!! $accounts->links() !!}
                            </div>
                        </div>
                    </div>
                    <!-- End Pagination -->
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
