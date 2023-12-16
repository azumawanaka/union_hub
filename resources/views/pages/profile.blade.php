@extends('layouts.user')
@section('content')

<div class="row">
    <div class="col-md-4 text-center">
        <h2 class="mb-4">Profile Picture</h2>
        <div id="profilePictureContainer">
            <img id="profilePicturePreview" class="" alt="Profile Preview">
            <img id="dummyProfilePicture" class="" src="dummy-profile-picture.jpg" alt="Dummy Profile Picture">
            <label id="uploadButton" for="profilePictureInput">Upload</label>
            <input type="file" class="form-control visually-hidden" id="profilePictureInput" name="profilePicture" onchange="previewImage()">
        </div>
        <div id="userInfo">
            <h3>User Information</h3>
            <p><i class="fa fa-user fa-icon"></i> John Doe</p>
            <p><i class="fa fa-envelope fa-icon"></i> john.doe@example.com</p>
            <p><i class="fa fa-mobile fa-icon"></i> +1 123-456-7890</p>
            <!-- Add more user information as needed -->
        </div>
      </div>
    <div class="col-md-8">
        <h2 class="mb-4">Edit Profile</h2>
        <form id="editProfileForm">
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="tel" class="form-control" id="mobile" name="mobile" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="gender" id="male" value="male" checked>
                  <label class="form-check-label" for="male">
                    Male
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                  <label class="form-check-label" for="female">
                    Female
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="gender" id="other" value="other">
                  <label class="form-check-label" for="other">
                    Other
                  </label>
                </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="submitForm()">Save Changes</button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
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
        } else {
        preview.src = "";
        preview.style.display = 'none';
        dummyProfilePicture.style.display = 'block';
        }
    }


    function submitForm() {
      // Get form data
      var formData = new FormData(document.getElementById('editProfileForm'));

      // Send AJAX POST request
      $.ajax({
        type: 'POST',
        url: 'your_backend_endpoint_url',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          // Handle success
          console.log('Profile updated successfully:', response);
        },
        error: function(error) {
          // Handle error
          console.error('Error updating profile:', error);
        }
      });
    }
  </script>
@endpush
