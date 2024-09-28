@extends('admin.layouts.master')
@section('cpage', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Custome Page Create</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.cpage.index') }}">Manage Custome Page</a>
                            </li>
                            <li class="breadcrumb-item active">Custome Page Create</li>
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
                                        <h3 class="card-title"> Custome Page Create</h3>
                                    </div>
                                    <div class="col-6">
                                        <div class="float-right">
                                            <a href="{{ route('admin.cpage.index') }}" class="btn btn-primary">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body table-responsive p-0">
                                <form action="{{ route('admin.cpage.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="title" class="form-lable">Page Name</label>
                                                <input type="text" name="title" id="title"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="slug" class="form-lable">Page Slug</label>
                                                <input type="text" name="slug" id="slug" readonly
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="status" class="form-lable">Published Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="1">Published</option>
                                                    <option value="0">Unpublished</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="status" class="form-lable">Description</label>
                                                <textarea name="description" cols="30" rows="5" class="form-control summernote"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Add Page</button>
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

@push('script')
    <script>
        // slug generator
        $(document).on('input','#title', function(){
            let titleValue = event.target.value;
            let slug = titleValue.toLowerCase()
                .replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ')
                .replace(/^\s+|\s+$/gm, '')
                .replace(/\s+/g, '-');
            $('#slug').val(slug);
        })
    </script>

@endpush
