<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - {{ config('app.name', $settings->site_name) }}</title>
    <!-- meta -->
    <meta name="robots" content="index,follow">
    <meta name="googlebot" content="index,follow">
    <meta name="author" content="Rabin Mia, Md. Shakib Hossain Rijon" />
    <meta name="Developed By" content="Arobil Ltd" />
    <meta name="Developer" content="Arobil Team" />
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $settings->seo_meta_description }}">
    <meta property="og:image" content="{{getPhoto($settings->site_logo)}}" />
    <meta property="og:site_name" content="{{ config('app.name', $settings->site_name) }}">
    <meta property="og:title" content="Home - {{ config('app.name', $settings->site_name) }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="article">
    <meta property="og:description" content="{{ $settings->seo_meta_description }}">
    <!-- favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{getPhoto($settings->favicon)}}" />
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css?v=3.6') }}">
    <style>
        .table td {
            padding: 20px 15px !important;
            border: 1px solid #fafafa !important;
            background: transparent !important;
        }

    </style>
</head>

<body>
    <div class="template">
        <div class="container-fluid">
            <div class="row">
                <div class="">
                    <div class="d-sm-flex align-items-center justify-content-between mb-5 mt-2">
                        <div class="mb-3 mb-sm-0 col-md-3">
                            <img src="{{getPhoto($settings->site_logo)}}" class="img-fluid" width="150" alt="logo">
                        </div>
                        <div class="title text-center col-md-3">
                            <h4 style="color: {{$level_color}}">Current DEFCON Level: 
                                {{ $level_title }}
                            </h4>
                        </div>
                        <div class="col-md-3">
                            <div class="row align-items-center">
                                <div class="col-2 col-lg-2 col-md-3">
                                    @auth
                                    <a href="{{ route('logout') }}" class="btn btn-danger"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{__('Logout') }}</a>
                                    <form class="logout" id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
                                    @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">{{__('Login') }}</a>
                                    @endauth
                                </div>
                                <div class="col-10 col-lg-10 col-md-9">
                                    <form action="{{route('home')}}" method="get" class="d-flex align-items-center">
                                        <select name="defcon_level" id="defcon_level" class="form-control form-select" onchange="this.form.submit()">
                                            @foreach ($defcon_levels as $defcon)
                                                <option value="{{ $defcon->id }}" {{ $selectedDefconLevel == $defcon->id ? 'selected' : '' }}>
                                                    {{ $defcon->defcon_level }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table table-responsive">
                        <table class="table table-striped m-0 align-middle shadow-lg">
                            <thead>
                                <tr>
                                    <th style="width:5%;">Alarm Level</th>
                                    <th style="width:10%;">Description</th>
                                    <th style="width:10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $key => $row)                               
                                <tr style="background: {{$row->level?->color}} !important;">
                                    <td>{{$row->level?->defcon_level}}</td>
                                    <td style="text-wrap: balance;">{!! nl2br(e($row->description)) !!}</td>
                                    <td style="text-wrap: balance;">{!! nl2br(e($row->action)) !!}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- js -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</body>

</html>
