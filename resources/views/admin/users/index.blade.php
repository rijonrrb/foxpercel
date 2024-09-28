@extends('admin.layouts.master')

@section('admin-user', 'active')
@section('title') Admin| User @endsection

@push('style')
@endpush

@php
$userr = Auth::user();
@endphp

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('users') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('user') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">{{ __('User List') }}

                            </h5>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table id="dataTables" class="table table-hover text-nowrap jsgrid-table">
                                <thead>
                                    <tr>
                                        {{-- <th width="5%">Sl</th> --}}
                                        <th>{{ __('name') }}</th>
                                        <th>{{ __('email') }}</th>
                                        <th width="10%">{{ __('action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $key=> $row)
                                        <tr>
                                            {{-- <td>{{ ++$key }}</td> --}}
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>
                                                @if (Auth::user()->can('admin.user.delete'))
                                                    <a  href="{{ route('admin.user.destroy', $row->id) }}" id="deleteData" class="btn btn-danger btn-xs">Delete</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="4">User not found!</td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('script')
@endpush
