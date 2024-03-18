@extends($activeTemplate . 'layouts.app')
@section('app')
@include($activeTemplate . 'partials.header')
<div class="main-wrapper">
    <section class="pt-50 pb-50 px-xxl-5">
        <div class="container-fluid">
            <div class="row">
                @include($activeTemplate . 'partials.left_side')
                <main class="xxxl-8 col-lg-6 px-lg-4">
                    @yield('content')
                </main>
                @include($activeTemplate . 'partials.right_side')
            </div>
        </div>
    </section>
</div>
@include($activeTemplate . 'partials.footer')
@endsection


@push('script')
    <script>
        (function($) {
            "use strict";
            $('.ajaxCount').on('click', function() {
                var id = $(this).data('id');
                $.get("{{ route('ad.count.ajax') }}", {
                    id: id
                }, function(response) {});
            });
        })(jQuery)
    </script>
@endpush
