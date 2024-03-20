@extends($activeTemplate . 'layouts.app')
@section('app')
    @include($activeTemplate . 'partials.header')
    <section class="main-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-xl-none d-block">
                    <span class="aside-responsive-btn"><i class="fas fa-bars"></i></span>
                </div>
                @include($activeTemplate . 'partials.left_side')
                <div class="main-col col-12 px-xxl-4">
                    <div class="forum-wrapper">
                        @yield('content')
                    </div>
                </div>
                @include($activeTemplate . 'partials.right_side')
            </div>
        </div>
    </section>
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
