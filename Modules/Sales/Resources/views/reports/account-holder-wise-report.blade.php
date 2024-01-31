@extends('layouts.backend-layout')
@section('title', 'Sales Summary Report')

@section('style')

@endsection

@section('breadcrumb-title')
    Sales Summary Report
@endsection

@section('style')
    <style>
        td {
            overflow-wrap: break-word;
            word-wrap: break-word;
        }
    </style>
@endsection

@section('sub-title')

@endsection


@section('content')
    <form action="" method="get" class="my-4">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="ticket_no" class="font-weight-bold">Account Holder:</label>
                    <select name="account_holder_name" id="account_holder_name" class="form-control select2">
                        <option value="">Select Account Holder</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->name }}"
                                {{ old('account_holder') == $employee->name ? 'selected' : '' }}>{{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_from" class="font-weight-bold">From Date:</label>
                    <input type="text" class="form-control date" id="date_from" name="date_from"
                        aria-describedby="date_from" value="{{ old('date_from') ?? (request()?->date_from ?? null) }}"
                        readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_to" class="font-weight-bold">To Date:</label>
                    <input type="text" class="form-control date" id="date_to" name="date_to" aria-describedby="date_to"
                        value="{{ old('date_to') ?? (request()?->date_to ?? null) }}" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_to" class="font-weight-bold">Select Type:</label>
                    <select name="type" id="type" class="form-control">
                        <option value="">Select Type</option>
                        <option value="Report">Report</option>
                        <option value="PDF">PDF</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group my-4 row">
                    <div class="col-md-6">
                        {{-- modal button --}}
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                            data-target="#exampleModal">
                            Filter Column
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group my-4 row">
                    <div class="col-md-6">
                        <input type="button" onclick="resetForm()" value="Reset"
                            class="btn btn-outline-warning btn-sm col-12">
                    </div>
                    <div class="col-md-6">
                        <input type="submit" value="Search" class="btn btn-outline-primary btn-sm col-12">
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Filter Columns</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table id="" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Column Name</th>
                                        <th>Filter</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Client ID</td>
                                        <td><input type="checkbox" name="client_id" id="" checked
                                                value="client_id">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Client Name</td>
                                        <td><input type="checkbox" name="client_name" id="" checked
                                                value="client_name"></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Connectivity Point</td>
                                        <td><input type="checkbox" name="connectivity_point" checked id=""
                                                value="connectivity_point"></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Pop</td>
                                        <td><input type="checkbox" name="pop" id="" checked value="pop">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Method</td>
                                        <td><input type="checkbox" name="method" id="" checked value="method">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Product</td>
                                        <td><input type="checkbox" name="product" id="" checked
                                                value="product">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Quantity</td>
                                        <td><input type="checkbox" name="quantity" id="" checked
                                                value="quantity">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>Price</td>
                                        <td><input type="checkbox" name="price" id="" checked value="price">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>Total</td>
                                        <td><input type="checkbox" name="total" id="" checked value="total">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>OTC</td>
                                        <td><input type="checkbox" name="otc" id="" checked value="otc">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td>MRC</td>
                                        <td><input type="checkbox" name="mrc" id="" checked value="mrc">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>12</td>
                                        <td>Activation Date</td>
                                        <td><input type="checkbox" name="activation_date" checked id=""
                                                value="activation_date"></td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td>Billing Start Date</td>
                                        <td><input type="checkbox" name="billing_start_date" checked id=""
                                                value="billing_start_date"></td>
                                    </tr>
                                    <tr>
                                        <td>14</td>
                                        <td>Billing Address</td>
                                        <td><input type="checkbox" name="billing_address" checked id=""
                                                value="billing_address"></td>
                                    </tr>
                                    <tr>
                                        <td>15</td>
                                        <td>A/C holder</td>
                                        <td><input type="checkbox" name="account_holder" checked id=""
                                                value="account_holder">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>16</td>
                                        <td>Remarks</td>
                                        <td><input type="checkbox" name="remarks" id="" checked
                                                value="remarks">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                {{-- check empty of filter data --}}
                @php
                    $filter_data = array_filter($filter_data);
                @endphp
                <tr>
                    <th>#SL</th>
                    @if (in_array('account_holder', $filter_data) || empty($filter_data))
                        <th>A/C holder</th>
                    @endif
                    @if (in_array('client_id', $filter_data) || empty($filter_data))
                        <th>Client ID</th>
                    @endif
                    @if (in_array('client_name', $filter_data) || empty($filter_data))
                        <th>Client Name</th>
                    @endif
                    @if (in_array('connectivity_point', $filter_data) || empty($filter_data))
                        <th>Connectivity Point</th>
                    @endif
                    @if (in_array('pop', $filter_data) || empty($filter_data))
                        <th>Pop</th>
                    @endif
                    @if (in_array('method', $filter_data) || empty($filter_data))
                        <th>Method</th>
                    @endif
                    @if (in_array('product', $filter_data) || empty($filter_data))
                        <th>Product</th>
                    @endif
                    @if (in_array('quantity', $filter_data) || empty($filter_data))
                        <th>Quantity</th>
                    @endif
                    @if (in_array('price', $filter_data) || empty($filter_data))
                        <th>Price</th>
                    @endif
                    @if (in_array('total', $filter_data) || empty($filter_data))
                        <th>Total</th>
                    @endif
                    @if (in_array('otc', $filter_data) || empty($filter_data))
                        <th>OTC</th>
                    @endif
                    @if (in_array('mrc', $filter_data) || empty($filter_data))
                        <th>MRC</th>
                    @endif
                    @if (in_array('activation_date', $filter_data) || empty($filter_data))
                        <th>Activation Date</th>
                    @endif
                    @if (in_array('billing_start_date', $filter_data) || empty($filter_data))
                        <th>Billing Start Date</th>
                    @endif
                    @if (in_array('billing_address', $filter_data) || empty($filter_data))
                        <th>Billing Address</th>
                    @endif
                    @if (in_array('remarks', $filter_data) || empty($filter_data))
                        <th>Remarks</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @foreach ($sales_data as $key => $monthly_sales_summary)
                    {{-- @dd($monthly_sales_summary['products']) --}}
                    @php
                        $max_rowspan = $monthly_sales_summary['products']->count();
                    @endphp
                    @for ($i = 0; $i < $max_rowspan; $i++)
                        <tr>
                            @if ($i == 0)
                                <td rowspan="{{ $max_rowspan }}">{{ $key + 1 }}</td>
                                @if (in_array('account_holder', $filter_data) || empty($filter_data))
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['account_holder'] }}
                                    </td>
                                @endif
                                @if (in_array('client_no', $filter_data) || empty($filter_data))
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['client_no'] }}
                                    </td>
                                @endif
                                @if (in_array('client_name', $filter_data) || empty($filter_data))
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['client_name'] }}
                                    </td>
                                @endif
                                @if (in_array('connectivity_point', $filter_data) || empty($filter_data))
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['connectivity_point'] }}
                                    </td>
                                @endif
                            @endif
                            @if (isset($monthly_sales_summary['pop'][$i]))
                                @if (in_array('pop', $filter_data) || empty($filter_data))
                                    <td>
                                        {!! $monthly_sales_summary['pop'][$i] !!}
                                    </td>
                                @endif
                            @else
                                @if (in_array('pop', $filter_data) || empty($filter_data))
                                    <td>-</td>
                                @endif
                            @endif

                            @if (isset($monthly_sales_summary['method'][$i]))
                                @if (in_array('method', $filter_data) || empty($filter_data))
                                    <td>
                                        {!! $monthly_sales_summary['method'][$i] !!}
                                    </td>
                                @endif
                            @else
                                @if (in_array('method', $filter_data) || empty($filter_data))
                                    <td>-</td>
                                @endif
                            @endif
                            @if (in_array('product', $filter_data) || empty($filter_data))
                                <td>
                                    {{ $monthly_sales_summary['products'][$i]->product->name ?? '' }}
                                </td>
                            @endif
                            @if (in_array('quantity', $filter_data) || empty($filter_data))
                                <td>
                                    {{ $monthly_sales_summary['products'][$i]->quantity ?? '' }}
                                </td>
                            @endif
                            @if (in_array('price', $filter_data) || empty($filter_data))
                                <td>
                                    {{ $monthly_sales_summary['products'][$i]->price }}
                                </td>
                            @endif
                            @if (in_array('total', $filter_data) || empty($filter_data))
                                <td>
                                    {{ $monthly_sales_summary['products'][$i]->quantity * $monthly_sales_summary['products'][$i]->price }}
                                </td>
                            @endif
                            @if ($i == 0)
                                @if (in_array('otc', $filter_data) || empty($filter_data))
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['otc'] }}
                                    </td>
                                @endif
                                @if (in_array('mrc', $filter_data) || empty($filter_data))
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['mrc'] }}
                                    </td>
                                @endif
                                @if (in_array('activation_date', $filter_data) || empty($filter_data))
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['activation_date'] }}
                                    </td>
                                @endif
                                @if (in_array('billing_start_date', $filter_data) || empty($filter_data))
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['billing_date'] }}
                                    </td>
                                @endif
                                @if (in_array('billing_address', $filter_data) || empty($filter_data))
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['billing_address'] }}
                                    </td>
                                @endif
                                @if (in_array('remarks', $filter_data) || empty($filter_data))
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['remarks'] }}</td>
                                @endif
                            @endif
                        </tr>
                    @endfor
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.date').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
            });

            select2Ajax("{{ route('search-support-ticket') }}", '#ticket_no')
        })

        function resetForm() {
            $('#date_from').val('');
            $('#date_to').val('');
            $('#ticket_no').val('').trigger("change");
            // $('#ticket_no').prop('selectedIndex',0);
        }
    </script>
@endsection
