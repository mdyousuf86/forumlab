<!-- header-section start  -->
{{-- <header class="header">
    <div class="header__bottom px-xl-5">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-xl align-items-center p-0">
                <a class="site-logo site-title" href="{{ route('home') }}">
                    <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="logo">
                </a>
                <button class="navbar-toggler ms-auto" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    type="button" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="menu-toggle"></span>
                </button>
                <button class="header-search-open-btn">
                    <i class="las la-search"></i>
                </button>
                <form class="header-search-form header-search-form-mobile" action="{{ route('home') }}">
                    <input class="header-search-form__input text-white" name="search" type="text"
                        value="{{ request()->search }}" placeholder="@lang('Search Here')...">
                    <button class="header-search-form__btn" type="submit"><i class="las la-search"></i></button>
                </form>
                <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
                    <div class="header-search-area ms-auto">
                        <form class="header-search-form" action="{{ route('home') }}">
                            <input class="header-search-form__input text-white" name="search" type="text"
                                value="{{ request()->search }}" placeholder="@lang('Search Post Title')...">
                            <button class="header-search-form__btn" type="submit"><i
                                    class="las la-search"></i></button>
                        </form>
                    </div>

                    <ul class="navbar-nav main-menu ms-auto">
                        <li><a class="{{ menuActive('home') }}" href="{{ route('home') }}">@lang('Home')</a></li>
                        <li><a class="{{ menuActive('all.topic') }}"
                                href="{{ route('all.topic') }}">@lang('All Topic')</a></li>
                        <li><a class="{{ menuActive('contact') }}" href="{{ route('contact') }}">@lang('Contact')</a>
                        </li>
                    </ul>
                    <div class="nav-right d-flex align-items-center">
                        @if ($general->multi_language)
                            <select class="language langSel" name="site-language">
                                @foreach ($language as $item)
                                    <option value="{{ __($item->code) }}"
                                        @if (session('lang') == $item->code) selected @endif>{{ __($item->name) }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                        @auth
                            <a class="btn btn-md btn--gradient" href="{{ route('user.home') }}"><i
                                    class="las la-user fs--18px me-2"></i>@lang('Dashboard')</a>
                        @else
                            <a class="btn btn-md btn--gradient" href="{{ route('user.login') }}"><i
                                    class="las la-user fs--18px me-2"></i>@lang('Login')</a>
                        @endauth
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header> --}}

@php
    $header = getContent('header.content', true);
    $headerContent = $header->data_values;
    $categories = App\Models\Category::get();
@endphp

<header class="header" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logo" href="{{ route('home') }}"><img
                    src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="logo"></a>
            <button class="navbar-toggler header-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span id="hiddenNav"><i class="las la-bars"></i></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-menu ms-auto align-items-lg-center">
                    <li class="nav-item d-flex d-lg-none flex-wrap justify-content-end">
                        @if ($general->multi_language)
                            @php
                                $language = App\Models\Language::all();
                                $selectLang = $language->where('code', config('app.locale'))->first();
                            @endphp
                            <div class="language_switcher">
                                <div class="language_switcher__caption">
                                    <span class="icon"><i class="fli-language"></i></span>
                                    <span class="text"> {{ __(@$selectLang->name) }} </span>
                                </div>
                                <div class="language_switcher__list">
                                    @foreach ($language as $item)
                                        <div class="language_switcher__item    @if (session('lang') == $item->code) selected @endif"
                                            data-value="{{ $item->code }}">
                                            <a href="{{ route('lang', $item->code) }}" class="thumb">
                                                <span class="text"> {{ __($item->name) }}</span>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('home') }}" aria-current="page"
                            href="{{ route('home') }}">@lang('Home')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('all.topic') }}" aria-current="page"
                            href="{{ route('all.topic') }}">@lang('All Topic')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('contact') }}"
                            href="{{ route('contact') }}">@lang('Contact')</a>
                    </li>
                    <li class="nav-item header-access">
                        <div class="language_switcher d-none d-lg-block">
                            @if ($general->multi_language)
                                @php
                                    $language = App\Models\Language::all();
                                    $selectLang = $language->where('code', config('app.locale'))->first();
                                @endphp
                                <div class="language_switcher__caption">
                                    <span class="icon"><i class="fli-language"></i></span>
                                    <span class="text"> {{ __(@$selectLang->name) }} </span>
                                </div>
                                <div class="language_switcher__list">
                                    @foreach ($language as $item)
                                        <div class="language_switcher__item    @if (session('lang') == $item->code) selected @endif"
                                            data-value="{{ $item->code }}">
                                            <a href="{{ route('lang', $item->code) }}" class="thumb">
                                                <span class="text"> {{ __($item->name) }}</span>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        @auth
                            <a href="{{ route('user.home') }}" class="btn btn--base">@lang('Dashboard')</a>
                        @else
                            <a href="{{ route('user.login') }}" class="btn btn--base">@lang('Login Account')</a>
                        @endauth

                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
<section class="banner-section bg-img"
    data-background-image="{{ getImage('assets/images/frontend/header/' . @$headerContent->image, '1920x445') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7">
                <div class="banner-content text-center">
                    <h2 class="banner-content__title">{{__(@$headerContent->title)}}</h2>
                    <form action="{{ route('home') }}" method="#" class="banner-content__search">
                        <div class="form-group mb-0">
                            <input type="text" class="form--control" name="search" value="{{ request()->search }}"
                                placeholder="Search here...">
                            <button type="submit" class="btn btn--base">@lang('Search')</button>
                        </div>
                    </form>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="forum-menu-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="forum-menu-wrapper">
                    <ul class="forum-menu">
                        <li class="forum-menu__item">
                            <div class="category-nav">
                                <button class="category-nav__button categoryButton">@lang('All Category')<span
                                        class="arrow-icon"><i class="fli-sort-down"></i></span></button>
                                <ul class="dropdown--menu categoryArea">
                                    @foreach ($categories as $category)
                                        <li class="dropdown--menu__item">
                                            <a class="dropdown--menu__link"
                                                href="{{ route('category.topic', [slug($category->name), $category->id]) }}">
                                                @php echo $category->icon; @endphp
                                                {{ __($category->name) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="category-nav">
                                <button class="category-nav__button tagButton">@lang('ALL Tags')<span class="arrow-icon"><i
                                            class="fli-sort-down"></i></span></button>
                                <ul class="dropdown--menu tagArea">
                                    <li class="dropdown--menu__item">
                                        <a href="#" class="dropdown--menu__link">Breaking Topic</a>
                                    </li>
                                    <li class="dropdown--menu__item">
                                        <a href="#" class="dropdown--menu__link">Crypto Market</a>
                                    </li>
                                    <li class="dropdown--menu__item">
                                        <a href="#" class="dropdown--menu__link">Web Host</a>
                                    </li>
                                    <li class="dropdown--menu__item">
                                        <a href="#" class="dropdown--menu__link">Java</a>
                                    </li>
                                    <li class="dropdown--menu__item">
                                        <a href="#" class="dropdown--menu__link">Crypto Market</a>
                                    </li>
                                    <li class="dropdown--menu__item">
                                        <a href="#" class="dropdown--menu__link">Application Server</a>
                                    </li>
                                    <li class="dropdown--menu__item">
                                        <a href="#" class="dropdown--menu__link">Wordpress</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="forum-menu__item"><a href="#" class="forum-menu__link">Latest</a></li>
                        <li class="forum-menu__item"><a href="#" class="forum-menu__link">Unread</a></li>
                        <li class="forum-menu__item"><a href="#" class="forum-menu__link">Rising</a></li>
                        <li class="forum-menu__item"><a href="#" class="forum-menu__link">Most Liked</a></li>
                    </ul>
                    <a href="{{route('user.topic.form')}}" class="btn btn--dark">@lang('Create Topic')<i class="fli-plus"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
