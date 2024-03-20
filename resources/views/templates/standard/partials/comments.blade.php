@foreach ($comments as $comment)
    <div class="comment-list__item">
        <span class="thumb">
            <a href="{{ route('profile', @$comment->user->username) }}">
                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$comment->user->image, getFileSize('userProfile')) }}"
                    alt="@lang('image')">
            </a>
        </span>
        <div class="content">
            <h5 class="name"> <a href="{{ route('profile', @$comment->user->username) }}">
                    {{ __(@$comment->user->fullname) }}
                </a><span class="date">{{ diffForHumans(@$comment->created_at) }}</span></h5>
            <p class="desc">
                {{ __(@$comment->comment) }}
            </p>
        </div>
    </div>
@endforeach
