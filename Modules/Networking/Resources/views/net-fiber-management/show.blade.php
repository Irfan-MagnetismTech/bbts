@extends('layouts.backend-layout')
@section('title', 'Material Details')

@section('breadcrumb-title')
    Showing information of {{strtoupper($material->name)}}
@endsection

@section('breadcrumb-button')
    <a href="{{ url('nestedmaterials') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid','offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                    <tr class="bg-info"><td> <strong>Material name</strong> </td> <td> <strong>{{ $material->name}}</strong></td></tr>
                    <tr><td> <strong>Parent Name</strong> </td> <td>  {{ $material->parent->name}}</td></tr>
                    <tr><td> <strong>Unit</strong> </td> <td>  {{ $material->unit->name}}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection

