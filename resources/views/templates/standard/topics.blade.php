@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="row align-items-center mb-1">
        <div class="col-lg-6">
            <h4>{{ __($pageTitle) }}</h4>
        </div>

    </div>

    @if (request()->routeIs('category.topic'))
        <div class="row mb-4">
            <div class="d-flex flex-wrap gap-3">
                @foreach ($category->subcategories as $subcategory)
                    <a class="subcategory-badge"
                        href="{{ route('subcategory.topics', [slug($subcategory->name), $subcategory->id]) }}">{{ __($subcategory->name) }}</a>
                @endforeach
            </div>
        </div>
    @endif

    @include($activeTemplate . 'partials.topics')
@endsection
