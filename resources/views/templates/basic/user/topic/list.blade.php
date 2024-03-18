@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="row gy-4">
    <div class="col-12 text-end">
        <form>
            <div class="row justify-content-end gy-4">
                <div class="col-lg-3">
                    <div class="input-group">
                        <select name="status" class="form--control select">
                        <option value="" selected >@lang('All')</option>
                        <option value="0" @selected(request()->status=='0')>@lang('Pending')</option>
                        <option value="1" @selected(request()->status==1)>@lang('Approved')</option>
                        <option value="3" @selected(request()->status==3)>@lang('Rejected')</option>
                        </select>
                        <button class="input-group-text bg--base border-0 text-white" type="submit"><i class="la la-search"></i></button>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-group">
                        <input class="form--control" name="search" type="search" value="{{ request()->search }}" placeholder="@lang('Search by forum')">
                        <button class="input-group-text bg--base border-0 text-white" type="submit"><i class="la la-search"></i></button>
                    </div>
                </div>
                <div class="col-lg-3">
                    <a class="btn btn-outline--base w-100 " href="{{ route('user.topic.form') }}">
                        <i class="la la-plus"></i> @lang('Create New')
                    </a>
                </div>
            </div>
        </form>

    </div>
    <div class="col-12">
        <div class="card custom--card">
            <div class="card-body p-0">
                <div class="table-responsive--md">
                    <table class="custom--table table">
                        <thead>
                            <tr>
                                <th>@lang('Title')</th>
                                <th>@lang('Forum')</th>
                                <th>@lang('Up - Down Vote')</th>
                                <th>@lang('Status')</th>
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
                                        @php
                                            echo $topic->statusBadge;
                                        @endphp
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
                                        <i class="las la-frown fs--30px"></i><br>
                                        <span>{{ __($emptyMessage) }}</span>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                    {{ paginateLinks($topics) }}
                </div>
            </div>
        </div>
    </div>
</div>





    <x-confirmation-modal btn="btn btn--base btn--sm" />
@endsection
