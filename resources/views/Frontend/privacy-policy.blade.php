@extends('Frontend.layouts.app')
@section('content')
    @php
        $config = getWebsiteConfig();
        $language = config('app.locale');
        $title = 'title_' . $language;
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

    <section class="policy_sec pt-75 pb-75">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="title">{{ $data->cms_content[0]->$title }}</h2>
                    <p>{!! $data->cms_content[0]->$content !!}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
