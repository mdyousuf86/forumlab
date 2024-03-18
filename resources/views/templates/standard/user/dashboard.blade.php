@extends($activeTemplate . 'layouts.master')
@section('content')

    <div class="row gy-4">
        <div class="col-lg-6 col-sm-6">
            <div class="d-widget">
                <a class="d-widget__btn text--base border--base"  href="{{ route('user.topic.list') }}">
                    <i class="las la-arrow-right"></i>
                </a>
                <div class="d-widget__icon text--base border--base">
                    <i class="las la-list-ul"></i>
                </div>
                <div class="d-widget__content">
                    <h3 class="amount">{{ $widget['total_topic'] }}</h3>
                    <p class="caption">@lang('Total Topic')</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6">
            <div class="d-widget">
                <a class="d-widget__btn text--warning border--warning"  href="{{ route('user.topic.list') }}?status=0">
                    <i class="las la-arrow-right"></i>
                </a>
                <div class="d-widget__icon text--warning border--warning">
                    <i class="las la-spinner"></i>
                </div>
                <div class="d-widget__content">
                    <h3 class="amount">{{ $widget['pending_topic'] }}</h3>
                    <p class="caption">@lang('Pending Topic')</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6">
            <div class="d-widget">
                <a class="d-widget__btn text--success border--success"  href="{{ route('user.topic.list') }}?status=1">
                    <i class="las la-arrow-right"></i>
                </a>
                <div class="d-widget__icon text--success border--success">
                    <i class="las la-check-circle"></i>
                </div>
                <div class="d-widget__content">
                    <h3 class="amount">{{ $widget['approved_topic'] }}</h3>
                    <p class="caption">@lang('Approved Topic')</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6">
            <div class="d-widget">
                <a class="d-widget__btn text--danger border--danger"  href="{{ route('user.topic.list') }}?status=3">
                    <i class="las la-arrow-right"></i>
                </a>
                <div class="d-widget__icon text--danger border--danger">
                    <i class="las la-times"></i>
                </div>
                <div class="d-widget__content">
                    <h3 class="amount">{{ $widget['rejected_topic'] }}</h3>
                    <p class="caption">@lang('Rejected Topic')</p>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h6 class="ms-1 mb-2">@lang('Latest Approved Topics')</h6>
            <div class="custom--card ">
                <div class="card-body p-0">
                    <div class="table-responsive--md">
                        <table class="custom--table table">
                            <thead>
                                <tr>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Subcategory')</th>
                                    <th>@lang('Up - Down Vote')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topics as $topic)
                                    <tr>
                                        <td>
                                            {{ strLimit(__($topic->title), 25) }}
                                        </td>
                                        <td>
                                            {{ __(@$topic->subcategory->name) }}
                                        </td>
                                        <td>
                                            <i class="las la-arrow-up text--success"></i>
                                            {{ $topic->up_vote }}
                                            -
                                            <i class="las la-arrow-down text--danger"></i>
                                            {{ $topic->down_vote }}
                                        </td>
                                        <td>
                                            <div class="d-inline-flex justify-content-end flex-wrap gap-2">
                                                <a class="btn btn-outline--base btn--sm" href="{{ route('user.topic.detail', $topic->id) }}">
                                                    <i class="las la-desktop"></i> @lang('Detail')
                                                </a>
                                                <a class="btn btn-outline--success btn--sm" href="{{ route('user.topic.form', $topic->id) }}">
                                                    <i class="las la-edit"></i> @lang('Edit')
                                                </a>
                                                <button class="btn--sm btn-outline--danger btn confirmationBtn" data-action="{{ route('user.topic.delete', $topic->id) }}" data-question="@lang('Are you sure delete this topic')?">
                                                    <i class="las la-trash-alt"></i> @lang('Delete')
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">
                                            <i class="las la-frown"></i><br>
                                            <span>{{ __($emptyMessage) }}</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal btn="btn btn--base btn--sm" />
@endsection
