@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('SMS Template'))
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<style>
    .form-control {
        border-radius: 0;
        box-shadow: none;
        border-color: #d2d6de
    }

    .select2-hidden-accessible {
        border: 0 !important;
        clip: rect(0 0 0 0) !important;
        height: 1px !important;
        margin: -1px !important;
        overflow: hidden !important;
        padding: 0 !important;
        position: absolute !important;
        width: 1px !important
    }

    .form-control {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s
    }

    .select2-container--default .select2-selection--single,
    .select2-selection .select2-selection--single {
        border: 1px solid #d2d6de;
        border-radius: 0;
        padding: 6px 12px;
        height: 34px
    }

    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 1px solid #aaa;
        border-radius: 4px
    }

    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 28px;
        user-select: none;
        -webkit-user-select: none
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-right: 10px
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 0;
        padding-right: 0;
        height: auto;
        margin-top: -3px
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 28px
    }

    .select2-container--default .select2-selection--single,
    .select2-selection .select2-selection--single {
        border: 1px solid #d2d6de;
        border-radius: 0 !important;
        padding: 6px 12px;
        height: 40px !important
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 26px;
        position: absolute;
        top: 6px !important;
        right: 1px;
        width: 20px
    }
</style>
@section('content')
@php
    use Illuminate\Support\Facades\DB;
$sms_templates=DB::table('sms_templates')
            ->get();
@endphp
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{\App\CPU\translate('SMS Templates')}}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                            @foreach ($sms_templates as $key => $sms_template)
                                <a class="nav-link @if($sms_template->id == 1) active @endif" id="v-pills-tab-2" data-toggle="pill" href="#v-pills-{{ $sms_template->id }}" role="tab" aria-controls="v-pills-profile" aria-selected="false">{{ \App\CPU\translate(ucwords(str_replace('_', ' ', $sms_template->identifier)))  }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            @foreach ($sms_templates as $key => $sms_template)
                                <div class="tab-pane fade show @if($sms_template->id == 1) active @endif" id="v-pills-{{ $sms_template->id }}" role="tabpanel" aria-labelledby="v-pills-tab-1">
                                    <form action="{{ route('admin.orders.sms_templates_update')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="temp_id" value="{{$sms_template->id}}">
                                        @if($sms_template->identifier != 'phone_number_verification' && $sms_template->identifier != 'password_reset')
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label class="col-from-label">{{\App\CPU\translate('Activation')}}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <label class="aiz-switch aiz-switch-success mb-0">
                                                        <input value="1" name="status" type="checkbox" @if ($sms_template->status == 1)
                                                            checked
                                                        @endif>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label">{{\App\CPU\translate('SMS Body')}}</label>
                                            <div class="col-md-10">
                                                <textarea name="body" class="form-control" placeholder="Type.." rows="6" required>{{ $sms_template->sms_body }}</textarea>
                                                <small class="form-text text-danger">{{ ('**N.B : Do Not Change The Variables Like #____#') }}</small>
                                                @error('body')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 text-right">
                                            <button type="submit" class="btn btn-primary">{{\App\CPU\translate('Update Settings')}}</button>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

