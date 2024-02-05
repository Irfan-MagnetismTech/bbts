@extends('layouts.backend-layout')
@section('title', 'Active Clients Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Inactive Clients Report
@endsection

@section('style')
    <style>
    </style>
@endsection

@section('content')
    <form action="" method="get" class="custom-form" target="_blank">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="ticket_no" class="font-weight-bold">Type:</label>
                    <select name="type" id="type" class="form-control select2">
                        <option value="">Select Type</option>
                        <option value="Report">Report</option>
                        <option value="PDF">PDF</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group my-4 row">
                    <div class="col-md-6">
                        <input type="submit" value="Search" class="btn btn-outline-primary btn-sm col-12">
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="dt-responsive table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">

                <tbody>
                    @foreach ($permanently_inactive_clients as $key => $inactive_clients)
                        <tr>
                            <td colspan="10"
                                style="text-align: center; font-size: 16px; font-weight: bold; background-color: #f2f2f2;">
                                {{ $key }}
                            </td>
                        </tr>
                        <tr style="background-color: #f3f3f3;">
                            <th>Client</th>
                            <th>Connectivity Point</th>
                            <th>Branch</th>
                            <th>Thana</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Equipment</th>
                            <th>OTC</th>
                            <th>Monthly Revenue</th>
                            <th>Reason</th>
                        </tr>
                        @foreach ($inactive_clients as $client)
                            @php
                                $max_row = max(count($client['scm_err']), count($client['sale_product_details']));
                            @endphp
                            @for ($i = 0; $i < $max_row; $i++)
                                <tr>
                                    @if ($i == 0)
                                        <td rowspan="{{ $max_row }}" style="font-size: 14px;">
                                            {{ $client['client_name'] }}</td>
                                        <td rowspan="{{ $max_row }}" style="font-size: 14px;">
                                            {{ $client['connectivity_point'] }}</td>
                                        <td rowspan="{{ $max_row }}" style="font-size: 14px;">{{ $client['branch'] }}
                                        </td>
                                        <td rowspan="{{ $max_row }}" style="font-size: 14px;">{{ $client['thana'] }}
                                        </td>
                                    @endif
                                    @if (isset($client['sale_product_details'][$i]))
                                        <td style="font-size: 14px;">
                                            {{ $client['sale_product_details'][$i]->product->name }}</td>
                                        <td style="font-size: 14px;">{{ $client['sale_product_details'][$i]->quantity }}
                                        </td>
                                    @else
                                        <td>-</td>
                                        <td>-</td>
                                    @endif
                                    @if (isset($client['scm_err'][$i]))
                                        {{-- @dd($client['scm_err'][$i]); --}}
                                        <td> {{ $client['scm_err'][$i]->material->name }}
                                        @else
                                        <td>-</td>
                                    @endif
                                    @if ($i == 0)
                                        <td rowspan="{{ $max_row }}" style="font-size: 14px;">{{ $client['otc'] }}
                                        </td>
                                        <td rowspan="{{ $max_row }}" style="font-size: 14px;">{{ $client['mrc'] }}
                                        </td>
                                        <td rowspan="{{ $max_row }}" style="font-size: 14px;">{{ $client['reason'] }}
                                        </td>
                                    @endif
                                </tr>
                            @endfor
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
@endsection
