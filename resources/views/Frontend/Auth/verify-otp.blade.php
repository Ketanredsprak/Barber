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
                                    <form method="POST" action="{{ route('verify-otp-submit') }}" class="theme-form"
                                        id="otp_verify_form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="d-flex flex-row mb-4">
                                                    <input type="hidden" class="form-controls" name="email" id="email" value="{{ $email }}"/>
                                                    <input type="hidden" class="form-controls" name="user_id" id="user_id" value="{{ $id }}"/>
                                                    {{-- <input type="text" class="form-controls" autofocus="" name="otp[0]" id="otp" value="" maxlength="1"/>
                                                    <input type="text" class="form-controls" name="otp[1]" id="otp" value="" maxlength="1"/>
                                                    <input type="text" class="form-controls" name="otp[2]" id="otp" value="" maxlength="1"/>
                                                    <input type="text" class="form-controls" name="otp[3]" id="otp" value="" maxlength="1"/> --}}


                                                    <input class="form-controls" id="phone" name="otp[0]" type="text" pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                     aria-label="{{ __('labels.Phone') }}" maxlength="1">
                                                    <input class="form-controls" id="phone" name="otp[1]" type="text" pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                     aria-label="{{ __('labels.Phone') }}" maxlength="1">
                                                    <input class="form-controls" id="phone" name="otp[2]" type="text" pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                     aria-label="{{ __('labels.Phone') }}" maxlength="1">
                                                    <input class="form-controls" id="phone" name="otp[3]" type="text" pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                     aria-label="{{ __('labels.Phone') }}" maxlength="1">
                                                </div>

                                            </div>

                                            <div class="col-sm-12 text-center">
                                                <button class="btn btn-success btn-block mb-3"
                                                    type="submit">{{ __('labels.Submit') }}</button>
                                                <a href="javascript:void(0)" class="text-warning" id="resend_otp_forgot_password">{{ __('labels.Have not receive code?') }}</a>
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
            $("#otp_verify_form").submit(function(e) {
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
                        if (response.status == 1) {
                            toastr.success(response.message);
                            window.setTimeout(function() {
                                window.location.href = "{{ route('reset-password', '') }}" +
                                    '/' + response.userId;
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
        })



        $(document).ready(function() {
    $('#resend_otp_forgot_password').click(function() {
        var url = "{{ route('otp-resend-forgot-password') }}"; // Replace with the route to resend OTP
        var email = $("#email").val(); // Get the email from the hidden input
        var $this = $(this);

        // Disable the link
        $this.prop('disabled', true);
        $this.css('pointer-events', 'none'); // Disable click events
        $this.text("{{ __('labels.Please wait for resend otp') }}"); // Change the text to indicate waiting

        // Send the AJAX request
        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                email: email
            },
            success: function(response) {
                if (response.status == 1) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(response) {
                toastr.error("{{ __('error.Something went wrong, please try again later.') }}");
            }
        });

        // Re-enable the link after 1 minute
        setTimeout(function() {
            $this.prop('disabled', false);
            $this.css('pointer-events', 'auto'); // Re-enable click events
            $this.text("{{ __('labels.Have not receive code?') }}"); // Restore original text
        }, 60000); // 60000 milliseconds = 1 minute
    });
});

    </script>
@endsection
