@extends('layouts.service')

@section('content')

    @include('pages.admin.services.tables.lists')

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#service_tbl').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            order: [[6, 'desc']]
        });
    });
</script>
@endpush
