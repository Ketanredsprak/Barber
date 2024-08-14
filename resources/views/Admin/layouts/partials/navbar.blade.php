<?php
  $locale = config('app.locale');
?>
<div class="header-wrapper row m-0">
    <form class="form-inline search-full col" action="#" method="get">
      <div class="form-group w-100">
        <div class="Typeahead Typeahead--twitterUsers">
          <div class="u-posRelative">
            <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search Cuba .." name="q" title="" autofocus>
            <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span></div><i class="close-search" data-feather="x"></i>
          </div>
          <div class="Typeahead-menu"></div>
        </div>
      </div>
    </form>

    <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
      <ul class="nav-menus">
         <li class="language-nav">
          <div class="translate_wrapper">
            <div class="current_lang">
              <div class="lang">
               @if($locale == "ar") <i class="flag-icon flag-icon-ae"></i> @else <i class="flag-icon flag-icon-us"></i> @endif <span class="lang-txt">{{ $locale }} </span></div>
            </div>
            <div class="more_lang">
              <div class="lang selected" data-value="EN" onclick="change_lang('en');"><i class="flag-icon flag-icon-us"></i><span class="lang-txt" >English<span> (US)</span></span></div>
              <div class="lang" data-value="AR" onclick="change_lang('ar');"><i class="flag-icon flag-icon-ae"></i><span class="lang-txt" onclick="change_lang('ar');">لعربية <span> (AR)</span></span></div>
            </div>
          </div>
        </li>
        <li class="profile-nav onhover-dropdown pe-0 py-0">
          <div class="media profile-media"><img class="b-r-10" style="height:35px;" src="{{ static_asset('profile_image/' . Auth::user()->profile_image) }}" alt="">
            <div class="media-body"><span>{{  Auth::user()->first_name }}  {{  Auth::user()->last_name }}</span>
              <p class="mb-0">Admin <i class="middle fa fa-angle-down"></i></p>
            </div>
          </div>
          <ul class="profile-dropdown onhover-show-div">
            <li><a href="{{ route('setting') }}"><i data-feather="user"></i><span>{{ __('labels.Profile') }}</span></a></li>
            <li><a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"><i data-feather="log-in"> </i><span>{{ __('labels.Logout') }}</span></a></li>
               <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                </form></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
