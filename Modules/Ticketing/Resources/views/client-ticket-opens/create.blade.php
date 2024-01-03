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
    {{-- <link rel="icon" href="../files/assets/images/favicon.ico" type="image/x-icon"> --}}
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{!! asset(url('css/bootstrap.min.css')) !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset(url('css/style.css')) !!}">
    <style>
        
        body{
            background: #afe2e1!important;
            /* background-image: url("{{ asset('/images/back_image.png') }}"); */
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
    <div class="container d-flex align-items-center justify-content-center" style="height: 80vh">
        <div class="row col-sm-10 col-md-8 col-lg-6">
            <div class="col-md-12">
                <img src="{{ asset('images/bbts_logo.png') }}" alt="BBTS" class="loginLogo">
            </div>
            
            <div class="col-sm-12">
                @if ($message = Session::get('message'))
                    <div class="alert alert-success icons-alert mb-2 p-2">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="">X</i>
                        </button>
                        <p> {{ $message }} </p>
                    </div>
                @endif


                @if ($message = Session::get('error'))
<div class="alert alert-danger icons-alert mb-2 p-2">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="">X</i>
                        </button>
                        <p> {{ $message }} </p>
                    </div>
@endif
                <!-- Authentication card start -->
                <div class="card-block mr-auto ml-auto" >
                    <form class="md-float-material" method="POST" action="{{ route('client-ticket-opens.store') }}">
                        @csrf
                        <div style="background-color: #026aadc2; border-radius: 20px; margin: 30px 0 0 0; padding: 10px; box-shadow: 0 2px 15px -2px #000;">
                            <div class="row">
                                <div class="col-md-12">
                                     <h3 class="text-center" style="color: white">Complain</h3>
                                    {{-- <img src="{{ asset('images/bbts_logo.png') }}" alt="RanksFC" class="loginLogo"> --}}

                                </div>
                            </div>
                            <!-- <hr/> -->
                            @error('client_no')
    <span class="text-danger text-left" role="alert"> <strong>{{ $message }}</strong></span>
@enderror
                            <div class="input-group mb-2">
                                <input type="text" name="client_no" id="client_no" class="form-control round @error('client_no') is-invalid @enderror" value="{{ old('client_no') }}" placeholder="Enter your ID " required autocomplete="client_no" autofocus style="border-radius: 15px; padding: 6px 12px;">
                            </div>
                            <p class="d-none text-danger" id="clientNoError"></p>
                            <button type="button" class="btn btn-primary btn-sm" id="searchClient" style="border-radius: 20px; margin: 0 auto; display: block;">Find your connectivities</button>
                            <div class="input-group mt-2">
                                <select class="form-control d-none round select2" id="fr_no" name="fr_no" required style="border-radius: 15px; border-top-right-radius: 15px; border-bottom-right-radius: 15px; padding: 6px 12px;">
                                    <option value="" selected>Select Connectivity Point</option>
                                </select>
                            
                            </div>
                            {{-- <div class="input-group mt-2">
                                <select class="form-control round select2" id="support_complain_type_id" name="support_complain_type_id" required style="border-radius: 15px; border-top-right-radius: 15px; border-bottom-right-radius: 15px; padding: 6px 12px;">
                                    <option value="" selected>Select Complain Type</option>
                                    @foreach ($complainTypes as $complainType)
<option value="{{ $complainType->id }}"
                                            {{ old('support_complain_type_id', !empty($supportTicket) ? $supportTicket->support_complain_type_id : null) == $complainType->id ? 'selected' : '' }}>
                                            {{ $complainType->name }}
                                        </option>
@endforeach
                                </select>
                            </div> --}}
                            
                            <div class="input-group mt-2">
                                <input name="description" type="text" id="description" class="form-control d-none round @error('description') is-invalid @enderror" placeholder="Write your complain here...." required style="border-radius: 15px; border-top-right-radius: 15px; border-bottom-right-radius: 15px; padding: 6px 12px;">
                            </div>

                            <div id="submitButton" class="d-none">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-color btn-md btn-block waves-effect text-center" style="
                                        background: #181c1a;
                                        color: #fff;
                                        border-radius: 20px;
                                        line-height: 15px;
                                        width: 101px;
                                        margin: 0 auto;
                                    ">Submit</button>
                                </div>
                            </div>

                        </div>
                        <div class="text-center" >
{{--                            <h2 style="color: white">Magnetism Tech Ltd.</h2> --}}
                            <p style="margin-top:165%; " id="fixed_position">
                                {{ config('businessinfo.companyAddress') }} <br/>
                                {{-- {{config('businessinfo.developer')}}  --}}
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
<script>
    $('#searchClient').on('click', function() {
        var value = $('#client_no').val();
        $('#searchClient').html('Searching...');
        console.log(value);
        let html = '<option value="" selected>Select Connectivity Point</option>'
        if ((value !== '')) {
            console.log(value);
            $.ajax({
                url: "{{ route('client-ticket-opens-client-info') }}",
                type: "GET",
                data: {
                    "client_no": value
                },
                success: function(response) {
                    console.log(response);
                    console.log(response.status);
                    if (response) {
                        $('#clientNoError').toggleClass('d-none');
                        $('#searchClient').html('Find your connectivities');
                        $.each(response, function(key, value) {
                            console.log(value);
                            html += '<option value="' + value.fr_no + '">' + value
                                .connectivity_point + '</option>'
                        });
                        $("#fr_no").removeClass('d-none');
                        $('#description').removeClass('d-none');
                        $('#submitButton').removeClass('d-none');
                        $('#fr_no').html(html);
                    } else {
                        $('#clientNoError').toggleClass('d-none');
                        $('#clientNoError').text('Client No. not found');
                        $('#searchClient').html('Find your connectivities');
                    }
                },
                error: function(response) {
                    $('#clientNoError').toggleClass('d-none');
                    $('#clientNoError').text('Client No. not found');
                    $('#searchClient').html('Find your connectivities');
                }
            });

        } else {
            $('#clientNoError').toggleClass('d-none');
        }
    });
</script>
</body>

</html>
