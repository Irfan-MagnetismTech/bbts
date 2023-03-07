@extends('layouts.backend-layout')
@section('title', 'PurchaseOrder Details')

@section('breadcrumb-title')
    Purchase Order Details
@endsection

@section('breadcrumb-button')
    <a href="{{ route('purchase-orders.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    {{-- <span class="text-danger">*</span> Marked are required. --}}
@endsection

@section('content-grid', null)

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                        <tr style="background-color: #0C4A77;color: white">
                            <td> <strong>PO No.</strong> </td>
                            <td> <strong>{{ $purchaseOrder->po_no }}</strong></td>
                        </tr>

                        <tr>
                            <td> <strong>Purchase Date</strong> </td>
                            <td> {{ $purchaseOrder->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Supplier Name</strong> </td>

                            <td>{{ $purchaseOrder->supplier->name }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Indent No</strong> </td>
                            <td> {{ $purchaseOrder->indent->indent_no }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Delivery Location</strong> </td>
                            <td> {{ $purchaseOrder->delivery_location }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Submitted By</strong> </td>
                            <td> {{ $purchaseOrder->createdBy->name }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Branch</strong> </td>
                            <td> {{ $purchaseOrder?->branch?->name }}</td>
                        <tr>
                            <td> <strong>Remarks</strong> </td>
                            <td> {{ $purchaseOrder->remarks }}</td>
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
                    <th>Prs No</th>
                    <th>CS No.</th>
                    <th>Quotation No</th>
                    <th>Material Name</th>
                    <th>Material Unit</th>
                    <th>Description</th>
                    <th>Warranty period</th>
                    <th>Installation Cost</th>
                    <th>Transport Cost</th>
                    <th>Vat</th>
                    <th>Tax</th>
                    <th>Required Date </th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseOrder->purchaseOrderLines as $purchaseOrderLine)
                    <tr>
                        <td> {{ $loop->iteration }}</td>
                        <td>{{ $purchaseOrderLine->scmPurchaseRequisition->prs_no ?? '---' }}</td>
                        <td>{{ $purchaseOrderLine->cs->cs_no ?? '---' }}</td>
                        <td>{{ $purchaseOrderLine->quotation_no ?? '---' }}</td>
                        <td>{{ $purchaseOrderLine->material->name ?? '---' }}</td>
                        <td>{{ $purchaseOrderLine->material->unit ?? null }}</td>
                        <td> {{ $purchaseOrderLine->description }}</td>
                        <td> {{ $purchaseOrderLine->warranty_period }}</td>
                        <td> {{ $purchaseOrderLine->installation_cost }}</td>
                        <td> {{ $purchaseOrderLine->transport_cost }}</td>
                        <td> {{ $purchaseOrderLine->vat }}</td>
                        <td> {{ $purchaseOrderLine->tax }}</td>
                        <td> {{ $purchaseOrderLine->required_date }}</td>
                        <td> {{ $purchaseOrderLine->quantity }}</td>
                        <td> {{ $purchaseOrderLine->unit_price }}</td>
                        <td class="text-right"> {{ $purchaseOrderLine->total_amount }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="15" class="text-right"> Total Amount </td>
                    <td class="text-right">{{ $purchaseOrder->purchaseOrderLines->sum('total_amount') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="form-group col-4">
            <label for="terms_and_conditions">Terms and Conditions</label>
            <div class="input-group">
                <ol>
                    @foreach ($purchaseOrder->poTermsAndConditions as $term)
                        <li>{{ $term->particular }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
@endsection
