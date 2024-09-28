@extends('user.layouts.master')
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
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
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
                    <div class="card card-primary card-outline h-100">
                        <div class="card-body box-profile position-relative d-flex flex-column justify-content-center">
                            <a href="javascript:void(0)" class="position-absolute" style="right: 5px; top: 5px;" title="Edit" data-toggle="modal" data-target="#changePasswordModal">
                                <i class="fa-solid fa-key"></i>
                            </a>
                            {{-- <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ getProfile($data['user']->image) }}"
                                    style="width:160px; height:160px; display:block;" alt="">
                            </div> --}}
                            <div class="d-flex flex-column align-items-center">
                                <h3 class="profile-username my-3 font-weight-bold">{{ $data['user']->name }}</h3>
                                <div style="word-break: break-all;">
                                    @if(!empty($data['user']->email))
                                    <p class="text-muted"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-mail"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" /><path d="M3 7l9 6l9 -6" /></svg>&nbsp;
                                        {{ $data['user']->email }}</p>
                                    @endif

                                    @if(!empty($data['user']->phone))
                                    <p class="text-muted"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-phone"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>&nbsp;
                                        {{ '+45 '.$data['user']->phone }}</p>
                                    @endif

                                    @if(!empty($data['user']->address))
                                    <p class="text-muted"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" /></svg>&nbsp;
                                        {{ $data['user']->address }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card h-100">
                        <div class="card-body">
                            <form action="{{route('user.profile.update')}}" method="post" enctype="multipart/form-data">
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
                                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" value="{{ $data['user']->name }}" id="name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="text" name="email" value="{{ $data['user']->email }}" id="email" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Phone <span class="text-danger">*</span></label>
                                           <div class="input-group">
                                            <span class="input-group-text shadow">+45</span>
                                            <input type="tel" name="phone" id="phone" value="{{ $data['user']->phone }}"  class="form-control" required
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                           </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ip_address" class="form-lable">IP Address</label>
                                            <input type="text" name="ip_address" value="{{ $data['user']->ip_address }}" class="form-control">
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="address" class="form-lable">Address <span class="text-danger">*</span></label>
                                            <textarea name="address" id="address" class="form-control" required rows="3">{{ $data['user']->address }}</textarea>
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
                <form action="{{ route('user.password.update') }}" method="post">
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
