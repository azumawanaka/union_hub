<form id="editProfileForm" class="form-profile" action="{{ route('users.update_user', auth()->user()->id) }}" method="post">
    <input type="hidden" id="u" name="u" value="{{ auth()->user()->id }}">
    <div class="form-validation">
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="first_name">First Name <span class="text-danger">*</span></label>
            <div class="col-lg-12">
                <input type="text" class="form-control" id="first_name" value="{{ auth()->user()->first_name }}" name="first_name">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="last_name">Last Name</label>
            <div class="col-lg-12">
                <input type="text" class="form-control" id="last_name" value="{{ auth()->user()->last_name }}" name="last_name">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="email">Email</label>
            <div class="col-lg-12">
                <input type="text" class="form-control" name="email" value="{{ auth()->user()->email }}" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="address">Address</label>
            <div class="col-lg-12">
                <textarea class="form-control" id="address" name="address" value="{{ auth()->user()->address }}" rows="3">{!! auth()->user()->address !!}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-12 col-form-label" for="mobile">Mobile</label>
            <div class="col-lg-12">
                <input type="tel" class="form-control" id="mobile" name="mobile" value="{{ auth()->user()->mobile }}">
                <small class="help-block"><i class="fa fa-warning"> +63123456789 OR 09123456789</i></small>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Gender</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ auth()->user()->gender == 'male' ? 'checked' : '' }}>
                <label class="form-check-label" for="male">
                    Male
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="female" value="female"  {{ auth()->user()->gender == 'female' ? 'checked' : '' }}>
                <label class="form-check-label" for="female">
                    Female
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="other" value="other"  {{ auth()->user()->gender != 'male' && auth()->user()->gender != 'female' ? 'checked' : '' }}>
                <label class="form-check-label" for="other">
                    Other
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-info">Save Changes</button>
    </div>
</form>
