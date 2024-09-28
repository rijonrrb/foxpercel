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
                                    <h3 class="card-title">{{ $data['title'] ?? '' }}</h3>
                                </div>
                                <div class="col-6">
                                    <div class="float-right">
                                        <a href="{{ route('admin.customer.index') }}" class="btn btn-primary">Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table id="dataTables" class="table table-hover text-nowrap jsgrid-table">
                                <thead>
                                    <tr>
                                        {{-- <th width="15%">SL</th> --}}
                                        <th width="25%">Name</th>
                                        <th width="25%">Email</th>
                                        <th width="10%">Status</th> 
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        {{-- <td>01</td> --}}
                                        <td>Jamal</td>
                                        <td>jamal@gmail.com</td>
                                        <td>
                                            <span class="badge badge-success">Active</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.staff.view', 1) }}" class="btn btn-primary btn-xs">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>02</td>
                                        <td>Aisha</td>
                                        <td>aisha@gmail.com</td>
                                        <td>
                                            <span class="badge badge-success">Active</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.staff.view', 2) }}" class="btn btn-primary btn-xs">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>03</td>
                                        <td>David</td>
                                        <td>david@gmail.com</td>
                                        <td>
                                            <span class="badge badge-success">Active</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.staff.view', 3) }}" class="btn btn-primary btn-xs">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>04</td>
                                        <td>Fatima</td>
                                        <td>fatima@gmail.com</td>
                                        <td>
                                            <span class="badge badge-success">Active</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.staff.view', 4) }}" class="btn btn-primary btn-xs">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>05</td>
                                        <td>Michael</td>
                                        <td>michael@gmail.com</td>
                                        <td>
                                            <span class="badge badge-success">Active</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.staff.view', 5) }}" class="btn btn-primary btn-xs">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>06</td>
                                        <td>Linda</td>
                                        <td>linda@gmail.com</td>
                                        <td>
                                            <span class="badge badge-success">Active</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.staff.view', 6) }}" class="btn btn-primary btn-xs">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>07</td>
                                        <td>Omar</td>
                                        <td>omar@gmail.com</td>
                                        <td>
                                            <span class="badge badge-success">Active</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.staff.view', 7) }}" class="btn btn-primary btn-xs">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>08</td>
                                        <td>Emily</td>
                                        <td>emily@gmail.com</td>
                                        <td>
                                            <span class="badge badge-success">Active</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.staff.view', 8) }}" class="btn btn-primary btn-xs">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>09</td>
                                        <td>John</td>
                                        <td>john@gmail.com</td>
                                        <td>
                                            <span class="badge badge-success">Active</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.staff.view', 9) }}" class="btn btn-primary btn-xs">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>Sarah</td>
                                        <td>sarah@gmail.com</td>
                                        <td>
                                            <span class="badge badge-success">Active</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.staff.view', 10) }}" class="btn btn-primary btn-xs">View</a>
                                        </td>
                                    </tr>

                            
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
