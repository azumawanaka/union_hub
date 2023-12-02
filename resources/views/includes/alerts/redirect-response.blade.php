@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>Success!</strong> {{ session('success') }}
    </div>

@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>Error!</strong> {{ session('error') }}
    </div>
@endif
