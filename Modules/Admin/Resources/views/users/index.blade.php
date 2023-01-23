@extends('layouts.backend-layout')
@section('title', 'User')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
   List of  User Info
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('users.create')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($users) }}
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
            @foreach($users as $key => $user)
                <tr>
                    <td>{{$key  + 1}}</td>
                    <td class="text-left">{{$user->name}}</td>
                    <td class="text-left">{{$user->department->name ??''}}</td>
                    <td class="text-left">{{$user->designation->name ??''}}</td>
                    <td class="text-left">{{$user->email}}</td>
                    <td>
                        @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                                <label class="">{{ $v }}</label>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if($user->employee)
                            <a href="{{route('employees.show', $user->employee->id)}}" target="_blank"> Check Profile </a>
                        @endif
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ route('users.edit', $user->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                <form action="{{ url("users/$user->id") }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
