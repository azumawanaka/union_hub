@extends('layouts.service')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h4 class="card-title mb-4">Notifications</h4>
        @foreach ($notifications as $notif)
        <div class="card mb-3">
            <div class="card-body p-3">
                <div class="bootstrap-media">
                    <div class="media align-items-center">
                        <span class="d-flex icon"><i class="icon-bell text-success"></i></span>
                        <div class="media-body">
                            {!! $notif->message !!}<br/>
                            <small class="text-info">{{ $notif->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
                @if (auth()->user()->role === 1 || $notif->to === auth()->user()->id)
                    <span class="notif-delete-icon" id="notif-delete" data-route="{{ route('notifications.remove', $notif->id) }}">Delete</span>
                @endif
            </div>
        </div>
        @endforeach

        @include('pages.services.paginations.custom', ['data' => $notifications])
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let route = ''
        $(document).on('click', '#notif-delete', function(e) {
            e.preventDefault();
            route = $(this).attr('data-route');
            $('#deleteConfirmationModal').modal('show');
        });

        $(document).on('click', '.confirm-delete', function(e) {
            e.preventDefault();

            $.ajax({
                url: route,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#deleteConfirmationModal').modal('hide');
                    triggerToaster(response .message);
                    window.setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                },
                error: function(error) {

                }

            });
        });
    });
</script>
@endpush
