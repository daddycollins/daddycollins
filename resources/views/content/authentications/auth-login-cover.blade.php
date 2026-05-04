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

    @keyframes movingBorder {
      0% {
        box-shadow:
          0 24px 60px rgba(15, 23, 42, 0.3),
          inset 0 1px 2px rgba(255, 255, 255, 0.5),
          inset 0 -1px 2px rgba(0, 0, 0, 0.05),
          0 0 20px rgba(11, 91, 160, 0.3),
          inset 0 0 20px rgba(11, 91, 160, 0.05);
      }

      50% {
        box-shadow:
          0 24px 60px rgba(15, 23, 42, 0.3),
          inset 0 1px 2px rgba(255, 255, 255, 0.5),
          inset 0 -1px 2px rgba(0, 0, 0, 0.05),
          0 0 40px rgba(11, 91, 160, 0.5),
          inset 0 0 40px rgba(11, 91, 160, 0.1);
      }

      100% {
        box-shadow:
          0 24px 60px rgba(15, 23, 42, 0.3),
          inset 0 1px 2px rgba(255, 255, 255, 0.5),
          inset 0 -1px 2px rgba(0, 0, 0, 0.05),
          0 0 20px rgba(11, 91, 160, 0.3),
          inset 0 0 20px rgba(11, 91, 160, 0.05);
      }
    }

    .auth-cover-card {
      position: relative;
      z-index: 1;
      width: min(100%, 36rem);
      max-height: calc(100dvh - 2rem);
      padding: clamp(1.25rem, 2.5vw, 2rem);
      border: 2px solid rgba(11, 91, 160, 0.6);
      border-radius: 32px;
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.48) 0%, rgba(255, 255, 255, 0.38) 100%);
      backdrop-filter: blur(20px);
      overflow: hidden;
      transition: all 0.3s ease;
      animation: movingBorder 3s infinite ease-in-out;
    }

    .auth-cover-card:hover {
      border-color: rgba(11, 91, 160, 0.9);
    }

    .auth-card-brand {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      color: #14213d;
      transition: all 0.3s ease;
    }

    .auth-card-brand:hover {
      transform: scale(1.02);
    }

    .auth-card-brand .app-brand-text {
      color: #14213d !important;
      font-size: 1.1rem;
      letter-spacing: 0.01em;
      font-weight: 700;
      background: linear-gradient(135deg, #0b5ba0, #14213d);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
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
    .auth-cover-card .btn-primary {
      border-radius: 12px !important;
    }

    .auth-field-input {
      border: 1.5px solid rgba(20, 33, 61, 0.2) !important;
      border-left: 0 !important;
      border-radius: 0 12px 12px 0 !important;
      background: rgba(255, 255, 255, 0.95) !important;
      height: 2.75rem !important;
      padding: 0.5rem 0.875rem !important;
      font-size: 0.9rem;
      color: #14213d;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .auth-field-input::placeholder {
      color: rgba(20, 33, 61, 0.45);
      font-size: 0.88rem;
    }

    .auth-field-input:focus {
      border-color: #0b5ba0 !important;
      background: #fff !important;
      box-shadow: 0 0 0 0.2rem rgba(11, 91, 160, 0.18) !important;
      outline: none;
    }

    .auth-field-icon {
      background: rgba(255, 255, 255, 0.95) !important;
      border: 1.5px solid rgba(20, 33, 61, 0.2) !important;
      border-right: 0 !important;
      border-radius: 12px 0 0 12px !important;
      color: #0b5ba0;
      height: 2.75rem;
      padding: 0 0.875rem;
      display: flex;
      align-items: center;
    }

    .auth-cover-card .input-group {
      flex-wrap: nowrap;
    }

    .auth-password-toggle-append {
      border: 1.5px solid rgba(20, 33, 61, 0.2);
      border-left: 0;
      border-radius: 0 12px 12px 0 !important;
      background: linear-gradient(135deg, rgba(20, 33, 61, 0.88), rgba(20, 33, 61, 0.75));
      color: #fff;
      padding: 0 0.875rem;
      height: 2.75rem;
      display: flex;
      align-items: center;
      cursor: pointer;
      transition: background 0.2s ease;
    }

    .auth-password-toggle-append.is-visible,
    .auth-password-toggle-append:hover,
    .auth-password-toggle-append:focus {
      background: linear-gradient(135deg, #0b5ba0, rgba(11, 91, 160, 0.9));
      color: #fff;
      outline: none;
    }

    .auth-password-toggle {
      position: absolute;
      top: 50%;
      right: 0.75rem;
      z-index: 20;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 2.75rem;
      height: 2.5rem;
      padding-inline: 0;
      border: 0;
      border-radius: 999px;
      background: linear-gradient(135deg, rgba(20, 33, 61, 0.9), rgba(20, 33, 61, 0.8));
      color: #fff;
      cursor: pointer;
      transform: translateY(-50%);
      box-shadow: 0 10px 24px rgba(20, 33, 61, 0.24);
      transition: all 0.3s ease;
    }

    .auth-password-toggle.is-visible {
      background: linear-gradient(135deg, #0b5ba0, rgba(11, 91, 160, 0.9));
      box-shadow: 0 12px 28px rgba(11, 91, 160, 0.32);
    }

    .auth-password-toggle:hover,
    .auth-password-toggle:focus {
      background: linear-gradient(135deg, #0b5ba0, rgba(11, 91, 160, 0.95));
      color: #fff;
      transform: translateY(-50%) scale(1.08);
      box-shadow: 0 14px 32px rgba(11, 91, 160, 0.35);
    }

    .auth-password-toggle:focus {
      outline: none;
      box-shadow:
        0 14px 32px rgba(11, 91, 160, 0.35),
        0 0 0 0.3rem rgba(11, 91, 160, 0.15);
    }

    .auth-cover-card .btn-primary {
      padding-block: 0.9rem;
      font-weight: 600;
      background: linear-gradient(135deg, #0b5ba0, rgba(11, 91, 160, 0.9));
      border: 0;
      box-shadow: 0 8px 20px rgba(11, 91, 160, 0.24);
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      font-size: 0.95rem;
    }

    .auth-cover-card .btn-primary:hover {
      background: linear-gradient(135deg, rgba(11, 91, 160, 0.95), #0b5ba0);
      box-shadow: 0 12px 28px rgba(11, 91, 160, 0.35);
      transform: translateY(-2px);
    }

    .auth-cover-card .btn-primary:focus {
      box-shadow:
        0 12px 28px rgba(11, 91, 160, 0.35),
        0 0 0 0.3rem rgba(11, 91, 160, 0.15);
    }

    .auth-cover-card .btn-primary:active {
      transform: translateY(0);
    }

    .auth-cover-card .mb-5 {
      margin-bottom: 1rem !important;
    }

    .auth-cover-card .my-5 {
      margin-block: 0.9rem !important;
    }

    .auth-cover-card .form-check {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .auth-cover-card .form-check-input {
      width: 1.2rem;
      height: 1.2rem;
      border: 1.5px solid rgba(20, 33, 61, 0.3);
      border-radius: 0.25rem;
      background: rgba(255, 255, 255, 0.95);
      cursor: pointer;
      transition: all 0.3s ease;
      margin: 0;
    }

    .auth-cover-card .form-check-input:checked {
      background: linear-gradient(135deg, #0b5ba0, rgba(11, 91, 160, 0.9));
      border-color: #0b5ba0;
    }

    .auth-cover-card .form-check-input:focus {
      border-color: #0b5ba0;
      box-shadow: 0 0 0 0.2rem rgba(11, 91, 160, 0.15);
    }

    .auth-cover-card .form-check-label {
      color: #445468;
      cursor: pointer;
      user-select: none;
      font-weight: 500;
      margin-bottom: 0;
    }

    .auth-cover-card a {
      color: #0b5ba0;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
      position: relative;
    }

    .auth-cover-card a::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background: linear-gradient(90deg, #0b5ba0, rgba(11, 91, 160, 0.6));
      transition: width 0.3s ease;
    }

    .auth-cover-card a:hover {
      color: rgba(11, 91, 160, 0.8);
    }

    .auth-cover-card a:hover::after {
      width: 100%;
    }

    .auth-cover-card .text-center a {
      display: inline;
    }

    .auth-cover-card .divider {
      position: relative;
      margin: 1.5rem 0;
      border: 0;
      border-top: 1px solid rgba(20, 33, 61, 0.15);
    }

    .auth-cover-card .divider .divider-text {
      font-size: 0.85rem;
      color: #526072;
      font-weight: 500;
      letter-spacing: 0.02em;
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.48), rgba(255, 255, 255, 0.38));
      padding: 0 0.75rem;
      position: relative;
      bottom: -0.65rem;
      display: inline-block;
      width: auto;
    }

    .auth-social-button {
      width: 2.5rem;
      height: 2.5rem;
      border-radius: 999px;
      background: rgba(20, 33, 61, 0.1);
      border: 1px solid rgba(20, 33, 61, 0.2);
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .auth-social-button:hover {
      background: linear-gradient(135deg, rgba(11, 91, 160, 0.15), rgba(20, 33, 61, 0.15));
      border-color: rgba(11, 91, 160, 0.4);
      transform: translateY(-3px) scale(1.08);
      box-shadow: 0 8px 16px rgba(11, 91, 160, 0.15);
    }

    .auth-social-button:focus {
      outline: none;
      box-shadow: 0 0 0 0.3rem rgba(11, 91, 160, 0.15);
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
  @vite(['resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
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

        <div class="input-group mb-3 form-control-validation @error('email') has-validation @enderror">
          <span class="input-group-text auth-field-icon">
            <i class="ri ri-mail-line icon-18px"></i>
          </span>
          <input type="email" class="form-control auth-field-input @error('email') is-invalid @enderror" id="email" name="email"
            placeholder="Email Address" value="{{ old('email') }}" autofocus required />
          @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="mb-4">
          <div class="form-password-toggle">
            <div class="input-group form-control-validation @error('password') has-validation @enderror">
              <span class="input-group-text auth-field-icon">
                <i class="ri ri-lock-line icon-18px"></i>
              </span>
              <input type="password" id="password" class="form-control auth-field-input @error('password') is-invalid @enderror"
                name="password" placeholder="Password" required />
              <button type="button" class="auth-password-toggle-append" data-password-target="password"
                aria-label="Show password" aria-pressed="false">
                <i class="icon-base ri ri-eye-off-line icon-18px"></i>
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
      // Handle password toggle
      const toggleButtons = document.querySelectorAll('.auth-password-toggle, .auth-password-toggle-append');

      toggleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();

          const targetId = this.getAttribute('data-password-target');
          const passwordInput = targetId ? document.getElementById(targetId) : null;
          const icon = this.querySelector('i');

          if (!passwordInput || !icon) return;

          if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            this.setAttribute('aria-label', 'Hide password');
            this.setAttribute('aria-pressed', 'true');
            this.classList.add('is-visible');
            icon.classList.remove('ri-eye-off-line');
            icon.classList.add('ri-eye-line');
          } else {
            passwordInput.type = 'password';
            this.setAttribute('aria-label', 'Show password');
            this.setAttribute('aria-pressed', 'false');
            this.classList.remove('is-visible');
            icon.classList.remove('ri-eye-line');
            icon.classList.add('ri-eye-off-line');
          }
        });

        // Also handle mousedown for better responsiveness
        button.addEventListener('mousedown', function(e) {
          e.preventDefault();
        });
      });
    });
  </script>
@endsection
