@extends('admin.layouts.master')

@section('notification', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection

@push('style')

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
                                @if (Auth::user()->can('admin.notification.create'))
                                <div class="col-6">
                                    <div class="float-right">
                                        <a href="{{ route('admin.notification.create') }}" class="btn btn-primary">Add New</a>
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
                                        <th style="width:20%">Notification Title</th>
                                        <th style="width:30%">Message</th>
                                        <th style="width:5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['rows'] as $key => $row)
                                    <tr>
                                        {{-- <td>{{$key+1}}</td> --}}
                                        <td style="text-wrap: balance;">{{$row->title}}</td>
                                        <td style="text-wrap: balance;">{!! nl2br(e($row->message)) !!}</td>
                                        <td>
                                            @if (Auth::user()->can('admin.notification.edit'))
                                            <a href="{{ route('admin.notification.edit', $row->id) }}" class="btn btn-primary btn-xs">Edit</a>
                                            @endif
                                            @if (Auth::user()->can('admin.notification.delete'))
                                            <a href="{{route('admin.notification.delete', $row->id)}}" id="deleteData" class="btn btn-danger btn-xs">Delete</a>
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
