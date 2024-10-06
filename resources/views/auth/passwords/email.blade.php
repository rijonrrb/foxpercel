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
      <a href="{{route('login')}}" class="navbar-brand navbar-brand-autodark">
        <img src="{{ getLogo($settings->site_logo) }}" width="110" height="32" alt="Tabler" class="navbar-brand-image">
      </a>
    </div>  --}}
            <form method="POST" action="{{ route('password.email') }}" class="card card-md" id="password-reset-form">
                @csrf
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Forgot password</h2>
                    <p class="text-secondary mb-4">Enter your email address and your password will be reset and emailed to
                        you.</p>
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            placeholder="Enter email" required autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100" id="submit-button">
                            <span class="spinner-border spinner-border-sm d-none icon" id="spinner" role="status"
                                aria-hidden="true"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" id="mail" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                <path d="M3 7l9 6l9 -6" />
                            </svg>
                            Send me new password
                        </button>
                    </div>
                </div>
            </form>
            <div class="text-center text-secondary mt-3">
                Forget it, <a href="{{ route('login') }}">send me back</a> to the sign in screen.
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.getElementById('password-reset-form').addEventListener('submit', function() {
            var submitButton = document.getElementById('submit-button');
            var spinner = document.getElementById('spinner');
            var mailbox = document.getElementById('mail');

            // Disable the button and show the spinner
            submitButton.disabled = true;
            spinner.classList.remove('d-none');
            mailbox.classList.add('d-none');
        });
    </script>
@endpush
