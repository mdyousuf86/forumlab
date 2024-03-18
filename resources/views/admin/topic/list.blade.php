@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Subcategory')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Vote')</th>
                                    <th>@lang('View | Comments')</th>
                                    @if (request()->routeIs('admin.topic.list'))
                                        <th>@lang('Status')</th>
                                    @endif
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topics as $topic)
                                    <tr>
                                        <td>{{ $topics->firstItem() + $loop->index }}</td>
                                        <td>{{ strLimit(__($topic->title), 25) }}</td>
                                        <td>{{ __(@$topic->subcategory->name) }}</td>
                                        <td>
                                            <span class="fw-bold">{{ @$topic->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', @$topic->user->id) }}"><span>@</span>{{ @$topic->user->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            <span>@lang('Up') - {{ $topic->up_vote }}</span>
                                            <br>
                                            <span>@lang('Down') - {{ $topic->down_vote }}</span>
                                        </td>
                                        <td>
                                            <span>@lang('views') - {{ @$topic->view }}</span>
                                            <br>
                                            <span>@lang('Comments') - {{ @$topic->comment }}</span>
                                        </td>
                                        @if (request()->routeIs('admin.topic.list'))
                                            <td>
                                                @php
                                                    echo $topic->statusBadge;
                                                @endphp
                                            </td>
                                        @endif
                                        <td>
                                            <div class="button--group">
                                                <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.topic.detail', $topic->id) }}">
                                                    <i class="las la-desktop"></i> @lang('Details')
                                                </a>
                                                <a class="btn btn-sm btn-outline--info" href="{{ route('admin.topic.comments', $topic->id) }}">
                                                    <i class="las la-comments"></i> @lang('Comments')
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($topics->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($topics) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form />
@endpush
