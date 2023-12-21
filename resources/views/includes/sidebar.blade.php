<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('dashboard') }}" aria-expanded="false">
                    <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
            </li>

            @if(auth()->user()->role === 1)
                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Services</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('services.index') }}">Lists</a></li>
                        <li><a href="{{ route('service_requests.index') }}">Requests</a></li>
                        <li><a href="{{ route('clients.index') }}">Clients</a></li>
                    </ul>
                </li>
                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="icon-list menu-icon"></i><span class="nav-text">Events</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('events.index') }}">Events</a></li>
                        <li><a href="{{ route('event-calendar.index') }}">Calendar</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('users.index') }}" aria-expanded="false">
                        <i class="icon-user menu-icon"></i><span class="nav-text">Users</span>
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('event-calendar.index') }}" aria-expanded="false">
                        <i class="fa fa-calendar menu-icon"></i><span class="nav-text">Events</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
