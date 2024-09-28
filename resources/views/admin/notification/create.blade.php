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
                                    <h3 class="card-title">{{ $data['title'] ?? '' }} </h3>
                                </div>
                                <div class="col-6">
                                    @if (Auth::user()->can('admin.notification.index'))
                                    <div class="float-right">
                                        <a href="{{ route('admin.notification.index') }}" class="btn btn-primary">Back</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-body py-5">
                            <div class="row d-flex justify-content-center">
                                <div class="col-xl-6">
                                    <form action="{{ route('admin.notification.store') }}" method="post">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">Notification Title <span class="text-danger">*</span></label>
                                            <input type="text" name="notification_title" value="{{old('notification_title')}}" class="form-control" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">Notification Message <span class="text-danger">*</span></label>
                                            <textarea name="message" id="message" cols="30" rows="5" class="form-control" required>{{old('message')}}</textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
