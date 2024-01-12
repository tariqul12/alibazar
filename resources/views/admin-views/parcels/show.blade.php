@extends('layouts.back-end.app')

@section('title', 'Parcels')

@push('css_or_js')

@endpush
@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 d-flex gap-10">
                <img src="{{asset('/public/assets/back-end/img/brand-setup.png')}}" alt="">
                Tracking Parcel No: {!! $tracking_no ?? ' ' !!}
            </h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                            <form action="{{route('admin.parcel.parcel_tracking')}}" method="GET" >

                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="form-group">
                                            <label class="title-color" for="priority">
                                                Tracking No
                                            </label>
                                            <input type="text" class="form-control" name="tracking_no" value="{!! isset($tracking_no) ? $tracking_no : ' ' !!}">

                                        </div>
                                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                                            <button type="submit" class="btn btn--primary">{{\App\CPU\translate('submit')}}</button>
                                        </div>


                                    </div>

                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
<!--                    <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        @if(isset($tracking_info) && is_array($tracking_info))
                            @if(count($tracking_info))
                                @foreach($tracking_info as $trackingdata)
                                    <p>
                                        <strong>{!! isset($trackingdata['message_en']) ? $trackingdata['message_en'] : ' ' !!}</strong>
                                    </p>
                                    <p>
                                        <strong>{!! isset($trackingdata['time']) ? $trackingdata['time'] : ' ' !!}</strong>
                                    </p>

                                @endforeach
                            @else
                                <p>No data found</p>
                            @endif
                        @endif
                    </div>-->
                    <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        @if(isset($parcelData) && is_array($parcelData))
                            @if(count($parcelData))
                                @foreach($parcelData as $key=>$parcelData)
                                    <p>
                                        <strong>{!! $key !!}   :   {!! json_encode($parcelData) !!}</strong>
                                    </p>



                                @endforeach
                            @else
                                <p>No data found</p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')

@endpush
