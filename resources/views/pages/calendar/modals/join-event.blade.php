
<div class="modal fade none-border" id="event-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong>Event Name</strong></h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                @if (auth()->user()->role === 0)
                    <button type="button" class="btn btn-info join-event waves-effect waves-light" data-dismiss="modal">Join</button>
                @endif
            </div>
        </div>
    </div>
</div>
