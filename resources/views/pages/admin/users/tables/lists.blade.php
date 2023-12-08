<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Users</h4>
                <button type="button"
                    id="add_user"
                    class="btn mb-1 btn-info btn-xs"
                    data-href="{{ route('users.store') }}">
                    Add User <span class="btn-icon-right"><i class="fa fa-plus"></i></span>
                </button>

                @include('pages.admin.users.modals.user-modal')

                <div class="table-responsive">
                    <table id="user_tbl" class="table table-striped table-bordered"></table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/plugins/validation/jquery.validate.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            const dataTable = $('#user_tbl').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                ordering: true,
                order: [[5, 'desc']],
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                ajax: {
                    url: 'users/all',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    { data: 'u_id', name: 'u_id', title: 'ID' },
                    { data: 'full_name', name: 'full_name', title: 'Name' },
                    { data: 'u_email', name: 'u_email', title: 'Email' },
                    { data: 'u_address', name: 'u_address', title: 'Address' },
                    { data: 'u_mobile', name: 'u_mobile', title: 'Mobile' },
                    { data: 'u_gender', name: 'u_gender', title: 'Gender' },
                    { data: 'u_role', name: 'u_role', title: 'Role' },
                    { data: 'u_created_at', name: 'u_created_at', title: 'Added At' },
                    {
                        data: null,
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, row) {
                            var editButton = '<button id="edit_user" class="btn btn-xs btn-primary mr-1" data-href="' +
                                '{{ route("users.update_user", ":id") }}"'.replace(':id', data.u_id) +
                                '" data-get="' +
                                '{{ route("users.info", ":id") }}"'.replace(':id', data.u_id) +
                                '">Edit</button>';
                            var deleteButton = '<button id="delete_user" class="btn btn-xs btn-danger mr-1" data-href="' +
                                '{{ route("users.destroy", ":id") }}"'.replace(':id', data.u_id) +
                                '">Delete</button>';
                            return editButton + deleteButton;
                        }
                    }
                ]
            });

            $(document).on('click', '#edit_user', function () {
                var editUrl = $(this).data('href');
                var userUrl = $(this).data('get');

                emptyFields();

                const form = $('#userModal form')
                    form.attr('action', editUrl);

                getuser(userUrl);

                $('#userModal').modal('show');
            });


            let userRoute = ''
            $(document).on('click', '#delete_user', function(e) {
                e.preventDefault();
                userRoute = $(this).attr('data-href');

                $('#deleteConfirmationModal form').attr('action', userRoute);

                $('#deleteConfirmationModal').modal('show');
            });

            $(document).on('click', '.confirm-delete', function(e) {
                e.preventDefault();
                window.axios.delete(userRoute).then((response) => {
                    triggerToaster(response.data.message);

                    $('#deleteConfirmationModal').modal('hide');
                    dataTable.ajax.reload();
                });
            });

            $(document).on('click', '#add_user', function(e) {
                e.preventDefault();
                userRoute = $(this).attr('data-href');

                $('#userModal form').attr('action', userRoute);

                emptyFields();

                $('#userModal').modal('show');
            });

            function getuser(route) {
                window.axios.get(route)
                    .then(function(response) {
                        const userResponseData = response.data;
                        setUpFields(userResponseData);
                    })
                    .catch(function(error) {
                        console.error('Error fetching data:', error);
                    });
            }

            function emptyFields() {
                const emptyPayload = {
                    'title': '',
                    'user_type_id': '',
                    'client_id': '',
                    'description': '',
                };
                setUpFields(emptyPayload);
            }

            function setUpFields(v) {
                const form = $('#userModal form')

                form.find('#name').val(v.title).focus();
                form.find('#user_type_id').val(v.user_type_id);

                form.find('#client_id').val(v.client_id);
                $('#client_id').selectpicker('refresh');

                form.find('#descriptions').val(v.description);
            }

            $(document).on('click', '.close-modal', function () {
                $('.modal').modal('hide');
            });
        });
    </script>

    @vite(['resources/js/validator.js'])
@endpush
