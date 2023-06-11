<ul class="pcoded-item pcoded-left-item">
    <li class="{{ request()->routeIs('brands.*') ? 'active' : null }}">
        <a href="{{ route('brands.index') }}"> <span class="pcoded-micon"><i class="ti-angle-right"></i></span><span class="pcoded-mtext">Brands</span><span class="pcoded-mcaret"></span></a>
    </li>
</ul>
