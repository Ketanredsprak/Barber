@extends('Frontend.layouts.app')
@section('content')
@php
$auth = getauthdata();
$language = config('app.locale');
$title = 'title_' . $language;
$name = 'page_name_' . $language;
$subscription_name = 'subscription_name_' . $language;
$subscription_detail = 'subscription_detail_' . $language;
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
                    <h2>Chat Module</h2>
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
                        <h3 class="name">demo user</h3>
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
                  <h3>Chat</h3>
                </div>
              </div>
            </div>
            <div class="whitebox">
              <div class="row no-gutters">
                <div class="col-md-4 border-right">

                  <div class="search-box">
                    <div class="input-wrapper">
                      <input placeholder="Search chat" type="text">
                    </div>
                  </div>
                  <div class="friend-drawer friend-drawer--onhover">
                    <img class="profile-image" src="{{ static_asset('frontend/assets/images/user4.png') }}" alt="">
                    <div class="text">
                      <h6>Robo Cop</h6>
                      <p class="text-muted">Hey, you're arrested!</p>
                    </div>
                    <span class="time text-muted small">13:21</span>
                  </div>
                  <hr>
                  <div class="friend-drawer friend-drawer--onhover">
                    <img class="profile-image" src="{{ static_asset('frontend/assets/images/user4.png') }}" alt="">
                    <div class="text">
                      <h6>Optimus</h6>
                      <p class="text-muted">Wanna grab a beer?</p>
                    </div>
                    <span class="time text-muted small">00:32</span>
                  </div>
                  <hr>
                  <div class="friend-drawer friend-drawer--onhover ">
                    <img class="profile-image" src="{{ static_asset('frontend/assets/images/user4.png') }}" alt="">
                    <div class="text">
                      <h6>Skynet</h6>
                      <p class="text-muted">Im studying spanish...</p>
                    </div>
                    <span class="time text-muted small">13:21</span>
                  </div>
                  <hr>
                  <div class="friend-drawer friend-drawer--onhover">
                    <img class="profile-image" src="{{ static_asset('frontend/assets/images/profile-user-img.png') }}" alt="">
                    <div class="text">
                      <h6>Termy</h6>
                      <p class="text-muted">Im studying spanish...</p>
                    </div>
                    <span class="time text-muted small">13:21</span>
                  </div>
                  <hr>
                  <div class="friend-drawer friend-drawer--onhover">
                    <img class="profile-image" src="{{ static_asset('frontend/assets/images/user4.png') }}" alt="">
                    <div class="text">
                      <h6>Richard</h6>
                      <p class="text-muted">Im studying spanish...</p>
                    </div>
                    <span class="time text-muted small">13:21</span>
                  </div>
                  <hr>
                  <div class="friend-drawer friend-drawer--onhover">
                    <img class="profile-image" src="{{ static_asset('frontend/assets/images/user4.png') }}" alt="">
                    <div class="text">
                      <h6>Richard</h6>
                      <p class="text-muted">Im studying spanish...</p>
                    </div>
                    <span class="time text-muted small">13:21</span>
                  </div>
                  <hr>

                </div>
                <div class="col-md-8">
                  <div class="settings-tray">
                    <div class="friend-drawer no-gutters friend-drawer--grey">
                      <img class="profile-image" src="{{ static_asset('frontend/assets/images/booked-profile.png') }}" alt="">
                      <div class="text">
                        <h6>John</h6>
                        <p class="text-muted">Layin' down the law since like before Christ...</p>
                      </div>

                    </div>

                  </div>
                  <hr>
                  <div class="chat-panel">
                    <div class="row no-gutters">
                      <div class="col-md-6">
                        <div class="chat-bubble chat-bubble--left">
                          Good morning, I want to order
                        </div>
                      </div>
                    </div>
                    <div class="row no-gutters">
                      <div class="col-md-4 offset-md-9">
                        <div class="chat-bubble chat-bubble--right">
                          Hello dude!
                        </div>
                      </div>
                    </div>
                    <div class="row no-gutters">
                      <div class="col-md-4 offset-md-9">
                        <div class="chat-bubble chat-bubble--right">
                          Hello dude!
                        </div>
                      </div>
                    </div>
                    <div class="row no-gutters">
                      <div class="col-md-4">
                        <div class="chat-bubble chat-bubble--left">
                          Hello dude!
                        </div>
                      </div>
                    </div>
                    <div class="row no-gutters">
                      <div class="col-md-4">
                        <div class="chat-bubble chat-bubble--left">
                          Hello dude!
                        </div>
                      </div>
                    </div>
                    <div class="row no-gutters">
                      <div class="col-md-4">
                        <div class="chat-bubble chat-bubble--left">
                          Hello dude!
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-12">
                        <div class="chat-box-tray">
                          <input type="text" placeholder="Type your message here...">

                          <i class="send-btn">
                            <a href="#"><img src="{{ static_asset('frontend/assets/images/icon-send.png')}}"></a>
                          </i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        </div>
    </div>
</section>


@endsection