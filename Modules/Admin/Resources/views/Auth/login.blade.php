<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ config('businessinfo.name') }} || @yield('title', 'BBTS Ltd')</title>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    {{--    <link rel="icon" href="../files/assets/images/favicon.ico" type="image/x-icon"> --}}
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{!! asset(url('css/bootstrap.min.css')) !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset(url('css/style.css')) !!}">
    <style>
        
        body{
            /* background: #ffffff!important; */
            background-image: url("{{ asset('/images/back_image.png') }}");
            background-size: 100% 100%;
            background-repeat: no-repeat;
            height: 100vh;
            background-position: center;
        }
        .btn-color{
            backgrounk-color: #227447;
        }
        /* Small devices (landscape phones, 576px and < 576) */
        @media (max-width: 576px) {
            .loginLogo {
                margin-top: 30px;
                margin-bottom: 20px;
            }

            .loginInfo {
                margin-top: 250px;
                width: 100%
            }
        }


        /* Small devices (landscape phones, 576px and < 768) */
        @media (min-width: 576px) {
            .loginLogo {
                margin-bottom: 20px;
            }

            .loginInfo {
                margin-top: 300px;
                width: 100%
            }
        }

        /* Medium devices (Tab, 768px and < 992) */
        @media (min-width: 768px) {
            .loginLogo {
                margin-bottom: 20px;
            }

            .loginInfo {
                margin-top: 400px;
                width: 50%
            }
        }

        /* Large devices (Desktop, 768px and < 992) */
        @media (min-width: 992px) {
            .loginLogo {
                margin-top: 20px;
                margin-bottom: 20px;
            }

            .loginInfo {
                margin-top: 200px;
                width: 30%
            }
        }

        /* Extra large devices (Big size Monitor, Projector, etc 768px and < 992) */
        @media (min-width: 1367px) {
            .loginLogo {
                margin-top: 20px;
                margin-bottom: 20px;
            }

            .loginInfo {
                margin-top: 400px;
                width: 30%
            }
        }

        #fixed_position{
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }
    </style>
    
</head>

<body class="fix-menu">
<!-- Pre-loader start -->

{{-- <div class="theme-loader"> --}}
{{--    <div class="loader-track"> --}}
{{--        <div class="loader-bar"></div> --}}
{{--    </div> --}}
{{-- </div> --}}

<!-- Pre-loader end -->
<!-- style="background: #ffffff!important;" -->
<section class="p-fixed d-flex text-center" >
    
    <!-- Container-fluid starts -->
    <div class="container d-flex align-items-center justify-content-center" style="height: 100vh">
        <div class="row col-sm-10 col-md-6 col-lg-4">
            <div class="col-sm-12">
                <!-- Authentication card start -->
                <div class="card-block mr-auto ml-auto" >
                    <form class="md-float-material" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div style="background-color: #026aadc2; border-radius: 20px; margin: 30px 0 0 0; padding: 10px; box-shadow: 0 2px 15px -2px #000;">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- <h3 class="text-left txt-primary">Login</h3> -->
                                    <img src="{{ asset('images/bbts_logo.png') }}" alt="RanksFC" class="loginLogo">

                                </div>
                            </div>
                            <!-- <hr/> -->
                            @error('email')
    <span class="text-danger text-left" role="alert"> <strong>{{ $message }}</strong></span>
@enderror
                            <div class="input-group mb-1">
                                <input type="email" name="email" class="form-control round @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter your email here.." required autocomplete="email" autofocus style="border-radius: 15px; padding: 6px 12px;">
                            </div>
                            <div class="input-group mt-2">
                                <input name="password" type="password" class="form-control round @error('password') is-invalid @enderror" placeholder="Password" required style="border-radius: 15px; border-top-right-radius: 15px; border-bottom-right-radius: 15px; padding: 6px 12px;">
                                @error('password')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
@enderror
                                <span class="md-line"> </span>
                            </div>

                            {{-- <div class="input-group"> --}}
                                {{-- <input type="email" name="email" class="form-control round @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="abc@gmail.com" required autocomplete="email" autofocus > --}}
                                {{-- @error('email') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong></span>@enderror --}}
                                {{-- <span class="md-line"></span> --}}
                            {{-- </div> --}}
                            {{-- <div class="input-group"> --}}
                                {{-- <input name="password" type="password" class="form-control round @error('password') is-invalid @enderror" placeholder="Password" required> --}}
                                {{-- @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror --}}
                                {{-- <span class="md-line"> </span> --}}
                            {{-- </div> --}}

                            <!-- <hr/> -->
                            {{-- <div class="row m-t-25 text-left">
                                <div class="col-12">
                                    <div class="checkbox-fade fade-in-primary d-">
                                        <label>
                                            <input type="checkbox" value="">
                                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                            <span class="text-inverse">Remember me</span>
                                        </label>
                                    </div>
                                    <div class="forgot-phone text-right f-right">
                                        <a href="auth-reset-password.html" class="text-right f-w-600 text-inverse"> Forgot Password?</a>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-color btn-md btn-block waves-effect text-center" style="
                                        background: #181c1a;
                                        color: #fff;
                                        border-radius: 20px;
                                        line-height: 15px;
                                        width: 101px;
                                        margin: 0 auto;
                                    ">Login</button>
                                </div>
                            </div>

                        </div>
                        <div class="text-center" >
{{--                            <h2 style="color: white">Magnetism Tech Ltd.</h2> --}}
                            <p style="margin-top:165%" id="fixed_position">
                                Atlas Rangs Plaza(Level-9 & 10), 7 SK Mujib Road Agrabad C/A, Chattogram.
                            </p>
                        </div>
                    </form>
                    <!-- end of form -->
                </div>
                <!-- Authentication card end -->
            </div>
            <!-- end of col-sm-12 -->
        </div>
        <!-- end of row -->
    </div>
    <!-- end of container-fluid -->
</section>

<script src="{!! asset(url('js/jquery.min.js')) !!}"></script>
<script src="{!! asset(url('js/jquery-ui.min.js')) !!}"></script>
<script src="{!! asset(url('js/popper.min.js')) !!}"></script>
<script src="{!! asset(url('js/bootstrap.min.js')) !!}"></script>
<script src="{!! asset(url('js/common-pages.js')) !!}"></script>
</body>

</html>
