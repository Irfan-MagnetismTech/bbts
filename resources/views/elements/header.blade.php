<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'BBTS Ltd') | {{ config('businessinfo.name') }}</title>
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <![endif]-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <link rel="icon" href="{{ config('businessinfo.favicon') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/icofont.css') !!}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.min.css') }}">
    @yield('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.mCustomScrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/component.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toastify.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/switchery.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.step.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/myCustomScroll.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            background: none !important;
            line-height: 1 !important;
        }

        .select2-container--default .select2-selection--single {
            border-radius: 0 !important;
            height: 35px;
            font-size: 13px !important;
            border: 1px solid #cccccc !important;
        }

        .ui-menu-item {
            text-align: center;
        }
    </style>
    @yield('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    <style>
        .form-control[readonly],
        .form-control[readonly="true"],
        .form-control[readonly="readonly"] {
            background: #edeaed !important;
            opacity: 1;
        }

        .form-control[readonly]+label,
        .form-control[readonly="true"]+label,
        .form-control[readonly="readonly"]+label {
            background: linear-gradient(to bottom, #ffffff 50%, #edeaed 50%) !important;
        }
    </style>
</head>

<body>
    <div class="theme-loader">
        <div class="loader animation-start">
            <span class="circle delay-1 size-2"></span>
            <span class="circle delay-2 size-4"></span>
            <span class="circle delay-3 size-6"></span>
            <span class="circle delay-4 size-7"></span>
            <span class="circle delay-5 size-7"></span>
            <span class="circle delay-6 size-6"></span>
            <span class="circle delay-7 size-4"></span>
            <span class="circle delay-8 size-2"></span>
        </div>
    </div><!-- Pre-loader end -->

    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <div class="navbar-logo">
                        <a class="mobile-menu" style="color: #000;" id="mobile-collapse" href="#"><i
                                class="ti-menu"></i></a>
                        <div class="mobile-search">
                            <div class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                        <input type="text" class="form-control" placeholder="Enter Keyword">
                                        <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="">
                            <h4 class="my-0">
                                <img src="{{ config('businessinfo.logo') }}" alt="">
                            </h4>
                        </a>
                        <a class="mobile-options">
                            <i class="ti-more"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li>
                                <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a>
                                </div>
                            </li>
                            <li>
                                <a href="#" onclick="javascript:toggleFullScreen()">
                                    <i class="ti-fullscreen" style="color: #000;"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right">
                            {{-- header-notification --}}
                            {{-- comments --}}
                            <li class="header-notification">
                                <a href="#!">
                                    <i class="ti-bell" style="font-size: 24px"></i>
                                    <span class="badge bg-c-pink" style="top: 5px" id="notificationCount">
                                        {{ count(auth()->user()->unreadNotifications) }}
                                    </span>
                                </a>
                                <ul class="show-notification" id="notification-list-popup">
                                    @forelse(auth()->user()->unreadNotifications as $notification)
                                        <li>
                                            <a href="{{ url($notification->data['url']) }}"
                                                style="font-size: 12px; padding: 0" class="text-left p-0 d-block">
                                                {{ $notification->data['message'] }} <br>
                                                <small>
                                                    at
                                                    {{ \Carbon\Carbon::parse($notification->created_at)->format('d/m/Y \a\t h:i a') }}
                                                </small>
                                            </a>
                                        </li>
                                        @if ($loop->index > 8)
                                            @php break; @endphp
                                        @endif
                                    @empty
                                        <li id="no-notification">No notification</li>
                                    @endforelse
                                    <li>
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('read-all-notification') }}"
                                                class="btn btn-primary">Mark all as read</a>
                                            <a href="{{ route('all-notifications') }}" class="btn btn-info">See all
                                                notification</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="user-profile header-notification">
                                <a href="#">
                                    {{-- <img src="../files/assets/images/avatar-4.jpg" class="img-radius" alt="User-Profile-Image"> --}}
                                    <span>{{ Auth::user()->name ?? '' }}</span> <i class="ti-angle-down"></i>
                                </a>
                                <ul class="show-notification profile-notification">


                                    <li>
                                        <a href="{{ route('password-change-form') }}"><i
                                                class="ti-settings"></i>Change
                                            Password</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i>Logout
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">--}}
                                                @csrf
                                            </form>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav> <!-- end header -->
