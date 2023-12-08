<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Services</h4>
                <button type="button"
                    id="add_service"
                    class="btn mb-1 btn-info btn-xs"
                    data-href="{{ route('services.store') }}">
                    Add Service <span class="btn-icon-right"><i class="fa fa-plus"></i></span>
                </button>

                @include('pages.admin.services.modals.service-modal')

                <div class="table-responsive">
                    <table id="service_tbl" class="table table-striped table-bordered"></table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/plugins/validation/jquery.validate.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            const dataTable = $('#service_tbl').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                ordering: true,
                order: [[5, 'desc']],
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                ajax: {
                    url: 'services/all',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    { data: 's_id', name: 'services.id', title: 'ID' },
                    { data: 'title', name: 'title', title: 'Name' },
                    { data: 's_name', name: 'service_types.name', title: 'Type' },
                    { data: 'description', name: 'description', title: 'Description' },
                    { data: 'c_name', name: 'clients.name', title: 'Client' },
                    { data: 'added_at', name: 'added_at', title: 'Added at' },
                    {
                        data: null,
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, row) {
                            var editButton = '<button id="edit_service" class="btn btn-xs btn-primary mr-1" data-href="' +
                                '{{ route("services.update_service", ":id") }}"'.replace(':id', data.s_id) +
                                '" data-get="' +
                                '{{ route("services.info", ":id") }}"'.replace(':id', data.s_id) +
                                '">Edit</button>';
                            var deleteButton = '<button id="delete_service" class="btn btn-xs btn-danger mr-1" data-href="' +
                                '{{ route("services.destroy", ":id") }}"'.replace(':id', data.s_id) +
                                '">Delete</button>';
                            return editButton + deleteButton;
                        }
                    }
                ]
            });

            $(document).on('click', '#edit_service', function () {
                var editUrl = $(this).data('href');
                var serviceUrl = $(this).data('get');

                emptyFields();

                const form = $('#serviceModal form')
                    form.attr('action', editUrl);

                getService(serviceUrl);

                $('#serviceModal').modal('show');
            });


            let serviceRoute = ''
            $(document).on('click', '#delete_service', function(e) {
                e.preventDefault();
                serviceRoute = $(this).attr('data-href');

                $('#deleteConfirmationModal form').attr('action', serviceRoute);

                $('#deleteConfirmationModal').modal('show');
            });

            $(document).on('click', '.confirm-delete', function(e) {
                e.preventDefault();
                window.axios.delete(serviceRoute).then((response) => {
                    triggerToaster(response.data.message);

                    $('#deleteConfirmationModal').modal('hide');
                    dataTable.ajax.reload();
                });
            });

            $(document).on('click', '#add_service', function(e) {
                e.preventDefault();
                serviceRoute = $(this).attr('data-href');

                $('#serviceModal form').attr('action', serviceRoute);

                emptyFields();

                $('#serviceModal').modal('show');
            });

            function getService(route) {
                window.axios.get(route)
                    .then(function(response) {
                        const serviceResponseData = response.data;
                        setUpFields(serviceResponseData);
                    })
                    .catch(function(error) {
                        console.error('Error fetching data:', error);
                    });
            }

            function emptyFields() {
                const emptyPayload = {
                    'title': '',
                    'service_type_id': '',
                    'client_id': '',
                    'description': '',
                };
                setUpFields(emptyPayload);
            }

            function setUpFields(v) {
                const form = $('#serviceModal form')

                form.find('#name').val(v.title).focus();
                form.find('#service_type_id').val(v.service_type_id);

                form.find('#client_id').val(v.client_id);
                $('#client_id').selectpicker('refresh');

                form.find('#descriptions').val(v.description);
            }

            $(document).on('click', '.close-modal', function () {
                $('.modal').modal('hide');
            });
        });
    </script>

    @vite(['resources/js/validator.js','resources/js/clients.js'])
@endpush
