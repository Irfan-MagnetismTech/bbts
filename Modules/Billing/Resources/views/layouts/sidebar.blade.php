<div class="pcoded-navigation-label text-uppercase bg-primary">Billing</div>
<ul class="pcoded-item pcoded-left-item">
    <li class="pcoded-hasmenu {{ request()->routeIs(['otc-bills.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
            <span class="pcoded-mtext">OTC Bill</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('otc-bills.index') ? 'active' : null }}">
                <a href="{{ route('otc-bills.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ request()->routeIs(['monthly-bills.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
            <span class="pcoded-mtext">Monthly Bill</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('monthly-bills.create') ? 'active' : null }}">
                <a href="{{ route('monthly-bills.create') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Create</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('monthly-bills.index') ? 'active' : null }}">
                <a href="{{ route('monthly-bills.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ request()->routeIs(['broken-days-bills.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
            <span class="pcoded-mtext">Broken Days Bill</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('broken-days-bills.create') ? 'active' : null }}">
                <a href="{{ route('broken-days-bills.create') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Create</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ request()->routeIs(['bill-generate.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
            <span class="pcoded-mtext">Bill Generate</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('bill-generate.index') ? 'active' : null }}">
                <a href="{{ route('bill-generate.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ request()->routeIs(['collections.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
            <span class="pcoded-mtext">Bill Collection</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('collections.create') ? 'active' : null }}">
                <a href="{{ route('collections.create') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Create</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('collections.index') ? 'active' : null }}">
                <a href="{{ route('collections.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
</ul>
