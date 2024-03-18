@forelse ($forums as $forum)
    <div class="forum-block">
        <div class="forum-block__header">
            <h4 class="forum-block__title">{{ __($forum->name) }}</h4>
        </div>
        <div class="forum-block__body">
            @foreach ($forum->categories->take(5) as $category)
                <div class="single-thread">
                    <div class="single-thread__left">
                        <h5 class="single-thread__title">
                            <a href="{{ route('category.topic', [slug($category->name), $category->id]) }}">
                                {{ __($category->name) }}
                            </a>
                        </h5>
                        <p class="mt-2">{{ __($category->description) }}</p>
                        <div class="d-flex fs--12px mt-2 flex-wrap">
                            <strong>@lang('Sub Forum'): </strong> &nbsp;
                            <ul class="sub-forum-list d-flex align-items-center flex-wrap">
                                <li>
                                    @foreach ($category->subcategories->take(6) as $subcategory)
                                        <a href="{{ route('subcategory.topics', [slug($subcategory->name), $subcategory->id]) }}">{{ $subcategory->name }}</a>
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </li>
                            </ul>
                        </div>
                    </div>
                    @php
                        $comment = $category
                            ->topics()
                            ->withWhereHas('latestComment')
                            ->first();
                    @endphp
                    <div class="single-thread__right">
                        <div class="top">
                            <ul class="top__list">
                                <li>
                                    <span class="fs--14px">@lang('Topics')</span>
                                    <h3>{{ $category->topics->count() }}</h3>
                                </li>
                                <li class="d-flex align-items-center flex-wrap">
                                    <span class="w-100 fs--14px">@lang('Users')</span>
                                    <ul class="top__list-user me-2">
                                        @foreach ($category->topics->take(5) as $topic)
                                            <li>
                                                <a href="{{ route('profile', @$topic->user->username) }}">
                                                    <img src="{{ getImage(getFilePath('userProfile') . '/' . @$topic->user->image, getFileSize('userProfile'), true) }}" alt="@lang('image')">
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <strong class="fs--14px">
                                        @if ($category->topics->count() > 5)
                                            5+
                                        @else
                                            {{ $category->topics->count() }}
                                        @endif
                                    </strong>
                                </li>
                                <li>
                                    <span class="fs--14px">@lang('Activities')</span>
                                    <h6 class="fs--14px">
                                        @if (@$comment->latestComment->created_at)
                                            {{ diffForHumans(@$comment->latestComment->created_at) }}
                                        @else
                                            @lang('No activities yet')
                                        @endif
                                    </h6>
                                </li>
                            </ul>
                        </div>
                        <div class="bottom">
                            <span class="fs--14px mb-2">@lang('Latest Topic')</span>
                            <div class="latest-topic">
                                <div class="latest-topic__thumb">
                                    <a href="{{ route('profile', @$topic->user->username) }}">
                                        <img src="{{ getImage(getFilePath('userProfile') . '/' . @$category->topics[0]->user->image, getFileSize('userProfile'), true) }}" alt="@lang('image')">
                                    </a>

                                </div>
                                <div class="latest-topic__content">
                                    <h6 class="latest-topic__title">
                                        {{ __($category->topics[0]['title']) }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@empty

    <div class="single-post d-block border-0 text-center">
        {{ __($emptyMessage) }}
    </div>
@endforelse
