@extends('layouts.backend-layout')
@section('title', 'User')

@section('breadcrumb-title')
   List of  Role Info
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('roles.create')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection

@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#SL</th>
                <th>Name</th>
                <th>Permissions</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($roles as $key => $role)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left">{{$role->name}}</td>
                    <td class="text-left breakWords">
                        @foreach($role->permissions as $permission)
                            <span class="label label-success tableBadge">{{$permission->name}}</span>
                        @endforeach
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ route('roles.edit', $role->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                <form action="{{ url("admin/roles/$role->id") }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>#SL</th>
                <th>Name</th>
                <th>Permissions</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
    </div>

@endsection

@section('script')

@endsection
