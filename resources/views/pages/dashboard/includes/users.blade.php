<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Users</h4>

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
                    { data: 'f_n', name: 'f_n', title: 'Name' },
                    { data: 'u_email', name: 'u_email', title: 'Email' },
                    { data: 'u_created_at', name: 'u_created_at', title: 'Added At' },
                ]
            });
            $(document).on('click', '.close-modal', function () {
                $('.modal').modal('hide');
            });
        });
    </script>

    @vite(['resources/js/validator.js'])
@endpush
