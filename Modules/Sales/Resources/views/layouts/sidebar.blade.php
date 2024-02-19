<div class="pcoded-navigation-label text-uppercase bg-primary">Sales</div>
<ul class="pcoded-item pcoded-left-item">
    {{-- @hasanyrole('super-admin|admin') --}}
    @can('sales-configuration')
        @if(auth()->user()->hasRole('Admin'))
        <li class="{{ request()->routeIs('sales-admin-dashboard') ? 'active' : null }}">
            <a href="{{ route('sales-admin-dashboard') }}">
                <span class="pcoded-micon"><i class="fas fa-tachometer-alt"></i><b>D</b></span>
                <span class="pcoded-mtext">Dashboard</span>
                <span class="pcoded-mcaret"></span>
            </a>
        </li>
        @elseif(auth()->user()->hasRole('Salesman'))
        <li class="{{ request()->routeIs('sales-dashboard') ? 'active' : null }}">
            <a href="{{ route('sales-dashboard') }}">
                <span class="pcoded-micon"><i class="fas fa-tachometer-alt"></i><b>D</b></span>
                <span class="pcoded-mtext">Dashboard</span>
                <span class="pcoded-mcaret"></span>
            </a>
        </li>
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['category.*', 'product.*', 'vendor.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-wrench"></i><b>D</b></span>
                <span class="pcoded-mtext">Settings</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                @can('category')
                    <li class="{{ request()->routeIs('category.index') ? 'active' : null }}">
                        <a href="{{ route('category.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Category</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan
                @can('product')
                    <li class="{{ request()->routeIs('product.index') ? 'active' : null }}">
                        <a href="{{ route('product.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Product</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan
                @can('vendor')
                    <li class="{{ request()->routeIs('vendor.index') ? 'active' : null }}">
                        <a href="{{ route('vendor.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Vendor</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan
    @can('lead-generation')
        <li class="pcoded-hasmenu {{ request()->routeIs(['lead-generation.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-medal"></i><b>D</b></span>
                <span class="pcoded-mtext">Lead Generation</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                @can('lead-generation-create')
                    <li class="{{ request()->routeIs('lead-generation.create') ? 'active' : null }}">
                        <a href="{{ route('lead-generation.create') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext"> New Lead</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan
                @can('lead-generation')
                    <li
                        class="{{ request()->routeIs('lead-generation.index', 'lead-generation.show', 'lead-generation.edit') ? 'active' : null }}">
                        <a href="{{ route('lead-generation.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">My Leads</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan
    @can('meeting')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['meeting.*', 'followup.create']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-user-friends"></i><b>D</b></span>
                <span class="pcoded-mtext">Client Meeting</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                @can('client-meeting-create')
                    <li class="{{ request()->routeIs('meeting.create') ? 'active' : null }}">
                        <a href="{{ route('meeting.create') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Create New</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan
                @can('client-meeting-view')
                    <li
                        class="{{ request()->routeIs('meeting.index', 'meeting.show', 'meeting.edit', 'followup.create') ? 'active' : null }}">
                        <a href="{{ route('meeting.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan
    @can('followup')
        <li class="pcoded-hasmenu {{ request()->routeIs(['followup.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-sync"></i><b>D</b></span>
                <span class="pcoded-mtext">Follow Up</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                {{-- <li class="{{ request()->routeIs('followup.create') ? 'active' : null }}">
                <a href="{{ route('followup.create') }}"> <span class="pcoded-micon"><i
                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Create New</span><span
                        class="pcoded-mcaret"></span></a>
            </li> --}}
                @can('followup-list')
                    <li class="{{ request()->routeIs('followup.index', 'followup.show', 'followup.edit') ? 'active' : null }}">
                        <a href="{{ route('followup.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan
    @can('feasibility')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['feasibility-requirement.*', 'add-offer']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-tasks"></i><b>D</b></span>
                <span class="pcoded-mtext">Feasibility Req</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                @can('feasibility-create')
                    <li class="{{ request()->routeIs('feasibility-requirement.create') ? 'active' : null }}">
                        <a href="{{ route('feasibility-requirement.create') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Create New</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan
                @can('feasibility-list')
                    <li
                        class="{{ request()->routeIs('feasibility-requirement.index', 'feasibility-requirement.show', 'feasibility-requirement.edit', 'add-offer') ? 'active' : null }}">
                        <a href="{{ route('feasibility-requirement.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan
    {{-- connectivity requirement --}}
    @can('connectivity-requirement')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['connectivity-requirement.*', 'client-requirement-modification.*', 'add-modified-survey', 'client-plan-modification.create']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-link"></i><b>D</b></span>
                <span class="pcoded-mtext">Connectivity Req</span>
                <span class="pcoded-mcaret"></span>
            </a>
            @can('connectivity-requirement-list')
                <ul class="pcoded-submenu">
                    <li
                        class="{{ request()->routeIs('connectivity-requirement.index', 'connectivity-requirement.show', 'connectivity-requirement.edit') ? 'active' : null }}">
                        <a href="{{ route('connectivity-requirement.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                </ul>
            @endcan

            @can('connectivity-requirement-create')
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('client-requirement-modification.create') ? 'active' : null }}">
                        <a href="{{ url('changes/client-requirement-modification/create') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Modification
                                Requirement</span><span class="pcoded-mcaret"></span></a>
                    </li>
                </ul>
            @endcan
            <ul class="pcoded-submenu">
                <li
                    class="{{ request()->routeIs('client-requirement-modification.index', 'client-requirement-modification.edit', 'add-modified-survey', 'client-plan-modification.create') ? 'active' : null }}">
                    <a href="{{ route('client-requirement-modification.index') }}"> <span class="pcoded-micon"><i
                                class="ti-angle-right"></i></span><span class="pcoded-mtext">Modification List</span><span
                            class="pcoded-mcaret"></span></a>
                </li>
            </ul>
        </li>
    @endcan
    @can('survey')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['survey.*', 'survey-modification.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-poll"></i><b>D</b></span>
                <span class="pcoded-mtext">Survey</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                @can('survey-list')
                    <li class="{{ request()->routeIs('survey.index', 'survey.show', 'survey.edit') ? 'active' : null }}">
                        <a href="{{ route('survey.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan
                @can('modify-survey-list')
                    <li
                        class="{{ request()->routeIs('survey-modification.index', 'survey-modification.edit') ? 'active' : null }}">
                        <a href="{{ route('survey-modification.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Modify List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan
    @can('plan')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['planning.*', 'client-plan-modification.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-calendar-alt"></i><b>D</b></span>
                <span class="pcoded-mtext">Planning</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                @can('plan-list')
                    <li
                        class="{{ request()->routeIs('planning.index', 'planning.show', 'planning.edit') ? 'active' : null }}">
                        <a href="{{ route('planning.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li
                        class="{{ request()->routeIs('client-plan-modification.index', 'client-plan-modification.show', 'client-plan-modification.edit') ? 'active' : null }}">
                        <a href="{{ route('client-plan-modification.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Modification List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan
    @can('cost')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['costing.*', 'modified-costing-list']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-calculator"></i><b>D</b></span>
                <span class="pcoded-mtext">Costing</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                @can('cost-list')
                    <li class="{{ request()->routeIs('costing.index', 'costing.edit', 'costing.show') ? 'active' : null }}">
                        <a href="{{ route('costing.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li class="{{ request()->routeIs('modified-costing-list') ? 'active' : null }}">
                        <a href="{{ route('modified-costing-list') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Modification List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan
    @can('offer')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['offer.*', 'client-offer', 'modified-offer-list', 'client-offer']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-tag"></i><b>D</b></span>
                <span class="pcoded-mtext">Offers</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                @can('offer-list')
                    <li class="{{ request()->routeIs('offer.index', 'offer.edit', 'client-offer') ? 'active' : null }}">
                        <a href="{{ route('offer.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li class="{{ request()->routeIs('modified-offer-list') ? 'active' : null }}">
                        <a href="{{ route('modified-offer-list') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Modification List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan
    @can('client')
        <li class="pcoded-hasmenu {{ request()->routeIs(['client-profile.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
                <span class="pcoded-mtext">Clients</span>
                <span class="pcoded-mcaret"></span>
            </a>
            @can('client-create')
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('client-profile.create') ? 'active' : null }}">
                        <a href="{{ route('client-profile.create') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Add New</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                </ul>
            @endcan
            @can('client-list')
                <ul class="pcoded-submenu">
                    <li
                        class="{{ request()->routeIs('client-profile.index', 'client-profile.show', 'client-profile.edit') ? 'active' : null }}">
                        <a href="{{ route('client-profile.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Client List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                </ul>
            @endcan
        </li>
    @endcan
    @can('sale')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['sales.*', 'modified-sale-list', 'pnl-summary']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-coins"></i><b>D</b></span>
                <span class="pcoded-mtext">Sales</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                @can('sale-create')
                    <li class="{{ request()->routeIs('sales.create') ? 'active' : null }}">
                        <a href="{{ route('sales.create') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">New</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan
                @can('sale-list')
                    <li class="{{ request()->routeIs('sales.index', 'sales.edit', 'pnl-summary') ? 'active' : null }}">
                        <a href="{{ route('sales.index') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                    <li class="{{ request()->routeIs('modified-sale-list') ? 'active' : null }}">
                        <a href="{{ route('modified-sale-list') }}"> <span class="pcoded-micon"><i
                                    class="ti-angle-right"></i></span><span class="pcoded-mtext">Modification List</span><span
                                class="pcoded-mcaret"></span></a>
                    </li>
                @endcan

            </ul>
        </li>
    @endcan
    @can('sales-report')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['plan-report', 'plan-modification-report', 'monthly-sales-summary-report']) ? 'active pcoded-trigger' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="fas fa-file-pdf"></i><b>D</b></span>
                <span class="pcoded-mtext">Report</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->routeIs('plan-report') ? 'active' : '' }}">
                    <a href="{{ route('plan-report') }}">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Plan Report</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('plan-modification-report') ? 'active' : '' }}">
                    <a href="{{ route('plan-modification-report') }}">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Plan Modification Report</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('monthly-sales-summary-report') ? 'active' : '' }}">
                    <a href="{{ route('monthly-sales-summary-report') }}">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Monthly Sales Summary Report</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('account-holder-wise-activation-report') ? 'active' : '' }}">
                    <a href="{{ route('account-holder-wise-activation-report') }}">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Account Holder Wise Report (MSSR)</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('branch-wise-activation-report') ? 'active' : '' }}">
                    <a href="{{ route('branch-wise-activation-report') }}">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Branch Wise Report (MSSR)</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('product-wise-report') ? 'active' : '' }}">
                    <a href="{{ route('product-wise-report') }}">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Product Wise Report</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('account-holder-wise-report') ? 'active' : '' }}">
                    <a href="{{ route('account-holder-wise-report') }}">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Account Holder Wise Report (PWR) </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('branch-wise-report') ? 'active' : '' }}">
                    <a href="{{ route('branch-wise-report') }}">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Branch Wise Report (PWR) </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul>
        </li>
    @endcan
    {{-- @endhasanyrole --}}
</ul>
