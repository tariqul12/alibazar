@extends('layouts.back-end.app')

@section('title', 'Parcels')

@push('css_or_js')

@endpush
@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 d-flex gap-10">
                <img src="{{asset('/public/assets/back-end/img/brand-setup.png')}}" alt="">
                Order Parcel
            </h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        <form action="{{route('admin.parcel.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <label class="title-color" for="priority">
                                            Order Id
                                        </label>

                                        <select class="form-control select2" name="order_id" data-live-search="true" id="" required>
                                            <option disabled selected>Set OrderId</option>
                                            @if(count($orders))
                                                @foreach($orders as $key=>$order)
                                            <option value="{!! $order->id !!}" @if($order->id == $order_id) selected @endif>{!! $order->id.' | Amount: '.$order->order_amount !!}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="title-color" for="priority">
                                           Set Area
                                        </label>

                                        <select class="form-control select2" name="post_code" id="" required>
                                            <option disabled selected>Set Area_id</option>
                                            @if(count($areas))
                                                @foreach($areas as $key=>$area)
                                                    <option value="{!! $area['post_code'] !!}">{!! $area['name'].' | Post Code: '.$area['post_code'] !!}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="title-color" for="priority">
                                            Set Weight
                                        </label>
                                        <input type="text" class="form-control" name="weight" required>

                                    </div>

                                </div>

                            </div>
                            <div class="d-flex flex-wrap gap-2 justify-content-end">
                                <button type="reset" id="reset" class="btn btn-secondary">{{\App\CPU\translate('reset')}}</button>
                                <button type="submit" class="btn btn--primary">{{\App\CPU\translate('submit')}}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $('.select2').select2();
    </script>

@endpush