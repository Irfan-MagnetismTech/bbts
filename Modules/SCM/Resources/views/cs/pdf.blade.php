<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        table {
            font-size: 12px;
        }

        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #0e2b4e;
            color: white;
        }

        .tableHead {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }

        p {
            margin: 0;
        }

        h1 {
            margin: 0;
        }

        h2 {
            margin: 0;
        }

        .container {
            margin: 20px;
        }

        #logo {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
            position: relative;
        }

        #client {
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            top: 0;
            line-height: 18px;
            padding: 5px;
        }

        #apartment {
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            right: 20px;
            top: 20px;
            line-height: 18px;
            padding: 5px;
        }

        .infoTable {
            font-size: 12px;
            width: 100%;
        }

        .infoTableTable td:nth-child(2) {
            text-align: center;
            width: 20px;
        }

        .pdflogo a {
            font-size: 18px;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        @page {
            margin: 40px 0 0 0;
        }

        /*header - position: fixed */
        #fixed_header {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            right: 0;
        }

        /*fixed_footer - position: fixed */
        #fixed_footer {
            position: fixed;
            width: 94.4%;
            bottom: 20;
            left: 0;
            right: 0;
        }

        .page_break {
            page-break-before: always;
        }

    </style>
</head>

<body>
    @php
        $iteration = 1;
    @endphp
    <div>
        &nbsp;
    </div>
    <div>
        <div style="width: 100%; text-align: center">
            <img src="{{ asset('images/bbts_logo.png') }}" alt="Logo" class="pdfimg">
            <h5>Ispahani Building (2nd Floor), Agrabad C/A, Chittagong-4100.</h5>
        </div>

        <div id="pageTitle" style="display: block; width: 100%;">
            <h2 style="text-align: center; width: 65%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">
                Comparative Statement & Supplier Selection</h2>
        </div>
    </div>
    <div style="margin-left: 25px; margin-top: 10px">
{{--        <span><b>Date Issued:</b> {{$comparativeStatement->effective_date ?? ''}}</span><br>--}}
        <?php
        $effectiveDate = $comparativeStatement->effective_date ?? '';
        if (!empty($effectiveDate)) {
            $formattedDate = date('d/m/y', strtotime($effectiveDate));
            echo '<span><b>Date Issued:</b> ' . $formattedDate . '</span><br>';
        } else {
            echo '<span><b>Date Issued:</b> </span><br>';
        }
        ?>

        <span><b>CS No:</b> {{$comparativeStatement->cs_no ?? ''}}</span><br>
        <span><b>Indent No:</b> {{$comparativeStatement->indent_no ?? ''}}</span><br>
        <span>
            <b>PRS No:</b>
                @foreach ($prsNos as $prsNo)
                {{ $prsNo ?? ''}}
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
            </span>
    </div>
    <br>
    <div class="container" style="margin-top: 10px; clear: both; display: block; width: 96%;">
        <table id="table">
            <thead>
                <tr style="vertical-align: middle" class="text-center">
                    <th width="20px">SL No</th>
                    <th width="100px">Material's Name</th>
                    <th width="30px">Unit</th>
                    @forelse ($csSuppliers as $csSupplier)
                        @if($csSupplier->cs_id == $comparativeStatement->id)
                        <th width="120px">
                            <span>{{ $csSupplier->supplier->name }}</span> <br>
                            <span>{{ $csSupplier->supplier->address }}</span> <br>
                            <span>{{ $csSupplier->supplier->contact }}</span> <br>
                            <span>{{ $csSupplier->collection_way }}</span> <br>
                            <span>{{ $csSupplier->is_checked ? 'Selected' : ''}}</span> <br>
                        </th>
                        @endif
                    @empty
                    @endforelse
                    <th width="60px">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($csMaterials as $csMaterial)
                    @if($csMaterial->cs_id == $comparativeStatement->id)
                    <tr>
                        <td style="text-align: center">{{ $iteration++ }}</td>
                        <td style="text-align: center"><b>{{ $csMaterial->material->name }}</b></td>
                        <td style="text-align: center">{{ $csMaterial->material->unit?? '' }}</td>
                        @forelse ($csSuppliers as $csSupplier)
                            @if($csSupplier->cs_id == $comparativeStatement->id)
                            <td style="text-align: center">
                                {{ $comparativeStatement->csMaterialsSuppliers->where('cs_material_id', $csMaterial->id)->where('cs_supplier_id', $csSupplier->id)->first()->price ?? ''}}
                            </td>
                            @endif
                        @empty
                        @endforelse
                        <td style="text-align: center">  {{ $comparativeStatement->remarks}}</td>
                    </tr>
                    @endif
                @endforeach

                @php
                    $other_details = [
                        'vat_tax' => 'Vat & Tax',
                        'credit_period' => 'Credit Period',
                        'material_availability' => 'Material Availability',
                        'delivery_condition' => 'Delivery Condition',
                        'required_time' => 'Load Atime required by supplier',
                    ];
                @endphp

                @foreach ($other_details as $key => $value)
                    <tr>
                        <td style="text-align: center">---</td>
                        <td>{{ $value }}</td>
                        <td></td>
                        @forelse ($csSuppliers as $csSupplier)
                            @if($csSupplier->cs_id == $comparativeStatement->id)
                            <td style="text-align: center">{{ $csSupplier[$key] }}</td>
                            @endif
                        @empty
                        @endforelse
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <span style="font-size: 12px">We may select all suppliers for contingency price</span>
        <br>

        <br><br><br>
        <div style="display: block; width: 100%;" id="fixed_footer">
            <table style="text-align: center; width: 100%;">
                <tr>
                    <td>
                        <span>----------------------</span>
                        <p>Prepared By</p>
                    </td>
                    <td>
                        <span>----------------------</span>
                        <p>Authorised By</p>
                    </td>
                    <td>
                        <span>----------------------</span>
                        <p>Checked By</p>
                    </td>
                    <td>
                        <span>----------------------</span>
                        <p>Verified By</p>
                    </td>
                    <td>
                        <span>----------------------</span>
                        <p>Approved By</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
