@extends('Frontend.layouts.app')
@section('content')
@php
    $language = config('app.locale');
    $title = 'title_' . $language;
    $sub_title = 'sub_title_' . $language;
    $content = 'content_' . $language;
    $name = 'page_name_' . $language;
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

    <section class="explore_sec pt-75 pb-75" style="background-color: #EFF3FF;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="login_box">
                        <div class="row">
                            <div class="col-md-8 col-lg-5 mx-auto">
                                <div class="login_form">
                                    <h2>{{ $data->cms_content[0]->$title }}</h2>
                                    <p>{{ $data->cms_content[0]->$content }}</p>
                                    <form method="POST" action="{{ route('forgot-password-submit') }}" class="theme-form" id="forgot_password_form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1"
                                                        aria-describedby="emailHelp" placeholder="{{ __('labels.Email') }}" name="email">
                                                        @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12 text-center">
                                                <button class="btn btn-light sign-in-btn" type="submit">{{ __('labels.Send OTP') }}</button>
                                                <a href="{{ route('login') }}" class="text-warning">{{ __('labels.Back to Login') }}</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer-script')
    <script>
        $(document).ready(function() {



            $("#forgot_password_form").submit(function(e) {
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

                          form_data.reset();
                          if(response.status == 1)
                          {
                            toastr.success(response.message);
                                window.setTimeout(function(){
                                    window.location.href = "{{ route('verify-otp', '') }}" + '/' + response.userId;
                               }, 1000);
                          }
                          else{
                            toastr.error(response.message);
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
        })
    </script>
@endsection

