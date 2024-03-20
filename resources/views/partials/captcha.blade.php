@php
    $customCaptcha = loadCustomCaptcha();
    $googleCaptcha = loadReCaptcha();
@endphp
@if ($googleCaptcha)
    <div class="col-md-12">
        <div class="form-group">
            @php echo $googleCaptcha @endphp
        </div>
    </div>
@endif
@if ($customCaptcha)
    <div class="col-md-12">
        <div class="form-group">
            @php echo $customCaptcha @endphp
        </div>
        <div class="form-group">
            <label for="captcha">@lang('Captcha')</label>
            @if (request()->routeIs('admin.login'))
                <input class="form-control" id="captcha" name="captcha" type="text" required>
            @else
                <div class="custom-icon-field">
                    <input class="form--control" id="captcha" name="captcha" type="text" required>
                </div>
            @endif
        </div>
    </div>
@endif
@if ($googleCaptcha)
    @push('script')
        <script>
            (function($) {
                "use strict"
                $('.verify-gcaptcha').on('submit', function() {
                    var response = grecaptcha.getResponse();
                    if (response.length == 0) {
                        document.getElementById('g-recaptcha-error').innerHTML =
                            '<span class="text--danger">@lang('Captcha field is required.')</span>';
                        return false;
                    }
                    return true;
                });
            })(jQuery);
        </script>
    @endpush
@endif
