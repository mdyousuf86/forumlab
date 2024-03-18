@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="post-details">
        <span class="post-details__badge">{{ __($topic->subcategory->name) }}</span>
        <h3 class="post-details__title">{{ __($topic->title) }}</h3>
        <div class="d-flex justify-content-between flex-wrap">
            <ul class="post-details__tags mt-2">
                @foreach ($topic->tags as $tag)
                    <li>
                        <span>{{ __($tag) }}</span>
                    </li>
                @endforeach
            </ul>
            <ul class="post-details__social d-flex align-items-center mt-2 flex-wrap list list--row flex-wrap social-list">
                <li class="caption">@lang('Share')</li>
                <li><a class="social-list__icon" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"><i class="lab la-facebook-f"></i></a></li>
                <li><a class="social-list__icon" href="https://twitter.com/intent/tweet?text={{ __(@$topic->title) }}%0A{{ url()->current() }}" target="_blank"><i class="lab la-twitter"></i></a></li>
                <li><a class="social-list__icon" href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}&amp;title={{ __(@$topic->title) }}&amp;summary={{ __(@$topic->description) }}" target="_blank"><i class="lab la-linkedin-in"></i></a></li>
            </ul>
        </div>
        <div class="single-post__action-list d-flex align-items-center mt-3 flex-wrap">
            @auth
                <ul class="left">
                    <li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('Up Vote')">
                        <a class="upVote" data-id="{{ $topic->id }}" href="javascript:void(0)">
                            <i class="las la-arrow-up text--success"></i>
                            <span class="up-vote">{{ $topic->up_vote }}</span>
                        </a>
                    </li>
                    <li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('Down Vote')">
                        <a class="downVote" data-id="{{ $topic->id }}" href="javascript:void(0)">
                            <i class="las la-arrow-down text--danger"></i>
                            <span class="down-vote">{{ $topic->down_vote }}</span>
                        </a>
                    </li>
                </ul>
            @endauth
            <ul class="right">
                <li class="d-flex align-items-center">
                    <i class="las la-eye"></i>
                    <span>{{ $topic->view }} @lang('Views')</span>
                </li>
                <li class="d-flex align-items-center">
                    <i class="las la-comments"></i>
                    <span class="commentArea">{{ $topic->comment }} @lang('Comments')</span>
                </li>
            </ul>
        </div>
        <div class="post-author mt-5">
            <div class="post-author__thumb">
                <a href="{{ route('profile', @$topic->user->username) }}">
                    <img src="{{ getImage(getFilePath('userProfile') . '/' . @$topic->user->image, getFileSize('userProfile')) }}" alt="@lang('image')">
                </a>
            </div>
            <div class="post-author__content">
                <h6 class="post-author__name">
                    <a href="{{ route('profile', @$topic->user->username) }}">
                        {{ __($topic->user->username) }}
                    </a>
                </h6>
                <ul class="post-author__meta d-flex align-items-center fs--14px">
                    <li>@lang('Post By') <i class="las la-user"></i>
                        <a href="{{ route('profile', @$topic->user->username) }}">{{ __($topic->user->username) }}</a>
                    </li>
                    <li><i class="las la-clock"></i> {{ $topic->created_at->diffforhumans() }}</li>
                </ul>
                <p class="@if ($topic->image || $topic->video) has-image @endif mt-3">
                    @if ($topic->image || $topic->video)
                        @if ($topic->image)
                            <img src="{{ getImage(getFilePath('topic') . '/' . $topic->image, getFileSize('topic')) }}">
                        @endif
                        @if ($topic->video)
                            <iframe src="{{ $topic->video }}" width="200" allowfullscreen></iframe>
                        @endif
                    @endif
                    @php
                        echo $topic->description;
                    @endphp
                </p>
            </div>
        </div>
    </div>
    <div class="comment-wrapper mt-4">
        @auth
            <div class="comment-wrapper__thumb">
                <img src="{{ getImage(getFilePath('userProfile') . '/' . authUser()->image, getFileSize('userProfile')) }}" alt="@lang('image')">
            </div>
        @endauth
        @auth
            <div class="comment-wrapper__content">
                <form action="{{ route('user.topic.comment', $topic->id) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <textarea class="form--control" name="comment" placeholder="@lang('Write your comment')..." required></textarea>
                    </div>
                    <button class="btn btn--gradient" type="submit">@lang('Submit')</button>
                </form>
            </div>
        @else
            <div class="comment-wrapper__content ps-0 text-center">
                <a class="btn btn--gradient mt-3" href="{{ route('user.login') }}">@lang('Login To Post Your Comment')</a>
            </div>
        @endauth
    </div>

    @if ($topic->comments_count)
        <div class="comment-area mt-5">
            <h3 class="mb-3"><span class="totalComment">{{ $topic->comments_count }}</span> @lang('comments')</h3>

            <div id="commentArea">
                @include($activeTemplate . 'partials.comments')
            </div>

            @if ($topic->comments_count > 5)
                <button class="loadMore btn btn--base mt-4" type="button">
                    @lang('Load More')
                </button>
            @endif
        </div>
    @endif
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            let voteType;
            $('.downVote').on('click', function(e) {
                voteType = 2;
                vote(voteType);
            });

            $('.upVote').on('click', function(e) {
                voteType = 1
                vote(voteType);
            });

            function vote(voteType) {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    type: "POST",
                    url: "{{ route('user.topic.vote', $topic->id) }}",
                    data: {
                        vote_type: voteType
                    },
                    success: function(response) {
                        if (response.status == 'error') {
                            iziToast.error({
                                message: response.message,
                                position: "topRight"
                            });
                        } else {
                            $('.up-vote').text(response.up);
                            $('.down-vote').text(response.down);
                            iziToast.success({
                                message: response.message,
                                position: "topRight"
                            });
                        }
                    }
                });
            }

            let showComment = 5;
            $('.loadMore').on('click', function(e) {
                e.preventDefault();
                $(this).addClass('disabled');
                var url = "{{ route('fetch.comments', $topic->id) }}"
                let data = {}
                data.skipComment = showComment;
                $.ajax({
                    type: "GET",
                    url: url,
                    data: data,
                    success: function(response) {
                        $('.loadMore').removeClass('disabled');
                        if (response.status == 'error') {
                            iziToast.error({
                                message: response.notification,
                                position: "topRight"
                            });
                        } else {
                            $('#commentArea').append(response);
                            console.log(showComment)
                            showComment += 5;
                        }
                    }
                });

            });
        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        .has-image {
            overflow: unset !important;
        }
    </style>
@endpush
