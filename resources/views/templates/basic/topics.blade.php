@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="row align-items-center mb-4">
        <div class="col-lg-6">
            <h3>{{ __($pageTitle) }}</h3>
        </div>
        <div class="col-lg-6 text-end">
            <a class="btn btn--gradient" href="{{ route('user.topic.form') }}">@lang('Create Topic')</a>
        </div>
    </div>

    @if (request()->routeIs('category.topic'))
        <div class="row mb-4">
            <div class="d-flex flex-wrap gap-3">
                @foreach ($category->subcategories as $subcategory)
                    <a class="subcategory-badge" href="{{ route('subcategory.topics', [slug($subcategory->name), $subcategory->id]) }}">{{ __($subcategory->name) }}</a>
                @endforeach
            </div>
        </div>
    @endif

    @include($activeTemplate . 'partials.topics')
@endsection
