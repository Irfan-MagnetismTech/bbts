@extends('layouts.backend-layout')
@section('title', 'Password Configur')

@section('breadcrumb-title')
    Change Password
@endsection

@section('project-name')
    {{session()->get('project_name')}}
@endsection

@section('breadcrumb-button')
@endsection

@section('content-grid', 'offset-md-2 col-md-6 offset-lg-2 col-lg-6 my-3')

@section('content')
@section('style')

</style>
@endsection
    <div class="row">
        <div class="col-md-12">
                {!! Form::open(array('url' => "admin/password-change",'method' => 'POST', 'class'=>'custom-form')) !!}
                <div class="row">
                    <div class="col-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <input name="old_password" type="password" class="form-control round @error('old_password') is-invalid @enderror" autocomplete="off" placeholder="Old Password" required style="border-radius: 15px; border-top-right-radius: 15px; border-bottom-right-radius: 15px; padding: 6px 12px;">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <input name="new_password" type="password" class="form-control round @error('new_password') is-invalid @enderror" autocomplete="off" id="new_password" placeholder="New Password" required style="border-radius: 15px; border-top-right-radius: 15px; border-bottom-right-radius: 15px; padding: 6px 12px;">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <input name="confirm_password" type="password" class="form-control round @error('confirm_password') is-invalid @enderror" autocomplete="off" id="confirm_password" placeholder="Confirm Password" required style="border-radius: 15px; border-top-right-radius: 15px; border-bottom-right-radius: 15px; padding: 6px 12px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-md-4 col-md-4 mt-2">
                        <div class="input-group input-group-sm ">
                            <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#confirm_password").on('change', function (){
            let new_password = $("#new_password").val();
            let confirm_password = $("#confirm_password").val();
            if(new_password !== confirm_password){
            alert("New Password and Confirm Password does not match");
            }
        })
    </script>
@endsection
