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

@php $price_index = 0; @endphp
@foreach ($comparative_statement->csMaterials->chunk(5) as $chunk)

    <div>
        <div id="logo" class="pdflogo" id="fixed_header">
            <img src="{{ asset('images/ranksfc_log.png') }}" alt="Logo" class="pdfimg">
            <div class="clearfix"></div>
            <h5>Atlas Rangs Plaza (Level- 9 & 10), 7, SK Mujib Road, Agrabad C/A, Chattogram.</h5>
        </div>

        <div id="pageTitle" style="display: block; width: 100%;">
            <h2 style="text-align: center; width: 65%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">
                Comparative Statement & Supplier Selection Form</h2>
        </div>
        <div class="container" style="margin-top: 10px; clear: both; display: block; width: 96%;">
            <div style="text-align: center !important; position: relative;">
                <table id="table" style="text-align: right">
                    <tr>
                        <td>
                            <b>Projects:</b>
                            @forelse ($comparative_statement->csProjects as $cs_project)
                                {{ $cs_project->project->name }}
                                {{ !$loop->last ? ', ' : '' }}
                            @empty

                            @endforelse
                        </td>
                        <td><b>CS Ref# - {{ $comparative_statement->reference_no }}</b></td>
                        <td><b>Effective Date:</b> {{ $comparative_statement->effective_date }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>



    <div class="container" style="margin-top: 10px; clear: both; display: block; width: 96%;">
        <table id="table">
            <thead>
                <tr style="vertical-align: middle" class="text-center">
                    <th width="20px">SL No</th>
                    <th width="100px">Material's Name</th>
                    <th width="30px">Unit</th>
                    @forelse ($comparative_statement->csSuppliers as $cs_supplier)
                        <th width="120px">
                            <span>{{ $cs_supplier->supplier->name }}</span> <br>
                            <span>{{ $cs_supplier->supplier->address }}</span> <br>
                            <span>{{ $cs_supplier->supplier->contact }}</span> <br>
                            <span>{{ $cs_supplier->collection_way }}</span> <br>
                            <span>{{ $cs_supplier->is_checked ? 'Selected' : ''}}</span> <br>
                        </th>
                    @empty
                    @endforelse
                    <th width="60px">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @php $price_index = 0; @endphp
                @foreach ($chunk as $cs_material)
                    <tr>
                        <td style="text-align: center">{{ $iteration++ }}</td>
                        <td style="text-align: center"><b>{{ $cs_material->nestedMaterial->name }}</b></td>
                        <td style="text-align: center">{{ $cs_material->nestedMaterial->unit->name }}</td>
                        @forelse ($comparative_statement->csSuppliers as $cs_supplier)
                            <td style="text-align: center">
                                {{ $comparative_statement->csMaterialsSuppliers->where('cs_material_id', $cs_material->id)->where('cs_supplier_id', $cs_supplier->id)->first()->price }}</td>
                        @empty
                        @endforelse

                        @if ($loop->last) <td style="text-align: center">{{ $comparative_statement->remarks }}</td> @endif
                    </tr>
                @endforeach
                <tr>
                    <td style="text-align: center">---</td>
                    <td>Terms & Condition</td>
                    <td colspan="{{ count($comparative_statement->csSuppliers) + 2 }}"></td>
                </tr>
                @php
                    $other_details = [
                        'grade' => 'Grade',
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
                        @forelse ($comparative_statement->csSuppliers as $cs_supplier)
                            <td style="text-align: center">{{ $cs_supplier[$key] }}</td>
                        @empty
                        @endforelse
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <span style="font-size: 12px">We May select all suppliers for contingency price</span>
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
    @if (!$loop->last)
            <div class="page_break"></div>
        @endif
    @endforeach

</body>

</html>
