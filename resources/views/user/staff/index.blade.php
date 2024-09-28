@extends('user.layouts.master')
@section('staff', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection

@push('style')
<style>
    td {
        width: 0;
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
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
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
                                    <h3 class="card-title">{{ $data['title'] ?? '' }}</h3>
                                </div>
                                <div class="col-6">
                                    <div class="float-right">
                                        <a href="{{ route('user.staff.create') }}" class="btn btn-sm btn-primary">Add Staff</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table id="dataTables" class="table table-hover text-nowrap jsgrid-table">
                                <thead>
                                    <tr>
                                        {{-- <th width="5%">SL</th> --}}
                                        {{-- <th width ="10%">Image</th> --}}
                                        <th width="25%">Name</th>
                                        <th width="15%">Email</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data['rows'] as $key => $row)
                                    <tr>
                                        {{-- <td>{{ $key + 1 }}</td> --}}
                                        {{-- <td>
                                            <img src="{{ getPhoto($row->image) }}" class="img-fluid rounded-sm" width="80" height="80" alt="{{ $row->name }}">
                                        </td> --}}
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td>
                                            @if ($row->status == 1)
                                            <span class="badge badge-success">Active</span>
                                            @else
                                            <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('user.staff.view', $row->id) }}" class="btn btn-primary btn-xs">View</a>
                                            <a href="{{ route('user.staff.edit', $row->id) }}" class="btn btn-secondary btn-xs">Edit</a>
                                            <a href="{{ route('user.staff.delete', $row->id) }}" id="deleteData" class="btn btn-danger btn-xs">Delete</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="text-center" colspan="4">No Records Found</td>
                                    </tr>
                                    @endforelse 
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end px-4 py-3">
                                {{ $data['rows']->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
