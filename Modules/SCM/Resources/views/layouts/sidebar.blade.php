<div class="pcoded-navigation-label text-uppercase bg-primary">Supply Chain</div>
<ul class="pcoded-item pcoded-left-item">
    {{-- @hasanyrole('super-admin|admin') --}}
    <li class="pcoded-hasmenu {{ request()->routeIs(['units.*', 'materials.*', 'suppliers.*', 'couriers.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
            <span class="pcoded-mtext">Configurations</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('units.*') ? 'active' : null }}">
                <a href="{{ route('units.index') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">Units</span><span class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('materials.*') ? 'active' : null }}">
                <a href="{{ route('materials.index') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">Materials</span><span class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('suppliers.*') ? 'active' : null }}">
                <a href="{{ route('suppliers.index') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">Suppliers</span><span class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('couriers.*') ? 'active' : null }}">
                <a href="{{ route('couriers.create') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">Couriers</span><span class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>

    <li class="pcoded-hasmenu {{ request()->routeIs(['requisitions.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
            <span class="pcoded-mtext">Requisition</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('requisitions.create') ? 'active' : null }}">
                <a href="{{ route('requisitions.create') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('requisitions.index') ? 'active' : null }}">
                <a href="{{ route('requisitions.index') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>

    <li class="pcoded-hasmenu {{ request()->routeIs(['purchase-requisitions.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
            <span class="pcoded-mtext">Purchase Requisition</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('purchase-requisitions.create') ? 'active' : null }}">
                <a href="{{ route('purchase-requisitions.create') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('purchase-requisitions.index') ? 'active' : null }}">
                <a href="{{ route('purchase-requisitions.index') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>

    <li class="pcoded-hasmenu {{ request()->routeIs(['cs.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-panel"></i></span>
            <span class="pcoded-mtext">CS</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('cs.create') ? 'active' : null }}">
                <a href="{{ route('cs.create') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('cs.index') ? 'active' : null }}">
                <a href="{{ route('cs.index') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>

    <li class="pcoded-hasmenu {{ request()->routeIs(['indents.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
            <span class="pcoded-mtext">Indents</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('indents.create') ? 'active' : null }}">
                <a href="{{ route('indents.create') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('indents.index') ? 'active' : null }}">
                <a href="{{ route('indents.index') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>

    <li class="pcoded-hasmenu {{ request()->routeIs(['purchase-orders.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
            <span class="pcoded-mtext">Purchase Orders</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('purchase-orders.create') ? 'active' : null }}">
                <a href="{{ route('purchase-orders.create') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('purchase-orders.index') ? 'active' : null }}">
                <a href="{{ route('purchase-orders.index') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ request()->routeIs(['material-receives.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
            <span class="pcoded-mtext">Material Receive</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('material-receives.create') ? 'active' : null }}">
                <a href="{{ route('material-receives.create') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('material-receives.index') ? 'active' : null }}">
                <a href="{{ route('material-receives.index') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ request()->routeIs(['material-issues.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
            <span class="pcoded-mtext">Material Issue</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('material-issues.create') ? 'active' : null }}">
                <a href="{{ route('material-issues.create') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('material-issues.index') ? 'active' : null }}">
                <a href="{{ route('material-issues.index') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
    {{-- @endhasanyrole --}}
</ul>