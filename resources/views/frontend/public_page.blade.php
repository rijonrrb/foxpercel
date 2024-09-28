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
    <meta name="Developed By" content="defcon-app.com" />
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $settings->seo_meta_description }}">
    <meta property="og:image" content="{{getPhoto($settings->site_logo)}}" />
    <meta property="og:site_name" content="{{ config('app.name', $settings->seo_title) }}">
    <meta property="og:title" content="{{ $settings->seo_title }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="article">
    <meta property="og:description" content="{{ $settings->seo_meta_description }}">
    <!-- favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{getPhoto($settings->favicon)}}" />
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css?v=3.6') }}">
    <style>
        @media (max-width: 768px) {
            .title h4 {
                font-size: 20px !important;
            }
            .table th, .table td {
                font-size: 14px !important;
            }
        }
    </style>
</head>

<body>
    <div class="template">
        <div class="container-fluid pb-5 pt-4 position-relative">
            <div class="text-end pe-2">
                <button class="btn bg-transparent border-0 text-white" data-widget="fullscreen" role="button" data-toggle="tooltip"  id="fullscreenToggle" onclick="toggleFullscreen()">
                    <span id="fullscreenIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrows-maximize">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M16 4l4 0l0 4" />
                            <path d="M14 10l6 -6" />
                            <path d="M8 20l-4 0l0 -4" />
                            <path d="M4 20l6 -6" />
                            <path d="M16 20l4 0l0 -4" />
                            <path d="M14 14l6 6" />
                            <path d="M8 4l-4 0l0 4" />
                            <path d="M4 4l6 6" />
                        </svg>
                    </span>
                </button>
            </div>
            <div class="row">
                <div class="mt-3">
                    <div class="text-center mb-4">
                        <div class="mb-5">
                            <div class="logo">
                                <img src="{{getPhoto($settings->site_logo)}}" class="img-fluid" width="150" alt="logo">
                            </div>
                        </div>
                        @if(!empty($level_title))
                        <div class="title text-center mb-5">
                            <h4 class="text-uppercase" style="color: {{$level_color}}">
                                {{ $settings->alarm_label ? $settings->alarm_label : 'Current DEFCON Level' }}: {{ $level_title }}
                            </h4>
                        </div>
                        @endif
                        {{-- <div class="col-md-3">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <form action="{{route('public.page', $slug)}}" method="get" class="d-flex align-items-center">
                                        <select name="defcon_level" id="defcon_level" class="form-control form-select" onchange="this.form.submit()">
                                            <option value="" class="d-none">Change DEFCON Level</option>
                                            @foreach ($defcon_levels as $defcon)
                                            <option value="{{ $defcon->id }}" {{ $selectedDefconLevel == $defcon->id ? 'selected' : '' }}>
                                                {{ $defcon->defcon_level }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="defcon_table position-relative">
                        <div class="table-responsive">
                            <table class="table table-striped m-0 align-middle shadow-lg">
                                <thead>
                                    <tr class="border-0">
                                        <th style="width:5%;" class="{{ is_numeric($settings->table_heading_1) ? 'text-center' : 'text-start' }}">
                                            {{ $settings->table_heading_1 ? $settings->table_heading_1 : 'Alarm Level' }}</th>
                                        <th style="width:10%;" class="{{ is_numeric($settings->table_heading_2) ? 'text-center' : 'text-start' }}">
                                            {{ $settings->table_heading_2 ? $settings->table_heading_2 : 'Description' }}</th>
                                        <th style="width:10%;" class="{{ is_numeric($settings->table_heading_3) ? 'text-center' : 'text-start' }}">
                                            {{ $settings->table_heading_3 ? $settings->table_heading_3 : 'Action' }}</th>
                                    </tr>
                                </thead>
                                <tbody id="alarm-table-body">
                                    @include('frontend.partials.alarm_table', ['rows' => $rows])
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        function toggleFullscreen() {
            const iconElement = document.getElementById('fullscreenIcon');
            const tooltipElement = document.getElementById('fullscreenToggle');

            if (!document.fullscreenElement) {
                // Enter fullscreen
                document.documentElement.requestFullscreen();

                // Change the icon to minimize and update tooltip
                iconElement.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrows-minimize">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M5 9l4 0l0 -4" />
                        <path d="M3 3l6 6" />
                        <path d="M5 15l4 0l0 4" />
                        <path d="M3 21l6 -6" />
                        <path d="M19 9l-4 0l0 -4" />
                        <path d="M15 9l6 -6" />
                        <path d="M19 15l-4 0l0 4" />
                        <path d="M15 15l6 6" />
                    </svg>`;
                tooltipElement.setAttribute('title', 'Minimize');
                $('[data-toggle="tooltip"]').tooltip('hide').attr('data-original-title', 'Minimize').tooltip('show'); // Update tooltip text
            } else {
                // Exit fullscreen
                if (document.exitFullscreen) {
                    document.exitFullscreen();

                    // Change the icon back to maximize and update tooltip
                    iconElement.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrows-maximize">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M16 4l4 0l0 4" />
                            <path d="M14 10l6 -6" />
                            <path d="M8 20l-4 0l0 -4" />
                            <path d="M4 20l6 -6" />
                            <path d="M16 20l4 0l0 -4" />
                            <path d="M14 14l6 6" />
                            <path d="M8 4l-4 0l0 4" />
                            <path d="M4 4l6 6" />
                        </svg>`;
                    tooltipElement.setAttribute('title', 'Full Screen');
                    $('[data-toggle="tooltip"]').tooltip('hide').attr('data-original-title', 'Full Screen').tooltip('show'); // Update tooltip text
                }
            }
        }
    </script>

    <script>
        function fetchAlarmTable() {
            $.ajax({
                url: "{{ route('public.page', $slug) }}",
                type: 'GET',
                success: function (response) {
                    $('#alarm-table-body').html(response.table);

                    if (response.level_title && response.level_color) {
                        $('.title h4').html(response.alarm_label + ': ' + response.level_title);
                        $('.title h4').css('color', response.level_color);
                    }
                },
                error: function () {
                    console.log('Unable to fetching alarm table');
                }
            });
        }

        setInterval(fetchAlarmTable, 10000);
    </script>
</body>

</html>
