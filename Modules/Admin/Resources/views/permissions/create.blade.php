@extends('layouts.backend-layout')
@section('title', 'Permission')

@section('breadcrumb-title')
    @if($formType == 'edit')  Edit  @else  Create  @endif
    Permission
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">

    <style>
        .input-group-addon{
           // min-width: 110px;
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('permissions.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection
@section('content')

        @if($formType == 'edit')
            {!! Form::open(array('url' => "admin/permissions/$permission->id",'method' => 'PUT')) !!}
        @else
            {!! Form::open(array('url' => "admin/permissions",'method' => 'POST')) !!}
        @endif
        <div class="row">
            <div class="col-md-5 pr-md-1 my-1 my-md-0">
                {{Form::text('name', old('name') ? old('name') : (!empty($permission->name) ? $permission->name : null),['class' => 'form-control','id' => 'name', 'placeholder' => 'Permission Name'] )}}
            </div>
            <div class="col-md-2 pl-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block">Submit</button>
                </div>
            </div>
        </div><!-- end form row -->
        {!! Form::close() !!}
        <hr class="my-2 bg-success">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#SL</th>
                        <th>Permission Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#SL</th>
                        <th>Permission Name</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                @foreach($permissions as $key => $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td class="text-left">{{$data->name}}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("admin/permissions/$data->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open(array('url' => "admin/permissions/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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

