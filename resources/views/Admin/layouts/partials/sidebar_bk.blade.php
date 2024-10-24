<style>
    .sidebar-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.chevron-right {
    margin-left: auto; /* This ensures the icon moves to the right */
}
</style>
<div>
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
                    <div class="mobile-back text-end"><span>{{ __('labels.Back') }}</span><i class="fa fa-angle-right ps-2"
                            aria-hidden="true"></i></div>
                </li>


                <li class="sidebar-list">
                    <a class="sidebar-link sidebar-title  link-nav  @if ($url == 'dashboard') badge-light-primary @endif"
                        href="{{ route('dashboard') }}">
                        <i data-feather="home"></i>
                        <span>{{ __('labels.dashboard') }}</span>
                    </a>
                </li>

                @if (auth()->user()->id == 1)
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title  link-nav   @if ($url == 'role.index' || $url == 'role.create' || $url == 'role.edit') badge-light-primary @endif"
                            href="{{ route('role.index') }}">
                            <i data-feather="briefcase"></i>
                            <span>{{ __('labels.Roles') }}</span>
                        </a>
                    </li>
                @endif


                @if (auth()->user()->can('subadmin-list'))
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title  link-nav   @if ($url == 'subadmin.index' || $url == 'subadmin.create' || $url == 'subadmin.edit') badge-light-primary @endif"
                            href="{{ route('subadmin.index') }}">
                            <i data-feather="users"></i>
                            <span>{{ __('labels.Sub Admin') }}</span>
                        </a>
                    </li>
                @endif


                @if (auth()->user()->can('barber-list'))
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title  link-nav   @if ($url == 'barber.index' || $url == 'barber.create' || $url == 'barber.edit' || $url == 'barber.show') badge-light-primary @endif"
                            href="{{ route('barber.index') }}">
                            <i data-feather="users"></i>
                            <span>{{ __('labels.Barbers') }}</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->can('customer-list'))
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title  link-nav   @if ($url == 'customer.index' || $url == 'customer.create' || $url == 'customer.edit' || $url == 'customer.show') badge-light-primary @endif"
                            href="{{ route('customer.index') }}">
                            <i data-feather="users"></i>
                            <span>{{ __('labels.Customers') }}</span>
                        </a>
                    </li>
                @endif


                @if (auth()->user()->can('testimonial-list'))
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title  link-nav @if ($url == 'testimonial.index' || $url == 'testimonial.create' || $url == 'testimonial.edit') badge-light-primary @endif"
                            href="{{ route('testimonial.index') }}">
                            <i data-feather="type"></i>
                            <span>{{ __('labels.Testimonials') }}</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->can('banner-list'))
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title  link-nav @if ($url == 'banner.index' || $url == 'banner.create' || $url == 'banner.edit') badge-light-primary @endif"
                            href="{{ route('banner.index') }}">
                            <i data-feather="image"></i>
                            <span>{{ __('labels.Banners') }}</span>
                        </a>
                    </li>
                @endif


                @if (auth()->user()->can('booking-list'))
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title  link-nav @if ($url == 'booking.index' || $url == 'booking.show') badge-light-primary @endif"
                            href="{{ route('booking.index') }}">
                            <i data-feather="shopping-cart"></i>
                            <span>{{ __('labels.Booking') }}</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->can('subscription-list'))
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title  link-nav  @if ($url == 'subscription.index' || $url == 'subscription.create' || $url == 'subscription.edit') badge-light-primary @endif"
                            href="{{ route('subscription.index') }}">
                            <i data-feather="box"></i>
                            <span>{{ __('labels.Subscriptions') }}</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->can('service-list'))
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title  link-nav  @if ($url == 'service.index' || $url == 'service.create' || $url == 'service.edit') badge-light-primary @endif"
                            href="{{ route('service.index') }}">
                            <i data-feather="scissors"></i>
                            <span>{{ __('labels.Services') }}</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->can('subject-list'))
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title  link-nav  @if ($url == 'subject.index' || $url == 'subject.create' || $url == 'subject.edit') badge-light-primary @endif"
                            href="{{ route('subject.index') }}">
                            <i data-feather="book"></i>
                            <span>{{ __('labels.Subjects') }}</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->can('country-code-list'))
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title  link-nav  @if ($url == 'country-code.index' || $url == 'country-code.create' || $url == 'country-code.edit') badge-light-primary @endif"
                            href="{{ route('country-code.index') }}">
                            <i data-feather="list"></i>
                            <span>{{ __('labels.Countries') }}</span>
                        </a>
                    </li>
                @endif



                @if (auth()->user()->can('page-list'))
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title  link-nav @if ($url == 'page.index' || $url == 'page.create' || $url == 'page.edit') badge-light-primary @endif"
                            href="{{ route('page.index') }}">
                            <i data-feather="monitor"></i>
                            <span>{{ __('labels.Pages') }}</span>
                        </a>
                    </li>
                @endif


                @if (auth()->user()->can('contact-us-list'))
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title  link-nav @if ($url == 'contact-us.index' || $url == 'contact-us.show') badge-light-primary @endif"
                            href="{{ route('contact-us.index') }}">
                            <i data-feather="smartphone"></i>
                            <span>{{ __('labels.Customer Inquirys') }}</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->can('notification-list'))
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title  link-nav @if ($url == 'SystemNotification.index' || $url == 'SystemNotification.create' || $url == 'SystemNotification.edit') badge-light-primary @endif"
                            href="{{ route('SystemNotification.index') }}">
                            <i data-feather="bell"></i>
                            <span>{{ __('labels.Notification') }}</span>
                        </a>
                    </li>
                @endif


                @if (auth()->user()->can('report'))
                <li class="sidebar-list">
                    <a id="dropdownMenuButton1"
                        class="dropdown-toggle sidebar-link sidebar-title d-flex align-items-center justify-content-between @if (request()->routeIs('subadmin.report', 'customer.report', 'barber.report','booking.report')) badge-light-primary @endif"
                        href="javascript:void(0);" data-bs-toggle="dropdown">
                            <span>
                                <i data-feather="file"></i>
                                {{ __('labels.Reports') }}
                            </span>
                            <i class="fa fa-chevron-down chevron-right"></i>
                        </a>
                    <ul class="sidebar-submenu dropdown-menu @if (request()->routeIs('subadmin.report', 'customer.report', 'barber.report','booking.report')) show @endif" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <a href="{{ route('subadmin.report') }}"
                                class="@if (request()->routeIs('subadmin.report')) badge-light-primary @endif">
                                <span>{{ __('labels.Sub Admin Report') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.report') }}"
                                class="@if (request()->routeIs('customer.report')) badge-light-primary @endif">
                                <span>{{ __('labels.Customer Report') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('barber.report') }}"
                                class="@if (request()->routeIs('barber.report')) badge-light-primary @endif">
                               <span>{{ __('labels.Barber Report') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('booking.report') }}"
                                class="@if (request()->routeIs('booking.report')) badge-light-primary @endif">
                                <span>{{ __('labels.Booking Report') }}</span>
                            </a>
                        </li>

                    </ul>
                </li>
                @endif


                @if (auth()->user()->can('website-config-list'))
                <li class="sidebar-list">
                    <a class="sidebar-link sidebar-title  link-nav @if ($url == 'get-website-config') custom_active badge-light-primary @endif"
                        href="{{ route('get-website-config') }}">
                        <i data-feather="settings"></i>
                        <span>{{ __('labels.Website Settings') }}</span>
                    </a>
                </li>
            @endif



            </ul>
            </li>


            </ul>
        </div>
        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
</div>

<script>
    $(document).ready(function() {
        $('.sidebar-link').on('click', function() {
            $(this).toggleClass('active');
            $(this).siblings('.sidebar-submenu').toggle();
        });
    });
</script>
