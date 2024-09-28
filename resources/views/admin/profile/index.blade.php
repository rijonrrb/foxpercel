@extends('admin.layouts.master')
@section('title') {{ $data['title'] ?? '' }} @endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile position-relative">
                            <a href="javascript:void(0)" class="position-absolute" style="right: 5px; top: 5px;" title="Edit" data-toggle="modal" data-target="#changePasswordModal">
                                <i class="fa-solid fa-key"></i>
                            </a>
                            <div class="text-center">
                                {{-- <img class="profile-user-img img-fluid img-circle"
                                    src="{{ getProfile($data['user']->image) }}"
                                    style="width:160px; height:160px; display:block;" alt=""> --}}
                            </div>
                            <h3 class="profile-username text-center">{{ $data['user']->name }}</h3>
                            <p class="text-muted text-center">{{ $data['user']->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('admin.profile.update')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    {{-- <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="image" class="form-label">Profile Photo</label>
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" name="name" value="{{ $data['user']->name }}" id="name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" name="email" value="{{ $data['user']->email }}" id="email" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Update</button>
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


<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="card-title">Change Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.password.update') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="password-field" class="form-label">New Password <span class="text-danger">*</span></label>
                        <div class="input-group input-group-flat">
                            <input type="password" name="password" id="password-field" class="form-control" required>
                            <span class="input-group-text px-3">
                                <a href="javascript:void(0)" class="link-secondary fa fa-fw fa-eye field-icon toggle-password" toggle="#password-field"></a>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                        <div class="input-group input-group-flat">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                            <span class="input-group-text px-3">
                                <a href="javascript:void(0)" class="link-secondary fa fa-fw fa-eye field-icon confirm-toggle-password" toggle="#confirm_password"></a>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    $(document).ready(function () {

    // password show hide
    $(".toggle-password").click(function () {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
    });

    $(".confirm-toggle-password").click(function () {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
    });

    })
</script>
@endpush