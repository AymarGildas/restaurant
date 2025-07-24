@extends('admin.layouts.app')

@section('title', 'Edit Site Settings')
@section('page-title', 'Edit Site Settings')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST" class="card p-4 shadow-sm rounded-4 border-0">
        @csrf
        @method('PUT') {{-- Added method spoofing for the update --}}

        {{-- General Settings --}}
        <h4 class="border-bottom pb-2 mb-3">General Settings</h4>
        <div class="mb-3">
            <label class="form-label fw-bold">Site Name</label>
            <input type="text" name="site_name" value="{{ old('site_name', $settings->site_name) }}" class="form-control rounded-3">
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Primary Color</label>
                <input type="color" name="primary_color" value="{{ old('primary_color', $settings->primary_color ?? '#3498db') }}" class="form-control form-control-color" style="width: 100px;">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Secondary Color</label>
                <input type="color" name="secondary_color" value="{{ old('secondary_color', $settings->secondary_color ?? '#2ecc71') }}" class="form-control form-control-color" style="width: 100px;">
            </div>
        </div>

        {{-- Footer Settings --}}
        <h4 class="border-bottom pb-2 my-3">Footer Settings</h4>
        <div class="mb-3">
            <label class="form-label fw-bold">Contact Email</label>
            <input type="email" name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}" class="form-control rounded-3">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Phone Number</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', $settings->phone_number) }}" class="form-control rounded-3">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Address</label>
            <input type="text" name="footer_address" value="{{ old('footer_address', $settings->footer_address) }}" class="form-control rounded-3">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Footer "About" Text</label>
            <textarea name="footer_about_text" class="form-control rounded-3" rows="3">{{ old('footer_about_text', $settings->footer_about_text) }}</textarea>
        </div>

        {{-- Social Media Links --}}
        <h5 class="mt-4">Social Media Links</h5>
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">Facebook URL</label>
                <input type="url" name="social_facebook_url" value="{{ old('social_facebook_url', $settings->social_facebook_url) }}" class="form-control rounded-3">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Instagram URL</label>
                <input type="url" name="social_instagram_url" value="{{ old('social_instagram_url', $settings->social_instagram_url) }}" class="form-control rounded-3">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Twitter URL</label>
                <input type="url" name="social_twitter_url" value="{{ old('social_twitter_url', $settings->social_twitter_url) }}" class="form-control rounded-3">
            </div>
        </div>

        {{-- Other Settings --}}
        <h4 class="border-bottom pb-2 my-3">Other Settings</h4>
        <div class="mb-3">
            <label class="form-label fw-bold">Payment Info</label>
            <textarea name="payment_info" class="form-control rounded-3" rows="4">{{ old('payment_info', $settings->payment_info) }}</textarea>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary px-4">Cancel</a>
            <button type="submit" class="btn btn-success px-5">Save Changes</button>
        </div>
    </form>
@endsection