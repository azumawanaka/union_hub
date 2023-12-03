<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventFormLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventFormLabel">Event Form</h5>
            </div>
            <form class="form-event" action="" method="post">
                @csrf

                @include('pages.admin.events.modals.body.fields')

                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-md close-modal">Close</button>
                    <button type="submit" class="btn btn-info btn-md">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
