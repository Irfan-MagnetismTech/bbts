@extends('layouts.backend-layout')
@section('title', 'Employee')

@section('breadcrumb-title')
    Profile : <strong>{{strtoupper($employee->fullname)}}</strong>
@endsection

@section('breadcrumb-button')
    <a href="{{ url('employees') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
{{--    <span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content-grid', 'offset-lg-1 col-lg-10 my-3')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="tableHeading">
            <h5> <span>&#10070;</span> Personal Information <span>&#10070;</span> </h5>
        </div>
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <tbody class="text-left">

                <tr>
                    <td class="background-info"> <strong>Employee Name</strong> </td>
                    <td colspan="3" class="breakWords background-info">{{$employee->fullname}} </td>
                </tr>
                {{--<tr><td> <strong>Designation</strong> </td> <td>{{$employee->designation->name}} </td></tr>--}}
                {{--<tr><td> <strong>Department</strong> </td> <td>{{$employee->department->name}} </td></tr>--}}
                {{--                    <tr><td> <strong>Team</strong> </td> <td>{{$employee->team->name}} </td></tr>--}}
                <tr>
                    <td> <strong> Employee ID</strong> </td> <td>{{$employee->employee_code}}</td>
                    <td> <strong>Date of Birth</strong> </td> <td> {{$employee->dob}}</td>
                </tr>
                <tr>
                    <td> <strong> Department</strong> </td>
                    <td>{{$employee->department->name}}</td>
                    <td> <strong> Designation</strong> </td>
                    <td>{{$employee->designation->name}}</td>
                </tr>
                <tr>
                    <td> <strong>Contact</strong> </td> <td>{{$employee->contact}} </td>
                    <td> <strong>Email</strong> </td> <td> {{$employee->email}}</td>

                </tr>

                <tr><td> <strong>NID</strong> </td> <td colspan="3">{{$employee->nid}} </td></tr>
                <tr><td colspan="4" class="background-info"> <strong>Present Address</strong> </td> </tr>
                <tr><td> <strong>Street</strong> </td> <td colspan="3">{{$employee->pre_street_address}} </td></tr>
                <tr><td> <strong>Thana</strong> </td> <td colspan="3">{{$employee->preThana->name ?? '' }} </td></tr>
                <tr><td> <strong>District</strong> </td> <td colspan="3">{{$employee->preThana->district->name ?? '' }} </td></tr>
                <tr><td> <strong>Division</strong> </td> <td colspan="3">{{$employee->preThana->district->division->name ?? '' }} </td></tr>
                <tr><td colspan="4" class="background-info"> <strong>Permanent Address</strong> </td> </tr>
                <tr><td> <strong>Street</strong> </td> <td colspan="3">{{$employee->per_street_address}} </td></tr>
                <tr><td> <strong>Thana</strong> </td> <td colspan="3">{{$employee->perThana->name ?? ''}} </td></tr>
                <tr><td> <strong>District</strong> </td> <td colspan="3">{{$employee->perThana->district->name ?? ''}} </td></tr>
                <tr><td> <strong>Division</strong> </td> <td colspan="3">{{$employee->perThana->district->division->name ?? ''}} </td></tr>
                <tr><td><strong>Picture</strong></td>
                    <td colspan="3">
                        @if($employee && $employee->picture)
                            <img src="{{asset($employee->picture)}}" alt="" width="auto" height="80px">
                        @else
                            <strong>Not Uploaded</strong>
                        @endif
                    </td></tr>
                </tbody>
            </table>
        </div>
    </div> <!-- col-md-6 -->

    @if($employee->user && $employee->user->leads)
        @php
            $leads  = $employee->user->leads->groupBy('lead_stage')->map(function($item, $key){
                return collect($item)->count();
            });
        @endphp
        <div class="col-12">
            <div class="tableHeading">
                <h5> <span>&#10070;</span> Leads <span>&#10070;</span> </h5>
            </div>
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered text-center">
                    <thead>
                    <tr>
                        <td class="bg-info"> Stage - <strong> A </strong> <br>(Almost Final) </td>
                        <td class="bg-info"> Stage - <strong> B </strong> <br>(Processing) </td>
                        <td class="bg-info"> Stage - <strong> C </strong> <br>(Initial) </td>
                        <td class="bg-info"> Stage - <strong> D </strong> <br>(Dead) </td>
                        <td class="bg-info"><strong>Total</strong></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="bg-white">
                        <td> {{$leads['A'] ?? 0}} </td>
                        <td> {{$leads['B'] ?? 0}} </td>
                        <td> {{$leads['C'] ?? 0}} </td>
                        <td> {{$leads['D'] ?? 00}} </td>
                        <td>{{$employee->user->leads->count()}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div> <!-- end col-lg-6 -->
    @endif


    @if($employee->user && $employee->user->sells)
    <div class="col-12">
        <div class="tableHeading">
            <h5> <span>&#10070;</span> Sales <span>&#10070;</span> </h5>
        </div>
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered text-center">
                <thead>
                <tr>
                    <td class="bg-info"> # </td>
                    <td class="bg-info"> Project Name </td>
                    <td class="bg-info"> Client's Name </td>
                    <td class="bg-info"> Apartment ID </td>
                    <td class="bg-info"> Rate (Per Sft) </td>
                    <td class="bg-info"> Total Value </td>
                    <td class="bg-info"> Received </td>
                    <td class="bg-info"> Balance </td>
                    <td class="bg-info"> Sold Date </td>
                </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($employee->user->sells as $sell)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td class="text-left breakWords"> <strong><a href="{{route('projects.show', $sell->apartment->project->id)}}" target="_blank">{{$sell->apartment->project->name}}</a></strong> </td>
                            <td class="text-left breakWords"> <strong><a href="{{route('sells.show', $sell->id)}}" target="_blank">{{$sell->sellClient->client->name}}</a></strong> </td>
                            <td> <strong><a href="{{route('apartments.show', $sell->apartment->id)}}" target="_blank">{{$sell->apartment->name}}</a></strong> </td>
                            <td>{{$sell->apartment->apartment_rate}}</td>
                            <td>{{$sell->apartment->total_value}}</td>
                            <td>{{$sell->salesCollections->sum('received_amount')}}</td>
                            <td>
                                {{$sell->apartment->total_value - $sell->salesCollections->sum('received_amount')}}
                            </td>
                            <td>
                                {{$sell->sell_date}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> <!-- end col-lg-6 -->
    @endif



</div> <!-- end row -->



@endsection

@section('script')

@endsection
