
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
                        <p class="text-white">@lang('A 6 digit verification code sent to your mobile number') : +{{ showMobileNumber(auth()->user()->mobile) }}</p>
                      </div>
                    <div class="d-flex justify-content-center">
                        <div class="verification-code-wrapper">
                            <div class="verification-area">
                                <form class="submit-form" action="{{ route('user.verify.mobile') }}" method="POST">
                                    @csrf

                                    @include($activeTemplate . 'partials.verification_code')
                                    <button class="btn btn--gradient w-100" type="submit">@lang('Submit')</button>
                                    <p class="fs--16px mt-3">
                                        @lang('If you don\'t get any code'), <a class="text--base" href="{{ route('user.send.verify.code', 'phone') }}"> @lang('Try again')</a>
                                    </p>
                                    @if ($errors->has('resend'))
                                        <br />
                                        <small class="text--danger">{{ $errors->first('resend') }}</small>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

