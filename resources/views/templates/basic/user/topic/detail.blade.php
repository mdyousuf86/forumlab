@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-header justify-content-between d-flex align-items-center flex-wrap gap-3">
            <h5>{{ __($pageTitle) }}</h5>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    @lang('Date')
                    <span>{{ showDateTime($topic->created_at) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    @lang('Forum')
                    <span>{{ __(@$topic->subcategory->category->forum->name) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    @lang('Category')
                    <span>{{ __(@$topic->subcategory->category->name) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    @lang('Subcategory')
                    <span>{{ __(@$topic->subcategory->name) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    @lang('Status')
                    <span>
                        @php
                            echo $topic->statusBadge;
                        @endphp
                    </span>
                </li>
                @if ($topic->video)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        @lang('Video URL')
                        <a href="{{ $topic->video }}" target="_blank"><i class="lab la-youtube"></i></a>
                    </li>
                @endif
                @if ($topic->video)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        @lang('Image')
                        <a href="{{ route('admin.download.attachment', encrypt(getFilePath('topic') . '/' . $topic->image)) }}">
                            <i class="las la-image"></i>
                        </a>
                    </li>
                @endif
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    @lang('Total Views')
                    <span><i class="las la-eye"></i> {{ getAmount($topic->view) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    @lang('Total Comments')
                    <span><i class="las la-comment"></i> {{ getAmount($topic->comment) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    @lang('Up vote')
                    <span><i class="las la-arrow-up"></i> {{ getAmount($topic->up_vote) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    @lang('Down vote')
                    <span><i class="las la-arrow-down"></i> {{ getAmount($topic->down_vote) }}</span>
                </li>
            </ul>
            <div class="mt-4">
                <h6 class="mb-3">@lang('Description')</h6>
                <p>@php echo $topic->description @endphp</p>
            </div>
        </div>
    </div>
@endsection
