@extends('layouts.user')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Reports</h4>
                <div class="basic-list-group">
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-sm-3 mb-4 mb-sm-0">
                            <div class="list-group" id="list-tab" role="tablist">
                                <a class="list-group-item list-group-item-action d-flex justify-content-between"
                                    id="form-fields-list"
                                    data-toggle="list"
                                    href="#form-fields"
                                    role="tab"
                                    aria-controls="form-fields">Submit Report<i class="fa fa-plus"></i></a>

                                <a class="list-group-item list-group-item-action active"
                                    id="list-home-list"
                                    data-toggle="list"
                                    href="#list-home"
                                    role="tab"
                                    aria-controls="home">This is a subject of the report A</a>
                                <a class="list-group-item list-group-item-action"
                                    id="list-profile-list"
                                    data-toggle="list"
                                    href="#list-profile"
                                    role="tab"
                                    aria-controls="profile">This is a subject of the reportB</a>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-8 col-sm-9">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="list-home">
                                    <!-- Dropdown button -->
                                    <div class="dropdown top-0 end-0 mt-2 text-right">
                                        <span class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-cog"></i>
                                        </span>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        </ul>
                                    </div>

                                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dicta minus voluptates repudiandae facilis eligendi quidem hic magnam recusandae architecto placeat, harum aliquid et corporis explicabo ipsam beatae, commodi ex quo.</p>
                                    <div class="tab-footer">
                                        <small class="badge badge-info">category-abc</small><br/>
                                        <small class="text-muted">2024-03-17 01:00:00</small>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="list-profile" role="tabpanel">
                                    <p>This is the content of the report B</p>
                                </div>
                                <div class="tab-pane fade" id="form-fields" role="tabpanel">
                                    <form class="form-event" action="" method="post">
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
                                                            <option value="{{$key }}">{{ Str::title($value) }}</option>
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
                                                <input type="file" class="form-control visually-hidden d-none" id="issueImgInput" name="profilePicture">
                                            </div>

                                            <div class="form-group row mt-4">
                                                <div class="col-lg-12">
                                                    <label class="css-control css-control-primary css-checkbox" for="val-terms">
                                                    <input type="checkbox"
                                                        class="css-control-input valid"
                                                        id="val-terms"
                                                        name="val-terms"
                                                        value="1"
                                                        aria-required="true"
                                                        aria-describedby="val-terms-error"
                                                        aria-invalid="false"
                                                        checked> <span class="css-control-indicator"></span>&nbsp; Make me anonymous</label>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-md close-modal">Close</button>
                                            <button type="submit" class="btn btn-info btn-md">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('#dummyIssuePicture').hide();
        $('#issueImgInput').change(function(){
            previewImage(this);
        });
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#issueImgPreview').attr('src', e.target.result);
                $('#issueImgPreview').show();
                $('.upload-btn').css({'opacity': 0})
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
