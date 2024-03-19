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

                                @if (auth()->user()->role === 0)
                                <a class="list-group-item list-group-item-action active d-flex justify-content-between"
                                    id="form-fields-list"
                                    data-toggle="list"
                                    href="#form-fields"
                                    role="tab"
                                    aria-controls="form-fields">Submit Report<i class="fa fa-paper-plane"></i></a>
                                @endif

                                @foreach ($reports as $key => $report)
                                    <a class="list-group-item list-group-item-action pl-4 {{ auth()->user()->role === 1 && $loop->first ? ' active' : '' }}"
                                        id="list-{{ $report->id }}-list"
                                        data-toggle="list"
                                        href="#list-{{ $report->id }}"
                                        role="tab"
                                        aria-controls="{{ $report->id }}">
                                        <i class="fa fa-circle text-{{ \App\Models\Report::STATUS[$report->status]['color'] }} position-absolute circle-stat"></i>
                                        {{ \Illuminate\Support\Str::limit($report->description, 80) }}<br/>
                                        <small>{{ $report->reported_at }}</small>
                                    </a>
                                @endforeach

                                <div class="pagination mt-4">
                                    {{ $reports->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-8 col-sm-9">
                            <div class="tab-content" id="nav-tabContent">
                                @foreach ($reports as $report)
                                    <div class="tab-pane fade{{ auth()->user()->role === 1 && $loop->first ? ' active show' : '' }}" id="list-{{ $report->id }}">
                                        @if (auth()->user()->role === 0)
                                            @if ($report->status === 'pending' || $report->status === 'declined')
                                                <!-- Dropdown button -->
                                                <div class="dropdown top-0 end-0 mt-2 text-right">
                                                    <span class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-cog"></i>
                                                    </span>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li><a class="dropdown-item" href="#" id="delete_report">Delete</a></li>
                                                    </ul>
                                                </div>
                                            @endif
                                        @else
                                            <!-- Dropdown button -->
                                            <div class="dropdown top-0 end-0 mt-2 text-right">
                                                <span class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li><a class="dropdown-item" href="#">Accept</a></li>
                                                    <li><a class="dropdown-item" href="#">Decline</a></li>
                                                    <li><a class="dropdown-item" href="#">Mark as Done</a></li>
                                                </ul>
                                            </div>
                                        @endif

                                        <div>
                                            <i class="fa fa-user"></i> {{ $report->is_anonymous ? 'Anonymous' : $report->user->full_name }}
                                        </div>
                                        <div class="d-flex py-4">
                                            <div class="col-md-8"><p>{!! $report->description !!}</p></div>
                                            <div class="col-md-4">
                                                <img src="{{ $report->attached_file }}" width="100%" />
                                            </div>
                                        </div>
                                        <div class="tab-footer">
                                            <small class="badge badge-dark">{{ \App\Models\Report::TYPES[$report->category] }}</small><br/>
                                            <small class="text-muted">{{ $report->reported_at }}</small>
                                        </div>
                                    </div>
                                @endforeach

                                @if (auth()->user()->role === 0)
                                    @include('pages.reports.form.create')
                                @endif

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

                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
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
