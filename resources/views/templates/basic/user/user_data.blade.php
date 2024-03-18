@extends($activeTemplate . 'layouts.app')
@section('app')
@php
$authPage = getContent('auth_page.content', true);
@endphp
<section class="pt-100 pb-100 account-section main-wrapper"
    style="background-image: url({{ getImage('assets/images/frontend/auth_page/' . @$authPage->data_values->image, '1920x1280') }})">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="account-wrapper">
                    <div class="account-thumb text-center text-white" style="background-image: url('{{ getImage('assets/images/frontend/auth_page/' . $authPage->data_values->image, '1920x1280') }}');">
                        <h3 class="text-white">@lang('Complete your profile')</h3>
                        <p class="text-white">@lang('You need to complete your profile by providing below information.')</p>
                    </div>
                    <div class="account-content">
                        <form method="POST" action="{{ route('user.data.submit') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('First Name')</label>
                                        <input class="form--control" name="firstname" type="text" value="{{ old('firstname') }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('Last Name')</label>
                                        <input class="form--control" name="lastname" type="text" value="{{ old('lastname') }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('Address')</label>
                                        <input class="form--control" name="address" type="text" value="{{ old('address') }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('State')</label>
                                        <input class="form--control" name="state" type="text" value="{{ old('state') }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('Zip Code')</label>
                                        <input class="form--control" name="zip" type="text" value="{{ old('zip') }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('City')</label>
                                        <input class="form--control" name="city" type="text" value="{{ old('city') }}">
                                    </div>
                                </div>

                            </div>
                            <button class="btn btn--gradient w-100" type="submit">
                                @lang('Submit')
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection

@push('auth-content')
    <h2 class="text-white">{{ __($pageTitle) }}</h2>
@endpush
