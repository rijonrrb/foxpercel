<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('tabler/js/demo-theme.min.js?v=1') }}"></script>
<script src="{{ asset('tabler/js/tabler.min.js?v=1') }}" defer></script>
<script src="{{ asset('tabler/js/demo.min.js?v=1') }}" defer></script>
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
    @if (session('success'))
        toastr.success('{{ session('success') }}', 'Success', {
            closeButton: true,
            progressBar: true,
        });
    @endif
</script>