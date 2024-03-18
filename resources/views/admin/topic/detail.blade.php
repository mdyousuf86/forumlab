@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30 justify-content-center">
        <div class="col-xl-12 mb-30">
            <div class="card b-radius--10 box--shadow1 overflow-hidden">
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Date')
                            <span class="fw-bold">{{ showDateTime($topic->created_at) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Forum')
                            <span class="fw-bold">{{ __(@$topic->subcategory->category->forum->name) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Category')
                            <span class="fw-bold">{{ __(@$topic->subcategory->category->name) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Subcategory')
                            <span class="fw-bold">{{ __(@$topic->subcategory->name) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="fw-bold">
                                <a href="{{ route('admin.users.detail', $topic->user_id) }}">{{ @$topic->user->username }}</a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            <span class="fw-bold">
                                @php
                                    echo $topic->statusBadge;
                                @endphp
                            </span>
                        </li>
                        @if ($topic->video)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Video URL')
                                <a href="{{ $topic->video }}" target="_blank"><i class="lab la-youtube"></i></a>
                            </li>
                        @endif
                        @if ($topic->video)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Image')
                                <a href="{{ route('admin.download.attachment', encrypt(getFilePath('topic') . '/' . $topic->image)) }}">
                                    <i class="las la-image"></i>
                                </a>
                            </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Total Views')
                            <span class="fw-bold"><i class="las la-eye"></i> {{ getAmount($topic->view) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Total Comments')
                            <span class="fw-bold"><i class="las la-comment"></i> {{ getAmount($topic->comment) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Up vote')
                            <span class="fw-bold"><i class="las la-arrow-up"></i> {{ getAmount($topic->up_vote) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Down vote')
                            <span class="fw-bold"><i class="las la-arrow-down"></i> {{ getAmount($topic->down_vote) }}</span>
                        </li>
                    </ul>
                    <div class="mt-4">
                        <h6 class="mb-3">@lang('Description')</h6>
                        <p>@php echo $topic->description @endphp</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@if ($topic->status == Status::TOPIC_PENDING)
    @push('breadcrumb-plugins')
        <button class="btn btn-outline--success btn-sm confirmationBtn" data-action="{{ route('admin.topic.approve', $topic->id) }}" data-question="@lang('Are you sure to approve this topic?')"><i class="las la-check-double"></i>
            @lang('Approve')
        </button>

        <button class="btn btn-outline--danger btn-sm confirmationBtn" data-action="{{ route('admin.topic.reject', $topic->id) }}" data-question="@lang('Are you sure to reject this topic?')"><i class="las la-ban"></i> @lang('Reject')
        </button>
    @endpush
@endif
