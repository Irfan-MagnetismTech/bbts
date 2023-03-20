@extends('layouts.backend-layout')
@section('title', "Bulk Notification")

@section('style')
    
@endsection

@section('breadcrumb-title')
    Bulk Notification
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="col-md-10 mx-auto">
        <div class="row">
            <div class="col-md-12">
                <form
                action="{{ route('send-notification') }}"
                method="post" class="custom-form">
                
                @csrf
                
                    <div class="row">
                        <div class="form-group col-10 mx-auto">
                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="offset-md-4 col-md-4 mt-2">
                            <div class="input-group input-group-sm ">
                                <button class="btn btn-success btn-round btn-block py-2">Send Email</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
        
</script>
@endsection
