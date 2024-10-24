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
                        <h2>{{ $data->$name }} </h2>
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
                                    <form method="POST" action="{{ route('customer-login') }}" class="theme-form"
                                        id="login_form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <input type="text"
                                                        class="form-control  @error('email_or_phone') is-invalid @enderror"
                                                        id="email_or_phone" aria-describedby="emailHelp"
                                                        placeholder="{{ __('labels.Enter Mobile Number or Email') }}"
                                                        name="email_or_phone" value="{{ old('email_or_phone') }}">
                                                    @error('email_or_phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                {{-- <div class="form-group">
                                                    <input type="password"
                                                        class="form-control  @error('password') is-invalid @enderror"
                                                        placeholder="{{ __('labels.Password') }}" id="password" name="password"  value="{{ old('password') }}">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div> --}}

                                                <div class="form-group position-relative">
                                                    <input type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="{{ __('labels.Password') }}" id="password"
                                                        name="password" value="{{ old('password') }}">
                                                    <span toggle="#password"
                                                        class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>

                                            <div class="col-sm-12 text-center">
                                                <button class="btn btn-light sign-in-btn"
                                                    type="submit">{{ __('labels.Sign In') }}</button>
                                                <a href="{{ route('forgot-password') }}"
                                                    class="text-warning">{{ __('labels.Forgot Password?') }}</a>
                                                <p> {{ __('labels.Don’t have an account?') }} <a
                                                        href="{{ route('register') }}"
                                                        class="text-warning">{{ __('labels.Register') }}</a>
                                                </p>

                                            </div>


                                            <div class="text devider"><span>{{ __('labels.or') }}</span></div>


                                            <div class="col-sm-12 text-center login-btns-wrapper">
                                                <div class="text-center py-3">
                                                    <a href="{{ route('google') }}" target="_blank" class="btn">
                                                        <img src="{{ static_asset('frontend/assets/images/google-icon.png') }}" alt="Gmail-Login">Continue with Google
                                                    </a>
                                                    {{-- <a href="#" target="_blank" class="btn">
                                                        <img src="{{ static_asset('frontend/assets/images/fb-icon.png') }}" alt="FaceBook-Login">
                                                    </a> --}}
                                                    <a href="#" target="_blank" class="btn">
                                                        <img src="{{ static_asset('frontend/assets/images/apple-icon.png') }}" alt="Apple-Login">Continue with Apple
                                                    </a>
                                                </div>
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
            $("#login_form").submit(function(e) {
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
                            toastr.success(response.message);
                            form_data.reset();
                            window.setTimeout(function() {
                                window.location.href = "{{ route('index') }}";
                            }, 1000);
                        }

                        if(response.status == 2)
                        {
                            window.setTimeout(function(){
                                    window.location.href = "{{ route('verify', '') }}" + '/' + response.user_id;
                               }, 1000);
                        }

                        if (response.status == 0) {
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


            $(".toggle-password").click(function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });

        })



    </script>
@endsection
