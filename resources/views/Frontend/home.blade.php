@extends('Frontend.layouts.app')
@section('content')
    @php
        $language = config('app.locale');
        $title = 'title_' . $language;
        $sub_title = 'sub_title_' . $language;
        $content = 'content_' . $language;
        $testimonial_content = 'testimonial_content_' . $language;
        $name = 'name_' . $language;
        $designation = 'designation_' . $language;

    @endphp
    <section class="banner_slider">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 px-0">
                    <div id="banner" class="owl-carousel owl-theme">


                        @foreach ($banners as $banner)
                            <div class="item">
                                <div class="slide_box"
                                    style="background-image: url({{ static_asset('banner_image/' . $banner->banner_image) }});">
                                    <div class="banner_info">
                                        <h1>{{ @$banner->$title }}</h1>
                                        <p>{{ @$banner->$content }}</p>
                                        <div class="info_btn">
                                            <button class="btn btn-warning mr-2"
                                                type="submit">{{ __('labels.Learn More') }}</button>
                                            <button class="btn btn-outline-light"
                                                type="submit">{{ __('labels.Our Services') }}</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="explore_sec pt-75 pb-75">

        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center mb-4">
                    <div class="head">
                        <h3>{{ $data->cms_content[0]->$title }}</h3>
                    </div>
                    <div class="title">
                        <h2>{{ $data->cms_content[0]->$sub_title }}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="explore_box">
                        <img src="{{ static_asset('frontend/assets/images/service1.png') }}" class="img-fluid"
                            alt="explore">
                        <div class="info">
                            <a href="">
                                <h4 class="text-center">Haircut & Beard Trim</h4>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="explore_box">
                        <img src="{{ static_asset('frontend/assets/images/service2.png') }}" class="img-fluid"
                            alt="explore">
                        <div class="info">
                            <a href="">
                                <h4 class="text-center">Hair Coloring</h4>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="explore_box">
                        <img src="{{ static_asset('frontend/assets/images/service3.png') }}" class="img-fluid"
                            alt="explore">
                        <div class="info">
                            <a href="">
                                <h4 class="text-center">Hair Treatment</h4>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="explore_box">
                        <img src="{{ static_asset('frontend/assets/images/service4.png') }}" class="img-fluid"
                            alt="explore">
                        <div class="info">
                            <a href="">
                                <h4 class="text-center">Skin Care</h4>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="explore_box">
                        <img src="{{ static_asset('frontend/assets/images/service5.png') }}" class="img-fluid"
                            alt="explore">
                        <div class="info">
                            <a href="">
                                <h4 class="text-center">Children's Care</h4>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="explore_box">
                        <img src="{{ static_asset('frontend/assets/images/service6.png') }}" class="img-fluid"
                            alt="explore">
                        <div class="info">
                            <a href="">
                                <h4 class="text-center">Hair Dyeing</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="row">
                    <div class="col-sm-12 text-center">
                      <a href="" class="btn btn-warning">View All Cities</a>
                    </div>
                  </div> -->
        </div>
    </section>

    <section class="explore_sec pt-75 pb-75" style="background-color: #fcc06015;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 mb-4">
                    <div class="head">
                        <h3>{{ $data->cms_content[1]->$title }}</h3>
                    </div>
                    <div class="title">
                        <h2>{{ $data->cms_content[1]->$sub_title }}</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="item">
                        <div class="post_box">
                            <div class="top">
                                <div class="post_img">
                                    <div class="rating">
                                        <p><i class="fa fa-star"></i> 4.5</p>
                                    </div>
                                    <a href="">
                                        <img src="{{ static_asset('frontend/assets/images/nearest_1.png') }}"
                                            class="img-fluid" alt="post">
                                    </a>
                                </div>
                                <div class="post_info">
                                    <h5><a href="">Jonson Barber</a></h5>
                                    <h4 class="shop_name">Alfa Barber shop</h4>
                                </div>
                            </div>
                            <div class="bottom">
                                <ul class="list-unstyled">
                                    <li> <i class="fa fa-map-marker"></i> Jalan Kaliurang (1 km)</span></li>
                                    <button class="btn btn-success" type="submit">{{ __('labels.Book Now') }}</button>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="item">
                        <div class="post_box">
                            <div class="top">
                                <div class="post_img">
                                    <div class="rating">
                                        <p><i class="fa fa-star"></i> 4.5</p>
                                    </div>
                                    <a href="">
                                        <img src="{{ static_asset('frontend/assets/images/nearest_2.png') }}"
                                            class="img-fluid" alt="post">
                                    </a>
                                </div>
                                <div class="post_info">
                                    <h5><a href="">Jonson Barber</a></h5>
                                    <h4 class="shop_name">Alfa Barber shop</h4>
                                </div>
                            </div>

                            <div class="bottom">
                                <ul class="list-unstyled">
                                    <li> <i class="fa fa-map-marker"></i> Jalan Kaliurang (1 km)</span></li>
                                    <button class="btn btn-success" type="submit">{{ __('labels.Book Now') }}</button>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="item">
                        <div class="post_box">
                            <div class="top">
                                <div class="post_img">
                                    <div class="rating">
                                        <p><i class="fa fa-star"></i> 4.5</p>
                                    </div>

                                    <a href="">
                                        <img src="{{ static_asset('frontend/assets/images/nearest_3.png') }}"
                                            class="img-fluid" alt="post">
                                    </a>

                                </div>

                                <div class="post_info">
                                    <h5><a href="">Jonson Barber</a></h5>
                                    <h4 class="shop_name">Alfa Barber shop</h4>
                                </div>
                            </div>

                            <div class="bottom">
                                <ul class="list-unstyled">
                                    <li> <i class="fa fa-map-marker"></i> Jalan Kaliurang (1 km)</span></li>
                                    <button class="btn btn-success" type="submit">{{ __('labels.Book Now') }}</button>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <section class="explore_sec pt-75 pb-75">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 mb-4">
                    <div class="head">
                        <h3>{{ $data->cms_content[2]->$title }}</h3>
                    </div>
                    <div class="title">
                        <h2>{{ $data->cms_content[2]->$title }}</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="item">
                        <div class="post_box">
                            <div class="top">
                                <div class="post_img">
                                    <div class="rating">
                                        <p><i class="fa fa-star"></i> 4.5</p>
                                    </div>

                                    <a href="">
                                        <img src="{{ static_asset('frontend/assets/images/higest_1.png') }}"
                                            class="img-fluid" alt="post">
                                    </a>
                                </div>
                                <div class="post_info">
                                    <h5><a href="">Jonson Barber</a></h5>
                                    <h4 class="shop_name">Alfa Barber shop</h4>
                                </div>
                            </div>
                            <div class="bottom">
                                <ul class="list-unstyled">
                                    <li> <i class="fa fa-map-marker"></i> Jalan Kaliurang (1 km)</span></li>
                                    <button class="btn btn-success" type="submit">{{ __('labels.Book Now') }}</button>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="item">
                        <div class="post_box">
                            <div class="top">
                                <div class="post_img">
                                    <div class="rating">
                                        <p><i class="fa fa-star"></i> 4.5</p>
                                    </div>
                                    <a href="">
                                        <img src="{{ static_asset('frontend/assets/images/higest_2.png') }}"
                                            class="img-fluid" alt="post">
                                    </a>
                                </div>
                                <div class="post_info">
                                    <h5><a href="">Jonson Barber</a></h5>
                                    <h4 class="shop_name">Alfa Barber shop</h4>
                                </div>
                            </div>

                            <div class="bottom">
                                <ul class="list-unstyled">
                                    <li> <i class="fa fa-map-marker"></i> Jalan Kaliurang (1 km)</span></li>
                                    <button class="btn btn-success" type="submit">{{ __('labels.Book Now') }}</button>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="item">
                        <div class="post_box">
                            <div class="top">
                                <div class="post_img">
                                    <div class="rating">
                                        <p><i class="fa fa-star"></i> 4.5</p>
                                    </div>

                                    <a href="">
                                        <img src="{{ static_asset('frontend/assets/images/higest_3.png') }}"
                                            class="img-fluid" alt="post">
                                    </a>

                                </div>

                                <div class="post_info">
                                    <h5><a href="">Jonson Barber</a></h5>
                                    <h4 class="shop_name">Alfa Barber shop</h4>
                                </div>
                            </div>

                            <div class="bottom">
                                <ul class="list-unstyled">
                                    <li> <i class="fa fa-map-marker"></i> Jalan Kaliurang (1 km)</li>
                                    <button class="btn btn-success" type="submit">{{ __('labels.Book Now') }}</button>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>


    <section class="testimonial_sec pt-75 pb-75"
        style="background: url({{ static_asset('frontend/assets/images/testi_bg.png') }}) no-repeat;background-position: center;background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-12 text-center">
                    <div class="title">
                        <h2>{{ $data->cms_content[3]->$title }}</h2>
                    </div>
                    <p>{{ $data->cms_content[3]->$content }}</p>
                </div>

                <div class="col-sm-12 col-lg-12">
                    <div class="testimonial-slider owl-carousel owl-theme">

                        @foreach ($testimonials as $testimonial)
                            <div class="item">
                                <div class="testimonial_box">
                                    <div class="user">
                                        <div class="user_img">
                                            <img src="{{ static_asset('testimonial_image/' . $testimonial->testimonial_image) }}"
                                                class="img-fluid" alt="user">
                                        </div>
                                    </div>
                                    <p>“{{ $testimonial->$testimonial_content }}” </p>

                                    <div class="user">

                                        <div class="user_info">
                                            <h6 class="name">{{ $testimonial->$name }}</h6>
                                            <p>{{ $testimonial->$designation }}</p>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
