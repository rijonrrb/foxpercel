@extends('admin.layouts.master')
@section('staff', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection

@push('style')
<style>
    .custom-img {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        width: 100px;
        height: 90px;
    }
</style>
@endpush
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
                            <div class="row align-items-center justify-content-between">
                                <div class="">
                                    <h3 class="card-title">{{ $data['title'] ?? '' }}</h3>
                                </div>
                                <div class="">
                                    {{-- @if (Auth::user()->can('admin.staff.index')) --}}
                                    <a href="{{ route('admin.staff.index') }}"  class="btn btn-primary">Back</a>
                                    {{-- @endif --}}
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.staff.update',$data['user']->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    {{-- <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="image" class="form-label">Image <span class="text-danger">({{ __('Recommended size : 250x250') }})</span></label>
                                            <input type="file" name="image" id="image" class="form-control">
                                            <img class="custom-img mt-2" src="{{ getPhoto($data['user']->image) }}" alt="{{ $data['user']->name }}" width="100" height="100">
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="name" class="form-lable">User <span class="text-danger">*</span></label>
                                            <select name="user" id="user" class="form-control select2" required>
                                                <option value="" class="d-none">Select</option>
                                                @foreach ($data['users'] as $user)
                                                    <option value="{{$user->id}}" {{ $data['user']->parent_user == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="name" class="form-lable">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control" required value="{{ $data['user']->name }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="email" class="form-lable">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email" class="form-control" required value="{{ $data['user']->email }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="phone" class="form-lable">Phone <span class="text-danger">*</span></label>

                                            <div class="input-group">
                                                <span class="input-group-text  shadow">+45</span>
                                            <input type="text" name="phone" id="phone" class="form-control" required value="{{ $data['user']->phone }}"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            </div>
                                            </div>
                                    </div>

                                     {{-- <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="ip_address" class="form-lable">Staff IP Address <span class="text-danger">*</span></label>
                                            <input type="text" name="ip_address" class="form-control" required value="{{ $data['user']->ip_address }}">
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="ip_address" class="form-label">IP Address <span class="text-danger">*</span></label>
                                            <select id="ip_address" name="ip_address[]"  class="form-control selectit-container" multiple="multiple">
                                                @php
                                                    $ipAddresses = json_decode($data['user']->ip_address, true) ?? [];
                                                @endphp
                                                @foreach($ipAddresses as $ip)  
                                                    <option value="{{ $ip }}" selected>{{ $ip }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="diffcon" class="form-lable">Can Change Alarm Level <span class="text-danger">*</span></label>
                                                <select name="change_diffcon" id="diffcon" class="form-control">
                                                    <option value="1" {{ $data['user']->change_diffcon == '1' ? 'selected' : '' }}>Yes</option>
                                                    <option value="0" {{ $data['user']->change_diffcon == '0' ? 'selected' : '' }}>Not</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="status" class="form-lable">Published Status <span class="text-danger">*</span></label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" {{ $data['user']->status == '1' ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ $data['user']->status == '0' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label required">{{ __('2FA Verification') }} <span class="text-danger">*</span></label>
                                        <select class="form-select form-control" name="authenticator" required>
                                            <option value="0"
                                                {{ $data['user']->authenticator == '0' ? 'selected' : '' }}>
                                                {{ __('Disabled') }}</option>
                                            <option value="1"
                                                {{ $data['user']->authenticator == '1' ? 'selected' : '' }}>
                                                {{ __('Enabled') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="password" class="form-lable">Password</label>
                                            <input type="password" name="password"  id="password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">Update</button>
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
