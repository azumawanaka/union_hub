<div class="modal fade" id="serviceRequestsModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
            </div>
            <form id="service_requests_form" action="" method="POST">
                @csrf
                <input type="hidden" class="form-control" id="service_id" name="service_id">
                <div class="modal-body">
                    <div class="form-validation">
                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label" for="preferred_date_time">Preferred Date & Time <span class="text-danger">*</span></label>
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="preferred_date_time" name="preferred_date_time" placeholder="">
                                    <span class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label" for="location">Location <span class="text-danger">*</span></label>
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="location" name="location" placeholder="">
                                    <span class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-map"></i></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label" for="details">Details <span class="text-danger">*</span></label>
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <textarea class="form-control" id="details" name="details" cols="5"></textarea>
                                    <span class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-pencil"></i></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default close-modal" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#preferred_date_time').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD HH:mm',
                minDate: new Date()
            });

            $(document).on('submit', '#service_requests_form', function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'service_requests/avail',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: $(this).serialize(),
                    success: function(response) {
                        triggerToaster(response.message);
                        $('#serviceRequestsModal').modal('hide');
                        window.setTimeout(() => {
                            location.reload();
                        }, 5000);
                    },
                    error: function(error) {
                        $('#serviceRequestsModal').modal('hide');
                        console.log(error.responseJSON.errors);
                    }
                });
            });
        });
    </script>
@endpush
