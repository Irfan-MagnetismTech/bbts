@extends('layouts.backend-layout')
@section('title', 'Materials')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
    <style>
        .material_text{ padding-left:60px;  text-align: left; }
    </style>
@endsection

@section('breadcrumb-title')
    List of Materials
@endsection


@section('breadcrumb-button')
    <a href="{{ url('nestedmaterials/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($materials) }}
    @endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="" class=" table  table-bordered" width="100%">
            <thead>
            <tr>
                <th>SL</th>
                <th>Material Name</th>
                <th>Unit</th>
                <th>Account Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($materials as $key => $material)
                <tr style="background-color: #9fdcd1">
                    <td>{{ $floop = $loop->iteration}}</td>
                    <td class="text-left"> {{ $material->name }}</td>
                    <td> {{ $material->unit->name}}</td>
                    <td> {{ $material->account->account_name ?? ''}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url("nestedmaterials/$material->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                <a href="{{ url("nestedmaterials/$material->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "nestedmaterials/$material->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                {!! Form::close() !!}
                            </nobr>
                        </div>
                    </td>
                </tr>
                @php $firstancestors = $material->descendants()->where('parent_id',$material->id)->get();  @endphp
                @foreach($firstancestors as $akey => $firstancestor)
                    <tr style="background-color: #afccee">
                        <td>{{$sloop = $floop .'.'.  $loop->iteration}}</td>
                        <td class="text-left " style="padding-left: 40px!important;"> {{ $firstancestor->name }}</td>
                        <td> {{ $firstancestor->unit->name}}</td>
                        <td> {{ $firstancestor->account->account_name ?? ''}}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("nestedmaterials/$firstancestor->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    <a href="{{ url("nestedmaterials/$firstancestor->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open(array('url' => "nestedmaterials/$firstancestor->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!}
                                </nobr>
                            </div>
                        </td>
                    </tr>
                    @php $secondancestors = $material->descendants()->where('parent_id',$firstancestor->id)->get();  @endphp
                    @foreach($secondancestors as $skey => $secondancestor)
                        <tr style="background-color: #b3aeec">
                            <td>{{ $ssloop =  $sloop .'.'.$loop->iteration}}</td>
                            <td class="text-left " style="padding-left: 80px!important;"> {{ $secondancestor->name }}</td>
                            <td> {{ $secondancestor->unit->name}}</td>
                            <td> {{ $secondancestor->account->account_name ?? ''}}</td>
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        <a href="{{ url("nestedmaterials/$secondancestor->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                        <a href="{{ url("nestedmaterials/$secondancestor->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        {!! Form::open(array('url' => "nestedmaterials/$secondancestor->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                        {!! Form::close() !!}
                                    </nobr>
                                </div>
                            </td>
                        </tr>
                        @php $thirdancestors = $material->descendants()->where('parent_id',$secondancestor->id)->get();  @endphp
                        @foreach($thirdancestors as $tkey => $thirdancestor)
                            <tr>
                                <td>{{ $ssloop .'.'.$loop->iteration}}</td>
                                <td class="text-left " style="padding-left: 120px!important;"> {{ $thirdancestor->name }}</td>
                                <td> {{ $thirdancestor->unit->name}}</td>
                                <td> {{ $thirdancestor->account->account_name ?? ''}}</td>
                                <td>
                                    <div class="icon-btn">
                                        <nobr>
                                            <a href="{{ url("nestedmaterials/$thirdancestor->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                            <a href="{{ url("nestedmaterials/$thirdancestor->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                            {!! Form::open(array('url' => "nestedmaterials/$thirdancestor->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                            {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                            {!! Form::close() !!}
                                        </nobr>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
            </tbody>
        </table>
        {{ $materials->withQueryString()->links() }}
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
