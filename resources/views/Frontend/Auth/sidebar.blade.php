@php
      $currentRouteName = Route::currentRouteName();
@endphp

<ul class="nav sidebar_nav">
    <li class="nav-item d-block">
        <a href="{{ route('my-account')}}" class="nav-link @if($currentRouteName == "my-account") active @endif">
            <span class="dashboard_icon profile"></span>
            <span>{{ __('labels.Profile') }}</span>
        </a>
    </li>

    <li class="nav-item d-block">
        <a href="{{ route('my-account-about')}}" class="nav-link @if($currentRouteName == "my-account-about") active @endif">
            <span class="dashboard_icon post"></span>
            <span>{{ __('labels.About') }}</span>
        </a>
    </li>

    <li class="nav-item d-block">
        <a href="{{ route('my-package') }}" class="nav-link @if($currentRouteName == "my-package") active @endif">
            <span class="dashboard_icon review"></span>
            <span>{{ __('labels.My Package') }}</span>
        </a>
    </li>

    <li class="nav-item d-block">
        <a href="dashboard.html" class="nav-link">
            <span class="dashboard_icon level"></span>
            <span>{{ __('labels.My Booking') }}</span>
        </a>
    </li>

    <li class="nav-item d-block">
        <a href="dashboard.html" class="nav-link">
            <span class="dashboard_icon support"></span>
            <span>{{ __('labels.My Favorite') }}</span>
        </a>
    </li>
    <li class="nav-item d-block">
        <a href="dashboard.html" class="nav-link">
            <span class="dashboard_icon setting"></span>
            <span>{{ __('labels.Points') }}</span>
        </a>
    </li>
    <li class="nav-item d-block">
        <a href="{{ route('change-password') }}" class="nav-link @if($currentRouteName == "change-password") active @endif">
            <span class="dashboard_icon setting"></span>
            <span>{{ __('labels.Change Password') }}</span>
        </a>
    </li>
</ul>
