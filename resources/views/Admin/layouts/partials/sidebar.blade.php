<div>
    <style>
        .custom_active {
            background-color: #cac5ff;
            color: #ffffff;
        }

        /* Basic styles for the sidebar */
.sidebar-list {
    position: relative;
}

.sidebar-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: inherit;
    padding: 10px;
    cursor: pointer;
}

.sidebar-link .fa-chevron-down {
    margin-left: auto;
    transition: transform 0.3s ease;
}

/* Hide submenu by default */
.sidebar-submenu {
    display: none;
    list-style: none;
    padding: 0;
    margin: 0;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
}

/* Show submenu when the parent item is hovered */
.sidebar-list:hover .sidebar-submenu {
    display: block;
}

/* Rotate chevron when the submenu is visible */
.sidebar-list:hover .fa-chevron-down {
    transform: rotate(180deg);
}

/* Submenu item styling */
.sidebar-submenu li {
    padding: 10px;
}

.sidebar-submenu a {
    text-decoration: none;
    color: #333;
    display: block;
}

/* Active state styling for the link */
.custom_active {
    font-weight: bold;
    color: #007bff; /* Customize this color as needed */
}

    </style>

    <div class="logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                src="{{ static_asset('admin/assets/images/logo/logo.png') }}" alt=""></a>
        <div class="back-btn"><i class="fa fa-angle-left"></i></div>
        <div class="toggle-sidebar"></div>
    </div>
    <div class="logo-icon-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid"
                src="{{ static_asset('admin/assets/images/logo/logo-icon.png') }}" alt=""></a></div>
    <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
        <div id="sidebar-menu">
            <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"><a href="{{ route('dashboard') }}"></a>
                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                            aria-hidden="true"></i></div>
                </li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'dashboard') custom_active badge-light-primary @endif"
                        href="{{ route('dashboard') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-home') }}"></use>
                        </svg><span>{{ __('labels.dashboard') }}</span></a></li>



                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'subadmin.index' || $url == 'subadmin.create' || $url == 'subadmin.edit') custom_active badge-light-primary @endif"
                        href="{{ route('subadmin.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-user') }}"> </use>
                        </svg><span>{{ __('labels.Sub Admin') }}</span></a></li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'barber.index' || $url == 'barber.create' || $url == 'barber.edit' || $url == 'barber.show') custom_active badge-light-primary @endif"
                        href="{{ route('barber.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-user') }}">
                            </use>
                        </svg><span>{{ __('labels.Barbers') }}</span></a></li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'customer.index' || $url == 'customer.create' || $url == 'customer.edit' || $url == 'customer.show') custom_active badge-light-primary @endif"
                        href="{{ route('customer.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-user') }}">
                            </use>
                        </svg><span>{{ __('labels.Customers') }}</span></a></li>



                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'testimonial.index' || $url == 'testimonial.create' || $url == 'testimonial.edit') custom_active badge-light-primary @endif"
                        href="{{ route('testimonial.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-user') }}">
                            </use>
                        </svg><span>{{ __('labels.Testimonials') }}</span></a></li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'banner.index' || $url == 'banner.create' || $url == 'banner.edit') custom_active badge-light-primary @endif"
                        href="{{ route('banner.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-blog') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-blog') }}"> </use>
                        </svg><span>{{ __('labels.Banners') }}</span></a></li>



                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'booking.index' || $url == 'booking.create' || $url == 'booking.edit') custom_active badge-light-primary @endif"
                        href="{{ route('booking.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-blog') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-blog') }}"> </use>
                        </svg><span>{{ __('labels.Booking') }}</span></a></li>



                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'subscription.index' || $url == 'subscription.create' || $url == 'subscription.edit') custom_active badge-light-primary @endif"
                        href="{{ route('subscription.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-landing-page') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-landing-page') }}">
                            </use>
                        </svg><span>{{ __('labels.Subscriptions') }}</span></a></li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'service.index' || $url == 'service.create' || $url == 'service.edit') custom_active badge-light-primary @endif"
                        href="{{ route('service.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-calendar') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-calendar') }}">
                            </use>
                        </svg><span>{{ __('labels.Services') }}</span></a></li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'subject.index' || $url == 'subject.create' || $url == 'subject.edit') custom_active badge-light-primary @endif"
                        href="{{ route('subject.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-calendar') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-calendar') }}">
                            </use>
                        </svg><span>{{ __('labels.Subjects') }}</span></a></li>




                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'get-website-config') custom_active badge-light-primary @endif"
                        href="{{ route('get-website-config') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-editors') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-editors') }}">
                            </use>
                        </svg><span>{{ __('labels.Website Settings') }}</span></a></li>

                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'page.index' || $url == 'page.create' || $url == 'page.edit') custom_active badge-light-primary @endif"
                        href="{{ route('page.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-editors') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-editors') }}">
                            </use>
                        </svg><span>{{ __('labels.Pages') }}</span></a></li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'contact-us.index' || $url == 'contact-us.show') custom_active badge-light-primary @endif"
                        href="{{ route('contact-us.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-editors') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-editors') }}">
                            </use>
                        </svg><span>{{ __('labels.Contact Us') }}</span></a></li>



                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'role.index' || $url == 'role.create' || $url == 'role.edit') custom_active badge-light-primary @endif"
                        href="{{ route('role.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-blog') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-blog') }}"> </use>
                        </svg><span>{{ __('labels.Roles and Permissions') }}</span></a></li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'SystemNotification.index' || $url == 'SystemNotification.create' || $url == 'SystemNotification.edit') custom_active badge-light-primary @endif"
                        href="{{ route('SystemNotification.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-blog') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-blog') }}"> </use>
                        </svg><span>{{ __('labels.Notification') }}</span></a></li>

                <!-- <li class="sidebar-list">
                    <a class="sidebar-link sidebar-title  link-nav  @if (Route::is('report.index')) badge-light-primary @endif"
                        href="{{ route('report.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-knowledgebase') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-home') }}"></use>
                        </svg>
                        <span>{{ __('labels.Report') }}</span>
                    </a>
                </li> -->

                <!-- <li class="sidebar-list">
                    <a class="sidebar-link sidebar-title @if (request()->routeIs('subadmin.report', 'customer.report')) custom_active @endif"
                        href="javascript:void(0);" onclick="toggleSubMenu(event, 'reportsDropdown')">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-landing-page') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-landing-page') }}"></use>
                        </svg>
                        <span>Reports</span>
                        <i class="fa fa-chevron-down"></i>
                    </a>
                    <ul class="sidebar-submenu" id="reportsDropdown">
                        <li>
                            <a href="{{ route('subadmin.report') }}"
                                class="@if (request()->routeIs('subadmin.report')) custom_active @endif">Sub Admin
                                Report</a>
                        </li>

                        <li>
                            <a href="{{ route('customer.report') }}"
                                class="@if (request()->routeIs('customer.report')) custom_active @endif">Customer
                                Report</a>
                        </li>

                        <li>
                            <a href="{{ route('barber.report') }}"
                                class="@if (request()->routeIs('barber.report')) custom_active @endif">Barber
                                Report</a>
                        </li>
                    </ul>
                </li> -->

                <li class="sidebar-list">
    <a class="sidebar-link sidebar-title @if (request()->routeIs('subadmin.report', 'customer.report', 'barber.report')) custom_active @endif"
       href="javascript:void(0);">
        <svg class="stroke-icon">
            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-landing-page') }}"></use>
        </svg>
        <svg class="fill-icon">
            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-landing-page') }}"></use>
        </svg>
        <span>{{ __('labels.Reports') }}</span>
        <i class="fa fa-chevron-down"></i>
    </a>
    <ul class="sidebar-submenu">
        <li>
            <a href="{{ route('subadmin.report') }}" class="@if (request()->routeIs('subadmin.report')) custom_active @endif">
                {{ __('labels.Sub Admin Report') }}   
            </a>
        </li>
        <li>
            <a href="{{ route('customer.report') }}" class="@if (request()->routeIs('customer.report')) custom_active @endif">
                {{ __('labels.Customer Report') }}    
            </a>
        </li>
        <li>
            <a href="{{ route('barber.report') }}" class="@if (request()->routeIs('barber.report')) custom_active @endif">
                {{ __('labels.Barber Report') }}   
            </a>
        </li>
        <li>
            <a href="{{ route('booking.report') }}" class="@if (request()->routeIs('booking.report')) custom_active @endif">
                {{ __('labels.Booking Report') }}    
            </a>
        </li>
        <li>
            <a href="{{ route('revenue.report') }}" class="@if (request()->routeIs('revenue.report')) custom_active @endif">
                {{ __('labels.Revenue Report') }}    
            </a>
        </li>
    </ul>
</li>


            </ul>
            </li>


            </ul>
        </div>
        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
</div>

<script>
    $(document).ready(function () {
        $('.sidebar-link').on('click', function () {
            $(this).toggleClass('active');
            $(this).siblings('.sidebar-submenu').toggle();
        });
    });
</script>