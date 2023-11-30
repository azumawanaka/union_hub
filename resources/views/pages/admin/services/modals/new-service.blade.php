<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-valide" action="#" method="post">
                <div class="modal-body">
                    <div class="form-validation">
                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label" for="val-name">Name <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" id="val-name" name="val-name" placeholder="Enter a service name..">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label" for="val-service-type">Service Type <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-12">
                                <select class="form-control" id="val-service-type" name="val-service-type">
                                    <option value="">Please select</option>
                                    @foreach ($serviceTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/plugins/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins-init/jquery.validate-init.js') }}"></script>
@endpush
