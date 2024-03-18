<nav class="profile-nav navbar navbar-expand-md p-0">
    <div class="container">
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#profileNavbar" type="button" aria-controls="profileNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <i class="las la-bars"></i> <span>@lang('Menu')</span>
        </button>
        <div class="collapse navbar-collapse" id="profileNavbar">
            <ul class="profile-menu m-auto">
                <li class="@if (request()->routeIs('profile')) active @endif">
                    <a href="{{ route('profile', $user->username) }}">
                        <i class="las la-user-circle"></i> @lang('Bio')
                    </a>
                </li>
                <li class='@if (request()->routeIs('profile.topics')) active @endif'>
                    <a href="{{ route('profile.topics', $user->username) }}">
                        <i class="las la-clipboard-list"></i> @lang('Topics')
                    </a>
                </li>
                <li class="@if (request()->routeIs('profile.answered')) active @endif">
                    <a href="{{ route('profile.answered', $user->username) }}">
                        <i class="las la-clipboard-check"></i> @lang('Answered')
                    </a>
                </li>
                <li class="@if (request()->routeIs('profile.up.vote')) active @endif">
                    <a href="{{ route('profile.up.vote', $user->username) }}">
                        <i class="las la-arrow-up"></i> @lang('Up Vote')
                    </a>
                </li>
                <li class="@if (request()->routeIs('profile.down.vote')) active @endif">
                    <a href="{{ route('profile.down.vote', $user->username) }}">
                        <i class="las la-arrow-down"></i> @lang('Down Vote')
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
