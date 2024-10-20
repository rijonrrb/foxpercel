@extends('admin.layouts.master')
@section('customer', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection
@section('nav_menu', $data['title'])

@section('content')
    <div class="container-xl">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-column">
                            <form action="{{ route('admin.customer.create') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <h2 class="mb-4">User Information</h2>
                                    <h3 class="card-title">Profile Image</h3>
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="preview avatar avatar-xl" style="background-image: url('{{ getPhoto('') }}');"></span>
                                        </div>
                                        <div class="col-auto">
                                            <a href="javascript:void(0)" class="btn" id="changeAvatarBtn">
                                                Change avatar
                                            </a>
                                            <input type="file" name="image" id="image" accept="image/*" hidden>
                                        </div>
                                    </div>
                                    <div class="row g-3 my-3">
                                        <div class="col-md-6">
                                            <div class="form-label">Name</div>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                               placeholder="User Name" required value="{{old('name')}}">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-label">Email</div>
                                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" 
                                                placeholder="User Email" required value="{{old('email')}}">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-label">Phone</div>
                                            <input type="text" name="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required
                                                class="form-control @error('phone') is-invalid @enderror" value="{{old('phone')}}" placeholder="User Phone">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-label">Password</div>
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
                                        <div class="col-md-6">
                                            <div class="form-label">Published Status</div>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="1" {{ old('status') == 1 ? "selected" : "" }}>Active</option>
                                                <option value="0" {{ old('status') == 0 ? "selected" : "" }}>Inactive</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-label">Address</div>
                                            <textarea name="address" id="address" class="form-control" cols="30" rows="5" placeholder="User Address">{{old('address')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent mt-auto">
                                    <div class="btn-list justify-content-end">
                                        <a href="{{route('admin.customer.index')}}" class="btn">
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

@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const togglePasswordIcon = document.querySelector('.input-group-text a#togglePasswordIcon');
            let isPasswordVisible = false;

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