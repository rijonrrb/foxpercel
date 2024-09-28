@extends('admin.layouts.master')
@section('customer', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $data['title'] ?? '' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $data['title'] ?? '' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h3 class="card-title">{{ $data['title'] ?? '' }} </h3>
                                </div>
                                <div class="col-6">
                                    <div class="float-right">
                                        {{-- @if (Auth::user()->can('admin.customer.index')) --}}
                                        <a href="{{ route('admin.customer.index') }}"  class="btn btn-primary">Back</a>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.customer.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    {{-- <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="image" class="form-lable">Image <span class="text-danger">({{ __('Recommended size : 250x250') }})</span></label>
                                            <input type="file" name="image" id="image" class="form-control" >
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="name" class="form-lable">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="email" class="form-lable">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="password" class="form-lable">Password <span class="text-danger">*</span></label>
                                            <input type="password" name="password" id="password" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="phone" class="form-lable">Phone <span class="text-danger">*</span></label>

                                            <div class="input-group">
                                                <span class="input-group-text  shadow">+45</span>

                                            <input type="tel" name="phone" id="phone" class="form-control" required
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            </div>
                                            </div>
                                    </div>
                                     <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="status" class="form-lable">Published Status <span class="text-danger">*</span></label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="ip_address" class="form-label">IP Address <span class="text-danger">*</span></label>
                                            <select id="ip_address" name="ip_address[]" class="form-control selectit-container" multiple="multiple"></select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label required">{{ __('2FA Verification') }} <span class="text-danger">*</span></label>
                                        <select class="form-select form-control" name="authenticator" required>
                                            <option value="0"
                                                {{ old('authenticator') == '0' ? 'selected' : '' }}>
                                                {{ __('Disabled') }}</option>
                                            <option value="1"
                                                {{ old('authenticator') == '1' ? 'selected' : '' }}>
                                                {{ __('Enabled') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="address" class="form-lable">Address <span class="text-danger">*</span></label>
                                            <textarea name="address" id="address" class="form-control" required rows="3">{{ old('address') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Add Customer</button>
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
</div>
@endsection



