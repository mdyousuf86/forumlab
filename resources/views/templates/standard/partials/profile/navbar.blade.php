
<div class="profile-nav">
    <span class="profile-nav__close d-md-none d-inline-flex"><i class="fas fa-times"></i></span>
    <ul class="profile-nav__list">
        <li class="profile-nav__item">
            <a href="{{ route('profile', $user->username) }}" class="profile-nav__link @if (request()->routeIs('profile')) active @endif">
                <span class="icon"><i class="fli-user-circle"></i></span>
                <span class="text">@lang('Bio')</span>
            </a>
        </li>
        <li class="profile-nav__item">
            <a href="{{ route('profile.topics', $user->username) }}" class="profile-nav__link @if (request()->routeIs('profile.topics')) active @endif" >
                <span class="icon"><i class="fli-file"></i></span>
                <span class="text">@lang('Topics')</span>
            </a>
        </li>
        <li class="profile-nav__item">
            <a href="{{ route('profile.answered', $user->username) }}" class="profile-nav__link @if (request()->routeIs('profile.answered')) active @endif">
                <span class="icon"><i class="fli-answered"></i></span>
                <span class="text">@lang('Answered')</span>
            </a>
        </li>
        <li class="profile-nav__item">
            <a href="{{ route('profile.up.vote', $user->username) }}" class="profile-nav__link @if (request()->routeIs('profile.up.vote')) active @endif">
                <span class="icon"><i class="fli-arrow-double-up"></i></span>
                <span class="text">@lang('Up Vote')</span>
            </a>
        </li>
        <li class="profile-nav__item">
            <a href="{{ route('profile.down.vote', $user->username) }}" class="profile-nav__link @if (request()->routeIs('profile.down.vote')) active @endif">
                <span class="icon"><i class="fli-arrow-double-down"></i></span>
                <span class="text">@lang('Down Vote')</span>
            </a>
        </li>
    </ul>
</div>
