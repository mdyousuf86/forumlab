
@forelse($topics as $topic)
    <div class="forum-post">
        <div class="forum-post__inner">
            <div class="forum-post__author">
                <a class="thumb" href="{{ route('profile', $topic->user->username) }}"><img
                        src="{{ getImage(getFilePath('userProfile') . '/' . @$topic->user->image, getFileSize('userProfile'), true) }}"
                        alt="@lang('image')"></a>
                <div class="content">
                    <h5 class="content__name">@lang('Posted By') <a
                            href="{{ route('profile', $topic->user->username) }}"
                            class=" link">{{ __(@$topic->user->username) }}</a></h5>
                    <span class="content__date"><i
                            class="fli-calendar2"></i>{{ diffForHumans($topic->created_at) }}</span>
                </div>
            </div>
            <div class="forum-post__content">
                <h5 class="forum-post__title">
                    <a
                        href="{{ route('topic.detail', [slug($topic->title), $topic->id]) }}">{{ __($topic->title) }}</a>
                </h5>
                <p class="forum-post__desc @if (@$topic->image || @$topic->video) has-image @endif mt-3">
                    @if (@$topic->image || @$topic->video)
                        @if ($topic->image)
                            <img
                                src="{{ getImage(getFilePath('topic') . '/' . @$topic->image, getFileSize('topic')) }}">
                        @endif
                        @if (@$topic->video)
                            <iframe src="{{ $topic->video }}" width="200" allowfullscreen></iframe>
                        @endif
                    @endif
                    @php
                        echo strLimit(strip_tags($topic->description), 400);
                    @endphp
                </p>
            </div>
        </div>
        <div class="forum-post__bottom">
            <ul class="list">
                <li class="item">
                    <span class="icon"><i class="fli-comment"></i></span>
                    <a class="text" href="{{ route('topic.detail', [slug($topic->title), $topic->id]) }}">
                        {{ $topic->comment }} @lang('Comments')
                    </a>
                </li>
                <li class="item">
                    <span class="icon"><i class="fli-eye"></i></span>
                    <a class="text" href="{{ route('topic.detail', [slug($topic->title), $topic->id]) }}">
                        {{ $topic->view }} @lang('Views')
                    </a>
                </li>
                <li class="item">
                    <span class="icon"><i class="fli-comment"></i></span>
                    <span class="text">@lang('Share')</span>
                </li>
            </ul>
            <ul class="list right">
                <li class="item">
                    <span class="icon"><i class="fli-caret-up"></i></span>
                    <span class="text"> {{ $topic->up_vote }}</span>
                </li>
                <li class="item">
                    <span class="icon"><i class="fli-caret-down"></i></span>
                    <span class="text">{{ $topic->down_vote }}</span>
                </li>
            </ul>
        </div>
    </div>
@empty
    <div class="no-data-wrapper">
        {{ __($emptyMessage) }}
    </div>
@endforelse
