<div class="explore_list">
    <div class="row">
        @if ($barber_list->isEmpty())
            <div class="white-box">
                <div class="col-sm-12">

                    <div class="no-record">
                        <img src="{{ static_asset('frontend/assets/images/no-record.png') }}" class="img-fluid">
                    </div>

                </div>
            </div>
        @else
            @foreach ($barber_list as $barber)
                @php
                    if (empty($barber->profile_image)) {
                        $profile_image = 'default.png';
                    } else {
                        $profile_image = $barber->profile_image;
                    }
                @endphp

                <div class="col-sm-12  right_sec">
                    <div class="@if($barber->is_holiday == 0) @if($barber->full_booked == 1) barber-review-wrapper2 @else  @if($barber->has_upcoming_booking == 0) barber-review-wrapper1  @endif  @if($barber->has_upcoming_waitlist == 1) barber-review-wrapper3 @else barber-review-wrapper1 @endif @endif @else barber-review-wrapper @endif">
                        <div class="@if($barber->is_holiday == 0) @if($barber->full_booked == 1) barber-review-item2 @else @if($barber->has_upcoming_booking == 0) barber-review-item1  @endif @if($barber->has_upcoming_waitlist == 1)  barber-review-item3 @else barber-review-item1 @endif  @endif @else barber-review-item @endif">
                            <div class="img-wrapper">
                                <a href="{{ route('barber-detail', $barber->encrypt_id) }}"> <img
                                        src="{{ static_asset('profile_image/' . $profile_image) }}" alt=""> </a>
                            </div>
                            <div class="barber-info">
                                <h5 class="name"><a
                                        href="{{ route('barber-detail', $barber->encrypt_id) }}">{{ $barber->first_name }}
                                        {{ $barber->last_name }}</a></h5>
                                <h6 class="designation">{{ $barber->salon_name }} {{ $barber->is_holiday }} </h6>
                                <p class="location"><span><i
                                            class="fa-solid fa-location-dot"></i></span>{{ $barber->location }} ({{ @$barber->distance ?? 0 }} km)
                                </p>
                                <p class="rating"><span><i
                                            class="fa-solid fa-star"></i></span>{{ $barber->average_rating }}</p>
                            </div>
                            <div>
                                <a class="btn btn-success" type="submit"
                                    href="{{ route('barber-detail', $barber->encrypt_id) }}">{{ __('labels.Book Now') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @if (!$barber_list->isEmpty())
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="Page navigation example">
                    {!! $barber_list->links() !!}
                </nav>
            </div>
        </div>
    @endif
</div>
