@extends('admin.layouts.master')
@section('customer', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection
@section('nav_menu', $data['title'])

@push('style')
    <style>
        .user-image {
            max-width: 60px;
            max-height: 60px;
            object-fit: contain;
            border-radius: 10px !important;
        }
    </style>
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xl">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Manage Information</h4>
                                <a href="{{ route('admin.customer.create') }}"
                                    class="btn btn-primary">Add New</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dataTables" class="table table-hover text-nowrap jsgrid-table">

                                        <thead>
                                            <tr>
                                                <th width="5%">SN</th>
                                                <th width="5%">Image</th>
                                                <th width="10%">Name</th>
                                                <th width="10%">Email</th>
                                                <th width="10%">Phone</th>
                                                <th width="10%">Status</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data['rows'] as $key => $row)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td> 
                                                        <a href="{{getPhoto($row->image)}}" target="_blank" rel="noopener noreferrer">
                                                            <img src="{{getPhoto($row->image)}}" class="img img-fluid user-image" alt="{{ $row->name }}">
                                                        </a>
                                                    </td>
                                                    <td>{{ $row->name }}</td>
                                                    <td>{{ $row->email }}</td>
                                                    <td>{{ $row->phone }}</td>
                                                    <td class="text-center">
                                                        @if ($row->status == 1)
                                                            <span class="badge bg-success text-white">Active</span>
                                                        @else
                                                            <span class="badge bg-danger text-white">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{-- <a href="{{ route('admin.customer.view', $row->id) }}"
                                                            class="btn btn-info btn-sm"
                                                            data-id="{{ $row->id }}">View</a> --}}
                                                        <a href="{{ route('admin.customer.edit', $row->id) }}"
                                                            class="btn btn-secondary btn-sm"
                                                            data-id="{{ $row->id }}">Edit</a>
                                                        <a href="{{ route('admin.customer.delete', $row->id) }}"
                                                            id="deleteData" class="btn btn-danger btn-sm">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
