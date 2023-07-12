<div class="pcoded-navigation-label text-uppercase bg-primary">Billing</div>
<ul class="pcoded-item pcoded-left-item">
    <li
        class="pcoded-hasmenu {{ request()->routeIs(['category.*']) || request()->routeIs(['product.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
            <span class="pcoded-mtext">Settings</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            {{-- <li class="{{ request()->routeIs('category.index') ? 'active' : null }}">
                <a href="{{ route('category.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Category</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('product.index') ? 'active' : null }}">
                <a href="{{ route('product.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Product</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('vendor.index') ? 'active' : null }}">
                <a href="{{ route('vendor.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Vendor</span><span
                        class="pcoded-mcaret"></span></a>
            </li> --}}
        </ul>
    </li>
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
</ul>
