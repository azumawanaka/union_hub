<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Clients</h4>
                <button type="button"
                    id="add_client"
                    class="btn mb-1 btn-info btn-xs"
                    data-href="{{ route('clients.store') }}">
                    Add Client <span class="btn-icon-right"><i class="fa fa-plus"></i></span>
                </button>

                @include('pages.admin.clients.modals.client-modal')

                <div class="table-responsive">
                    <table id="client_tbl" class="table table-striped table-bordered"></table>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/plugins/validation/jquery.validate.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            const dataTable = $('#client_tbl').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                ordering: true,
                order: [[0, 'desc']],
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                ajax: {
                    url: 'clients/all',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    { data: 'c_id', name: 'c_id', title: 'ID' },
                    { data: 'c_name', name: 'c_name', title: 'Name' },
                    { data: 'c_email', name: 'c_email', title: 'Email' },
                    { data: 'c_address', name: 'c_address', title: 'Address' },
                    { data: 'c_mobile', name: 'c_mobile', title: 'Mobile' },
                    { data: 'c_created_at', name: 'c_created_at', title: 'Added At' },
                    { data: 'total_services', name: 'total_services', title: 'Total Services' },
                    {
                        data: null,
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, row) {
                            var editButton = '<button id="edit_client" class="btn btn-xs btn-primary mr-1" data-client="'+data.c_id+'" data-href="' +
                                '{{ route("clients.update_client", ":id") }}"'.replace(':id', data.c_id) +
                                '" data-get="' +
                                '{{ route("clients.info", ":id") }}"'.replace(':id', data.c_id) +
                                '">Edit</button>';
                            var deleteButton = '<button id="delete_client" class="btn btn-xs btn-danger mr-1" data-href="' +
                                '{{ route("clients.destroy", ":id") }}"'.replace(':id', data.c_id) +
                                '">Delete</button>';

                            return editButton + deleteButton;
                        }
                    }
                ]
            });

            let clientId;

            let methodType = 'post';
            $(document).on('click', '#add_client', function(e) {
                e.preventDefault();
                clientRoute = $(this).attr('data-href');

                $('#u').val('');
                methodType = 'post';

                $('#clientModal form').attr('action', clientRoute);

                emptyFields('#clientModal');

                $('#clientModal').modal('show');
            });

            $(document).on('click', '#edit_client', function () {
                var editUrl = $(this).data('href');
                var clientUrl = $(this).data('get');

                clientId = $(this).data('client');
                $('#u').val(clientId);

                methodType = 'put';

                emptyFields('#clientModal');

                const form = $('#clientModal form')
                    form.attr('action', editUrl);

                getClient(clientUrl, '#clientModal');

                $('#clientModal').modal('show');
            });

            $(document).on('submit', '.form-client', function(event) {
                event.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                $.ajax({
                    url: url,
                    type: methodType,
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#clientModal').modal('hide');

                        triggerToaster(response.message);
                        dataTable.ajax.reload();
                    },
                    error: function(error) {
                        console.log(error.responseJSON.errors);
                        const errors = error.responseJSON.errors;

                        for (var fieldName in errors) {
                            if (errors.hasOwnProperty(fieldName)) {
                                var errorMessages = errors[fieldName];

                                console.log('Field: ' + fieldName);
                                console.log('Error Messages:');

                                for (var i = 0; i < errorMessages.length; i++) {
                                    const feebackDiv = `<div class="invalid-feedback animated fadeInUp" style="display: block;">${errorMessages[i]}</div>`;

                                    jQuery(`#${fieldName}`).addClass('is-invalid');
                                    jQuery(`#${fieldName}`).parents(".form-group > div").append(feebackDiv)
                                }
                            }
                        }
                    }
                });
            });


            let clientRoute = ''
            $(document).on('click', '#delete_client', function(e) {
                e.preventDefault();
                clientRoute = $(this).attr('data-href');

                $('#deleteConfirmationModal form').attr('action', clientRoute);

                $('#deleteConfirmationModal').modal('show');
            });

            $(document).on('click', '.confirm-delete', function(e) {
                e.preventDefault();
                window.axios.delete(clientRoute).then((response) => {
                    triggerToaster(response.data.message);

                    $('#deleteConfirmationModal').modal('hide');
                    dataTable.ajax.reload();
                });
            });

            function getClient(route, id) {
                window.axios.get(route)
                    .then(function(response) {
                        const clientResponseData = response.data;
                        setUpFields(clientResponseData, id);
                    })
                    .catch(function(error) {
                        console.error('Error fetching data:', error);
                    });
            }

            function emptyFields(id) {
                const emptyPayload = {
                    'name': '',
                    'email': '',
                    'address': '',
                    'mobile': '',
                };
                setUpFields(emptyPayload, id);
            }

            function setUpFields(v, id) {
                const form = $(`${id} form`)

                form.find('[name=name]').val(v.name).focus();
                form.find('[name=email]').val(v.email).focus();
                form.find('[name=address]').val(v.address).focus();
                form.find('[name=mobile]').val(v.mobile).focus();
            }

            $(document).on('click', '.close-modal', function () {
                $('.modal').modal('hide');
            });
        });
    </script>

    @vite(['resources/js/validator.js'])
@endpush
