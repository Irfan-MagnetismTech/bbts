@extends('layouts.backend-layout')
@section('title', 'POP')

@section('breadcrumb-title')
    POP Information
@endsection

@section('breadcrumb-button')
    <a href="{{ route('pops.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('content-grid', null)
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- table  -->
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="font-size: 12px;">
                                <tr>
                                    <td colspan="4" style="text-align: start"><h6><u>Owner Information:-</u></h6></td>
                                </tr>
                                <tr>
                                    <th>Owner Name</th>
                                    <td><b>{{$pop->owners_name ?? '' }}</b></td>
                                    <th>Owner Address</th>
                                    <td>{{$pop->owners_address ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Owner NID</th>
                                    <td>{{$pop->owners_nid ?? '' }}</td>
                                    <th>Mobile Number</th>
                                    <td>{{$pop->contact_person ?? '' }}(Contact Person) {{$pop->contact_no ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: start"><h6><u>Account Information:-</u></h6></td>
                                </tr>
                                <tr>
                                    <th>A/C No</th>
                                    <td>{{ $pop->account_no ?? '' }}</td>
                                    <th>Bank Name</th>
                                    <td>{{ $pop->bank->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Method</th>
                                    <td>{{$pop->payment_method ?? ''}}</td>
                                    <th>Payment Date</th>
                                    <td>{{ $pop->payment_date ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: start"><h6><u>Building Information:-</u></h6></td>
                                </tr>
                                <tr>
                                    <th>POP Address</th>
                                    <td>{{ $pop->address ?? '' }}</td>
                                    <th>Electric Meter No</th>
                                    <td>{{$pop->electric_meter_no ??''}}</td>

                                </tr>
                                <tr>
                                    <th>Lat/Long</th>
                                    <td>{{ $pop->lat_long ?? '' }}</td>
                                    <th>Tower (Y/N)</th>
                                    <td>{{ $pop->tower ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Tower Height (m)</th>
                                    <td>{{ $pop->tower_height ?? '' }}</td>
                                    <th>Flat/Room Size</th>
                                    <td>{{ $pop->room_size ?? '' }}</td>

                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: start"><h6><u>Agreement Information:-</u></h6></td>
                                </tr>
                                <tr>
                                    <th>Advance Amount</th>
                                    <td>{{$pop->advance_amount ?? '' }}</td>
                                    <th>Rent Amount</th>
                                    <td>{{ $pop->total_rent ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Deed Duration</th>
                                    <td>{{ $pop->deed_duration ?? '' }}</td>
                                    <th>Payment Date</th>
                                    <td>{{ $pop->payment_date ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Tower Rent</th>
                                    <td>{{ $pop->popLines[0]->amount ?? '' }}</td>
                                    <th>Electricity Bill</th>
                                    <td>{{ $pop->popLines[1]->amount ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Water Bill</th>
                                    <td>{{ $pop->popLines[2]->amount ?? '' }}</td>
                                    <th>Gas Bill</th>
                                    <td>{{ $pop->popLines[3]->amount ?? '' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="status" value="">
                </div>
            </div>
        </div>
    </div>
@endsection
