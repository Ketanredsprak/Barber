@php
  $locale = config('app.locale');
  $config = getWebsiteConfig();
  $location = "location_".$locale;
@endphp
<div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <h5>{{ __('labels.Get in Touch') }}</h5>
            <div class="footer_info">
                <ul class="list-unstyled pl-0">
                    <li> <i class="fa fa-map-marker"></i> <a href="javascript:void(0)"> {{ __('labels.Location') }}</a>
                        <p>{{ $config->$location }}</p>
                    </li>
                    <li> <i class="fa fa-phone"></i> <a href="javascript:void(0)"> {{ __('labels.Phone') }}</a>
                        <p>{{ $config->phone }}</p>
                    </li>
                    <li> <i class="fa fa-envelope-o"></i> <a href="javascript:void(0)"> {{ __('labels.Email') }}</a>
                        <p>{{ $config->email }}</p>
                    </li>

                </ul>
            </div>

        </div>
        <div class="col-md-6 col-lg-3">
            <h5>{{ __('labels.Useful Links') }}</h5>
            <div class="footer_info">
                <ul class="list-unstyled pl-0">
                    <li> <a href="#">{{ __('labels.Home') }}</a></li>
                    <li> <a href="#">{{ __('labels.About Us') }}</a></li>
                    <li> <a href="#">{{ __('labels.Contact Us') }}</a></li>
                    <li> <a href="#">{{ __('labels.Terms & Conditions') }}</a></li>
                    <li> <a href="#">{{ __('labels.Privacy Policy') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <h5>{{ __('labels.Services') }}</h5>
            <div class="footer_info">
                <ul class="list-unstyled pl-0">
                    <li> <a href="#">{{ __('labels.Haircut & Beard Trim') }}</a></li>
                    <li> <a href="#">{{ __('labels.Hair Coloring') }}</a></li>
                    <li> <a href="#">{{ __('labels.Hair Treatment') }}</a></li>
                    <li> <a href="#">{{ __('labels.Skin Care') }}</a></li>
                    <li> <a href="#">{{ __('labels.Childrens Care') }}</a></li>
                    <li> <a href="#">{{ __('labels.Hair Dyeing') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 col-lg-3  ">
            <h5>{{ __('labels.Connect with Us') }}</h5>
            <div class="footer_info">
                <div class="footer_social">
                    <ul class="list-unstyled pl-0">
                        <li> <a href="{{ $config->facebook_link }}" target="_blank"> <i class="fa fa-facebook"></i></a> </li>
                        <li> <a href="{{ $config->twitter_link }}" target="_blank"> <i class="fa fa-twitter"></i></a> </li>
                        <li> <a href="{{ $config->linkedin_link }}" target="_blank"> <i class="fa fa-linkedin"></i></a> </li>
                        <li> <a href="{{ $config->youtube_link }}" target="_blank"> <i class="fa fa-youtube"></i></a> </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>


</div>
<div class="row copyright">
    <div class="col-sm-12 text-center">
        <p class="mb-0"> {{ __('labels.Copyright')}} © 2024 Ehjez</p>
    </div>
</div>
