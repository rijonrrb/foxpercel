@extends('admin.layouts.master')
@section('dashboard', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection

@push('style')
@endpush

@section('content')
<div class="content-wrapper">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush