@extends('layouts.backend-layout')
@section('title', 'MRR Show')

@section('breadcrumb-title')
    MRR Show
@endsection

@section('breadcrumb-button')
    <a href="{{ route('material-receives.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection


@section('content-grid', null)

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                        <tr style="background-color: #0C4A77;color: white">
                            <td> <strong>MRR No.</strong> </td>
                            <td> <strong>{{ $materialReceive->mrr_no }}</strong></td>
                        </tr>
                        <tr>
                            <td> <strong>Date</strong> </td>
                            <td> {{ $materialReceive->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Challan NO</strong> </td>
                            <td> {{ $materialReceive->challan_no }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Challan Date</strong> </td>

                            <td>{{ $materialReceive->challan_date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Created By</strong> </td>
                            <td> {{ $materialReceive->createdBy->name }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Supplier</strong> </td>
                            <td> {{ $materialReceive->supplier->name }}</td>
                        </tr>
                        <tr>
                            <td> <strong>PO No</strong> </td>
                            <td> {{ $materialReceive->createdBy->name }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Branch</strong> </td>
                            <td> {{ $materialReceive?->branch?->name }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Bill Register No</strong> </td>
                            <td> {{ $materialReceive?->bill_reg_no }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Bill Date</strong> </td>
                            <td> {{ $materialReceive?->bill_date }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <h6 class="text-center">Material Details</h6>
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL.No</th>
                    <th>Material</th>
                    <th>Description</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Warranty Period</th>
                    <th>Serial Code</th>
                    <th>Item Code</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @php($total = 0)
                @foreach ($materialReceive->scmMrrLines as $scmMrrLine)
                    <tr>
                        <td> {{ $loop->iteration }}</td>
                        <td>{{ $scmMrrLine->material->name ?? '---' }}</td>
                        <td>{{ $scmMrrLine->description ?? '---' }}</td>
                        <td>{{ $scmMrrLine->brand->name ?? '---' }}</td>
                        <td>{{ $scmMrrLine->model ?? '---' }}</td>
                        <td>{{ $scmMrrLine->warranty_period ?? null }}</td>
                        <td>
                            @if(count($scmMrrLine->scmMrrSerialCodeLines))
                                @foreach ($scmMrrLine->scmMrrSerialCodeLines as $value)
                                        {{$value->serial_or_drum_code}}
                                        @if (!($loop->last))
                                            ,
                                        @endif
                                @endforeach
                            @endif
                        </td>
                        <td> {{ $scmMrrLine->item_code }}</td>
                        <td> {{ $scmMrrLine->quantity }}</td>
                        {{-- <td> {{ $scmMrrLine->installation_cost }}</td> --}}
                        {{-- <td> {{ $scmMrrLine->transport_cost }}</td> --}}
                        <td> {{ $scmMrrLine->unit_price }}</td>
                        <td class="text-right"> {{ $scmMrrLine->quantity * $scmMrrLine->unit_price }}</td>
                        @php($total += ($scmMrrLine->quantity * $scmMrrLine->unit_price))
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10" class="text-right"> Total Amount </td>
                    <td class="text-right">{{ $total }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
