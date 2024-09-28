@php
    $setting = getSetting();
    $user = auth()->user();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" type="image/png" href="{{ getPhoto($setting->favicon) }}" />
        @include('user.layouts.style')
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
        <link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
      
    <body>
        <div class="page">
          <!-- Sidebar -->
            @include('user.layouts.sidebar')
          <div class="page-wrapper">
            <!-- Page header -->
                @include('user.layouts.header')
            <!-- Page body -->
            <div class="page-body">
                @yield('content')
            </div>
            <!-- Page footer -->
            @include('user.layouts.footer')
          </div>
        </div>
        @include('user.layouts.script')
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

        {{-- custom js area --}}
        @stack('script')
      </body>
</html>
