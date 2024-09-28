@extends('admin.layouts.master')
@section('customer', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection

@push('style')
<style>
    td {
        width: 0;
    }
</style>
@endpush
@php
    $user = $data['user'];
@endphp
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
                                    <h3 class="card-title"> View Customer</h3>
                                </div>
                                <div class="col-6">
                                    <div class="float-right">
                                        <a href="{{ route('admin.customer.login', $user->id) }}" class="btn btn-sm btn-info" target="_blank">Login</a>
                                        {{-- @if (Auth::user()->can('admin.customer.index')) --}}
                                        <a href="{{ route('admin.customer.index') }}"  class="btn btn-sm btn-primary">Back</a>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table">
                                {{-- <tr>
                                    <td>Featured Image</td>
                                    <td><img src="{{ getPhoto($user->image) }}" width="100" alt="{{ $user->name }}"></td>
                                </tr> --}}
                                <tr>
                                    <td>Customer Name</td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td>Customer Role</td>
                                    <td>{{ $user->role->name }}</td>
                                </tr>
                                <tr>
                                    <td>Customer Email</td>
                                    {{-- <td>{{ $user->email }}</td> --}}
                                        <td style="word-break: break-all;"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                </tr>
                                <tr>
                                    <td>Customer Phone</td>
                                    <td><a href="tel:{{ '+45'.$user->phone }}">{{ '+45'.$user->phone }}</a></td>

                                    {{-- <td>{{ $user->phone }}</td> --}}
                                    <tr>
                                <td>Publihed Status</td>
                                    <td>
                                        @if($user->status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif

                                    </td>
                                </tr>
                                <tr>
                                    <td>Customer Address</td>
                                    <td>{{ $user->address }}</td>
                                </tr>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="modal modal-blur fade" id="login-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">{{ __('Are you sure login into the user?')}}</div>
                <div class="text-danger">{{ __('Note : If you proceed, you will lose your admin session.')}}</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal">{{ __('Cancel')}}</button>
                <a href="{{ route('admin.customer.login', $user->id) }}" target="_blank"
                   class="btn btn-danger">{{ __('Yes, proceed')}}</a>
        </div>
    </div>
</div> --}}
@endsection
@push('script')
{{-- <script>
    function loginUser(parameter) {
        "use strict";
        $("#login-modal").modal("show");
    }
</script> --}}
@endpush
