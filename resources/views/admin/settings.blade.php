@extends('admin.layouts.master')
@section('setting', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection

@push('style')
@endpush
@section('nav_menu', $data['title'])

@section('content')
    <div class="container-xl">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card-header">
                                <h3 class="card-title">Site Settings</h3>
                            </div>
                            <form action="{{ route('admin.settings.general_store') }}" method="post"
                                enctype="multipart/form-data" id="settingUpdate">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <img src="{{ getPhoto($settings->site_logo) }}" height="50px" />
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Site Logo') }} <span class="text-danger">
                                                        ({{ __('Recommended size : 180x60') }})</span>
                                                </div>
                                                <input type="file" class="form-control" name="site_logo"
                                                    placeholder="{{ __('Site Logo') }}..."
                                                    accept=".png,.jpg,.jpeg,.gif,.svg" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            @if ($settings->favicon)
                                                <img src="{{ getPhoto($settings->favicon) }}" height="50px" />
                                            @endif
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Favicon') }} <span class="text-danger">
                                                        ({{ __('Recommended size : 200x200') }})</span>
                                                </div>
                                                <input type="file" class="form-control" name="favicon"
                                                    placeholder="{{ __('Favicon') }}..."
                                                    accept=".png,.jpg,.jpeg,.gif,.svg" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('App Name') }}</label>
                                                <input type="text" class="form-control" name="app_name"
                                                    value="{{ config('app.name') }}" placeholder="{{ __('App Name') }}..."
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Site Name') }}</label>
                                                <input type="text" class="form-control" name="site_name"
                                                    value="{{ $settings->site_name }}"
                                                    placeholder="{{ __('Site Name') }}..." required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Site Title') }}</label>
                                                <input type="text" class="form-control" name="site_title"
                                                    value="{{ $settings->site_title }}"
                                                    placeholder="{{ __('Site Title') }}..." required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('OTP Verification') }}</label>
                                                <select class="form-select form-control" name="authenticator" required>
                                                    <option value="0"
                                                        {{ $settings->authenticator == '0' ? 'selected' : '' }}>
                                                        {{ __('Disabled') }}</option>
                                                    <option value="1"
                                                        {{ $settings->authenticator == '1' ? 'selected' : '' }}>
                                                        {{ __('Enabled') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent mt-auto">
                                    <div class="btn-list justify-content-end">
                                        <a href="{{ route('admin.dashboard') }}" class="btn">
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            Update
                                        </button>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        const form = document.getElementById("settingUpdate");
        const submitButton = form.querySelector("button[type='submit']");

        form.addEventListener("submit", function() {

            $("#updateButton").html(`
                <span id="">
                    <span class="spinner-border spinner-border-sm text-white" role="status" aria-hidden="true"></span>
                    Updating Setting...
                </span>
            `);

            submitButton.disabled = true;

        });
    </script>
@endpush
