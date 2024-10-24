@foreach ($topBarbers as $barber)
<div class="col-lg-4 col-sm-6">
    <div class="item">
        <div class="post_box">
            <div class="top">
                <div class="post_img">
                    <div class="rating">
                        <p><i class="fa fa-star"></i>
                            {{ round($barber->barber_ratings_avg_rating, 2) }}</p>
                    </div>
                    @php
                        if (empty($barber->profile_image)) {
                            $profile_image = 'default.png';
                        } else {
                            $profile_image = $barber->profile_image;
                        }
                    @endphp
                    <a href="{{ route('get-booking-page', $barber->encrypt_id) }}">
                        <img src="{{ static_asset('profile_image/' . $profile_image) }}"
                            class="img-fluid" alt="post">
                    </a>
                </div>
                <div class="post_info">
                    <h5><a href="{{ route('get-booking-page', $barber->encrypt_id) }}">{{ $barber->first_name }}
                            - {{ $barber->last_name }}</a>
                    </h5>
                    <h4 class="shop_name">{{ $barber->salon_name }} ({{ round($barber->distance, 2) }} KM)</h4>
                </div>
            </div>
            <div class="bottom">
                <ul class="list-unstyled">

                    @php
                        $location = $barber->location;
                        $shortLocation =
                            strlen($location) > 30 ? substr($location, 0, 30) . '...' : $location;
                    @endphp

                    <li> <i class="fa fa-map-marker"></i> {{ $shortLocation ?? '' }}</span></li>
                    @if (!empty($barber->barber_service) && !empty($barber->barber_schedule))
                        <a class="btn btn-light" type="submit"
                            href="{{ route('get-booking-page', $barber->encrypt_id) }}">{{ __('labels.Book Now') }}</a>
                    @endif


                </ul>
            </div>
        </div>
    </div>
</div>
@endforeach
