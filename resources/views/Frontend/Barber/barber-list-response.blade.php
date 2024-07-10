    <div class="explore_list">
        <div class="row">

            @foreach ($barber_list as $barber)
                <div class="col-sm-12 col-md-6">
                    <div class="item">
                        <div class="post_box">
                            <div class="top">
                                <div class="post_img">
                                    <div class="rating">
                                        <p><i class="fa fa-star"></i>4.5</p>
                                    </div>
                                    <a href="">
                                        @php
                                            if (empty($barber->profile_image)) {
                                                $profile_image = 'default.png';
                                            } else {
                                                $profile_image = $barber->profile_image;
                                            }
                                        @endphp

                                        <img src="{{ static_asset('profile_image/' . $profile_image) }}"
                                            class="img-fluid" alt="post">
                                    </a>
                                </div>
                                <div class="post_info">
                                    <h5><a href="">{{ $barber->first_name }} {{ $barber->last_name }}</a></h5>
                                    <h4 class="shop_name">{{ $barber->salon_name }}</h4>
                                </div>
                            </div>
                            <div class="bottom">
                                <ul class="list-unstyled">
                                    <li><span> <i class="fa fa-map-marker"></i> {{ $barber->location }} (1 km)</span></li>
                                    <a class="btn btn-success" type="submit"
                                        href="{{ route('barber-detail', $barber->encrypt_id) }}">{{ __('labels.Book Now') }}</a>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>


        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="Page navigation example">
                    {!! $barber_list->links() !!}
                </nav>
            </div>
        </div>

    </div>
