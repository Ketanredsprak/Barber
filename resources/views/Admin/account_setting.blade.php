@extends('Admin.layouts.app')
@section('content')

<div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-6">
          <h4> {{ __('labels.Account Setting') }}</h4>
        </div>
        <div class="col-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">
                <svg class="stroke-icon">
                  <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                </svg></a></li>
            <li class="breadcrumb-item">{{ __('labels.Account Setting') }}</li>
            <li class="breadcrumb-item active">{{ __('labels.Account Setting') }}</li>
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
          <div class="card-header">
            <h4>{{ __('labels.Edit Profile') }}</h4>
           </div>
          <div class="card-body custom-input">
             <form class="row g-3" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profile-submit">
                @csrf
                @method('patch')

                <div class="col-6">
                    <label class="form-label" for="name">{{ __('labels.Name') }} <span class="text-danger">*</span></label>
                    <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" placeholder="{{ __('labels.Name') }}" aria-label="Name" name="name" value="{{ Auth::user()->name }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

              <div class="col-5">
                <label class="form-label" for="profile_image">{{ __('labels.Profile Image') }} - <span class="text-danger">{{ __('labels.200px * 200px') }}</span> <span class="text-danger">*</span></label>
                <input class="form-control" id="profile_image" type="file" name="profile_image" accept=".png, .jpg, .jpeg">
              </div>
              <div class="col-1">
                <label class="form-label" for="profile_image"></label><br>
                <img src="{{ static_asset('profile_image/' . Auth::user()->profile_image) }}" class="" style="height:30px">
              </div>


             <div class="col-6">
                <label class="form-label" for="email">{{ __('labels.Email Address') }} <span class="text-danger">*</span></label>
                <input class="form-control  @error('email') is-invalid @enderror" id="email" name="email" type="email"  placeholder="{{ __('labels.Email Address') }}" value="{{ Auth::user()->email }}">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
               @enderror
             </div>


              <div class="col-6">
                <label class="form-label" for="phone">{{ __('labels.Phone') }} <span class="text-danger">*</span></label>
                <input class="form-control  @error('phone') is-invalid @enderror" name="phone" id="phone" type="text" placeholder="{{ __('labels.Phone') }}"  value="{{ Auth::user()->phone }}">
                @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
               @enderror
              </div>


            <div class="col-12">
                <input type="submit" class="btn btn-primary" value="{{ __('labels.Submit') }}" id="profileSubmit">
                <a href="{{ route('dashboard') }}" class="btn btn-light">{{ __('labels.Cancel') }} </a>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-xl-12">
        <div class="card height-equal">
          <div class="card-header">
            <h4>{{ __('labels.Change Password') }}</h4>
           </div>
          <div class="card-body custom-input">
             <form class="row g-3" method="post" action="{{ route('store.change.password') }}" id="change-password-submit">
                @csrf

              <div class="col-4">
                <label class="form-label" for="current_password">{{ __('labels.Current Password') }} <span class="text-danger">*</span></label>
                <input class="form-control @error('current_password') is-invalid @enderror" id="current_password" type="password" placeholder="{{ __('labels.Current Password') }}"  aria-label="current_password" name="current_password">
                @error('current_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>


              <div class="col-4">
                <label class="form-label" for="password">{{ __('labels.New Password') }}   <span class="text-danger">*</span></label>
                <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" placeholder="{{ __('labels.New Password') }}"   aria-label="password" name="password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>



              <div class="col-4">
                <label class="form-label" for="password_confirmation">{{ __('labels.Password Confirmation') }} <span class="text-danger">*</span> </label>
                <input class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" type="password" placeholder="{{ __('labels.Password Confirmation') }}" aria-label="password_confirmation" name="password_confirmation">
                @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>




            <div class="col-12">
                <input type="submit" class="btn btn-primary" value="{{ __('labels.Submit') }}" id="change-passwordSubmit">
                <a href="{{ route('dashboard') }}" class="btn btn-light">{{ __('labels.Cancel') }}</a>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection


