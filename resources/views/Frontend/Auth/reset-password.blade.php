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
                                    <h2>{{ $data->cms_content[0]->$title }} </h2>
                                    <p>{{ $data->cms_content[0]->$content }}</p>
                                    <form method="POST" action="{{ route('reset-password-submit') }}" class="theme-form"
                                    id="reset_password_login">
                                    @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" name="id" value="{{ $id }}">
                                                    <input type="text" class="form-control  @error('password') is-invalid @enderror" id="password"
                                                        aria-describedby="textHelp" placeholder="{{ __('labels.New Password') }}" name="password">
                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control  @error('confirm_password') is-invalid @enderror" name="confirm_password" id="confirm_password"
                                                        placeholder="{{ __('labels.Confirm Password') }}">
                                                        @error('confirm_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12 text-center">
                                                <button class="btn btn-success btn-block mb-3" type="submit">{{ __('labels.Submit') }}</button>
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
            $("#reset_password_login").submit(function(e) {
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
                            window.setTimeout(function() {
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
