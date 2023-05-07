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
                    <div class="col-xl-3 col-md-6">
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
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-c-green text-white">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <p class="m-b-5">Total Client</p>
                                        <h4 class="m-b-0">105</h4>
                                    </div>
                                    <div class="col col-auto text-right">
                                        <i class="far fa-user f-50 text-c-green"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-c-pink text-white">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <p class="m-b-5">Total FR</p>
                                        <h4 class="m-b-0">40</h4>
                                    </div>
                                    <div class="col col-auto text-right">
                                        <i class="fas fa-search-location f-50 text-c-pink"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-c-blue text-white">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <p class="m-b-5">Total Sales</p>
                                        <h4 class="m-b-0">502</h4>
                                    </div>
                                    <div class="col col-auto text-right">
                                        <i class="fas fa-shopping-cart f-50 text-c-blue"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div class="card bg-c-orenge text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total Survey</p>
                                                <h4 class="m-b-0">852</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="fas fa-broadcast-tower f-50 text-c-orenge"></i>
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
                                                <p class="m-b-5">Total Planning</p>
                                                <h4 class="m-b-0">852</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="fas fa-route f-50 text-c-lite-green"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12" style="padding:0px;">
                            <div class="card">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-4 mt-3">
                                            <div class="card bg-c-lite-green text-white">
                                                <div class="card-block">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <p class="m-b-5">Target</p>
                                                            <h4 class="m-b-0">1000</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <div class="card bg-c-lite-green text-white">
                                                <div class="card-block">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <p class="m-b-5">Achievement</p>
                                                            <h4 class="m-b-0">900</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <div class="progress blue">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">90%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="card past-payment-card">
                            <div class="card-header">
                                <div class="card-header-center text-center ">
                                    <h5 class="">Meeting Schedule</h5>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Client</th>
                                                <th>Type</th>
                                                <th>Date & Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p class="d-inline-block m-l-10 f-w-600">Erwin Brown</p>
                                                </td>
                                                <td>Meeting</td>
                                                <td>
                                                    <p>23 oct, 2017 6:23</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p class="d-inline-block m-l-10 f-w-600">Erwin Brown</p>
                                                </td>
                                                <td>
                                                    Schedule
                                                </td>
                                                <td>
                                                    <p>23 oct, 2017 6:23</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p class="d-inline-block m-l-10 f-w-600">Erwin Brown</p>
                                                </td>
                                                <td>
                                                    Meeting
                                                </td>
                                                <td>
                                                    <p>23 oct, 2017 6:23</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
    </script>
@endsection
