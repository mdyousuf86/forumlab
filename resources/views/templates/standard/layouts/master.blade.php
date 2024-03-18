@extends($activeTemplate . 'layouts.app')
@section('app')
@include($activeTemplate . 'partials.header')
<div class="main-wrapper">
    <div class="pt-100 pb-100 section--bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-3">
                    @include($activeTemplate . 'partials.dashboard_sidebar')
                </div>
                <div class="col-xl-9">
                    <div class="dashboard-toggler-wrapper radius-5 d-xl-none d-inline-block mb-4 text-end">
                        <div class="dashboard-toggler">
                            <i class="las la-align-center"></i>
                        </div>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>
@include($activeTemplate . 'partials.footer')
@endsection

@push('script')
<script>
    (function ($) {
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
