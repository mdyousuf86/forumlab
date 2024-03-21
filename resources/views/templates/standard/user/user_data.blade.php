@extends($activeTemplate . 'layouts.app')
@section('app')
@php
$authPage = getContent('auth_page.content', true);
@endphp
<section class="pt-100 pb-100 account-section main-wrapper"
    style="background-image: url({{ getImage('assets/images/frontend/auth_page/' . @$authPage->data_values->image, '1920x1280') }})">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7 col-xl-7">
                <div class="card custom--card">
                    <div class="card-header">
                        <div class="text-center">
                            <h3 class="text--dark">@lang('Complete your profile')</h3>
                            <p class="text--dark">@lang('You need to complete your profile by providing below information.')</p>
                        </div>
                    </div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.data.submit') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="form-label">@lang('First Name')</label>
                                    <input type="text" class="form-control form--control" name="firstname" value="{{ old('firstname') }}" required>
                                </div>
    
                                <div class="form-group col-sm-6">
                                    <label class="form-label">@lang('Last Name')</label>
                                    <input type="text" class="form-control form--control" name="lastname" value="{{ old('lastname') }}" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">@lang('Address')</label>
                                    <input type="text" class="form-control form--control" name="address" value="{{ old('address') }}">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">@lang('State')</label>
                                    <input type="text" class="form-control form--control" name="state" value="{{ old('state') }}">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">@lang('Zip Code')</label>
                                    <input type="text" class="form-control form--control" name="zip" value="{{ old('zip') }}">
                                </div>
    
                                <div class="form-group col-sm-6">
                                    <label class="form-label">@lang('City')</label>
                                    <input type="text" class="form-control form--control" name="city" value="{{ old('city') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn--base w-100">
                                    @lang('Submit')
                                </button>
                            </div>
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