@php
    $policyPages = getContent('policy_pages.element', orderById: true);
@endphp

<footer class="footer-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="footer-content">
                    <p class="copyright-text">@lang('Copyright') &copy; @php echo date('Y') @endphp @lang('All Right Reserved')</p>
                    <a href="{{ route('home') }}" class="navbar-brand logo">
                        <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="@lang('logo')">
                    </a>
                    <ul class="footer-menu">
                        @foreach ($policyPages as $policy)
                            <li class="footer-menu__item">
                                <a class="footer-menu__link"
                                    href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}"
                                    target="_blank">
                                    {{ __($policy->data_values->title) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
