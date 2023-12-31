
<a href="javascript:void(0)" data-toggle="dropdown">
    <i class="mdi mdi-bell-outline"></i>
    <span class="badge badge-pill gradient-2 badge-primary">{{ $notifications->get()->count() }}</span>
</a>
<div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
    <div class="dropdown-content-heading d-flex justify-content-between">
        <span class="">Notifications</span>
    </div>
    <div class="dropdown-content-body">
        <ul>
            @foreach ($notifications->limit(3)->get() as $notif)
                <li>
                    <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-bell"></i></span>
                    <div class="notification-content">
                        <h6 class="notification-heading">{{ $notif->message }}</h6>
                        <span class="notification-text">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                </li>
            @endforeach
            <li class="py-2"><a href="{{ route('notifications.index') }}" class="btn btn-block btn-primary btn-sm text-center">See All Notifications</a></li>
        </ul>

    </div>
</div>
