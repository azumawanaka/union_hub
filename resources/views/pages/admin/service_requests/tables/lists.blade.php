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

@push('scripts')
    <script src="{{ asset('assets/plugins/validation/jquery.validate.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var dataTable = $('#service_request_tbl').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                ordering: true,
                order: [[5, 'desc']],
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                ajax: {
                    url: 'service_requests/all',
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
                    {
                        data: 'sr_status',
                        name: 'service_requests.status',
                        title: 'Status',
                        render: function (data, type, row) {
                            // Assuming data.sr_status contains the status value

                            // Add HTML tags based on the status value
                            let statusHTML = '';
                            switch (data) {
                                case 'pending':
                                    statusHTML = '<span class="badge bg-warning text-white">Pending</span>';
                                    break;
                                case 'approved':
                                    statusHTML = '<span class="badge bg-success text-white">Approved</span>';
                                    break;
                                case 'rejected':
                                    statusHTML = '<span class="badge bg-danger text-white">Rejected</span>';
                                    break;
                                // Add more cases for other statuses

                                default:
                                    statusHTML = data; // Display raw status value if not matched
                            }

                            return statusHTML;
                        }
                    },
                    // { data: 'sr_status', name: 'service_requests.status', title: 'Status' },
                    { data: 'details', name: 'details', title: 'Details' },
                    { data: 'sr_created_at', name: 'service_requests.created_at', title: 'Created At', width: "100px" },
                    {
                        data: null,
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, row) {
                            const dropDown = '<div class="dropdown">'+
                                '<button class="btn btn-info dropdown-toggle btn-xs text-white"'+
                                    'type="button"'+
                                    'id="service_request_action"'+
                                    'data-bs-toggle="dropdown"'+
                                    'aria-expanded="false">'+
                                    '<i class="fa fa-cog"></i>'+
                                '</button>'+
                                '<ul class="dropdown-menu py-0" aria-labelledby="service_request_action">'+
                                    '<li>'+
                                        '<a href="javascript:;" id="update_request_status" data-status="approved"'+
                                            'type="button" class="d-block p-2 text-info" data-href="' +
                                            '{{ route("service_requests.update_status", ":id") }}"'.replace(':id', data.sr_id) +
                                            '"><i class="fa fa-thumbs-up"></i> Approve'+
                                        '</a>'+
                                    '</li>'+
                                    '<li>'+
                                        '<a href="javascript:;" id="update_request_status" data-status="rejected"'+
                                            'type="button" class="d-block p-2 text-danger" data-href="' +
                                            '{{ route("service_requests.update_status", ":id") }}"'.replace(':id', data.sr_id) +
                                            '"><i class="fa fa-thumbs-up"></i> Reject'+
                                        '</a>'+
                                    '</li>'+
                                '</ul>'+
                            '</div>';

                            const deleteBtn = '<button id="delete_request" class="btn btn-xs btn-danger ml-1" data-href="' +
                                '{{ route("service_requests.destroy", ":id") }}"'.replace(':id', data.sr_id) +
                                '">Delete</button>';

                            if (data.sr_status === 'rejected' || data.sr_status === 'approved') {
                                return `<div class="d-flex"> ${ deleteBtn } </div>`;
                            } else {
                                return `<div class="d-flex"> ${  dropDown + deleteBtn }</div>`;
                            }
                        }
                    }
                ]
            });

            let route = ''
            $(document).on('click', '#delete_request', function(e) {
                e.preventDefault();
                route = $(this).attr('data-href');

                $('#deleteConfirmationModal form').attr('action', route);
                $('#deleteConfirmationModal').modal('show');
            });

            $(document).on('click', '.confirm-delete', function(e) {
                e.preventDefault();
                window.axios.delete(route).then((response) => {
                    triggerToaster(response.data.message);

                    $('#deleteConfirmationModal').modal('hide');
                    dataTable.ajax.reload();
                })
                .catch((error) => {
                    triggerToaster('Oops! Something went wrong.');
                    console.error(error);
                });
            });

            $(document).on('click', '#update_request_status', function(e) {
                e.preventDefault();
                const status = $(this).attr('data-status');
                route = $(this).attr('data-href');

                updateStatus(route, status);
            });

            function updateStatus(route, status) {
                window.axios.post(route, {'status': status})
                .then((response) => {
                    if (response.data.status === 'error') {
                        triggerErrorToaster(response.data.message);
                    } else {
                        triggerToaster(response.data.message);
                    }

                    dataTable.ajax.reload();
                })
                .catch((error) => {
                    triggerToaster('Oops! Something went wrong.');
                    console.error(error);
                });
            }
        });
    </script>

    @vite(['resources/js/validator.js'])
@endpush
