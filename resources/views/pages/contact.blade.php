@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<style>
    .contact-header {
        background-color: #f8f9fa;
        padding: 4rem 0;
    }
    .contact-info-icon {
        font-size: 1.5rem;
        width: 50px;
        height: 50px;
        line-height: 50px;
        text-align: center;
        border-radius: 50%;
        color: #fff;
        background-color: {{ $settings->primary_color ?? '#4F46E5' }};
    }
</style>

<div class="contact-header text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Get in Touch</h1>
        <p class="lead col-lg-8 mx-auto">We'd love to hear from you. Whether you have a question about our menu or an order, we're here to help.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        {{-- Contact Info Column --}}
        <div class="col-lg-5">
            <h3 class="fw-bold mb-4">Contact Information</h3>
            <div class="d-flex align-items-start mb-4">
                <div class="contact-info-icon me-3"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <h5 class="mb-1">Address</h5>
                    <p class="text-muted mb-0">{{ $settings->footer_address ?? '123 Food Street, Cityville' }}</p>
                </div>
            </div>
            <div class="d-flex align-items-start mb-4">
                <div class="contact-info-icon me-3"><i class="fas fa-phone"></i></div>
                <div>
                    <h5 class="mb-1">Phone</h5>
                    <p class="text-muted mb-0">{{ $settings->phone_number ?? '(123) 456-7890' }}</p>
                </div>
            </div>
            <div class="d-flex align-items-start mb-4">
                <div class="contact-info-icon me-3"><i class="fas fa-envelope"></i></div>
                <div>
                    <h5 class="mb-1">Email</h5>
                    <p class="text-muted mb-0">{{ $settings->contact_email ?? 'contact@foodexpress.com' }}</p>
                </div>
            </div>
        </div>

        {{-- Contact Form Column --}}
        <div class="col-lg-7">
            <h3 class="fw-bold mb-4">Send Us a Message</h3>
            
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm border-0 p-4">
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required></textarea>
                        @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary" style="background-color: {{ $settings->secondary_color ?? '#FF6B6B' }}; border-color: {{ $settings->secondary_color ?? '#FF6B6B' }};">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
