<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $settings->seo_title ?? 'defcon-app.com' }}</title>
        <!-- meta -->
        <meta name="robots" content="index,follow">
        <meta name="googlebot" content="index,follow">
        <meta name="author" content="Rabin Mia, Md. Shakib Hossain Rijon" />
        <meta name="Developed By" content="Arobil Ltd" />
        <meta name="Developer" content="Arobil Team" />
        <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ $settings->seo_meta_description }}">
        <meta property="og:image" content="{{getPhoto($settings->site_logo)}}" />
        <meta property="og:site_name" content="{{ config('app.name', $settings->seo_title) }}">
        <meta property="og:title" content="{{ $settings->seo_title}}">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:type" content="article">
        <meta property="og:description" content="{{ $settings->seo_meta_description }}">
        <!-- favicon -->
        <link rel="icon" type="image/png" sizes="16x16" href="{{getPhoto($settings->favicon)}}" />
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
                max-width: 750px;
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
            .btn-google{
                background: #4285F4 !important;
                font-size: 14px;
                color: #fff !important;
                padding: 4px 14px 4px 4px !important;
            }
            .btn-google img {
                width: 40px;
                background: #fff;
                padding: 7px;
                border-radius: 18px;
                margin-right: 6px;
            }
            .message-box {
                font-family: sans-serif;
                text-align: center;
                padding: 20px;
                line-height: 35px;
            }

            .message-box p {
                font-size: 18px;
                color: #666666;
                text-transform: uppercase;
            }
        </style>
    </head>
    <body class="template">
        <div class="container">
            <div class="signin_form p-5 bg-white">
                <div class="mb-3 text-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ getLogo($settings->site_logo) }}" width="150" alt="logo">
                    </a>
                </div>
                <div class="message-box">
                    <p style="font-weight: bold; color: #e11919;">Alarm is not available!</p>
                </div>
            </div>
        </div>
    </body>
</html>

