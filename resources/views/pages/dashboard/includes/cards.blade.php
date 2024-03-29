<div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="card gradient-1">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h3 class="card-title text-white">Registered Users</h3>
                    <h2 class="text-white">{{ $total_users }}</h2>
                </div>
                <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card gradient-2">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h3 class="card-title text-white">Events</h3>
                    <h2 class="text-white">{{ $total_events }}</h2>
                </div>
                <span class="float-right display-5 opacity-5"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card gradient-7">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h3 class="card-title text-white">Services</h3>
                    <h2 class="text-white">{{ $total_services }}</h2>
                </div>
                <span class="float-right display-5 opacity-5"><i class="fa fa-globe"></i></span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card gradient-3">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h3 class="card-title text-white">Reports</h3>
                    <h2 class="text-white">{{ $total_reports }}</h2>
                </div>
                <span class="float-right display-5 opacity-5"><i class="fa fa-warning"></i></span>
            </div>
        </div>
    </div>
</div>
