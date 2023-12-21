@extends('layouts.calendar')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4>Event Calendar</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box m-b-50">
                                <div id="calendar"></div>
                            </div>
                        </div>

                        @include('pages.calendar.modals.join-event')
                    </div>
                </div>
            </div>
            <!-- /# card -->
        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $(document).on('click', '.join-event', function(e) {
            const eventRoute = $(this).attr('data-route');
            const eventId = $(this).attr('data-event-id');
            const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Get CSRF token from meta tag

            $.ajax({
                url: eventRoute,
                type: 'POST',
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                },
                data: JSON.stringify({event_id: eventId}),
                success: function(response) {
                    triggerToaster(response.message);
                    $('#event-modal').modal('hide');
                },
                error: function(error) {
                    triggerErrorToaster(error);
                }
            });
        });
    });
</script>
@endpush
