@extends($activeTemplate . 'layouts.app')
@section('app')
@php
$authPage = getContent('auth_page.content', true);
@endphp
<div class="main-wrapper account-section pt-100 pb-100"
    style="background-image: url({{ getImage('assets/images/frontend/auth_page/' . @$authPage->data_values->image, '1920x1280') }})">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="account-wrapper">
                    <div class="account-thumb text-center" style="background-image: url('{{ getImage('assets/images/frontend/auth_page/' . $authPage->data_values->image, '1920x1280') }}');">
                        <h3 class="text-white">{{ __($pageTitle) }}</h3>
                        <p class="fs--16px text-white">@lang('A 6 digit verification code sent to your email address') : {{ showEmailAddress($email) }}</p>
                    </div>
                    <div class="account-content">
                        <div class="d-flex justify-content-center">
                            <div class="verification-code-wrapper ">
                                <div class="verification-area account-content">
                                    <form class="submit-form" action="{{ route('user.password.verify.code') }}" method="POST">
                                        @csrf
                                        <input name="email" type="hidden" value="{{ $email }}">
                                        @include($activeTemplate . 'partials.verification_code')

                                        <button class="btn btn--gradient w-100" type="submit">@lang('Submit')</button>
                                        <p class="fs--16px mt-3">@lang('Please check including your Junk/Spam Folder. if not found, you can')
                                            <a class="text--base" href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
@push('style')
    <style>
        .account-thumb{
            padding: 2rem !important;
        }
        .account-content{
            padding: 0 !important;
        }
    </style>
@endpush
