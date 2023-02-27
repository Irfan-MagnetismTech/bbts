@extends('layouts.backend-layout')
@section('title', 'Complain Sources')

@section('style')
    
@endsection

@section('breadcrumb-title')
   List of Complain Sources
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('complain-sources.create')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total Complain Sources: {{ count($complainSources) }}
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
                @forelse ($complainSources as $complainSource)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td class="text-left">{{ $complainSource->name }}</td>
                        <td>
                            <x:action-button :show="null" :edit="route('complain-sources.edit', ['complain_source' => $complainSource->id])" :delete="route('complain-sources.show', ['complain_source' => $complainSource->id])" />
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
