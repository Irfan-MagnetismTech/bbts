@extends('layouts.backend-layout')
@section('title', 'Pops')
 
@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title', "Pops")

@section('breadcrumb-button')
@endsection

@section('sub-title') 
@endsection
@section('content')
        @if($formType == 'edit')
            {!! Form::open(array('url' => "admin/pops/$pop->id",'method' => 'PUT')) !!}
            <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($pop->id) ? $pop->id : null)}}">

        @else
            {!! Form::open(array('url' => "admin/pops",'method' => 'POST')) !!}
        @endif
        <div class="row">
            <div class="col-md-3 pr-md-1 my-1 my-md-0">
                {{Form::text('name', old('name') ? old('name') : (!empty($pop->name) ? $pop->name : null),['class' => 'form-control form-control-sm','id' => 'name', 'placeholder' => 'Enter pop Name', 'autocomplete'=>"off"] )}}
            </div>

            <div class="col-md-3 pr-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <select class="form-control form-control-sm" id="branch_id" name="branch_id" required>
                        <option value="">Select Branch</option>
                        @foreach (@$branches as $branch)
                            <option value="{{ $branch->id }}"
                                {{ (old('branch_id') ?? ($branch->branch_id ?? '')) == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3 pr-md-1 my-1 my-md-0">
                {{Form::text('address', old('address') ? old('address') : (!empty($pop->address) ? $pop->address : null),['class' => 'form-control form-control-sm','id' => 'address', 'placeholder' => 'Enter pop Address', 'autocomplete'=>"off"] )}}
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
                    <th>SL</th>
                    <th>Pop Name</th>
                    <th>Branch Name</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Pop Name</th>
                    <th>Branch Name</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach(@$pops as $key => $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td class="text-center">{{$data->name}}</td>
                        <td class="text-center">{{$data->branch->name}}</td>
                        <td class="text-center">{{$data->address}}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("admin/pops/$data->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open(array('url' => "admin/pops/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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

