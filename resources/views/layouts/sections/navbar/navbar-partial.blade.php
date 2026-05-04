@php
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Route;
@endphp

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
@if (isset($navbarFull))
  <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-6">
    <a href="{{ url('/') }}" class="app-brand-link gap-2">
      <span class="app-brand-logo demo">@include('_partials.macros')</span>
      <span class="app-brand-text demo menu-text fw-semibold ms-1">{{ config('variables.templateName') }}</span>
    </a>

    <!-- Display menu close icon only for horizontal-menu with navbar-full -->
    @if (isset($menuHorizontal))
      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
        <i class="icon-base ri ri-close-line icon-sm"></i>
      </a>
    @endif
  </div>
@endif

<!-- ! Not required for layout-without-menu -->
@if (!isset($navbarHideToggle))
  <div
    class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 {{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
      <i class="icon-base ri ri-menu-line icon-md"></i>
    </a>
  </div>
@endif

<div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">


  <ul class="navbar-nav flex-row align-items-center ms-md-auto">

    @if ($configData['hasCustomizer'] == true)
      <!-- Style Switcher -->
      <li class="nav-item dropdown me-sm-2 me-xl-0">
        <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill" id="nav-theme"
          href="javascript:void(0);" data-bs-toggle="dropdown">
          <i class="icon-base ri ri-sun-line icon-22px theme-icon-active"></i>
          <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
          <li>
            <button type="button" class="dropdown-item align-items-center active" data-bs-theme-value="light"
              aria-pressed="false">
              <span><i class="icon-base ri ri-sun-line icon-22px me-3" data-icon="sun-line"></i>Light</span>
            </button>
          </li>
          <li>
            <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="dark"
              aria-pressed="true">
              <span><i class="icon-base ri ri-moon-clear-line icon-22px me-3"
                  data-icon="moon-clear-line"></i>Dark</span>
            </button>
          </li>
          <li>
            <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="system"
              aria-pressed="false">
              <span><i class="icon-base ri ri-computer-line icon-22px me-3" data-icon="computer-line"></i>System</span>
            </button>
          </li>
        </ul>
      </li>
      <!-- / Style Switcher-->
    @endif

    <!-- Notification -->
    <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-4 me-xl-1">
      <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
        href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
        <i class="icon-base ri ri-notification-2-line icon-22px"></i>
        <span class="position-absolute top-0 start-50 translate-middle-y badge badge-dot bg-danger mt-2 border"></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end py-0">
        <li class="dropdown-menu-header border-bottom py-50">
          <div class="dropdown-header d-flex align-items-center py-2">
            <h6 class="mb-0 me-auto">Notification</h6>
            <div class="d-flex align-items-center h6 mb-0">
              <span class="badge rounded-pill bg-label-primary fs-xsmall me-2">0 New</span>
              <a href="javascript:void(0)" class="dropdown-notifications-all p-2" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Mark all as read"><i
                  class="icon-base ri ri-mail-open-line text-heading"></i> </a>
            </div>
          </div>
        </li>
        <li class="dropdown-notifications-list scrollable-container">
          <ul class="list-group list-group-flush">
            <li class="list-group-item text-center py-4">
              <small class="text-body-secondary">No notifications yet</small>
            </li>
          </ul>
        </li>
        <li class="border-top">
          <div class="d-grid p-4">
            <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
              <small class="align-middle">View all notifications</small>
            </a>
          </div>
        </li>
      </ul>
    </li>
    <!--/ Notification -->

    <!-- Shopping Cart (Only for client users) -->
    @auth
      @if (auth()->user()->role === 'client')
        <li class="nav-item me-4 me-xl-1">
          <a class="nav-link btn btn-icon btn-text-secondary rounded-pill position-relative"
            href="{{ route('cart.index') }}" title="My Cart">
            <i class="icon-base ri ri-shopping-cart-2-line icon-22px"></i>
            @if (isset($cartCount) && $cartCount > 0)
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $cartCount }}
              </span>
            @endif
          </a>
        </li>
      @endif
    @endauth
    <!--/ Shopping Cart -->

    <!-- User -->
    <li class="nav-item navbar-dropdown dropdown-user dropdown">
      <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
          @if (Auth::check() && Auth::user()->profile_photo_url)
            <img src="{{ Auth::user()->profile_photo_url }}" alt="avatar" class="rounded-circle" />
          @elseif (Auth::check())
            <span class="avatar-initial rounded-circle bg-label-primary">
              {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
            </span>
          @else
            <img src="{{ asset('assets/img/avatars/1.png') }}" alt="avatar" class="rounded-circle" />
          @endif
        </div>
      </a>
      <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
        <li>
          <a class="dropdown-item"
            href="{{ auth()->check() ? (auth()->user()->role === 'artisan' ? route('artisan-profile') : route('user-profile')) : url('pages/profile-user') }}">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0 me-2">
                <div class="avatar avatar-online">
                  @if (Auth::check() && Auth::user()->profile_photo_url)
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="alt"
                      class="w-px-40 h-auto rounded-circle" />
                  @elseif (Auth::check())
                    <span
                      class="avatar-initial rounded-circle bg-label-primary w-px-40 h-px-40 d-flex align-items-center justify-content-center">
                      {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
                    </span>
                  @else
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt="alt"
                      class="w-px-40 h-auto rounded-circle" />
                  @endif
                </div>
              </div>
              <div class="flex-grow-1">
                <h6 class="mb-0 small">
                  @if (Auth::check())
                    {{ Auth::user()->name }}
                  @else
                    John Doe
                  @endif
                </h6>
                <small class="text-body-secondary">{{ ucfirst(auth()->user()->role ?? 'User') }}</small>
              </div>
            </div>
          </a>
        </li>
        <li>
          <div class="dropdown-divider"></div>
        </li>
        <li>
          <a class="dropdown-item"
            href="{{ auth()->check() ? (auth()->user()->role === 'artisan' ? route('artisan-profile') : route('user-profile')) : url('pages/profile-user') }}">
            <i class="icon-base ri ri-user-3-line icon-22px me-2"></i> <span class="align-middle">My Profile</span>
          </a>
        </li>
        <li>
          <div class="dropdown-divider my-1"></div>
        </li>
        @if (Auth::check())
          <li>
            <div class="d-grid px-4 pt-2 pb-1">
              <a class="btn btn-danger d-flex" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <small class=" align-middle">Logout</small>
                <i class="icon-base ri ri-logout-box-r-line ms-2 icon-16px"></i>
              </a>
            </div>
          </li>
          <form method="POST" id="logout-form" action="{{ route('logout') }}">
            @csrf
          </form>
        @else
          <li>
            <div class="d-grid px-4 pt-2 pb-1">
              <a class="btn btn-danger d-flex"
                href="{{ Route::has('login') ? route('login') : url('auth/login-basic') }}">
                <small class="align-middle">Login</small>
                <i class="icon-base ri ri-logout-box-r-line ms-2 icon-16px"></i>
              </a>
            </div>
          </li>
        @endif
      </ul>
    </li>
    <!--/ User -->
  </ul>
</div>
