<div class="row">
    <div class="col-12">
        <div class="profile-wrapper">
            <div class="profile-header bg-img"
                data-background-image="{{ getImage('assets/images/frontend/dashboard/' . $dashboardContent->data_values->banner_image) }}">
                <div class="profile-header__content text-center">
                    <span class="thumb"><img
                            src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile'), true) }}"
                            alt="@lang('image')" alt=""></span>
                    <h4 class="name">{{ __($user->fullname) }}</h4>
                    <div class="meta-info">
                        <span class="meta-info__item">
                            <span class="icon"><i class="las la-flag"></i></span>
                            <span class="text"> {{ __(@$user->address->country) }}</span>
                        </span>
                        <span class="meta-info__item">
                            <span class="icon"><i class="las la-envelope"></i></span>
                            <span class="text">{{ $user->email }}</span>
                        </span>
                        <span class="meta-info__item">
                            <span class="icon"><i class="las la-phone"></i></span>
                            <span class="text">{{ $user->mobile }}</span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="profile-nav dashboard">
                <span class="profile-nav__close d-md-none d-inline-flex"><i class="fas fa-times"></i></span>
                <ul class="profile-nav__list">
                    <li class="profile-nav__item">
                        <a href="{{ route('user.home') }}"
                            class="profile-nav__link {{ menuActive('user.home') }}">
                            <span class="icon"><i class="fli-user-circle"></i></span>
                            <span class="text">@lang('Dashboard')</span>
                        </a>
                    </li>
                    <li class="profile-nav__item ">
                        <a href="{{ route('user.topic.list') }}" class="profile-nav__link {{ menuActive('user.topic.list') }}">
                            <span class="icon"><i class="fli-file"></i></span>
                            <span class="text">@lang('My Topics')</span>
                        </a>
                    </li>
                    <li class="profile-nav__item ">
                        <a href="{{ route('ticket.index') }}" class="profile-nav__link {{ menuActive('ticket.*') }}">
                            <span class="icon"><i class="fli-tickets"></i></span>
                            <span class="text">@lang('Support Ticket')</span>
                        </a>
                    </li>
                    <li class="profile-nav__item">
                        <a href="{{ route('user.profile.setting') }}" class="profile-nav__link {{ menuActive('user.profile.setting') }}">
                            <span class="icon"><i class="fli-user-setting"></i></span>
                            <span class="text">@lang('Profile Setting')</span>
                        </a>
                    </li>
                    <li class="profile-nav__item ">
                        <a href="{{ route('user.change.password') }}" class="profile-nav__link {{ menuActive('user.change.password') }}">
                            <span class="icon"><i class="fli-key"></i></span>
                            <span class="text">@lang('Change Password')</span>
                        </a>
                    </li>
                    <li class="profile-nav__item">
                        <a href="{{ route('user.topic.form') }}" class="profile-nav__link {{ menuActive('user.topic.form') }}">
                            <span class="icon"><i class="fli-comment-plus"></i></span>
                            <span class="text">@lang('Create Topics')</span>
                        </a>
                    </li>
                    <li class="profile-nav__item">
                        <a href="{{ route('user.logout') }}" class="profile-nav__link">
                            <span class="icon"><i class="fli-logout"></i></span>
                            <span class="text">@lang('Logout')</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="profile-nav-btn d-xl-none d-flex">
                <span class="profile-nav-btn__title">
                    <span class="text">@lang('Click to expand')</span>
                    <span class="icon"><i class="las la-long-arrow-alt-right"></i></span>
                </span>
                <span class="profile-nav-btn__icon"><i class="fas fa-bars"></i></span>
            </div>
        </div>
    </div>
</div>