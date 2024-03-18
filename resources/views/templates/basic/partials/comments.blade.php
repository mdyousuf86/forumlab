@foreach ($comments as $comment)
    <div class="single-comment">
        <div class="single-comment__thumb">
            <a href="{{ route('profile',@$comment->user->username) }}">
                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$comment->user->image, getFileSize('userProfile')) }}" alt="@lang('image')">
            </a>
        </div>
        <div class="single-comment__content">
            <h6>
                <a href="{{ route('profile',@$comment->user->username) }}">
                    {{ __(@$comment->user->fullname) }}
                </a>
            </h6>
            <span class="fs--14px">{{ diffForHumans(@$comment->created_at) }}</span>
        </div>
        <p class="w-100 mt-2">{{ __(@$comment->comment) }}</p>
    </div>
@endforeach
