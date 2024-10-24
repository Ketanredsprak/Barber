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
                    <div class="barber-review-wrapper">
                        <div
                            class="barber-review-item @if ($barber->is_holiday == 0) @if ($barber->full_booked == 1) grey-border  @else @if ($barber->has_upcoming_booking == 0) green-border @endif @if ($barber->has_upcoming_waitlist == 1) orange-border @else green-border @endif  @endif
@else
grey-border @endif">
                            <div class="img-wrapper">
                                <a href="{{ route('barber-detail', $barber->encrypt_id) }}"> <img
                                        src="{{ static_asset('profile_image/' . $profile_image) }}" alt=""> </a>
                            </div>
                            <div class="barber-info">



                                <h5 class="name"><a
                                        href="{{ route('barber-detail', $barber->encrypt_id) }}">{{ $barber->first_name }}
                                        {{ $barber->last_name }}</a></h5>
                                <h6 class="designation">{{ $barber->salon_name }}</h6>
                                <p class="rating"><span><i
                                            class="fa-solid fa-star"></i></span>{{ $barber->average_rating }}</p>
                                <p class="location"><span><i
                                            class="fa-solid fa-location-dot"></i></span>{{ $barber->location }}
                                    ({{ @$barber->distance ?? 0 }} km)</p>
                                <h6>


                                    {{ __('labels.Availability Status') }} :
                                    @if ($barber->is_holiday == 0)
                                        @if ($barber->full_booked == 1)
                                            <span class="booked"> {{ __('labels.Booked') }}</span>
                                        @else
                                            @if ($barber->has_upcoming_waitlist == 1)
                                                <span class="waiting">{{ __('labels.Waiting') }} </span>
                                            @else
                                                <span class="available">{{ __('labels.Available') }}</span>
                                            @endif
                                        @endif
                                    @else
                                        <span class="booked">{{ __('labels.Booked') }}</span>
                                    @endif


                                </h6>
                                <div>
                                    <a class="btn btn-light" type="submit"
                                        href="{{ route('barber-detail', $barber->encrypt_id) }}">{{ __('labels.Book Now') }}</a>
                                </div>
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
