@php
  $configData = Helper::appClasses();
  $customizerHidden = 'customizer-hide';
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Register Cover - Pages')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
  @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
  @vite(['resources/assets/js/pages-auth.js'])
@endsection

@section('content')
  <div class="authentication-wrapper authentication-cover">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="auth-cover-brand d-flex align-items-center gap-2">
      <span class="app-brand-logo demo">@include('_partials.macros')</span>
      <span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>
    </a>
    <!-- /Logo -->
    <div class="authentication-inner row m-0">
      <!-- /Left Text -->
      <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
        <img src="{{ asset('assets/img/illustrations/auth-register-illustration-' . $configData['theme'] . '.png') }}"
          class="auth-cover-illustration w-100" alt="auth-illustration"
          data-app-light-img="illustrations/auth-register-illustration-light.png"
          data-app-dark-img="illustrations/auth-register-illustration-dark.png" />
        <img src="{{ asset('assets/img/illustrations/auth-cover-register-mask-' . $configData['theme'] . '.png') }}"
          class="authentication-image" alt="mask"
          data-app-light-img="illustrations/auth-cover-register-mask-light.png"
          data-app-dark-img="illustrations/auth-cover-register-mask-dark.png" />
      </div>
      <!-- /Left Text -->

      <!-- Register -->
      <div
        class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-12 px-12 py-6">
        <div class="w-px-400 mx-auto pt-12 pt-lg-0">
          <h4 class="mb-1">Adventure starts here 🚀</h4>
          <p class="mb-5">Create your ArtisanConnect account</p>

          @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <form id="formAuthentication" class="mb-5" action="{{ route('auth-register-cover') }}" method="POST">
            @csrf

            <!-- Full Name -->
            <div class="form-floating form-floating-outline mb-5 form-control-validation">
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                placeholder="Enter your full name" value="{{ old('name') }}" autofocus required />
              <label for="name">Full Name</label>
              @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Email -->
            <div class="form-floating form-floating-outline mb-5 form-control-validation">
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" placeholder="Enter your email" value="{{ old('email') }}" required />
              <label for="email">Email Address</label>
              @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Role Selection -->
            <div class="form-floating form-floating-outline mb-5 form-control-validation">
              <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                <option value="">Select your account type</option>
                <option value="client" {{ old('role') === 'client' ? 'selected' : '' }}>
                  Client (I need services)
                </option>
                <option value="artisan" {{ old('role') === 'artisan' ? 'selected' : '' }}>
                  Artisan (I provide services)
                </option>
              </select>
              <label for="role">Register as:</label>
              @error('role')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Artisan-Specific Fields (Hidden by default) -->
            <div id="artisanFields" style="display: {{ old('role') === 'artisan' ? 'block' : 'none' }};">
              <!-- Business Name -->
              <div class="form-floating form-floating-outline mb-5 form-control-validation">
                <input type="text" class="form-control @error('business_name') is-invalid @enderror" id="business_name"
                  name="business_name" placeholder="Enter your business name" value="{{ old('business_name') }}" />
                <label for="business_name">Business Name</label>
                @error('business_name')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>

              <!-- Category -->
              <div class="form-floating form-floating-outline mb-5 form-control-validation">
                <select class="form-control @error('category') is-invalid @enderror" id="category" name="category">
                  <option value="">Select a category</option>
                  <option value="Carpentry" {{ old('category') === 'Carpentry' ? 'selected' : '' }}>Carpentry</option>
                  <option value="Plumbing" {{ old('category') === 'Plumbing' ? 'selected' : '' }}>Plumbing</option>
                  <option value="Electrical" {{ old('category') === 'Electrical' ? 'selected' : '' }}>Electrical</option>
                  <option value="Painting" {{ old('category') === 'Painting' ? 'selected' : '' }}>Painting</option>
                  <option value="Cleaning" {{ old('category') === 'Cleaning' ? 'selected' : '' }}>Cleaning</option>
                  <option value="Gardening" {{ old('category') === 'Gardening' ? 'selected' : '' }}>Gardening</option>
                  <option value="IT & Technology" {{ old('category') === 'IT & Technology' ? 'selected' : '' }}>IT &
                    Technology</option>
                  <option value="Other" {{ old('category') === 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                <label for="category">Service Category</label>
                @error('category')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>

              <!-- Location -->
              <div class="form-floating form-floating-outline mb-5 form-control-validation">
                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location"
                  name="location" placeholder="Enter your location" value="{{ old('location') }}" />
                <label for="location">Service Location</label>
                @error('location')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>

              <!-- Bio -->
              <div class="mb-5">
                <label for="bio" class="form-label">Bio (Optional)</label>
                <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3"
                  placeholder="Tell us about your services...">{{ old('bio') }}</textarea>
                @error('bio')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
            </div>

            <!-- Password -->
            <div class="mb-5 form-password-toggle form-control-validation">
              <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline">
                  <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" required />
                  <label for="password">Password</label>
                </div>
                <span class="input-group-text cursor-pointer"><i class="icon-base ri ri-eye-off-line"></i></span>
              </div>
              @error('password')
                <span class="invalid-feedback d-block">{{ $message }}</span>
              @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-5 form-password-toggle form-control-validation">
              <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline">
                  <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password_confirmation" required />
                  <label for="password_confirmation">Confirm Password</label>
                </div>
                <span class="input-group-text cursor-pointer"><i class="icon-base ri ri-eye-off-line"></i></span>
              </div>
            </div>

            <!-- Terms & Conditions -->
            <div class="mb-5 form-control-validation">
              <div class="form-check mt-2">
                <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox"
                  id="terms-conditions" name="terms" required />
                <label class="form-check-label" for="terms-conditions">
                  I agree to
                  <a href="javascript:void(0);">privacy policy & terms</a>
                </label>
                @error('terms')
                  <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
              </div>
            </div>

            <button type="submit" class="btn btn-primary d-grid w-100">Sign up</button>
          </form>

          <p class="text-center mb-5">
            <span>Already have an account?</span>
            <a href="{{ route('auth-login-cover') }}">>
              <span>Sign in instead</span>
            </a>
          </p>

          <div class="divider my-5">
            <div class="divider-text">or</div>
          </div>

          <div class="d-flex justify-content-center gap-2">
            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-facebook">
              <i class="icon-base ri ri-facebook-fill icon-18px"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-twitter">
              <i class="icon-base ri ri-twitter-fill icon-18px"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-github">
              <i class="icon-base ri ri-github-fill icon-18px"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-google-plus">
              <i class="icon-base ri ri-google-fill icon-18px"></i>
            </a>
          </div>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const roleSelect = document.getElementById('role');
      const artisanFields = document.getElementById('artisanFields');

      // Toggle artisan fields based on role selection
      roleSelect.addEventListener('change', function() {
        if (this.value === 'artisan') {
          artisanFields.style.display = 'block';
          // Make artisan fields required
          document.getElementById('business_name').required = true;
          document.getElementById('category').required = true;
          document.getElementById('location').required = true;
        } else {
          artisanFields.style.display = 'none';
          // Remove required from artisan fields
          document.getElementById('business_name').required = false;
          document.getElementById('category').required = false;
          document.getElementById('location').required = false;
        }
      });

      // Password visibility toggle
      const passwordToggles = document.querySelectorAll('.input-group-text');
      passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
          const passwordInput = this.parentElement.querySelector(
            'input[type="password"], input[type="text"]');
          const icon = this.querySelector('i');

          if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('ri-eye-off-line');
            icon.classList.add('ri-eye-line');
          } else {
            passwordInput.type = 'password';
            icon.classList.remove('ri-eye-line');
            icon.classList.add('ri-eye-off-line');
          }
        });
      });
    });
  </script>
@endsection
