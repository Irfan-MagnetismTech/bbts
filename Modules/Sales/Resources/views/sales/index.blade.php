@extends('layouts.backend-layout')
@section('title', 'Sales List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Sales List
@endsection

@section('style')
@endsection
@section('breadcrumb-button')
    <a href="{{ route('sales.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($sales) }}
@endsection


@section('content')
<form action="" method="get" class="my-4">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="date_from" class="font-weight-bold">From Date:</label>
                <input type="text" class="form-control date" id="from_date" name="from_date"
                    aria-describedby="from_date" value="{{ old('from_date') ?? (request()?->from_date ?? null) }}"
                    readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="date_to" class="font-weight-bold">To Date:</label>
                <input type="text" class="form-control date" id="to_date" name="to_date" aria-describedby="date_to"
                    value="{{ old('to_date') ?? (request()?->to_date ?? null) }}" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group my-4 row">
                <div class="col-md-6">
                    <input type="button" onclick="resetForm()" value="Reset"
                        class="btn btn-outline-warning btn-sm col-12">
                </div>
                <div class="col-md-6">
                    <input type="submit" value="Search" class="btn btn-outline-primary btn-sm col-12">
                </div>
            </div>
        </div>
    </div>
</form>
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Account Holder</th>
                    <th>Contract Duration</th>
                    <th>Effective Date</th>
                    <th>Work Order No</th>
                    <th>MQ No</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->client->client_name ?? '' }}</td>
                        <td>{{ $sale->account_holder }}</td>
                        <td>{{ $sale->contract_duration }}</td>
                        <td>{{ $sale->effective_date }}</td>
                        <td>{{ $sale->wo_no ?? '' }}</td>
                        <td>{{ $sale->mq_no ?? '' }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    @can('sales-edit')
                                        <a href="{{ route('sales.edit', $sale->id) }}" data-toggle="tooltip" title="Edit"
                                            class="btn btn-outline-warning"><i class="fas fa-pen"></i>
                                        </a>
                                    @endcan
                                    @can('sales-delete')
                                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                                            data-toggle="tooltip" title="Delete" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    @endcan
                                    <a href="{{ route('pnl-summary', $sale->mq_no) }}" data-toggle="tooltip" title="PNL"
                                        class="btn btn-outline-success">PNL</a>
                                </nobr>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Client Name</th>
                    <th>Account Holder</th>
                    <th>Contract Duration</th>
                    <th>Effective Date</th>
                    <th>Work Order No</th>
                    <th>MQ No</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;
        $(document).ready(function() {
            $('.date').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
            });

            select2Ajax("{{ route('search-support-ticket') }}", '#ticket_no')
        })

        function resetForm() {
            $('#from_date').val('');
            $('#to_date').val('');
        }
    </script>
@endsection
