@extends('layouts.auth')

@section('content')

<div class="login-form-bg h-100" style="background-image: url('assets/images/planting.jpg')">
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-xl-6">
                <div class="form-input-content">
                    <div class="card login-form mb-0">
                        <div class="text-center pt-3">
                            <img src="{{ asset('assets/images/logo.png') }}" width="100" />
                            <h4 class="text-center pt-2">Union Hub</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}" class="mb-5 login-input">
                                @csrf
                                <div class="form-group">
                                    <input id="first_name"
                                        type="text"
                                        class="form-control @error('first_name') is-invalid @enderror"
                                        name="first_name"
                                        value="{{ old('first_name') }}"
                                        required
                                        autofocus
                                        placeholder="Enter name">

                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="email"
                                        type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required
                                        autocomplete="email"
                                        autofocus
                                        placeholder="Email Address">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="password"
                                        type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                        placeholder="Enter password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="password-confirm"
                                        type="password"
                                        class="form-control"
                                        name="password_confirmation"
                                        required
                                        autocomplete="new-password"
                                        placeholder="Re-enter password">
                                </div>
                                <button type="submit" class="btn login-form__btn submit w-100 text-white">{{ __('Register') }}</button>
                            </form>
                            <p class="mt-5 login-form__footer">Already have account? <a href="{{ route('login') }}" class="text-primary">Sign In</a> now</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/common/common.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.min.js') }}"></script>
<script src="{{ asset('assets/js/settings.js') }}"></script>
<script src="{{ asset('assets/js/gleek.js') }}"></script>
<script src="{{ asset('assets/js/styleSwitcher.js') }}"></script>
@endpush
