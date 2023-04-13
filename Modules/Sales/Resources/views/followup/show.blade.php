@extends('layouts.backend-layout')
@section('title', 'Follow Up Details')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Follow Up Details
@endsection

@section('style')

@endsection
@section('breadcrumb-button')
    <a href="{{ route('followup.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
    <a href="{{ route('followup.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection
@section('sub-title')
    Meeting Client: {{ $followup->client->client_name }}
@endsection


@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- table  -->
                    {{-- headings --}}

                    <div class="col-md-12">
                        <h5 class="text-center">Follow Up Details</h5>
                        <hr>
                        <div class="table-responsive">
                            <table class="table custom_table table-bordered" style="font-size: 12px;">
                                <tr>
                                    <th>Client Name</th>
                                    <td>{{ $followup->client->client_name }}</td>
                                    <th>Address</th>
                                    <td>{{ $followup->client->address }}</td>
                                </tr>
                                <tr>
                                    <th>Activity Date</th>
                                    <td>{{ $followup->activity_date }}</td>
                                    <th>Time of Work Started</th>
                                    <td>{{ $followup->work_start_time }}</td>
                                </tr>
                                <tr>
                                    <th>Time of Work Ended</th>
                                    <td>{{ $followup->work_end_time }}</td>
                                    <th>Nature of Work</th>
                                    <td>{{ $followup->work_nature_type }}</td>
                                </tr>
                                <tr>
                                    <th>Types of Sales Call</th>
                                    <td>{{ $followup->sales_type }}</td>
                                    <th>Potentility Amount</th>
                                    <td>{{ $followup->potentility_amount }}</td>
                                </tr>
                                <tr>
                                    <th>Meeting Outcome</th>
                                    <td colspan="3" class="text-left">{{ $followup->meeting_outcome }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @if ($followup->clientQuestion)
                        <div class="col-md-12">
                            <h5 class="text-center">Client Questions</h5>
                            <hr>
                            <div class="table-responsive">
                                <table class="table custom_table table-bordered" style="font-size: 12px;">
                                    <tr>
                                        <th class="text-left">1. Reason Behind Client switching ISP ?
                                        </th>
                                        <td>
                                            {{ $followup->clientQuestion->reason_of_switching }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">2. Is there any LAN issue on client site ? </th>
                                        <td>
                                            {{ $followup->clientQuestion->lan_issue }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">3.What devices client at present have ?</th>
                                        <td>
                                            @php $devices = json_decode($followup->clientQuestion->device)  @endphp
                                            @foreach ($devices as $index => $device)
                                                {{ $device }}
                                                @if ($index !== count($devices) - 1)
                                                    {{ ',' }}
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">4. Client devices capable to handle requested bandwidth ?
                                        </th>
                                        <td>
                                            {{ $followup->clientQuestion->capability_of_bandwidth }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">5. Any additional devices connected with LAN ?</th>
                                        <td>
                                            {{ $followup->clientQuestion->device_connected_with_lan }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">6. Does client use licensed Windows / Antivirus ?</th>
                                        <td>
                                            {{ $followup->clientQuestion->license_of_antivirus }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">7. Does client have any designated IT Personnel available at
                                            client site ?</th>
                                        <td>
                                            {{ $followup->clientQuestion->client_site_it_person }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">8. Does client have any own mail domain ?</th>
                                        <td>
                                            {{ $followup->clientQuestion->mail_domain }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">9. Client have any Virtual Private Network (VPN) requirement ?
                                        </th>
                                        <td>
                                            {{ $followup->clientQuestion->vpn_requirement }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">10. Client have any Video Conferencing (VC) requirement ?</th>
                                        <td>
                                            {{ $followup->clientQuestion->video_conferencing }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">11. Client have any IPTSP Service Usage ?</th>
                                        <td>
                                            {{ $followup->clientQuestion->iptsp_service_usage }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">12. Does client use any software usage such as ERP / Tally etc
                                            ?
                                        </th>
                                        <td>
                                            {{ $followup->clientQuestion->software_usage }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">13. Any specific destination client shares their data with?
                                            (e.g:
                                            China / India
                                            etc.)</th>
                                        <td>
                                            {{ $followup->clientQuestion->specific_destination }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">14. Does client want 99-100% uptime clause applicable in their
                                            SLA ?</th>
                                        <td>
                                            {{ $followup->clientQuestion->uptime_capable_sla }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">15. Present ISP providing redundant connectivity ?</th>
                                        <td>
                                            {{ $followup->clientQuestion->isp_providing }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    @endsection

    @section('script')
        <script src=" {{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script>
            $(window).scroll(function() {
                //set scroll position in session storage
                sessionStorage.scrollPos = $(window).scrollTop();
            });
            var init = function() {
                //get scroll position in session storage
                $(window).scrollTop(sessionStorage.scrollPos || 0)
            };
            window.onload = init;

            $(document).ready(function() {
                $('#dataTable').DataTable({
                    stateSave: true
                });
            });
        </script>
    @endsection
