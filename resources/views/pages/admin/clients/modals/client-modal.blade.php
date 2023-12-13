<div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="clientFormLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clientFormLabel">Client Form</h5>
            </div>
            <form class="form-client" action="" method="post">
                @csrf

                <input type="hidden" id="u" name="u" value="">

                @include('pages.admin.clients.modals.body.fields')

                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-md close-modal">Close</button>
                    <button type="submit" class="btn btn-info btn-md">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
