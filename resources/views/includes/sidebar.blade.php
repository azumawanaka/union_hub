<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('dashboard') }}" aria-expanded="false">
                    <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Services</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('services.index') }}">Lists</a></li>
                    <li><a href="{{ route('service_requests.index') }}">Requests</a></li>
                </ul>
            </li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-note menu-icon"></i><span class="nav-text">Events</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('events.index') }}">Lists</a></li>
                    <li><a href="">Participants</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
