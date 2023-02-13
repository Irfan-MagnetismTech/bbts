@extends('layouts.backend-layout')
@section('title', 'Support Tickets')

@section('style')
    
@endsection

@section('breadcrumb-title')
   Create New Support Team
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('support-teams.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="col-md-10 mx-auto">
        <div class="row">
            <div class="col-md-12">
                <form
                action="{{ ($formType == 'edit') ? route('support-teams.update', $requisition->id) : route('support-teams.store') }}"
                method="post" class="custom-form">
                @if ($formType == 'edit')
                    @method('PUT')
                @endif
                @csrf
                
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="mrs_no">Department Name:</label>
                            <input type="text" class="form-control mrs_no" id="mrs_no" name="mrs_no" aria-describedby="mrs_no"
                                value="{{ old('mrs_no') ?? ($team->mrs_no ?? '') }}" placeholder="Department Name">
                        </div>
                        <div class="form-group col-6">
                            <label for="mrs_no">Department Head:</label>
                            <input type="text" class="form-control mrs_no" id="mrs_no" name="mrs_no" aria-describedby="mrs_no"
                                value="{{ old('mrs_no') ?? ($team->mrs_no ?? '') }}" placeholder="Department Name">
                        </div>
                    </div>

                    Team Members
                    <div class="dt-responsive table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Type</th>
                                <th>Action</th>
                                <th><i class="btn btn-primary btn-sm fa fa-plus add-new"></i></th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
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
