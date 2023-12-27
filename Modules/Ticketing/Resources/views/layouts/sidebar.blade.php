{{-- Ticketing and Support --}}
<div class="pcoded-navigation-label text-uppercase bg-primary">Support & Ticketing</div>
<ul class="pcoded-item pcoded-left-item">
    <li class="{{ request()->routeIs('ticketing-dashboard') ? 'active' : null }}">
        <a href="{{ route('ticketing-dashboard') }}">
            <span class="pr-2 pt-1 w-25px d-inline-block"><i class="fas fa-tachometer-alt"></i></span>
            <span class="pcoded-mtext">Dashboard</span>
        </a>
    </li>
    @can('ticket-create')
    <li class="{{ request()->routeIs('support-tickets.create') ? 'active' : null }}">
        <a href="{{ route('support-tickets.create') }}">
            <span class="pr-2 pt-1 w-25px d-inline-block"><i class="fa fa-ticket-alt"></i></span>
            <span class="pcoded-mtext">New Ticket</span>
        </a>
    </li>
    @endcan
    @can('ticket-index')
    <li class="{{ request()->routeIs('support-tickets.index') ? 'active' : null }}">
        <a href="{{ route('support-tickets.index') }}">
            <span class="pr-2 pt-1 w-25px d-inline-block"><i class="fas fa-clipboard-list"></i></span>
            <span class="pcoded-mtext">Ticket List</span>
        </a>
    </li>
    @endcan
    <li class="{{ request()->routeIs('repeated-ticket-client-list') ? 'active' : null }}">
        <a href="{{ route('repeated-ticket-client-list') }}">
            <span class="pr-2 pt-1 w-25px d-inline-block"><i class="fas fa-clipboard-list"></i></span>
            <span class="pcoded-mtext">Repeated Ticket Client List</span>
        </a>
    </li>
    @can('feedback-list')
    <li class="{{ request()->routeIs('feedback-list') ? 'active' : null }}">
        <a href="{{ route('feedback-list') }}">
            <span class="pr-2 pt-1 w-25px d-inline-block"><i class="far fa-comments"></i></span>
            <span class="pcoded-mtext">Client Feedbacks</span>
        </a>
    </li>
    @endcan
    @can('internal-feedback')
        <li class="{{ request()->routeIs('internal-feedback') ? 'active' : null }}">
            <a href="{{ route('internal-feedback') }}">
                <span class="pr-2 pt-1 w-25px d-inline-block"><i class="far fa-comments"></i></span>
                <span class="pcoded-mtext">Internal Feedbacks</span>
            </a>
        </li>
    @endcan
    @can('forwarded-ticket-index')
    <li class="{{ request()->routeIs('forwarded-tickets') ? 'active' : null }}">
        <a href="{{ route('forwarded-tickets') }}">
            <span class="pr-2 pt-1 w-25px d-inline-block"><i class="fas fa-fast-forward"></i></span>
            <span class="pcoded-mtext">Forwarded Ticket List</span>
        </a>
    </li>
    @endcan
    @can('backwarded-ticket-index')
    <li class="{{ request()->routeIs('backwarded-tickets') ? 'active' : null }}">
        <a href="{{ route('backwarded-tickets') }}">
            <span class="pr-2 pt-1 w-25px d-inline-block"><i class="far fa-share-square"></i></span>
            <span class="pcoded-mtext">Backwarded Ticket List</span>
        </a>
    </li>
    @endcan
    @can('support-ticket-handover')
    <li class="{{ request()->routeIs('handovered-tickets') ? 'active' : null }}">
        <a href="{{ route('handovered-tickets') }}">
            <span class="pr-2 pt-1 w-25px d-inline-block"><i class="fas fa-hands-helping"></i></span>
            <span class="pcoded-mtext">Handovered Ticket List</span>
        </a>
    </li>
    @endcan
    @can('bulk-email-send')
    <li class="{{ request()->routeIs('bulk-email') ? 'active' : null }}">
        <a href="{{ route('bulk-email') }}">
            <span class="pr-2 pt-1 w-25px d-inline-block"><i class="fas fa-mail-bulk"></i></span>
            <span class="pcoded-mtext">Bulk Email</span>
        </a>
    </li>
    @endcan
    @can('support-team-index')
    <li class="{{ request()->routeIs('support-teams.index') ? 'active' : null }}">
        <a href="{{ route('support-teams.index') }}">
            <span class="pr-2 pt-1 w-25px d-inline-block"><i class="fas fa-users"></i></span>
            <span class="pcoded-mtext">Support Teams</span>
        </a>
    </li>
    @endcan
    @can('support-complain-type-index')
    <li class="{{ request()->routeIs('support-complain-types.index') ? 'active' : null }}">
        <a href="{{ route('support-complain-types.index') }}">
            <span class="pr-2 pt-1 w-25px d-inline-block"><i class="fas fa-chalkboard-teacher"></i></span>
            <span class="pcoded-mtext">Complain Types</span>
        </a>
    </li>
    @endcan
    @can('support-solution-index')
    <li class="{{ request()->routeIs('support-solutions.index') ? 'active' : null }}">
        <a href="{{ route('support-solutions.index') }}">
            <span class="pr-2 pt-1 w-25px d-inline-block"><i class="fas fa-user-md"></i></span>
            <span class="pcoded-mtext">Support Solutions</span>
        </a>
    </li>
    @endcan
    @can('support-complain-source-index')
    <li class="{{ request()->routeIs('complain-sources.index') ? 'active' : null }}">
        <a href="{{ route('complain-sources.index') }}">
            <span class="pr-2 pt-1 w-25px d-inline-block"><i class="fas fa-tty"></i></span>
            <span class="pcoded-mtext">Complain Source</span>
        </a>
    </li>
    @endcan
    @can('support-ticket-reports')
    <li class="{{ request()->routeIs('report-index') ? 'active' : null }}">
        <a href="{{ route('report-index') }}">
            <span class="pr-2 pt-1 w-25px d-inline-block"><i class="fas fa-briefcase"></i></span>
            <span class="pcoded-mtext">Reports</span>
        </a>
    </li>
    @endcan
    @can('support-ticket-downtime-report')
    <li class="{{ request()->routeIs('downtime-report-index') ? 'active' : null }}">
        <a href="{{ route('downtime-report-index') }}">
            <span class="pr-2 pt-1 w-25px d-inline-block"><i class="fas fa-network-wired"></i></span>
            <span class="pcoded-mtext">Downtime Report</span>
        </a>
    </li>
    @endcan
</ul>
