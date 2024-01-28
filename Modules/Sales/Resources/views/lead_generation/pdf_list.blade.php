<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $plan->lead_generation->client_name ?? '' }} Planning </title>
    <style>
        .text-center {
            text-align: center;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .productTable {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            font-size: 12px;
        }

        .productTable th {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
            background: #f2f2f2;
        }

        .productTable td {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
        }

        .equipementTable {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            font-size: 12px;
        }

        .equipementTable th {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
            background: #f2f2f2;
        }

        .equipementTable td {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
        }

        .totalInvestment {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            font-size: 12px;
        }

        .totalInvestment th {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
            background: #f2f2f2;
        }

        .totalInvestment td {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
        }

        .productEquipmentTable {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            font-size: 12px;
        }

        .productEquipmentTable th {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
            background: #f2f2f2;
        }

        .productEquipmentTable td {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
        }

        @page {
            header: page-header;
            footer: page-footer;
        }

        #logo {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
            position: relative;
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
            margin: 150px 10px 40px 10px;
        }
    </style>
</head>

<body>
    <div>
        <htmlpageheader name="page-header">
            <div>
                &nbsp;
            </div>
            <div>
                <div id="logo" class="pdflogo">
                    <img src="{{ asset('images/bbts_logo.png') }}" alt="Logo" class="pdfimg">
                    <div class="clearfix"></div>
                    <h5 style="margin: 2px; padding: 2px;">Ispahani Building (2nd Floor), Agrabad C/A, Chittagong-4100.
                    </h5>
                    <h4 style="margin: 2px; padding: 2px;">Lead Generation</h4>
                    <hr />
                </div>
            </div>

        </htmlpageheader>
        <div>
            <div>
                <table class="productTable">
                    <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Date</th>
                            <th>Client id</th>
                            <th>Client Name</th>
                            <th>Contact Person</th>
                            <th>Designation</th>
                            <th>Contact No</th>
                            <th>Created By</th>
                            <th>Connected Status</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lead_generations as $key => $lead_generation)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $lead_generation->created_at->format('d-m-Y') }}</td>
                                <td>{{ $lead_generation->client_no }}</td>
                                <td>
                                    {{-- @if (!empty($lead_generation->client))
                                    <a href="{{ route('client-profile.show', $lead_generation->client->id) }}"> 
                                    {{ $lead_generation->client_name }}</a>
                                    @else
                                    {{ $lead_generation->client_name }}
                                    @endif --}}

                                    {{ $lead_generation->client_name }}

                                </td>
                                <td>{{ $lead_generation->contact_person }}</td>
                                <td>{{ $lead_generation->designation }}</td>
                                <td>{{ $lead_generation->contact_no }}</td>
                                <td>{{ $lead_generation->createdBy->name ?? '' }}</td>
                                <td>{{ !empty($lead_generation->sale) ? 'Connected' : 'New' }}</td>
                                <td>
                                    @if ($lead_generation->status == 'Review')
                                        <span class="badge badge-pill badge-info">{{ $lead_generation->status }}</span>
                                    @elseif ($lead_generation->status == 'Pending')
                                        <span
                                            class="badge badge-pill badge-warning">{{ $lead_generation->status }}</span>
                                    @elseif($lead_generation->status == 'Accept')
                                        <span
                                            class="badge badge-pill badge-success">{{ $lead_generation->status }}</span>
                                    @elseif($lead_generation->status == 'Cancel')
                                        <span
                                            class="badge badge-pill badge-danger">{{ $lead_generation->status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
