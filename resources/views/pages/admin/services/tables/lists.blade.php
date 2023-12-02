<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Services</h4>
                <button type="button"
                    id="add_service"
                    class="btn mb-1 btn-info btn-xs"
                    data-href="{{ route('service.store') }}">
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

@include('pages.admin.services.modals.delete-confirmation')

@push('scripts')
    <script src="{{ asset('assets/plugins/validation/jquery.validate.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#service_tbl').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                ordering: true,
                order: [[5, 'desc']],
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                ajax: {
                    url: 'service/all',
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
                        render: function (data, type, row) {
                            var editButton = '<button id="edit_service" class="btn btn-xs btn-primary mr-1" data-href="' +
                                '{{ route("service.update_service", ":id") }}"'.replace(':id', data.s_id) +
                                '" data-get="' +
                                '{{ route("service.info", ":id") }}"'.replace(':id', data.s_id) +
                                '">Edit</button>';
                            var deleteButton = '<button id="delete_service" class="btn btn-xs btn-danger mr-1" data-href="' +
                                '{{ route("service.destroy", ":id") }}"'.replace(':id', data.s_id) +
                                '">Delete</button>';
                            return editButton + deleteButton;
                        }
                    }
                ]
            });
        });
    </script>

    @vite(['resources/js/validator.js','resources/js/clients.js','resources/js/services.js'])
@endpush
