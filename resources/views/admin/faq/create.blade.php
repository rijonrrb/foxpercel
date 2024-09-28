@extends('admin.layouts.master')
@section('faq', 'active')

@section('title') {{ $data['title'] ?? '' }} @endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Faq Create</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.faq.index') }}">Manage faq</a></li>
                        <li class="breadcrumb-item active">Faq Create</li>
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
                                    <h3 class="card-title"> Create Faq</h3>
                                </div>
                                <div class="col-6">
                                    <div class="float-right">
                                        <a href="{{ route('admin.faq.index') }}" class="btn btn-primary">Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <form action="{{ route('admin.faq.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row d-flex justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="title" class="form-lable">Question</label>
                                                <input type="text" name="title" id="title" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="summernote" class="form-lable">Answer</label>
                                                <textarea name="body" id="summernote" cols="30" rows="5"
                                                    class="form-control" required style="height: 150px !important;"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="is_active" class="form-lable">Status</label>
                                                <select name="is_active" id="is_active"  class="form-control">
                                                    <option value="1">Active</option>
                                                    <option value="2">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Add</button>
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
