@extends('layouts.backend-layout')
@section('title', 'Gate Pass Show')

@section('breadcrumb-title')
    Gate Pass Show
@endsection

@section('breadcrumb-button')
<a href="{{ route('gate-passes.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
    class="fas fa-database"></i></a>
@endsection

@section('content-grid', null)

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                        <tr style="background-color: #0C4A77;color: white">
                            <td> <strong>Gate Pass No.</strong> </td>
                            <td> <strong>{{ $gate_pass->gate_pass_no }}</strong></td>
                        </tr>
                        <tr>
                            <td> <strong>Date</strong> </td>
                            <td> {{ $gate_pass->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Type</strong> </td>
                            <td> {{ ucfirst($gate_pass->type ?? '') }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Carrier</strong> </td>
                            <td> {{ ucfirst($gate_pass->carrier ?? '') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Challan / MIR</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gate_pass->lines as $key => $value)
                    <tr>
                        <td> {{ $value->challan?->challan_no ?? $value->mir?->mir_no }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
