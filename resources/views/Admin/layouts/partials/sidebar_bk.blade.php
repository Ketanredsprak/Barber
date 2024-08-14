<div>
    <style>
        .custom_icon {
            font-size: 19px;
            /* Adjust the size here */
        }

        .custom_active {
            background-color: #cac5ff;
            color: #ffffff;
            border-radius: 5px 0px 0px 5px;

        }
    </style>
    <div class="logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                src="{{ static_asset('admin/assets/images/logo/logo.png') }}" alt=""></a>
        <div class="back-btn"><i class="fa fa-angle-left"></i></div>
        {{-- <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div> --}}
    </div>
    <div class="logo-icon-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid"
                src="{{ static_asset('admin/assets/images/logo/logo-icon.png') }}" alt=""></a></div>
    <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
        <div id="sidebar-menu">
            <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"><a href="{{ route('dashboard') }}"></a>
                    <div class="mobile-back text-end"><span></span><i class="fa fa-angle-right ps-2"
                            aria-hidden="true"></i></div>
                </li>

                <li class="sidebar-list">
                    <a class="sidebar-link sidebar-title  link-nav  @if ($url == 'dashboard') badge-light-primary custom_active @endif"
                        href="{{ route('dashboard') }}">
                        <div class="col-sm-6 col-md-6 col-lg-6"> <i class="icofont custom_icon icofont-dashboard-web"
                                style=""></i>&nbsp;&nbsp;{{ __('labels.dashboard') }}</div>
                    </a>
                </li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'subadmin.index' || $url == 'subadmin.create' || $url == 'subadmin.edit') badge-light-primary custom_active @endif"
                        href="{{ route('subadmin.index') }}">

                        <div class="col-sm-6 col-md-6 col-lg-6"> <i
                                class="icofont custom_icon icofont-business-man-alt-2"></i>&nbsp;&nbsp;{{ __('labels.Sub Admin') }}
                        </div>
                    </a></li>



                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'barber.index' || $url == 'barber.create' || $url == 'barber.edit' || $url == 'barber.show') badge-light-primary custom_active @endif"
                        href="{{ route('barber.index') }}">

                        <div class="col-sm-6 col-md-6 col-lg-6"> <i
                                class="icofont custom_icon icofont-man-in-glasses"></i>&nbsp;&nbsp;{{ __('labels.Barbers') }}
                        </div>
                    </a></li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'customer.index' || $url == 'customer.create' || $url == 'customer.edit' || $url == 'customer.show') badge-light-primary custom_active @endif"
                        href="{{ route('customer.index') }}">
                        <div class="col-sm-6 col-md-6 col-lg-6"> <i
                                class="icofont custom_icon icofont-users"></i>&nbsp;&nbsp;{{ __('labels.Customers') }}
                        </div>
                    </a></li>




                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'permission.index' || $url == 'permission.create' || $url == 'permission.edit') badge-light-primary custom_active @endif"
                        href="{{ route('permission.index') }}">
                        <div class="col-sm-6 col-md-6 col-lg-6"> <i
                                class="icofont custom_icon icofont-ui-lock"></i>&nbsp;&nbsp;{{ __('labels.Permissions') }}
                        </div>
                    </a></li>



                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'module.index' || $url == 'module.create' || $url == 'module.edit') badge-light-primary custom_active @endif"
                        href="{{ route('module.index') }}">
                        <div class="col-sm-6 col-md-6 col-lg-6"> <i
                                class="icofont custom_icon icofont-ui-note"></i>&nbsp;&nbsp;{{ __('labels.Modules') }}
                        </div>
                    </a></li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'role.index' || $url == 'role.create' || $url == 'role.edit') badge-light-primary custom_active @endif"
                        href="{{ route('role.index') }}">
                        <div class="col-sm-6 col-md-6 col-lg-6"> <i
                                class="icofont custom_icon icofont-tools-alt-2"></i>&nbsp;&nbsp;{{ __('labels.Roles') }}
                        </div>
                    </a></li>

                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'testimonial.index' || $url == 'testimonial.create' || $url == 'testimonial.edit') badge-light-primary custom_active @endif"
                        href="{{ route('testimonial.index') }}">
                        <div class="col-sm-6 col-md-6 col-lg-6"> <i
                                class="icofont custom_icon  icofont-comment"></i>&nbsp;&nbsp;{{ __('labels.Testimonials') }}
                        </div>
                    </a></li>



                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'banner.index' || $url == 'banner.create' || $url == 'banner.edit') badge-light-primary custom_active @endif"
                        href="{{ route('banner.index') }}">
                        <div class="col-sm-6 col-md-6 col-lg-6"> <i
                                class="icofont custom_icon icofont-image"></i>&nbsp;&nbsp;{{ __('labels.Banners') }}
                        </div>
                    </a></li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'service.index' || $url == 'service.create' || $url == 'service.edit') badge-light-primary custom_active @endif"
                        href="{{ route('service.index') }}">
                        <div class="col-sm-6 col-md-6 col-lg-6"> <i
                                class="icofont custom_icon  icofont-bullhorn"></i>&nbsp;&nbsp;{{ __('labels.Services') }}
                        </div>
                    </a></li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'get-website-config') badge-light-primary custom_active @endif"
                        href="{{ route('get-website-config') }}">
                        <div class="col-sm-12 col-md-12 col-lg-12"> <i
                                class="icofont custom_icon icofont-web"></i>&nbsp;&nbsp;{{ __('labels.Website Settings') }}
                        </div>
                    </a></li>



                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'page.index' || $url == 'page.create' || $url == 'page.edit') custom_active badge-light-primary custom_active @endif"
                        href="{{ route('page.index') }}">
                        <div class="col-sm-6 col-md-6 col-lg-6"> <i
                                class="icofont custom_icon  icofont-papers"></i>&nbsp;&nbsp;{{ __('labels.Pages') }}
                        </div>
                    </a></li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'contact-us.index') custom_active  badge-light-primary custom_active @endif"
                        href="{{ route('contact-us.index') }}">

                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <i class="icofont custom_icon icofont-ui-contact-list"></i>
                            &nbsp;&nbsp;{{ __('labels.Contact Us') }}
                        </div>
                    </a></li>

            </ul>
        </div>
        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
</div>
