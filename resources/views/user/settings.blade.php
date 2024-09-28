@extends('user.layouts.master')
@section('title') {{ $data['title'] ?? '' }} @endsection
@section('settings', 'active')

@push('style')
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $data['title'] ?? 'Page Header' }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">{{ __('Dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('Settings') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @if (Session::get('success'))
                        <div class="col-lg-12">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ Session::get('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-12">
                        <form action="{{ route('user.settings.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class=""> 
                                <div class="card-body p-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Site Settings</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <img src="{{ getPhoto($settings->site_logo ?? '') }}" height="50px" />
                                                            <div class="mb-3">
                                                                <div class="form-label">{{ __('Site Logo') }} <span
                                                                        class="text-danger">
                                                                        ({{ __('Recommended size : 180x60') }})</span>
                                                                </div>
                                                                <input type="file" class="form-control" name="site_logo"
                                                                    placeholder="{{ __('Site Logo') }}..."
                                                                    accept=".png,.jpg,.jpeg,.gif,.svg" />
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-lg-4">
                                                            <img src="{{ getPhoto($settings->seo_image ?? '') }}"
                                                                height="50px" />

                                                            <div class="mb-3">
                                                                <div class="form-label">{{ __('SEO image') }} <span
                                                                        class="text-danger">
                                                                        ({{ __('Recommended size : 728x680') }})</span>
                                                                </div>
                                                                <input type="file" class="form-control" name="seo_image"
                                                                    placeholder="{{ __('SEO image') }}..."
                                                                    accept=".png,.jpg,.jpeg,.gif,.svg" />
                                                            </div>
                                                        </div> --}}

                                                        <div class="col-lg-4">
                                                            <img src="{{ getPhoto($settings->favicon ?? '') }}"
                                                                height="50px" />
                                                            <div class="mb-3">
                                                                <div class="form-label">{{ __('Favicon') }} <span
                                                                        class="text-danger">
                                                                        ({{ __('Recommended size : 200x200') }})</span>
                                                                </div>
                                                                <input type="file" class="form-control" name="favicon"
                                                                    placeholder="{{ __('Favicon') }}..."
                                                                    accept=".png,.jpg,.jpeg,.gif,.svg" />
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label required">{{ __('SMS Sender Name') }} <span
                                                                    class="text-danger">(Max 11 characters)</span></label>
                                                                <input type="text" class="form-control" name="site_name" maxlength="11"
                                                                    value="{{ $settings->site_name ?? '' }}" placeholder="{{ __('SMS Sender Name') }}...">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Site Title') }} <span
                                                                    class="text-danger">(Max 70 characters)</span></label>
                                                                <input type="text" class="form-control" maxlength="70"
                                                                    name="seo_title" value="{{ $settings->seo_title ?? '' }}"
                                                                    placeholder="{{ __('Site Title') }}...">
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Current Alarm Label') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="alarm_label" value="{{ $settings->alarm_label ?? '' }}"
                                                                    placeholder="{{ __('Current Alarm Label') }}...">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Table Heading 1') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="table_heading_1" value="{{ $settings->table_heading_1 ?? '' }}"
                                                                    placeholder="{{ __('Table Heading 1') }}...">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Table Heading 2') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="table_heading_2" value="{{ $settings->table_heading_2 ?? '' }}"
                                                                    placeholder="{{ __('Table Heading 2') }}...">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Table Heading 3') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="table_heading_3" value="{{ $settings->table_heading_3 ?? '' }}"
                                                                    placeholder="{{ __('Table Heading 3') }}...">
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('SEO Meta Description') }}</label>
                                                                <textarea class="form-control" name="seo_meta_desc" rows="3" placeholder="{{ __('SEO Meta Description') }}"
                                                                    style="height: 120px !important;" required>{{ $settings->seo_meta_description ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ __('SEO Keywords') }}</label>
                                                                <textarea class="form-control required" name="meta_keywords" rows="3"
                                                                    placeholder="{{ __('SEO Keywords (Keyword 1, Keyword 2)') }}" style="height: 120px !important;" required>{{ $settings->seo_keywords ?? '' }}</textarea>
                                                            </div>
                                                        </div> --}}
                                                        {{-- <div class="col-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ __('Main Motto') }}</label>
                                                                <textarea class="form-control required" name="main_motto" rows="3" placeholder="{{ __('Main moto') }}"
                                                                    style="height: 120px !important;" required>{{ $settings->main_motto ?? '' }}</textarea>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success"
                                            id="updateButton">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection

@push('script')
@endpush
