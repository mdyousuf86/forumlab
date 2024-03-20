<aside class="aside-list aside-col">
    <span class="aside-list__close d-xl-none d-inline-flex"><i class="las la-times"></i></span>
    <div class="sidebar-widget categories">
        <h5 class="sidebar-widget__title">@lang('Categories')</h5>
        <ul class="category-list">
            @forelse ($categories as $category)
                <li
                    class="category-list__item {{ request()->url() === route('category.topic', [slug($category->name), $category->id]) ? 'active' : '' }}">
                    <span class="icon">@php echo $category->icon; @endphp</span>
                    <a class="category-list__link"
                        href="{{ route('category.topic', [slug($category->name), $category->id]) }}">
                        {{ __($category->name) }}
                    </a>
                </li>
            @empty
                <li class="category-list__item">
                    <p><i class="las la-frown"></i> {{ __($emptyMessage) }}</p>
                </li>
            @endforelse
        </ul>
    </div>

    @php echo showAdvertisement(); @endphp


    <span class="aside-list__close d-xl-none d-inline-flex"><i class="las la-times"></i></span>
    <div class="sidebar-widget categories mt-4">
        <h5 class="sidebar-widget__title">@lang('Forum')</h5>
        <ul class="category-list">
            @forelse ($forums as $forum)
                <li
                    class=" category-list__item {{ request()->url() === route('forums', [slug($forum->name), $forum->id]) ? 'active' : '' }}">
                    <span class="icon">@php echo $forum->icon; @endphp</span>
                    <a class="category-list__link" href="{{ route('forums', [slug($forum->name), $forum->id]) }}">
                        {{ __($forum->name) }}
                    </a>
                </li>
            @empty
                <li class="single-discussion">
                    <p><i class="las la-frown"></i> {{ __($emptyMessage) }}</p>
                </li>
            @endforelse
        </ul>
    </div>

    <div class="sidebar-widget">
        <div class="sidebar-widget__header">
            <h5 class="sidebar-widget__title">@lang('Discussion Now')</h5>
        </div>
        <div class="sidebar-widget__body">
            <ul class="sidebar-widget__list">
                @forelse (@$discussions as $discussion)
                    <li class="sidebar-widget__list-item">
                        <a class="sidebar-widget__list-link"
                            href="{{ route('topic.detail', [slug($discussion->title), $discussion->id]) }}">
                            {{ __($discussion->title) }}
                        </a>
                        <span class="sidebar-widget__list-meta_info">
                            <i class="las la-comments fs--14px"></i>
                            {{ $discussion->comment }} @lang('answered')
                        </span>
                    </li>
                @empty
                    <li class="sidebar-widget__list-item">
                        <p><i class="las la-frown"></i> {{ __($emptyMessage) }}</p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    @php echo showAdvertisement(); @endphp

    <div class="right-enable d-none">
        <div class="sidebar-widget">
            <ul class="statistics-list">
                <li class="statistics-list__item">
                    <span class="statistics-list__number">{{ @$forumCount }}</span>
                    <span class="statistics-list__caption">@lang('Forum')</span>
                </li>
                <li class="statistics-list__item">
                    <span class="statistics-list__number">{{ @$categoryCount }}</span>
                    <span class="statistics-list__caption">@lang('Category')</span>
                </li>
                <li class="statistics-list__item">
                    <span class="statistics-list__number">{{ @$subCategoryCount }}</span>
                    <span class="statistics-list__caption">@lang('Subcategory')</span>
                </li>
                <li class="statistics-list__item">
                    <span class="statistics-list__number">{{ @$topicCount }}</span>
                    <span class="statistics-list__caption">@lang('Topic')</span>
                </li>
            </ul>
        </div>
        <div class="sidebar-widget two tc">
            <div class="sidebar-widget__header">
                <h5 class="sidebar-widget__title">@lang('Top Contributors')</h5>
            </div>
            <div class="sidebar-widget__body">
                <ul class="sidebar-widget__list">
                    @forelse ($topContributors as $top)
                        <li class="sidebar-widget__list-item">
                            <span class="sidebar-widget__list-thumb"><a
                                    href="{{ route('profile', @$top->user->username) }}"><img
                                        src="{{ getImage(getFilePath('userProfile') . '/' . @$top->user->image, getFileSize('userProfile')) }}"
                                        alt=""></a>
                            </span>
                            <div class="sidebar-widget__list-content">
                                <a href="{{ route('profile', @$top->user->username) }}"
                                    class="sidebar-widget__list-link">{{ __(@$top->user->fullname) }}</a>
                                <span class="sidebar-widget__list-meta_info"><i class="fli-comments"></i>
                                    {{ @$top->total }}</span>
                            </div>
                        </li>
                    @empty
                        <li class="sidebar-widget__list-item">
                            <p><i class="las la-frown"></i> {{ __($emptyMessage) }}</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="sidebar-widget two">
            <div class="sidebar-widget__header">
                <h5 class="sidebar-widget__title">@lang('Hot Topics')</h5>
            </div>
            <div class="sidebar-widget__body">
                <ul class="sidebar-widget__list">
                    @forelse ($hots as $hot)
                        <li class="sidebar-widget__list-item">
                            <span class="sidebar-widget__list-thumb"> <a
                                    href="{{ route('profile', @$hot->topic->user->username) }}"> <img
                                        src="{{ getImage(getFilePath('userProfile') . '/' . @$hot->topic->user->image, getFileSize('userProfile')) }}"
                                        alt="@lang('image')"> </a>
                            </span>
                            <div class="sidebar-widget__list-content">
                                <a href="{{ route('topic.detail', [slug(@$hot->topic->title), @$hot->topic->id]) }}"
                                    class="sidebar-widget__list-link">{{ __(@$hot->topic->title) }}</a>
                                <span class="sidebar-widget__list-meta_info"><i class="fli-calendar2"></i>
                                    {{ showDateTime(@$hot->topic->cretaed_at, 'd M, Y') }}</span>
                            </div>
                        </li>
                    @empty
                        <li class="sidebar-widget__list-item">
                            <p><i class="las la-frown"></i> {{ __($emptyMessage) }}</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</aside>
