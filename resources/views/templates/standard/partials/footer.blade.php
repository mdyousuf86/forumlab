@php
    $footer = getContent('footer.content', true);
    $policyPages = getContent('policy_pages.element', orderById: true);
@endphp
<footer class="footer-section">
    <div class="container-fluid px-xl-5">
        <div class="d-flex justify-content-md-between justify-content-center align-items-center flex-wrap gap-3">
            <p>@lang('Copyright') &copy; @php echo date('Y') @endphp @lang('All Right Reserved')</p>
            <a class="footer-logo" href="{{ route('home') }}">
                <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="@lang('logo')">
            </a>
            <ul class="d-inline-flex justify-content-center flex-wrap gap-3">
                @foreach ($policyPages as $policy)
                    <li>
                        <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}" target="_blank">
                            {{ __($policy->data_values->title) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</footer>
