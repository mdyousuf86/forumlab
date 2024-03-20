@extends($activeTemplate . 'layouts.app')
@section('app')
    @include($activeTemplate . 'partials.header')
    @php
        $dashboardContent = getContent('dashboard.content', true);
        $user = authUser();
    @endphp

    <section class="contact-section">
        <div class="container">
            @include($activeTemplate . 'partials.dashboard_sidebar')
            @yield('content')
        </div>
    </section>
    @include($activeTemplate . 'partials.footer')
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            Array.from(document.querySelectorAll('table')).forEach(table => {
                let heading = table.querySelectorAll('thead tr th');
                Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                    Array.from(row.querySelectorAll('td')).forEach((column, i) => {
                        (column.colSpan == 100) || column.setAttribute('data-label', heading[i]
                            .innerText)
                    });
                });
            });
        })(jQuery)
    </script>
@endpush
