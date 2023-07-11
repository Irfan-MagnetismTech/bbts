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
                                    <a href="{{ route('sales.edit', $sale->id) }}" data-toggle="tooltip" title="Edit"
                                        class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>

                                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                                        data-toggle="tooltip" title="Delete" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                    <a href="{{ route('pnl-summary', $sale->mq_no) }}" data-toggle="tooltip"
                                        title="Add Survey" class="btn btn-outline-success">PNL</a>
                                    <a href="{{ route('client-offer', $sale->mq_no) }}" data-toggle="tooltip"
                                        title="Add Survey" class="btn btn-outline-success">Client Offer</a>
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
    </script>
@endsection
