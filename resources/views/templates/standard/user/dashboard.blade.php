@extends($activeTemplate . 'layouts.master')
@section('content')
    
    <div class="row gy-3 mb-4 justify-content-center dashboard-widget-wrapper">
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="dashboard-widget">
                <span class="dashboard-widget__tag">@lang('Total Topics')</span>
                <h3 class="dashboard-widget__number">{{ $widget['total_topic'] }}</h3>
                <a href="{{ route('user.topic.list') }}" class="dashboard-widget__btn btn btn--base">@lang('View All')</a>
                <div class="dashboard-widget__icon">
                    <i class="fli-file"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="dashboard-widget">
                <span class="dashboard-widget__tag">@lang('Pending Topics')</span>
                <h3 class="dashboard-widget__number">{{ $widget['pending_topic'] }}</h3>
                <a href="{{ route('user.topic.list') }}?status=0"
                    class="dashboard-widget__btn btn btn--base">@lang('View All')</a>
                <div class="dashboard-widget__icon">
                    <i class="fli-prosesing"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="dashboard-widget">
                <span class="dashboard-widget__tag">@lang('Approved Topics')</span>
                <h3 class="dashboard-widget__number">{{ $widget['approved_topic'] }}</h3>
                <a href="{{ route('user.topic.list') }}?status=1"
                    class="dashboard-widget__btn btn btn--base">@lang('View All')</a>
                <div class="dashboard-widget__icon">
                    <i class="fli-file-check"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="dashboard-widget">
                <span class="dashboard-widget__tag">@lang('Rejected Topics')</span>
                <h3 class="dashboard-widget__number">{{ $widget['rejected_topic'] }}</h3>
                <a href="{{ route('user.topic.list') }}?status=3"
                    class="dashboard-widget__btn btn btn--base">@lang('View All')</a>
                <div class="dashboard-widget__icon">
                    <i class="fli-file-cross"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table--responsive--lg">
                <thead>
                    <tr>
                        <th>@lang('TITLE')</th>
                        <th>@lang('SUBTITLE')</th>
                        <th>@lang('UP - DOWN VOTE')</th>
                        <th>@lang('ACTION')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topics as $topic)
                        <tr>
                            <td data-label="TITLE">
                                {{ strLimit(__($topic->title), 25) }}
                            </td>
                            <td data-label="SUBTITLE">
                                {{ __(@$topic->subcategory->name) }}
                            </td>
                            <td data-label="UP - DOWN VOTE">
                                <div class="up-down-vote">
                                    <span class="up-down-vote__item">
                                        <span class="icon"><i class="fli-caret-up"></i></span>
                                        <span class="text">{{ $topic->up_vote }}</span>
                                    </span>
                                    <span class="up-down-vote__item">
                                        <span class="icon"><i class="fli-caret-down"></i></span>
                                        <span class="text">{{ $topic->down_vote }}</span>
                                    </span>
                                </div>
                            </td>
                            <td data-label="ACTION">
                                <div class="d-inline-flex justify-content-end flex-wrap gap-2">
                                    <a class="btn btn-outline--base btn--sm"
                                        href="{{ route('user.topic.detail', $topic->id) }}">
                                        <i class="las la-desktop"></i> @lang('Detail')
                                    </a>
                                    <a class="btn btn-outline--success btn--sm"
                                        href="{{ route('user.topic.form', $topic->id) }}">
                                        <i class="las la-edit"></i> @lang('Edit')
                                    </a>
                                    <button class="btn--sm btn-outline--danger btn confirmationBtn"
                                        data-action="{{ route('user.topic.delete', $topic->id) }}"
                                        data-question="@lang('Are you sure delete this topic')?">
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
    <x-confirmation-modal btn="btn btn--base btn--sm" />
@endsection
