<div class="pcoded-navigation-label text-uppercase bg-primary">Sales</div>
<ul class="pcoded-item pcoded-left-item">
    {{-- @hasanyrole('super-admin|admin') --}}
    <li class="pcoded-hasmenu {{ request()->routeIs(['cs.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
            <span class="pcoded-mtext">Client</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('cs.create') ? 'active' : null }}">
                <a href="{{ route('cs.create') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">Create New</span><span class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('cs.index') ? 'active' : null }}">
                <a href="{{ route('cs.index') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
    {{-- @endhasanyrole --}}
</ul>