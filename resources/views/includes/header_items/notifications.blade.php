
<a href="javascript:void(0)" data-toggle="dropdown">
    <i class="mdi mdi-bell-outline"></i>
    <span class="badge badge-pill gradient-2 badge-primary">{{ $notifications->count() }}</span>
</a>
<div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
    <div class="dropdown-content-heading d-flex justify-content-between">
        <span class="">Notifications</span>
    </div>
    <div class="dropdown-content-body">
        <ul>
            @foreach ($notifications as $notif)
                <li>
                    <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-bell"></i></span>
                    <div class="notification-content">
                        <h6 class="notification-heading">{{ $notif->message }}</h6>
                        <span class="notification-text">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                </li>
            @endforeach
        </ul>

    </div>
</div>
