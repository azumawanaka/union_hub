
<div class="modal-body">
    <div class="form-validation">
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="name">Name <span class="text-danger">*</span>
            </label>
            <div class="col-lg-12">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter a service name..">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="description">Description <span class="text-danger">*</span></label>
            <div class="col-lg-12">
                <textarea class="form-control" id="descriptions" name="description" rows="5" placeholder="Write description here..."></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="start_end_date">Start & End Date <span class="text-danger">*</span>
            </label>
            <div class="col-lg-12">
                <input type="text"
                    id="event_date_range"
                    class="form-control"
                    name="start_end_date"
                    value="01/01/2015 1:30 PM - 01/01/2015 2:00 PM">
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
    </div>
</div>
