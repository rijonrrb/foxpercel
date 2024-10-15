@extends('admin.layouts.master')
@section('coupon', 'active')
@section('title') {{ $title ?? '' }} @endsection
@section('nav_menu', $title)
@push('style')
@endpush
@section('content')
    <div class="container-xl">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card-header">
                                <h3 class="card-title">Coupon View</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Coupon Name : <strong>{{ $coupon->name }}</strong> </p>
                                        <p>Coupon Code : <strong>{{ $coupon->coupon_code }}</strong> </p>
                                        <p>Valid Date : <strong>{{ date('d-m-Y', strtotime($coupon->validity_from)) }} to
                                                {{ date('d-m-Y', strtotime($coupon->validity_to)) }}</strong> </p>
                                        <p>Coupon Type : <strong>{{ $coupon->coupon_type }}</strong> </p>
                                        <p>Amount : <strong>{{ $coupon->amount }}</strong> </p>
                                        <p>Usability : <strong>{{ $coupon->usability }}</strong> </p>
                                        <p>Status : <strong
                                                class="text-{{ $coupon->status ? 'success' : 'danger' }}">{{ $coupon->status ? 'Active' : 'Inactive' }}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent mt-auto">
                                <div class="btn-list justify-content-end">
                                    <a href="{{ route('admin.coupon.index') }}" class="btn">
                                        Back
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
