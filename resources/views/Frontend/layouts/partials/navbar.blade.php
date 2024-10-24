@php
    $locale = config('app.locale');
    $config = getWebsiteConfig();
    $auth = getauthdata();
    $currentRouteName = Route::currentRouteName();

    if (empty($auth->profile_image)) {
        $profile_image = 'default.png';
    } else {
        $profile_image = $auth->profile_image;
    }

@endphp
<style>
    .header_image {
        border-radius: 50%;
        height: 30px;
        width: 30px;
    }
</style>
<div class="container">
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand color_logo" href="{{ route('index') }}">
            <img src="{{ static_asset('website-config/' . $config->header_logo) }}" class="img-fluid" alt="logo">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="fa fa-bars"></i>
            </span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link @if ($currentRouteName == 'index') active @endif"
                        href="{{ route('index') }}">{{ __('labels.Home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  @if ($currentRouteName == 'services') active @endif"
                        href="{{ route('services') }}">{{ __('labels.Services') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($currentRouteName == 'barber-list') active @endif"
                        href="{{ route('barber-list') }}">{{ __('labels.Barbers Search') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  @if ($currentRouteName == 'my-package') active @endif"
                        href="{{ route('my-package') }}">{{ __('labels.Packages') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($currentRouteName == 'about-us') active @endif"
                        href="{{ route('about-us') }}">{{ __('labels.About Us') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($currentRouteName == 'contact-us') active @endif"
                        href="{{ route('contact-us') }}">{{ __('labels.Contact Us') }}</a>
                </li>
                <li class="mobile-links">
                    <a class="btn btn-warning" href="{{ route('login') }}" type="submit">{{ __('labels.Sign In') }}</a>                
                </li>
                <li class="mobile-links">
                    <a class="btn btn-light" href="{{ route('register') }}" type="submit">{{ __('labels.Sign Up') }}</a>
                </li>
            </ul>
        </div>

        <div class="action-btns-wrapper">
            @guest
            @else
                <div class="notifications-item"> <span><a href="{{ route('notification-list') }}"><i class="fa fa-bell" aria-hidden="true"></i></span>
                    <span class="badge">
                        @php  $number = getNotificationCount(); @endphp
                        {{ $number }}
                    </span>
                    </a>
                </div>
            @endguest


            <div class="header_btn">

                @guest

                    <a class="btn btn-warning desktop-links" href="{{ route('login') }}" type="submit">{{ __('labels.Sign In') }}</a>
                    <a class="btn btn-light desktop-links" href="{{ route('register') }}" type="submit">{{ __('labels.Sign Up') }}</a>
                @else
                    <div class="dropdown profile_btn">
                        <button class="btn btn-outline-warning dropdown-toggle" type="button" data-toggle="dropdown">
                            <img src="{{ static_asset('profile_image/' . $profile_image) }}" class="header_image">
                            <span>{{ $auth->first_name }}</span>
                        </button>
                        <div class="dropdown-menu">
                            {{-- <div class="mobile_menu">
                                <a class="dropdown-item @if ($currentRouteName == 'my-account') active @endif"
                                    href="{{ route('my-account') }}">{{ __('labels.Profile') }} </a>
                                <a class="dropdown-item @if ($currentRouteName == 'my-package') active @endif"
                                    href="{{ route('my-package') }}">{{ __('labels.Packages') }}</a>
                                <a class="dropdown-item @if ($currentRouteName == 'my-booking-appointment-today') active @endif"
                                    href="{{ route('my-booking-appointment-today') }}">{{ __('labels.My Booking') }}</a>
                                <a class="dropdown-item  @if ($currentRouteName == 'my-favorite') active @endif"
                                    href="{{ route('my-favorite') }}">{{ __('labels.My Favorite') }}</a>
                                <a class="dropdown-item @if ($currentRouteName == 'my-point') active @endif"
                                    href="{{ route('my-point') }}">{{ __('labels.Points') }}</a>
                                <a class="dropdown-item @if ($currentRouteName == 'change-password') active @endif"
                                    href="{{ route('change-password') }}">{{ __('labels.Change Password') }}</a>
                            </div> --}}
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf</form>
                            <a class="dropdown-item @if ($currentRouteName == 'my-account') active @endif"
                                href="{{ route('my-account') }}">{{ __('labels.Profile') }} </a>
                            <a class="dropdown-item @if ($currentRouteName == 'my-package') active @endif"
                                href="{{ route('my-package') }}">{{ __('labels.Packages') }}</a>
                            <a class="dropdown-item @if ($currentRouteName == 'my-booking-appointment-today') active @endif"
                                href="{{ route('my-booking-appointment-today') }}">{{ __('labels.My Booking') }}</a>
                            <a class="dropdown-item  @if ($currentRouteName == 'my-favorite') active @endif"
                                href="{{ route('my-favorite') }}">{{ __('labels.My Favorite') }}</a>
                            <a class="dropdown-item @if ($currentRouteName == 'my-point') active @endif"
                                href="{{ route('my-point') }}">{{ __('labels.Points') }}</a>
                            <a class="dropdown-item @if ($currentRouteName == 'my-chat') active @endif"
                                href="{{ route('my-chat') }}">{{ __('labels.My Chat') }}</a>
                            <a class="dropdown-item @if ($currentRouteName == 'change-password') active @endif"
                                href="{{ route('change-password') }}">{{ __('labels.Change Password') }}</a>
                            {{-- <a class="dropdown-item @if ($currentRouteName == 'my-account') active @endif"
                                href="{{ route('my-account') }}">{{ __('labels.Profile') }}</a> --}}
                            <a class="dropdown-item" href="javascript:void(0);"
                                onclick="showConfirmationModal('{{ route('logout') }}');">
                                {{ __('labels.Logout') }}
                            </a>
                        </div>
                    </div>
                @endguest
            </div>
            <div class="dropdown select-lang">
                <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    {{ strtoupper($locale) }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item @if ($locale == 'en') active @endif"
                        href="javascript:void(0);" onclick="change_lang('en');">English</a>
                    <a class="dropdown-item @if ($locale == 'ar') active @endif"
                        href="javascript:void(0);" onclick="change_lang('ar');">Arabic</a>
                    <a class="dropdown-item @if ($locale == 'ur') active @endif"
                        href="javascript:void(0);" onclick="change_lang('ur');">Urdu</a>
                    <a class="dropdown-item @if ($locale == 'tr') active @endif"
                        href="javascript:void(0);" onclick="change_lang('tr');">Turkish</a>
                </div>
            </div>
        </div>




    </nav>





    <script>
        function showConfirmationModal(logoutUrl) {
            // Show the modal
            $('#confirmationModal').modal('show');

            // Set up the "Yes" button to trigger the logout
            $('#confirmYesButton').off('click').on('click', function() {
                // Submit the logout form
                $('#logout-form').attr('action', logoutUrl).submit();
            });
        }
    </script>
