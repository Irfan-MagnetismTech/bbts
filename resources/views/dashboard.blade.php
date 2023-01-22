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
