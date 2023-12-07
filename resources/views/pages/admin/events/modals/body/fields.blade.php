
<div class="modal-body">
    <div class="form-validation">
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="name">Name <span class="text-danger">*</span>
            </label>
            <div class="col-lg-12">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter a event name..">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="description">Description <span class="text-danger">*</span></label>
            <div class="col-lg-12">
                <textarea class="form-control" id="description" name="description" rows="5" placeholder="Write description here..."></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="start_end_date">Start & End Date <span class="text-danger">*</span>
            </label>
            <div class="col-lg-12">
                <input type="text"
                    id="start_end_date"
                    class="form-control"
                    name="start_end_date"
                    value="">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="category">Category <span class="text-danger">*</span>
            </label>
            <div class="col-lg-12">
                <select class="form-control form-select"
                    id="category"
                    name="category"
                    title="Select category">
                    <option selected disabled></option>
                    @foreach (\App\Models\Event::CATEGORIES as $category)
                        <option value="{{ $category }}">{{ Str::title($category) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="max_participants">Desired Number of Participants <span class="text-danger">*</span>
            </label>
            <div class="col-lg-12">
                <input type="number" min="1" class="form-control" id="max_participants" name="max_participants" value="10">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="status">
                Status
            </label>
            <div class="col-lg-12">
                @foreach(\App\Models\Event::STATUSES as $status)
                    <label class="radio-inline mr-3">
                        <input type="radio" name="status" value="{{ $status }}"> {{ ucfirst($status) }}
                    </label>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#start_end_date').daterangepicker({
                timePicker: true,
                format: 'MM/DD/YYYY HH:mm',
                timePickerIncrement: 30,
                timePicker24Hour: true,
                timePickerSeconds: false,
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-danger',
                cancelClass: 'btn-inverse'
            });

            // Set the initial date range
            $('#start_end_date').on('apply.daterangepicker', function(ev, picker) {
                const start_date = picker.startDate.format('YYYY-MM-DD HH:mm');
                const end_date = picker.endDate.format('YYYY-MM-DD HH:mm');

                $('#start_end_date').val(start_date +' - '+ end_date);
            });
        });
    </script>
@endpush
