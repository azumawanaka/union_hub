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

                @include('pages.admin.users.modals.edit-user-modal')

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
                order: [[0, 'desc']],
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
                    { data: 'u_fn', name: 'u_fn', title: 'First Name' },
                    { data: 'u_ln', name: 'u_ln', title: 'Last Name' },
                    { data: 'u_email', name: 'u_email', title: 'Email' },
                    { data: 'u_address', name: 'u_address', title: 'Address' },
                    { data: 'u_mobile', name: 'u_mobile', title: 'Mobile' },
                    { data: 'u_gender', name: 'u_gender', title: 'Gender' },
                    {
                        data: 'u_role',
                        name: 'u_role',
                        title: 'Role',
                        orderable: true,
                        render: function (data, type, row) {
                            return data == 0 ? 'user' : 'admin';
                        }
                    },
                    { data: 'u_created_at', name: 'u_created_at', title: 'Added At' },
                    {
                        data: null,
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, row) {
                            var editButton = '<button id="edit_user" class="btn btn-xs btn-primary mr-1" data-user="'+data.u_id+'" data-href="' +
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

            let userId;
            $(document).on('click', '#edit_user', function () {
                var editUrl = $(this).data('href');
                var userUrl = $(this).data('get');

                userId = $(this).data('user');
                $('#u').val(userId);

                emptyFields('#userEditModal');

                const form = $('#userEditModal form')
                    form.attr('action', editUrl);

                getuser(userUrl, '#userEditModal');

                $('#userEditModal').modal('show');
            });

            $(document).on('submit', '.form-user-edit', function(event) {
                event.preventDefault();

                var form = $(this);
                var url = form.attr('action');

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#userEditModal').modal('hide');

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

                                    jQuery(`#edit_${fieldName}`).addClass('is-invalid');
                                    jQuery(`#edit_${fieldName}`).parents(".form-group > div").append(feebackDiv)
                                }
                            }
                        }
                    }
                });
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

                $('#u').val('');

                $('#userModal form').attr('action', userRoute);

                emptyFields('#userModal');

                $('#userModal').modal('show');
            });

            function getuser(route, id) {
                window.axios.get(route)
                    .then(function(response) {
                        const userResponseData = response.data;
                        setUpFields(userResponseData, id);
                    })
                    .catch(function(error) {
                        console.error('Error fetching data:', error);
                    });
            }

            function emptyFields(id) {
                const emptyPayload = {
                    'first_name': '',
                    'last_name': '',
                    'email': '',
                    'address': '',
                    'password': '',
                    'mobile': '',
                    'gender': '',
                };
                setUpFields(emptyPayload, id);
            }

            function setUpFields(v, id) {
                const form = $(`${id} form`)

                form.find('[name=first_name]').val(v.first_name).focus();
                form.find('[name=last_name]').val(v.last_name).focus();
                form.find('[name=email]').val(v.email).focus();
                form.find('[name=address]').val(v.address).focus();
                form.find('[name=mobile]').val(v.mobile).focus();
                form.find('[name=gender]').val(v.gender).focus();
            }

            $(document).on('click', '.close-modal', function () {
                $('.modal').modal('hide');
            });
        });
    </script>

    @vite(['resources/js/validator.js'])
@endpush
