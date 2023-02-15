@extends('layouts.backend-layout')
@section('title', 'Support Teams')

@section('style')
    
@endsection

@section('breadcrumb-title')
   List of Support Teams
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('support-teams.create')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total Team: 
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#SL</th>
                <th>Name</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Action</th>
            </tr>
            </thead>
            
            <tbody>
                @foreach ($teams as $team)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $team->teamLead->name }}</td>
                        <td>{{ $team->department->name }}</td>
                        <td>{{ $team->teamLead->employee->designation->name }}</td>
                        <td>
                            <x:action-button :show="route('support-teams.show', ['support_team' => $team->id])" :edit="route('support-teams.edit', ['support_team' => $team->id])" :delete="route('support-teams.show', ['support_team' => $team->id])" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')

@endsection
