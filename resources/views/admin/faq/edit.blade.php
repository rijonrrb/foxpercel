@extends('admin.layouts.master')
@section('faq', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection
@php
    $row = $data['row'];
    // dd($row);
@endphp
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $data['title'] ?? '' }} Edit</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.faq.index') }}">Manage
                                    {{ $data['title'] ?? '' }}</a></li>
                            <li class="breadcrumb-item active">{{ $data['title'] ?? '' }} Edit</li>
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
                                        <h3 class="card-title"> Edit Faq</h3>
                                    </div>
                                    <div class="col-6">
                                        <div class="float-right">
                                            <a href="{{ route('admin.faq.index') }}" class="btn btn-primary">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <form action="{{ route('admin.faq.update', $row->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-lg-8">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="title" class="form-lable">Question</label>
                                                    <input type="text" name="title" id="title"
                                                        value="{{ $row->title }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="summernote" class="form-lable">Answer</label>
                                                    <textarea name="body" class="form-control" style="height: 150px !important;">{{ $row->body }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="is_active" class="form-lable">Status</label>
                                                    <select name="is_active" id="is_active" class="form-control">
                                                        <option value="1">Active</option>
                                                        <option value="0" {{ $row->is_active == 0 ? 'selected' : '' }}>
                                                            Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="order_id" class="form-lable">Order Number</label>
                                                    <input type="text" name="order_id" id="order_id"
                                                        value="{{ $row->order_id }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
