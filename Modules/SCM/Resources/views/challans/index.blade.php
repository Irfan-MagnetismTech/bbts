@extends('layouts.backend-layout')
@section('title', 'Challans')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Challan
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('challans.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($challans) }}
    <x-warning-paragraph name="Challan" />
@endsection

@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Challan No</th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>From Branch</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Challan No</th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>From Branch</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($challans as $key => $challan)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-center">{{ $challan->challan_no }}</td>
                        <td class="text-center">{{ ucfirst($challan->type) }}</td>
                        <td class="text-center">{{ ucfirst($challan->pop->name ?? '') }}
                            {{ ucfirst($challan->client->client_name ?? '') }}
                            {{ ucfirst(!empty($challan->feasibilityRequirementDetail) ? '(' . $challan->feasibilityRequirementDetail->connectivity_point . ')' : '') }}
                        </td>
                        <td class="text-center">{{ ucfirst($challan?->branch?->name ?? '') }}</td>
                        <td class="text-center">{{ $challan->date }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route("challan-gate-pass", $challan->id) }}" data-toggle="tooltip" title="GP" class="btn btn-outline-primary"><i class="fas fa-file-pdf"></i></a>
                                    <a href="{{ url("scm/challans/$challan->id") }}" data-toggle="tooltip" title="Details"
                                        class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>

                                    <a href="{{ route('challans.edit', $challan->id) }}" data-toggle="tooltip"
                                        title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>


                                    @if (!$challan->mur)
                                        <form action="{{ url("scm/challans/$challan->id") }}" method="POST"
                                            data-toggle="tooltip" title="Delete" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                        <a href="{{ route('material-utilizations.create', ['challan_id' => $challan->id]) }}"
                                            data-toggle="tooltip" title="Create MUR"
                                            class="btn btn-outline-secondary">Create MUR</a>
                                    @else
                                        <a href="{{ route('material-utilizations.edit', $challan->mur->id) }}"
                                            data-toggle="tooltip" title="Edit MUR" class="btn btn-outline-warning">Edit
                                            MUR</a>
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
    <script></script>
@endsection
