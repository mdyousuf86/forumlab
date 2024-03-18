<h3 class="mb-3">@lang('About')</h3>
@if ($user->about)
    <p>@php echo $user->about; @endphp</p>
@else
    <div class="single-post d-block border-0 text-center">
        {{ __($emptyMessage) }}
    </div>
@endif
