{{-- Ticketing and Support --}}
<div class="pcoded-navigation-label text-uppercase bg-primary">Support & Ticketing</div>
<ul class="pcoded-item pcoded-left-item">
    <li class="">
        <a href="{{ route('support-tickets.create') }}">
            <span class="pr-2 w-25px d-inline-block"><i class="fa fa-ticket-alt"></i></span>
            <span class="pcoded-mtext">New Ticket</span>
        </a>
    </li>
    <li class="">
        <a href="{{ route('support-tickets.index') }}">
            <span class="pr-2 w-25px d-inline-block"><i class="fas fa-clipboard-list"></i></span>
            <span class="pcoded-mtext">Ticket List</span>
        </a>
    </li>
    <li class="">
        <a href="{{ route('forwarded-tickets') }}">
            <span class="pr-2 w-25px d-inline-block"><i class="fas fa-fast-forward"></i></span>
            <span class="pcoded-mtext">Forwarded Ticket List</span>
        </a>
    </li>
    <li class="">
        <a href="{{ route('backwarded-tickets') }}">
            <span class="pr-2 w-25px d-inline-block"><i class="far fa-share-square"></i></span>
            <span class="pcoded-mtext">Backwarded Ticket List</span>
        </a>
    </li>
    <li class="">
        <a href="{{ route('bulk-email') }}">
            <span class="pr-2 w-25px d-inline-block"><i class="fas fa-mail-bulk"></i></span>
            <span class="pcoded-mtext">Bulk Email</span>
        </a>
    </li>
    <li class="">
        <a href="{{ route('support-teams.index') }}">
            <span class="pr-2 w-25px d-inline-block"><i class="fas fa-users"></i></span>
            <span class="pcoded-mtext">Support Teams</span>
        </a>
    </li>
    <li class="">
        <a href="{{ route('support-complain-types.index') }}">
            <span class="pr-2 w-25px d-inline-block"><i class="fas fa-chalkboard-teacher"></i></span>
            <span class="pcoded-mtext">Complain Types</span>
        </a>
    </li>
    <li class="">
        <a href="{{ route('support-solutions.index') }}">
            <span class="pr-2 w-25px d-inline-block"><i class="fas fa-user-md"></i></span>
            <span class="pcoded-mtext">Support Solutions</span>
        </a>
    </li>
    <li class="">
        <a href="{{ route('complain-sources.index') }}">
            <span class="pr-2 w-25px d-inline-block"><i class="fas fa-tty"></i></span>
            <span class="pcoded-mtext">Complain Source</span>
        </a>
    </li>
</ul>
