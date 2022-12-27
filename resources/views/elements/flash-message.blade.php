@if ($message = Session::get('message'))
<div class="alert alert-success icons-alert mb-2 p-2">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="icofont icofont-close-line-circled"></i>
    </button>
    <p> {{$message}} </p>
</div>
@endif


@if ($message = Session::get('error'))
    {{-- <div class="alert alert-danger alert-block message">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div> --}}
    <div class="alert alert-danger icons-alert mb-2 p-2">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="icofont icofont-close-line-circled"></i>
        </button>
        <p> {{$message}} </p>
    </div>
@endif

{{--@if ($message = Session::get('warning'))--}}
    {{--<div class="alert alert-warning alert-block message">--}}
        {{--<button type="button" class="close" data-dismiss="alert">×</button>--}}
        {{--<strong>{{ $message }}</strong>--}}
    {{--</div>--}}
{{--@endif--}}


{{--@if ($message = Session::get('info'))--}}
    {{--<div class="alert alert-info alert-block message">--}}
        {{--<button type="button" class="close" data-dismiss="alert">×</button>--}}
        {{--<strong>{{ $message }}</strong>--}}
    {{--</div>--}}
{{--@endif--}}


@if ($errors->any())
    <div class="alert alert-danger icons-alert mb-2 p-2">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="icofont icofont-close-line-circled"></i>
        </button>
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
