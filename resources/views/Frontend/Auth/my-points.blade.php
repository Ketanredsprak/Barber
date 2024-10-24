@extends('Frontend.layouts.app')
@section('content')
    @php
        $auth = getauthdata();
        $language = config('app.locale');
        $title = 'title_' . $language;
        $name = 'page_name_' . $language;
        $content = 'content_' . $language;
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
                <div class="col-lg-3 col-md-4">
                    <div class="profile_sidebar">
                        <div class="sidebar_profile">
                            <img src="{{ static_asset('profile_image/' . $profile_image) }}" class="img-fluid" alt="profile">
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
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="heading_dashboard">
                                    <h3>{{ __('labels.Points') }}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="explore_list my-points-wrapper">
                            <div class="whitebox">
                                <div class="points_head">
                                    <div class="point_title">
                                        <h2> {{ $data->total_points }}</h2>
                                        <h3>{{ $data->cms_content[0]->$title }}</h3>
                                        <p>{!! $data->cms_content[0]->$content !!}</p>
                                        <span class='my-points-img-wrapper'><img src="{{ static_asset('frontend/assets/images/points-img.png') }}" class="img-fluid"></span>
                                    </div>                                                                            
                                </div>

                                {{-- <div class="points_list">
                                    <div class="info">
                                        <div class="points_head">
                                            <h6>Learn & Earn</h6>
                                            <div class="claimed mb-2">
                                                <span>100 Points</span>
                                            </div>
                                        </div>

                                        <p>Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat,
                                            velit mauris
                                            egestas quam, ut aliquam massa nisl quis neque.</p>
                                        <div class="points_head2">
                                            <div class="claim mb-2">
                                                <button class="btn btn-success" type="submit">Claim</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="points_list">
                                    <div class="info">
                                        <div class="points_head">
                                            <h6>Learn & Earn</h6>
                                            <div class="claimed mb-2">
                                                <span>100 Points</span>
                                            </div>
                                        </div>
                                        <p>Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat,
                                            velit mauris
                                            egestas quam, ut aliquam massa nisl quis neque.</p>
                                        <div class="points_head2">
                                            <div class="claimed mb-2">
                                                <button class="btn btn-secondary btn-lg" type="submit">Claimed</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
