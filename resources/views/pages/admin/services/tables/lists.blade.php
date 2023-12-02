<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Services</h4>
                <button type="button"
                    data-toggle="modal"
                    data-target="#newServiceModal"
                    class="btn mb-1 btn-info btn-xs">
                    Add Service <span class="btn-icon-right"><i class="fa fa-plus"></i></span>
                </button>

                @include('pages.admin.services.modals.new-service')

                <div class="table-responsive">
                    <table id="service_tbl" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Name</th>
                                <th width="350">Description</th>
                                <th>Client</th>
                                <th>Added At</th>
                                <th width="30">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td>{{ $service->id }}</td>
                                    <td><span class="badge badge-primary px-2">{{ $service?->title }}</span></td>
                                    <td>{{ $service?->serviceType?->name }}</td>
                                    <td>{!! $service?->description ?? '----' !!}</td>
                                    <td>{{ $service?->client?->name }}</td>
                                    <td>{{ $service?->created_at->diffForHumans() }}</td>
                                    <td class="text-center">
                                        <span>
                                            <span type="button"
                                                id="edit_service"
                                                class="btn btn-xs btn-info"
                                                data-service="{{ $service->id }}"
                                                data-get="{{ route("service.info", $service->id) }}"
                                                data-href='{{ route("service.update_service", $service) }}'>
                                                <i class="fa fa-pencil color-muted m-r-5"></i>
                                            </span>

                                            <!-- Button trigger modal -->
                                            <span type="button"
                                                id="delete_service"
                                                class="btn btn-xs btn-danger"
                                                data-href='{{ route("service.destroy", $service->id) }}'>
                                                <i class="fa fa-close color-danger"></i>
                                            </span>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('pages.admin.services.modals.delete-confirmation')

@push('scripts')
    <script src="{{ asset('assets/plugins/validation/jquery.validate.min.js') }}"></script>

    @vite(['resources/js/validator.js','resources/js/services.js'])

    <script>
        $(document).ready(function() {

            $(document).on('click', '#delete_service', function(e) {
                e.preventDefault();
                serviceRoute = $(this).attr('data-href');

                $('#deleteConfirmationModal form').attr('action', serviceRoute);

                $('#deleteConfirmationModal').modal('show');
            });

            $(document).on('click', '#edit_service', function(e) {
                e.preventDefault();
                serviceRoute = $(this).attr('data-href');

                const form = $('#newServiceModal form')
                form.attr('action', serviceRoute);

                const getRoute = $(this).attr('data-get');
                getService(getRoute);

                $('#newServiceModal').modal('show');
            });

            function getService(route) {
                window.axios.get(route)
                    .then(function(response) {
                        const serviceResponseData = response.data;
                        const form = $('#newServiceModal form');

                        form.find('#name').val(serviceResponseData.title);
                        form.find('#service_type_id').val(serviceResponseData.service_type_id);

                        form.find('#client_id').val(serviceResponseData.service_type_id);
                        $('#client_id').selectpicker('refresh');

                        form.find('#descriptions').val(serviceResponseData.description);
                    })
                    .catch(function(error) {
                        console.error('Error fetching data:', error);
                    });
            }

            // Manually close modal on click
            $(document).on('click', '.close-modal', function () {
                $('.modal').modal('hide');
            });
        });
    </script>
@endpush
