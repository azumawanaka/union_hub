<div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="responseFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="responseFormLabel">Response Form</h5>
            </div>
            <form id="form-response" action="" method="post">
                @csrf

                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-lg-12 col-form-label" for="note">Note</label>
                        <div class="col-lg-12">
                            <textarea class="form-control" id="note" name="note" rows="5" placeholder="Write your note here..."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="radio-inline mr-3">
                            <input type="radio" name="status" value="ongoing" checked> Ongoing</label>
                        <label class="radio-inline mr-3">
                            <input type="radio" name="status" value="declined"> Decline</label>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="done"> Done</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-md close-modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info btn-md">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
