<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 20px !important;
            padding: 20px !important;
        }

        table {
            font-size: 10px;
        }

        p {
            margin: 0;
        }

        h1 {
            margin: 0;
        }


        .text-center {
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .justify-between {
            justify-content: space-between;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        table,
        td,
        th {
            padding: 5px;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        #orderinfo-table tr td {
            border: 1px solid #000000;
        }

        #orderinfo-table2 tr td {
            border: 1px solid #000000;
            text-align: left;
        }

        @page {
            header: page-header;
            footer: page-footer;
            margin: 120px 50px 50px 50px;
        }
    </style>
</head>

<body>
    <htmlpageheader name="page-header">
        <div>
            &nbsp;
        </div>
        <div style="width: 100%; text-align: center">
            <img src="{{ asset('images/bbts_logo.png') }}" alt="Logo" class="pdfimg">
            <h5>Ispahani Building (2nd Floor), Agrabad C/A, Chittagong-4100.</h5>
        </div>
    </htmlpageheader>

    <html-separator />

    <div style="width: 100%">
        <div class="row" style="margin-top: 30px">
            <div class="col-lg-12 col-md-12">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered" width="50%">
                        <tbody class="text-left">
                            <tr style="text-align: center">
                                <td> <strong>Challan No.</strong> </td>
                                <td> <strong>{{ $challan->challan_no }}</strong></td>
                            </tr>
                            <tr>
                                <td> <strong>Type</strong> </td>
                                <td> {{ ucfirst($challan->type) }}</td>
                            </tr>
                            <tr>
                                <td> <strong>Date</strong> </td>
                                <td> {{ $challan->date }}</td>
                            </tr>
                            <tr>
                                <td> <strong>Requisition No</strong> </td>
                                <td> {{ $challan->scmRequisition->mrs_no }}</td>
                            </tr>
                            <tr>
                                <td> <strong>Purpose</strong> </td>
                                <td> {{ $challan->purpose }}</td>
                            </tr>
                            <tr>
                                <td> <strong>Client</strong> </td>
                                <td> {{ $challan?->client?->client_name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td> <strong>FR No</strong> </td>
                                <td> {{ $challan->fr_no . ' (' . $challan->feasibilityRequirementDetail->connectivity_point . ')' }}
                                </td>
                            </tr>
                            <tr>
                                <td> <strong>Link No</strong> </td>
                                <td> {{ $challan->link_no }}</td>
                            </tr>
                            <tr>
                                <td> <strong>Branch No</strong> </td>
                                <td> {{ $challan?->branch?->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td> <strong>Equipment Type</strong> </td>
                                <td> {{ $challan->equipment_type }}</td>
                            </tr>
                            <tr>
                                <td> <strong>Pop No</strong> </td>
                                <td> {{ $challan?->pop?->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td> <strong>Challan By</strong> </td>
                                <td> {{ ucfirst($challan->challanBy->name) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="table-responsive" style="margin-top: 30px">
            <table id="example" class="table table-striped table-bordered" width="100%">
                <thead>
                    <tr>
                        <th>Material Name</th>
                        <th>Item Code</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Serial Code</th>
                        <th>Purpose</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($challan->mur))
                        @foreach ($challanLines as $key => $scmChallanLine)
                            <tr>
                                <td> {{ $scmChallanLine['material_name'] }} </td>
                                <td> {{ $scmChallanLine['code'] }} </td>
                                <td> {{ $scmChallanLine['unit'] }} </td>
                                <td> {{ $scmChallanLine['quantity'] }} </td>
                                <td> {{ $scmChallanLine['brand_name'] }} </td>
                                <td> {{ $scmChallanLine['model'] }} </td>
                                <td> {{ $scmChallanLine['serial_code'] }} </td>
                                <td> {{ $scmChallanLine['purpose'] }} </td>
                                <td> {{ $scmChallanLine['remarks'] }} </td>
                            </tr>
                        @endforeach
                    @else
                        @foreach ($challan->scmChallanLines as $key => $scmChallanLine)
                            <tr>
                                <td> {{ $scmChallanLine->material->name }} </td>
                                <td> {{ $scmChallanLine->item_code }} </td>
                                <td> {{ $scmChallanLine->material->unit }} </td>
                                <td> {{ $scmChallanLine->quantity }} </td>
                                <td> {{ $scmChallanLine->brand->name }} </td>
                                <td> {{ $scmChallanLine->model }} </td>
                                <td> {{ $scmChallanLine->serial_code }} </td>
                                <td> {{ $scmChallanLine->purpose }} </td>
                                <td> {{ $scmChallanLine->remarks }} </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <htmlpagefooter name="page-footer">
        <div class=" text-xs justify-between" style="margin-top: 100px">
            <div>
                <div style="width:33%; float:left; margin-left: 5px;">
                    <div>
                        <div class="text-center"> </div>
                        <hr class="w-32 border-gray-700" />
                        <div class="text-center">Received</div>
                    </div>
                </div>
                {{--                <div style="width:33%; float:left; margin-left: 5px;"> --}}
                {{--                    <div> --}}

                {{--                        <hr class="w-32 border-gray-700" /> --}}
                {{--                        <div class="text-center">CMO Approved</div> --}}
                {{--                    </div> --}}
                {{--                </div> --}}
                <div style="width:33%; float:right; margin-right: 5px">
                    <div>
                        <hr class="w-32 border-gray-700" />
                        <div class="text-center">Authorized</div>
                    </div>
                </div>
            </div>
            <div>
                &nbsp;
            </div>
        </div>
    </htmlpagefooter>
</body>

</html>
