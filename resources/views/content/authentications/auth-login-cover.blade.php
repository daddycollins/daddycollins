@php
  $configData = Helper::appClasses();
  $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Login Cover - Pages')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
  @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])

  <style>
    html,
    body {
      height: 100%;
      margin: 0;
      overflow: hidden;
    }

    .auth-cover-page {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      min-height: 100dvh;
      height: 100dvh;
      padding: clamp(1rem, 2vw, 1.5rem) clamp(1rem, 4vw, 3.5rem);
      background:
        linear-gradient(135deg, rgba(11, 20, 45, 0.72), rgba(23, 84, 121, 0.45)),
        url("{{ asset('assets/img/logoo.png') }}") center center / cover no-repeat;
      overflow: hidden;
    }

    .auth-cover-page::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.22), transparent 32%);
      pointer-events: none;
    }

    .auth-cover-card {
      position: relative;
      z-index: 1;
      width: min(100%, 36rem);
      max-height: calc(100dvh - 2rem);
      padding: clamp(1.25rem, 2.5vw, 2rem);
      border: 1px solid rgba(255, 255, 255, 0.22);
      border-radius: 32px;
      background: rgba(255, 255, 255, 0.42);
      backdrop-filter: blur(18px);
      box-shadow: 0 24px 60px rgba(15, 23, 42, 0.22);
      overflow: hidden;
    }

    .auth-card-brand {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      color: #14213d;
    }

    .auth-card-brand .app-brand-text {
      color: #14213d !important;
      font-size: 1.1rem;
      letter-spacing: 0.01em;
    }

    .auth-cover-title {
      color: #14213d;
      font-weight: 700;
    }

    .auth-cover-subtitle {
      color: #526072;
      font-size: 0.92rem;
      line-height: 1.45;
    }

    .auth-cover-card .alert,
    .auth-cover-card .btn,
    .auth-cover-card .form-control,
    .auth-cover-card .form-select {
      border-radius: 18px !important;
    }

    .auth-cover-card .form-control,
    .auth-cover-card .form-select {
      border: 1.5px solid rgba(20, 33, 61, 0.32);
      background: rgba(255, 255, 255, 0.92);
      box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.15);
    }

    .auth-cover-card .form-floating > .form-control,
    .auth-cover-card .form-floating > .form-control-plaintext,
    .auth-cover-card .form-floating > .form-select {
      min-height: 3.6rem;
    }

    .auth-cover-card .form-control:focus,
    .auth-cover-card .form-select:focus {
      border-color: rgba(11, 91, 160, 0.9);
      box-shadow: 0 0 0 0.2rem rgba(11, 91, 160, 0.15);
    }

    .auth-cover-card .form-floating > label {
      color: #445468;
      padding-inline: 0.35rem;
      margin-inline-start: 0.55rem;
      z-index: 3;
    }

    .auth-cover-card .form-floating > label::after {
      background: rgba(255, 255, 255, 0.94) !important;
      border-radius: 999px;
      inset: 0.05rem 0.15rem;
    }

    .auth-cover-card .form-floating > .form-control:focus ~ label,
    .auth-cover-card .form-floating > .form-control:not(:placeholder-shown) ~ label,
    .auth-cover-card .form-floating > .form-select ~ label {
      color: #0b5ba0;
      opacity: 1;
    }

    .auth-password-field {
      position: relative;
    }

    .auth-password-field .form-control {
      padding-right: 4.4rem;
    }

    .auth-password-toggle {
      position: absolute;
      top: 50%;
      right: 0.75rem;
      z-index: 5;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 2.75rem;
      height: 2.5rem;
      padding-inline: 0;
      border: 0;
      border-radius: 999px;
      background: rgba(20, 33, 61, 0.92);
      color: #fff;
      cursor: pointer;
      transform: translateY(-50%);
      box-shadow: 0 10px 24px rgba(20, 33, 61, 0.24);
      transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .auth-password-toggle.is-visible {
      background: rgba(11, 91, 160, 0.98);
    }

    .auth-password-toggle:hover,
    .auth-password-toggle:focus {
      background: rgba(11, 91, 160, 0.98);
      color: #fff;
      transform: translateY(-50%) scale(1.03);
    }

    .auth-password-toggle:focus {
      outline: none;
      box-shadow: 0 0 0 0.2rem rgba(11, 91, 160, 0.2);
    }

    .auth-cover-card .btn-primary {
      padding-block: 0.8rem;
      font-weight: 600;
    }

    .auth-cover-card .mb-5 {
      margin-bottom: 1rem !important;
    }

    .auth-cover-card .my-5 {
      margin-block: 0.9rem !important;
    }

    .auth-cover-card .divider .divider-text {
      font-size: 0.9rem;
    }

    .auth-social-button {
      width: 2.5rem;
      height: 2.5rem;
      border-radius: 999px;
      background: rgba(20, 33, 61, 0.08);
    }

    @media (max-width: 575.98px) {
      .auth-cover-page {
        align-items: center;
        justify-content: center;
        padding-inline: 1rem;
      }

      .auth-cover-card {
        width: 100%;
        border-radius: 26px;
        max-height: calc(100dvh - 1.5rem);
        padding: 1.1rem;
      }
    }
  </style>
@endsection

@section('vendor-script')
  @vite([
      'resources/assets/vendor/libs/@form-validation/popular.js',
      'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
      'resources/assets/vendor/libs/@form-validation/auto-focus.js',
  ])
@endsection

@section('page-script')
  @vite(['resources/assets/js/pages-auth.js'])
@endsection

@section('content')
  <div class="authentication-wrapper authentication-cover auth-cover-page">
    <div class="auth-cover-card">
      <a href="{{ url('/') }}" class="auth-card-brand gap-2 mb-4 text-decoration-none">
        <span class="app-brand-logo demo">@include('_partials.macros')</span>
        <span class="app-brand-text demo fw-bold">Verified Artisan Connect</span>
      </a>

      <div class="text-center">
        <h5 class="auth-cover-title mb-2 fw-semibold">Welcome back</h5>
        <p class="auth-cover-subtitle mb-5">Sign in to continue to the Verified Artisan Connect platform.</p>
      </div>

      <form id="formAuthentication" class="mb-5" action="{{ route('auth-login-cover') }}" method="POST">
        @csrf

        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="form-floating form-floating-outline mb-4 form-control-validation">
          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
            placeholder="Enter your email" value="{{ old('email') }}" autofocus required />
          <label for="email">Email Address</label>
          @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="mb-4">
          <div class="form-password-toggle form-control-validation">
            <div class="form-floating form-floating-outline auth-password-field">
              <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                name="password" placeholder="Enter your password" aria-describedby="password" required />
              <label for="password">Password</label>
              <button type="button" class="auth-password-toggle" data-password-target="password" aria-label="Show password"
                aria-pressed="false">
                <i class="icon-base ri ri-eye-off-line icon-20px"></i>
              </button>
            </div>
            @error('password')
              <span class="invalid-feedback d-block">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="mb-5 d-flex justify-content-between align-items-center gap-3 flex-wrap">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
            <label class="form-check-label" for="remember-me">Remember Me</label>
          </div>

          <a href="{{ route('auth-forgot-password-cover') }}">
            <span>Forgot Password?</span>
          </a>
        </div>

        <button type="submit" class="btn btn-primary d-grid w-100">Sign in</button>
      </form>

      <p class="text-center mb-5">
        <span>New on our platform?</span>
        <a href="{{ route('auth-register-cover') }}">
          <span>Create an account</span>
        </a>
      </p>

      <div class="divider my-5">
        <div class="divider-text">or</div>
      </div>

      <div class="d-flex justify-content-center gap-2">
        <a href="javascript:;" class="btn btn-icon auth-social-button btn-text-facebook">
          <i class="icon-base ri ri-facebook-fill icon-18px"></i>
        </a>

        <a href="javascript:;" class="btn btn-icon auth-social-button btn-text-twitter">
          <i class="icon-base ri ri-twitter-fill icon-18px"></i>
        </a>

        <a href="javascript:;" class="btn btn-icon auth-social-button btn-text-github">
          <i class="icon-base ri ri-github-fill icon-18px"></i>
        </a>

        <a href="javascript:;" class="btn btn-icon auth-social-button btn-text-google-plus">
          <i class="icon-base ri ri-google-fill icon-18px"></i>
        </a>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.addEventListener('click', function(evt) {
        const toggle = evt.target.closest('.auth-password-toggle');
        if (!toggle) return;
        evt.preventDefault();

        const targetId = toggle.getAttribute('data-password-target');
        const passwordInput = targetId ? document.getElementById(targetId) : toggle.previousElementSibling;
        const icon = toggle.querySelector('i');

        if (!passwordInput || !icon) return;

        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
          toggle.setAttribute('aria-label', 'Hide password');
          toggle.setAttribute('aria-pressed', 'true');
          toggle.classList.add('is-visible');
          icon.classList.remove('ri-eye-off-line');
          icon.classList.add('ri-eye-line');
        } else {
          passwordInput.type = 'password';
          toggle.setAttribute('aria-label', 'Show password');
          toggle.setAttribute('aria-pressed', 'false');
          toggle.classList.remove('is-visible');
          icon.classList.remove('ri-eye-line');
          icon.classList.add('ri-eye-off-line');
        }
      });
    });
  </script>
@endsection
