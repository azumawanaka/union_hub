<form method="GET" action="{{ $route }}" class="col-md-3 col-xs-12">
    <div class="input-group icons">
        <div class="input-group-prepend border">
            <span class="input-group-text bg-transparent pl-3 pr-2 pr-sm-3 {{ !is_null(request('q')) ? 'refresh-bar' : '' }}">
                <i class="fa fa-{{ !is_null(request('q')) ? 'refresh' : 'search' }}"></i>
            </span>
        </div>
        <input type="search" class="form-control" name="q" value="{{ request('q') }}" placeholder="Search here...">
    </div>
</form>

@push('scripts')
    <script>
        $(document).ready(function(e) {
            $(document).on('click', '.refresh-bar', function (e) {
                window.location.href = "{{ $route }}";
            });
        });
    </script>
@endpush
