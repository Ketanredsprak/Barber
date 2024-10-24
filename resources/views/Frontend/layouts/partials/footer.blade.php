@php
    $locale = config('app.locale');
    $config = getWebsiteConfig();
    $location = 'location_' . $locale;
@endphp

<style>

/* Style for the app download section */
.app-download {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
    gap: 10px; /* Space between the store images */
}

.store-image {
    width: 120px; /* Sets a uniform width for both images */
    height: auto;
    border-radius: 8px; /* Optional: Rounds the corners of the images */
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Optional: Adds a subtle shadow effect */
}

</style>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-6">
            <h5>{{ __('labels.Get in Touch') }}</h5>
            <div class="footer_info">
                <ul class="list-unstyled">
                    <li> <i class="fa fa-map-marker"></i> <a href="javascript:void(0)"> {{ __('labels.Location') }}</a>
                        <p>{{ $config->$location }}</p>
                    </li>
                    <li> <i class="fa fa-phone"></i> <a href="tel:{{ $config->phone }}"> {{ __('labels.Phone') }}</a>
                        <p>{{ $config->phone }}</p>
                    </li>
                    <li> <i class="fa fa-envelope-o"></i> <a href="mailto:{{ $config->email }}">
                            {{ __('labels.Email') }}</a>
                        <p>{{ $config->email }}</p>
                    </li>

                </ul>
            </div>

        </div>
        <div class="col-lg-3 col-6">
            <h5>{{ __('labels.Useful Links') }}</h5>
            <div class="footer_info">
                <ul class="list-unstyled">
                    <li> <a href="{{ route('index') }}">{{ __('labels.Home') }}</a></li>
                    <li> <a href="{{ route('about-us') }}">{{ __('labels.About Us') }}</a></li>
                    <li> <a href="{{ route('contact-us') }}">{{ __('labels.Contact Us') }}</a></li>
                    <li> <a href="{{ route('terms-and-condition') }}">{{ __('labels.Terms & Conditions') }}</a></li>
                    <li> <a href="{{ route('privacy-policy') }}">{{ __('labels.Privacy Policy') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <h5>{{ __('labels.Services') }}</h5>
            <div class="footer_info">
                <ul class="list-unstyled">
                    <li> <a href="#">{{ __('labels.Haircut & Beard Trim') }}</a></li>
                    <li> <a href="#">{{ __('labels.Hair Coloring') }}</a></li>
                    <li> <a href="#">{{ __('labels.Hair Treatment') }}</a></li>
                    <li> <a href="#">{{ __('labels.Skin Care') }}</a></li>
                    <li> <a href="#">{{ __('labels.Childrens Care') }}</a></li>
                    <li> <a href="#">{{ __('labels.Hair Dyeing') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <h5>{{ __('labels.Connect with Us') }}</h5>
            <div class="footer_info">
                <div class="footer_social">
                    <ul class="list-unstyled">
                        <li> <a href="{{ $config->tiktok_link }}" target="_blank"> <i class="fa fa-tiktok"></i></a>
                        </li>
                        <li> <a href="{{ $config->twitter_link }}" target="_blank"> <i class="fa fa-twitter"></i></a>
                        </li>
                        <li> <a href="{{ $config->linkedin_link }}" target="_blank"> <i class="fa fa-linkedin"></i></a>
                        </li>
                        <li> <a href="{{ $config->youtube_link }}" target="_blank"> <i class="fa fa-youtube"></i></a>
                        </li>
                    </ul>
                </div>



                <div class="app-download">
                    <a href="{{ $config->play_store_link }}" target="_blank">
                        <img src="{{ static_asset('image/play-store.png') }}" alt="Download on Play Store" class="store-image">
                    </a>
                    <a href="{{ $config->app_store_link }}" target="_blank">
                        <img src="{{ static_asset('image/app-store.png') }}" alt="Download on App Store" class="store-image">
                    </a>
                </div>


            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row copyright">
        <div class="container">
            <div class="content-wrapper">
                <p>© {{ date('Y') }} Ehjez. All Rights Reserved.</p>
                <p>Website design & developed by <a href="https://redsparkinfo.com/" target="_blank">Redspark Technologies</a></p>
            </div>
        </div>
        <div class="col-sm-12 text-center">

        </div>
    </div>
</div>




