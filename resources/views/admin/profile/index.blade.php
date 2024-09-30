@extends('admin.layouts.master')
@section('dashboard', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection

@push('style')
@endpush
@section('nav_menu', $data['title'])

@section('content')
    <div class="container-xl">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-column">
                            <form action="{{ route('admin.profile.update') }}" method="post" enctype="multipart/form-data">
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
                                        <div class="col-md-6">
                                            <div class="form-label">Name</div>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{$data['user']->name}}">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-label">Email</div>
                                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" required value="{{$data['user']->email}}">
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
                                        <a href="{{route('admin.dashboard')}}" class="btn">
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
                <form action="{{ route('admin.password.update') }}" method="post">
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