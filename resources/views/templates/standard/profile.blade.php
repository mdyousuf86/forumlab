@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="profile-section">
        <div class="profile-header bg_img" style="background-image: url('{{ asset($activeTemplateTrue . 'images/bg/bg1.jpg') }}');">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="profile-thumb">
                            <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')) }}" alt="@lang('image')">
                        </div>
                        <h3 class="profile-name mt-3 text-white">{{ __($user->fullname) }}</h3>
                        <ul class="profile-info-list d-flex align-items-center justify-content-center mt-1 flex-wrap text-white">
                            <li><i class="las la-flag"></i> {{ __(@$user->address->country) }}</li>
                            <li><i class="las la-user-clock"></i> @lang('Since') {{ showDateTime(@$user->created_at, 'd M, Y') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @include($activeTemplate . 'partials.profile.navbar')

        <div class="profile-details-wrapper">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        @if (request()->routeIs('profile'))
                            @include($activeTemplate . 'partials.profile.about')
                        @endif

                        @if (request()->routeIs('profile.topics') || request()->routeIs('profile.answered') || request()->routeIs('profile.up.vote') || request()->routeIs('profile.down.vote'))
                            @include($activeTemplate . 'partials.topics')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
