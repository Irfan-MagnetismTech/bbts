@extends('layouts.backend-layout')
@section('title', 'Sales Dashboard')

@section('breadcrumb-title')
    Sales Dashboard
@endsection
@section('style')
    <style>
        .progress {
            width: 100px;
            height: 100px;
            line-height: 100px;
            background: none;
            margin: 0 auto;
            box-shadow: none;
            position: relative;
        }

        .progress:after {
            content: "";
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 12px solid #fff;
            position: absolute;
            top: 0;
            left: 0;
        }

        .progress>span {
            width: 50%;
            height: 100%;
            overflow: hidden;
            position: absolute;
            top: 0;
            z-index: 1;
        }

        .progress .progress-left {
            left: 0;
        }

        .progress .progress-bar {
            width: 100%;
            height: 100%;
            background: none;
            border-width: 12px;
            border-style: solid;
            position: absolute;
            top: 0;
        }

        .progress .progress-left .progress-bar {
            left: 100%;
            border-top-right-radius: 80px;
            border-bottom-right-radius: 80px;
            border-left: 0;
            -webkit-transform-origin: center left;
            transform-origin: center left;
        }

        .progress .progress-right {
            right: 0;
        }

        .progress .progress-right .progress-bar {
            left: -100%;
            border-top-left-radius: 80px;
            border-bottom-left-radius: 80px;
            border-right: 0;
            -webkit-transform-origin: center right;
            transform-origin: center right;
            animation: loading-1 1.8s linear forwards;
        }

        .progress .progress-value {
            width: 90%;
            height: 90%;
            border-radius: 50%;
            background: #ffffff;
            font-size: 24px;
            color: #0ce6a8;
            line-height: 135px;
            text-align: center;
            position: absolute;
            top: -13%;
            left: 7%;
        }

        .progress.blue .progress-bar {
            border-color: #00fcc6;
        }

        .progress.blue .progress-left .progress-bar {
            animation: loading-2 1.5s linear forwards 1.8s;
        }

        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 360px;
            max-width: 800px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

        @keyframes loading-1 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(180deg);
                transform: rotate(180deg);
            }
        }

        @keyframes loading-2 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(144deg);
                transform: rotate(144deg);
            }
        }

        @keyframes loading-3 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(90deg);
                transform: rotate(90deg);
            }
        }

        @keyframes loading-4 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(36deg);
                transform: rotate(36deg);
            }
        }

        @keyframes loading-5 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(126deg);
                transform: rotate(126deg);
            }
        }

        @media only screen and (max-width: 990px) {
            .progress {
                margin-bottom: 20px;
            }
        }
    </style>

@endsection

@section('content')
    <div class="dt-responsive table-responsive">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-xl-3 col-md-3">
                                <div class="card bg-c-orenge text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total Sales</p>
                                                <h4 class="m-b-0">{{ $this_month_sale }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="fas fa-hand-holding-usd f-50 text-c-orenge"></i>
                                                <p class="label label-success" style="margin-top: 15px;">This Month</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-3">
                                <div class="card bg-c-lite-green text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total Sales </p>
                                                <h4 class="m-b-0">{{ $this_year_sale }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="fas fa-user-tie f-50 text-c-lite-green"></i>
                                                <p class="label label-warning" style="margin-top: 15px;">This Year</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-3">
                                <div class="card bg-c-yellow text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total FR</p>
                                                <h4 class="m-b-0">{{ $this_month_fr }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="far fa-user f-50 text-c-yellow"></i>
                                                <p class="label label-success" style="margin-top: 15px;">This Month</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-3">
                                <div class="card bg-c-green text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total FR</p>
                                                <h4 class="m-b-0">{{ $this_year_fr }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="far fa-user f-50 text-c-green"></i>
                                                <p class="label label-warning" style="margin-top: 15px;">This Year</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-3">
                                <div class="card bg-c-yellow text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total Pre-Sales</p>
                                                <h4 class="m-b-0">{{ $total_lead_generation }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="fas fa-briefcase f-50 text-c-yellow"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-3">
                                <div class="card bg-c-green text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Pending Pre Sales</p>
                                                <h4 class="m-b-0">{{ $pending_lead_generation }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="far fa-user f-50 text-c-green"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-3">
                                <div class="card bg-c-orenge text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total Client</p>
                                                <h4 class="m-b-0">{{ $total_client }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="far fa-user f-50 text-c-green"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-3">
                                <div class="card bg-c-blue text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Meeting Request</p>
                                                <h4 class="m-b-0">{{ $meeting_request }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="far fa-user f-50 text-c-green"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-center">Month Wise Product Sales</p>
                <div class="row">
                    <div id="chartsView" style="width: 100%"></div>
                </div>
                <div>
                    <table class="highcharts-data-table table table-striped table-bordered nowrap">
                        <thead>
                            @php
                                $colspan = count($this_year_salesman_sale);
                            @endphp
                            <tr>
                                <th colspan="{{ $colspan }}">Salesman Wise Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($this_year_salesman_sale as $key => $value)
                                    <td>{{ $key }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($this_year_salesman_sale as $key => $value)
                                    <td>{{ $value }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                    <table class="highcharts-data-table table table-striped table-bordered nowrap">
                        <thead>
                            @php
                                $colspan = count($this_year_product_wise_total_sale_amount);
                            @endphp
                            <tr>
                                <th colspan="{{ $colspan }}">Produt Wise Sale Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($this_year_product_wise_total_sale_amount as $key => $value)
                                    <td>{{ $key }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($this_year_product_wise_total_sale_amount as $key => $value)
                                    <td>{{ $value }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;


        Highcharts.chart('chartsView', {
            title: {
                text: '',
                align: 'left'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                    pointStart: 1
                }
            },
            xAxis: {
                categories: [
                    @foreach ($month_list as $month => $value)
                        '{{ $month }}',
                    @endforeach
                ],
                accessibility: {
                    rangeDescription: 'Range: 2010 to 2020'
                }
            },
            series: [
                @foreach ($month_wise_product_sale as $key => $value)
                    {
                        name: '{{ $key }}',
                        data: [
                            @foreach ($value as $key => $value)
                                {{ $value }},
                            @endforeach
                        ]
                    },
                @endforeach
            ],
            responsive: {
                rules: [{
                    condition: {
                        width: '100%'
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom',
                            width: '100%'
                        }
                    }
                }]
            }
        });
    </script>
@endsection
