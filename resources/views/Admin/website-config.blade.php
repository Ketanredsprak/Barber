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
                            enctype="multipart/form-data" id="profile-submit">
                            @csrf

                            <div class="col-5">
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
                            <div class="col-1">
                                <label class="form-label" for="header_logo"></label><br>
                                <img src="{{ static_asset('website-config/' . $data->header_logo) }}" class=""
                                    style="height:30px">
                            </div>


                            <div class="col-5">
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
                            </div>



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
        </div>
    </div>
@endsection
