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
