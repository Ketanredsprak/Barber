@extends('Frontend.layouts.app')
@section('content')
@php
            $config = getWebsiteConfig();
            $language = config('app.locale');
            $title = 'title_' . $language;
            $content = 'content_' . $language;
            $name = 'page_name_' . $language;
@endphp
    <section class="heading_sec"
        style="background-image: url(images/banner.png);background-position: center;background-repeat: no-repeat;background-size: cover;">
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
                    <div class="contact_info">
                        <ul class="list-unstyled call_to_action">
                            <li> <a href="tel:{{ $config->phone }}"><i class="fa fa-phone" aria-hidden="true"></i> {{ $config->phone }}</a></li>
                            <li> <a href="https://wa.me/{{ $config->whatsapp }}"><i class="fa fa-whatsapp" aria-hidden="true"></i> {{ $config->whatsapp }}</a></li>
                            <li><a href="mailto:{{ $config->email }}"><i class="fa fa-envelope-o" aria-hidden="true"></i> {{ $config->email }}</a></li>
                            <li></li>

                        </ul>

                        <ul class="list-unstyled social_contact">
                            <li> <a href="{{ $config->facebook_link }}" target="_blank"> <i class="fa fa-facebook"></i></a> </li>
                            <li> <a href="{{ $config->twitter_link }}" target="_blank"> <i class="fa fa-twitter"></i></a> </li>
                            <li> <a href="{{ $config->linkedin_link }}" target="_blank"> <i class="fa fa-linkedin"></i></a> </li>
                            <li> <a href="{{ $config->youtube_link }}" target="_blank"> <i class="fa fa-youtube"></i></a> </li>

                        </ul>
                    </div>
                </div>

                <div class="col-md-7 col-lg-8">
                    <div class="title">
                        <h2 class="mb-3">{{ $data->cms_content[1]->$title }}</h2>
                    </div>
                    <div class="contact_box">
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
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="{{ __("labels.Subject") }}" name="subject" id="subject">
                                    </div>
                                    @error('subject')
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

                                <div class="col-sm-12 text-center mt-4">
                                    <button class="btn btn-success" type="submit" id="contactSubmit"><i
                                            class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>
                                </div>
                            </div>
                        </form>
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
