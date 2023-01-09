@extends('layouts.backend-layout')
@section('title', 'Employees')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Employees
@endsection


@section('breadcrumb-button')
    <a href="{{ url('employees/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($employees) }}
    @endsection


    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th> Name</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Joining Date</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($employees as $key => $employee)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td> {{ $employee->name}}</td>
                    <td> {{ $employee->department->name ?? ''}}</td>
                    <td> {{ $employee->designation->name ?? ''}}</td>
                    <td> {{ !empty($employee->joining_date) ? date('d-m-Y',strtotime($employee->joining_date)): null}}</td>
                    <td> {{ $employee->contact}}</td>
                    <td> {{ $employee->email}}</td>

                    <td><img class="" style="width: 80px;height: 60px"
                             src='{{asset("images/Employees/$employee->picture")}}' alt=""></td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url("employees/$employee->id") }}" data-toggle="tooltip" title="View" class="btn btn-outline-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ url("employees/$employee->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "employees/$employee->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                {!! Form::close() !!}
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
