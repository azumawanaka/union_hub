
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
            <label class="col-lg-12 col-form-label" for="client_id">Client <span class="text-danger">*</span>
            </label>
            <div class="col-lg-12">
                <select class="form-control form-select client-id"
                    id="client_id"
                    name="client_id"
                    data-live-search="true"
                    title="Select a client">
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="service_type_id">Service Type <span class="text-danger">*</span>
            </label>
            <div class="col-lg-12">
                <select class="form-control" id="service_type_id" name="service_type_id">
                    <option value="">Please select</option>
                    @foreach ($serviceTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="description">Description</label>
            <div class="col-lg-12">
                <textarea class="form-control" id="descriptions" name="description" rows="5" placeholder="Write description here..."></textarea>
            </div>
        </div>
    </div>
</div>
