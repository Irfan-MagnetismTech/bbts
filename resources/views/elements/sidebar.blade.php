<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <ul class="pcoded-item pcoded-left-item">
            {{-- @hasanyrole('super-admin|admin') --}}
            <li
                class="pcoded-hasmenu {{ request()->routeIs(['users.*', 'roles.*', 'permissions.*', 'brands.*', 'branchs.*', 'pops.*']) ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
                    <span class="pcoded-mtext">Control Users</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('users.*') ? 'active' : null }}">
                        <a href="{{ route('users.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">User</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li class="{{ request()->routeIs('roles.*') ? 'active' : null }}">
                        <a href="{{ route('roles.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Role</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li class="{{ request()->routeIs('permissions.*') ? 'active' : null }}">
                        <a href="{{ route('permissions.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Permission</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li class="{{ request()->routeIs('brands.*') ? 'active' : null }}">
                        <a href="{{ route('brands.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Brands</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li class="{{ request()->routeIs('branchs.*') ? 'active' : null }}">
                        <a href="{{ route('branchs.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Branches</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li class="{{ request()->routeIs('pops.*') ? 'active' : null }}">
                        <a href="{{ route('pops.create') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">POP</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                </ul>
            </li>
            {{-- @endhasanyrole --}}
            {{-- @endrole --}}
            <li
                class="pcoded-hasmenu {{ request()->routeIs(['branches.*', 'apsections.*', 'teams.*', 'departments.*', 'designations.*', 'employees.*', 'sellCollectionHeads.*']) ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-settings"></i><b>P</b></span>
                    <span class="pcoded-mtext">Configurations</span>
                    {{-- <span class="pcoded-badge label label-warning">NEW</span> --}}
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('dataencoding.departments.*') ? 'active' : null }}">
                        <a href="{{ route('dataencoding.departments.index') }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Departments </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dataencoding.designations.*') ? 'active' : null }}">
                        <a href="{{ route('dataencoding.designations.index') }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Designations </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dataencoding.employees.*') ? 'active' : null }}">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Employee </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    {{--                    <li class="{{ request()->routeIs('departments.*') ? 'active' : null }}"><a href="{{ route('departments.index') }}"><span class="pcoded-micon"><i class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Departments </span><span class="pcoded-mcaret"></span></a></li> --}}
                    {{--                    <li class="{{ request()->routeIs('designations.*') ? 'active' : null }}"><a href="{{ route('designations.index') }}"><span class="pcoded-micon"><i class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Designations </span><span class="pcoded-mcaret"></span></a></li> --}}
                    {{--                    <li class="{{ request()->routeIs('employees.*') ? 'active' : null }}"><a href="{{ route('employees.index') }}"><span class="pcoded-micon"><i class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Employee </span><span class="pcoded-mcaret"></span></a></li> --}}
                    {{-- <li class="{{ request()->routeIs('leayer-name.*') ? 'active' : null }}"><a href="{{ route('leayer-name.index') }}"><span class="pcoded-micon"><i class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Layer Name </span><span class="pcoded-mcaret"></span></a></li> --}}
                </ul>
            </li>
            {{-- @hasanyrole('super-admin|admin') --}}
            <li
                class="pcoded-hasmenu {{ request()->routeIs(['units.*', 'materials.*', 'suppliers.*', 'couriers.*', 'requisitions.*']) ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
                    <span class="pcoded-mtext">SCM</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('units.*') ? 'active' : null }}">
                        <a href="{{ route('units.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Units</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li class="{{ request()->routeIs('materials.*') ? 'active' : null }}">
                        <a href="{{ route('materials.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Materials</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li class="{{ request()->routeIs('suppliers.*') ? 'active' : null }}">
                        <a href="{{ route('suppliers.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Suppliers</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li class="{{ request()->routeIs('couriers.*') ? 'active' : null }}">
                        <a href="{{ route('couriers.create') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Couriers</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li class="{{ request()->routeIs('requisitions.*') ? 'active' : null }}">
                        <a href="{{ route('requisitions.create') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Requisitions</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                </ul>
            </li>
            {{-- @endhasanyrole --}}

            {{-- Ticketing and Support --}}
            <li
                class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-headset"></i><b>D</b></span>
                    <span class="pcoded-mtext">Support & Ticketing</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="">
                        <a href="{{ route('support-tickets.index') }}"> <span class="pr-2"><i class="fa fa-ticket-alt"></i></span><span class="pcoded-mtext">New Ticket</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="p-5"></div>
    </div>
</nav>
