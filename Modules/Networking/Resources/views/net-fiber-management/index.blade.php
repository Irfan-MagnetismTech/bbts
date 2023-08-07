@extends('layouts.backend-layout')
@section('title', 'Fiber')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
    <style>
    </style>
@endsection

@section('breadcrumb-title')
    List of Fiber
@endsection


@section('breadcrumb-button')
@endsection

@section('sub-title')
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Parent</th>
                    <th>Pop</th>
                    <th>Conectivity Point</th>
                    <th>Cable code</th>
                    <th>Fiber type</th>
                    <th>Core no color</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $key => $value )
                    
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td> {{ $value->parent->coreRefId }}</td>
                    <td> {{ $value->pop_id }}</td>
                    <td> {{ $value->connectivity_point_name }}</td>
                    <td> {{ $value->cable_code }}</td>
                    <td> {{ $value->fiber_type }}</td>
                    <td> {{ $value->core_no_color }}</td>
                    <td>
                     <div class="icon-btn">
                        <nobr>
                                <a href="{{ url("networking/fiber-managements/$value->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "networking/fiber-managements/$value->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
    <script>
            </script>
@endsection
