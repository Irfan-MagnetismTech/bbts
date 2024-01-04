<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Monthly Sales Report</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }

        th {
            text-align: center;
        }

        .dt-responsive {
            overflow: auto;
            padding: 0 5%;
        }

        thead tr th {
            background-color: #f2f2f2;
            font-size: 12px;
        }

        tbody tr td {
            font-size: 12px;
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
            margin: 150px 0px 40px 0px;
        }
    </style>

</head>

<body>
    <htmlpageheader name="page-header">
        <div>
            &nbsp;
        </div>
        <div>
            <div id="logo" class="pdflogo">
                <img src="{{ asset('images/bbts_logo.png') }}" alt="Logo" class="pdfimg">
                <div class="clearfix"></div>
                <h5 style="margin: 2px; padding: 2px;">Ispahani Building (2nd Floor), Agrabad C/A, Chittagong-4100.</h5>
                <h4 style="margin: 2px; padding: 2px;">Plan Modification Report</h4>
                <hr />
            </div>
        </div>

    </htmlpageheader>

    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Client ID</th>
                    <th>Client Name</th>
                    <th>Connectivity Point</th>
                    <th>Asked for plan note</th>
                    <th>Plan Provided</th>
                    <th>Remarks (Plan for)</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($plan_reports as $key => $plan_report)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $plan_report->client_no }}</td>
                        <td>{{ $plan_report?->lead_generation?->client_name }}</td>
                        <td>{{ $plan_report?->feasibilityRequirementDetail?->connectivity_point }}</td>
                        <td>{{ date('d-m-Y h:m A', strtotime($plan_report->ConnectivityRequirement->created_at)) }}</td>
                        <td>{{ date('d-m-Y h:m A', strtotime($plan_report->created_at)) }}</td>
                        <td>{{ $plan_report->remarks }}</td>
                        <td>
                            <a href="{{ route('client-plan-modification.show', $plan_report->id) }}"
                                class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
