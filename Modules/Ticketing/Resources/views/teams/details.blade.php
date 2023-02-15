@extends('layouts.backend-layout')
@section('title', 'Support Team')

@section('style')
    
@endsection

@section('breadcrumb-title')
   Support Team Details
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('support-teams.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection
@section('sub-title')
    Total Team Member: {{ count($supportTeam->teamMembers) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">

        <p class="py-2">Team Lead: <strong>{{ $supportTeam?->teamLead?->name }}</strong> ({{ $supportTeam?->teamLead?->employee?->designation?->name }})</p>
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#SL</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Type</th>
            </tr>
            </thead>
            
            <tbody>
                @foreach ($supportTeam->teamMembers as $team)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td class="text-left">{{ $team?->user?->name }}</td>
                        <td class="text-left">{{ $team?->user?->employee?->designation?->name }}</td>
                        <td>
                            {{ $levels[$team->type] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')

@endsection
