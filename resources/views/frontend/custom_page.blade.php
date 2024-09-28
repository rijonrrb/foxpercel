@extends('frontend.layouts.app')

@section('title')
{{ $data['title'] ?? 'Page header' }}
@endsection

@section('meta')
<meta property="og:title" content="{{ $og_title }}" />
<meta property="og:description" content="{{ $og_description }}" />
<meta property="og:image" content="{{ asset($og_image) }}" />
@endsection

@push('style')
@endpush

@section('content')
<div class="breadcrumb_sec">
    <div class="container">
        <div class="breadcrumb_nav text-center">
            <h5>FRANCHISE OPPORTUNITY WEB PORTAL</h5>
            <h2>{{ $data['row']->title ?? 'Page header' }}</h2>
        </div>
    </div>
</div>
<div class="privacy_policy_sec section">
    <div class="container">
        <div class="row">
            <div class="page_content">
                <div class="content_wrap">
                    <p>{!! $data['row']->body ?? 'Page description' !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush
