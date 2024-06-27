@php
  $locale = config('app.locale');
  $config = getWebsiteConfig();
@endphp

<div class="container">
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand white_logo" href="index.html">
            <img src="{{ static_asset('website-config/'.$config->header_logo) }}" class="img-fluid" alt="logo">
        </a>
        <a class="navbar-brand color_logo" href="index.html">
            <img src="{{ static_asset('website-config/'.$config->footer_logo) }}" class="img-fluid" alt="logo">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="fa fa-bars"></i>
            </span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.html">{{ __('labels.Home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">{{ __('labels.Services') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">{{ __('labels.Find Barber') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">{{ __('labels.Packages') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">{{ __('labels.About Us') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contactus.html">{{ __('labels.Contact Us') }}</a>
                </li>
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ strtoupper($locale) }}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item @if($locale == "en") active @endif" href="javascript:void(0);" onclick="change_lang('en');">English</a>
                        <a class="dropdown-item @if($locale == "ar") active @endif" href="javascript:void(0);" onclick="change_lang('ar');">Arabic</a>
                        <a class="dropdown-item @if($locale == "ur") active @endif" href="javascript:void(0);" onclick="change_lang('ur');">Urdu</a>
                        <a class="dropdown-item @if($locale == "tr") active @endif" href="javascript:void(0);" onclick="change_lang('tr');">Turkish</a>
                    </div>
                </div>
            </ul>
        </div>
        <div class="header_btn">
            <button class="btn btn-warning mr-2" type="submit">{{ __('labels.Log In') }}</button>
            <button class="btn btn-light" type="submit">{{ __('labels.Sign Up') }}</button>
        </div>
    </nav>
</div>
