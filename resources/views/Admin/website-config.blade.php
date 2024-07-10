@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4> {{ __('labels.Website Setting') }}</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">{{ __('labels.Website Setting') }}</li>
                        <li class="breadcrumb-item active">{{ __('labels.Website Setting') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card height-equal">
                    <div class="card-body custom-input">
                        <form class="row g-3" method="post" action="{{ route('website-config-update') }}"
                            enctype="multipart/form-data" id="website_config_submit">
                            @csrf

                            <div class="col-10">
                                <label class="form-label" for="header_logo">{{ __('labels.Header Logo') }} <span
                                        class="text-danger">*</span> </label>
                                <input class="form-control @error('header_logo') is-invalid @enderror" id="header_logo"
                                    type="file" aria-label="header_logo" name="header_logo" accept=".png, .jpg, .jpeg">
                                @error('header_logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-2">
                                <label class="form-label" for="header_logo"></label><br>
                                <img src="{{ static_asset('website-config/' . $data->header_logo) }}" class=""
                                    style="height:30px">
                            </div>


                            {{-- <div class="col-5">
                                <label class="form-label" for="footer_logo">{{ __('labels.Footer Logo') }} <span
                                        class="text-danger">*</span> </label>
                                <input class="form-control @error('footer_logo') is-invalid @enderror" id="footer_logo"
                                    type="file" aria-label="footer_logo" name="footer_logo" accept=".png, .jpg, .jpeg">
                                @error('footer_logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-1">
                                <label class="form-label" for="footer_logo"></label><br>
                                <img src="{{ static_asset('website-config/' . $data->footer_logo) }}" class=""
                                    style="height:30px">
                            </div> --}}



                            <div class="col-6">
                                <label class="form-label" for="location_en">{{ __('labels.Location English') }} <span
                                        class="text-danger">*</span> </label>
                                <input class="form-control @error('location_en') is-invalid @enderror" id="location_en"
                                    type="text" aria-label="location_en" name="location_en"
                                    value="{{ $data->location_en }}">
                                @error('location_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-6">
                                <label class="form-label" for="location_ar">{{ __('labels.Location Arabic') }} <span
                                        class="text-danger">*</span> </label>
                                <input class="form-control @error('location_ar') is-invalid @enderror" id="location_ar"
                                    type="text" aria-label="location_ar" name="location_ar"
                                    value="{{ $data->location_ar }}">
                                @error('location_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-6">
                                <label class="form-label" for="location_ur">{{ __('labels.Location Urdu') }} <span
                                        class="text-danger">*</span> </label>
                                <input class="form-control @error('location_ur') is-invalid @enderror" id="location_ur"
                                    type="text" aria-label="location_ur" name="location_ur"
                                    value="{{ $data->location_ur }}">
                                @error('location_ur')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label class="form-label" for="location_tr">{{ __('labels.Location Turkish') }} <span
                                        class="text-danger">*</span> </label>
                                <input class="form-control @error('location_tr') is-invalid @enderror" id="location_tr"
                                    type="text" aria-label="location_tr" name="location_tr"
                                    value="{{ $data->location_tr }}">
                                @error('location_tr')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label class="form-label" for="phone">{{ __('labels.Phone') }} <span
                                        class="text-danger">*</span> </label>
                                <input class="form-control @error('phone') is-invalid @enderror" id="phone"
                                    type="text" aria-label="phone" name="phone" value="{{ $data->phone }}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-6">
                                <label class="form-label" for="whatsapp">{{ __('labels.Whatsapp') }} <span
                                        class="text-danger">*</span> </label>
                                <input class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp"
                                    type="text" aria-label="whatsapp" name="whatsapp" value="{{ $data->whatsapp }}">
                                @error('whatsapp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-6">
                                <label class="form-label" for="email">{{ __('labels.Email') }} <span
                                        class="text-danger">*</span> </label>
                                <input class="form-control @error('email') is-invalid @enderror" id="email"
                                    type="text" aria-label="email" name="email" value="{{ $data->email }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-6">
                                <label class="form-label" for="facebook_link">{{ __('labels.Facebook Link') }} <span
                                        class="text-danger">*</span> </label>
                                <input class="form-control @error('facebook_link') is-invalid @enderror"
                                    id="facebook_link" type="text" aria-label="facebook_link" name="facebook_link"
                                    value="{{ $data->facebook_link }}">
                                @error('facebook_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-6">
                                <label class="form-label" for="twitter_link">{{ __('labels.Twitter Link') }} <span
                                        class="text-danger">*</span> </label>
                                <input class="form-control @error('twitter_link') is-invalid @enderror" id="twitter_link"
                                    type="text" aria-label="twitter_link" name="twitter_link"
                                    value="{{ $data->twitter_link }}">
                                @error('twitter_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-6">
                                <label class="form-label" for="linkedin_link">{{ __('labels.Linkedin Link') }} <span
                                        class="text-danger">*</span> </label>
                                <input class="form-control @error('linkedin_link') is-invalid @enderror"
                                    id="linkedin_link" type="text" aria-label="linkedin_link" name="linkedin_link"
                                    value="{{ $data->linkedin_link }}">
                                @error('linkedin_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label class="form-label" for="youtube_link">{{ __('labels.Youtube Link') }} <span
                                        class="text-danger">*</span> </label>
                                <input class="form-control @error('youtube_link') is-invalid @enderror" id="youtube_link"
                                    type="text" aria-label="youtube_link" name="youtube_link"
                                    value="{{ $data->youtube_link }}">
                                @error('youtube_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <input type="submit" class="btn btn-primary" value="{{ __('labels.Submit') }}"
                                    id="websiteConfigSubmit">
                                <a href="{{ route('dashboard') }}" class="btn btn-light">{{ __('labels.Cancel') }} </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('labels.Point System') }}</h4>
                    </div>
                    <div class="card-body custom-input">
                        <form class="row g-3" method="post" action="{{ route('point-system-update') }}"
                            id="point-sytem-submit">
                            @csrf

                            <div class="col-4">
                                <label class="form-label" for="per_booking_points">{{ __('labels.Per Booking Points') }}
                                    <span class="text-danger">*</span></label>
                                <input class="form-control @error('per_booking_points') is-invalid @enderror"
                                    id="per_booking_points" type="text"
                                    placeholder="{{ __('labels.Per Booking Points') }}" aria-label="per_booking_points"
                                    name="per_booking_points" value="{{ $pointSystem->per_booking_points }}">
                                @error('per_booking_points')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-4">
                                <label class="form-label"
                                    for="per_active_referral_points">{{ __('labels.Per Active Referral Points') }} <span
                                        class="text-danger">*</span></label>
                                <input class="form-control @error('per_active_referral_points') is-invalid @enderror"
                                    id="per_active_referral_points" type="text"
                                    placeholder="{{ __('labels.Per Active Referral Points') }}"
                                    aria-label="per_active_referral_points" name="per_active_referral_points" value="{{ $pointSystem->per_active_referral_points }}">
                                @error('per_active_referral_points')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>



                            <div class="col-4">
                                <label class="form-label"
                                    for="how_many_point_equal_sr">{{ __('labels.How Many Point Equal 1 SR') }} <span
                                        class="text-danger">*</span> </label>
                                <input class="form-control @error('how_many_point_equal_sr') is-invalid @enderror"
                                    id="how_many_point_equal_sr" type="text"
                                    placeholder="{{ __('labels.How Many Point Equal 1 SR') }}"
                                    aria-label="how_many_point_equal_sr" name="how_many_point_equal_sr" value="{{ $pointSystem->how_many_point_equal_sr }}">
                                @error('how_many_point_equal_sr')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>




                            <div class="col-12">
                                <input type="submit" class="btn btn-primary" value="{{ __('labels.Submit') }}"
                                    id="point-system-update-submit">
                                <a href="{{ route('dashboard') }}" class="btn btn-light">{{ __('labels.Cancel') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            ///website config update
            $("#website_config_submit").submit(function(e) {
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
                            $(".is-invalid").removeClass('is-invalid');
                            location.reload();
                            show_toster(response.message)
                            form_data.reset();
                        }
                    },
                    error: function(response) {
                        var errors = response.responseJSON;
                        $(".is-invalid").removeClass('is-invalid');
                        $.each(errors.errors, function(key, value) {
                            var ele = "#" + key;
                            $(ele).addClass('is-invalid');
                            toastr.error(value);
                        });
                    }
                })
                return false;

            });
            ///website config update

            // Website point system  update
            $("#point-sytem-submit").submit(function(e) {
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
                            $(".is-invalid").removeClass('is-invalid');
                            location.reload();
                            show_toster(response.message)
                            form_data.reset();
                        }
                    },
                    error: function(response) {
                        var errors = response.responseJSON;
                        $(".is-invalid").removeClass('is-invalid');
                        $.each(errors.errors, function(key, value) {
                            var ele = "#" + key;
                            $(ele).addClass('is-invalid');
                            toastr.error(value);
                        });
                    }
                })
                return false;

            });
            // Website point system  update
        });
    </script>
@endsection
