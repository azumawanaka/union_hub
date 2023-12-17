@extends('layouts.user')
@section('content')

<div class="row">
    <div class="col-lg-4 col-xl-3">
        @include('pages.user.form.profile')
    </div>
    <div class="col-lg-8 col-xl-9">
        <div class="card">
            <div class="card-body">
                <h2 class="mb-4">Edit Profile</h2>
                @include('pages.user.form.edit')
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
