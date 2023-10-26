@extends('layouts.backend-layout')
@section('title', 'POP')

@section('breadcrumb-title')
    POP Information
@endsection

@section('breadcrumb-button')
    <a href="{{ route('pops.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('style')
<style>
    .table_header{
        background-color:#057097!important; 
        font-size: 12px; 
        color: white; 
        font-size: 14px;
    }
    .table_header_td{
        background-color: #ecf4f7;
        text-align: left;
        border: 1px solid rgb(205, 207, 208) !important
    }
</style>
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
                            <table class="table table-bordered" style="">
                                <tr class="table_header">
                                    <td colspan="4" style="text-align: center" style=""><b>POP Information</b></td>
                                </tr> 
                                <tr>
                                    <td class="table_header_td">POP Name</td>
                                    <td><b>{{ $pop->name ?? '' }}</b></td>
                                    <td class="table_header_td">POP Type</td>
                                    <td><b>{{ $pop->type ?? '' }}</b></td> 
                                </tr>
                                <tr>
                                    <td class="table_header_td">POP Address</td>
                                    <td colspan="3"><b>{{ $pop->address ?? '' }}</b></td> 
                                </tr>
                                <tr>
                                    <td class="table_header_td">Thana</td>
                                    <td><b>{{ $pop->thana->name ?? '' }}</b></td>
                                    <td class="table_header_td">District</td>
                                    <td><b>{{ $pop->district->name ?? '' }}</b></td> 
                                </tr>
                                <tr>
                                    <td class="table_header_td">Division</td>
                                    <td><b>{{ $pop->division->name ?? '' }}</b></td>
                                    <td class="table_header_td">Branch</td>
                                    <td><b>{{ $pop->branch->name ?? '' }}</b></td> 
                                </tr>
                                <tr>
                                    <td class="table_header_td">Lat/Long</td>
                                    <td><b>{{ $pop->lat_long ?? ''}}</b></td> 
                                    <td class="table_header_td">Tower</td>
                                    <td><b>{{ $pop->tower ?? '' }}</b></td> 
                                </tr>
                                <tr>
                                    <td class="table_header_td">Tower Height (m)</td>
                                    <td>{{ $pop->tower_height ?? '' }}</td>
                                    <td class="table_header_td">Flat/Room Size</td>
                                    <td>{{ $pop->room_size ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Sign Board Status</td>
                                    <td>{{ $pop->signboard ?? '' }}</td>
                                    <td class="table_header_td">Electric Meter No</td>
                                    <td>{{ $pop->electric_meter_no ?? '' }}</td>
                                </tr> 
                                <tr>
                                    <td class="table_header_td">Approval Date</td>
                                    <td>{{ $pop->approval_date ?? '' }}</td>
                                    <td class="table_header_td">Deed Duration</td>
                                    <td>{{ $pop->deed_duration ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">BTRC Approval Date</td>
                                    <td>{{ $pop->btrc_approval_date ?? '' }}</td>
                                    <td class="table_header_td">Commissioning Date</td>
                                    <td>{{ $pop->commissioning_date ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="table_header_td"></td>
                                    <td></td>
                                    <td class="table_header_td">Website Published Date</td>
                                    <td>{{ $pop->website_published_date ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Renewal Date</td>
                                    <td>{{ $pop->renewal_date ?? '' }}</td>
                                    <td class="table_header_td">Renewal Condition</td>
                                    <td>{{ $pop->renewal_condition ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Descreption</td>
                                    <td colspan="3">{{ $pop->description ?? '' }}</td> 
                                </tr>
                                <tr class="table_header">
                                    <td colspan="4" style="text-align: center" style=""><b>Owner's Information</b></td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Owner Name</td>
                                    <td><b>{{ $pop->owners_name ?? '' }}</b></td>
                                    <td class="table_header_td">Owner Address</th>
                                    <td>{{ $pop->owners_address ?? '' }}</td>
                                </tr> 
                                <tr>
                                    <td class="table_header_td">Owner NID</td>
                                    <td>{{ $pop->owners_nid ?? '' }}</td>
                                    <td class="table_header_td">Contact Person</td>
                                    <td>{{ $pop->contact_person ?? '' }} - {{ $pop->designation }} - 
                                        {{ $pop->contact_no ?? '' }} - {{ $pop->email }}
                                    </td>
                                </tr>
                                <tr class="table_header">
                                    <td colspan="4" style="text-align: center" style=""><b>Billing Information</b></td>
                                </tr> 
                                <tr>
                                    <td class="table_header_td">Tower Rent</td>
                                    <td>{{ $pop->popLines[0]->amount ?? '' }}</td>
                                    <td class="table_header_td">Electricity Bill</td>
                                    <td>{{ $pop->popLines[1]->amount ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Water Bill</td>
                                    <td>{{ $pop->popLines[2]->amount ?? '' }}</td>
                                    <td class="table_header_td">Gas Bill</td>
                                    <td>{{ $pop->popLines[3]->amount ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Advance Amount</td>
                                    <td>{{ $pop->advance_amount ?? '' }}</td>
                                    <td class="table_header_td">Reduce Amount</td>
                                    <td>{{ $pop->advance_reduce ?? '' }}</td> 
                                </tr>
                                <tr> 
                                    <td class="table_header_td">Rent Amount</td>
                                    <td>{{ $pop->rent ?? '' }}</td>
                                    <td class="table_header_td">Total Rent</td>
                                    <td> {{ $pop->total_rent ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Payment Method</td>
                                    <td>{{ $pop->payment_method ?? '' }}</td>
                                    <td class="table_header_td">Payment Date</td>
                                    <td>{{ $pop->payment_date ?? '' }}</td>
                                </tr> 
                                <tr>
                                    <td class="table_header_td">A/C No</td>
                                    <td>{{ $pop->account_no ?? '' }} - {{ $pop->routing_no ?? '' }}</td>
                                    <td class="table_header_td">Bank Name</td>
                                    <td>{{ $pop->bank->name ?? '' }} </td>
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
