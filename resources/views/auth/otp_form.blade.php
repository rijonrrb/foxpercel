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
                    <img src="./static/logo.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image">
                </a>
            </div> --}}
            <form class="card card-md" action="{{route('user.otp.verification')}}" method="post" autocomplete="off" novalidate>
                @csrf
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Authenticate Your Account</h2>
                    <p class="my-4 text-center">Please confirm your account by entering the authorization code sent to
                        <strong>{{auth()->user()->email}}</strong>.</p>
                    <div class="my-5">
                        <div class="row g-4">
                            <div class="col">
                                <div class="row g-2">
                                    <div class="col">
                                        <input type="text" class="form-control form-control-lg text-center py-3"
                                            maxlength="1" inputmode="numeric" pattern="[0-9]*" name="digit1" data-code-input />
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control form-control-lg text-center py-3"
                                            maxlength="1" inputmode="numeric" pattern="[0-9]*" name="digit2" data-code-input />
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control form-control-lg text-center py-3"
                                            maxlength="1" inputmode="numeric" pattern="[0-9]*" name="digit3" data-code-input />
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control form-control-lg text-center py-3"
                                            maxlength="1" inputmode="numeric" pattern="[0-9]*" name="digit4" data-code-input />
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control form-control-lg text-center py-3"
                                            maxlength="1" inputmode="numeric" pattern="[0-9]*" name="digit5" data-code-input />
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control form-control-lg text-center py-3"
                                            maxlength="1" inputmode="numeric" pattern="[0-9]*" name="digit6" data-code-input />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-footer">
                        <div class="btn-list flex-nowrap">
                            {{-- <a href="{{route('home')}}" class="btn w-100">
                                Cancel
                            </a> --}}
                            <button type="submit" class="btn btn-primary w-100">
                                Verify
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="text-center text-secondary mt-3">
                It may take a minute to receive your code. Haven't received it? <a href="{{route('user.otp.send')}}">Resend a new code.</a>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var inputs = document.querySelectorAll('[data-code-input]');
        for(let i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener('input', function(e) {
                if(e.target.value.length === e.target.maxLength && i + 1 < inputs.length) {
                    inputs[i + 1].focus();
                }
            });
            inputs[i].addEventListener('keydown', function(e) {
                if(e.target.value.length === 0 && e.keyCode === 8 && i > 0) {
                    inputs[i - 1].focus();
                }
            });
        }
    });
</script>
@endpush
