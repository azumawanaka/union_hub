@extends('layouts.user')
@section('content')

<div class="row">
    <div class="col-lg-4 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="media align-items-center mb-4">
                    <div id="profilePictureContainer">
                        <img id="profilePicturePreview"
                            src="{{ !auth()->user()->photo ? asset('assets/images/user/sample.png') : asset(auth()->user()->photo) }}"
                            alt="Profile Preview">
                        <img id="dummyProfilePicture"
                            src="{{ !auth()->user()->photo ? asset('assets/images/user/sample.png') : asset(auth()->user()->photo) }}"
                            alt="Dummy Profile Picture">
                        <label id="uploadButton" for="profilePictureInput">Upload</label>
                        <input type="file" class="form-control visually-hidden" id="profilePictureInput"
                            src="{{ !auth()->user()->photo ? asset('assets/images/user/sample.png') : asset(auth()->user()->photo) }}"
                            name="profilePicture"
                            onchange="previewImage()">
                    </div>
                    <div class="media-body">
                        <h4 class="mb-0">{{ auth()->user()->full_name }}</h4>
                        <p class="text-muted mb-0">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="mr-1">
                        <div class="card card-profile text-center px-2">
                            <span class="mb-1 text-primary"><i class="icon-globe"></i></span>
                            <h3 class="mb-0">{{ auth()->user()->total_attended_events }}</h3>
                            <p class="text-muted px-4">Attended Events</p>
                        </div>
                    </div>
                    <div class="ml-1">
                        <div class="card card-profile text-center px-2">
                            <span class="mb-1 text-warning"><i class="icon-list"></i></span>
                            <h3 class="mb-0">{{ auth()->user()->total_service_requests }}</h3>
                            <p class="text-muted">Requested Services</p>
                        </div>
                    </div>
                </div>

                <ul class="card-profile__info">
                    <li><strong class="text-dark mr-4">Mobile</strong> <span>{{ auth()->user()->mobile ?? 'none' }}</span></li>
                    <li><strong class="text-dark mr-4">Address</strong> <span>{{ auth()->user()->address ?? 'none' }}</span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-xl-9">
        <div class="card">
            <div class="card-body">
                <h2 class="mb-4">Edit Profile</h2>
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
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/validation/jquery.validate.min.js') }}"></script>

@vite(['resources/js/validator.js'])

<script>
    function previewImage() {
        var input = document.getElementById('profilePictureInput');
        var preview = document.getElementById('profilePicturePreview');
        var dummyProfilePicture = document.getElementById('dummyProfilePicture');
        var file = input.files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
            preview.style.display = 'block';
            dummyProfilePicture.style.display = 'none';
        };

        if (file) {
            reader.readAsDataURL(file);

            // Use Axios to make a POST request
            const formData = new FormData();
            formData.append('profile_picture', file);

            window.axios.post('/upload-photo', formData)
                .then(response => {
                    triggerToaster(response.data.message);
                })
                .catch(error => {
                    triggerErrorToaster(response.data.message)
                });
        } else {
            preview.src = "";
            preview.style.display = 'none';
            dummyProfilePicture.style.display = 'block';
        }
    }


    $(document).on('submit', '#editProfileForm', function(event) {
        event.preventDefault();

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            url: url,
            type: 'PUT',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                triggerToaster(response.message);
            },
            error: function(error) {
                // error message here
            }
        });
    });
  </script>
@endpush
