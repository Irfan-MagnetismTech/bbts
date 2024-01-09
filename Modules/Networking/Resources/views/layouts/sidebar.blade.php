@can('infrastructure-module')
    <div class="pcoded-navigation-label text-uppercase bg-primary">Infrastructure</div>
    <ul class="pcoded-item pcoded-left-item">
        @can('pop-view')
            <li class="pcoded-hasmenu {{ request()->routeIs(['pops.*']) ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
                    <span class="pcoded-mtext">Pops</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('pops.create') ? 'active' : null }}">
                        <a href="{{ route('pops.create') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Add New Pop</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                </ul>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('pops.index', 'pops.show', 'pops.edit') ? 'active' : null }}">
                        <a href="{{ route('pops.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Pops List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                </ul>
            </li>
        @endcan
        @can('transmission-link')
            <li
                class="pcoded-hasmenu {{ request()->routeIs(['connectivity.*', 'get_connectivity_link_log']) ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-signal"></i><b>D</b></span>
                    <span class="pcoded-mtext">Transmission Link</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('connectivity.create') ? 'active' : null }}">
                        <a href="{{ route('connectivity.create') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Add New Link</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                </ul>
                <ul class="pcoded-submenu">
                    <li
                        class="{{ request()->routeIs('connectivity.index', 'connectivity.edit', 'get_connectivity_link_log') ? 'active' : null }}">
                        <a href="{{ route('connectivity.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext"> Link List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                </ul>
            </li>
            </li>
        @endcan

        @can('vas-service-view')
            <li class="pcoded-hasmenu {{ request()->routeIs(['vas-services.*']) ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-toolbox"></i><b>D</b></span>
                    <span class="pcoded-mtext">Vas Service</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('vas-services.create') ? 'active' : null }}">
                        <a href="{{ route('vas-services.create') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li class="{{ request()->routeIs('vas-services.index', 'vas-services.edit') ? 'active' : null }}">
                        <a href="{{ route('vas-services.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                </ul>
            </li>
        @endcan
        @can('activation-process')
            <li class="pcoded-submenu {{ request()->routeIs(['cc-schedules.*']) ? 'active pcoded-trigger' : null }}">
                <a href="{{ route('cc-schedules.index') }}">
                    <span class="pcoded-micon"><i class="fas fa-key"></i><b>D</b></span>
                    <span>Activition Proccess</span>
                </a>
            </li>
        @endcan
    </ul>
@endcan
<div class="pcoded-navigation-label text-uppercase bg-primary">Networking</div>
<ul class="pcoded-item pcoded-left-item">
    @can('network-configuration')
        <li class="pcoded-hasmenu {{ request()->routeIs(['ips.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-cog"></i><b>D</b></span>
                <span class="pcoded-mtext">Configurations</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('ips.*') ? 'active' : null }}">
                    <a href="{{ route('ips.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">IP List</span></span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
            {{--            <ul class="pcoded-submenu"> --}}
            {{--                <li class="{{ request()->routeIs('vas-services.*') ? 'active' : null }}"> --}}
            {{--                    <a href="{{ route('vas-services.index') }}"> <span class="pcoded-micon"><i --}}
            {{--                                class="ti-angle-right"></i></span><span class="pcoded-mtext">VAS Services</span><span --}}
            {{--                            class="pcoded-mcaret"></span></a> --}}
            {{--                </li> --}}
            {{--            </ul> --}}
        </li>
    @endcan
    {{-- @hasanyrole('super-admin|admin') --}}
    @can('pop-equipment-view')
        <li class="pcoded-hasmenu {{ request()->routeIs(['pop-equipments.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-boxes"></i><b>D</b></span>
                <span class="pcoded-mtext">Pop Wise Equipment</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('pop-equipments.create') ? 'active' : null }}">
                    <a href="{{ route('pop-equipments.create') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li
                    class="{{ request()->routeIs('pop-equipments.index', 'pop-equipments.show', 'pop-equipments.edit') ? 'active' : null }}">
                    <a href="{{ route('pop-equipments.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan
    @can('service-requisitions-view')
        <li class="pcoded-hasmenu {{ request()->routeIs(['service-requisitions.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-handshake"></i><b>D</b></span>
                <span class="pcoded-mtext">Service Requisition</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('service-requisitions.create') ? 'active' : null }}">
                    <a href="{{ route('service-requisitions.create') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li
                    class="{{ request()->routeIs('service-requisitions.index', 'service-requisitions.edit') ? 'active' : null }}">
                    <a href="{{ route('service-requisitions.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan

    @can('connectivities')
        <li class="pcoded-submenu {{ request()->routeIs(['connectivities.*']) ? 'active pcoded-trigger' : null }}">
            <a href="{{ route('connectivities.index') }}">
                <span class="pcoded-micon"><i class="fas fa-link"></i><b>D</b></span>
                <span>Connectivities</span>
            </a>
        </li>
    @endcan

    @can('physical-connectivity-view')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['physical-connectivities.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-network-wired"></i><b>D</b></span>
                <span class="pcoded-mtext">Physical Connectivity</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                {{-- <li class="{{ request()->routeIs('physical-connectivities.create') ? 'active' : null }}">
                <a href="{{ route('physical-connectivities.create') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                        class="pcoded-mcaret"></span></a>
            </li> --}}
                <li
                    class="{{ request()->routeIs('physical-connectivities.index', 'physical-connectivities.edit') ? 'active' : null }}">
                    <a href="{{ route('physical-connectivities.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan

    @can('logical-connectivity-view')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['logical-connectivities.*', 'logical-internet-connectivities.edit']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-laptop-code"></i><b>D</b></span>
                <span class="pcoded-mtext">Logical Connectivity</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li
                    class="{{ request()->routeIs('logical-connectivities.index', 'logical-internet-connectivities.edit') ? 'active' : null }}">
                    <a href="{{ route('logical-connectivities.index') }}">
                        <span class="pcoded-micon">
                            <i class="ti-angle-right"></i>
                        </span>
                        <span class="pcoded-mtext">Logical Connectivity List</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                {{-- <li class="{{ request()->routeIs('logical-internet-connectivities.create') ? 'active' : null }}">
                <a href="{{ route('logical-internet-connectivities.index') }}">
                    <span class="pcoded-micon">
                        <i class="ti-angle-right"></i>
                    </span>
                    <span class="pcoded-mtext">Internet Services</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ request()->routeIs('logical-vas-connectivities.create') ? 'active' : null }}">
                <a href="{{ route('logical-vas-connectivities.index') }}">
                    <span class="pcoded-micon">
                        <i class="ti-angle-right"></i>
                    </span>
                    <span class="pcoded-mtext">Vas Services</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li> --}}
            </ul>
        </li>
    @endcan

    {{-- <li class="pcoded-submenu {{ request()->routeIs(['cc-schedules.*']) ? 'active pcoded-trigger' : null }}">
        <a href="{{ route('cc-schedules.index') }}">
            <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
            <span>Client Schedules</span>
        </a>
    </li> --}}
    @can('fiber-management-view')
        <li class="pcoded-hasmenu {{ request()->routeIs(['fiber-managements.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-external-link-square-alt"></i><b>D</b></span>
                <span class="pcoded-mtext">Fiber</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('fiber-managements.create') ? 'active' : null }}">
                    <a href="{{ route('fiber-managements.create') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li
                    class="{{ request()->routeIs('fiber-managements.index', 'fiber-managements.edit') ? 'active' : null }}">
                    <a href="{{ route('fiber-managements.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan
    @can('networking-report-view')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['active-clients-report', 'pop-wise-equipment-report', 'pop-wise-client-report', 'ip-report', 'vlan-report', 'client-wise-equipment-report', 'client-wise-net-ip-report']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-file-pdf"></i><b>D</b></span>
                <span class="pcoded-mtext">Report</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('active-clients-report') ? 'active' : null }}">
                    <a href="{{ route('active-clients-report') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">Active Clients</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('pop-wise-equipment-report') ? 'active' : null }}">
                    <a href="{{ route('pop-wise-equipment-report') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">Pop wise equipment
                            report</span><span class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('pop-wise-client-report') ? 'active' : null }}">
                    <a href="{{ route('pop-wise-client-report') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">Pop wise client
                            report</span><span class="pcoded-mcaret"></span></a>
                <li class="{{ request()->routeIs('client-wise-equipment-report') ? 'active' : null }}">
                    <a href="{{ route('client-wise-equipment-report') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">Client wise equipment
                            report</span><span class="pcoded-mcaret"></span></a>

                </li>
                <li class="{{ request()->routeIs('client-wise-net-ip-report') ? 'active' : null }}">
                    <a href="{{ route('client-wise-net-ip-report') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">Client wise Net-IP
                            report</span><span class="pcoded-mcaret"></span></a>

                </li>
                {{--                <li class="{{ request()->routeIs('work-order-receives.index') ? 'active' : null }}"> --}}
                {{--                    <a href="{{ route('work-order-receives.index') }}"> <span class="pcoded-micon"><i --}}
                {{--                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span --}}
                {{--                            class="pcoded-mcaret"></span></a> --}}
                {{--                </li> --}}
                <li class="{{ request()->routeIs('ip-report') ? 'active' : null }}">
                    <a href="{{ route('ip-report') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">IP Report</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('vlan-report') ? 'active' : null }}">
                    <a href="{{ route('vlan-report') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">VLAN Report</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan
</ul>
