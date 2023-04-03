@section('title', 'Dashboard')

@include('elements.header')
@include('elements.sidebar-chat')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        @include('elements.sidebar')
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- Main-body start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-body">
                            <div class="row">
                                <div class="dt-responsive table-responsive">
                                    <table id="dataTable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#SL</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse(auth()->user()->unreadNotifications as $notification)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td class="text-left">
                                                    <a href="">
                                                        {{ $notification->data['message'] }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($notification->created_at)->format('d/m/Y \a\t H:i a') }}
                                                </td>
                                            </tr>
                                            @if($loop->index > 8)
                                                @php break; @endphp
                                            @endif
                                            @empty
                                            <tr>
                                                <td colspan="3">No notification</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    <table>
                                </div>
                            </div>
                        </div>
                        <!-- Page-body end -->
                    </div>
                    {{--<div id="styleSelector"> </div>--}}
                </div>
            </div>
        </div>
    </div>
</div>
@include('elements.footer')
