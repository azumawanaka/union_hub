<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Service Requests</h4>
                <div class="table-responsive">
                    <table id="service_request_tbl" class="table table-striped table-bordered"></table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('pages.admin.services.modals.delete-confirmation')

@push('scripts')
    <script src="{{ asset('assets/plugins/validation/jquery.validate.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#service_request_tbl').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                ordering: true,
                order: [[5, 'desc']],
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                ajax: {
                    url: 'service_request/all',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    { data: 'sr_id', name: 'service_requests.id', title: 'ID' },
                    { data: 's_name', name: 'services.title', title: 'Service Type' },
                    { data: 'budget', name: 'budget', title: 'Budget' },
                    { data: 'preferred_date', name: 'preferred_date', title: 'Preferred Date' },
                    { data: 'preferred_time', name: 'preferred_time', title: 'Preferred Time' },
                    { data: 'location', name: 'location', title: 'Location' },
                    { data: 'u_name', name: 'users.first_name', title: 'User' },
                    { data: 'sr_status', name: 'service_requests.status', title: 'Status' },
                    { data: 'details', name: 'details', title: 'Details' },
                    { data: 'sr_created_at', name: 'service_requests.created_at', title: 'Created At' },
                    // {
                    //     data: null,
                    //     title: 'Actions',
                    //     render: function (data, type, row) {
                    //         return '<button id="delete_service" class="btn btn-xs btn-danger mr-1" data-href="' +
                    //             '{{ route("service_request.destroy", ":id") }}"'.replace(':id', data.sr_id) +
                    //             '">Delete</button>';
                    //     }
                    // }
                ]
            });

            let serviceRoute = ''
            $(document).on('click', '#delete_service', function(e) {
                e.preventDefault();
                serviceRoute = $(this).attr('data-href');

                $('#deleteConfirmationModal form').attr('action', serviceRoute);

                $('#deleteConfirmationModal').modal('show');
            });
        });
    </script>

    @vite(['resources/js/validator.js'])
@endpush
