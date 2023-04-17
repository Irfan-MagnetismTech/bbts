@extends('layouts.backend-layout')
@section('title', 'Tickets Downtime Reports')

@section('style')
    <style>

    </style>
@endsection

@section('breadcrumb-title')
    Downtime Reports
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('downtime-report-index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection
@section('sub-title')
    Total Tickets: {{ !empty($supportTickets) ? $supportTickets->count() : 0 }} <br>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6"></div>
</div>
@endsection

@section('script')

@endsection


