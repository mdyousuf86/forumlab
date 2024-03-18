{{-- <aside class="xxxl-2 col-lg-3 d-lg-block d-none">
    <div class="sidebar-widget">
        <div class="sidebar-widget__header">
            <h5 class="sidebar-widget__title">@lang('Forum')</h5>
        </div>
        <div class="sidebar-widget__body">
            <ul class="category-list">

                @forelse ($forums as $forum)
                    <li
                        class="{{ request()->url() === route('forums', [slug($forum->name), $forum->id]) ? 'active' : '' }}">
                        <a href="{{ route('forums', [slug($forum->name), $forum->id]) }}">
                            @php echo $forum->icon; @endphp
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
    </div>
    <div class="sidebar-widget mt-4">
        <div class="sidebar-widget__header">
            <h5 class="sidebar-widget__title">@lang('Categories')</h5>
        </div>
        <div class="sidebar-widget__body">
            <ul class="category-list">
                @forelse ($categories as $category)
                    <li
                        class="{{ request()->url() === route('category.topic', [slug($category->name), $category->id]) ? 'active' : '' }}">
                        <a href="{{ route('category.topic', [slug($category->name), $category->id]) }}">
                            @php echo $category->icon; @endphp
                            {{ __($category->name) }}
                        </a>
                    </li>
                @empty
                    <li class="single-discussion">
                        <p><i class="las la-frown"></i> {{ __($emptyMessage) }}</p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    @php echo showAdvertisement(); @endphp

    <div class="sidebar-widget mt-4">
        <div class="sidebar-widget__header">
            <h5 class="sidebar-widget__title">@lang('Disscussion Now')</h5>
        </div>
        <div class="sidebar-widget__body">
            <ul class="discussion-list">
                @forelse (@$discussions as $discussion)
                    <li class="single-discussion">
                        <h6 class="single-discussion__title">
                            <a href="{{ route('topic.detail', [slug($discussion->title), $discussion->id]) }}">
                                {{ __($discussion->title) }}
                            </a>
                        </h6>
                        <span class="fs--12px">
                            <i class="las la-comments fs--14px"></i>
                            {{ $discussion->comment }} @lang('answered')
                        </span>
                    </li>
                @empty
                    <li class="single-discussion">
                        <p><i class="las la-frown"></i> {{ __($emptyMessage) }}</p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    @php echo showAdvertisement(); @endphp

</aside> --}}
@php
    $leftSideBar = getContent('left_side_bar.content', true);
    $leftSideBarContent = $leftSideBar->data_values;
@endphp
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
    {{-- <div class="sidebar-widget advertisement">
        <a href="#" class="advertisement-link">
            <img src="{{ getImage('assets/images/frontend/left_side_bar/' . $leftSideBarContent->image_one, '220x460') }}"
                alt="">
        </a>
    </div> --}}
    @php echo showAdvertisement(); @endphp
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
    {{-- <div class="sidebar-widget advertisement">
        <a href="#" class="advertisement-link">
            <img src="{{ getImage('assets/images/frontend/left_side_bar/' . $leftSideBarContent->image_two, '220x460') }}"
                alt="">
        </a>
    </div> --}}
    @php echo showAdvertisement(); @endphp
    {{-- <div class="sidebar-widget advertisement">
        <a href="#" class="advertisement-link">
            <img src="{{ getImage('assets/images/frontend/left_side_bar/' . $leftSideBarContent->image_three, '220x460') }}"
                alt="">
        </a>
    </div> --}}
    @php echo showAdvertisement(); @endphp
    <div class="right-enable d-none">
        <div class="sidebar-widget">
            <ul class="statistics-list">
                <li class="statistics-list__item">
                    <span class="statistics-list__number">{{ @$forum }}</span>
                    <span class="statistics-list__caption">@lang('Forum')</span>
                </li>
                {{-- <li class="statistics-list__item">
                    <span class="statistics-list__number">{{ @$category }}</span>
                    <span class="statistics-list__caption">@lang('Category')</span>
                </li> --}}
                <li class="statistics-list__item">
                    <span class="statistics-list__number">{{ @$subCategory }}</span>
                    <span class="statistics-list__caption">@lang('Subcategory')</span>
                </li>
                <li class="statistics-list__item">
                    <span class="statistics-list__number">{{ @$topic }}</span>
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
                    {{-- @forelse ($topContributors as $top)
                        <li class="sidebar-widget__list-item">
                            <span class="sidebar-widget__list-thumb"> <a
                                    href="{{ route('profile', @$top->user->username) }}">
                                    <img src="{{ getImage(getFilePath('userProfile') . '/' . @$top->user->image, getFileSize('userProfile')) }}"
                                        alt="@lang('image')"></a>
                            </span>
                            <div class="sidebar-widget__list-content">
                                <a href="{{ route('profile', @$top->user->username) }}">
                                    {{ __(@$top->user->fullname) }}
                                </a>
                                <span class="sidebar-widget__list-meta_info"><i class="fli-comments"></i> {{ @$top->total }}</span>
                            </div>
                        </li>
                    @empty
                        <li class="sidebar-widget__list-item">
                            <p><i class="las la-frown"></i> {{ __($emptyMessage) }}</p>
                        </li>
                    @endforelse --}}

                    <li class="sidebar-widget__list-item">
                        <span class="sidebar-widget__list-thumb"><img src="assets/images/thumbs/tc-01.png"
                                alt=""></span>
                        <div class="sidebar-widget__list-content">
                            <a href="javascript:void(0)" class="sidebar-widget__list-link">Bfa Chats</a>
                            <span class="sidebar-widget__list-meta_info"><i class="fli-comments"></i> 05</span>
                        </div>
                    </li>
                    <li class="sidebar-widget__list-item">
                        <span class="sidebar-widget__list-thumb"><img src="assets/images/thumbs/tc-02.png"
                                alt=""></span>
                        <div class="sidebar-widget__list-content">
                            <a href="javascript:void(0)" class="sidebar-widget__list-link">Tomato Lab</a>
                            <span class="sidebar-widget__list-meta_info"><i class="fli-comments"></i> 07</span>
                        </div>
                    </li>
                    <li class="sidebar-widget__list-item">
                        <span class="sidebar-widget__list-thumb"><img src="assets/images/thumbs/tc-03.png"
                                alt=""></span>
                        <div class="sidebar-widget__list-content">
                            <a href="javascript:void(0)" class="sidebar-widget__list-link">Martin Tomas</a>
                            <span class="sidebar-widget__list-meta_info"><i class="fli-comments"></i> 12</span>
                        </div>
                    </li>
                    <li class="sidebar-widget__list-item">
                        <span class="sidebar-widget__list-thumb"><img src="assets/images/thumbs/tc-04.png"
                                alt=""></span>
                        <div class="sidebar-widget__list-content">
                            <a href="javascript:void(0)" class="sidebar-widget__list-link">Rayhon Tech</a>
                            <span class="sidebar-widget__list-meta_info"><i class="fli-comments"></i> 08</span>
                        </div>
                    </li>
                    <li class="sidebar-widget__list-item">
                        <span class="sidebar-widget__list-thumb"><img src="assets/images/thumbs/tc-05.png"
                                alt=""></span>
                        <div class="sidebar-widget__list-content">
                            <a href="javascript:void(0)" class="sidebar-widget__list-link">Belle Hoter</a>
                            <span class="sidebar-widget__list-meta_info"><i class="fli-comments"></i> 24</span>
                        </div>
                    </li>
                    <li class="sidebar-widget__list-item">
                        <span class="sidebar-widget__list-thumb"><img src="assets/images/thumbs/tc-06.png"
                                alt=""></span>
                        <div class="sidebar-widget__list-content">
                            <a href="javascript:void(0)" class="sidebar-widget__list-link">Tomas Whikin</a>
                            <span class="sidebar-widget__list-meta_info"><i class="fli-comments"></i> 32</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>



        <div class="sidebar-widget two">
            <div class="sidebar-widget__header">
                <h5 class="sidebar-widget__title">Hot Topics</h5>
            </div>
            <div class="sidebar-widget__body">
                <ul class="sidebar-widget__list">
                    <li class="sidebar-widget__list-item">
                        <span class="sidebar-widget__list-thumb"><img src="assets/images/thumbs/hc-01.png"
                                alt=""></span>
                        <div class="sidebar-widget__list-content">
                            <a href="javascript:void(0)" class="sidebar-widget__list-link">A meeting or medium where
                                ideas and views...</a>
                            <span class="sidebar-widget__list-meta_info"><i class="fli-calendar2"></i> 27 Dec,
                                2023</span>
                        </div>
                    </li>
                    <li class="sidebar-widget__list-item">
                        <span class="sidebar-widget__list-thumb"><img src="assets/images/thumbs/hc-02.png"
                                alt=""></span>
                        <div class="sidebar-widget__list-content">
                            <a href="javascript:void(0)" class="sidebar-widget__list-link">A meeting or medium where
                                ideas and views...</a>
                            <span class="sidebar-widget__list-meta_info"><i class="fli-calendar2"></i> 27 Dec,
                                2023</span>
                        </div>
                    </li>
                    <li class="sidebar-widget__list-item">
                        <span class="sidebar-widget__list-thumb"><img src="assets/images/thumbs/hc-03.png"
                                alt=""></span>
                        <div class="sidebar-widget__list-content">
                            <a href="javascript:void(0)" class="sidebar-widget__list-link">A meeting or medium where
                                ideas and views...</a>
                            <span class="sidebar-widget__list-meta_info"><i class="fli-calendar2"></i> 27 Dec,
                                2023</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>
