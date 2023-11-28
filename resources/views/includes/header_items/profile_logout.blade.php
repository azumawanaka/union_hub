<div class="user-img c-pointer position-relative"   data-toggle="dropdown">
    <span class="activity active"></span>
    <img src="{{ asset('assets/images/user/sample.png') }}" height="40" width="40" alt="">
</div>
<div class="drop-down dropdown-profile   dropdown-menu">
    <div class="dropdown-content-body">
        <ul>
            <li>
                <a href="#profile"><i class="icon-user"></i> <span>Profile</span></a>
            </li>

            <hr class="my-2">
            <li>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="icon-key"></i> <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
