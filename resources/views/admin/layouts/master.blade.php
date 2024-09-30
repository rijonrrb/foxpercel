@php
    $setting = getSetting();
    $user = auth()->user();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/png" href="{{ getPhoto($setting->favicon) }}" />
    @include('admin.layouts.style')
    <style>
        .select2-container--default .select2-selection--single {
            height: 46px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px !important;
        }

        .select2-container--default .select2-selection--multiple {
            border-radius: 4px;
            border: 1px solid #ced4da;

            min-height: 46px !important;
        }

        .select2-container--default .select2-selection--multiple:focus-within {
            border-color: #ced4da;
            /* Change to your preferred focus color */
        }

        .select2-container--default .select2-dropdown .select2-search__field:focus,
        .select2-container--default .select2-search--inline .select2-search__field:focus {
            border: none !important;
        }


        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #1484cc;
            color: #fff;
            border-radius: 4px;
            border: none;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff;
            border: none;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: red;
            background-color: #1484cc;
            border: none;

        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            padding: 0;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
            color: white;

        }
    </style>
    @stack('style')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="page">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')
        <div class="page-wrapper">
            <!-- Page header -->
            @include('admin.layouts.header')
            <!-- Page body -->
            <div class="page-body">
                @yield('content')
            </div>
            <!-- Page footer -->
            @include('admin.layouts.footer')
        </div>

        {{-- Delete Modal --}}
        <div class="modal modal-blur fade" id="modal-danger" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-body text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z"></path>
                            <path d="M12 9v4"></path>
                            <path d="M12 17h.01"></path>
                        </svg>
                        <h3>Are you sure?</h3>
                        <div class="text-secondary">Do you really want to remove this? Once deleted, it will be permanently removed.</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <a href="#" class="btn w-100" id="cancelDelete" data-bs-dismiss="modal">Cancel</a>
                                </div>
                                <div class="col">
                                    <a href="#" class="btn btn-danger w-100" id="confirmDelete" data-bs-dismiss="modal">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    @include('admin.layouts.script')
    {{-- toastr javascript --}}
    {!! Toastr::message() !!}
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}', 'Error', {
                    closeButton: true,
                    progressBar: true,
                });
            @endforeach
        @endif
    </script>

    {{-- delete sweetalert2 --}}
    <script>
        $(document).on("click", "#deleteData", function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            $('#modal-danger').modal('show');
            $(document).on('click', '#confirmDelete', function() {
                window.location.href = link;
            });
            
            $(document).on('click', '#cancelDelete', function() {
                $('#modal-danger').modal('hide');
            });
        });
    </script>

    {{-- custom js area --}}
    @stack('script')
</body>

</html>

