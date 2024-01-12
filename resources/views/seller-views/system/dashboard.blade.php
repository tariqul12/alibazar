@extends('layouts.back-end.app-seller')

@section('title', \App\CPU\translate('Dashboard'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Heading -->
        <div class="page-header pb-0 border-0 mb-3">
            <div class="flex-between row align-items-center mx-1">
                <div>
                    <h1 class="page-header-title">{{\App\CPU\translate('Dashboard')}}</h1>
                    <div>{{ \App\CPU\translate('Welcome_message')}}.</div>
                </div>

                <div>
                    <a class="btn btn--primary" href="{{route('seller.product.list')}}">
                        <i class="tio-premium-outlined mr-1"></i> {{\App\CPU\translate('Products')}}
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Statistics -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row justify-content-between align-items-center g-2 mb-3">
                    <div class="col-sm-6">
                        <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
                            <img src="{{asset('/public/assets/back-end/img/business_analytics.png')}}" alt="">
                            {{\App\CPU\translate('business_analytics')}}
                        </h4>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-sm-end">
                        <select class="custom-select w-auto" name="statistics_type"
                                onchange="order_stats_update(this.value)">
                            <option
                                value="overall" {{session()->has('statistics_type') && session('statistics_type') == 'overall'?'selected':''}}>
                                {{\App\CPU\translate('Overall Statistics')}}
                            </option>
                            <option
                                value="today" {{session()->has('statistics_type') && session('statistics_type') == 'today'?'selected':''}}>
                                {{\App\CPU\translate('Todays Statistics')}}
                            </option>
                            <option
                                value="this_month" {{session()->has('statistics_type') && session('statistics_type') == 'this_month'?'selected':''}}>
                                {{\App\CPU\translate('This Months Statistics')}}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row g-2" id="order_stats">
                    @include('seller-views.partials._dashboard-order-stats',['data'=>$data])
                </div>
            </div>
        </div>

        <!-- Seller Wallet -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row justify-content-between align-items-center g-2 mb-3">
                    <div class="col-sm-6">
                        <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
                            <img width="20" class="mb-1" src="{{asset('/public/assets/back-end/img/admin-wallet.png')}}" alt="">
                            {{\App\CPU\translate('Seller_Wallet')}}
                        </h4>
                    </div>
                </div>
                <div class="row g-2" id="order_stats">
                    @include('seller-views.partials._dashboard-wallet-stats',['data'=>$data])
                </div>
            </div>
        </div>

        <div class="modal fade" id="balance-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content"
                     style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{\App\CPU\translate('Withdraw Request')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('seller.withdraw.request')}}" method="post">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">{{\App\CPU\translate('Amount')}}
                                    :</label>
                                <input type="number" name="amount" step=".01"
                                       value="{{\App\CPU\BackEndHelper::usd_to_currency($data['total_earning'])}}"
                                       class="form-control" id="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{\App\CPU\translate('Close')}}</button>
                            @if(auth('seller')->user()->account_no==null || auth('seller')->user()->bank_name==null)
                                <button type="button" class="btn btn--primary" onclick="call_duty()">
                                    {{\App\CPU\translate('Incomplete bank info')}}
                                </button>
                            @else
                                <button type="submit"
                                        class="btn btn--primary">{{\App\CPU\translate('Request')}}</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{--        <div class="user-overview-wrap mb-2">--}}
        {{--            <div class="card">--}}
        {{--                <div class="card-body">--}}
        {{--                    <div class="row g-2 align-items-center">--}}
        {{--                        <div class="col-md-5">--}}
        {{--                            <h4 class="d-flex align-items-center gap-10 mb-0">--}}
        {{--                                <img src="{{asset('/public/assets/back-end/img/order_statictics.png')}}" alt="">--}}
        {{--                                Order Statictics--}}
        {{--                            </h4>--}}
        {{--                        </div>--}}
        {{--                        <div class="col-md-7 d-flex justify-content-md-end">--}}
        {{--                            <ul class="option-select-btn">--}}
        {{--                                <li>--}}
        {{--                                    <label>--}}
        {{--                                        <input type="radio" name="statistics" hidden="" checked="">--}}
        {{--                                        <span>This Year</span>--}}
        {{--                                    </label>--}}
        {{--                                </li>--}}
        {{--                                <li>--}}
        {{--                                    <label>--}}
        {{--                                        <input type="radio" name="statistics" hidden="">--}}
        {{--                                        <span>This Month</span>--}}
        {{--                                    </label>--}}
        {{--                                </li>--}}
        {{--                                <li>--}}
        {{--                                    <label>--}}
        {{--                                        <input type="radio" name="statistics" hidden="">--}}
        {{--                                        <span>This Week</span>--}}
        {{--                                    </label>--}}
        {{--                                </li>--}}
        {{--                            </ul>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <!-- Bar Chart -->--}}
        {{--                    <div class="chartjs-custom mt-2">--}}
        {{--                        <canvas id="order_statictics" height="340"></canvas>--}}
        {{--                    </div>--}}
        {{--                    <!-- End Bar Chart -->--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--            <div class="card">--}}
        {{--                <div class="card-header">--}}
        {{--                    <h4 class="card-header__title">User Overview</h4>--}}
        {{--                </div>--}}
        {{--                <div class="card-body">--}}
        {{--                    <div class="position-relative">--}}
        {{--                        <h3 class="amount-of-user">1.6M+ <span>User</span></h3>--}}
        {{--                        <canvas id="user_overview" height="300" width="300"></canvas>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

        <div class="row g-2">
            <div class="col-lg-12">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Body -->
                    <div class="card-body">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-6">
                                <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
                                    <img src="{{asset('/public/assets/back-end/img/earning_statictics.png')}}" alt="">
                                    {{\App\CPU\translate('Earning_statistics')}}
                                </h4>
                            </div>
                            <div class="col-md-6 d-flex justify-content-md-end">
                                <ul class="option-select-btn">
                                    <li>
                                        <label>
                                            <input type="radio" name="statistics2" hidden="" checked="">
                                            <span data-earn-type="yearEarn"
                                                  onclick="earningStatisticsUpdate(this)">{{\App\CPU\translate('This_Year')}}</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="radio" name="statistics2" hidden="">
                                            <span data-earn-type="MonthEarn"
                                                  onclick="earningStatisticsUpdate(this)">{{\App\CPU\translate('This_Month')}}</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="radio" name="statistics2" hidden="">
                                            <span data-earn-type="WeekEarn"
                                                  onclick="earningStatisticsUpdate(this)">{{\App\CPU\translate('This Week')}}</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
{{--                        <div class="row mb-4">--}}
{{--                            <div class="col-6 graph-border-1">--}}
{{--                                <div class="mt-2 center-div">--}}
{{--                                      <span class="h6 mb-0">--}}
{{--                                          <i class="legend-indicator bg-success"--}}
{{--                                             style="background-color: #B6C867!important;"></i>--}}
{{--                                         {{\App\CPU\translate('Your Earnings')}} : {{\App\CPU\BackEndHelper::usd_to_currency(array_sum($seller_data))." ".\App\CPU\BackEndHelper::currency_symbol()}}--}}
{{--                                    </span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-6 graph-border-1">--}}
{{--                                <div class="mt-2 center-div">--}}
{{--                                      <span class="h6 mb-0">--}}
{{--                                          <i class="legend-indicator bg-danger"--}}
{{--                                             style="background-color: #01937C!important;"></i>--}}
{{--                                        {{\App\CPU\translate('Commission Given')}} : {{\App\CPU\BackEndHelper::usd_to_currency(array_sum($commission_data))." ".\App\CPU\BackEndHelper::currency_symbol()}}--}}
{{--                                    </span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <!-- End Row -->

                        <!-- Bar Chart -->
                        <div class="chartjs-custom mt-2" id="set-new-graph">
                            <canvas id="updatingData" class="earningShow"
                                    data-hs-chartjs-options='{
                            "type": "bar",
                            "data": {
                              "labels": ["Jan","Feb","Mar","April","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                              "datasets": [{
                                "label": "Seller",
                                "data": [
                                    @php($i = 0)
                                    @php($array_count = count($seller_data))
                                    @foreach($seller_data as $value)
                                    {{ $value }}{{ (++$i < $array_count) ? ',':'' }}
                                    @endforeach
                                        ],
                                        "backgroundColor": "#0177CD",
                                        "borderColor": "#0177CD"
                                      },
                                      {
                                        "label": "Commission",
                                        "data": [
                                    @php($i = 0)
                                    @php($array_count = count($commission_data))
                                    @foreach($commission_data as $value)
                                    {{ $value }}{{ (++$i < $array_count) ? ',':'' }}
                                    @endforeach
                                        ],
                                        "backgroundColor": "#FFB36D",
                                        "borderColor": "#FFB36D"
                                      }]
                                    },
                                    "options": {
                                    "legend": {
                                        "display": true,
                                        "position": "top",
                                        "align": "center",
                                        "labels": {
                                            "usePointStyle": true,
                                            "boxWidth": 6,
                                            "fontColor": "#758590",
                                            "fontSize": 14
                                        }
                                    },
                                      "scales": {
                                        "yAxes": [{
                                          "gridLines": {
                                                "color": "rgba(180, 208, 224, 0.5)",
                                                "borderDash": [8, 4],
                                                "drawBorder": false,
                                                "zeroLineColor": "rgba(180, 208, 224, 0.5)"
                                          },
                                          "ticks": {
                                            "beginAtZero": true,
                                            "stepSize": 50000,
                                            "fontSize": 12,
                                            "fontColor": "#97a4af",
                                            "fontFamily": "Open Sans, sans-serif",
                                            "padding": 10,
                                            "postfix": " {{\App\CPU\BackEndHelper::currency_symbol()}}"
                                  }
                                }],
                                "xAxes": [{
                                  "gridLines": {
                                        "color": "rgba(180, 208, 224, 0.5)",
                                        "display": true,
                                        "drawBorder": true,
                                        "zeroLineColor": "rgba(180, 208, 224, 0.5)"
                                  },
                                  "ticks": {
                                    "fontSize": 12,
                                    "fontColor": "#97a4af",
                                    "fontFamily": "Open Sans, sans-serif",
                                    "padding": 5
                                  },
                                  "categoryPercentage": 0.5,
                                  "maxBarThickness": "7"
                                }]
                              },
                              "cornerRadius": 3,
                              "tooltips": {
                                "prefix": " ",
                                "hasIndicator": true,
                                "mode": "index",
                                "intersect": false
                              },
                              "hover": {
                                "mode": "nearest",
                                "intersect": true
                              }
                            }
                          }'></canvas>
                        </div>
                        <!-- End Bar Chart -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-6">
                <!-- Card -->
                <div class="card h-100">
                    @include('seller-views.partials._top-selling-products',['top_sell'=>$data['top_sell']])
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-6">
                <!-- Card -->
                <div class="card h-100">
                    @include('seller-views.partials._most-rated-products',['most_rated_products'=>$data['most_rated_products']])
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="{{asset('public/assets/back-end')}}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/chart.js.extensions/chartjs-extensions.js"></script>
    <script
        src="{{asset('public/assets/back-end')}}/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>
@endpush

@push('script_2')
    <script>
        function earningStatisticsUpdate(t) {
            let value = $(t).attr('data-earn-type');

            $.ajax({
                url: '{{route('seller.dashboard.earning-statistics')}}',
                type: 'GET',
                data: {
                    type: value
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (response_data) {
                    document.getElementById("updatingData").remove();
                    let graph = document.createElement('canvas');
                    graph.setAttribute("id", "updatingData");
                    document.getElementById("set-new-graph").appendChild(graph);

                    var ctx = document.getElementById("updatingData").getContext("2d");
                    var options = {
                        responsive: true,
                        bezierCurve: false,
                        maintainAspectRatio: false,
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    color: "rgba(180, 208, 224, 0.5)",
                                    zeroLineColor: "rgba(180, 208, 224, 0.5)",
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    color: "rgba(180, 208, 224, 0.5)",
                                    zeroLineColor: "rgba(180, 208, 224, 0.5)",
                                    borderDash: [8, 4],
                                }
                            }]
                        },
                        legend: {
                            display: true,
                            position: "top",
                            labels: {
                                usePointStyle: true,
                                boxWidth: 6,
                                fontColor: "#758590",
                                fontSize: 14
                            }
                        },
                        plugins: {
                            datalabels: {
                                display: false
                            }
                        },
                    };
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: [],
                            datasets: [
                                {
                                    label: "In-house",
                                    data: [],
                                    backgroundColor: "#FFB36D",
                                    borderColor: "#FFB36D",
                                    fill: false,
                                    lineTension: 0.3,
                                    radius: 0
                                },
                                {
                                    label: "Seller",
                                    data: [],
                                    backgroundColor: "#0177CD",
                                    borderColor: "#0177CD",
                                    fill: false,
                                    lineTension: 0.3,
                                    radius: 0
                                }
                            ]
                        },
                        options: options
                    });

                    myChart.data.labels = response_data.seller_label;
                    myChart.data.datasets[0].data = response_data.seller_earn;
                    myChart.data.datasets[1].data = response_data.commission_earn;

                    myChart.update();
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }
    </script>
    <script>
        // INITIALIZATION OF CHARTJS
        // =======================================================
        Chart.plugins.unregister(ChartDataLabels);

        $('.js-chart').each(function () {
            $.HSCore.components.HSChartJS.init($(this));
        });

        var updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));
    </script>

    <script>
        var ctx = document.getElementById('business-overview');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    '{{\App\CPU\translate('customer')}} ',
                    '{{\App\CPU\translate('store')}} ',
                    '{{\App\CPU\translate('product')}} ',
                    '{{\App\CPU\translate('order')}} ',
                    '{{\App\CPU\translate('brand')}} ',
                ],
                datasets: [{
                    label: '{{\App\CPU\translate('business')}}',
                    data: ['{{$data['customer']}}', '{{$data['store']}}', '{{$data['product']}}', '{{$data['order']}}', '{{$data['brand']}}'],
                    backgroundColor: [
                        '#041562',
                        '#DA1212',
                        '#EEEEEE',
                        '#11468F',
                        '#000000',
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        $(function () {

            //get the doughnut chart canvas
            var ctx1 = $("#user_overview");

            //doughnut chart data
            var data1 = {
                labels: ["Customer", "Seller", "Delivery Man"],
                datasets: [
                    {
                        label: "User Overview",
                        data: [88297, 34546, 15000],
                        backgroundColor: [
                            "#017EFA",
                            "#51CBFF",
                            "#56E7E7",
                        ],
                        borderColor: [
                            "#017EFA",
                            "#51CBFF",
                            "#56E7E7",
                        ],
                        borderWidth: [1, 1, 1]
                    }
                ]
            };

            //options
            var options = {
                responsive: true,
                legend: {
                    display: true,
                    position: "bottom",
                    align: "start",
                    maxWidth: 100,
                    labels: {
                        usePointStyle: true,
                        boxWidth: 6,
                        fontColor: "#758590",
                        fontSize: 14
                    }
                },
                plugins: {
                    datalabels: {
                        display: false
                    }
                },
            };

            //create Chart class object
            var chart1 = new Chart(ctx1, {
                type: "doughnut",
                data: data1,
                options: options
            });
        });
    </script>

    <script>
        function call_duty() {
            toastr.warning('{{\App\CPU\translate('Update your bank info first!')}}', '{{\App\CPU\translate('Warning')}}!', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>

    <script>
        function order_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('seller.dashboard.order-stats')}}',
                data: {
                    statistics_type: type
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    $('#order_stats').html(data.view)
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }

        function business_overview_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.dashboard.business-overview')}}',
                data: {
                    business_overview: type
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    console.log(data.view)
                    $('#business-overview-board').html(data.view)
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }
    </script>
@endpush
