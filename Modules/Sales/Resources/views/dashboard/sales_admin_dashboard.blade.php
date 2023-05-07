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
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div class="card bg-c-orenge text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total Sales Achievement</p>
                                                <h4 class="m-b-0">852</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="fas fa-hand-holding-usd f-50 text-c-orenge"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="card bg-c-lite-green text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">No of Client &nbsp; &nbsp; Involvement </p>
                                                <h4 class="m-b-0">852</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="fas fa-user-tie f-50 text-c-lite-green"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="card bg-c-yellow text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total Pre-Sales</p>
                                                <h4 class="m-b-0">852</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="fas fa-briefcase f-50 text-c-yellow"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="card bg-c-green text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total Workorder</p>
                                                <h4 class="m-b-0">105</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="far fa-user f-50 text-c-green"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12" style="padding:0px;">
                            <div class="card past-payment-card">
                                <div class="card-header">
                                    <div class="card-header-center text-center ">
                                        <h5 class="">List of Salesman</h5>
                                    </div>
                                </div <div class="table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <tbody>
                                        <tr>
                                            <td>John</td>
                                            <td>
                                                <span class="label label-success f-15">Target:</span> 1000
                                            </td>
                                            <td>
                                                <span class="label label-danger">Achievement:</span>900
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>John</td>
                                            <td>
                                                <span class="label label-success">Target:</span> 1000
                                            </td>
                                            <td>
                                                <span class="label label-danger">Achievement:</span>900
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            {{-- top performer --}}
                            <div class="col-xl-12 col-md-12" style="padding:0px;">
                                <div class="card past-payment-card">
                                    <div class="card-header">
                                        <div class="card-header-center text-center ">
                                            <h5 class="">Top Performer</h5>
                                        </div>
                                    </div>
                                    <div class="card-body card-body-center">
                                        <table class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Rank</th>
                                                    <th>Name</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>John</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>John</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>John</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div id="chartsView"></div>

                        </div>
                        <div>
                            <table class="highcharts-data-table table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Data</th>
                                        <th>Internet</th>
                                        <th>Data & Internet</th>
                                        <th>IoT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>OTC</td>
                                        <td>143,000</td>
                                        <td>260,000</td>
                                        <td>143,000</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>MRC</td>
                                        <td>143,000</td>
                                        <td>260,000</td>
                                        <td>143,000</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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

            // subtitle: {
            //     text: 'Source: <a href="https://irecusa.org/programs/solar-jobs-census/" target="_blank">IREC</a>',
            //     align: 'left'
            // },

            // yAxis: {
            //     title: {
            //         text: 'Number of Employees'
            //     }
            // },

            // xAxis: {
            //     accessibility: {
            //         rangeDescription: 'Range: 2010 to 2020'
            //     }
            // },

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
                    pointStart: 2010
                }
            },

            series: [{
                name: 'Data',
                data: [10000, 15000, 20000, 12000, 25000, 28000]
            }, {
                name: 'Internet',
                data: [24916, 30000, 29742, 29851, 32490, 30282]
            }, {
                name: 'Data & Internet',
                data: [11744, 30000, 16005, 19771, 20185, 24377]
            }, {
                name: 'IoT',
                data: [null, null, null, null, null, null, null]
            }, ],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
    </script>
@endsection
