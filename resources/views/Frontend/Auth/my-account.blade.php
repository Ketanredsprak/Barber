@extends('Frontend.layouts.app')

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/css/select2.min.css">
@section('content')

@php
        $auth = getauthdata();
        $language = config('app.locale');
        $title = 'title_' . $language;
        $name = 'page_name_' . $language;
        if (empty($auth->profile_image)) {
            $profile_image = 'default.png';
        } else {
            $profile_image = $auth->profile_image;
        }
    @endphp
    <style>
        /* Adjust width and display */
        .dropdown-with-img-wrapper {
            display: flex;
            align-items: center;
        }

        .custom_select2 {
            width: auto !important;
            margin-right: 5px;
        }

        .number-field {
            width: 100%;
        }
    </style>
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

    <section class="dashboard_sec colored-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <div class="profile_sidebar">
                        <div class="sidebar_profile">
                            <img src="{{ static_asset('profile_image/' . $profile_image) }}" class="img-fluid"
                                alt="profsdfzsdfgile">
                            <h3 class="name">{{ $auth->first_name . ' ' . $auth->last_name }}</h3>
                            <hr>

                        </div>

                        <div class="sidebar_nav">
                            @include('Frontend.Auth.sidebar')
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 col-md-8">
                    <div class="dashboard_right">
                        <div class="row mb-3 align-items-center">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="heading_dashboard">
                                    <h3>{{ __('labels.Profile') }}</h3>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('edit-my-account') }}" class="theme-form"
                            id="edit_account_form" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control"
                                            placeholder="{{ __('labels.First Name') }}" name="first_name"
                                            id="first_name" value="{{ $auth->first_name }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control"
                                            placeholder="{{ __('labels.Last Name') }}" name="last_name" id="last_name"
                                            value="{{ $auth->last_name }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <select class="form-control custom-select" name="gender" id="gender">
                                            <option value="Male"
                                                @if ($auth->gender == 'Male') selected="selected" @endif>
                                                {{ __('labels.Male') }}</option>
                                            <option value="Female"
                                                @if ($auth->gender == 'Female') selected="selected" @endif>
                                                {{ __('labels.Female') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 number-field-wrapper">
                                    <div class="input-group mb-3">
                                        <!-- Country Code Dropdown -->
                                        <div class="dropdown-with-img-wrapper">
                                            <select name='country_code' id="country_code"
                                                class="form-control custom_select2">
                                                @foreach (country_code() as $country_code)
                                                    @php
                                                        if (empty($country_code->image)) {
                                                            $image = 'no-image.png';
                                                        } else {
                                                            $image = $country_code->image;
                                                        }
                                                    @endphp
                                                    <option data-src="{{ static_asset('image/' . @$image) }}"
                                                        value="{{ $country_code->phonecode }}"
                                                        {{ $country_code->phonecode == $auth->country_code ? 'selected' : '' }}>
                                                        +{{ $country_code->phonecode }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Phone Input -->
                                        <input class="form-control number-field" id="phone" name="phone"
                                            type="text" pattern="[0-9]*" inputmode="numeric"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                            placeholder="{{ __('labels.Phone Number') }}"
                                            aria-label="{{ __('labels.Phone Number') }}"
                                            maxlength="10" value="{{ $auth->phone }}">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control"
                                            placeholder="{{ __('labels.Email') }}" name="email" id="email"
                                            value="{{ $auth->email }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="file" class="form-control" name="profile_image"
                                            id="profile_image">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <button class="btn btn-light" type="submit">{{ __('labels.Update') }}</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/js/select2.min.js"></script>
    <script>
        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                '<span><img src="' + $(state.element).attr('data-src') + '" class="img-flag" /> ' + state.text +
                '</span>'
            );
            return $state;
        };
        $('.custom_select2').select2({
            minimumResultsForSearch: Infinity,
            templateResult: formatState,
            templateSelection: formatState
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#edit_account_form").submit(function(e) {
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
                                // Move to a new location or you can do something else
                                window.location.href = "{{ route('my-account') }}";
                            }, 500);
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
