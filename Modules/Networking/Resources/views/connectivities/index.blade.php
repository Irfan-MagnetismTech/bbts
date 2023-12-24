@extends('layouts.backend-layout')
@section('title', 'Client Connectivities')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">

    <style>
        .checkbox-fade .cr {
            height: 10px;
            width: 10px;
        }

        .noWrapStyle {
            white-space: normal;
            min-width: 12rem;
        }
    </style>
@endsection

@section('breadcrumb-title')
    Client Connectivities
@endsection

@section('sub-title')
    Total: {{ count($salesDetails) }}
@endsection

@section('content')
    <!-- put search form here -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Client Name</th>
                    <th>FR No</th>
                    <th>Connectivity Point</th>
                    <th>New/Existing</th>
                    <th>Delivery Date</th>
                    <th>Commissioning Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($salesDetails as $key => $details)
                    {{-- @dd($details->logicalConnectivityInternetModify) --}}
                    @php
                        $product_category = $details->saleProductDetails
                            ->map(function ($item, $key) {
                                return $item->product->category->name;
                            })
                            ->unique()
                            ->toArray();
                    @endphp


                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $details->client->client_name }}</td>
                        <td>{{ $details->fr_no }}</td>
                        <td class="noWrapStyle">{{ $details->frDetails->connectivity_point ?? '' }} </td>
                        <td> {{ $details->sale->is_modified == 1 ? 'Existing' : 'New' }} </td>
                        <td>{{ $details->delivery_date ? $details->delivery_date : '' }}</td>
                        <td>{{ $details->connectivities ? $details->connectivities->commissioning_date : '' }}</td>
                        <td>

                            @if ($details->sale->is_modified == 1)
                                @if (empty($details->physicalConnectivityModify))
                                    <span class="badge badge-primary">
                                        <a href="{{ route('modify-physical-connectivities.create', ['sale_id' => $details->sale_id, 'fr_no' => $details->fr_no]) }}"
                                            class="text-white" target="_blank">Physical Connectivity</a>
                                    </span>
                                @endif
                            @else
                                @if (empty($details->physicalConnectivity))
                                    <span class="badge badge-primary">
                                        <a href="{{ route('physical-connectivities.create', ['sale_id' => $details->sale_id, 'fr_no' => $details->fr_no]) }}"
                                            class="text-white" target="_blank">Physical Connectivity</a>
                                    </span>
                                @endif
                            @endif
                            {{-- <a href="{{ route('physical-connectivities.edit', $physicalConnectivity->id) }}" data-toggle="tooltip" 
                                    title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a> --}}


                            @if ($details->sale->is_modified == 1)
                                @if (in_array('Internet', $product_category) && empty($details->logicalConnectivityInternetModify))
                                    <span class="badge badge-info">
                                        <a href="{{ route('modify-internet-connectivities.create', ['sale_id' => $details->sale_id, 'fr_no' => $details->fr_no]) }}"
                                            class="text-white" target="_blank">Internet</a>
                                    </span>
                                @endif
                            @else
                                @if (in_array('Internet', $product_category) && empty($details->logicalConnectivityInternet))
                                    <span class="badge badge-info">
                                        <a href="{{ route('logical-internet-connectivities.create', ['sale_id' => $details->sale_id, 'fr_no' => $details->fr_no]) }}"
                                            class="text-white" target="_blank">Internet</a>
                                    </span>
                                @endif
                            @endif
                            @if ($details->sale->is_modified == 1)
                                @if (in_array('VAS', $product_category) && empty($details->logicalConnectivityVASModify))
                                    <span class="badge badge-info">
                                        <a href="{{ route('modify-logical-vas-connectivities.create', ['sale_id' => $details->sale_id, 'fr_no' => $details->fr_no]) }}"
                                            class="text-white" target="_blank">VAS</a>
                                    </span>
                                @endif
                            @else
                                @if (in_array('VAS', $product_category) && empty($details->logicalConnectivityVAS))
                                    <span class="badge badge-info">
                                        <a href="{{ route('logical-vas-connectivities.create', ['sale_id' => $details->sale_id, 'fr_no' => $details->fr_no]) }}"
                                            class="text-white" target="_blank">VAS</a>
                                    </span>
                                @endif
                            @endif

                            @if ($details->sale->is_modified == 1)
                                @if (in_array('Data', $product_category) && empty($details->logicalConnectivityDataModify))
                                    <span class="badge badge-info">
                                        <a href="{{ route('modify-logical-data-connectivities.create', ['sale_id' => $details->sale_id, 'fr_no' => $details->fr_no]) }}"
                                            class="text-white" target="_blank">Data</a>
                                    </span>
                                @endif
                            @else
                                @if (in_array('Data', $product_category) && empty($details->logicalConnectivityData))
                                    <span class="badge badge-info">
                                        <a href="{{ route('logical-data-connectivities.create', ['sale_id' => $details->sale_id, 'fr_no' => $details->fr_no]) }}"
                                            class="text-white" target="_blank">Data</a>
                                    </span>
                                @endif
                            @endif
                            </span>
                            <span class="badge badge-warning">
                                @if ($details->sale->is_modified == 1)
                                    <a href="{{ url("networking/modify-connectivities/create/$details->fr_no") }}"
                                        class="text-white" target="_blank">Details</a>
                                @else
                                    <a href="{{ url("networking/connectivities/create/$details->fr_no") }}"
                                        class="text-white" target="_blank">Details</a>
                                @endif
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {});
    </script>
@endsection
