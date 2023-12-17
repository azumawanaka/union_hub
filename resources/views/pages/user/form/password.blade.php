<form id="updatePasswordForm" class="form-password" action="{{ route('users.update_password', auth()->user()->id) }}" method="post">
    <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
    <div class="form-validation">
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="old_password">Old Password <span class="text-danger">*</span></label>
            <div class="col-lg-12">
                <input type="password" class="form-control" id="old_password" value="" name="old_password">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="new_password">New Password <span class="text-danger">*</span></label>
            <div class="col-lg-12">
                <input type="password" class="form-control" id="new_password" value="" name="new_password">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-info">Save Changes</button>
</form>
