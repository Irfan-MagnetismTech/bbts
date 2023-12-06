@extends('layouts.backend-layout')
@section('title', 'Warranty Claim Receive')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/component.css') }}">
@endsection

@section('breadcrumb-title')
    List of Warranty Claim Receive
@endsection


@section('breadcrumb-button')
    <a href="{{ route('warranty-claims-receives.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($ScmDatas) }}
    {{-- <x-warning-paragraph name="WCRR" /> --}}
@endsection

@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>WCR No</th>
                    <th>To Branch</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>WCR No</th>
                    <th>To Branch</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($ScmDatas as $key => $ScmData)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-center">{{ $ScmData->wcrr_no }}</td>
                        <td class="text-center">{{ ucfirst($ScmData->branch->name) }}</td>
                        <td class="text-center">{{ $ScmData->date }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('warranty-claims-receives.show', $ScmData->id) }}"
                                        data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i
                                            class="fas fa-eye"></i></a>
                                    @if ($ScmData->receiveable()->doesntExist())
                                        <a href="{{ route('warranty-claims-receives.edit', $ScmData->id) }}"
                                            data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                                class="fas fa-pen"></i></a>

                                        <form action="{{ url("scm/warranty-claims-receives/$ScmData->id") }}"
                                            method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                </nobr>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('script')

@endsection
