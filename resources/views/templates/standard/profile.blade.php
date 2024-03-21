@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $porfileContent = getContent('profile.content', true);
        $profileContent = $porfileContent->data_values;
    @endphp
    <div class="profile-wrapper">
        <div class="profile-header bg-img"
            data-background-image="{{ getImage('assets/images/frontend/profile/' . @$profileContent->background_image, '1100x220') }}">
            <div class="profile-header__content text-center">
                <span class="thumb">
                    <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')) }}"
                        alt="@lang('image')">
                </span>
                <h4 class="name">{{ __($user->fullname) }}</h4>
                <div class="meta-info">
                    <span class="meta-info__item">
                        <span class="icon"><i class="las la-flag"></i></span>
                        <span class="text">{{ __(@$user->address->country) }}</span>
                    </span>
                    <span class="meta-info__item">
                        <span class="icon"><i class="fli-calendar3"></i></span>
                        <span class="text">@lang('Since'){{ showDateTime(@$user->created_at, 'd M, Y') }}</span>
                    </span>
                </div>
            </div>
        </div>

        @include($activeTemplate . 'partials.profile.navbar')

        <div class="profile-nav-btn d-md-none d-flex">
            <span class="profile-nav-btn__title">
                <span class="text">@lang('Click to expand')</span>
                <span class="icon"><i class="las la-long-arrow-alt-right"></i></span>
            </span>
            <span class="profile-nav-btn__icon"><i class="fas fa-bars"></i></span>
        </div>
    </div>
    <div class="profile-details-wrapper">
        @if (request()->routeIs('profile'))
            @include($activeTemplate . 'partials.profile.about')
        @endif

        @if (request()->routeIs('profile.topics') ||
                request()->routeIs('profile.answered') ||
                request()->routeIs('profile.up.vote') ||
                request()->routeIs('profile.down.vote'))
            @include($activeTemplate . 'partials.topics')
        @endif
    </div>
@endsection
