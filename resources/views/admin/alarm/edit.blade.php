@extends('admin.layouts.master')
@section('alarm_menu', 'menu-open')
@section('alarm', 'active')
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
                                    @if (Auth::user()->can('admin.alarm.index'))
                                    <div class="float-right">
                                        <a href="{{ route('admin.alarm.index') }}" class="btn btn-primary">Back</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-body py-5">
                            <div class="row d-flex justify-content-center">
                                <div class="col-xl-6">
                                    <form action="{{ route('admin.alarm.update', $data['row']->id) }}" method="post">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label for="level" class="form-label">Alarm Level <span class="text-danger">*</span></label>
                                            <select name="level" id="level" class="form-control" required>
                                                <option value="" class="d-none">Select</option>
                                                @foreach ($data['defcon_levels'] as $level)
                                                    <option value="{{$level->id}}" {{$data['row']->alarm_level == $level->id ? 'selected' : ''}}>{{$level->defcon_level}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">Description <span class="text-danger">*</span></label>
                                            <textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="Write description" required>{{$data['row']->description}}</textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">Action <span class="text-danger">*</span></label>
                                            <textarea name="action" id="action" cols="30" rows="5" class="form-control" placeholder="Write action" required>{{$data['row']->action}}</textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <button type="submit" class="btn btn-success">Update</button>
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
