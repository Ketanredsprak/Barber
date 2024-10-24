@extends('Frontend.layouts.app')

@section('content')

@php

            $config = getWebsiteConfig();

            $language = config('app.locale');

            $title = 'title_' . $language;

            $content = 'content_' . $language;

            $name = 'page_name_' . $language;

            $subject_name = 'name_' . $language;



@endphp

    <section class="heading_sec"

        style="background-image: url({{ static_asset('frontend/assets/images/banner.png') }});background-position: center;background-repeat: no-repeat;background-size: cover;">

        <div class="container">

            <div class="row">

                <div class="col-sm-12 text-center">

                    <div class="heading_title">

                        <h2>{{ $data->$name }}</h2>

                    </div>

                </div>

            </div>

        </div>

    </section>



    <section class="contact_sec pt-75 pb-75">

        <div class="container">

            <div class="row">

                <div class="col-md-5 col-lg-4">

                    <div class="title">
                        <h2 class="mb-3">{{ $data->cms_content[0]->$title }}</h2>
                    </div>

                    <div class="contact_info content-box-wrapper">

                        <ul class="list-unstyled call_to_action">

                            <li> <a href="tel:{{ $config->phone }}"><i class="fa fa-phone" aria-hidden="true"></i> {{ $config->phone }}</a></li>

                            <li> <a href="https://wa.me/{{ $config->whatsapp }}"><i class="fa fa-whatsapp" aria-hidden="true"></i> {{ $config->whatsapp }}</a></li>

                            <li><a href="mailto:{{ $config->email }}"><i class="fa fa-envelope-o" aria-hidden="true"></i> {{ $config->email }}</a></li>

                            <li></li>



                        </ul>



                        <ul class="list-unstyled social_contact">

                            <li> <a href="{{ $config->tiktok_link }}" target="_blank"> <i class="fa fa-tiktok"></i></a> </li>

                            <li> <a href="{{ $config->twitter_link }}" target="_blank"> <i class="fa fa-twitter"></i></a> </li>

                            <li> <a href="{{ $config->linkedin_link }}" target="_blank"> <i class="fa fa-linkedin"></i></a> </li>

                            <li> <a href="{{ $config->youtube_link }}" target="_blank"> <i class="fa fa-youtube"></i></a> </li>



                        </ul>

                    </div>

                </div>

                <div class="col-md-7 col-lg-8">

                    <div class="title mt-4 mt-md-0">

                        <h2 class="mb-3">{{ $data->cms_content[1]->$title }}</h2>

                    </div>

                    <div class="content-box-wrapper">

                        <form id="contact_form" method="POST" action="{{ route('contact-submit') }}">

                            @csrf

                            <div id="succuess-message" class="d-none">{{ __('message.Thanks For Contact Us') }}</div>

                            <div class="form-wrapper">
                                <div class="row">

                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="{{ __("labels.First Name") }}" name="first_name" id="first_name" value="{{ Auth::user()->first_name ?? "" }}">

                                        </div>

                                        @error('first_name')

                                            <span class="invalid-feedback" role="alert">

                                                <strong>{{ $message }}</strong>

                                            </span>

                                        @enderror

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="{{ __("labels.Last Name") }}" name="last_name"

                                                id="last_name" value="{{ Auth::user()->last_name ?? "" }}">

                                        </div>

                                        @error('last_name')

                                            <span class="invalid-feedback" role="alert">

                                                <strong>{{ $message }}</strong>

                                            </span>

                                        @enderror

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="{{ __("labels.Email") }}" name="email" id="email" value="{{ Auth::user()->email ?? "" }}">

                                        </div>

                                        @error('email')

                                            <span class="invalid-feedback" role="alert">

                                                <strong>{{ $message }}</strong>

                                            </span>

                                        @enderror

                                    </div>



                                    <div class="col-lg-6">

                                                <select class="form-control custom-select @error('subject') is-invalid @enderror"

                                                        id="subject" name="subject">

                                                        <option value="">{{ __('labels.Subject') }}</option>

                                                        @foreach ($subjects as $subject)

                                                        <option value="{{ $subject->id }}">{{ $subject->$subject_name }}</option>

                                                        @endforeach





                                                </select>

                                        </div>



                                    <div class="col-sm-12">

                                        <div class="form-group">

                                            <textarea class="form-control" type="text"  rows="5" placeholder="{{ __("labels.Description") }}" name="note"

                                                id="note"></textarea>

                                        </div>

                                        @error('note')

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>

                                    @enderror

                                    </div>



                                    <div class="col-lg-6">

                                        <div class="form-group">

                                            <input type="file" class="form-control"  name="contact_file"

                                                id="contact_file">

                                        </div>

                                    </div>



                                    <div class="col-sm-12 text-right mt-4">

                                        <button class="btn btn-warning" type="submit" id="contactSubmit"><i

                                                class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Send') }}</button>

                                    </div>

                                </div>
                            </div>
                        </form>

                    </div>

                </div>

                <div class="col-12">
                    <div class="map-wrapper">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d463877.31242950493!2d46.49288193599672!3d24.725455372447055!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x3e2f03890d489399%3A0xba974d1c98e79fd5!2sRiyadh%20Saudi%20Arabia!3m2!1d24.7135517!2d46.6752957!5e0!3m2!1sen!2sin!4v1727681295084!5m2!1sen!2sin" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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

                            $('#succuess-message').removeClass('d-none');

                            $(".error").removeClass('is-invalid');

                            setTimeout(function() {

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

