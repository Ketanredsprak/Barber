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
                            <div class="register_form">
                                <h2>{{ $data->$name }}</h2>
                                <form method="POST" action="{{ route('register-submit') }}" class="theme-form"
                                    id="register_login">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text"
                                                    class="form-control @error('first_name') is-invalid @enderror"
                                                    placeholder="{{ __('labels.First Name') }}" name="first_name"
                                                    id="first_name" value="{{ old('first_name') }}">
                                                @error('first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text"
                                                    class="form-control @error('last_name') is-invalid @enderror"
                                                    placeholder="{{ __('labels.Last Name') }}" name="last_name"
                                                    id="last_name" value="{{ old('last_name') }}">
                                                @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="input-group">
                                                <select class="form-control @error('gender') is-invalid @enderror"
                                                    id="gender" name="gender">
                                                    <option value="">{{ __('labels.Select Gender') }}</option>
                                                    <option value="Male">{{ __('labels.Male') }}</option>
                                                    <option value="Female">{{ __('labels.Female') }}</option>
                                                </select>

                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <select class="form-control" id="country_code" name="country_code"
                                                        id="country_code">
                                                        @foreach (country_code() as $country_code)
                                                            <option value="{{ $country_code }}">+ {{ $country_code }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                  <input class="form-control" id="phone" name="phone" type="text" pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                    placeholder="{{ __('labels.Phone Number') }}" aria-label="{{ __('labels.Phone Number') }}" value="{{ old('phone') }}">
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input type="text"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    placeholder="{{ __('labels.Email') }}" id="email" name="email"
                                                    value="{{ old('email') }}">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="{{ __('labels.Password') }}" id="password"
                                                    name="password" value="{{ old('password') }}">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="password"
                                                    class="form-control @error('confirm_password') is-invalid @enderror"
                                                    placeholder="{{ __('labels.Confirm Password') }}" id="confirm_password"
                                                    name="confirm_password" value="{{ old('confirm_password') }}">
                                                @error('confirm_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="tacbox">
                                            <label><input type="checkbox" name="terms_and_conditions"
                                                    id="terms_and_conditions"
                                                    @if (old('terms_and_conditions') == 'on') checked @endif />
                                                {{ __('labels.I have read and agreed to the') }}<a
                                                    href="{{ route('terms-and-condition') }}">
                                                    {{ __('labels.Terms and Conditions') }}</a></label>
                                            @error('terms_and_conditions')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>

                                        <div class="col-sm-12 text-center">
                                            <button class="btn btn-success btn-block mb-3"
                                                type="submit">{{ __('labels.Sign Up') }}</button>

                                        </div>

                                        <div class="text">{{ __('labels.or') }} </div>



                                        <div class="col-sm-12 text-center">
                                            <div class="text-center py-3">
                                                <a href="#" target="_blank" class="px-2"> <img
                                                        src="{{ static_asset('frontend/assets/images/gmail-icon.png') }}"
                                                        alt="Gmail-Login"> </a>
                                                <a href="#" target="_blank" class="px-2"> <img
                                                        src="{{ static_asset('frontend/assets/images/fb-icon.png') }}"
                                                        alt="FaceBook-Login"> </a>
                                                <a href="#" target="_blank" class="px-2"> <img
                                                        src="{{ static_asset('frontend/assets/images/apple-icon.png') }}"
                                                        alt="Apple-Login"> </a>
                                            </div>

                                            <p>{{ __('labels.Already have an account?') }}<a href="{{ route('login') }}"
                                                    class="text-warning"> {{ __('labels.login') }} </a></p>
                                        </div>





                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function() {
            $(window).resize(function() {
                $('.line').width(($(window).width() - $('.text').width() * 2) / 3 - 8);
            });
            $('.line').width(($(window).width() - $('.text').width() * 2) / 3 - 8);


            $("#register_login").submit(function(e) {
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
                        toastr.success(response.message);
                        form_data.reset();


                        if (response.status == 1) {
                            $(".error").removeClass('is-invalid');
                            window.setTimeout(function() {
                                // Move to a new location or you can do something else
                                window.location.href = "{{ route('login') }}";
                            }, 1000);
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
