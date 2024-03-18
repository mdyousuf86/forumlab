<aside class="xxxl-2 col-lg-3 d-lg-block d-none">
    <div class="sidebar-widget">
        <div class="sidebar-widget__header">
            <h5 class="sidebar-widget__title">@lang('Forum')</h5>
        </div>
        <div class="sidebar-widget__body">
            <ul class="category-list">

                @forelse ($forums as $forum)
                    <li class="{{ request()->url() === route('forums', [slug($forum->name), $forum->id]) ? 'active' : '' }}">
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
                    <li class="{{ request()->url() === route('category.topic', [slug($category->name), $category->id]) ? 'active' : '' }}">
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

</aside>
