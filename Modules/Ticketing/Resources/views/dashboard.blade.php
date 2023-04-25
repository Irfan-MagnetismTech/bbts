@extends('layouts.backend-layout')
@section('title', 'Tickets Downtime Reports')

@section('style')
    <style>
        :root {
            --color-primary-rgba: 88, 64, 255;
            --color-secondary-rgba: 251, 53, 134;
            --color-success-rgba: 1, 184, 26;
            --color-info-rgba: 0, 170, 255;
            --color-warning-rgba: 250, 139, 12;
            --color-danger-rgba: 255, 15, 15;
        }

        .bg-primary-08 {
            background-color: rgba(var(--color-primary-rgba), .08) !important;
        }
        .bg-secondary-08 {
            background-color: rgba(var(--color-secondary-rgba), .08) !important;
        }
        .bg-info-08 {
            background-color: rgba(var(--color-info-rgba), .08) !important;
        }
        .bg-success-08 {
            background-color: rgba(var(--color-success-rgba), .08) !important;
        }

        .bg-secondary {
        background-color: rgba(var(--color-secondary-rgba), .4) !important;
    }

        .ap-po-details__titlebar {
            font-weight: 600;
        }

        .svg-icon {
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
                }
    </style>
@endsection

@section('breadcrumb-title')
    Ticketing Dashboard
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('downtime-report-index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection
@section('sub-title')
    Total Tickets: {{ !empty($supportTickets) ? $supportTickets->count() : 0 }} <br>
@endsection

@section('content')
<form action="" method="get" class="my-4">
    <div class="row">
        
        <div class="col-md-3">
            <div class="form-group">
                <label for="date_from" class="font-weight-bold">From Date:</label>
                <input type="text" class="form-control date" id="date_from" name="date_from" aria-describedby="date_from"
                    value="{{ old('date_from') ?? (request()?->date_from ?? null) }}" readonly>
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
            <div class="form-group my-4 row">
                <div class="col-md-6">
                    <input type="button" onclick="resetForm()" value="Reset" class="btn btn-outline-warning btn-sm col-12">
                </div>
                <div class="col-md-6">
                    <input type="submit" value="Search" class="btn btn-outline-primary btn-sm col-12">
                </div>
            </div>
        </div>
    </div>
</form>
    <div class="row">
        <div class="col-12 col-md-3 my-3 ">
            <div class="card">
                <div class="ap-po-details ap-po-details--2 p-25 rounded d-flex justify-content-between bg-info-08">
                    <div class="overview-content w-100">
                        <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                            <div>
                                <div class="ap-po-details__titlebar">
                                    <p>Open Ticket</p>
                                    <h5>{{ $supportTickets->where('status', '!=', 'Closed')->count() }}</h5>
                                </div>
                            </div>
                            <div class="ap-po-details__icon-area d-flex align-items-center">
                                <div class="svg-icon bg-info color-white rounded-circle">
                                    <i class="fas fa-exclamation fa-2x p-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 my-3 ">
            <div class="card">
                <div class="ap-po-details ap-po-details--2 p-25 rounded d-flex justify-content-between bg-secondary-08">
                    <div class="overview-content w-100">
                        <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                            <div>
                                <div class="ap-po-details__titlebar">
                                    <p>In Progress</p>
                                    <h5>{{ $supportTickets->where('status', 'Processing')->count() }}</h5>
                                </div>
                            </div>
                            <div class="ap-po-details__icon-area d-flex align-items-center">
                                <div class="svg-icon bg-secondary text-white rounded-circle">
                                    <i class="fas fa-tools fa-2x p-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 my-3 ">
            <div class="card">
                <div class="ap-po-details ap-po-details--2 p-25 rounded d-flex justify-content-between bg-success-08">
                    <div class="overview-content w-100">
                        <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                            <div>
                                <div class="ap-po-details__titlebar">
                                    <p>Pending</p>
                                    <h5>{{ $supportTickets->where('status', 'Pending')->count() }}</h5>
                                </div>
                            </div>
                            <div class="ap-po-details__icon-area d-flex align-items-center">
                                <div class="svg-icon bg-success color-white rounded-circle">
                                    <i class="fas fa-hourglass-end fa-2x p-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 my-3 ">
            <div class="card">
                <div class="ap-po-details ap-po-details--2 p-25 rounded d-flex justify-content-between bg-primary-08">
                    <div class="overview-content w-100">
                        <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                            <div>
                                <div class="ap-po-details__titlebar">
                                    <p>Closed Ticket</p>
                                    <h5>{{ $supportTickets->where('status', 'Closed')->count() }}</h5>
                                </div>
                            </div>
                            <div class="ap-po-details__icon-area d-flex align-items-center">
                                <div class="svg-icon bg-primary color-white rounded-circle">
                                    <i class="fas fa-vector-square fa-2x p-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card px-3">
                <h4 class="text-secondary text-center py-3">Ticket Activity <small>({{ \Carbon\Carbon::parse($from)->format('d-M-Y'); }} to {{ \Carbon\Carbon::parse($to)->format('d-M-Y'); }})</small></h4>
                <div id="ticketActivity">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7 card">
            <h4 class="text-info text-center py-3">Recent Activity</h4>
            <div class="p-3">
                <div class="dt-responsive table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Activity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentActivities as $activity)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td class="text-left">Ticket: {{ $activity->ticket->ticket_no }} => {{ $activity->remarks }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card px-3">
                <h4 class="text-secondary text-center py-3">Ticket Sources</h4>
                <div id="ticketSource">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('/js/apexcharts.js') }}"></script>

<script>
          
        var pieChart = {
          series: [
            @foreach($sources as $source)
                {{ $supportTickets->where('ticket_source_id', $source->id)->count() }} @if(!$loop->last) , @endif
            @endforeach
          ],
          chart: {
            width: 400,
            type: 'pie',
            },
          labels: [
                @foreach($sources as $source)
                    '{{ $source->name }}' @if(!$loop->last) , @endif
                @endforeach
          ],
          responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                width: 400
                },
                legend: {
                position: 'bottom'
                }
            }
          }]
        };

        var pieChart = new ApexCharts(document.querySelector("#ticketSource"), pieChart);
        pieChart.render();
      

        @php
            $start_date = \Carbon\Carbon::parse($from);
            $end_date = \Carbon\Carbon::parse($to);
        @endphp

        var lineChart = {
          series: [
            {
                name: "Assigned",
                data: [
                    @while ($start_date->lte($end_date))
                        {{ isset($supportTicketLifeCycles[$start_date->toDateString()]['Accepted']) ? count($supportTicketLifeCycles[$start_date->toDateString()]['Accepted']) : 0}},
                        @php
                            $start_date->addDay();
                        @endphp
                    @endwhile
                ]
            },
            @php
                $start_date = \Carbon\Carbon::parse($from);
                $end_date = \Carbon\Carbon::parse($to);
            @endphp
            {
                name: "Processing",
                data: [
                    @while ($start_date->lte($end_date))
                        {{ isset($supportTicketLifeCycles[$start_date->toDateString()]['Processing']) ? count($supportTicketLifeCycles[$start_date->toDateString()]['Processing']) : 0}},
                        @php
                            $start_date->addDay();
                        @endphp
                    @endwhile
                ]
            },
            @php
                $start_date = \Carbon\Carbon::parse($from);
                $end_date = \Carbon\Carbon::parse($to);
            @endphp
            {
                name: "Pending",
                data: [
                    @while ($start_date->lte($end_date))
                        {{ isset($supportTicketLifeCycles[$start_date->toDateString()]['Pending']) ? count($supportTicketLifeCycles[$start_date->toDateString()]['Pending']) : 0}},
                        @php
                            $start_date->addDay();
                        @endphp
                    @endwhile
                ]
            },
            @php
                $start_date = \Carbon\Carbon::parse($from);
                $end_date = \Carbon\Carbon::parse($to);
            @endphp
            {
                name: "Closed",
                data: [
                    @while ($start_date->lte($end_date))
                        {{ isset($supportTicketLifeCycles[$start_date->toDateString()]['Closed']) ? count($supportTicketLifeCycles[$start_date->toDateString()]['Closed']) : 0}},
                        @php
                            $start_date->addDay();
                        @endphp
                    @endwhile
                ]
            },
            @php
                $start_date = \Carbon\Carbon::parse($from);
                $end_date = \Carbon\Carbon::parse($to);
            @endphp
            {
                name: "Opened",
                data: [
                    @while ($start_date->lte($end_date))
                        {{ isset($supportTicketLifeCycles[$start_date->toDateString()]['Pending']) ? count($supportTicketLifeCycles[$start_date->toDateString()]['Pending']) : 0}},
                        @php
                            $start_date->addDay();
                        @endphp
                    @endwhile
                ]
            }  
          ],
          chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            }
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            curve: 'straight'
          },
          title: {
            text: 'Ticket Activities by Month',
            align: 'left'
          },
          grid: {
            row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
          },
          xaxis: {
            categories: [
                @php
                    $start_date = \Carbon\Carbon::parse($from);
                    $end_date = \Carbon\Carbon::parse($to);
                @endphp
                @while ($start_date->lte($end_date))
                    '{{ \Carbon\Carbon::parse($start_date->toDateString())->format("d-M") }}',
                    @php
                        $start_date->addDay();
                    @endphp
                @endwhile
            ],
          }
        };

        var lineChartRender = new ApexCharts(document.querySelector("#ticketActivity"), lineChart);
        lineChartRender.render();
      
      
</script>


<script>
    $(document).ready(function() {
        $('.date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
            });
    })

    function resetForm() {
        $('#date_from').val('');
        $('#date_to').val('');
        $('#ticket_no').val('').trigger( "change" );
        // $('#ticket_no').prop('selectedIndex',0);
    }

</script>
@endsection
