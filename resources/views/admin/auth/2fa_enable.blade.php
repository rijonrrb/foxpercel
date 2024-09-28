@php
$settings = getSetting();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
                max-width: 550px;
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
            .panel-body {
                text-align: center;
                font-family: sans-serif;
                font-size: large;
            }
        </style>
    </head>
    
    <body style="background-color: #FFF7F3;">
        <!--  SignIn  -->
        <div class="signin_sec template">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8 col-lg-8 col-xl-8">
                        <div class="signin_form p-5 bg-white">
                            <div class="mb-5 text-center">
                                <h3>Setup Google Authenticator</h3>
                            </div>
            
                            <div class="panel-body" style="text-align: center;">
                                <p>Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code {{ $secret }}</p>
                                <div>
                                    <img src="{{ $QR_Image }}">
                                </div>
                                <p>You must set up your Google Authenticator app before continuing. You will be unable to login otherwise</p>
                                <div>
                                    <a  href="{{route('admin.2fa.enabled')}}" class="btn btn-primary w-100 py-2">Complete 2FA</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- js file -->
        @include('frontend.layouts.script')
    </body>
</html>
