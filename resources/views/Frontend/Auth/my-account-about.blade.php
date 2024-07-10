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
                      <h3>{{ __('labels.About') }}</h3>
                    </div>
                  </div>
                </div>
                <div class="whitebox">
                  <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsum sapiente et libero autem placeat ex nemo
                    odio! Ipsa tempora quo consectetur tempore, temporibus, ullam quae blanditiis eligendi impedit dicta quam.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsum sapiente et libero autem placeat ex nemo
                    odio! Ipsa tempora quo consectetur tempore, temporibus, ullam quae blanditiis eligendi impedit dicta quam.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit.Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                  </p>

                  <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsum sapiente et libero autem placeat ex nemo
                    odio! Ipsa tempora quo consectetur tempore, temporibus.
                  </p>

                  <h4 class="font-weight-bold">About</h4>
                  <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsum sapiente et libero autem placeat ex nemo
                    odio! Ipsa tempora quo consectetur tempore, temporibus, ullam quae blanditiis eligendi impedit dicta quam.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsum sapiente et libero autem placeat ex nemo
                    odio! Ipsa tempora quo consectetur tempore, temporibus, ullam quae blanditiis eligendi impedit dicta quam.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit.Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit.Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                  </p>
                  <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsum sapiente et libero autem placeat ex nemo
                    odio! Ipsa tempora quo consectetur tempore, temporibus.
                  </p>

                </div>
              </div>
            </div>

          </div>
        </div>
      </section>


@endsection
