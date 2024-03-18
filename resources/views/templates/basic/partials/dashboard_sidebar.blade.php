@php
    $user = authUser();
@endphp
<div class="user-sidebar">
    <button class="btn-close sidebar-close d-xl-none shadow-none"><i class="las la-times"></i></button>
    <div class="user-widget">
        <div class="thumb text-center">
            <img class="w-100 profilePicPreview" src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile'), true) }}" alt="@lang('image')">
            <h6 class="name text-white">{{ __($user->fullname) }}</h6>
        </div>
        <ul class="user-info-list mt-3 text-white">
            <li>
                <i class="las la-map-marked-alt"></i>
                <p>
                    {{ __(@$user->address->country) }}
                </p>
            </li>
            <li>
                <i class="las la-envelope"></i>
                <p>{{ $user->email }}</p>
            </li>
            <li>
                <i class="las la-phone"></i>
                <p>{{ $user->mobile }}</p>
            </li>
        </ul>
    </div>
    <div class="user-menu-widget" id="navLink">
        <ul class="user-menu">
            <li class="{{ menuActive('user.home') }}">
                <a href="{{ route('user.home') }}"><i class="las la-layer-group"></i> <span>@lang('Dashboard')</span></a>
            </li>
            <li class="{{ menuActive('user.topic.*') }}">
                <a href="{{ route('user.topic.list') }}"><i class="lab la-forumbee"></i> <span>@lang('My Topics')</span></a>
            </li>
            <li class="{{ menuActive('ticket.*') }}">
                <a href="{{ route('ticket.index') }}"><i class="las la-ticket-alt"></i> <span>@lang('Support Ticket')</span></a>
            </li>
            <li class="{{ menuActive('user.profile.setting') }}">
                <a href="{{ route('user.profile.setting') }}"><i class="las la-user"></i> <span>@lang('Profile Setting')</span></a>
            </li>
            <li class="{{ menuActive('user.change.password') }}">
                <a href="{{ route('user.change.password') }}"><i class="las la-key"></i> <span>@lang('Change Password')</span></a>
            </li>
            <li>
                <a href="{{ route('user.logout') }}"><i class="las la-sign-out-alt"></i> <span>@lang('Logout')</span></a>
            </li>
        </ul>
    </div>
</div>
