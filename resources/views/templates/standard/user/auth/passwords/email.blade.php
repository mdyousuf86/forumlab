@extends($activeTemplate . 'layouts.app')
@section('app')
    @php
        $authPage = getContent('auth_page.content', true);
    @endphp
    <div class="main-wrapper account-section pt-100 pb-100"
        style="background-image: url({{ getImage('assets/images/frontend/auth_page/' . @$authPage->data_values->image, '1920x1280') }})">
        <div class="container py-120">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-5">
                    <div class="card custom--card">
                        <a class="account-section__close" href="{{ route('home') }}"> <i class="las la-times"></i></a>
                        <div class="card-header ">
                            <h5 class="card-title mb-0">{{ __($pageTitle) }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <p>@lang('To recover your account please provide your email or username to find your account.')</p>
                            </div>
                            <form method="POST" action="{{ route('user.password.email') }}" class="verify-gcaptcha">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">@lang('Email or Username')</label>
                                    <input type="text" class="form-control form--control" name="value"
                                        value="{{ old('value') }}" required autofocus="off">
                                </div>

                                <x-captcha />

                                <div class="form-group">
                                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('style')
    <style>
        .account-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        a.account-section__close {
            position: absolute;
            right: 15px;
            top: 10px;
            color: hsl(var(--body-color));
        }
    </style>
@endpush
