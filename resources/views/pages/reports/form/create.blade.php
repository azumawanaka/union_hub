
<div class="tab-pane fade show active" id="form-fields" role="tabpanel">
    <form id="report-form" action="{{ route('reports.store') }}" method="post"  enctype="multipart/form-data">
        @csrf

        <div class="form-validation mb-4">
            <div class="form-group row">
                <label class="col-lg-12 col-form-label" for="type">Type <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <select class="form-control form-select"
                        id="category"
                        name="category"
                        title="Select type">
                        <option selected disabled></option>
                        @foreach (\App\Models\Report::TYPES as $key => $value)
                            <option value="{{ $key }}">{{ Str::title($value) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-12 col-form-label" for="description">Description <span class="text-danger">*</span></label>
                <div class="col-lg-12">
                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Write description here..."></textarea>
                </div>
            </div>

            <div class="col-md-3 issue-prev">
                <img id="issueImgPreview" src="" alt="Image Preview" style="display: none;">
                <img id="dummyIssuePicture" src="" alt="Dummy Image">
                <label class="upload-btn" for="issueImgInput">Upload</label>
                <input type="file"
                    class="form-control visually-hidden d-none"
                    id="issueImgInput"
                    name="report_img"
                    accept="image/*">
            </div>

            <div class="form-group row mt-4">
                <div class="col-lg-12">
                    <label class="css-control css-control-primary css-checkbox" for="is_anonymous">
                    <input type="checkbox"
                        class="css-control-input valid"
                        id="is_anonymous"
                        name="is_anonymous"
                        value="1"
                        aria-required="true"
                        aria-describedby="is_anonymous-error"
                        aria-invalid="false"
                        checked> <span class="css-control-indicator"></span>&nbsp; Make me anonymous</label>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-info btn-md">Send <i class="fa fa-paper-plane"></i></button>
        </div>
    </form>
</div>
