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
                        class="card-link float-right btn btn-info btn-sm show-details"
                            data-url="{{ route('services.info', $service->s_id) }}"
                            data-sr-id="{{ $service->sr_id }}"
                            data-sr-status="{{ $service->sr_status }}"><small>Show Details</small>
                    </button>
                </div>
            </div>
        </div>
    @endforeach

    @include('pages.services.modals.service-details')
    @include('pages.services.modals.service-requests')
</div>

@include('pages.services.paginations.custom', ['data' => $services])

@push('scripts')
    <script src="{{ asset('assets/plugins/validation/jquery.validate.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.show-details', function (e) {
                e.preventDefault();

                const url = $(this).attr('data-url');
                const sr_id = $(this).attr('data-sr-id');
                const sr_status = $(this).attr('data-sr-status');

                let statusHTML = '';
                $('.avail-btn')
                    .show()
                    .removeClass('btn-warning')
                    .addClass('btn-info')
                    .attr('id', 'avail_service')
                    .text('Avail');

                switch (sr_status) {
                    case 'pending':
                        statusHTML = '<span class="badge bg-warning text-white">Pending</span>';
                        $('.avail-btn')
                            .removeClass('btn-info')
                            .addClass('btn-warning text-white')
                            .removeAttr('id', 'avail_service')
                            .attr('id', 'cancel_request')
                            .text('Cancel');
                        break;
                    case 'approved':
                        statusHTML = '<span class="badge bg-success text-white">Approved @ 04-20-2023 10:00:00</span>';
                        $('.avail-btn')
                            .removeAttr('id')
                            .hide();
                        break;
                    case 'rejected':
                        statusHTML = '<span class="badge bg-danger text-white">Rejected</span></span>';
                        $('.avail-btn')
                            .removeAttr('id')
                            .hide();
                        break;
                    default:
                        statusHTML = ''
                }

                if (sr_id) {
                    $('#badge-status').html(statusHTML);
                    $('#serviceDetailsModal .modal-footer').addClass('justify-content-between')
                    $('#cancel_request').attr('data-sr-id', sr_id);
                } else {
                    $('#badge-status').html('');
                    $('#serviceDetailsModal .modal-footer').removeClass('justify-content-between')
                    $('#cancel_request').removeAttr('data-sr-id');
                }

                $.ajax({
                    url: url,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#serviceDetailsModal').modal('show');

                        $('#service_id').val(response.id);

                        $('#serviceDetailsModal').find('.modal-title').text(response.title);
                        $('#serviceDetailsModal').find('.modal-body').html(`${response.description} </br></br>
                            <strong class="badge badge-info">Rate: Php ${formatCurrency(response.rate)}</strong>`);
                        $('#avail_service').attr('data-service', response.s_id);
                    },
                    error: function(error) {
                        $('#serviceDetailsModal').modal('hide');
                        console.log(error.responseJSON.errors);
                    }
                });
            });

            $(document).on('click', '.close-modal', function (e) {
                e.preventDefault();

                $('#serviceDetailsModal').modal('hide');
                $('#serviceRequestsModal').modal('hide');
            });

            $(document).on('click', '#avail_service', function (e) {
                e.preventDefault();
                const service_id = $(this).attr('data-service');

                $('#serviceDetailsModal').modal('hide');
                $('#serviceRequestsModal').modal('show');
                $('#serviceRequestsModal').find('.modal-title').html($('#serviceDetailsModal').find('.modal-title').html());
            });

            $(document).on('click', '#cancel_request', function (e) {
                e.preventDefault();

                const sr_id = $(this).attr('data-sr-id')
                $.ajax({
                    url: `service_requests/${sr_id}/cancel`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        triggerToaster(response.message);
                        $('#serviceDetailsModal').modal('hide');
                        window.setTimeout(() => {
                            location.reload();
                        }, 5000);
                    },
                    error: function(error) {
                        $('#serviceDetailsModal').modal('hide');
                        console.log(error.responseJSON.errors);
                    }
                });
            });

            function formatCurrency(number) {
                // Convert the number to a string
                const numString = number.toString();

                // Split the string into parts before and after the decimal point (if any)
                const parts = numString.split('.');

                // Add commas to the integer part of the number
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ', ');

                // Join the parts back together and return the formatted string
                return parts.join('.');
            }
        });
    </script>

    @vite(['resources/js/validator.js'])
@endpush
