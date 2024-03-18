<!-- header-section start  -->
<header class="header">
    <div class="header__bottom px-xl-5">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-xl align-items-center p-0">
                <a class="site-logo site-title" href="{{ route('home') }}">
                    <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="logo">
                </a>
                <button class="navbar-toggler ms-auto" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="menu-toggle"></span>
                </button>
                <button class="header-search-open-btn">
                    <i class="las la-search"></i>
                </button>
                <form class="header-search-form header-search-form-mobile" action="{{ route('home') }}">
                    <input class="header-search-form__input text-white" name="search" type="text" value="{{ request()->search }}" placeholder="@lang('Search Here')...">
                    <button class="header-search-form__btn" type="submit"><i class="las la-search"></i></button>
                </form>
                <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
                    <div class="header-search-area ms-auto">
                        <form class="header-search-form" action="{{ route('home') }}">
                            <input class="header-search-form__input text-white" name="search" type="text" value="{{ request()->search }}" placeholder="@lang('Search Post Title')...">
                            <button class="header-search-form__btn" type="submit"><i class="las la-search"></i></button>
                        </form>
                    </div>

                    <ul class="navbar-nav main-menu ms-auto">
                        <li><a class="{{ menuActive('home') }}" href="{{ route('home') }}">@lang('Home')</a></li>
                        <li><a class="{{ menuActive('all.topic') }}" href="{{ route('all.topic') }}">@lang('All Topic')</a></li>
                        <li><a class="{{ menuActive('contact') }}" href="{{ route('contact') }}">@lang('Contact')</a></li>
                    </ul>
                    <div class="nav-right d-flex align-items-center">
                        @if ($general->multi_language)
                            <select class="language langSel" name="site-language">
                                @foreach ($language as $item)
                                    <option value="{{ __($item->code) }}" @if (session('lang') == $item->code) selected @endif>{{ __($item->name) }}</option>
                                @endforeach
                            </select>
                        @endif
                        @auth
                            <a class="btn btn-md btn--gradient" href="{{ route('user.home') }}"><i class="las la-user fs--18px me-2"></i>@lang('Dashboard')</a>
                        @else
                            <a class="btn btn-md btn--gradient" href="{{ route('user.login') }}"><i class="las la-user fs--18px me-2"></i>@lang('Login')</a>
                        @endauth

                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
