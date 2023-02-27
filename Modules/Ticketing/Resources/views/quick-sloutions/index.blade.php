@extends('layouts.backend-layout')
@section('title', 'Support Solutionss')

@section('style')
    
@endsection

@section('breadcrumb-title')
   List of Support Solutions
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('support-solutions.create')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total Support Solutions: {{ count($supportSolutions) }}
@endsection


@section('content')
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#SL</th>
                <th class="text-left">Name</th>
                <th>Action</th>
            </tr>
            </thead>
            
            <tbody>
                @forelse ($supportSolutions as $supportSolution)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td class="text-left">{{ $supportSolution->name }}</td>
                        <td>
                            <x:action-button :show="null" :edit="route('support-solutions.edit', ['support_solution' => $supportSolution->id])" :delete="route('support-solutions.show', ['support_solution' => $supportSolution->id])" />
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">No Data Found!</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th class="text-left">Name</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection

@section('script')

@endsection
