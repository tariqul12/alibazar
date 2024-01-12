@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Transaction Add'))

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
                <li class="breadcrumb-item">{{ \App\CPU\translate('Transaction Add') }}</li>
            </ol>
        </nav>
    </div>
    {{-- add --}}
    <form class="user" action="{{ route('admin.account.transaction_store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h5>{{ \App\CPU\translate('Add New Transaction') }}</h5>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('Payer') }}<span style="color:red">*</span></label>
                            <select name="cust_id" id="" class="form-control form-control-user" required>
                                <option value="">--Select--</option>
                                @foreach ($customer as $row)
                                    <option value="{{ $row->id }}">{{ $row->f_name }} {{ $row->l_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('C/O') }}<span style="color:red">*</span></label>
                            <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                name="co" placeholder="{{ \App\CPU\translate('Ex: C/O') }}" required>
                        </div>
                    </div>
                </div>
               
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('Account') }}<span style="color:red">*</span></label>
                                <select name="account_no" id="" class="form-control form-control-user" required>
                                    <option value="">--Select--</option>
                                    @foreach ($accounts as $row)
                                        <option value="{{ $row->id }}">{{ $row->account_no }}-{{ $row->name }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('Date') }}<span style="color:red">*</span></label>
                            <input type="date" class="form-control form-control-user" id="exampleFirstName"
                                name="txn_dt"  required>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('Amount') }}<span style="color:red">*</span></label>
                            <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                name="amount" placeholder="{{ \App\CPU\translate('Ex: 5000') }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('Type') }}<span style="color:red">*</span></label>
                            <select name="type" id="" class="form-control form-control-user" required>
                                <option value="">--Select--</option>
                                <option value="Income">Income</option>
                                <option value="Expense">Expense</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('Category') }}<span style="color:red">*</span></label>
                            <select name="category" id="" class="form-control form-control-user" required>
                                <option value="">--Select--</option>
                                <option value="Sales">Sales</option>
                                <option value="Store">Store</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('Method') }}<span style="color:red">*</span></label>
                            <select name="method" id="" class="form-control form-control-user" required>
                                <option value="">--Select--</option>
                                <option value="Cash">Cash</option>
                                <option value="Bank">Bank</option>
                                <option value="MFS">MFS</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFirstName"
                                class="title-color d-flex gap-1 align-items-center">{{ \App\CPU\translate('note') }}<span style="color:red">*</span></label>
                            <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                name="note" placeholder="{{ \App\CPU\translate('Ex: Text') }}" required>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end gap-10">
                    <button type="submit" class="btn btn--primary btn-user"
                        id="apply">{{ \App\CPU\translate('Add Transaction') }}</button>
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
