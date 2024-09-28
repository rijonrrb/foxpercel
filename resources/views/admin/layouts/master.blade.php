<!DOCTYPE html>
<html lang="en">
@php
    $setting = getSetting();
@endphp

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, minimum-scale=1, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <link rel="icon" type="image/png" href="{{ asset($setting->favicon) }}" />


    <title>@yield('title') - {{ config('app.name', 'defcon-app.com') }}</title>

    {{-- style --}}
    @include('admin.layouts.style')

    {{-- toastr style --}}
    <link rel="stylesheet" href="{{ asset('massage/toastr/toastr.css') }}">
    {{-- custom style --}}
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
            border-color: #ced4da; /* Change to your preferred focus color */
        }
        .select2-container--default .select2-dropdown .select2-search__field:focus, .select2-container--default
        .select2-search--inline .select2-search__field:focus{
            border: none !important;
        }


        .select2-container--default .select2-selection--multiple .select2-selection__choice {

            background-color: #007bff;
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
            background-color: #007bff;
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
    <link href="https://adminlte.io/themes/v3/plugins/summernote/summernote-bs4.min.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        {{-- header area --}}
        @include('admin.layouts.header')
        {{-- sidebar area --}}
        @include('admin.layouts.sidebar')
        {{-- main content --}}
        @yield('content')
        {{-- footer --}}
        @include('admin.layouts.footer')

        {{-- javascript --}}
        @include('admin.layouts.script')

    </div>
    {{-- toastr javascript --}}
    <script src="{{ asset('massage/toastr/toastr.js') }}"></script>
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

    {{-- <script>
        $('#dataTables').DataTable({
            "paging": true,
            "ordering": false,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "pageLength": 10
        });
    </script> --}}

    {{-- delete sweetalert2 --}}
    <script>
        $(document).on("click", "#deleteData", function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            Swal.fire({
                title: 'Are you want to delete?',
                text: "Once Delete, This will be Permanently Delete!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#8bc34a',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    window.location.href = link;
                }
            })
        })
    </script>

    {{-- summernote --}}
    <script>
        $('.summernote').summernote({
            height: 200,
        })
        $('.select2').select2()
    </script>

<script>
    $(document).ready(function() {
        $('#ip_address').select2({
            tags: true,
            tokenSeparators: [',', ' '],

        });
    });
</script>

    {{-- custom js area --}}
    @stack('script')

</body>

</html>
