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
            const dataTable = $('#event_tbl').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                ordering: true,
                order: [[0, 'desc']],
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
                    {
                        data: 'category',
                        name: 'category',
                        title: 'Category',
                        render: function (data, type, row) {
                            return `<span class="badge badge-${data === 'cultural' ? 'info' : 'success text-white'}">${ data }</span>`;
                        },
                        width: '80px'
                    },
                    { data: 'description', name: 'description', title: 'Description', width: '250px' },
                    { data: 'start_date', name: 'start_date', title: 'Start Date', width: '120px' },
                    { data: 'end_date', name: 'end_date', title: 'End Date', width: '120px' },
                    { data: 'participant_count', name: 'participant_count', title: 'No. of participants', width: '120px' },
                    {
                        data: 'status',
                        name: 'status',
                        title: 'Status',
                        render: function (data, type, row) {
                            let badgeColor = 'warning';
                            switch (data) {
                                case 'cancelled':
                                    badgeColor = 'danger';
                                    break;
                                case 'ongoing':
                                    badgeColor = 'secondary text-white';
                                    break;
                                case 'finished':
                                    badgeColor = 'success text-white';
                                    break;
                                case 'full':
                                    badgeColor = 'info';
                                    break;
                                default:
                                    badgeColor = 'dark';
                                    break;
                            }
                            return `<span class="badge badge-${badgeColor}">${ data }</span>`;
                        },
                        width: '60px'
                    },
                    {
                        data: null,
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, row) {
                            var editButton = '<button id="edit_event" class="btn btn-xs btn-primary mr-1" data-href="' +
                                '{{ route("event.update_event", ":id") }}"'.replace(':id', data.event_id) +
                                '" data-get="' +
                                '{{ route("event.show", ":id") }}"'.replace(':id', data.event_id) +
                                '">Edit</button>';
                            var deleteButton = '<button id="delete_event" class="btn btn-xs btn-danger mr-1" data-href="' +
                                '{{ route("event.destroy", ":id") }}"'.replace(':id', data.event_id) +
                                '">Delete</button>';
                            return editButton + deleteButton;
                        },
                        width: '90px'
                    }
                ]
            });

            $(document).on('click', '#edit_event', function () {
                var editUrl = $(this).data('href');
                var eventUrl = $(this).data('get');

                $('#eventModal form').attr('action', editUrl);

                emptyFields();

                window.axios.get(eventUrl).then((response) => {
                    setUpFields(response.data);
                });

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
                    'name': '',
                    'description': '',
                    'category': '',
                    'start_date': '01/01/2023 01:00',
                    'end_date': '01/02/2023 02:00',
                    'max_participants': 10,
                    'status': '',
                };
                setUpFields(emptyPayload);
            }

            function setUpFields(v) {
                const form = $('#eventModal form')

                form.find('#name').val(v.name).focus();
                form.find('#description').val(v.description);
                form.find('#category').val(v.category);
                form.find('#max_participants').val(v.max_participants);

                $(`input[name="status"][value="${v.status}"]`).prop('checked', true);

                setupDanteRangePicker(v, form);
            }

            function setupDanteRangePicker(v, form) {
                // Set the date range for the edit form
                const startDate = moment(v.start_date, 'YYYY-MM-DD HH:mm');
                const endDate = moment(v.end_date, 'YYYY-MM-DD HH:mm');

                // Get the daterangepicker instance
                const daterangepicker = $('#start_end_date').data('daterangepicker');

                // Set the start and end date for the daterangepicker
                daterangepicker.setStartDate(startDate);
                daterangepicker.setEndDate(endDate);

                form.find('#start_end_date').val(v.start_date +" - " + v.end_date);
            }

            $(document).on('click', '.close-modal', function () {
                $('.modal').modal('hide');
            });
        });
    </script>

    @vite(['resources/js/validator.js'])
@endpush
