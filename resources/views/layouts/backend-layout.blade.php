@include('elements.header')
{{--@include('elements.sidebar-chat')--}}
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        @include('elements.sidebar')
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- Main-body start -->
                <div class="main-body">
                    <div class="page-wrapper p-1">
                        <div class="page-body">
                            <div class="row">
                                <div class="@yield('content-grid', 'col-sm-12')">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row px-1 d-flex align-items-end">
                                                <div class="col-7">
                                                    <h4 class="">@yield('breadcrumb-title')</h4>
                                                </div>
                                                <div class="col-5">
                                                    <div class="float-right">
                                                        @yield('breadcrumb-button')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <h4 class="sub-title">
                                                @yield('sub-title')
                                            </h4>
                                            @include('elements.flash-message')
                                            @yield('content')
                                            
                                        </div> <!-- end card-block -->
                                    </div> <!-- end card -->
                                </div> <!-- end col-sm-12  -->
                            </div> <!-- end row -->
                            @yield('card')
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