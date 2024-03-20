@extends($activeTemplate . 'layouts.frontend')
@section('content')

    <div class="forum-post">
        <div class="forum-post__inner">
            <div class="forum-post__author">
                <a class="thumb" href="{{ route('profile', @$topic->user->username) }}">
                    <img src="{{ getImage(getFilePath('userProfile') . '/' . @$topic->user->image, getFileSize('userProfile')) }}"
                        alt="@lang('image')">
                </a>
                <div class="content">
                    <h5 class="content__name">@lang('Posted by')
                        <a class="link"
                            href="{{ route('profile', @$topic->user->username) }}">{{ __($topic->user->username) }}</a>
                    </h5>
                    <span class="content__date"><i
                            class="fli-calendar2"></i>{{ $topic->created_at->diffforhumans() }}</span>
                </div>
            </div>
            <div class="forum-post__content">
                <h5 class="forum-post__title">{{ __($topic->title) }}</h5>
                <p class="forum-post__desc" class="@if ($topic->image || $topic->video) has-image @endif mt-3">
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
        <div class="forum-post__bottom">
            <ul class="list">
                <li class="item">
                    <span class="icon"><i class="fli-comment"></i></span>
                    <span class="text">{{ $topic->comment }} @lang('Comments')</span>
                </li>
                <li class="item">
                    <span class="icon"><i class="fli-eye"></i></span>
                    <span class="text">{{ $topic->view }} @lang('Views')</span>
                </li>
            </ul>
            <ul class="list right">
                <li class="item" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="@lang('Up Vote')">
                    <a class="upVote" data-id="{{ $topic->id }}" href="javascript:void(0)">
                        <span class="icon"><i class="fli-caret-up"></i></span>
                        <span class="up-vote text">{{ $topic->up_vote }}</span>
                    </a>
                </li>
                <li class="item" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="@lang('Down Vote')">
                    <a class="downVote" data-id="{{ $topic->id }}" href="javascript:void(0)">
                        <span class="icon"><i class="fli-caret-down"></i></span>
                        <span class="down-vote text">{{ $topic->down_vote }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="comment-wrapper">
        <div class="post-comment">
            <div class="post-comment__author">
                @auth
                    <span class="thumb">
                        <img src="{{ getImage(getFilePath('userProfile') . '/' . authUser()->image, getFileSize('userProfile')) }}"
                            alt="@lang('image')">
                    </span>
                    <h5 class="name mb-0">{{ authUser()->username }}</h5>
                @endauth
            </div>
            @auth
                <form action="{{ route('user.topic.comment', $topic->id) }}" method="post" class="comment-form">
                    @csrf
                    <div class="form-group mb-0">
                        <textarea class="form--control" name="comment" placeholder="Write An Comment"></textarea>
                        <button type="submit" class="btn btn--base">@lang('Submit Now')</button>
                    </div>
                </form>
            @else
                <div class="">
                    <a class="btn btn--base mt-3" href="{{ route('user.login') }}">@lang('Login To Post Your Comment')</a>
                </div>
            @endauth
        </div>
        @if ($topic->comments_count)
            <div class="comment-list">
                <h4 class="comment-list__title">{{ $topic->comments_count }} @lang('Comment')</h4>
                <div id="commentAreaa">
                    @include($activeTemplate . 'partials.comments')

                </div>
                @if ($topic->comments_count > 2)
                    <button class="loadMore btn btn--base mt-4" type="button">
                        @lang('See More Comments')
                    </button>
                @endif
            </div>
        @endif
    </div>



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
                        console.log(response);
                        $('.loadMore').removeClass('disabled');
                        if (response.status == 'error') {
                            iziToast.error({
                                message: response.notification,
                                position: "topRight"
                            });
                        } else {
                            $('#commentAreaa').append(response);
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
