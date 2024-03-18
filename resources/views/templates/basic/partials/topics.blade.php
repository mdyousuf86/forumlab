@forelse($topics as $topic)
    <div class="single-post">
        <span class="forum-badge">
            {{ __(@$topic->subcategory->name) }}
        </span>
        <div class="single-post__thumb">
            <a href="{{ route('profile', $topic->user->username) }}">
                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$topic->user->image, getFileSize('userProfile'), true) }}" alt="@lang('image')">
            </a>
        </div>
        <div class="single-post__content">
            <h3 class="single-post__title">
                <a href="{{ route('topic.detail', [slug($topic->title), $topic->id]) }}">
                    {{ __($topic->title) }}
                </a>
            </h3>
            <ul class="single-post__meta d-flex align-items-center mt-1">
                <li>
                    @lang('Post By')
                    <i class="las la-user"></i>
                    <a href="{{ route('profile', $topic->user->username) }}">
                        {{ __(@$topic->user->username) }}
                    </a>
                </li>
                <li><i class="las la-clock"></i> {{ diffForHumans($topic->created_at) }}</li>
            </ul>
        </div>
        <div class="single-post__footer">
            <p class="@if (@$topic->image || @$topic->video) has-image @endif mt-3">
                @if (@$topic->image || @$topic->video)
                    @if ($topic->image)
                        <img src="{{ getImage(getFilePath('topic') . '/' . @$topic->image, getFileSize('topic')) }}">
                    @endif
                    @if (@$topic->video)
                        <iframe src="{{ $topic->video }}" width="200" allowfullscreen></iframe>
                    @endif
                @endif
                @php
                    echo strLimit(strip_tags($topic->description), 400);
                @endphp
            </p>

            <div class="single-post__action-list d-flex align-items-center mt-3 flex-wrap gap-3">
                <ul class="left">
                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Up Vote')">
                        <i class="las la-arrow-up text--success"></i>
                        {{ $topic->up_vote }}
                    </li>
                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Down Vote')">
                        <i class="las la-arrow-down"></i>
                        {{ $topic->down_vote }}
                    </li>
                </ul>
                <ul class="right">
                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Total Views')">
                        <a href="{{ route('topic.detail', [slug($topic->title), $topic->id]) }}">
                            <i class="las la-eye"></i>
                            {{ $topic->view }} @lang('Views')
                        </a>
                    </li>
                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Total Comments')">
                        <a href="{{ route('topic.detail', [slug($topic->title), $topic->id]) }}">
                            <i class="las la-comments"></i>
                            {{ $topic->comment }} @lang('Comments')
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@empty
    <div class="no-data-wrapper">
       {{ __($emptyMessage) }}
    </div>
@endforelse

<div class="mt-5">
    <ul class="pagination pagination-md justify-content-end">
        {{ paginateLinks($topics) }}
    </ul>
</div>
