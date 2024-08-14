@extends('Frontend.layouts.app')
@section('content')
    @php
        $language = config('app.locale');
        $title = 'title_' . $language;
        $sub_title = 'sub_title_' . $language;
        $content = 'content_' . $language;
        $testimonial_content = 'testimonial_content_' . $language;
        $name = 'page_name_' . $language;
        $designation = 'designation_' . $language;
        $subject_name = 'name_' . $language;

        // dd($data1);

    @endphp
    <section class="heading_sec"
        style="background-image: url({{ static_asset('frontend/assets/images/banner.png') }});background-position: center;background-repeat: no-repeat;background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="heading_title">
                        <h2>{{ $data1->$name }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about_wrap pt-75 pb-75">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 order-2 order-sm-1">
                    <img src="{{ static_asset('cms_image/' . $data1->cms_content[0]->cms_image) }}" class="img-fluid"
                        alt="about">
                </div>

                <div class="col-sm-6 order-1 order-sm-2">
                    <div class="head">
                        <h3>{{ $data1->cms_content[0]->$title }}</h3>
                    </div>
                    <div class="title">
                        <h2>{{ $data1->cms_content[0]->$sub_title }}</h2>
                    </div>
                    <p>{{ $data1->cms_content[0]->$content }}</p>
                    <button class="btn btn-success" type="submit">{{ __('labels.Book Appointment') }}</button>

                </div>
            </div>
        </div>
    </section>

    <section class="explore_sec pt-75 pb-75 bg-light">
        <div class="container">
            <div class="text-center">
                <div class="title">
                    <h2>{{ $data1->cms_content[1]->$title }}</h2>
                </div>
            </div>

                <form id="contact_form" method="POST" action="{{ route('contact-submit') }}">
                @csrf
                <div id="succuess-message" class="d-none">{{ __('message.Thanks For Contact Us') }}</div>
                <div class="row mt-5">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="{{ __("labels.First Name") }}" name="first_name"
                                id="first_name">
                        </div>
                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="{{ __("labels.Last Name") }}" name="last_name"
                                id="last_name">
                        </div>
                        @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="{{ __("labels.Email") }}" name="email" id="email">
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <select class="form-control @error('subject') is-invalid @enderror"
                                id="subject" name="subject">
                                <option value="">{{ __('labels.Subject') }}</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->$subject_name }}</option>
                                    @endforeach


                            </select>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <textarea class="form-control" type="text"  rows="5" placeholder="{{ __("labels.Note") }}" name="note"
                                id="note"></textarea>
                        </div>
                        @error('note')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                       @enderror
                    </div>


                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="file" class="form-control"  name="contact_file"
                                id="contact_file">
                        </div>
                    </div>

                    <div class="col-sm-12 text-center mt-4">
                        <button class="btn btn-success" type="submit" id="contactSubmit"><i
                                class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>
                    </div>
                </div>
            </form>

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


    <section class="testimonial_sec pt-75 pb-75"
        style="background: url({{ static_asset('frontend/assets/images/testi_bg.png') }}) no-repeat;background-position: center;background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-12 text-center">
                    <div class="title">
                        <h2>{{ $data->cms_content[3]->$title ?? '' }}</h2>
                    </div>
                    <p>{{ $data->cms_content[3]->$content ?? '' }}</p>
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
@section('footer-script')
<script>
    $(document).ready(function() {
        $("#contact_form").submit(function(e) {

            e.preventDefault();

            var form_data = this;
            var formData = new FormData(form_data);
            var url = $(this).attr('action');
            var type = "POST";

            $.ajax({
                type: type,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 1) {
                        $(".error").removeClass('is-invalid');
                        $('#succuess-message').removeClass('d-none');
                        setTimeout(function () {
                            $('#succuess-message').fadeOut('fast');
                        }, 2000);
                        toastr.success(response.message);
                        form_data.reset();
                    } else {
                        toastr.error("Error");
                    }
                },
                error: function(response) {
                    var errors = response.responseJSON;
                    $(".error").removeClass('is-invalid');
                    $.each(errors.errors, function(key, value) {
                        var ele = "#" + key;
                        $(ele).addClass('error is-invalid');
                        toastr.error(value);
                    });
                }
            })
            return false;

        });
    });
</script>
@endsection
