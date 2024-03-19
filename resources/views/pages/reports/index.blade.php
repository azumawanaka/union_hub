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
                                <a class="list-group-item list-group-item-action active d-flex justify-content-between"
                                    id="form-fields-list"
                                    data-toggle="list"
                                    href="#form-fields"
                                    role="tab"
                                    aria-controls="form-fields">Submit Report<i class="fa fa-paper-plane"></i></a>

                                @foreach ($reports as $report)
                                    <a class="list-group-item list-group-item-action"
                                        id="list-{{ $report->id }}-list"
                                        data-toggle="list"
                                        href="#list-{{ $report->id }}"
                                        role="tab"
                                        aria-controls="{{ $report->id }}">
                                        <i class="fa fa-circle text-{{ \App\Models\Report::STATUS[$report->status]['color'] }}"></i>
                                        {{ \Illuminate\Support\Str::limit($report->description, 80) }}
                                    </a>
                                @endforeach
                                <div class="pagination">
                                    {{ $reports->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-8 col-sm-9">
                            <div class="tab-content" id="nav-tabContent">
                                @foreach ($reports as $report)
                                    <div class="tab-pane fade" id="list-{{ $report->id }}">
                                        @if ($report->status === 'pending' || $report->status === 'declined')
                                            <!-- Dropdown button -->
                                            <div class="dropdown top-0 end-0 mt-2 text-right">
                                                <span class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li><a class="dropdown-item" href="#" id="delete_report">Delete</a></li>
                                                    {{-- <li><a class="dropdown-item" href="#">Edit</a></li> --}}
                                                </ul>
                                            </div>
                                        @endif

                                        <p>{!! $report->description !!}</p>
                                        <div class="tab-footer">
                                            <small class="badge badge-dark">{{ \App\Models\Report::TYPES[$report->category] }}</small><br/>
                                            <small class="text-muted">{{ $report->reported_at }}</small>
                                        </div>
                                    </div>
                                @endforeach

                                {{-- form --}}
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pages.modals.delete-confirmation')
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/validation/jquery.validate.min.js') }}"></script>
@vite(['resources/js/validator.js'])

<script>
    $(document).ready(function(){
        $('#dummyIssuePicture').hide();
        $('#issueImgInput').change(function(){
            previewImage(this);
        });

        $(document).on('submit', '#report-form', function(event) {
            event.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var formData = new FormData(form[0]); // Create FormData object to handle form data and files

            $.ajax({
                url: url,
                type: 'POST',
                data: formData, // Use FormData object instead of form.serialize()
                contentType: false, // Don't set content type (will be automatically set)
                processData: false, // Don't process data (already done by FormData)
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    triggerToaster(response.message);

                     // Clear the form
                    form[0].reset();
                    $('#dummyIssuePicture').hide();
                    $('#issueImgPreview').hide();
                    $('#dummyIssuePicture').hide();
                },
                error: function(error) {
                    // error message here
                }
            });
        });

        let userRoute = ''
        $(document).on('click', '#delete_report', function(e) {
            e.preventDefault();
            userRoute = $(this).attr('data-href');

            $('#deleteConfirmationModal form').attr('action', userRoute);

            $('#deleteConfirmationModal').modal('show');
        });

        $(document).on('click', '.confirm-delete', function(e) {
            e.preventDefault();
            window.axios.delete(userRoute).then((response) => {
                triggerToaster(response.data.message);

                $('#deleteConfirmationModal').modal('hide');
                dataTable.ajax.reload();
            });
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
