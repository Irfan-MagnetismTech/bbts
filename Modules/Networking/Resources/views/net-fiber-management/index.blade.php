@extends('layouts.backend-layout')
@section('title', 'Materials')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
    <style>
        .hide_material {
            display: none;
        }
    </style>
@endsection

@section('breadcrumb-title')
    List of Materials
@endsection


@section('breadcrumb-button')
    <a href="{{ url('nestedmaterials/create') }}" class="btn btn-out-dashed btn-sm btn-success" data-toggle="tooltip"
        title="Add New"><i class="fa fa-plus"></i></a>
    <a href="{{ url('nestedmaterials') }}" class="btn btn-out-dashed btn-sm btn-secondary" data-toggle="tooltip"
        title="Refresh"><i class="fa fa-sync"></i></a>
@endsection

@section('sub-title')
    {{-- Total: {{ $materials->count() }} --}}
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form method="get" action="{{ url('nestedmaterials') }}" class="custom-form">
                <!-- <input type="text" id="material_name" name="material_name" class="form-control form-control-sm" value="" placeholder="Search Material Name" autocomplete="off">
                                                                                        {{-- <input type="hidden" id="project_id" name="project_id" class="form-control form-control-sm" value=""> --}} -->
                <div class="input-group input-group-sm input-group-primary">
                    {{ Form::text('material_name', request()->material_name ? request()->material_name : null, ['class' => 'form-control', 'id' => 'material_name', 'autocomplete' => 'off', 'required', 'placeholder' => 'Material Name']) }}
                    {{ Form::hidden('material_id', request()->material_id ? request()->material_id : null, ['class' => 'form-control', 'id' => 'material_id', 'autocomplete' => 'off', 'required']) }}
                    <button type="submit" class="input-group-addon">Search</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
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
                @if (request()->material_id)
                    <?php $first_layer_material = $material_details[0];
                    ?>
                    <tr style="background-color: #b7ebb7" class="balanceLineStyle">
                        <td class="text-left" style="padding-left: 15px!important; first_line"> {{ $floop = 1 }}
                        </td>
                        <td class="text-left first_layer" id="{{ $first_layer_material->id }}">
                            {{ $first_layer_material->name }} </td>
                        <td class="text-center"> {{ $first_layer_material->unit->name }}</td>
                        <td class="text-center"> {{ $first_layer_material->account->account_name ?? '' }}</td>

                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("nestedmaterials/$first_layer_material->id/edit") }}"
                                        data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                            class="fas fa-pen"></i></a>
                                    {!! Form::open([
                                        'url' => "nestedmaterials/$first_layer_material->id",
                                        'method' => 'delete',
                                        'class' => 'd-inline',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Delete',
                                    ]) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                    {!! Form::close() !!}
                                </nobr>
                            </div>
                        </td>
                    </tr>
                    @if ($material_details->count() > 1)
                        ;
                        <?php
                        $second_layer_material = $material_details[1];
                        ?>
                        <tr style="background-color: #d0ebe3"
                            class="balanceLineStyle hide_material second_line second_line_{{ $first_layer_material->id }} ">
                            <td class="text-left " style="padding-left: 15px!important;">
                                {{ $sloop = 1.1 }}</td>
                            <td class="text-left second_layer" id="{{ $second_layer_material->id }}"
                                style="padding-left: 30px!important; "> {{ $second_layer_material->name }}</td>
                            <td class="text-center"> {{ $first_layer_material->unit->name }}</td>
                            <td class="text-center"> {{ $second_layer_material->account->account_name ?? '' }}
                            </td>
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        <a href="{{ url("nestedmaterials/$second_layer_material->id/edit") }}"
                                            data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                                class="fas fa-pen"></i></a>
                                        {!! Form::open([
                                            'url' => "nestedmaterials/$second_layer_material->id",
                                            'method' => 'delete',
                                            'class' => 'd-inline',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Delete',
                                        ]) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                        {!! Form::close() !!}
                                    </nobr>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @if ($material_details->count() > 2)
                        ;
                        <?php
                        $third_layer_material = $material_details[2];
                        ?>
                        <tr style="background-color: #c5eed5fb"
                            class="balanceLineStyle hide_material third_line third_line_{{ $second_layer_material->id }} hide_parent_account_{{ $first_layer_material->id }}">
                            <td class="text-left " style="padding-left: 15px!important;">
                                {{ $ssloop = '1.1.1' }}</td>
                            <td class="text-left third_layer" id="{{ $third_layer_material->id }}"
                                style="padding-left: 60px!important; "> {{ $third_layer_material->name }}
                            </td>
                            <td class="text-center"> {{ $third_layer_material->unit->name }}</td>
                            <td class="text-center">
                                {{ $third_layer_material->account->account_name ?? '' }}</td>
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        <a href="{{ url("nestedmaterials/$third_layer_material->id/edit") }}"
                                            data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                                class="fas fa-pen"></i></a>
                                        {!! Form::open([
                                            'url' => "nestedmaterials/$third_layer_material->id",
                                            'method' => 'delete',
                                            'class' => 'd-inline',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Delete',
                                        ]) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                        {!! Form::close() !!}
                                    </nobr>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @if ($material_details->count() > 3)
                        ;
                        <?php
                        $fourth_layer_material = $material_details[3];
                        ?>
                        <tr style="background-color: #dbecdb"
                            class="balanceLineStyle  fourth_line fourth_line_{{ $third_layer_material->id }} hide_parent_account_{{ $first_layer_material->id }}">
                            <td class="text-left " style="padding-left: 15px!important;">
                                {{ $accloop = '1.1.1.1' }}</td>
                            <td class="text-left fourth_layer" id="{{ $fourth_layer_material->id }}"
                                style="padding-left: 100px!important; ">
                                {{ $fourth_layer_material->name }}</td>
                            <td class="text-center"> {{ $fourth_layer_material->unit->name }}</td>
                            <td class="text-center">
                                {{ $fourth_layer_material->account->account_name ?? '' }}</td>
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        <a href="{{ url("nestedmaterials/$fourth_layer_material->id/edit") }}"
                                            data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                                class="fas fa-pen"></i></a>
                                        {!! Form::open([
                                            'url' => "nestedmaterials/$fourth_layer_material->id",
                                            'method' => 'delete',
                                            'class' => 'd-inline',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Delete',
                                        ]) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                        {!! Form::close() !!}
                                    </nobr>
                                </div>
                            </td>
                        </tr>
                    @endif
                @else
                    @foreach ($material_details as $key => $first_layer_material)
                        @if ($first_layer_material->material_status != 'Work-Material')
                            <tr style="background-color: #b7ebb7" class="balanceLineStyle">
                                <td class="text-left" style="padding-left: 15px!important; first_line">
                                    {{ $floop = $loop->iteration }}</td>
                                <td class="text-left first_layer" id="{{ $first_layer_material->id }}">
                                    {{ $first_layer_material->name }}</td>
                                <td class="text-center"> {{ $first_layer_material->unit->name }}</td>
                                <td class="text-center"> {{ $first_layer_material->account->account_name ?? '' }}</td>

                                <td>
                                    <div class="icon-btn">
                                        <nobr>
                                            <a href="{{ url("nestedmaterials/$first_layer_material->id/edit") }}"
                                                data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                                    class="fas fa-pen"></i></a>
                                            {!! Form::open([
                                                'url' => "nestedmaterials/$first_layer_material->id",
                                                'method' => 'delete',
                                                'class' => 'd-inline',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Delete',
                                            ]) !!}
                                            {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                            {!! Form::close() !!}
                                        </nobr>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @foreach ($first_layer_material->children as $akey => $second_layer_material)
                            @if ($second_layer_material->material_status != 'Work-Material')
                                <tr style="background-color: #d0ebe3"
                                    class="balanceLineStyle hide_material second_line second_line_{{ $first_layer_material->id }} ">
                                    <td class="text-left " style="padding-left: 15px!important;">
                                        {{ $sloop = $floop . '.' . $loop->iteration }}</td>
                                    <td class="text-left second_layer" id="{{ $second_layer_material->id }}"
                                        style="padding-left: 30px!important; "> {{ $second_layer_material->name }}</td>
                                    <td class="text-center"> {{ $first_layer_material->unit->name }}</td>
                                    <td class="text-center"> {{ $second_layer_material->account->account_name ?? '' }}
                                    </td>
                                    <td>
                                        <div class="icon-btn">
                                            <nobr>
                                                <a href="{{ url("nestedmaterials/$second_layer_material->id/edit") }}"
                                                    data-toggle="tooltip" title="Edit"
                                                    class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                                {!! Form::open([
                                                    'url' => "nestedmaterials/$second_layer_material->id",
                                                    'method' => 'delete',
                                                    'class' => 'd-inline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => 'Delete',
                                                ]) !!}
                                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                                {!! Form::close() !!}
                                            </nobr>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @foreach ($second_layer_material->children as $key => $third_layer_material)
                                @if ($third_layer_material->material_status != 'Work-Material')
                                    <tr style="background-color: #c5eed5fb"
                                        class="balanceLineStyle hide_material third_line third_line_{{ $second_layer_material->id }} hide_parent_account_{{ $first_layer_material->id }}">
                                        <td class="text-left " style="padding-left: 15px!important;">
                                            {{ $ssloop = $sloop . '.' . $loop->iteration }}</td>
                                        <td class="text-left third_layer" id="{{ $third_layer_material->id }}"
                                            style="padding-left: 60px!important; "> {{ $third_layer_material->name }}
                                        </td>
                                        <td class="text-center"> {{ $third_layer_material->unit->name }}</td>
                                        <td class="text-center">
                                            {{ $third_layer_material->account->account_name ?? '' }}</td>
                                        <td>
                                            <div class="icon-btn">
                                                <nobr>
                                                    <a href="{{ url("nestedmaterials/$third_layer_material->id/edit") }}"
                                                        data-toggle="tooltip" title="Edit"
                                                        class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                                    {!! Form::open([
                                                        'url' => "nestedmaterials/$third_layer_material->id",
                                                        'method' => 'delete',
                                                        'class' => 'd-inline',
                                                        'data-toggle' => 'tooltip',
                                                        'title' => 'Delete',
                                                    ]) !!}
                                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                                    {!! Form::close() !!}
                                                </nobr>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @foreach ($third_layer_material->children as $key => $fourth_layer_material)
                                    <tr style="background-color: #dbecdb"
                                        class="balanceLineStyle hide_material fourth_line fourth_line_{{ $third_layer_material->id }} hide_parent_account_{{ $first_layer_material->id }}">
                                        <td class="text-left " style="padding-left: 15px!important;">
                                            {{ $accloop = $ssloop . '.' . $loop->iteration }}</td>
                                        <td class="text-left fourth_layer" id="{{ $fourth_layer_material->id }}"
                                            style="padding-left: 100px!important; ">
                                            {{ $fourth_layer_material->name }}</td>
                                        <td class="text-center"> {{ $fourth_layer_material->unit->name }}</td>
                                        <td class="text-center">
                                            {{ $fourth_layer_material->account->account_name ?? '' }}</td>
                                        <td>
                                            <div class="icon-btn">
                                                <nobr>
                                                    <a href="{{ url("nestedmaterials/$fourth_layer_material->id/edit") }}"
                                                        data-toggle="tooltip" title="Edit"
                                                        class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                                    {!! Form::open([
                                                        'url' => "nestedmaterials/$fourth_layer_material->id",
                                                        'method' => 'delete',
                                                        'class' => 'd-inline',
                                                        'data-toggle' => 'tooltip',
                                                        'title' => 'Delete',
                                                    ]) !!}
                                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                                    {!! Form::close() !!}
                                                </nobr>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach



                        {{-- @php
                    $second_layer_materials = $first_layer_material->descendants()->where('parent_id',$first_layer_material->id)->get();
                @endphp
                @foreach ($second_layer_materials as $akey => $second_layer_material)
                    @if ($second_layer_material->material_status != 'Work-Material')
                    <tr style="background-color: #d0ebe3" class="balanceLineStyle hide_material second_line second_line_{{$first_layer_material->id}} ">
                        <td class="text-left " style="padding-left: 15px!important;">{{$sloop = $floop .'.'.  $loop->iteration}}</td>
                        <td class="text-left second_layer" id="{{$second_layer_material->id}}" style="padding-left: 30px!important; " > {{ $second_layer_material->name }}</td>
                        <td class="text-center"> {{ $first_layer_material->unit->name }}</td>
                        <td class="text-center"> {{ $second_layer_material->account->account_name ?? '' }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("nestedmaterials/$second_layer_material->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open(array('url' => "nestedmaterials/$second_layer_material->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!}
                                </nobr>
                            </div>
                        </td>
                    </tr>
                    @endif --}}
                        {{-- @php
                        $third_layer_materials = $second_layer_material->descendants()->where('parent_id',$second_layer_material->id)->get();
                        if($loop->last){
                            dd($second_layer_material->id);
                        }
                    @endphp
                    @foreach ($third_layer_materials as $akey => $third_layer_material)
                        @if ($third_layer_material->material_status != 'Work-Material')
                        <tr style="background-color: #c5eed5fb" class="balanceLineStyle hide_material third_line third_line_{{$second_layer_material->id}} hide_parent_account_{{$first_layer_material->id}}">
                            <td class="text-left " style="padding-left: 15px!important;">{{ $ssloop = $sloop .'.'.$loop->iteration }}</td>
                            <td class="text-left third_layer" id="{{$third_layer_material->id}}" style="padding-left: 60px!important; " > {{ $third_layer_material->name }}</td>
                            <td class="text-center"> {{ $third_layer_material->unit->name }}</td>
                            <td class="text-center"> {{ $third_layer_material->account->account_name ?? '' }}</td>
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        <a href="{{ url("nestedmaterials/$third_layer_material->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        {!! Form::open(array('url' => "nestedmaterials/$third_layer_material->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                        {!! Form::close() !!}
                                    </nobr>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @php
                            $fourth_layer_materials = $third_layer_material->descendants()->where('parent_id',$third_layer_material->id)->get();
                        @endphp
                        @foreach ($fourth_layer_materials as $key => $fourth_layer_material)
                            @if ($fourth_layer_material->material_status != 'Work-Material')
                            <tr style="background-color: #dbecdb" class="balanceLineStyle hide_material fourth_line fourth_line_{{$third_layer_material->id}} hide_parent_account_{{$first_layer_material->id}}">
                                <td class="text-left " style="padding-left: 15px!important;">{{ $accloop = $ssloop .'.'.$loop->iteration }}</td>
                                <td class="text-left fourth_layer" id="{{$fourth_layer_material->id}}" style="padding-left: 100px!important; " > {{ $fourth_layer_material->name }}</td>
                                <td class="text-center"> {{ $fourth_layer_material->unit->name }}</td>
                                <td class="text-center"> {{ $fourth_layer_material->account->account_name ?? '' }}</td>
                                <td>
                                    <div class="icon-btn">
                                        <nobr>
                                            <a href="{{ url("nestedmaterials/$fourth_layer_material->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                            {!! Form::open(array('url' => "nestedmaterials/$fourth_layer_material->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                            {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                            {!! Form::close() !!}
                                        </nobr>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    @endforeach --}}
                        {{-- @endforeach --}}
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        @if (request()->material_id)
            $(document).ready(function() {
                $('.first_layer').each(function() {
                    let header = $(this).attr('id');
                    $(".second_line_" + header).toggle();
                });
                @if ($material_depth != null || $material_depth->depth != 0)
                    @if ($material_depth->depth == 2)
                        $("#" + {{ request()->material_id }});
                        var classes = $("#" + {{ request()->material_id }}).parent().attr('class').split(' ');
                        var beforeLastClass = classes[classes.length - 2];
                        $("." + beforeLastClass).toggle();
                    @elseif ($material_depth->depth == 3)
                        $("#" + {{ request()->material_id }});
                        var classes = $("#" + {{ request()->material_id }}).parent().attr('class').split(' ');
                        var beforeLastClass = classes[classes.length - 2];
                        $('.' + classes[classes.length - 2]).prevAll('.second_line').nextAll('.third_line').each(
                            function() {
                                $(this).toggle();
                            });
                        var lastClassSplit = classes[classes.length - 1].split(' ');
                    @endif
                    $("#" + {{ request()->material_id }}).parent().addClass('bg-danger');
                @endif
            });
        @endif
        $(function() {
            $(document).on('click', '.first_layer', function() {
                let header = $(this).attr('id');
                $(".second_line_" + header).toggle();
                $(".hide_parent_account_" + header).hide();
            });
            $(document).on('click', '.second_layer', function() {
                let currentLine = $(this).attr('id');
                $(".third_line_" + currentLine).toggle();
                $(".hide_parent_account_" + currentLine).hide();
            });
            $(document).on('click', '.third_layer', function() {
                let parentAccount = $(this).attr('id');
                $(".fourth_line_" + parentAccount).toggle();
                $(".hide_parent_account_" + parentAccount).hide();
            });
        });

        var CSRF_TOKEN = "{{ csrf_token() }}";

        $("#material_name").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('scj.materialAutoSuggest') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $('#mpr_no').val(ui.item.value);
                $('#mpr_id').val(ui.item.mpr_id);
                $('#project_id').val(ui.item.project_id);
                $('#project_name').val(ui.item.project_name);
                $('#cost_center_id').val(ui.item.cost_center_id);
                $('#po_id').val(ui.item.po_id);
                $(this).val(ui.item.label);
                $('#material_id').val(ui.item.material_id);
                return false;
            }
        });
    </script>
@endsection
