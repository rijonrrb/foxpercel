@extends('admin.layouts.master')
@section('dashboard', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection
@push('style')
<style>
    .circle_div {
        border-radius: 100%;
        height: 20px;
        width: 20px;
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
    }
</style>
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                {{-- <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">Total Staff</span>
                            <span class="info-box-number">{{$data['staff_count']}}</span>
                        </div>
                        <a href="{{route('admin.staff.index')}}" class="stretched-link"></a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">Total Notification Templates</span>
                            <span class="info-box-number">{{$data['notification_count']}}</span>
                        </div>
                        <a href="{{route('admin.notification.index')}}" class="stretched-link"></a>
                    </div>
                </div>
                 <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">Total Defcon alarm</span>
                            <span class="info-box-number">{{$data['alarm_count']}}</span>
                        </div>
                        <a href="{{route('admin.alarm.index')}}" class="stretched-link"></a>
                    </div>
                </div> --}}
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">Total Customers</span>
                            <span class="info-box-number">{{$data['customer_count']}}</span>
                        </div>
                        {{-- <a href="{{route('admin.customer.index')}}" class="stretched-link"></a> --}}
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">Total SMS sent</span>
                            <span class="info-box-number">{{$data['sms_count']}}</span>
                        </div>
                        {{-- <a href="{{route('admin.customer.index')}}" class="stretched-link"></a> --}}
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                @if (Auth::user()->can('admin.alarm.index'))
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="">
                                    <h4 class="card-title">Latest Alarm</h4>
                                </div>
                                <div class="">
                                    <a href="{{ route('admin.alarm.index') }}" class="btn btn-primary">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap jsgrid-table">
                                <thead>
                                    <tr>
                                        <th width="10%">SL</th>
                                        <th width="15%">Alarm Level</th>
                                        <th width="30%">Description</th>
                                        <th width="30%">Action</th>
                                        <th width="10%" class="text-center">Defcon Color</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['alarms'] as $key => $row)                                        
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$row->level?->defcon_level}}</td>
                                        <td style="text-wrap: balance;">{!! nl2br(e($row->description)) !!}</td>
                                        <td style="text-wrap: balance;">{!! nl2br(e($row->action)) !!}</td>
                                        <td style="text-align: -webkit-center;"><div class="circle_div" style="background:{{$row->level?->color}}"></div></td>
                                        <td>
                                            @if (Auth::user()->can('admin.alarm.edit'))
                                                <a href="{{ route('admin.alarm.edit', $row->id) }}" class="btn btn-primary btn-xs">Edit</a>
                                            @endif
                                            @if (Auth::user()->can('admin.alarm.delete'))
                                                <a href="{{ route('admin.alarm.delete', $row->id) }}" id="deleteData" class="btn btn-danger btn-xs">Delete</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div> --}}
            <div class="row">
                {{-- @if (Auth::user()->can('admin.customer.index')) --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="">
                                    <h4 class="card-title">Customers</h4>
                                </div>
                                <div class="">
                                    <a href="{{ route('admin.customer.index') }}" class="btn btn-primary">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap jsgrid-table">
                                <thead>
                                    <tr>
                                        {{-- <th width="5%">SL</th> --}}
                                        <th width="25%">Name</th>
                                        <th width="15%">Email</th>
                                        <th width="15%" class="text-center">Status</th>
                                        {{-- <th width="15%">Register At</th> --}}
                                        <th width="10%" class="text-center">SMS sent</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data['rows'] as $key => $row)
                                    <tr>
                                        {{-- <td>{{ $key + 1 }}</td> --}}
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td class="text-center">
                                            @if ($row->status == 1)
                                            <span class="badge badge-success">Active</span>
                                            @else
                                            <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        {{-- <td>{{ $row->created_at }}</td> --}}
                                        <td class="text-center">{{ $row->sms_count }}</td>
                                        <td>
                                            {{-- @if (Auth::user()->can('admin.staff.index')) --}}
                                            <a href="{{ route('admin.staff.index', ['user' => $row->id]) }}" class="btn btn-info view btn-xs">User</a>
                                            {{-- @endif --}}

                                            {{-- @if (Auth::user()->can('admin.customer.index')) --}}
                                            <a href="{{ route('admin.customer.view', $row->id) }}" class="btn btn-secondary view btn-xs">View</a>
                                            {{-- @endif --}}

                                            {{-- @if (Auth::user()->can('admin.customer.edit')) --}}
                                            <a href="{{ route('admin.customer.edit', $row->id) }}" class="btn btn-primary edit btn-xs">Edit</a>
                                            {{-- @endif --}}

                                            {{-- @if (Auth::user()->can('admin.customer.delete')) --}}
                                            <a href="{{ route('admin.customer.delete', $row->id) }}" id="deleteData" class="btn btn-danger btn-xs">Delete</a>
                                            {{-- @endif --}}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="text-center" colspan="6">No Records Found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- @endif --}}
            </div>
        </div>
    </div>
</div>

@endsection
