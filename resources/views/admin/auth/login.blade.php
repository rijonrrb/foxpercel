@php
$settings = getSetting();
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() ?? 'en' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="index,follow">
    <meta name="googlebot" content="index,follow">
    <meta name="author" content="Rabin Mia, Md. Shakib Hossain Rijon" />
    <meta name="Developed By" content="Arobil Ltd" />
    <meta name="Developer" content="Arobil Team" />
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $settings->seo_meta_description }}">
    <meta property="og:image" content="{{getPhoto($settings->site_logo)}}" />
    <meta property="og:site_name" content="{{ config('app.name', $settings->site_name) }}">
    <meta property="og:title" content=">Home - {{ config('app.name', $settings->site_name) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
    <meta property="og:description" content="{{ $settings->seo_meta_description }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{getPhoto($settings->favicon)}}" />
    <title>{{ $settings->site_name }}</title>
    @include('frontend.layouts.style')
    <style>
        .signin_form {
            background: #fff !important;
            border: 1px solid #DDD;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 450px;
            border-radius: 5px;
        }
    
        .btn-primary {
            height: 49px;
            border-radius: 2px;
            font-size: 16px;
            font-family: 'Raleway', sans-serif;
            font-weight: bold;
            text-transform: uppercase;
        }
    
        .form-label {
            font-size: 13px;
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
        }
    
        .form-control {
            height: 50px;
            border: 1px solid #EEE;
            font-size: 14px;
            font-family: 'Raleway', sans-serif;
            font-weight: 500;
            outline: none !important;
            box-shadow: none !important;
        }
    
        .form-control::placeholder {
            color: #BBB;
        }
    </style>
</head>

<body>
    <!--  SignIn  -->
    <div class="signin_sec template">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-lg-5 col-xl-5">
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <div class="signin_form p-3  p-md-5 bg-white">
                            <div class="mb-5 text-center">
                                <a href="{{ route('home') }}">
                                    <img src="{{ getLogo($settings->site_logo) }}" width="150" alt="logo">
                                </a>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Admin Email') }}</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    placeholder="Enter your email" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Admin Password') }}</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter your password" required>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">{{ __('Sign In') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- js file -->
    @include('frontend.layouts.script')
</body>

</html>
