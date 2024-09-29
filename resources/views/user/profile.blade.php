@extends('user.layouts.master')
@section('dashboard', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection

@push('style')
@endpush
@section('nav_menu', 'Profile & account')

@section('content')
    <div class="container-xl">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-column">
                            <form action="{{ route('user.profile.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <h2 class="mb-4">My Account</h2>
                                    <h3 class="card-title">Profile Image</h3>
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="preview avatar avatar-xl" style="background-image: url('{{ getPhoto($data['user']->image) }}');"></span>
                                        </div>
                                        <div class="col-auto">
                                            <a href="javascript:void(0)" class="btn" id="changeAvatarBtn">
                                                Change avatar
                                            </a>
                                            <input type="file" name="image" id="image" accept="image/*" hidden>
                                        </div>
                                    </div>

                                    <h3 class="card-title mt-4">Profile Information</h3>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="form-label">Name</div>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{$data['user']->name}}">
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-label">Email</div>
                                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" required value="{{$data['user']->email}}">
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-label">Phone</div>
                                            <input type="text" name="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required
                                                class="form-control @error('phone') is-invalid @enderror" value="{{$data['user']->phone}}">
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-label">Address</div>
                                            <textarea name="address" id="address" class="form-control" cols="30" rows="5">{{$data['user']->address}}</textarea>
                                        </div>
                                    </div>
                                    <h3 class="card-title mt-4">Password</h3>
                                    <p class="card-subtitle">If you wish, you can set a new password by clicking 'Set New Password'</p>
                                    <div>
                                        <a href="#" class="btn" data-bs-toggle="modal"
                                            data-bs-target="#changePasswordModal">
                                            Set New Password
                                        </a>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent mt-auto">
                                    <div class="btn-list justify-content-end">
                                        <a href="{{route('user.dashboard')}}" class="btn">
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Password Edit Modal --}}
    <div class="modal modal-blur fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Form -->
                <form action="{{ route('user.password.update') }}" method="post">
                    @csrf
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <!-- Password Input -->
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <div class="input-group input-group-flat">
                                <input type="password" name="password" id="password" class="form-control" autocomplete="off" required>
                                <span class="input-group-text">
                                    <a href="javascript:void(0)" class="link-secondary" id="togglePasswordIcon" title="Show password">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                    </a>
                                </span>
                            </div>
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <div class="input-group input-group-flat">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" autocomplete="off" required>
                                <span class="input-group-text">
                                    <a href="javascript:void(0)" class="link-secondary" id="toggleConfirmPasswordIcon" title="Show password">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <a href="javascript:void(0)" class="btn btn-danger" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm_password');

            const togglePasswordIcon = document.querySelector('.input-group-text a#togglePasswordIcon');
            const toggleConfirmPasswordIcon = document.querySelector(
                '.input-group-text a#toggleConfirmPasswordIcon');

            let isPasswordVisible = false;
            let isConfirmPasswordVisible = false;

            // Toggle password visibility for "password" field
            togglePasswordIcon.addEventListener('click', function(e) {
                e.preventDefault();

                if (isPasswordVisible) {
                    passwordInput.type = 'password';
                    togglePasswordIcon.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" 
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                </svg>
            `;
                } else {
                    passwordInput.type = 'text';
                    togglePasswordIcon.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                     class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" />
                    <path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 
                             4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 
                             -2.138 2.87" />
                    <path d="M3 3l18 18" />
                </svg>
            `;
                }

                isPasswordVisible = !isPasswordVisible;
            });

            // Toggle password visibility for "confirm_password" field
            toggleConfirmPasswordIcon.addEventListener('click', function(e) {
                e.preventDefault();

                if (isConfirmPasswordVisible) {
                    confirmPasswordInput.type = 'password';
                    toggleConfirmPasswordIcon.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" 
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                </svg>
            `;
                } else {
                    confirmPasswordInput.type = 'text';
                    toggleConfirmPasswordIcon.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                     class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" />
                    <path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 
                             4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 
                             -2.138 2.87" />
                    <path d="M3 3l18 18" />
                </svg>
            `;
                }

                isConfirmPasswordVisible = !isConfirmPasswordVisible;
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const changeAvatarBtn = document.getElementById('changeAvatarBtn');
            const imageInput = document.getElementById('image');
            const preview = document.querySelector('.preview');
    
            changeAvatarBtn.addEventListener('click', function() {
                imageInput.click();
            });
    
            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.style.backgroundImage = `url(${e.target.result})`;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush


{{-- @extends('user.layouts.master')
@section('title') {{ $data['title'] ?? '' }} @endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-primary card-outline h-100">
                            <div class="card-body box-profile position-relative d-flex flex-column justify-content-center">
                                <a href="javascript:void(0)" class="position-absolute" style="right: 5px; top: 5px;"
                                    title="Edit" data-toggle="modal" data-target="#changePasswordModal">
                                    <i class="fa-solid fa-key"></i>
                                </a>
                                <div class="d-flex flex-column align-items-center">
                                    <h3 class="profile-username my-3 font-weight-bold">{{ $data['user']->name }}</h3>
                                    <div style="word-break: break-all;">
                                        @if (!empty($data['user']->email))
                                            <p class="text-muted"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                                    <path d="M3 7l9 6l9 -6" />
                                                </svg>&nbsp;
                                                {{ $data['user']->email }}</p>
                                        @endif

                                        @if (!empty($data['user']->phone))
                                            <p class="text-muted"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-phone">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                                </svg>&nbsp;
                                                {{ '+45 ' . $data['user']->phone }}</p>
                                        @endif

                                        @if (!empty($data['user']->address))
                                            <p class="text-muted"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                                    <path
                                                        d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                                                </svg>&nbsp;
                                                {{ $data['user']->address }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="card h-100">
                            <div class="card-body">
                                <form action="{{ route('user.profile.update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="name" value="{{ $data['user']->name }}"
                                                    id="name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label">Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="email" value="{{ $data['user']->email }}"
                                                    id="email" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Phone <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text shadow">+45</span>
                                                    <input type="tel" name="phone" id="phone"
                                                        value="{{ $data['user']->phone }}" class="form-control" required
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="address" class="form-lable">Address <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="address" id="address" class="form-control" required rows="3">{{ $data['user']->address }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
@push('script')
    <script>
        $(document).ready(function() {

            // password show hide
            $(".toggle-password").click(function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });

            $(".confirm-toggle-password").click(function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });

        })
    </script>
@endpush --}}
