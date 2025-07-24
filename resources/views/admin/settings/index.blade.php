@extends('admin.layouts.app')

@section('title', 'Site Settings')
@section('page-title', 'Site Settings')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Current Site & Footer Settings</h4>
        <a href="{{ route('admin.settings.edit') }}" class="btn btn-primary px-4">
            Edit Settings
        </a>
    </div>

    <div class="row g-4">

        {{-- General Settings --}}
        <div class="col-12">
            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="mb-0">General</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Site Name</h6>
                            <p class="fs-5 fw-semibold text-primary">{{ $settings->site_name ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <h6 class="text-muted">Primary Color</h6>
                            <div class="rounded-circle mx-auto mb-2" style="width: 50px; height: 50px; background-color: {{ $settings->primary_color }};"></div>
                            <p class="mb-0">{{ $settings->primary_color }}</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <h6 class="text-muted">Secondary Color</h6>
                            <div class="rounded-circle mx-auto mb-2" style="width: 50px; height: 50px; background-color: {{ $settings->secondary_color }};"></div>
                            <p class="mb-0">{{ $settings->secondary_color }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Settings --}}
        <div class="col-12">
            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="mb-0">Footer Content</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Contact Email</h6>
                            <p class="fs-5 fw-semibold">{{ $settings->contact_email ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Phone Number</h6>
                            <p class="fs-5 fw-semibold">{{ $settings->phone_number ?? '-' }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <h6 class="text-muted">Address</h6>
                            <p class="fs-5 fw-semibold">{{ $settings->footer_address ?? '-' }}</p>
                        </div>
                        <div class="col-12">
                            <h6 class="text-muted">Footer "About" Text</h6>
                            <p class="fw-semibold">{{ $settings->footer_about_text ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Social Media --}}
        <div class="col-12">
            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="mb-0">Social Media Links</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <h6 class="text-muted">Facebook URL</h6>
                            <p class="fw-semibold">{{ $settings->social_facebook_url ?? '-' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="text-muted">Instagram URL</h6>
                            <p class="fw-semibold">{{ $settings->social_instagram_url ?? '-' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="text-muted">Twitter URL</h6>
                            <p class="fw-semibold">{{ $settings->social_twitter_url ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Other Settings --}}
        <div class="col-12">
            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="mb-0">Other Settings</h5>
                </div>
                <div class="card-body">
                    <h6 class="text-muted">Payment Info</h6>
                    <p class="fw-semibold">{{ $settings->payment_info ?? '-' }}</p>
                </div>
            </div>
        </div>

    </div>
@endsection