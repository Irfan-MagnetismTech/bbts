<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Service Feedback Form</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="icon" href="{{ config('businessinfo.favicon') }}" type="image/x-icon">
    <style>
        label {
            font-weight: bold;
            font-size: 11px;
        }
        html, body {
            overflow-x: hidden;
        }
        button {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- Main-body start -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <form action="{{ route('store-client-feedback', ['slug' => $slug]) }}" method="post">
                                    @csrf
                                    <div class="row mt-5">
                                        <div class="col-5 mx-auto text-center">
                                            <h4 class="text-gray">Ticket No: {{ $supportTicket->ticket_no }}</h4>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-5 mx-auto">
                                            <div class="form-check-inline d-flex justify-content-between">
                                                <label class="form-check-label" for="poor">
                                                    <input type="radio" required class="form-check-input radioButton" id="poor" name="feedback" value="Poor">
                                                    <span style="position: relative; top: 3px">
                                                        Poor
                                                    </span>
                                                </label>
                                                <label class="form-check-label" for="fair">
                                                    <input type="radio" required class="form-check-input radioButton" id="fair" name="feedback" value="Fair">
                                                    <span style="position: relative; top: 3px">
                                                        Fair
                                                    </span>
                                                </label>
                                                <label class="form-check-label" for="good">
                                                    <input type="radio" required class="form-check-input radioButton" id="good" name="feedback" value="Good">
                                                    <span style="position: relative; top: 3px">
                                                        Good
                                                    </span>
                                                </label>
                                                <label class="form-check-label" for="very_good">
                                                    <input type="radio" required class="form-check-input radioButton" id="very_good" name="feedback" value="Very Good">
                                                    <span style="position: relative; top: 3px">
                                                        Very Good
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-5 mx-auto">
                                            <label for="comment">
                                                <h5>Comment <small>(optional)</small></h5>
                                            </label>
                                            <textarea name="comment" id="comment" cols="30" rows="5" class="form-control" placeholder="Your Comment"></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" name="otl" value="{{ $slug }}">
                                    <div class="row mt-5 mx-auto">
                                        <div class="col-5 mx-auto text-center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Page-body end -->
                        </div>
                        {{--<div id="styleSelector"> </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>