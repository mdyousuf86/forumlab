@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-header">
            <h5 class="card-title">@lang('Change Password')</h5>
        </div>
        <div class="card-body">
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <label>@lang('Current Password')</label>
                    <input class="form--control" name="current_password" type="password" required autocomplete="current-password">
                </div>
                <div class="form-group">
                    <label>@lang('Password')</label>
                    <input class="form--control" name="password" type="password" required autocomplete="current-password">
                    @if ($general->secure_password)
                        <div class="input-popup">
                            <p class="error lower">@lang('1 small letter minimum')</p>
                            <p class="error capital">@lang('1 capital letter minimum')</p>
                            <p class="error number">@lang('1 number minimum')</p>
                            <p class="error special">@lang('1 special character minimum')</p>
                            <p class="error minimum">@lang('6 character password')</p>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label>@lang('Confirm Password')</label>
                    <input class="form--control" name="password_confirmation" type="password" required autocomplete="current-password">
                </div>
                <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
            </form>
        </div>
    </div>
@endsection
@if ($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
