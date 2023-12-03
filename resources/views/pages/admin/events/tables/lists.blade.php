<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Events</h4>
                <button type="button"
                    id="add_event"
                    class="btn mb-1 btn-info btn-xs"
                    data-href="{{ route('event.store') }}">
                    Add Event <span class="btn-icon-right"><i class="fa fa-plus"></i></span>
                </button>

                @include('pages.admin.events.modals.event-modal')

                <div class="table-responsive">
                    <table id="event_tbl" class="table table-striped table-bordered"></table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/plugins/validation/jquery.validate.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#event_date_range').daterangepicker({
                timePicker: true,
                format: 'MM/DD/YYYY h:mm A',
                timePickerIncrement: 30,
                timePicker12Hour: true,
                timePickerSeconds: false,
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-danger',
                cancelClass: 'btn-inverse'
            });

            const dataTable = $('#event_tbl').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                ordering: true,
                order: [[0, 'asc']],
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                ajax: {
                    url: 'event/all',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    { data: 'event_id', name: 'id', title: 'ID', width: '50px' },
                    { data: 'name', name: 'name', title: 'Name', width: '150px' },
                    { data: 'description', name: 'description', title: 'Description', width: '250px' },
                    { data: 'start_date', name: 'start_date', title: 'Start Date', width: '120px' },
                    { data: 'end_date', name: 'end_date', title: 'End Date', width: '120px' },
                    { data: 'category', name: 'category', title: 'Category', width: '80px' },
                    { data: 'status', name: 'status', title: 'Status', width: '60px' },
                    {
                        data: null,
                        title: 'Actions',
                        render: function (data, type, row) {
                            var editButton = '<button id="edit_event" class="btn btn-xs btn-primary mr-1" data-href="' +
                                '{{ route("event.update_event", ":id") }}"'.replace(':id', data.event_id) +
                                '">Edit</button>';
                            var deleteButton = '<button id="delete_event" class="btn btn-xs btn-danger mr-1" data-href="' +
                                '{{ route("event.destroy", ":id") }}"'.replace(':id', data.event_id) +
                                '">Delete</button>';
                            return editButton + deleteButton;
                        },
                        width: '50px'
                    }
                ]
            });

            $(document).on('click', '#edit_event', function () {
                var editUrl = $(this).data('href');
                var serviceUrl = $(this).data('get');

                emptyFields();

                const form = $('#eventModal form')
                    form.attr('action', editUrl);

                $('#eventModal').modal('show');
            });


            let eventRoute = ''
            $(document).on('click', '#delete_event', function(e) {
                e.preventDefault();
                eventRoute = $(this).attr('data-href');

                $('#deleteConfirmationModal form').attr('action', eventRoute);

                $('#deleteConfirmationModal').modal('show');
            });

            $(document).on('click', '.confirm-delete', function(e) {
                e.preventDefault();
                window.axios.delete(eventRoute).then((response) => {
                    triggerToaster(response.data.message);

                    $('#deleteConfirmationModal').modal('hide');
                    dataTable.ajax.reload();
                });
            });

            $(document).on('click', '#add_event', function(e) {
                e.preventDefault();
                eventRoute = $(this).attr('data-href');

                $('#eventModal form').attr('action', eventRoute);

                emptyFields();

                $('#eventModal').modal('show');
            });

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
                const form = $('#eventModal form')

                form.find('#name').val(v.title).focus();

                form.find('#descriptions').val(v.description);
            }

            $(document).on('click', '.close-modal', function () {
                $('.modal').modal('hide');
            });
        });
    </script>

    @vite(['resources/js/validator.js'])
@endpush
