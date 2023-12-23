<div class="row g-2">
    @foreach ($services as $service)
        <div class="col-xl-3 col-md-4">
            <div class="card">
                <div class="text-center mb-3 pt-3">
                    <img src="{{ asset('assets/icons/services/'.$service->service_type_id.'.png') }}" width="100" />
                    <div><small>{{ $service->s_name }}</small></div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $service->title }}</h5>

                    <p class="card-text">{!! nl2br($service->description) !!}</p>
                </div>
                <div class="card-footer">
                    <p class="card-text d-inline">
                        <small class="text-muted">{{ $service->updated_at->diffForHumans() }}</small>
                    </p>
                    <button type="button"
                        class="card-link float-right btn btn-info btn-sm show-details"><small>Show Details</small>
                    </button>
                </div>
            </div>
        </div>
    @endforeach

    @include('pages.services.modals.service-details')
</div>

@push('scripts')
    <script src="{{ asset('assets/plugins/validation/jquery.validate.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.show-details', function (e) {
                e.preventDefault();

                $('#serviceDetailsModal').modal('show');
            })

            $(document).on('click', '.close-modal', function (e) {
                e.preventDefault();

                $('#serviceDetailsModal').modal('hide');
            })
        });
    </script>

    @vite(['resources/js/validator.js'])
@endpush
