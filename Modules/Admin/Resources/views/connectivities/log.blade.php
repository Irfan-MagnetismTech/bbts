@extends('layouts.backend-layout')
@section('title', 'link Log')

@section('breadcrumb-title')
   Log
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('connectivity.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('content')
<div class="table-responsive">
    <table id="dataTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>BBTS Link Id</th>
                <th>From</th>
                <th>To</th>
                <th>Existing Capacity</th> 
                <th>New Capacity</th> 
                <th>Terrif Per Month</th> 
                <th>Total</th> 
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Date</th>
                <th>BBTS Link Id</th>
                <th>From</th>
                <th>To</th>
                <th>Existing Capacity</th> 
                <th>New Capacity</th> 
                <th>Terrif Per Month</th> 
                <th>Total</th> 
            </tr>
        </tfoot>
        <tbody>
        @foreach(@$datas as $key => $data)
            <tr>
                <td class="text-center">{{date('d-m-Y', strtotime($data->created_at))}}</td>
                <td class="text-center">{{$data->bbts_link_id}}</td>
                <td class="text-center">{{$data->from_location}}</td>
                <td class="text-center">{{$data->to_location}}</td>
                <td class="text-center">{{$data->existing_capacity}}</td>
                <td class="text-center">{{$data->new_capacity}}</td>
                <td class="text-center">{{$data->terrif_per_month}}</td>
                <td class="text-center">{{$data->total}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
