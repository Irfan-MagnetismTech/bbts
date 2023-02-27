@extends('layouts.backend-layout')
@section('title', 'Complain Types')

@section('style')
    
@endsection

@section('breadcrumb-title')
   List of Complain Types
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('support-complain-types.create')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total Complain Types: {{ count($complainTypes) }}
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
                @forelse ($complainTypes as $complainType)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td class="text-left">{{ $complainType->name }}</td>
                        <td>
                            <x:action-button :show="null" :edit="route('support-complain-types.edit', ['support_complain_type' => $complainType->id])" :delete="route('support-complain-types.show', ['support_complain_type' => $complainType->id])" />
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
