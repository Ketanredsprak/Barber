@extends('Frontend.layouts.app')
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

    <section class="dashboard_sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-lg-3">
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

                <div class="col-sm-9 col-lg-9">
                    <div class="dashboard_right">
                        <div class="row mb-3 align-items-center">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="heading_dashboard">
                                    <h3>{{ __('labels.Profile') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="whitebox">
                            <form method="POST" action="{{ route('edit-my-account') }}" class="theme-form" id="edit_account_form" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="{{ __('labels.First Name') }}" name="first_name" id="first_name" value="{{ $auth->first_name }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="{{ __('labels.Last Name') }}" name="last_name" id="last_name" value="{{ $auth->last_name }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <select class="form-control" name="gender" id="gender">
                                                <option value="Male" @if($auth->gender == "Male") selected="selected" @endif>{{ __('labels.Male') }}</option>
                                                <option value="Female" @if($auth->gender == "Female") selected="selected" @endif>{{ __('labels.Female') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <select class="form-control" id="exampleFormControlSelect1" name="country_code" id="country_code">
                                                @foreach (country_code() as $country_code)
                                                       <option value="{{ $country_code }}" @if($auth->country_code == $country_code) selected="selected" @endif>+ {{ $country_code }} </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <input type="text" class="form-control" placeholder="{{ __('labels.Phone') }}" @error('phone') is-invalid @enderror name="phone" id="phone" value="{{ $auth->phone }}">
                                        @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                        </div>

                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="{{ __('labels.Email') }}" name="email" id="email" value="{{ $auth->email }}">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-6">
                                        <div class="input-group">
                                            <select class="form-control" id="exampleFormControlSelect1">
                                                <option>Country</option>
                                                <option>1</option>
                                                <option>2</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <select class="form-control" id="exampleFormControlSelect1">
                                                <option>State</option>
                                                <option>1</option>
                                                <option>2</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="City">
                                        </div>
                                    </div> --}}

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>{{ __('labels.Profile Image') }}</label>
                                            <input type="file" class="form-control" name="profile_image" id="profile_image" >
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <button class="btn btn-success" type="submit">{{ __('labels.Update') }}</button>
                                    </div>
                                </div>
                            </form>
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

                          if(response.status == 1)
                          {
                                toastr.success(response.message);
                                form_data.reset();
                                 window.setTimeout(function(){
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
