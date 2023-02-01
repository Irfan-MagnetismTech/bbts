@extends('layouts.backend-layout')
@section('title', 'Support Tickets')

@section('style')
    
@endsection

@section('breadcrumb-title')
   List of  Support Tickets
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('support-tickets.create')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: 
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#SL</th>
                <th>Name</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Email</th>
                <th>User Role</th>
                <th>Profile</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>#SL</th>
                <th>Name</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Email</th>
                <th>User Role</th>
                <th>Profile</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection

@section('script')

@endsection
