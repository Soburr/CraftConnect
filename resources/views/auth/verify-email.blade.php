@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center py-5" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding-top: 100px !important;">
    <div class="container" style="margin-top: 60px;">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <!-- Icon -->
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle p-4 mb-3" style="width: 100px; height: 100px;">
                                <i class="fas fa-envelope-open-text fa-3x text-success"></i>
                            </div>
                            <h2 class="fw-bold mb-2">Verify Your Email Address</h2>
                            <p class="text-muted mb-0">We've sent you a verification link</p>
                        </div>

                        <!-- Alert Messages -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('info'))
                            <div class="alert alert-info alert-dismissible fade show rounded-3 mb-4" role="alert">
                                <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Instructions -->
                        <div class="bg-light rounded-3 p-4 mb-4">
                            <h5 class="fw-semibold mb-3">
                                <i class="fas fa-inbox text-success me-2"></i>Check Your Inbox
                            </h5>
                            <p class="mb-2 text-dark">Before proceeding, please check your email for a verification link.</p>
                            <p class="mb-0 text-muted small">If you didn't receive the email, check your spam folder or request another one below.</p>
                        </div>

                        <!-- Resend Form -->
                        <form method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ session('verification_email') ?? old('email') }}">

                            @if (!session('verification_email'))
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="fas fa-envelope me-2"></i>Email Address
                                    </label>
                                    <input type="email"
                                           class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           placeholder="Enter your email address"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @else
                                <div class="alert alert-light border rounded-3 mb-4">
                                    <p class="mb-0 text-muted">
                                        <i class="fas fa-paper-plane text-success me-2"></i>Email will be sent to:
                                        <strong class="text-dark">{{ session('verification_email') }}</strong>
                                    </p>
                                </div>
                            @endif

                            <div class="d-grid gap-3">
                                <button type="submit" class="btn btn-success btn-lg rounded-3 fw-semibold">
                                    <i class="fas fa-paper-plane me-2"></i>Resend Verification Email
                                </button>
                                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg rounded-3">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Login
                                </a>
                            </div>
                        </form>

                        <!-- Help Text -->
                        <div class="text-center mt-4 pt-4 border-top">
                            <p class="text-muted small mb-0">
                                <i class="fas fa-question-circle me-1"></i>
                                Having trouble? Contact us at
                                <a href="mailto:support@lagartisan.com" class="text-decoration-none">support@lagartisan.com</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Additional Info Card -->
                <div class="card border-0 bg-white bg-opacity-10 mt-4 text-white">
                    <div class="card-body p-4 text-center">
                        <h6 class="fw-semibold mb-2">
                            <i class="fas fa-shield-alt me-2"></i>Why verify your email?
                        </h6>
                        <p class="small mb-0 opacity-75">
                            Email verification helps us keep your account secure and ensures you receive important updates about your bookings and services.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Mobile responsiveness */
    @media (max-width: 576px) {
        .card-body {
            padding: 2rem 1.5rem !important;
        }

        .bg-light.rounded-3 {
            padding: 1.25rem !important;
        }

        h2 {
            font-size: 1.5rem !important;
        }

        .btn-lg {
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }
    }

    /* Smooth animations */
    .card {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Button hover effects */
    .btn-success {
        transition: all 0.3s ease;
        background-color: #10b981;
        border-color: #10b981;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(16, 185, 129, 0.4);
        background-color: #059669;
        border-color: #059669;
    }

    .btn-outline-secondary:hover {
        transform: translateY(-2px);
    }

    /* Alert animations */
    .alert {
        animation: slideInDown 0.4s ease-out;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection
