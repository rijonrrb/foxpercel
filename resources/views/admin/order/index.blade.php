@extends('admin.layouts.master')
@section('order', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection
@section('nav_menu', $data['title'])
@push('style')
@endpush

@section('content')
    <div class="container-xl">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Order Information</h4>
                                {{-- <a href="#" class="btn btn-primary">Add New</a> --}}
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dataTables" class="table table-hover text-nowrap jsgrid-table">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Order Number</th>
                                                <th>Shopping From</th>
                                                <th>Delivery Country</th>
                                                <th>Requested Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach ($data['rows'] as $key => $row)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $row->order_number }}</td>
                                                    <td>{{ $row->shopping_from_country }}</td>
                                                    <td>{{ $row->delivery_country }}</td>
                                                    <td>{{ $row->created_at }}</td>
                                                    <td>                                              
                                                        @if ($row->status == 'complete')
                                                            <span class="badge bg-success text-white">Complete</span>
                                                        @elseif ($row->status == 'approved')
                                                            <span class="badge bg-success text-white">Approved</span>
                                                        @elseif ($row->status == 'cancel')
                                                            <span class="badge bg-danger text-white">Cancelled</span>
                                                        @else
                                                            <span class="badge bg-warning text-white">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.order.edit', $row->id) }}" class="btn btn-secondary btn-sm"
                                                            data-id="{{ $row->id }}">Edit</a>
                                                        <a href="#" class="btn btn-info btn-sm"
                                                            data-id="{{ $row->id }}">Invoice</a>
                                                        {{-- <a href="{{ route('admin.country.delete', $row->id) }}"
                                                            id="deleteData" class="btn btn-danger btn-sm">Delete</a> --}}
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