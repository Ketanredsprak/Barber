<div>
    <div class="logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                src="{{ static_asset('admin/assets/images/logo/logo.png') }}" alt=""></a>
        <div class="back-btn"><i class="fa fa-angle-left"></i></div>
        <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
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
                    <a class="sidebar-link sidebar-title  link-nav  @if ($url == 'dashboard') badge-light-primary @endif"
                        href="{{ route('dashboard') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-home') }}"></use>
                        </svg><span>{{ __('labels.dashboard') }}</span>
                    </a>
                </li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'customer.index' || $url == 'customer.create' || $url == 'customer.edit') badge-light-primary @endif"
                        href="{{ route('customer.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-user') }}"> </use>
                        </svg><span>{{ __('labels.Customers') }}</span></a></li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'subadmin.index' || $url == 'subadmin.create' || $url == 'subadmin.edit') badge-light-primary @endif"
                        href="{{ route('subadmin.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-user') }}">
                            </use>
                        </svg><span>{{ __('labels.Sub Admin') }}</span></a></li>



                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'permission.index' || $url == 'permission.create' || $url == 'permission.edit') badge-light-primary @endif"
                        href="{{ route('permission.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-user') }}"> </use>
                        </svg><span>{{ __('labels.Permissions') }}</span></a></li>



                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'module.index' || $url == 'module.create' || $url == 'module.edit') badge-light-primary @endif"
                        href="{{ route('module.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-user') }}"> </use>
                        </svg><span>{{ __('labels.Modules') }}</span></a></li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'role.index' || $url == 'role.create' || $url == 'role.edit') badge-light-primary @endif"
                        href="{{ route('role.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-user') }}"> </use>
                        </svg><span>{{ __('labels.Roles') }}</span></a></li>






                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'cms.index' || $url == 'cms.create' || $url == 'cms.edit') badge-light-primary @endif"
                        href="{{ route('cms.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-user') }}"> </use>
                        </svg><span>{{ __('labels.Content Management') }}</span></a></li>

                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'testimonial.index' || $url == 'testimonial.create' || $url == 'testimonial.edit') badge-light-primary @endif"
                        href="{{ route('testimonial.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-user') }}"> </use>
                        </svg><span>{{ __('labels.Testimonials') }}</span></a></li>



               <li class="sidebar-list"><a
                            class="sidebar-link sidebar-title link-nav @if ($url == 'banner.index' || $url == 'banner.create' || $url == 'banner.edit') badge-light-primary @endif"
                            href="{{ route('banner.index') }}">
                            <svg class="stroke-icon">
                                <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-user') }}"> </use>
                            </svg><span>{{ __('labels.Banners') }}</span></a></li>

               <li class="sidebar-list"><a
                            class="sidebar-link sidebar-title link-nav @if ($url == 'service.index' || $url == 'service.create' || $url == 'service.edit') badge-light-primary @endif"
                            href="{{ route('service.index') }}">
                            <svg class="stroke-icon">
                                <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-user') }}"> </use>
                            </svg><span>{{ __('labels.Services') }}</span></a></li>



            <li class="sidebar-list"><a
                class="sidebar-link sidebar-title link-nav @if ($url == 'get-website-config') badge-light-primary @endif"
                href="{{ route('get-website-config') }}">
                <svg class="stroke-icon">
                    <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-user') }}"> </use>
                </svg><span>{{ __('labels.Website Setting') }}</span></a></li>







            </ul>
        </div>
        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
</div>
