<div class="pcoded-navigation-label text-uppercase bg-primary">Supply Chain</div>
<ul class="pcoded-item pcoded-left-item">
    {{-- @hasanyrole('super-admin|admin') --}}
    <li
        class="pcoded-hasmenu {{ request()->routeIs(['units.*', 'materials.*', 'suppliers.*', 'couriers.*', 'sc-categories.*' ]) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
            <span class="pcoded-mtext">Configurations</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('units.*') ? 'active' : null }}">
                <a href="{{ route('units.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Units</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('sc-categories.*') ? 'active' : null }}">
                <a href="{{ route('sc-categories.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Categories</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('brands.*') ? 'active' : null }}">
                <a href="{{ route('brands.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Brands</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
            @can('material-view')
            <li class="{{ request()->routeIs('materials.*') ? 'active' : null }}">
                <a href="{{ route('materials.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Materials</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
            @endcan
            @can('supplier-view')
            <li class="{{ request()->routeIs('suppliers.*') ? 'active' : null }}">
                <a href="{{ route('suppliers.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Suppliers</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
            @endcan
            <li class="{{ request()->routeIs('couriers.*') ? 'active' : null }}">
                <a href="{{ route('couriers.create') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Couriers</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
    @can('opening-stocks-view')
        <li class="pcoded-hasmenu {{ request()->routeIs(['opening-stocks.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
                <span class="pcoded-mtext">Opening Stock</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('purchase-requisitions.create') ? 'active' : null }}">
                    <a href="{{ route('opening-stocks.create') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('purchase-requisitions.index') ? 'active' : null }}">
                    <a href="{{ route('opening-stocks.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan
    @can('scm-requisition-view')
    <li class="pcoded-hasmenu {{ request()->routeIs(['requisitions.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
            <span class="pcoded-mtext">Requisition</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('requisitions.create') ? 'active' : null }}">
                <a href="{{ route('requisitions.create') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('requisitions.index') ? 'active' : null }}">
                <a href="{{ route('requisitions.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
    @endcan
    @can('scm-prs-view')
    <li class="pcoded-hasmenu {{ request()->routeIs(['purchase-requisitions.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
            <span class="pcoded-mtext">Purchase Requisition</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('purchase-requisitions.create') ? 'active' : null }}">
                <a href="{{ route('purchase-requisitions.create') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('purchase-requisitions.index') ? 'active' : null }}">
                <a href="{{ route('purchase-requisitions.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
    @endcan
    @can('scm-indent-view')
        <li class="pcoded-hasmenu {{ request()->routeIs(['indents.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
                <span class="pcoded-mtext">Indents</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('indents.create') ? 'active' : null }}">
                    <a href="{{ route('indents.create') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('indents.index') ? 'active' : null }}">
                    <a href="{{ route('indents.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan
    @can('scm-comparative-statement-view')
        <li class="pcoded-hasmenu {{ request()->routeIs(['cs.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i></span>
                <span class="pcoded-mtext">CS</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('cs.create') ? 'active' : null }}">
                    <a href="{{ route('cs.create') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('cs.index') ? 'active' : null }}">
                    <a href="{{ route('cs.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan
    @can('scm-purchase-order-view')
        <li class="pcoded-hasmenu {{ request()->routeIs(['purchase-orders.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
                <span class="pcoded-mtext">Purchase Orders</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('purchase-orders.create') ? 'active' : null }}">
                    <a href="{{ route('purchase-orders.create') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('purchase-orders.index') ? 'active' : null }}">
                    <a href="{{ route('purchase-orders.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan
    @can('scm-mrr-view')
    <li class="pcoded-hasmenu {{ request()->routeIs(['material-receives.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
            <span class="pcoded-mtext">Material Receive</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('material-receives.create') ? 'active' : null }}">
                <a href="{{ route('material-receives.create') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('material-receives.index') ? 'active' : null }}">
                <a href="{{ route('material-receives.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
    @endcan
    @can('scm-mir-view')
        <li class="pcoded-hasmenu {{ request()->routeIs(['material-issues.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
                <span class="pcoded-mtext">Material Issue</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('material-issues.create') ? 'active' : null }}">
                    <a href="{{ route('material-issues.create') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('material-issues.index') ? 'active' : null }}">
                    <a href="{{ route('material-issues.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan
    @can('scm-challan-view')
        <li class="pcoded-hasmenu {{ request()->routeIs(['challans.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
                <span class="pcoded-mtext">Challan</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('challans.create') ? 'active' : null }}">
                    <a href="{{ route('challans.create') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('challans.index') ? 'active' : null }}">
                    <a href="{{ route('challans.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan
    @can('scm-gate-pass-view')
        <li class="pcoded-hasmenu {{ request()->routeIs(['gate-passes.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
                <span class="pcoded-mtext">Gate Passes</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('gate-passes.create') ? 'active' : null }}">
                    <a href="{{ route('gate-passes.create') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('gate-passes.index') ? 'active' : null }}">
                    <a href="{{ route('gate-passes.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan
    @can('scm-mur-view')
        <li class="pcoded-hasmenu {{ request()->routeIs(['material-utilizations.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
                <span class="pcoded-mtext">Material Utilization</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">

                <li class="{{ request()->routeIs('material-utilizations.index') ? 'active' : null }}">
                    <a href="{{ route('material-utilizations.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan
    @can('scm-err-view')
        <li class="pcoded-hasmenu {{ request()->routeIs(['errs.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
                <span class="pcoded-mtext">Equipment Restore</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('errs.create') ? 'active' : null }}">
                    <a href="{{ route('errs.create') }}"> <span class="pcoded-micon"><i
                                lass="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('errs.index') ? 'active' : null }}">
                    <a href="{{ route('errs.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan
    @can('scm-wcr-view')
        <li class="pcoded-hasmenu {{ request()->routeIs(['warranty-claims.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
                <span class="pcoded-mtext">Warranty Claim</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('warranty-claims.create') ? 'active' : null }}">
                    <a href="{{ route('warranty-claims.create') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('warranty-claims.index') ? 'active' : null }}">
                    <a href="{{ route('warranty-claims.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan
    @can('scm-wcrr-view')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['warranty-claims-receives.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
                <span class="pcoded-mtext">Warranty Claim Receive</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('warranty-claims-receives.create') ? 'active' : null }}">
                    <a href="{{ route('warranty-claims-receives.create') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('warranty-claims-receives.index') ? 'active' : null }}">
                    <a href="{{ route('warranty-claims-receives.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan
    @can('scm-wor-view')
    <li class="pcoded-hasmenu {{ request()->routeIs(['work-orders.*']) ? 'active pcoded-trigger' : null }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
            <span class="pcoded-mtext">Work Order Receive</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->routeIs('work-order-receives.create') ? 'active' : null }}">
                <a href="{{ route('work-order-receives.create') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
            <li class="{{ request()->routeIs('work-order-receives.index') ? 'active' : null }}">
                <a href="{{ route('work-order-receives.index') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                        class="pcoded-mcaret"></span></a>
            </li>
        </ul>
    </li>
    @endcan
    @can('scm-report-view')
        <li class="pcoded-hasmenu {{ request()->routeIs(['scm-reports.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-file-pdf"></i><b>D</b></span>
                <span class="pcoded-mtext">Report</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('scm-material-stock-report') ? 'active' : null }}">
                    <a href="{{ route('scm-material-stock-report') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">Material Stock Report</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('view-scm-report') ? 'active' : null }}">
                    <a href="{{ route('view-scm-report') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">SCM Report</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('view-scm-item-report') ? 'active' : null }}">
                    <a href="{{ route('view-scm-item-report') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">Item Report</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
                <li class="{{ request()->routeIs('view-product-cost-report') ? 'active' : null }}">
                    <a href="{{ route('view-product-cost-report') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">Product Cost Report</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan
    {{-- @endhasanyrole --}}
</ul>
