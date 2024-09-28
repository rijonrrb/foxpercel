@extends('auth.layouts.app')

@push('style')
<style>
    @import url('https://rsms.me/inter/inter.css');
    :root {
        --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }
    body {
        font-feature-settings: "cv03", "cv04", "cv11";
    }
</style>
@endpush

@php
    $settings = getSetting();
@endphp

@section('content')
<div class="auth-page page page-center">
    <div class="container container-tight py-4">
      {{-- <div class="text-center mb-4">
        <a href="." class="navbar-brand navbar-brand-autodark">
          <img src="{{ getLogo($settings->site_logo) }}" width="110" height="32" alt="Tabler" class="navbar-brand-image">
        </a>
      </div> --}}
      <form class="card card-md" action="{{ route('register') }}" method="post" autocomplete="off">
        @csrf
        <div class="card-body">
          <h2 class="card-title text-center mb-4">Create new account</h2>
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" required>
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" required>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="tel" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone number"
                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror            
          </div>
          <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" id="address" cols="30" rows="4" class="form-control" placeholder="Enter Address">{{ old('address') }}</textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group input-group-flat">
              <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Your password" autocomplete="off" required>
              <span class="input-group-text">
                <a href="javascript:void(0)" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" 
                      stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                  </svg>
                </a>
              </span>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{-- <div class="mb-3">
            <label class="form-check">
              <input type="checkbox" class="form-check-input"/>
              <span class="form-check-label">Agree the <a href="./terms-of-service.html" tabindex="-1">terms and policy</a>.</span>
            </label>
          </div> --}}
          <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Create new account</button>
          </div>
        </div>
      </form>
      <div class="text-center text-secondary mt-3">
        Already have account? <a href="{{ route('login') }}" tabindex="-1">Sign in</a>
      </div>
    </div>
  </div>
@endsection

@push('script')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const togglePasswordIcon = document.querySelector('.input-group-text a');
    let isPasswordVisible = false;

    togglePasswordIcon.addEventListener('click', function (e) {
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

        // Toggle the visibility state
        isPasswordVisible = !isPasswordVisible;
    });
});
</script>
@endpush