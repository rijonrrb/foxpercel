@extends('admin.layouts.master')

@section('alarm', 'active')
@section('alarm_menu', 'menu-open')
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
                                    <h3 class="card-title">Manage {{ $data['title'] ?? '' }} </h3>
                                </div>
                                @if (Auth::user()->can('admin.alarm.create'))
                                <div class="col-6">
                                    <div class="float-right">
                                        <a href="{{ route('admin.alarm.create') }}" class="btn btn-primary">Add New</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table id="dataTables" class="table table-hover text-nowrap jsgrid-table">
                                <thead>
                                    <tr>
                                        {{-- <th width="5%">SL</th> --}}
                                        <th width="15%">Alarm Level</th>
                                        <th width="30%">Description</th>
                                        <th width="30%">Action</th>
                                        <th width="10%" class="text-center">Defcon Color</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['rows'] as $key => $row)                                        
                                    <tr>
                                        {{-- <td>{{$key+1}}</td> --}}
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
            </div>
        </div>
    </div>
</div>
@endsection
