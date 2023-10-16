<div class="pcoded-navigation-label text-uppercase bg-primary">Infrastructure</div>
    <ul class="pcoded-item pcoded-left-item">
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
                <li class="{{ request()->routeIs('pops.index') ? 'active' : null }}">
                    <a href="{{ route('pops.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">Pops List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
        <li class="pcoded-hasmenu {{ request()->routeIs(['connectivity.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
                <span class="pcoded-mtext">Connectivity</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('connectivity.create') ? 'active' : null }}">
                    <a href="{{ route('connectivity.create') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">Add New Links</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('connectivity.index') ? 'active' : null }}">
                    <a href="{{ route('connectivity.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">Connectivity List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
        <li class="pcoded-hasmenu {{ request()->routeIs(['vas-services.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
                <span class="pcoded-mtext">Vas Service</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('vas-services.create') ? 'active' : null }}">
                    <a href="{{ route('vas-services.create') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('vas-services.index') ? 'active' : null }}">
                    <a href="{{ route('vas-services.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
        <li class="pcoded-submenu {{ request()->routeIs(['cc-schedules.*']) ? 'active pcoded-trigger' : null }}">
            <a href="{{ route('cc-schedules.index') }}">
                <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
                <span>Activition Proccess</span>
            </a>
        </li>
    </ul>
<div class="pcoded-navigation-label text-uppercase bg-primary">Networking</div>
<ul class="pcoded-item pcoded-left-item">

    <li
        class="pcoded-hasmenu {{ request()->routeIs(['units.*', 'materials.*', 'suppliers.*', 'couriers.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
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
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('vas-services.*') ? 'active' : null }}">
                <a href="{{ route('vas-services.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">VAS Services</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
    {{-- @hasanyrole('super-admin|admin') --}}
    <li class="pcoded-hasmenu {{ request()->routeIs(['pop-equipments.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
            <span class="pcoded-mtext">Pop Wise Equipment</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('pop-equipments.create') ? 'active' : null }}">
                <a href="{{ route('pop-equipments.create') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('pop-equipments.index') ? 'active' : null }}">
                <a href="{{ route('pop-equipments.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ request()->routeIs(['service-requisitions.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
            <span class="pcoded-mtext">Service Requisition</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('service-requisitions.create') ? 'active' : null }}">
                <a href="{{ route('service-requisitions.create') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('service-requisitions.index') ? 'active' : null }}">
                <a href="{{ route('service-requisitions.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>

    <li class="pcoded-submenu {{ request()->routeIs(['connectivities.*']) ? 'active pcoded-trigger' : null }}">
        <a href="{{ route('connectivities.index') }}">
            <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
            <span>Connectivities</span>
        </a>
    </li>

    <li
        class="pcoded-hasmenu {{ request()->routeIs(['physical-connectivities.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
            <span class="pcoded-mtext">Physical Connectivity</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            {{-- <li class="{{ request()->routeIs('physical-connectivities.create') ? 'active' : null }}">
                <a href="{{ route('physical-connectivities.create') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                        class="pcoded-mcaret"></span></a>
            </li> --}}
            <li class="{{ request()->routeIs('physical-connectivities.index') ? 'active' : null }}">
                <a href="{{ route('physical-connectivities.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>

    <li
        class="pcoded-hasmenu {{ request()->routeIs(['logical-data-connectivities.*', 'logical-vas-connectivities.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
            <span class="pcoded-mtext">Logical Connectivity</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('logical-connectivities.create') ? 'active' : null }}">
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

    <li class="pcoded-submenu {{ request()->routeIs(['cc-schedules.*']) ? 'active pcoded-trigger' : null }}">
        <a href="{{ route('cc-schedules.index') }}">
            <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
            <span>Client Schedules</span>
        </a>
    </li>
    <li
        class="pcoded-hasmenu {{ request()->routeIs(['fiber-managements.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
            <span class="pcoded-mtext">Fiber</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('fiber-managements.create') ? 'active' : null }}">
                <a href="{{ route('fiber-managements.create') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('fiber-managements.index') ? 'active' : null }}">
                <a href="{{ route('fiber-managements.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
</ul>
