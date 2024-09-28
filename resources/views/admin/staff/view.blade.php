@extends('admin.layouts.master')
@section('staff', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection

@push('style')
<style>
    td {
        width: 0;
    }

</style>
@endpush
@section('content')
<div class="content-wrapper pt-5">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row d-flex justify-content-center">
                        <div class="col-xl-5">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="">
                                            <h5 class="card-title">User View</h5>
                                        </div>
                                        <div class="">
                                            <a href="{{ route('admin.staff.login', $data['user']->id) }}" class="btn btn-sm btn-info" target="_blank">Login</a>
                                            {{-- @if (Auth::user()->can('admin.staff.index')) --}}
                                            <a href="{{ route('admin.staff.index') }}"  class="btn btn-sm btn-primary">Back</a>
                                            {{-- @endif --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="text-ceter">
                                        {{-- <div class="py-4 d-flex justify-content-center align-items-center">
                                            <img src="{{ getPhoto($data['user']->image) }}" class="img-fluid rounded-sm" width="120" alt="{{ $data['user']->name }}">
                                        </div> --}}
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <tr>
                                                    <td style="width:30%;">Name</td>
                                                    <td>:&nbsp; {{ $data['user']->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td style="word-break: break-all;">:&nbsp; <a href="mailto:{{ $data['user']->email }}">{{ $data['user']->email }}</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Phone</td>
                                                    <td>:&nbsp; <a href="tel:{{ '+45'.$data['user']->phone }}">{{ '+45'.$data['user']->phone }}</a></td>
                                                </tr>
                                                <tr>
                                                    <td>IP Address</td>
                                                    <td>:&nbsp; @foreach(json_decode($data['user']->ip_address) as $ip)
                                                        <span class="badge badge-info">{{ $ip }}</span>
                                                    @endforeach</td>
                                                </tr>
                                                <tr>
                                                    <td>Can Change Alarm</td>
                                                    <td>:&nbsp; <span class="badge badge-{{ $data['user']->change_diffcon == 1 ? 'success' : 'danger' }}">
                                                        {{ $data['user']->change_diffcon == 1 ? 'Yes' : 'No' }}
                                                    </span></td>
                                                </tr>
                                                <tr>
                                                    <td>Status</td>
                                                    <td>:&nbsp; <span class="badge badge-{{ $data['user']->status == 1 ? 'success' : 'danger' }}">
                                                        {{ $data['user']->status == 1 ? 'Active' : 'Inactive' }}
                                                    </span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
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
