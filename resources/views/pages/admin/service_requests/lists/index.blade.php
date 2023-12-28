<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-4 align-items-center">
            <h4 class="card-title">{{ $title }}</h4>
            @include('includes.searchbar', [
                'route' => route('service_requests.index'),
            ])
        </div>
        <div class="basic-list-group">
            <ul class="list-group">
                @foreach ($data as $item)
                    @php
                        $status_bg = 'bg-info';
                        switch ($item->sr_status) {
                            case 'approved':
                                $status_bg = 'bg-success';
                                break;

                            case 'rejected':
                                $status_bg = 'bg-danger';
                                break;
                            default:
                                $status_bg = 'bg-info';
                                break;
                        }
                    @endphp
                    <li class="list-group-item d-flex">
                        <div class="pr-3">
                            <img src="{{ asset('assets/icons/services/'.$item->s_type_id.'.png') }}"
                                width="60"
                                class="rounded-circle border p-2" />
                        </div>
                        <div class="full-width">
                            <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
                                <strong>{{ $item->sr_title }}</strong> <span class="badge {{ $status_bg }} text-white">{{ $item->sr_status }}</span>
                            </div>
                            <div class="py-3">
                                {{ $item->sr_description }}<br/><br/>
                                Rate: <span class="badge badge-primary">Php {{ $item->sr_rate }}</span>
                                <div class="mt-3">
                                    <small><i class="fa fa-calendar text-warning"></i> Requested @ {{ $item->sr_created_at }}</small><br/>
                                    <small><i class="fa fa-map text-info"></i> Location @ {{ $item->location }}</small><br/><br/>
                                    <h4>My Notes</h4>
                                    <p>{!! $item->details !!}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if ($item->sr_status === 'pending')
                                    <button type="button" class="btn btn-sm btn-primary" id="edit_request" data-request="{{ $item->sr_id }}">Edit</button>
                                @endif

                                @if ($item->sr_status === 'rejected')
                                    Rejected @ {{ $item->sr_status_updated_at }}
                                @endif
                                @if ($item->sr_status === 'rejected' || $item->sr_status === 'pending')
                                    <button type="button"
                                        class="btn btn-sm btn-danger"
                                        id="delete_request"
                                        data-href="{{ route('service_requests.cancel', $item->sr_id) }}">Delete</button>
                                @endif
                                @if ($item->sr_status === 'approved')
                                    Approved @ {{ $item->sr_status_updated_at }}
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            @if ($data->total() === 0)
                Empty
            @endif
        </div>
    </div>
</div>
@include('pages.services.paginations.custom', ['data' => $data])
@include('pages.services.modals.service-requests')
@include('pages.modals.delete-confirmation')

@push('scripts')
    <script src="{{ asset('assets/plugins/validation/jquery.validate.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            $(document).on('click', '#edit_request', function (e) {
                e.preventDefault();
                const request_id = $(this).attr('data-request');
                $('#serviceRequestsModal').modal('show');
            });

            let clientRoute = ''
            $(document).on('click', '#delete_request', function(e) {
                e.preventDefault();
                clientRoute = $(this).attr('data-href');
                $('#deleteConfirmationModal').modal('show');
            });

            $(document).on('click', '.confirm-delete', function(e) {
                e.preventDefault();

                $.ajax({
                    url: clientRoute,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#deleteConfirmationModal').modal('hide');
                        triggerToaster('You have been successfully deleted your request.');
                        window.setTimeout(() => {
                            window.location.reload();
                        }, 3000);
                    },
                    error: function(error) {
                        console.log(error.responseJSON.errors);
                    }
                });
            });
        });
    </script>
@endpush
