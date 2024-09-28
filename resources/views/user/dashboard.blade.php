@extends('user.layouts.master')
@section('dashboard', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection

@push('style')
@endpush
@section('nav_menu', 'Welcome')

@section('content')
<div class="content-wrapper">
    <div class="content">
        <div class="container-fluid">
            <div class="row"> ddddddddddd
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush