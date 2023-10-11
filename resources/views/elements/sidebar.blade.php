<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <ul class="pcoded-item pcoded-left-item">
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
                </ul>
            </li>
            <li
                class="pcoded-hasmenu {{ request()->routeIs(['branches.*', 'apsections.*', 'teams.*', 'departments.*', 'designations.*', 'employees.*', 'sellCollectionHeads.*', 'services.*']) ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-settings"></i><b>P</b></span>
                    <span class="pcoded-mtext">Configurations</span>
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
                        <a href="{{ route('dataencoding.employees.index') }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Employee </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
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
                    <li class="{{ request()->routeIs('particulars.*') ? 'active' : null }}">
                        <a href="{{ route('particulars.create') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Particulars</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li class="{{ request()->routeIs('connectivity.*') ? 'active' : null }}">
                        <a href="{{ route('connectivity.create') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Add Link</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li class="{{ request()->routeIs('connectivity.*') ? 'active' : null }}">
                        <a href="{{ route('connectivity.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Link List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li class="{{ request()->routeIs('services.*') ? 'active' : null }}">
                        <a href="{{ route('services.create') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Services</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                </ul>
            </li>
        </ul>
        @can('sales')
            @include('sales::layouts.sidebar')
        @endcan
        @can('support-and-ticketing')
            @include('ticketing::layouts.sidebar')
        @endcan
        @can('networking')
            @include('networking::layouts.sidebar')
        @endcan
        @can('supply-chain')
            @include('scm::layouts.sidebar')
        @endcan
        @can('billing')
            @include('billing::layouts.sidebar')
        @endcan
        <div class="p-5"></div>
    </div>
</nav>
