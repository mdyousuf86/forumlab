{{-- <h3 class="mb-3">@lang('About')</h3>
@if ($user->about)
    <p>@php echo $user->about; @endphp</p>
@else
    <div class="single-post d-block border-0 text-center">
        {{ __($emptyMessage) }}
    </div>
@endif --}}

<div class="profile-details">
    <div class="profile-details__author">
        <span class="thumb">
            <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')) }}"
                alt="@lang('image')">
        </span>
        <h5 class="name"></h5>
        <ul class="meta-info">
            <li class="meta-info__item">
                <span class="icon"><i class="las la-flag"></i></span>
                <span class="text">{{ __(@$user->address->country) }}</span>
            </li>
            <li class="meta-info__item">
                <span class="icon"><i class="fli-calendar3"></i></span>
                <span class="text">@lang('Since') {{ showDateTime(@$user->created_at, 'd M, Y') }}</span>
            </li>
        </ul>
    </div>
    <div class="profile-details__content">
        <h4 class="title">@lang('About') {{ __($user->fullname) }}</h4>
        @if ($user->about)
            <p class="desc">@php echo $user->about; @endphp</p>
        @endif
    </div>
</div>
